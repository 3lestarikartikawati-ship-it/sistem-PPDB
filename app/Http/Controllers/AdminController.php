<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSiswa = Student::whereNotNull('kelas')->count();
        $totalPendaftar = Student::whereNull('kelas')->count();
        
        $kelas7 = Student::where('kelas', '7')->count();
        $kelas8 = Student::where('kelas', '8')->count();
        $kelas9 = Student::where('kelas', '9')->count();
        
        $recentPendaftar = Student::with('user')->whereNull('kelas')->latest()->take(5)->get();
        $recentSiswaAktif = Student::with('user')->whereNotNull('kelas')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSiswa', 'totalPendaftar', 'kelas7', 'kelas8', 'kelas9', 'recentPendaftar', 'recentSiswaAktif'
        ));
    }

    public function students(\Illuminate\Http\Request $request)
    {
        $query = Student::with(['user', 'payments']);
        
        if ($request->jalur) {
            $query->where('jalur_pendaftaran', $request->jalur);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nomor_pendaftaran', 'like', '%' . $request->search . '%');
            });
        }
        
        $students = $query->latest()->paginate(15)->withQueryString();
        
        $counts = [
            'semua' => Student::count(),
            'Reguler' => Student::where('jalur_pendaftaran', 'Reguler')->count(),
            'Prestasi' => Student::where('jalur_pendaftaran', 'Prestasi')->count(),
            'Afirmasi' => Student::where('jalur_pendaftaran', 'Afirmasi')->count(),
        ];

        return view('admin.students.index', compact('students', 'counts'));
    }

    public function activeStudents(\Illuminate\Http\Request $request)
    {
        $query = Student::with(['user', 'studentPayments']);
        
        if ($request->kelas) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }
        
        $students = $query->latest()->paginate(15)->withQueryString();
        
        $counts = [
            'semua' => Student::count(),
            '7' => Student::where('kelas', '7')->count(),
            '8' => Student::where('kelas', '8')->count(),
            '9' => Student::where('kelas', '9')->count(),
        ];

        return view('admin.siswa_aktif.index', compact('students', 'counts'));
    }

    /**
     * Store manual student
     */
    public function storeStudent(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'nisn' => 'required|unique:students,nisn',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas' => 'required|in:7,8,9',
        ]);

        $user = User::create([
            'name' => $request->nama_lengkap,
            'username' => $request->nisn,
            'email' => $request->nisn . '@student.local',
            'password' => Hash::make($request->nisn),
            'role' => 'siswa'
        ]);

        Student::create([
            'user_id' => $user->id,
            'nisn' => $request->nisn,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas' => $request->kelas,
            'status' => 'aktif',
            'nomor_pendaftaran' => 'M-' . rand(1000, 9999) . '-' . $request->nisn
        ]);

        return back()->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Import Excel
     */
    public function importExcel(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'kelas' => 'required|in:7,8,9'
        ]);

        try {
            Excel::import(new StudentImport($request->kelas), $request->file('file'));
            return back()->with('success', 'Data siswa berhasil di-import dari Excel.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                $messages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            return back()->with('error', implode('<br>', $messages));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete student
     */
    public function showStudent(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function verifyStudent(\Illuminate\Http\Request $request, Student $student)
    {
        $request->validate([
            'status' => 'required|in:menunggu,revisi_pendaftaran,lulus_pendaftaran,menunggu_daftar_ulang,revisi_daftar_ulang,aktif,ditolak,cadangan',
            'catatan' => 'nullable|string'
        ]);

        $student->update([
            'status' => $request->status,
            'catatan' => $request->catatan
        ]);

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function destroyStudent(Student $student)
    {
        if ($student->user) {
            $student->user->delete(); // This will cascade delete the student
        } else {
            $student->delete();
        }

        return back()->with('success', 'Data siswa berhasil dihapus.');
    }

    public function exportStudents()
    {
        $students = Student::with('user')->get();
        
        $filename = "data_pendaftar_" . date('Ymd') . ".csv";
        $handle = fopen('php://memory', 'w');
        
        // Add CSV headers
        fputcsv($handle, ['No', 'No Registrasi', 'Nama Lengkap', 'NISN', 'Asal Sekolah', 'No HP', 'Status']);
        
        foreach ($students as $index => $s) {
            fputcsv($handle, [
                $index + 1,
                $s->nomor_pendaftaran,
                $s->nama_lengkap,
                $s->nisn,
                $s->asal_sekolah,
                $s->user->no_hp ?? '',
                strtoupper($s->status)
            ]);
        }
        
        rewind($handle);
        $csvData = stream_get_contents($handle);
        fclose($handle);
        
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function exportPdf()
    {
        $students = Student::with('user')->orderBy('nomor_pendaftaran', 'asc')->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.students.pdf', compact('students'));
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('data_pendaftar_' . date('Ymd') . '.pdf');
    }
    public function settings()
    {
        $settings = Setting::where('key', 'not like', 'payment_%')->get();
        return view('admin.settings.index', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $settings = Setting::where('key', 'not like', 'payment_%')->get();
        foreach ($settings as $setting) {
            if ($setting->type === 'file') {
                if ($request->hasFile($setting->key)) {
                    if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                        Storage::disk('public')->delete($setting->value);
                    }
                    $path = $request->file($setting->key)->store('settings', 'public');
                    $setting->update(['value' => $path]);
                }
            } else {
                if ($request->has($setting->key)) {
                    $setting->update(['value' => $request->input($setting->key)]);
                }
            }
        }

        return back()->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }

    public function resetSettings()
    {
        Setting::whereIn('key', [
            'tgl_mulai_gel1', 'tgl_selesai_gel1', 
            'tgl_mulai_gel2', 'tgl_selesai_gel2', 
            'quota_gel1', 'quota_gel2',
            'tgl_pengumuman',
            'tgl_mulai_daftar_ulang', 'tgl_selesai_daftar_ulang'
        ])->update(['value' => null]);

        return back()->with('success', 'Pengaturan jadwal dan kuota telah dikosongkan.');
    }

    public function classesIndex()
    {
        // Get students who are accepted, have a fully paid payment, but don't have a class yet
        $unassignedStudents = Student::where('status', 'aktif')
            ->whereNull('kelas')
            ->orderBy('nama_lengkap', 'asc')
            ->get();

        // Get students who already have a class, grouped by class
        $assignedStudents = Student::whereNotNull('kelas')
            ->orderBy('nama_lengkap', 'asc')
            ->get()
            ->groupBy('kelas');

        return view('admin.classes.index', compact('unassignedStudents', 'assignedStudents'));
    }

    public function assignClass(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'kelas' => 'required|string|max:50',
        ]);

        $kelasName = strtoupper(trim($request->kelas));

        if ($kelasName !== '7') {
            return back()->withErrors(['kelas' => 'Siswa baru jalur PPDB hanya bisa dimasukkan ke Kelas 7.']);
        }

        Student::whereIn('id', $request->student_ids)->update(['kelas' => $kelasName]);

        return back()->with('success', count($request->student_ids) . ' siswa berhasil dimasukkan ke kelas ' . $kelasName . '.');
    }

    public function removeClass(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $student = Student::findOrFail($request->student_id);
        $oldKelas = $student->kelas;
        $student->update(['kelas' => null]);

        return back()->with('success', $student->nama_lengkap . ' berhasil dikeluarkan dari kelas ' . $oldKelas . '.');
    }

    public function exportClassPdf($kelas)
    {
        $students = Student::where('kelas', $kelas)->orderBy('nama_lengkap', 'asc')->get();
        
        if ($students->isEmpty()) {
            return back()->with('error', 'Tidak ada siswa di kelas ini.');
        }

        $settings = \App\Models\Setting::pluck('value', 'key');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.classes.pdf', compact('students', 'kelas', 'settings'));
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('daftar_siswa_kelas_' . strtolower(str_replace(' ', '_', $kelas)) . '.pdf');
    }
}
