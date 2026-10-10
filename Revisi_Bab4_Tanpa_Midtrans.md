# BAB IV - HASIL DAN PEMBAHASAN (Revisi Tanpa Midtrans)

> **Catatan untuk Penulis:** 
> Berikut adalah teks revisi Bab 4 yang telah disesuaikan karena penghapusan sistem Midtrans. Anda dapat menyalin (*copy-paste*) teks ini ke dalam dokumen Microsoft Word skripsi/laporan Anda.
> 
> **PERHATIAN UNTUK GAMBAR/DIAGRAM:**
> Saya telah menyertakan instruksi di dalam tanda kurung siku tebal (seperti **[REVISI GAMBAR 4.2: Hapus elips "Bayar via Midtrans"]**) di bawah judul setiap gambar. Anda harus mengedit gambar tersebut secara manual di aplikasi diagram yang Anda gunakan (misalnya MS Visio, Draw.io, atau StarUML), lalu menempelkannya kembali ke laporan Anda.

---

## 4.1. Analisis Sistem
Pada tahapan awal pengembangan sistem, dilakukan proses analisis kebutuhan untuk memahami secara menyeluruh fitur-fitur yang harus disediakan oleh Sistem Informasi Penerimaan Peserta Didik Baru (PPDB) Berbasis Web. Analisis dilakukan melalui metode observasi dan wawancara dengan pihak panitia penerimaan, yaitu pihak administrasi sekolah dan bendahara. Kebutuhan ini dibagi menjadi kebutuhan fungsional dan non-fungsional.

### 4.1.1 Kebutuhan Fungsional
Kebutuhan fungsional mendeskripsikan fungsi atau layanan spesifik yang harus disediakan oleh sistem untuk setiap aktor yang terlibat.

**a. Untuk Calon Siswa (Pendaftar):**
1. Sistem harus memungkinkan calon siswa melakukan registrasi akun dan mengakses *dashboard* melalui proses login yang divalidasi (termasuk via Google OAuth).
2. Sistem harus memfasilitasi calon siswa untuk memilih jalur pendaftaran (Reguler, Prestasi, Afirmasi) dan mengisi formulir biodata secara dinamis.
3. Sistem harus memungkinkan calon siswa mengunggah dokumen persyaratan sesuai dengan jalur pendaftaran yang dipilih.
4. Sistem harus menyediakan portal pembayaran pendaftaran yang memungkinkan siswa mengunggah bukti transfer bank secara manual.
5. Sistem harus menampilkan pengumuman status kelulusan, penempatan kelas (*plotting*), dan memungkinkan pencetakan bukti pendaftaran.

**b. Untuk Admin:**
1. Admin harus memiliki akses ke *dashboard* khusus yang dilindungi oleh proses login.
2. Admin harus dapat mengelola pengaturan jalur pendaftaran, termasuk mengaktifkan/menonaktifkan jalur dan menentukan syarat dokumen wajib secara dinamis.
3. Admin harus dapat melakukan verifikasi data biodata dan dokumen persyaratan yang diunggah oleh pendaftar.
4. Admin harus dapat melakukan manajemen penempatan kelas (*plotting*) bagi siswa yang dinyatakan lolos seleksi dan mengekspor data kelas ke dalam format PDF.
5. Sistem harus memungkinkan admin mengelola data master pengguna dan mereset data pendaftar (*database cleaning*) untuk persiapan periode PPDB baru.

**c. Untuk Bendahara:**
1. Bendahara harus memiliki akses ke *dashboard* keuangan untuk memonitor lalu lintas transaksi pembayaran pendaftaran.
2. Sistem harus memungkinkan bendahara untuk memverifikasi pembayaran yang dilakukan secara manual (transfer bank) melalui unggahan bukti transfer pendaftar.
3. Bendahara harus dapat mencetak laporan keuangan rekapitulasi pembayaran PPDB.

### 4.1.2 Kebutuhan Non-Fungsional
Kebutuhan non-fungsional mendefinisikan kriteria kualitas dan operasional dari sistem.

a. **Kemudahan Penggunaan (Usability):** Antarmuka pengguna (UI) harus dirancang agar modern, intuitif, responsif, dan ramah pengguna, dengan efek visual yang halus sehingga mudah diakses melalui perangkat desktop maupun mobile oleh calon siswa.
b. **Performa (Performance):** Sistem harus memiliki waktu respons yang cepat, terbebas dari masalah *loading* tak terbatas (*infinite loading*) pada proses verifikasi atau saat memuat data dalam jumlah besar.
c. **Keamanan (Security):** Sistem harus menggunakan enkripsi kata sandi, autentikasi aman (termasuk penyimpanan token OAuth yang memadai), dan hak akses berbasis peran (*Role-Based Access Control*) untuk melindungi kerahasiaan data calon siswa.
d. **Skalabilitas (Scalability):** Struktur basis data harus fleksibel untuk menampung rekam data transaksi pembayaran dan arsitektur harus sanggup menghadapi lonjakan akses pada masa puncak pendaftaran.

---

## 4.2. Perancangan Sistem
Pada tahap perancangan, dilakukan penyusunan arsitektur sistem yang mencakup desain antarmuka pengguna (UI), struktur basis data, serta alur proses pendaftaran PPDB. Perancangan ini bertujuan untuk membangun sistem yang efektif, efisien, dan sesuai dengan prosedur standar sekolah. Beberapa langkah yang dilakukan adalah sebagai berikut:

### 4.2.1 Perancangan Antarmuka Pengguna (UI)
Antarmuka pengguna dirancang untuk mengakomodasi kebutuhan Calon Siswa, Admin, dan Bendahara dengan pendekatan desain yang profesional dan responsif. Beberapa fitur antarmuka meliputi:

a. **Halaman Landing Page & Autentikasi:** Portal informasi pendaftaran dan pintu masuk sistem yang dilengkapi dengan opsi login reguler maupun *Single Sign-On* (Google).
b. **Halaman Dashboard Calon Siswa:** Menampilkan alur pendaftaran, status pembayaran, formulir pemilihan jalur (Reguler/Prestasi/Afirmasi), serta area unggah dokumen persyaratan yang spesifik per jalur.
c. **Halaman Dashboard Admin & Verifikasi:** Menampilkan metrik analitik pendaftar, kontrol *toggle* jalur pendaftaran, antarmuka verifikasi berkas, dan fitur manajemen penempatan kelas (*plotting*).
d. **Halaman Dashboard Bendahara:** Area khusus untuk pengecekan daftar tunggu konfirmasi pembayaran manual transfer bank dan rekapitulasi transaksi.
e. **Halaman Laporan dan Cetak PDF:** Fitur untuk me-*render* laporan daftar siswa yang diterima per kelas ke dalam dokumen PDF resmi sebagai arsip sekolah.

### 4.2.2 Perancangan Basis Data
Struktur basis data relasional dirancang menggunakan MySQL untuk menjamin integritas data operasional PPDB:

a. **Tabel Pengguna (Users / Roles):** Menyimpan kredensial autentikasi (termasuk ekstensi *field token* Auth) dan membedakan hak akses (*role*) antara Admin, Bendahara, atau Siswa.
b. **Tabel Calon Siswa / Pendaftar (Students):** Berisi data identitas lengkap, asal sekolah, dan status tahapan pendaftaran.
c. **Tabel Jalur & Persyaratan Pendaftaran (Registration Paths):** Menyimpan konfigurasi dinamis mengenai jalur PPDB mana yang sedang aktif beserta dokumen wajib yang mengikat.
d. **Tabel Dokumen (Documents):** Mengelola path direktori unggahan file persyaratan siswa dan status validasinya.
e. **Tabel Pembayaran (Payments):** Mencatat transaksi pendaftaran, pilihan rekening transfer, unggahan berkas bukti transfer, dan status pelunasan.
f. **Tabel Kelas & Plotting (Classes):** Menyimpan data rombongan belajar dan relasi pembagian kelas bagi siswa yang telah diterima.

---

## 4.3. Tahapan Analisis
Berdasarkan hasil analisis kebutuhan alur kerja operasional, berikut adalah spesifikasi kebutuhan interaksi spesifik dari sistem Informasi PPDB:

**a. Halaman / Kewenangan Calon Siswa:**
1. Calon siswa dapat melakukan pendaftaran akun baru atau login secara instan menggunakan akun Google.
2. Calon siswa dapat memilih jalur pendaftaran (Reguler, Prestasi, Afirmasi) yang disediakan oleh sistem.
3. Calon siswa dapat melengkapi formulir biodata dan mengunggah dokumen persyaratan sesuai dengan jalur yang dipilihnya.
4. Calon siswa dapat menyelesaikan tagihan pembayaran pendaftaran dengan melihat instruksi rekening sekolah dan mengunggah bukti transfer.
5. Calon siswa dapat memantau status verifikasi dokumen (Diterima/Menunggu/Ditolak).
6. Calon siswa dapat melihat hasil *plotting* kelas setelah dinyatakan lulus.
7. Calon siswa dapat mencetak bukti pendaftaran resmi dari sistem.

**b. Halaman / Kewenangan Admin:**
*(Tidak ada perubahan, sama dengan PDF asli)*

**c. Halaman / Kewenangan Bendahara:**
1. Bendahara dapat melihat daftar pembayaran pendaftar yang menunggu konfirmasi.
2. Bendahara dapat melakukan verifikasi silang dan memperbarui status pembayaran secara manual bagi siswa yang telah mengunggah bukti transfer.
3. Bendahara dapat mengunduh laporan rekapitulasi penerimaan dana pendaftaran untuk keperluan pembukuan dan audit sekolah.
4. Bendahara dapat mengatur referensi dan rincian nominal pembayaran.

---

## 4.4. Use Case Diagram

### 4.4.1 Use Case Diagram Pengunjung
*(Tidak ada perubahan)*

### 4.4.2 Use Case Diagram Calon Siswa (Pendaftar)

**[REVISI GAMBAR 4.2: Di dalam gambar Use Case Calon Siswa, HAPUS Use Case "Bayar via Midtrans". Sisakan Use Case "Melakukan Pembayaran / Daftar Ulang" dan "Cetak Kuitansi Bayar"]**

*Tabel 4. 2 Deskripsi Use Case Calon Siswa*
| No | Nama Use Case | Deskripsi / Tujuan Singkat |
|---|---|---|
| 1 | Melakukan Registrasi Akun | Mendaftar akun baru ke dalam sistem PPDB menggunakan email aktif. |
| 2 | Melakukan Login | Masuk ke *dashboard* menggunakan otorisasi Calon Siswa. |
| 3 | Login via Google SSO | Masuk secara instan menggunakan otentikasi Google tanpa perlu mengetikkan kata sandi. |
| 4 | Memilih Jalur Pendaftaran | Menentukan jalur pendaftaran yang sesuai (misal: Reguler, Prestasi, atau Afirmasi). |
| 5 | Mengisi Formulir Biodata | Melengkapi data diri secara detail, riwayat sekolah asal, serta kontak orang tua/wali. |
| 6 | Mengunggah Dokumen Persyaratan | Mengunggah berkas wajib (KK, Ijazah, dll) yang disesuaikan secara dinamis berdasar jalur yang dipilih. |
| 7 | Melakukan Pembayaran | Melihat rincian tagihan biaya pendaftaran dan mengunggah bukti transfer bank secara manual. |
| 8 | Melihat Status Verifikasi & Kelulusan | Memeriksa progres kelayakan dokumen dan informasi akhir kelulusan (serta hasil plotting kelas). |
| 9 | Mencetak Bukti Pendaftaran | Men-*generate* dan mengunduh kartu bukti pendaftaran format PDF untuk disimpan. |

### 4.4.3 Use Case Diagram Admin
*(Tidak ada perubahan)*

### 4.4.4 Use Case Diagram Bendahara

**[REVISI GAMBAR 4.4: Di dalam gambar Use Case Bendahara, HAPUS Use Case "Memantau Transaksi Midtrans". (Ubah teks jika sebelumnya ada tulisan Midtrans di Use Case verifikasi pembayaran)]**

*Tabel 4. 4 Deskripsi Use Case Bendahara*
| No | Nama Use Case | Deskripsi / Tujuan Singkat |
|---|---|---|
| 1 | Melakukan Login | Masuk ke portal keuangan sistem menggunakan kredensial Bendahara. |
| 2 | Melihat Dashboard Keuangan | Melihat ringkasan total dana yang masuk (*revenue*) dan metrik keberhasilan transaksi. |
| 3 | Memverifikasi Pembayaran Manual | Memeriksa file unggahan bukti transfer siswa dan mengubah status tagihan menjadi Lunas secara manual jika sesuai. |
| 4 | Mengelola Rincian Biaya Item | Menambahkan atau mengubah komponen biaya daftar ulang. |
| 5 | Mencetak Laporan Keuangan | Mengekspor laporan rekapitulasi penerimaan uang pendaftaran untuk kepentingan audit/pembukuan. |

---

## 4.5. Activity Diagram

### 4.5.1 & 4.5.2 Activity Diagram Calon Siswa
*(Subbab a, b, c, d tidak ada perubahan)*

**e. Activity Diagram Calon Siswa Pembayaran**

**[REVISI GAMBAR 4.12: Ubah alur diagram menjadi: Pilih Menu Pembayaran -> Tampilkan Tagihan & Opsi Rekening Sekolah -> Upload Bukti Transfer Bank -> Update Status Pendaftaran Menjadi Menunggu Verifikasi]**

**Deskripsi Singkat (Ganti Paragraf 4.5.2 bagian akhir):**
Setelah siswa mengunggah dokumen persyaratan dasar, mereka dapat melihat rincian tagihan keuangan. Siswa diharuskan melakukan transfer secara manual ke rekening sekolah yang tertera, lalu mengunggah bukti transfer. Sistem akan menyimpan bukti tersebut dan memperbarui status menjadi menunggu verifikasi bendahara. Setelah status pembayaran divalidasi lunas oleh bendahara, siswa baru dapat mencetak bukti pendaftaran resmi.

### 4.5.3 Activity Diagram Admin
*(Tidak ada perubahan)*

### 4.5.4 Activity Diagram Bendahara
Aktor Bendahara menjalankan alur aktivitas yang berpusat pada penyelesaian transaksi keuangan, diawali dari proses masuk ke dasbor khusus bendahara. Setelah login divalidasi, bendahara membuka modul daftar tunggu pembayaran dan melakukan aktivitas pengecekan terhadap bukti transfer yang telah diunggah oleh calon siswa. Pada tahap ini terdapat percabangan evaluasi: jika bukti pembayaran sah dan nominal sesuai, bendahara menyetujui transaksi dan sistem mengubah status menjadi lunas, namun sebaliknya, sistem akan memperbarui status menjadi tertolak jika bukti tidak valid. Bendahara juga mengelola konfigurasi rincian biaya pendaftaran dan mengekspor rekapitulasi data keuangan.

*(Subbab a dan b tidak ada perubahan)*

**c. Activity Diagram Bendahara Memantau Midtrans**
**(HAPUS SUBBAB INI DAN GAMBAR 4.20 SECARA KESELURUHAN KARENA MIDTRANS DIHAPUS)**

*(Subbab d menjadi Subbab c: Cetak Laporan Keuangan)*

---

## 4.6. Sequence Diagram

### 4.6.2 Calon Siswa

*(Subbab a, b, c, d tidak ada perubahan)*

**e. Sequence Diagram Calon Siswa Pembayaran**

**[REVISI GAMBAR 4.29: Ganti flow Midtrans. Alurnya: Siswa -> Sistem: Akses halaman pembayaran. Sistem -> Database: Ambil tagihan. Sistem -> Siswa: Tampilkan tagihan dan rekening tujuan. Siswa -> Sistem: Submit Form Upload Bukti Transfer. Sistem -> Database: Update path bukti_transfer dan status=Pending. Sistem -> Siswa: Tampilkan notifikasi Menunggu Verifikasi.]**

### 4.6.4 Bendahara

*(Subbab a, b, c, d tidak ada perubahan khusus selain memastikan di gambar tidak ada tulisan sinkronisasi Midtrans)*

---

## 4.8 & 4.9 ERD dan Perancangan Basis Data

*(Struktur gambar ERD dan Tabel Relasi secara umum tidak perlu diubah karena tabel `payments` masih relevan untuk menampung metode pembayaran manual dan `bukti_transfer`)*

**Pada bagian Tabel 4.8 (Struktur Tabel Pembayaran):**
Penjelasan kolom `metode_pembayaran` disesuaikan menjadi: "Nama bank transfer yang dipilih pendaftar (contoh: BRI, BSI, dll)."
Kolom `bukti_transfer` disesuaikan menjadi: "Path direktori ke file unggahan bukti setoran/transfer siswa."

---

## 4.10. Perancangan UI/UX

### 4.10.1 Perancangan UI/UX Calon Siswa

**e. Tampilan Halaman Pembayaran dan Daftar Ulang**
**[REVISI GAMBAR 4.46: Sesuaikan tampilan (atau gunakan tangkapan layar UI terbaru) yang tidak menampilkan tombol Midtrans Snap, melainkan form upload bukti transfer/tombol Konfirmasi Manual]**

**Teks Deskripsi:**
Tampilan di atas merupakan perancangan antarmuka untuk Halaman Pembayaran dan Daftar Ulang. Bagian halaman menampilkan rincian total nominal tagihan pendaftaran. Antarmuka ini menyediakan informasi rekening bank resmi milik sekolah yang dituju. Di bagian bawah, disediakan form atau area bagi siswa untuk mengunggah berkas foto bukti setoran atau transfer bank. Setelah diunggah, sistem akan menandai transaksi sebagai Menunggu Verifikasi.

**f. Tampilan Pop-up Modal Gateway Pembayaran (Instruksi Virtual Account Midtrans)**
**(HAPUS SUBBAB INI DAN GAMBAR 4.47 KARENA TIDAK ADA LAGI POP-UP MIDTRANS)**

*(Subbab g menjadi Subbab f, dan h menjadi g)*

### 4.10.3 Perancangan UI/UX Bendahara

*(Subbab a, b, c, d, e tidak ada perubahan signifikan, cukup pastikan jika ada tangkapan layar yang bertuliskan "Midtrans" diganti dengan tangkapan layar UI terbaru)*

---

## 4.12. Pengujian Sistem (Black Box Testing)

Pengujian sistem ini menggunakan metode *Black Box Testing*. Pengujian ini berfokus pada pengujian persyaratan fungsionalitas sistem informasi PPDB SMP Muhammadiyah Kaliwiro tanpa perlu memperhatikan struktur kode internal program. Pengujian dilakukan untuk memastikan bahwa seluruh fungsi input, proses bisnis, manajemen data pendaftar, dan pelaporan berjalan secara valid sesuai dengan spesifikasi.

**(Pada daftar aktor pengguna utama di sistem PPDB, perbaiki poin 2 dan 4):**
2. **Calon Siswa:** Melakukan registrasi, login, pengisian formulir biodata, upload berkas, live chat panitia, **unggah bukti pembayaran daftar ulang**, dan cetak dokumen.
4. **Bendahara:** Memantau dashboard keuangan, **verifikasi unggahan pembayaran daftar ulang**, mengelola rincian biaya per jalur, konfigurasi rekening sekolah, dan ekspor laporan keuangan.

### 4.12.3 Pengujian Modul Calon Siswa (Pendaftaran, Dokumen, dan Pembayaran)
*(Gabungkan pengujian pembayaran ke bagian siswa)*

**[REVISI TABEL 4.16: Hapus Tabel 4.16 Pengujian Midtrans seutuhnya, lalu tambahkan skenario pembayaran manual ini ke dalam Tabel 4.15 pengujian Calon Siswa]**

*Tambahan Skenario di Tabel 4.15 (Pengujian Siswa):*
| ID Test | Fungsi / Fitur | Skenario Pengujian | Input Data | Hasil Yang Diharapkan | Status |
|---|---|---|---|---|---|
| TC-SISWA-08 | Upload Bukti Pembayaran | Calon siswa mengunggah foto bukti transfer bank pada halaman tagihan. | File `.jpg` bukti setoran | Sistem menerima unggahan, memperbarui status tagihan menjadi "Menunggu Verifikasi", dan menampilkannya di riwayat. | Valid |
| TC-SISWA-09 | Cetak Kuitansi Pembayaran | Siswa menekan tombol cetak kuitansi pada tagihan yang sudah disetujui (Lunas) oleh Bendahara. | Klik tombol Cetak Kuitansi | Browser mengunduh file PDF kuitansi pendaftaran resmi. | Valid |

### 4.12.6 Pengujian Modul Bendahara (Keuangan & Rincian Biaya)

**[REVISI TABEL 4.18: Hapus skenario pengecekan Webhook atau Simulasi Midtrans jika sebelumnya ada di draft. Gunakan skenario verifikasi manual murni seperti di bawah ini]**

| ID Test | Fungsi / Fitur | Skenario Pengujian | Input Data | Hasil Yang Diharapkan | Status |
|---|---|---|---|---|---|
| TC-BND-01 | Dashboard Keuangan | Mengakses dashboard Bendahara. | Login Bendahara | Menampilkan ringkasan total uang masuk, persentase pelunasan pembayaran. | Valid |
| TC-BND-02 | Verifikasi Pembayaran Manual | Bendahara membuka riwayat transaksi siswa, meninjau foto bukti transfer, dan menyetujuinya. | Klik "Setujui" pada transaksi ID tertentu | Status transaksi siswa berubah menjadi "Lunas", nominal tagihan masuk ke rekap pendapatan. | Valid |
| TC-BND-03 | Penolakan Bukti Transfer | Bendahara menolak unggahan bukti karena foto tidak jelas atau nominal tidak sesuai. | Klik "Tolak", masukkan catatan | Status transaksi berubah menjadi "Ditolak", siswa bisa mengunggah ulang. | Valid |
| TC-BND-04 | Ekspor Laporan | Mengunduh rekapitulasi data pendaftar yang sudah lunas. | Klik "Ekspor PDF" | File PDF terunduh berisi data siswa lunas dan total pendapatan. | Valid |

---
**(Teks Lanjutan untuk Kesimpulan Pengujian di halaman akhir Bab 4 tetap dipertahankan, hapus kalimat nomor 3 yang menyebutkan Integrasi Midtrans Webhook.)**

> Kesimpulan Nomor 3 diubah menjadi:
> 3. Alur transaksi pembayaran daftar ulang manual berjalan lancar, dimulai dari unggahan bukti pendaftar hingga verifikasi status dan pencetakan laporan oleh modul bendahara secara *real-time*.

---
*(Selesai)*
