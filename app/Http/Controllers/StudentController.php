<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = auth()->user()->student;
        $tgl_pengumuman = \App\Models\Setting::where('key', 'tgl_pengumuman')->value('value');
        return view('student.dashboard', compact('student', 'tgl_pengumuman'));
    }

    public function edit()
    {
        $student = auth()->user()->student;
        if (!$student || $student->status !== 'revisi_pendaftaran') {
            return redirect()->route('siswa.dashboard')->with('error', 'Pendaftaran Anda tidak sedang dalam masa revisi.');
        }

        $settings = \App\Models\Setting::pluck('value', 'key');
        $jalurSettings = [
            'Reguler' => [
                'aktif' => $settings['jalur_reguler_aktif'] ?? '1',
                'req_rapor' => $settings['jalur_reguler_req_rapor'] ?? '1',
            ],
            'Prestasi' => [
                'aktif' => $settings['jalur_prestasi_aktif'] ?? '1',
                'req_rapor' => $settings['jalur_prestasi_req_rapor'] ?? '1',
                'req_prestasi' => $settings['jalur_prestasi_req_prestasi'] ?? '1',
            ],
            'Afirmasi' => [
                'aktif' => $settings['jalur_afirmasi_aktif'] ?? '1',
                'req_rapor' => $settings['jalur_afirmasi_req_rapor'] ?? '1',
                'req_beasiswa' => $settings['jalur_afirmasi_req_beasiswa'] ?? '1',
            ]
        ];

        return view('student.revisi', compact('student', 'jalurSettings'));
    }

    public function update(Request $request)
    {
        $student = auth()->user()->student;
        if (!$student || $student->status !== 'revisi_pendaftaran') {
            return redirect()->route('siswa.dashboard')->with('error', 'Pendaftaran Anda tidak sedang dalam masa revisi.');
        }

        $settings = \App\Models\Setting::pluck('value', 'key');
        $jalurSettings = [
            'Reguler' => [
                'aktif' => $settings['jalur_reguler_aktif'] ?? '1',
                'req_rapor' => $settings['jalur_reguler_req_rapor'] ?? '1',
            ],
            'Prestasi' => [
                'aktif' => $settings['jalur_prestasi_aktif'] ?? '1',
                'req_rapor' => $settings['jalur_prestasi_req_rapor'] ?? '1',
                'req_prestasi' => $settings['jalur_prestasi_req_prestasi'] ?? '1',
            ],
            'Afirmasi' => [
                'aktif' => $settings['jalur_afirmasi_aktif'] ?? '1',
                'req_rapor' => $settings['jalur_afirmasi_req_rapor'] ?? '1',
                'req_beasiswa' => $settings['jalur_afirmasi_req_beasiswa'] ?? '1',
            ]
        ];

        $selectedJalur = $request->jalur_pendaftaran;
        
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|string|max:20',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string',
            'alamat' => 'required|string',
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'pekerjaan_orang_tua' => 'required|string',
            'no_hp_orang_tua' => 'required|string',
            'asal_sekolah' => 'required|string',
            'jalur_pendaftaran' => 'required|in:Reguler,Prestasi,Afirmasi',
            'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'kartu_keluarga' => 'nullable|mimes:pdf,jpeg,png,jpg|max:5120',
            'ijazah_skl' => 'nullable|mimes:pdf,jpeg,png,jpg|max:5120',
        ];

        $isRaporRequired = $jalurSettings[$selectedJalur]['req_rapor'] === '1';
        $rules['nilai_rapor'] = $isRaporRequired ? 'required|numeric|min:0|max:100' : 'nullable|numeric|min:0|max:100';
        $rules['bukti_rapor'] = 'nullable|mimes:pdf,jpeg,png,jpg|max:5120';
        
        if ($selectedJalur === 'Prestasi') {
            $isPrestasiReq = $jalurSettings['Prestasi']['req_prestasi'] === '1';
            $rules['prestasi'] = $isPrestasiReq ? 'required|string' : 'nullable|string';
            $rules['bukti_prestasi'] = 'nullable|mimes:pdf,jpeg,png,jpg|max:5120';
        } else {
            $rules['prestasi'] = 'nullable|string';
            $rules['bukti_prestasi'] = 'nullable|mimes:pdf,jpeg,png,jpg|max:5120';
        }

        if ($selectedJalur === 'Afirmasi') {
            $isBeasiswaReq = $jalurSettings['Afirmasi']['req_beasiswa'] === '1';
            $rules['nomor_kip'] = $isBeasiswaReq ? 'required|string' : 'nullable|string';
            $rules['bukti_beasiswa'] = 'nullable|mimes:pdf,jpeg,png,jpg|max:5120';
        } else {
            $rules['nomor_kip'] = 'nullable|string';
            $rules['bukti_beasiswa'] = 'nullable|mimes:pdf,jpeg,png,jpg|max:5120';
        }

        $validated = $request->validate($rules);
        $data = $request->except(['pas_foto', 'kartu_keluarga', 'ijazah_skl', 'bukti_rapor', 'bukti_prestasi', 'bukti_beasiswa', '_token', '_method', 'setuju']);

        if ($request->hasFile('pas_foto')) {
            if ($student->pas_foto) Storage::delete($student->pas_foto);
            $data['pas_foto'] = $request->file('pas_foto')->store('berkas/foto');
        }
        if ($request->hasFile('kartu_keluarga')) {
            if ($student->kartu_keluarga) Storage::delete($student->kartu_keluarga);
            $data['kartu_keluarga'] = $request->file('kartu_keluarga')->store('berkas/kk');
        }
        if ($request->hasFile('ijazah_skl')) {
            if ($student->ijazah_skl) Storage::delete($student->ijazah_skl);
            $data['ijazah_skl'] = $request->file('ijazah_skl')->store('berkas/ijazah');
        }
        if ($request->hasFile('bukti_rapor')) {
            if ($student->bukti_rapor) Storage::delete($student->bukti_rapor);
            $data['bukti_rapor'] = $request->file('bukti_rapor')->store('berkas/rapor');
        }
        if ($request->hasFile('bukti_prestasi')) {
            if ($student->bukti_prestasi) Storage::delete($student->bukti_prestasi);
            $data['bukti_prestasi'] = $request->file('bukti_prestasi')->store('berkas/prestasi');
        }
        if ($request->hasFile('bukti_beasiswa')) {
            if ($student->bukti_beasiswa) Storage::delete($student->bukti_beasiswa);
            $data['bukti_beasiswa'] = $request->file('bukti_beasiswa')->store('berkas/beasiswa');
        }

        $data['status'] = 'menunggu';
        $student->update($data);
        
        // Also update User name
        $user = auth()->user();
        if ($user->name !== $data['nama_lengkap']) {
            $user->update(['name' => $data['nama_lengkap']]);
        }

        return redirect()->route('siswa.dashboard')->with('success', 'Data pendaftaran berhasil diperbarui dan dikirim kembali untuk diverifikasi.');
    }

    public function daftarUlangIndex()
    {
        $student = auth()->user()->student;
        
        if (!$student || !in_array($student->status, ['lulus_pendaftaran', 'menunggu_daftar_ulang', 'revisi_daftar_ulang', 'aktif'])) {
            return redirect()->route('siswa.dashboard')->with('error', 'Halaman daftar ulang hanya untuk siswa yang telah lulus pendaftaran.');
        }

        $settings = \App\Models\Setting::pluck('value', 'key');
        
        return view('student.daftar_ulang.index', compact('student', 'settings'));
    }

    public function storeDaftarUlang(Request $request)
    {
        $student = auth()->user()->student;

        if (!$student || !in_array($student->status, ['lulus_pendaftaran', 'revisi_daftar_ulang'])) {
            return redirect()->route('siswa.dashboard')->with('error', 'Anda tidak dapat melakukan daftar ulang saat ini.');
        }

        $settings = \App\Models\Setting::pluck('value', 'key');
        $now = now()->format('Y-m-d');
        $tgl_mulai = $settings['tgl_mulai_daftar_ulang'] ?? '9999-12-31';
        $tgl_selesai = $settings['tgl_selesai_daftar_ulang'] ?? '0000-01-01';

        if ($now < $tgl_mulai || $now > $tgl_selesai) {
            return redirect()->route('siswa.dashboard')->with('error', 'Jadwal daftar ulang belum dimulai atau sudah ditutup.');
        }

        $request->validate([
            'daftar_ulang_akte' => 'nullable|mimes:pdf,jpeg,png,jpg|max:5120',
            'daftar_ulang_kk' => 'nullable|mimes:pdf,jpeg,png,jpg|max:5120',
            'daftar_ulang_skl' => 'nullable|mimes:pdf,jpeg,png,jpg|max:5120',
        ]);

        $data = [];

        if ($request->hasFile('daftar_ulang_akte')) {
            if ($student->daftar_ulang_akte) Storage::delete($student->daftar_ulang_akte);
            $data['daftar_ulang_akte'] = $request->file('daftar_ulang_akte')->store('berkas/daftar_ulang');
        }

        if ($request->hasFile('daftar_ulang_kk')) {
            if ($student->daftar_ulang_kk) Storage::delete($student->daftar_ulang_kk);
            $data['daftar_ulang_kk'] = $request->file('daftar_ulang_kk')->store('berkas/daftar_ulang');
        }

        if ($request->hasFile('daftar_ulang_skl')) {
            if ($student->daftar_ulang_skl) Storage::delete($student->daftar_ulang_skl);
            $data['daftar_ulang_skl'] = $request->file('daftar_ulang_skl')->store('berkas/daftar_ulang');
        }

        $data['status'] = 'menunggu_daftar_ulang';

        $student->update($data);

        return redirect()->route('siswa.dashboard')->with('success', 'Berkas daftar ulang berhasil diunggah. Menunggu verifikasi admin.');
    }

    public function printPdf()
    {
        $student = auth()->user()->student;
        if (!$student) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data pendaftaran belum tersedia.');
        }
        
        return view('student.cetak', compact('student'));
    }

    public function printSkd()
    {
        $student = auth()->user()->student;
        if (!$student || !in_array($student->status, ['lulus_pendaftaran', 'menunggu_daftar_ulang', 'aktif'])) {
            return redirect()->route('siswa.dashboard')->with('error', 'Surat Keterangan hanya tersedia untuk siswa yang dinyatakan Diterima.');
        }
        
        $settings = \App\Models\Setting::pluck('value', 'key');
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('student.skd_pdf', compact('student', 'settings'));
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('SK_Diterima_' . $student->nomor_pendaftaran . '.pdf');
    }
}
