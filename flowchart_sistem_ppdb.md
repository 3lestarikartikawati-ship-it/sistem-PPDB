# 📊 Flowchart Sistem PPDB — SMP Muhammadiyah Kaliwiro

> Dokumen ini menggambarkan **seluruh alur kerja sistem PPDB** secara lengkap, mulai dari arsitektur, autentikasi, pendaftaran, pembayaran, hingga manajemen admin.

---

## 1. Arsitektur Sistem Keseluruhan

```mermaid
graph TB
    subgraph PUBLIC["🌐 Halaman Publik"]
        B[Beranda]
        PR[Profil]
        KG[Kegiatan]
        PS[Prestasi]
        BR[Berita]
        IF[Informasi PPDB]
    end

    subgraph AUTH["🔐 Autentikasi"]
        LG[Login Manual]
        RG[Register Akun]
        GO[Google OAuth]
    end

    subgraph SISWA["🎓 Dashboard Siswa"]
        SD[Dashboard]
        FP[Form Pendaftaran]
        PY[Pembayaran / Daftar Ulang]
        CT[Cetak Bukti PDF]
        SK[Cetak SK Diterima]
        MS[Pesan ke Admin]
    end

    subgraph BENDAHARA["💰 Dashboard Bendahara"]
        BD[Dashboard Keuangan]
        VP[Verifikasi Pembayaran]
        RI[Rincian Biaya]
        SK2[Pengaturan Keuangan]
        EX1[Export Data CSV/PDF]
    end

    subgraph ADMIN["⚙️ Dashboard Admin"]
        AD[Dashboard + Statistik]
        DS[Data Pendaftar]
        VS[Verifikasi Pendaftaran]
        KL[Pembagian Kelas]
        CMS[Manajemen Konten]
        FAQ[Manajemen FAQ]
        AM[Pesan / Chat]
        ST[Pengaturan Sistem]
        EX2[Export Data CSV/PDF]
        VP2[Verifikasi Pembayaran]
    end

    PUBLIC --> AUTH
    AUTH -->|role: siswa| SISWA
    AUTH -->|role: bendahara| BENDAHARA
    AUTH -->|role: admin| ADMIN
```

---

## 2. Alur Autentikasi & Role-Based Redirect

```mermaid
flowchart TD
    A([Pengunjung Buka Website]) --> B{Sudah Login?}
    B -->|Tidak| C[Halaman Publik]
    C --> D{Ingin Mendaftar?}
    D -->|Ya| E[Halaman Register]
    D -->|Sudah punya akun| F[Halaman Login]

    E --> G[Isi Nama, Email, No HP, Password]
    G --> H[Akun Dibuat - Role: Siswa]
    H --> I[Auto Login]

    F --> J{Metode Login}
    J -->|Email + Password| K[Validasi Kredensial]
    J -->|Google OAuth| L[Redirect ke Google]
    L --> M[Google Callback]
    M --> N{Email sudah terdaftar?}
    N -->|Ya| O[Update Google ID & Token]
    N -->|Tidak| P[Buat Akun Baru - Role: Siswa]
    O --> I
    P --> I
    K -->|Berhasil| I

    I --> Q{Cek Role User}
    Q -->|admin| R[🔧 Admin Dashboard]
    Q -->|bendahara| S[💰 Bendahara Dashboard]
    Q -->|siswa| T[🎓 Siswa Dashboard]

    K -->|Gagal| U[Tampilkan Error]
    U --> F

    style R fill:#e74c3c,color:#fff
    style S fill:#f39c12,color:#fff
    style T fill:#2ecc71,color:#fff
```

---

## 3. Alur Pendaftaran Siswa (Lengkap)

```mermaid
flowchart TD
    A([Siswa Login]) --> B[Dashboard Siswa]
    B --> C{Sudah Mengisi Biodata?}
    C -->|Ya| D[Lihat Status Pendaftaran]
    C -->|Tidak| E[Klik Menu Pendaftaran]

    E --> F{Cek Jadwal Gelombang}
    F -->|Dalam Periode Gel 1| G[Gelombang = 1]
    F -->|Dalam Periode Gel 2| H[Gelombang = 2]
    F -->|Di Luar Jadwal| I[❌ Pendaftaran Ditutup - Redirect]

    G --> J[Tampilkan Form Pendaftaran]
    H --> J

    J --> K["Isi Data Pribadi:
    - Nama Lengkap, NISN
    - Tempat & Tanggal Lahir
    - Jenis Kelamin, Agama
    - Alamat Lengkap"]

    K --> L["Isi Data Orang Tua:
    - Nama Ayah & Ibu
    - Pekerjaan Orang Tua
    - No HP Orang Tua"]

    L --> M["Isi Data Akademik:
    - Asal Sekolah
    - Jalur: Reguler/Prestasi/Afirmasi
    - Nilai Rapor
    - Prestasi (opsional)"]

    M --> N["Upload Dokumen:
    - Pas Foto (JPG/PNG)
    - Kartu Keluarga (PDF/JPG)
    - Ijazah/SKL (PDF/JPG)
    - Bukti Rapor (PDF/JPG)
    - Bukti Prestasi (PDF/JPG)"]

    N --> O[✅ Centang Persetujuan]
    O --> P[Submit Form]

    P --> Q{Cek Kuota Gelombang}
    Q -->|Kuota Tersedia| R["Status = Menunggu"]
    Q -->|Kuota Penuh| S["Status = Cadangan"]

    R --> T["Generate Nomor Pendaftaran
    Format: PPDB-2026-0001"]
    S --> T

    T --> U[📧 Kirim Email Konfirmasi Pendaftaran]
    U --> V[Redirect ke Dashboard + Pesan Sukses]
    V --> D

    D --> W{Status Pendaftaran}
    W -->|Menunggu| X["⏳ Menunggu Verifikasi Admin"]
    W -->|Diterima| Y["✅ Akses: Cetak Bukti, SKD, Pembayaran"]
    W -->|Ditolak| Z["❌ Ditolak + Catatan Admin"]
    W -->|Cadangan| AA["📋 Masuk Daftar Cadangan"]

    style I fill:#e74c3c,color:#fff
    style Y fill:#2ecc71,color:#fff
    style Z fill:#e74c3c,color:#fff
```

---

## 4. Alur Verifikasi Pendaftaran oleh Admin

```mermaid
flowchart TD
    A([Admin Login]) --> B[Dashboard Admin]
    B --> C[Menu Data Pendaftar]

    C --> D["Filter & Pencarian:
    - By Jalur: Reguler/Prestasi/Afirmasi
    - By Status: Menunggu/Diterima/Ditolak
    - By Nama / No Pendaftaran"]

    D --> E[Lihat Daftar Pendaftar + Pagination]
    E --> F[Klik Detail Siswa]

    F --> G["Review Data Lengkap:
    - Biodata Pribadi
    - Data Orang Tua
    - Dokumen yang Diupload
    - Nilai Rapor & Prestasi"]

    G --> H{Keputusan Admin}
    H -->|Terima| I["Status → Diterima"]
    H -->|Tolak| J["Status → Ditolak + Catatan Alasan"]
    H -->|Cadangan| K["Status → Cadangan"]
    H -->|Pending| L["Status → Menunggu"]

    I --> M[✅ Siswa Bisa Akses Daftar Ulang]
    J --> N[❌ Siswa Lihat Status Ditolak]

    M --> O["Export Data:
    - CSV Spreadsheet
    - PDF Laporan Resmi"]

    style I fill:#2ecc71,color:#fff
    style J fill:#e74c3c,color:#fff
    style K fill:#f39c12,color:#fff
```

---

## 5. Alur Pembayaran Daftar Ulang

```mermaid
flowchart TD
    A(["Siswa Berstatus Diterima"]) --> B[Menu Pembayaran]
    B --> C["Lihat Rincian Biaya per Jalur
    (Dinamis sesuai jalur pendaftaran)"]

    C --> D{Pilih Metode Pembayaran}

    D -->|Transfer Bank| E["Isi Data Transfer:
    - Bank Asal & Nama Rekening
    - Jumlah Bayar & Tanggal
    - Upload Bukti Transfer"]
    D -->|QRIS| F["Upload Bukti Scan QRIS
    + Jumlah & Tanggal"]
    D -->|Tunai| G["Upload Bukti Bayar Tunai
    + Jumlah & Tanggal"]
    D -->|Midtrans Gateway| H["Otomatis:
    Buat Snap Token → Bayar via Gateway"]

    E --> I["Status Pembayaran = Menunggu Verifikasi"]
    F --> I
    G --> I

    H --> J{Proses Midtrans}
    J -->|Settlement| K["Status = Lunas (Otomatis via Webhook)"]
    J -->|Pending| L["Status = Menunggu"]
    J -->|Deny/Expire/Cancel| M["Status = Ditolak"]

    I --> N["Menunggu Verifikasi
    oleh Bendahara / Admin"]

    subgraph SIM["🧪 Simulator (Sandbox Mode)"]
        S1[Simulator BSI VA]
        S2[Simulator QRIS]
        S1 --> S3["Status = Lunas (Instan)"]
        S2 --> S3
    end

    D -->|Simulator| SIM

    K --> O["📧 Email Notifikasi Pembayaran Lunas"]
    N --> P{Verifikasi oleh Bendahara/Admin}
    P -->|Terima| Q["Status = Lunas"]
    P -->|Tolak| R["Status = Ditolak + Catatan"]
    Q --> O
    O --> T["🧾 Cetak Kuitansi Resmi"]

    style K fill:#2ecc71,color:#fff
    style Q fill:#2ecc71,color:#fff
    style R fill:#e74c3c,color:#fff
    style S3 fill:#3498db,color:#fff
```

---

## 6. Alur Kerja Bendahara

```mermaid
flowchart TD
    A([Bendahara Login]) --> B[Dashboard Keuangan]

    B --> C["📊 Statistik:
    - Total Diterima
    - Sudah Bayar / Belum
    - Pending Verifikasi
    - Total Dana Masuk"]

    B --> D["📈 Chart:
    - Tren Pembayaran 7 Hari
    - Breakdown Metode Pembayaran"]

    B --> E[Menu Verifikasi Pembayaran]
    E --> F["Filter:
    - By Status Bayar
    - By Jalur Pendaftaran
    - By Pencarian Nama"]
    F --> G[Lihat Daftar Siswa Diterima + Status Bayar]
    G --> H[Review Bukti Pembayaran]
    H --> I{Keputusan}
    I -->|Lunas| J[✅ Verifikasi Lunas]
    I -->|Tolak| K[❌ Tolak + Catatan]

    B --> L[Menu Rincian Biaya]
    L --> M["CRUD Item Biaya:
    - Nama Item & Nominal
    - Berlaku: Semua/Reguler/Prestasi/Afirmasi
    - Aktif / Nonaktif"]

    B --> N[Menu Pengaturan Keuangan]
    N --> O["Setting: Rekening Sekolah,
    Nama Bank, Instruksi Bayar"]

    B --> P["Export Laporan:
    - CSV Data Belum Lunas
    - PDF Data Belum Lunas"]

    style J fill:#2ecc71,color:#fff
    style K fill:#e74c3c,color:#fff
```

---

## 7. Alur Pembagian Kelas (Plotting)

```mermaid
flowchart TD
    A([Admin]) --> B[Menu Pembagian Kelas]

    B --> C["Daftar Siswa Eligible:
    Status = Diterima
    + Pembayaran = Lunas
    + Belum Punya Kelas"]

    C --> D[Pilih Satu/Beberapa Siswa - Checkbox]
    D --> E["Input Nama Kelas
    (contoh: VII-A, VII-B)"]
    E --> F[Klik Tugaskan]
    F --> G[✅ Siswa Ditugaskan ke Kelas]

    B --> H["Daftar Kelas Terisi
    (Grouped by Nama Kelas)"]
    H --> I{Aksi}
    I -->|Keluarkan Siswa| J[Siswa Kembali ke Unassigned]
    I -->|Export PDF| K["📄 Download Daftar Siswa per Kelas (PDF)"]

    style G fill:#2ecc71,color:#fff
```

---

## 8. Fitur Tambahan Admin

```mermaid
flowchart LR
    subgraph CMS["📝 CMS Konten"]
        C1[Buat Konten Baru]
        C2[Edit Konten]
        C3[Hapus Konten]
        C4["Tipe: hero, about, profil,
        kegiatan, prestasi, berita, informasi"]
    end

    subgraph FAQ_M["❓ Manajemen FAQ"]
        F1[Tambah FAQ]
        F2[Edit FAQ]
        F3[Hapus FAQ]
        F4[Atur Urutan]
    end

    subgraph MSG["💬 Pesan / Chat"]
        M1[Lihat Inbox Siswa]
        M2[Baca Pesan Masuk]
        M3[Balas Pesan]
        M4[Tandai Sudah Dibaca]
    end

    subgraph SET["⚙️ Pengaturan Sistem"]
        S1["Jadwal Gelombang 1 & 2
        (Tanggal Mulai & Selesai)"]
        S2["Kuota per Gelombang"]
        S3["Tanggal Pengumuman"]
        S4["Logo & Identitas Sekolah"]
        S5["Reset Pengaturan"]
    end
```

---

## 9. Entity Relationship Diagram (Database)

```mermaid
erDiagram
    USERS {
        int id PK
        string name
        string email UK
        string password
        string no_hp
        enum role "siswa | admin | bendahara"
        string google_id
        text google_token
        text google_refresh_token
    }

    STUDENTS {
        int id PK
        int user_id FK
        string nomor_pendaftaran UK
        string nama_lengkap
        string nisn
        string tempat_lahir
        date tanggal_lahir
        enum jenis_kelamin "L | P"
        string agama
        text alamat
        string nama_ayah
        string nama_ibu
        string pekerjaan_orang_tua
        string no_hp_orang_tua
        string asal_sekolah
        enum jalur_pendaftaran "Reguler | Prestasi | Afirmasi"
        decimal nilai_rapor
        string prestasi
        string pas_foto
        string kartu_keluarga
        string ijazah_skl
        string bukti_rapor
        string bukti_prestasi
        enum status "menunggu | diterima | ditolak | cadangan"
        string catatan
        string gelombang
        string kelas
    }

    PAYMENTS {
        int id PK
        int student_id FK
        string metode_pembayaran
        decimal jumlah_bayar
        date tanggal_bayar
        string bank_asal
        string nama_rekening
        string bukti_transfer
        enum status "menunggu | lunas | ditolak"
        string catatan
        datetime verified_at
        int verified_by FK
        string snap_token
        string midtrans_order_id
    }

    PAYMENT_ITEMS {
        int id PK
        string name
        decimal amount
        enum jalur "Semua | Reguler | Prestasi | Afirmasi"
        boolean is_active
    }

    MESSAGES {
        int id PK
        int student_id FK
        text message
        enum sender "student | admin"
        boolean is_read
    }

    CONTENTS {
        int id PK
        string type
        string title
        text body
        string image
        boolean is_active
    }

    SETTINGS {
        int id PK
        string key UK
        string value
        string type
    }

    FAQS {
        int id PK
        string question
        text answer
        int order
    }

    USERS ||--o| STUDENTS : "has one"
    STUDENTS ||--o{ PAYMENTS : "has many"
    STUDENTS ||--o{ MESSAGES : "has many"
    USERS ||--o{ PAYMENTS : "verified_by"
```

---

## 10. Alur Lengkap End-to-End (Overview)

```mermaid
flowchart TD
    A([🌐 Pengunjung]) -->|Buka Website| B[Landing Page PPDB]
    B -->|Lihat Info| C[Halaman Publik: Profil, Kegiatan, Prestasi, Berita]
    B -->|Daftar Akun| D[Register / Google OAuth]
    D --> E[Login → Siswa Dashboard]

    E -->|1️⃣ Isi Biodata| F["Form Pendaftaran
    + Upload Dokumen"]
    F -->|Submit| G["📧 Email Konfirmasi
    Status: Menunggu"]

    G -->|Admin Review| H{Keputusan Admin}
    H -->|✅ Diterima| I[Status: Diterima]
    H -->|❌ Ditolak| J[Status: Ditolak]
    H -->|📋 Cadangan| K[Status: Cadangan]

    I -->|2️⃣ Daftar Ulang| L["Pembayaran via:
    Transfer / QRIS / Midtrans"]
    L -->|Upload Bukti| M[Menunggu Verifikasi]

    M -->|Bendahara/Admin| N{Verifikasi Bayar}
    N -->|✅ Lunas| O["📧 Email Notifikasi Lunas
    🧾 Cetak Kuitansi"]
    N -->|❌ Ditolak| P[Bayar Ulang]

    O -->|3️⃣ Plotting Kelas| Q["Admin Tugaskan ke Kelas
    (VII-A, VII-B, dst)"]
    Q --> R["📄 Export Daftar Kelas PDF
    🎓 Proses Selesai!"]

    style I fill:#2ecc71,color:#fff
    style J fill:#e74c3c,color:#fff
    style O fill:#2ecc71,color:#fff
    style R fill:#9b59b6,color:#fff
```

---

## Ringkasan Fitur per Role

| No | Fitur | Siswa | Bendahara | Admin |
|:--:|-------|:-----:|:---------:|:-----:|
| 1 | Dashboard + Statistik | ✅ | ✅ | ✅ |
| 2 | Form Pendaftaran | ✅ | — | — |
| 3 | Upload Dokumen | ✅ | — | — |
| 4 | Pembayaran Daftar Ulang | ✅ | — | — |
| 5 | Cetak Bukti Pendaftaran | ✅ | — | — |
| 6 | Cetak SK Diterima (PDF) | ✅ | — | — |
| 7 | Cetak Kuitansi Pembayaran | ✅ | — | — |
| 8 | Kirim Pesan ke Admin | ✅ | — | — |
| 9 | Verifikasi Pendaftaran | — | — | ✅ |
| 10 | Verifikasi Pembayaran | — | ✅ | ✅ |
| 11 | Kelola Rincian Biaya (CRUD) | — | ✅ | — |
| 12 | Pengaturan Keuangan | — | ✅ | — |
| 13 | Pembagian Kelas (Plotting) | — | — | ✅ |
| 14 | CMS Konten Website | — | — | ✅ |
| 15 | Manajemen FAQ | — | — | ✅ |
| 16 | Balas Pesan Siswa | — | — | ✅ |
| 17 | Pengaturan Sistem | — | — | ✅ |
| 18 | Export CSV / PDF | — | ✅ | ✅ |

---

## Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| Backend | Laravel (PHP) |
| Frontend | Blade Templates + Bootstrap 5 |
| Database | MySQL |
| Auth | Laravel Breeze + Google OAuth (Socialite) |
| Payment Gateway | Midtrans (Snap.js) + Simulator BSI/QRIS |
| PDF Generator | DomPDF (barryvdh/laravel-dompdf) |
| Email | Laravel Mail |
| Build Tool | Vite |
