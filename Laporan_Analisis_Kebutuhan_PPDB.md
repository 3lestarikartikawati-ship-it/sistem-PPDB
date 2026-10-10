4.1. Analisis Kebutuhan Sistem
Pada tahapan awal pengembangan sistem, dilakukan proses analisis kebutuhan untuk memahami secara menyeluruh fitur-fitur yang harus disediakan oleh Sistem Informasi Penerimaan Peserta Didik Baru (PPDB) Berbasis Web. Analisis dilakukan melalui metode observasi dan wawancara dengan pihak panitia penerimaan, yaitu pihak administrasi sekolah dan bendahara. Kebutuhan ini dibagi menjadi kebutuhan fungsional dan non-fungsional.

Kebutuhan Fungsional
Kebutuhan fungsional mendeskripsikan fungsi atau layanan spesifik yang harus disediakan oleh sistem untuk setiap aktor yang terlibat.

a. Untuk Calon Siswa (Pendaftar):
- Sistem harus memungkinkan calon siswa melakukan registrasi akun dan mengakses *dashboard* melalui proses login yang divalidasi (termasuk via Google OAuth).
- Sistem harus memfasilitasi calon siswa untuk memilih jalur pendaftaran (Reguler, Prestasi, Afirmasi) dan mengisi formulir biodata secara dinamis.
- Sistem harus memungkinkan calon siswa mengunggah dokumen persyaratan sesuai dengan jalur pendaftaran yang dipilih.
- Sistem harus menyediakan portal pembayaran pendaftaran yang terintegrasi dengan *Payment Gateway* (Midtrans) maupun opsi transfer bank.
- Sistem harus menampilkan pengumuman status kelulusan, penempatan kelas (*plotting*), dan memungkinkan pencetakan bukti pendaftaran.

b. Untuk Admin:
- Admin harus memiliki akses ke *dashboard* khusus yang dilindungi oleh proses login.
- Admin harus dapat mengelola pengaturan jalur pendaftaran, termasuk mengaktifkan/menonaktifkan jalur dan menentukan syarat dokumen wajib secara dinamis.
- Admin harus dapat melakukan verifikasi data biodata dan dokumen persyaratan yang diunggah oleh pendaftar.
- Admin harus dapat melakukan manajemen penempatan kelas (*plotting*) bagi siswa yang dinyatakan lolos seleksi dan mengekspor data kelas ke dalam format PDF.
- Sistem harus memungkinkan admin mengelola data master pengguna dan mereset data pendaftar (*database cleaning*) untuk persiapan periode PPDB baru.

c. Untuk Bendahara:
- Bendahara harus memiliki akses ke *dashboard* keuangan untuk memonitor lalu lintas transaksi pembayaran pendaftaran.
- Sistem harus memungkinkan bendahara untuk memverifikasi pembayaran yang dilakukan secara manual (transfer bank) jika diperlukan.
- Bendahara harus dapat melihat rekapitulasi data pembayaran otomatis via Midtrans dan mencetak laporan keuangan PPDB.

Kebutuhan Non-Fungsional
Kebutuhan non-fungsional mendefinisikan kriteria kualitas dan operasional dari sistem.

1. Kemudahan Penggunaan (Usability): Antarmuka pengguna (UI) harus dirancang agar modern, intuitif, responsif, dan ramah pengguna, dengan efek visual yang halus sehingga mudah diakses melalui perangkat desktop maupun mobile oleh calon siswa.
2. Performa (Performance): Sistem harus memiliki waktu respons yang cepat, terbebas dari masalah *loading* tak terbatas (*infinite loading*) pada proses verifikasi atau saat memuat data dalam jumlah besar.
3. Keamanan (Security): Sistem harus menggunakan enkripsi kata sandi, autentikasi aman (termasuk penyimpanan token OAuth yang memadai), dan hak akses berbasis peran (*Role-Based Access Control*) untuk melindungi kerahasiaan data calon siswa.
4. Skalabilitas (Scalability): Struktur basis data harus fleksibel untuk menampung format metode pembayaran yang dinamis dan arsitektur harus sanggup menghadapi lonjakan akses pada masa puncak pendaftaran.

4.2. Perancangan Sistem
Pada tahap perancangan, dilakukan penyusunan arsitektur sistem yang mencakup desain antarmuka pengguna (UI), struktur basis data, serta alur proses pendaftaran PPDB. Perancangan ini bertujuan untuk membangun sistem yang efektif, efisien, dan sesuai dengan prosedur standar sekolah. Beberapa langkah yang dilakukan adalah sebagai berikut:

1) Perancangan Antarmuka Pengguna (UI)

Antarmuka pengguna dirancang untuk mengakomodasi kebutuhan Calon Siswa, Admin, dan Bendahara dengan pendekatan desain yang profesional dan responsif. Beberapa fitur antarmuka meliputi:

- Halaman Landing Page & Autentikasi: Portal informasi pendaftaran dan pintu masuk sistem yang dilengkapi dengan opsi login reguler maupun *Single Sign-On* (Google).
- Halaman Dashboard Calon Siswa: Menampilkan alur pendaftaran, status pembayaran, formulir pemilihan jalur (Reguler/Prestasi/Afirmasi), serta area unggah dokumen persyaratan yang spesifik per jalur.
- Halaman Dashboard Admin & Verifikasi: Menampilkan metrik analitik pendaftar, kontrol *toggle* jalur pendaftaran, antarmuka verifikasi berkas, dan fitur manajemen penempatan kelas (*plotting*).
- Halaman Dashboard Bendahara: Area khusus untuk rekonsiliasi data pembayaran otomatis Midtrans dan konfirmasi pembayaran manual (BRI, BSI, Jateng).
- Halaman Laporan dan Cetak PDF: Fitur untuk me-*render* laporan daftar siswa yang diterima per kelas ke dalam dokumen PDF resmi sebagai arsip sekolah.

2) Perancangan Basis Data

Struktur basis data relasional dirancang menggunakan MySQL untuk menjamin integritas data operasional PPDB:

- Tabel Pengguna (Users / Roles): Menyimpan kredensial autentikasi (termasuk ekstensi *field token* OAuth) dan membedakan hak akses (*role*) antara Admin, Bendahara, atau Siswa.
- Tabel Calon Siswa / Pendaftar (Students): Berisi data identitas lengkap, asal sekolah, dan status tahapan pendaftaran.
- Tabel Jalur & Persyaratan Pendaftaran (Registration Paths): Menyimpan konfigurasi dinamis mengenai jalur PPDB mana yang sedang aktif beserta dokumen wajib yang mengikat.
- Tabel Dokumen (Documents): Mengelola path direktori unggahan file persyaratan siswa dan status validasinya.
- Tabel Pembayaran (Payments): Mencatat transaksi pendaftaran, tipe metode pembayaran (format *string* dinamis untuk Midtrans), dan status pelunasan.
- Tabel Kelas & Plotting (Classes): Menyimpan data rombongan belajar dan relasi pembagian kelas bagi siswa yang telah diterima.

4.3. Tahapan Analisis (Spesifikasi Kebutuhan Per Aktor)
Berdasarkan hasil analisis kebutuhan alur kerja operasional, berikut adalah spesifikasi kebutuhan interaksi spesifik dari sistem Informasi PPDB:

Halaman / Kewenangan Calon Siswa:
- Calon siswa dapat melakukan pendaftaran akun baru atau login secara instan menggunakan akun Google.
- Calon siswa dapat memilih jalur pendaftaran (Reguler, Prestasi, Afirmasi) yang disediakan oleh sistem.
- Calon siswa dapat melengkapi formulir biodata dan mengunggah dokumen persyaratan sesuai dengan jalur yang dipilihnya.
- Calon siswa dapat menyelesaikan tagihan pembayaran pendaftaran secara instan via Midtrans atau merujuk pada instruksi transfer bank manual.
- Calon siswa dapat memantau status verifikasi dokumen (Diterima/Menunggu/Ditolak).
- Calon siswa dapat melihat hasil *plotting* kelas setelah dinyatakan lulus.
- Calon siswa dapat mencetak bukti pendaftaran resmi dari sistem.

Halaman / Kewenangan Admin:
- Admin dapat melakukan pengaturan ketersediaan (Buka/Tutup) pada masing-masing jalur pendaftaran.
- Admin dapat mengonfigurasi dokumen wajib apa saja yang diperlukan untuk pendaftar pada jalur tertentu.
- Admin dapat melakukan proses verifikasi kelayakan dokumen pendaftar (*Approve/Reject*).
- Admin dapat melakukan proses penempatan/pembagian kelas (*plotting*) bagi calon siswa yang lolos seleksi.
- Admin dapat mengekspor dan mencetak daftar siswa per kelas ke dalam dokumen PDF.
- Admin dapat melakukan *reset* atau pembersihan data pendaftar (*database wipe*) dengan aman untuk persiapan siklus PPDB tahun berikutnya.

Halaman / Kewenangan Bendahara:
- Bendahara dapat melihat mutasi dan riwayat pembayaran pendaftar secara *real-time* hasil integrasi Midtrans.
- Bendahara dapat melakukan verifikasi silang dan memperbarui status pembayaran secara manual bagi siswa yang menggunakan metode transfer konvensional.
- Bendahara dapat mengunduh laporan rekapitulasi penerimaan dana pendaftaran untuk keperluan pembukuan dan audit sekolah.
- Bendahara dapat melihat rincian detail metode pembayaran yang digunakan oleh setiap calon siswa.
