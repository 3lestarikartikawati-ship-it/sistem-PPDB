<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PublicRegistrationController extends Controller
{
    public function create()
    {
        // Check if within any registration wave
        $settings = \App\Models\Setting::pluck('value', 'key');
        $now = now()->format('Y-m-d');
        $inGel1 = ($now >= ($settings['tgl_mulai_gel1'] ?? '9999-12-31') && $now <= ($settings['tgl_selesai_gel1'] ?? '0000-01-01'));
        $inGel2 = ($now >= ($settings['tgl_mulai_gel2'] ?? '9999-12-31') && $now <= ($settings['tgl_selesai_gel2'] ?? '0000-01-01'));

        if (!$inGel1 && (!$inGel2)) {
            return redirect('/')->with('error', 'Pendaftaran saat ini sedang ditutup. Silakan cek jadwal pendaftaran.');
        }

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

        return view('public.pendaftaran', compact('jalurSettings'));
    }

    public function store(Request $request)
    {
        // Check if within any registration wave
        $settings = \App\Models\Setting::pluck('value', 'key');
        $now = now()->format('Y-m-d');
        $inGel1 = ($now >= ($settings['tgl_mulai_gel1'] ?? '9999-12-31') && $now <= ($settings['tgl_selesai_gel1'] ?? '0000-01-01'));
        $inGel2 = ($now >= ($settings['tgl_mulai_gel2'] ?? '9999-12-31') && $now <= ($settings['tgl_selesai_gel2'] ?? '0000-01-01'));

        if (!$inGel1 && (!$inGel2)) {
            return redirect('/')->with('error', 'Pendaftaran sudah ditutup atau belum dimulai.');
        }

        // Quota Check
        $currentWave = $inGel1 ? '1' : '2';
        $quotaKey = $inGel1 ? 'quota_gel1' : 'quota_gel2';
        $maxQuota = intval($settings[$quotaKey] ?? 0);
        
        $currentCount = \App\Models\Student::where('gelombang', $currentWave)
                            ->whereIn('status', ['menunggu', 'lulus_pendaftaran', 'menunggu_daftar_ulang', 'aktif'])
                            ->count();
        
        $status = 'menunggu';
        if ($maxQuota > 0 && $currentCount >= $maxQuota) {
            $status = 'cadangan';
        }

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
        if (!isset($jalurSettings[$selectedJalur]) || $jalurSettings[$selectedJalur]['aktif'] !== '1') {
            return redirect()->back()->withInput()->withErrors(['jalur_pendaftaran' => 'Jalur pendaftaran yang dipilih sedang tidak aktif.']);
        }

        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|digits:10|unique:students,nisn|unique:users,username',
            'nik' => 'nullable|digits:16',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string',
            
            // New Student Fields
            'no_ujian' => 'nullable|string|max:50',
            'no_skhu' => 'nullable|string|max:50',
            'no_ijazah' => 'nullable|string|max:50',
            'suku' => 'nullable|string|max:50',
            'status_anak' => 'nullable|string|max:50',
            'kondisi_anak' => 'nullable|string|max:50',
            'keadaan_orang_tua' => 'nullable|string|max:50',
            'status_dalam_keluarga' => 'nullable|string|max:50',
            'tinggal_bersama' => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'anak_ke' => 'nullable|integer',
            'dari_bersaudara' => 'nullable|integer',
            'bahasa_sehari_hari' => 'nullable|string|max:50',
            
            // Address
            'jalan' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'desa_kelurahan' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kabupaten' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kode_pos' => 'nullable|string|max:10',
            'alamat' => 'nullable|string', // Retained for backward compatibility
            'email_siswa' => 'nullable|email',

            // Parent Data
            'nama_ayah' => 'nullable|string',
            'nama_ibu' => 'nullable|string',
            'pendidikan_ayah' => 'nullable|string|max:50',
            'pendidikan_ibu' => 'nullable|string|max:50',
            'pekerjaan_orang_tua' => 'nullable|string', // Legacy
            'penghasilan_ayah' => 'nullable|string|max:50',
            'penghasilan_ibu' => 'nullable|string|max:50',
            'email_orang_tua' => 'nullable|email',
            'nama_wali' => 'nullable|string',
            'alamat_wali' => 'nullable|string',
            'no_hp_orang_tua' => 'required|string',
            'alamat_penghubung_orang_tua' => 'nullable|string',
            'alamat_penghubung_wali' => 'nullable|string',

            // Health
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'berat_badan' => 'nullable|string|max:10',
            'tinggi_badan' => 'nullable|string|max:10',
            'riwayat_penyakit' => 'nullable|string',

            'asal_sekolah' => 'required|string',
            'jalur_pendaftaran' => 'required|in:Reguler,Prestasi,Afirmasi',
            'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'kartu_keluarga' => 'nullable|mimes:pdf,jpeg,png,jpg|max:5120',
            'ijazah_skl' => 'nullable|mimes:pdf,jpeg,png,jpg|max:5120',
            'setuju' => 'required|accepted',
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

        $data = $request->except(['setuju', 'pas_foto', 'kartu_keluarga', 'ijazah_skl', 'bukti_rapor', 'bukti_prestasi', 'bukti_beasiswa']);

        if ($request->hasFile('pas_foto')) {
            $data['pas_foto'] = $request->file('pas_foto')->store('berkas/foto');
        }
        if ($request->hasFile('kartu_keluarga')) {
            $data['kartu_keluarga'] = $request->file('kartu_keluarga')->store('berkas/kk');
        }
        if ($request->hasFile('ijazah_skl')) {
            $data['ijazah_skl'] = $request->file('ijazah_skl')->store('berkas/ijazah');
        }
        if ($request->hasFile('bukti_rapor')) {
            $data['bukti_rapor'] = $request->file('bukti_rapor')->store('berkas/rapor');
        }
        if ($request->hasFile('bukti_prestasi')) {
            $data['bukti_prestasi'] = $request->file('bukti_prestasi')->store('berkas/prestasi');
        }
        if ($request->hasFile('bukti_beasiswa')) {
            $data['bukti_beasiswa'] = $request->file('bukti_beasiswa')->store('berkas/beasiswa');
        }

        // Create User
        $password = Carbon::parse($request->tanggal_lahir)->format('dmY'); // Format DDMMYYYY
        $user = User::create([
            'name' => $request->nama_lengkap,
            'username' => $request->nisn,
            'no_hp' => $request->no_hp_orang_tua,
            'role' => 'siswa',
            'password' => Hash::make($password),
        ]);

        $data['status'] = $status;
        $data['user_id'] = $user->id;
        $data['gelombang'] = $currentWave;
        $newStudent = Student::create($data);

        session(['pendaftaran_nisn' => $newStudent->nisn, 'pendaftaran_password' => $password, 'pendaftaran_nama' => $newStudent->nama_lengkap]);

        return redirect()->route('pendaftaran.sukses');
    }

    public function sukses()
    {
        if (!session('pendaftaran_nisn')) {
            return redirect()->route('login');
        }

        $data = [
            'nisn' => session('pendaftaran_nisn'),
            'password' => session('pendaftaran_password'),
            'nama' => session('pendaftaran_nama'),
        ];

        // Clear session data after reading
        session()->forget(['pendaftaran_nisn', 'pendaftaran_password', 'pendaftaran_nama']);

        return view('public.pendaftaran-sukses', $data);
    }
}
