<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Student;
use App\Models\StudentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BendaharaController extends Controller
{
    /**
     * Bendahara Dashboard
     */
    public function dashboard()
    {
        $totalInfak = StudentPayment::where('type', 'infak')->sum('amount');
        $totalLk = StudentPayment::where('type', 'lk')->sum('amount');
        $totalSeragam = StudentPayment::where('type', 'seragam')->sum('amount');
        
        $totalFunds = $totalInfak + $totalLk + $totalSeragam;
        $totalAccepted = Student::whereIn('kelas', ['7', '8', '9'])->count();
        
        // Activity for dashboard
        $recentPayments = StudentPayment::with(['student', 'recorder'])
            ->latest('paid_at')
            ->take(5)
            ->get();

        // 7-day payment trend
        $chartData = StudentPayment::selectRaw('DATE(paid_at) as date, SUM(amount) as total')
            ->where('paid_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $labels = $chartData->pluck('date')->map(fn($date) => date('d M', strtotime($date)));
        $totals = $chartData->pluck('total');

        // Payment Type breakdown
        $methodData = StudentPayment::select('type', DB::raw('SUM(amount) as total'))
            ->groupBy('type')
            ->get();

        return view('bendahara.dashboard', compact(
            'totalInfak', 'totalLk', 'totalSeragam', 'totalFunds', 'totalAccepted',
            'recentPayments', 'labels', 'totals', 'methodData'
        ));
    }

    /**
     * Re-registration payments list (Now Student Installments)
     */
    public function paymentsIndex(Request $request)
    {
        $totalInfak = StudentPayment::where('type', 'infak')->sum('amount');
        $totalLk = StudentPayment::where('type', 'lk')->sum('amount');
        $totalSeragam = StudentPayment::where('type', 'seragam')->sum('amount');
        $totalFunds = $totalInfak + $totalLk + $totalSeragam;
        $totalAccepted = Student::whereIn('kelas', ['7', '8', '9'])->count();

        $query = Student::whereIn('kelas', ['7', '8', '9'])
            ->with(['studentPayments']);

        if ($request->search) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        if ($request->kelas) {
            $query->where('kelas', $request->kelas);
        }

        $students = $query->orderBy('kelas')->latest()->paginate(15)->withQueryString();

        $counts = [
            'semua' => Student::whereIn('kelas', ['7', '8', '9'])->count(),
            '7' => Student::where('kelas', '7')->count(),
            '8' => Student::where('kelas', '8')->count(),
            '9' => Student::where('kelas', '9')->count(),
        ];

        return view('bendahara.payments.index', compact(
            'students', 'totalFunds', 'counts', 'totalAccepted'
        ));
    }

    /**
     * Store new installment
     */
    public function storePayment(Request $request, Student $student)
    {
        // Hilangkan titik pada nominal (contoh: 5.000 jadi 5000)
        $request->merge([
            'amount' => str_replace('.', '', $request->amount)
        ]);

        $request->validate([
            'type' => 'required|in:infak,lk,seragam',
            'amount' => 'required|numeric|min:1',
            'paid_at' => 'required|date',
            'notes' => 'nullable|string',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ], [
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah.',
            'bukti_pembayaran.image' => 'File bukti pembayaran harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Format bukti pembayaran harus JPG, JPEG, atau PNG.',
            'bukti_pembayaran.max' => 'Ukuran file bukti pembayaran maksimal adalah 5MB.',
        ]);

        // Validasi dan proteksi cicilan
        $type = $request->type;
        $amount = $request->amount;
        $paid = $student->studentPayments()->where('type', $type)->sum('amount');
        
        if ($type === 'infak') {
            $target = $student->target_infak;
        } elseif ($type === 'lk') {
            $target = $student->target_lk;
        } elseif ($type === 'seragam') {
            $target = $student->target_seragam;
        }

        if (isset($target) && $paid + $amount > $target) {
            $sisa = $target - $paid;
            $namaJenis = $type === 'infak' ? 'infak' : ($type === 'lk' ? 'LK' : 'seragam');
            return back()->withErrors(['amount' => 'Nominal melebihi sisa target ' . $namaJenis . '. Sisa yang bisa dibayar: Rp ' . number_format($sisa, 0, ',', '.')]);
        }

        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $buktiPath = $file->storeAs('bukti_pembayaran', $filename, 'public');
        }

        $student->studentPayments()->create([
            'type' => $request->type,
            'amount' => $request->amount,
            'paid_at' => $request->paid_at,
            'notes' => $request->notes,
            'bukti_pembayaran' => $buktiPath,
            'recorded_by' => auth()->id()
        ]);

        return back()->with('success', 'Pembayaran berhasil dicatat.');
    }

    /**
     * Delete a payment record
     */
    public function destroyPayment(StudentPayment $payment)
    {
        if ($payment->bukti_pembayaran && \Illuminate\Support\Facades\Storage::disk('public')->exists($payment->bukti_pembayaran)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($payment->bukti_pembayaran);
        }

        $payment->delete();
        return back()->with('success', 'Riwayat pembayaran berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $query = Student::whereIn('kelas', ['7', '8', '9'])
            ->with(['studentPayments']);

        if ($request->search) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        if ($request->kelas) {
            $query->where('kelas', $request->kelas);
        }

        $students = $query->orderBy('kelas')->orderBy('nama_lengkap')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bendahara.payments.pdf', compact('students'));
        $pdf->setPaper('a4', 'landscape');
        
        $filename = 'rekap_pembayaran_' . ($request->kelas ? 'kelas_'.$request->kelas.'_' : '') . date('Ymd') . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Bendahara Settings (Rincian Biaya)
     */
    public function settings()
    {
        $keys = ['biaya_infak', 'biaya_lk_7', 'biaya_lk_8', 'biaya_lk_9', 'biaya_seragam_osis', 'biaya_seragam_olahraga', 'biaya_seragam_batik', 'biaya_seragam_identitas'];
        $settings = Setting::whereIn('key', $keys)->pluck('value', 'key')->toArray();

        return view('bendahara.settings', compact('settings'));
    }

    /**
     * Update Bendahara Settings
     */
    public function updateSettings(Request $request)
    {
        $keys = ['biaya_infak', 'biaya_lk_7', 'biaya_lk_8', 'biaya_lk_9', 'biaya_seragam_osis', 'biaya_seragam_olahraga', 'biaya_seragam_batik', 'biaya_seragam_identitas'];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $request->input($key), 'type' => 'number', 'name' => $key]
                );
            }
        }

        return back()->with('success', 'Rincian biaya berhasil diperbarui.');
    }

    /**
     * Export Belum Lunas PDF
     */
    public function exportBelumLunasPdf(Request $request)
    {
        $query = Student::whereIn('kelas', ['7', '8', '9'])
            ->with(['studentPayments']);

        if ($request->kelas) {
            $query->where('kelas', $request->kelas);
        }

        $allStudents = $query->orderBy('kelas')->orderBy('nama_lengkap')->get();

        // Filter only students who still owe money
        $students = $allStudents->filter(function ($student) {
            $paid = $student->studentPayments->sum('amount');
            $target = $student->total_target;
            return $paid < $target;
        });

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bendahara.payments.pdf_belum_lunas', compact('students'));
        $pdf->setPaper('a4', 'landscape');

        $filename = 'siswa_belum_lunas_' . ($request->kelas ? 'kelas_'.$request->kelas.'_' : '') . date('Ymd') . '.pdf';
        return $pdf->download($filename);
    }
}
