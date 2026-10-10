<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display student's re-registration payment page.
     */
    public function studentIndex()
    {
        $student = auth()->user()->student;
        if (!$student) {
            return redirect()->route('siswa.dashboard')->with('error', 'Silakan lengkapi biodata pendaftaran terlebih dahulu.');
        }

        if ($student->status !== 'lulus_pendaftaran' && $student->status !== 'menunggu_daftar_ulang' && $student->status !== 'revisi_daftar_ulang' && $student->status !== 'aktif') {
            return redirect()->route('siswa.dashboard')->with('error', 'Halaman pembayaran hanya untuk siswa yang telah lulus pendaftaran tahap 1.');
        }

        $payments = $student->payments()->latest()->get();
        $settings = Setting::pluck('value', 'key');
        
        $paymentItems = PaymentItem::where('is_active', true)
            ->whereIn('jalur', ['Semua', $student->jalur_pendaftaran])
            ->get();
        $totalAmount = $paymentItems->sum('amount');
        $totalPaid = $student->payments()->where('status', 'lunas')->sum('jumlah_bayar');
        $remainingAmount = max(0, $totalAmount - $totalPaid);
        $hasPending = $student->payments()->where('status', 'menunggu')->exists();

        // Midtrans client key for Snap.js
        $midtransClientKey = config('midtrans.client_key');
        $midtransIsProduction = config('midtrans.is_production');
        
        // Find pending midtrans payment with snap_token
        $pendingMidtrans = $student->payments()
            ->where('status', 'menunggu')
            ->where('metode_pembayaran', 'midtrans')
            ->whereNotNull('snap_token')
            ->latest()
            ->first();

        return view('student.payments.index', compact(
            'student', 'payments', 'settings', 'paymentItems', 
            'totalAmount', 'totalPaid', 'remainingAmount', 'hasPending',
            'midtransClientKey', 'midtransIsProduction', 'pendingMidtrans'
        ));
    }

    /**
     * Store or update student's payment proof.
     */
    public function studentStore(Request $request)
    {
        $student = auth()->user()->student;
        if (!$student || $student->status !== 'diterima') {
            return redirect()->route('siswa.dashboard')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'metode_pembayaran' => 'required|in:transfer,qris,tunai,midtrans',
            'jumlah_bayar' => 'required|numeric|min:0',
            'tanggal_bayar' => 'required_unless:metode_pembayaran,midtrans|date',
            'bukti_transfer' => 'required_unless:metode_pembayaran,midtrans|image|mimes:jpeg,png,jpg,pdf|max:5120',
            'bank_asal' => 'required_if:metode_pembayaran,transfer|nullable|string|max:50',
            'nama_rekening' => 'required_if:metode_pembayaran,transfer|nullable|string|max:100',
        ], [
            'bukti_transfer.required_unless' => 'Bukti pembayaran wajib diunggah untuk metode manual.',
            'bank_asal.required_if' => 'Nama Bank Pengirim wajib diisi untuk metode transfer bank.',
            'nama_rekening.required_if' => 'Nama Pemilik Rekening Pengirim wajib diisi untuk metode transfer bank.',
        ]);

        if ($request->metode_pembayaran === 'midtrans') {
            // Configure midtrans
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
            \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

            $orderId = 'PPDB-' . $student->id . '-' . time();
            
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $request->jumlah_bayar,
                ],
                'customer_details' => [
                    'first_name' => $student->nama_lengkap,
                    'email' => auth()->user()->email,
                    'phone' => $student->no_hp ?? '081111111111',
                ],
            ];

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal menghubungi server Midtrans: ' . $e->getMessage());
            }

            $paymentData = [
                'metode_pembayaran' => 'midtrans',
                'jumlah_bayar' => $request->jumlah_bayar,
                'tanggal_bayar' => now()->toDateString(),
                'bank_asal' => 'Midtrans Payment Gateway',
                'nama_rekening' => $student->nama_lengkap,
                'bukti_transfer' => null,
                'status' => 'menunggu',
                'snap_token' => $snapToken,
                'midtrans_order_id' => $orderId,
                'catatan' => 'Menunggu pembayaran otomatis via Midtrans.',
            ];

            $student->payments()->create($paymentData);

            return redirect()->route('siswa.payments.index')->with('success', 'Tagihan Midtrans berhasil dibuat. Silakan klik "Bayar Sekarang" di bawah ini.');
        }

        // File upload handling for manual payments
        $filePath = null;
        if ($request->hasFile('bukti_transfer')) {
            $filePath = $request->file('bukti_transfer')->store('berkas/pembayaran', 'public');
        }

        $paymentData = [
            'metode_pembayaran' => $request->metode_pembayaran,
            'jumlah_bayar' => $request->jumlah_bayar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'bank_asal' => $request->metode_pembayaran === 'transfer' ? $request->bank_asal : null,
            'nama_rekening' => $request->metode_pembayaran === 'transfer' ? $request->nama_rekening : null,
            'bukti_transfer' => $filePath,
            'status' => 'menunggu', 
            'catatan' => null, 
        ];

        $student->payments()->create($paymentData);

        return redirect()->route('siswa.payments.index')->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi dari panitia.');
    }

    /**
     * Instant Payment Simulation for Demo/Sandbox testing.
     */
    public function studentSimulate(Request $request)
    {
        $student = auth()->user()->student;
        if (!$student || $student->status !== 'diterima') {
            return redirect()->route('siswa.dashboard')->with('error', 'Akses ditolak.');
        }

        $settings = Setting::pluck('value', 'key');
        $amount = PaymentItem::where('is_active', true)
            ->whereIn('jalur', ['Semua', $student->jalur_pendaftaran])
            ->sum('amount');

        $paymentData = [
            'metode_pembayaran' => $request->metode_pembayaran ?? 'transfer',
            'jumlah_bayar' => $amount,
            'tanggal_bayar' => now()->toDateString(),
            'bank_asal' => $request->metode_pembayaran === 'qris' ? 'QRIS E-Wallet' : ($request->metode_pembayaran === 'tunai' ? 'Tunai Loket' : 'BSI SIMULATOR'),
            'nama_rekening' => 'PENDAFTAR SIMULASI (AUTO)',
            'bukti_transfer' => 'berkas/pembayaran/simulator_mock.png', // Simulated mock proof
            'status' => 'lunas', // Directly marked as PAID
            'catatan' => 'Diverifikasi instan secara otomatis melalui Simulator Pembayaran.',
            'verified_at' => now(),
            'verified_by' => \App\Models\User::where('role', 'bendahara')->first()?->id ?? \App\Models\User::where('role', 'admin')->first()?->id,
        ];

        $student->payments()->create($paymentData);

        return redirect()->route('siswa.payments.index')->with('success', '🎉 SIMULASI BERHASIL! Pembayaran sebesar Rp ' . number_format($amount, 0, ',', '.') . ' telah lunas diverifikasi otomatis oleh Simulator Gateway.');
    }

    /**
     * Display standalone BSI VA DOKU Simulator page.
     */
    public function bsiSimulatorPage(Request $request)
    {
        // Find the student matching this Virtual Account number or current logged in student
        $student = null;
        if (auth()->check() && auth()->user()->role === 'siswa') {
            $student = auth()->user()->student;
        }

        $settings = Setting::pluck('value', 'key');
        $defaultVa = $settings['payment_rekening'] ?? '7149028882';
        
        $defaultAmount = 0;
        if ($student) {
            $defaultAmount = PaymentItem::where('is_active', true)
                ->whereIn('jalur', ['Semua', $student->jalur_pendaftaran])
                ->sum('amount');
        } else {
            $defaultAmount = PaymentItem::where('is_active', true)->sum('amount');
        }
        
        $va = $request->get('va', $defaultVa);
        $amount = $request->get('amount', $defaultAmount);

        return view('simulator.bsi', compact('va', 'amount', 'student'));
    }

    /**
     * Process standalone BSI VA payment simulation.
     */
    public function bsiSimulatorProcess(Request $request)
    {
        $request->validate([
            'va_number' => 'required',
            'amount' => 'required|numeric'
        ]);

        $settings = Setting::pluck('value', 'key');
        $officialVa = $settings['payment_rekening'] ?? '7149028882';

        // Find student
        $student = null;
        if (auth()->check() && auth()->user()->role === 'siswa') {
            $student = auth()->user()->student;
        } else {
            // Find by matching nomor pendaftaran or the first student who is accepted and not paid
            $student = \App\Models\Student::whereIn('status', ['lulus_pendaftaran', 'menunggu_daftar_ulang', 'revisi_daftar_ulang', 'aktif'])->first();
        }

        if (!$student) {
            return response()->json(['success' => false, 'message' => 'No eligible student found.']);
        }

        // Set status to lunas
        $paymentData = [
            'metode_pembayaran' => 'transfer',
            'jumlah_bayar' => $request->amount,
            'tanggal_bayar' => now()->toDateString(),
            'bank_asal' => 'BSI DOKU SIMULATOR',
            'nama_rekening' => strtoupper($student->nama_lengkap),
            'bukti_transfer' => 'berkas/pembayaran/simulator_doku.png',
            'status' => 'lunas',
            'catatan' => 'Diverifikasi instan otomatis dari Web Gateway Simulator DOKU (BSI VA).',
            'verified_at' => now(),
            'verified_by' => \App\Models\User::where('role', 'bendahara')->first()?->id ?? \App\Models\User::where('role', 'admin')->first()?->id,
        ];

        $student->payments()->create($paymentData);

        return response()->json(['success' => true]);
    }

    /**
     * Display standalone QRIS Simulator page.
     */
    public function qrisSimulatorPage(Request $request)
    {
        $student = null;
        if (auth()->check() && auth()->user()->role === 'siswa') {
            $student = auth()->user()->student;
        }

        $settings = Setting::pluck('value', 'key');
        
        $defaultAmount = 0;
        if ($student) {
            $defaultAmount = PaymentItem::where('is_active', true)
                ->whereIn('jalur', ['Semua', $student->jalur_pendaftaran])
                ->sum('amount');
        } else {
            $defaultAmount = PaymentItem::where('is_active', true)->sum('amount');
        }
        
        $amount = $request->get('amount', $defaultAmount);

        return view('simulator.qris', compact('amount', 'student'));
    }

    /**
     * Process standalone QRIS payment simulation.
     */
    public function qrisSimulatorProcess(Request $request)
    {
        $student = null;
        if (auth()->check() && auth()->user()->role === 'siswa') {
            $student = auth()->user()->student;
        } else {
            $student = \App\Models\Student::whereIn('status', ['lulus_pendaftaran', 'menunggu_daftar_ulang', 'revisi_daftar_ulang', 'aktif'])->first();
        }

        if (!$student) {
            return response()->json(['success' => false, 'message' => 'No eligible student found.']);
        }

        $settings = Setting::pluck('value', 'key');
        $amount = PaymentItem::where('is_active', true)
            ->whereIn('jalur', ['Semua', $student->jalur_pendaftaran])
            ->sum('amount');

        $paymentData = [
            'metode_pembayaran' => 'qris',
            'jumlah_bayar' => $amount,
            'tanggal_bayar' => now()->toDateString(),
            'bank_asal' => 'QRIS GATEWAY SIMULATOR',
            'nama_rekening' => strtoupper($student->nama_lengkap),
            'bukti_transfer' => 'berkas/pembayaran/simulator_qris.png',
            'status' => 'lunas',
            'catatan' => 'Diverifikasi instan otomatis dari Web Gateway Simulator QRIS.',
            'verified_at' => now(),
            'verified_by' => \App\Models\User::where('role', 'bendahara')->first()?->id ?? \App\Models\User::where('role', 'admin')->first()?->id,
        ];

        $student->payments()->create($paymentData);

        return response()->json(['success' => true]);
    }

    /**
     * Show official receipt.
     */
    public function studentReceipt(\Illuminate\Http\Request $request)
    {
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'bendahara') {
            $student = \App\Models\Student::findOrFail($request->student_id);
        } else {
            $student = auth()->user()->student;
        }
        $payments = $student->payments()->where('status', 'lunas')->get();
        if ($payments->isEmpty()) {
            return redirect()->route('siswa.dashboard')->with('error', 'Kuitansi belum tersedia.');
        }

        $settings = Setting::pluck('value', 'key');
        
        $paymentItems = PaymentItem::where('is_active', true)
            ->whereIn('jalur', ['Semua', $student->jalur_pendaftaran])
            ->get();
        $totalAmount = $paymentItems->sum('amount');
        $totalPaid = $payments->sum('jumlah_bayar');
        $payment = $payments->last();

        return view('student.payments.receipt', compact('student', 'payments', 'payment', 'settings', 'paymentItems', 'totalAmount', 'totalPaid'));
    }

    /**
     * Admin Dashboard for Payments.
     */
    public function adminIndex(Request $request)
    {
        // Stats
        $totalAccepted = Student::where('status', 'aktif')->count();
        $totalPaid = Payment::where('status', 'lunas')->count();
        $totalPending = Payment::where('status', 'menunggu')->count();
        $totalNotPaid = Student::where('status', 'aktif')->whereDoesntHave('payments')->count();
        $totalFunds = Payment::where('status', 'lunas')->sum('jumlah_bayar');

        // Query Payments
        $query = Payment::with(['student.user', 'verifiedBy']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nomor_pendaftaran', 'like', '%' . $request->search . '%');
            });
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        return view('admin.payments.index', compact(
            'payments',
            'totalAccepted',
            'totalPaid',
            'totalPending',
            'totalNotPaid',
            'totalFunds'
        ));
    }

    /**
     * Verify payment status by admin.
     */
    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:lunas,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $payment->update([
            'status' => $request->status,
            'catatan' => $request->status === 'ditolak' ? $request->catatan : null,
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        // Send payment verified email
        try {
            \Illuminate\Support\Facades\Mail::to($payment->student->user->email)
                ->send(new \App\Mail\PaymentVerified($payment));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim email verifikasi pembayaran: ' . $e->getMessage());
        }

        return back()->with('success', 'Status verifikasi pembayaran berhasil disimpan.');
    }

    /**
     * Handle Midtrans Webhook Notification
     */
    public function midtransWebhook(Request $request)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        try {
            $notification = new \Midtrans\Notification();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid notification: ' . $e->getMessage()], 400);
        }

        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraud = $notification->fraud_status;

        $payment = Payment::where('midtrans_order_id', $orderId)->first();
        if (!$payment) {
            return response()->json(['message' => 'Order ID not found'], 404);
        }

        $methodName = $this->parsePaymentMethod($notification);

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $payment->update(['status' => 'menunggu', 'catatan' => 'Challenge by FDS']);
                } else {
                    $this->markAsLunas($payment, 'Pembayaran diverifikasi otomatis oleh Midtrans (Credit Card)', $methodName);
                }
            }
        } elseif ($transaction == 'settlement') {
            $this->markAsLunas($payment, 'Pembayaran diverifikasi otomatis oleh Midtrans Webhook', $methodName);
        } elseif ($transaction == 'pending') {
            $payment->update(['status' => 'menunggu', 'catatan' => 'Menunggu pembayaran via Midtrans.']);
        } elseif ($transaction == 'deny') {
            $payment->update(['status' => 'ditolak', 'catatan' => 'Pembayaran ditolak oleh Midtrans.']);
        } elseif ($transaction == 'expire') {
            $payment->update(['status' => 'ditolak', 'catatan' => 'Waktu pembayaran Midtrans kedaluwarsa.']);
        } elseif ($transaction == 'cancel') {
            $payment->update(['status' => 'ditolak', 'catatan' => 'Pembayaran dibatalkan.']);
        }

        return response()->json(['message' => 'Notification processed successfully']);
    }

    private function parsePaymentMethod($status)
    {
        $type = $status->payment_type ?? 'midtrans';
        
        if ($type === 'bank_transfer') {
            $bank = isset($status->va_numbers[0]->bank) ? strtoupper($status->va_numbers[0]->bank) : 'VA';
            return 'Midtrans - ' . $bank . ' Virtual Account';
        } elseif ($type === 'echannel') {
            return 'Midtrans - Mandiri Bill Payment';
        } elseif ($type === 'gopay') {
            return 'Midtrans - GoPay';
        } elseif ($type === 'qris') {
            return 'Midtrans - QRIS';
        } elseif ($type === 'cstore') {
            $store = isset($status->store) ? ucfirst($status->store) : 'Minimarket';
            return 'Midtrans - ' . $store;
        } elseif ($type === 'credit_card') {
            return 'Midtrans - Kartu Kredit';
        }
        
        return 'Midtrans - ' . strtoupper(str_replace('_', ' ', $type));
    }

    private function markAsLunas(Payment $payment, $note, $methodName = null)
    {
        if ($payment->status === 'lunas') return;
        
        $updateData = [
            'status' => 'lunas',
            'catatan' => $note,
            'verified_at' => now(),
            // Set verified_by to admin or null if auto
            'verified_by' => \App\Models\User::where('role', 'admin')->first()?->id
        ];

        if ($methodName) {
            $updateData['metode_pembayaran'] = $methodName;
        }
        
        $payment->update($updateData);

        try {
            \Illuminate\Support\Facades\Mail::to($payment->student->user->email)
                ->send(new \App\Mail\PaymentVerified($payment));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim email notifikasi Midtrans: ' . $e->getMessage());
        }
    }

    /**
     * Sync Midtrans status manually via Frontend (Useful for Localhost Dev)
     */
    public function midtransSync(Request $request)
    {
        $orderId = $request->order_id;
        $payment = Payment::where('midtrans_order_id', $orderId)->first();
        
        if ($payment && $payment->status === 'menunggu') {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            
            try {
                $status = \Midtrans\Transaction::status($orderId);
                
                if (in_array($status->transaction_status, ['capture', 'settlement'])) {
                    $methodName = $this->parsePaymentMethod($status);
                    $this->markAsLunas($payment, 'Pembayaran diverifikasi otomatis via Frontend Sync (Midtrans)', $methodName);
                    return response()->json(['success' => true, 'status' => 'lunas', 'message' => 'Status berhasil disinkronisasi (Lunas).']);
                } elseif (in_array($status->transaction_status, ['deny', 'expire', 'cancel'])) {
                    $payment->update([
                        'status' => 'ditolak',
                        'catatan' => 'Pembayaran ditolak/batal via Frontend Sync: ' . $status->transaction_status
                    ]);
                    return response()->json(['success' => true, 'status' => 'ditolak', 'message' => 'Status berhasil disinkronisasi (Batal/Ditolak).']);
                }
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Gagal mengecek status ke Midtrans: ' . $e->getMessage()]);
            }
        }
        
        return response()->json(['success' => true, 'message' => 'Tidak ada perubahan status.']);
    }
}
