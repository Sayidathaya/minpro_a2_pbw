# Portfolio_Part2 – Sayid Rafi A’thaya

## 📌 Deskripsi Project

Website ini adalah **portofolio personal dinamis** milik Sayid Rafi A'thaya, seorang Frontend Developer & UI Designer dari Samarinda, Kalimantan Timur. Website dibangun sebagai tugas akhir mata kuliah Pemrograman Web dengan tujuan mengimplementasikan data dari database ke tampilan website secara dinamis — artinya seluruh konten website diambil langsung dari database MySQL, bukan hardcode di dalam kode.

Website ini terdiri dari dua sisi utama:
- **Sisi Publik (User)** — Halaman yang bisa dilihat oleh siapa saja tanpa perlu login, menampilkan profil, skills, pengalaman, pendidikan, proyek, dan sertifikat secara menarik dan responsif.
- **Sisi Admin** — Panel khusus yang hanya bisa diakses oleh admin (pemilik portofolio) setelah login, digunakan untuk mengelola seluruh isi konten website melalui fitur CRUD (Create, Read, Update, Delete).

Website: https://sayidathaya.github.io/minpro_a1_pbw/

---

# TAMPILAN

<img width="1919" height="968" alt="Image" src="https://github.com/user-attachments/assets/717d8126-3e4c-4e4f-9745-2a33efd7692c" />

<img width="1919" height="968" alt="Image" src="https://github.com/user-attachments/assets/882e50c0-1e82-45ff-b5bf-f62a58651430" />

<img width="1919" height="967" alt="Image" src="https://github.com/user-attachments/assets/4dfce3b0-d176-4967-97e5-a5d35eddf83b" />

---

### Teknologi yang Digunakan

| Teknologi | Kegunaan |
|-----------|---------|
| **PHP 8+** | Backend, routing, logika CRUD, session |
| **MySQL** | Database penyimpanan semua data konten |
| **PDO** | Koneksi database yang aman (prepared statement) |
| **Bootstrap 5** | Framework CSS untuk tampilan responsif |
| **Vue JS 3** | Interaktivitas frontend (filter, tab, animasi) |
| **Bootstrap Icons** | Ikon-ikon pada UI |
| **Google Fonts (Syne + DM Sans)** | Tipografi premium |

### Pola Arsitektur

Website menggunakan pola **MVC (Model - View - Controller)**:
- `app/models/` — Kelas model untuk setiap tabel database
- `admin/*.php` & `*.php` di root — Berperan sebagai View sekaligus Controller
- `config/koneksi.php` — Koneksi database terpisah, di-include menggunakan `require_once`
- `config/session.php` — Helper autentikasi dan session management

---

## 👤 Fitur Sisi User (Publik)

Pengunjung website tidak perlu login untuk mengakses halaman publik. Berikut fitur yang tersedia:

### 1. Halaman Beranda (Hero Section)
- Menampilkan foto profil, nama lengkap, dan jabatan/title yang diambil dari database
- Tombol navigasi ke bagian Proyek dan Kontak
- Link media sosial (email, GitHub, LinkedIn, telepon)
- Animasi latar belakang grid, efek ring berputar pada foto profil
- Indikator "Available for Work" dengan dot hijau beranimasi

### 2. Halaman About (Tentang Saya)
- Menampilkan foto hero, deskripsi/bio, email, telepon, dan lokasi dari database
- **Skills Bar** — Daftar skill dengan progress bar animasi yang levelnya diambil dari database
- **Tab Pengalaman & Pendidikan** — Toggle antara daftar pengalaman kerja dan riwayat pendidikan menggunakan Vue JS (SPA-like, tanpa reload halaman)
- Setiap data pengalaman dan pendidikan ditampilkan dalam format timeline yang rapi

### 3. Halaman Proyek (Portfolio)
- Menampilkan semua proyek dalam format card grid
- **Filter Kategori** — Tombol filter (Semua / Web / Mobile / Design) untuk menyaring proyek berdasarkan kategori, tanpa reload halaman
- Setiap card menampilkan: gambar, kategori, judul, deskripsi singkat, tech stack, dan link demo/GitHub
- Badge **"Featured"** untuk proyek yang ditandai unggulan
- Tombol **Detail** yang mengarah ke halaman detail proyek tersendiri

### 4. Halaman Detail Proyek
- Halaman terpisah (`project-detail.php?id=X`) yang menampilkan informasi lengkap sebuah proyek
- Gambar besar, deskripsi lengkap, tech stack, link demo & source code
- Breadcrumb navigasi: Home → Projects → Nama Proyek
- Tanggal pembuatan dan status Featured

### 5. Halaman Sertifikat
- Menampilkan semua sertifikat dalam format card grid
- Setiap card menampilkan: gambar sertifikat, nama penerbit, judul, deskripsi, dan tanggal terbit
- Tombol **"Lihat"** yang mengarahkan ke URL sertifikat online (Google Drive, Credly, dsb.) — hanya muncul jika URL diisi
- Efek hover dengan animasi naik pada card

### 6. Halaman Kontak (Form Kirim Pesan)
- Form kontak yang bisa diisi oleh pengunjung (nama, email, pesan)
- Data yang dikirim tersimpan ke tabel `thankyou` di database dan bisa dilihat admin
- Menampilkan informasi kontak (email, telepon, lokasi) dari database
- Flash message sukses/gagal setelah pengiriman

### 7. Navigasi & UX
- Navbar sticky dengan efek blur saat discroll
- Active link highlight otomatis sesuai section yang sedang dilihat
- Smooth scroll ke setiap section
- Tampilan fully responsif di mobile, tablet, dan desktop
- Animasi fade-in saat elemen masuk ke viewport (Intersection Observer)
- Dark theme premium dengan aksen merah crimson

---

## 🔐 Fitur Sisi Admin

Admin harus login terlebih dahulu di `login.php`. Setelah login, admin dapat mengakses panel di `admin/index.php`.

### Login & Autentikasi
- Sistem login dengan validasi username dan password menggunakan `password_verify()` (bcrypt)
- Session management — admin tetap login selama session aktif
- Proteksi halaman admin: semua halaman di folder `admin/` memanggil `requireAdmin()`, jika belum login otomatis redirect ke halaman login
- Tombol Logout yang menghancurkan session sepenuhnya
- Flash message notifikasi sukses/error setelah setiap aksi CRUD

### Dashboard Admin
- Statistik ringkasan: jumlah proyek, sertifikat, skills, dan pesan masuk
- Badge notifikasi pesan belum dibaca (warna merah) di sidebar dan stat card
- Tabel **Proyek Terbaru** dan **Pesan Terbaru** untuk akses cepat
- Tombol **Aksi Cepat** (Tambah Proyek, Tambah Sertifikat, Lihat Pesan, dsb.)
- Sidebar navigasi dengan highlight halaman aktif
- Tombol toggle sidebar (collapse/expand)
- Link "Lihat Website" untuk preview hasil di tab baru

### CRUD About
- Edit nama lengkap, title/jabatan, deskripsi/bio, email, telepon, lokasi
- Upload foto profil (tampil di hero section website)
- Upload gambar hero (tampil di about section website)
- Preview gambar saat ini ditampilkan di bawah input upload

### CRUD Skills
- Tambah, edit, hapus skill
- Field: Nama skill, Level (0–100), Kategori (Frontend/Backend/dsb.), Urutan tampil
- Progress bar mini di tabel admin untuk visualisasi level

### CRUD Pengalaman (Experience)
- Tambah, edit, hapus data pengalaman kerja
- Field: Posisi/Jabatan, Perusahaan/Tempat, Periode (contoh: "2023 - Present"), Deskripsi, Urutan tampil

### CRUD Pendidikan (Education)
- Tambah, edit, hapus riwayat pendidikan
- Field: Nama Institusi, Jenjang/Gelar, Bidang Studi, Tahun Mulai, Tahun Selesai, Deskripsi, Urutan tampil

### CRUD Proyek (Projects)
- Tambah, edit, hapus proyek
- Field: Judul, Deskripsi, Tech Stack (pisah koma), Gambar (upload), URL Demo, URL GitHub, Kategori, Featured (centang)
- Upload gambar proyek langsung dari form
- Saat hapus, file gambar di server ikut dihapus otomatis

### CRUD Sertifikat (Certificates)
- Tambah, edit, hapus sertifikat
- Field: Judul, Penerbit/Issuer, Deskripsi, Gambar (upload), Tanggal Terbit, URL Sertifikat Online
- Upload gambar/scan sertifikat
- URL digunakan untuk tombol "Lihat" di halaman publik

### Kelola Pesan Masuk (Messages / Thankyou)
- Melihat semua pesan yang dikirim pengunjung melalui form kontak
- Baris pesan belum dibaca ditandai warna berbeda
- Tombol **Tandai Dibaca** (✓) untuk mengubah status pesan
- Tombol **Hapus** untuk menghapus pesan
- Counter pesan belum dibaca tampil di sidebar dan topbar

---

## 🗄️ Database yang Digunakan

**Nama Database:** `portofolio_sayid`
**Sistem:** MySQL
**Karakter Set:** `utf8mb4` (mendukung emoji dan karakter Unicode penuh)
**Koneksi:** PDO (PHP Data Objects) dengan prepared statement

### Daftar Tabel

| Tabel | Jumlah Kolom | Keterangan |
|-------|-------------|-----------|
| `users` | 5 | Data akun login (admin & user) |
| `about` | 10 | Informasi profil pemilik |
| `skills` | 5 | Daftar keahlian dengan level |
| `experience` | 6 | Riwayat pengalaman kerja |
| `education` | 8 | Riwayat pendidikan |
| `projects` | 10 | Data proyek portfolio |
| `certificates` | 8 | Data sertifikat & penghargaan |
| `thankyou` | 6 | Pesan masuk dari pengunjung |

---

## 📋 Isi Query SQL (Database Schema Lengkap)

```sql
-- ============================================================
-- DATABASE: portofolio_sayid
-- ============================================================

CREATE DATABASE IF NOT EXISTS portofolio_sayid
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE portofolio_sayid;

-- -------------------------------------------------------
-- TABLE: users
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  username   VARCHAR(100) NOT NULL UNIQUE,
  password   VARCHAR(255) NOT NULL,
  role       ENUM('admin','user') DEFAULT 'user',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Password default: 'password' (harus direset setelah setup)
-- Jalankan reset_pass.php untuk generate hash yang benar
INSERT INTO users (username, password, role) VALUES
('sayidrafi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uze/oSoze', 'admin');

-- -------------------------------------------------------
-- TABLE: about
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS about (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  name        VARCHAR(150) NOT NULL,
  title       VARCHAR(200) NOT NULL,
  description TEXT NOT NULL,
  email       VARCHAR(150),
  phone       VARCHAR(30),
  location    VARCHAR(150),
  photo       VARCHAR(255),
  hero_image  VARCHAR(255),
  updated_at  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO about (name, title, description, email, phone, location, photo, hero_image) VALUES
(
  "Sayid Rafi A'thaya",
  'Frontend Developer & UI Designer',
  'Saya adalah seorang developer yang berfokus pada pengembangan website modern menggunakan HTML, CSS, Bootstrap, dan Vue JS. Saya menyukai desain yang elegan, responsif, dan berkelas.',
  'sayidrafi@email.com',
  '+62 812-3456-7890',
  'Samarinda, Kalimantan Timur',
  'assets/images/profile.jpg',
  'assets/images/hero.jpg'
);

-- -------------------------------------------------------
-- TABLE: skills
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS skills (
  id       INT AUTO_INCREMENT PRIMARY KEY,
  name     VARCHAR(100) NOT NULL,
  level    INT NOT NULL DEFAULT 0,
  category VARCHAR(50) DEFAULT 'Technical',
  urutan   INT DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO skills (name, level, category, urutan) VALUES
('HTML & CSS', 95, 'Frontend', 1),
('Bootstrap',  90, 'Frontend', 2),
('Vue JS',     85, 'Frontend', 3),
('UI/UX Design', 80, 'Design', 4),
('PHP',        75, 'Backend',  5),
('MySQL',      70, 'Database', 6);

-- -------------------------------------------------------
-- TABLE: experience
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS experience (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  position    VARCHAR(150) NOT NULL,
  company     VARCHAR(150) NOT NULL,
  period      VARCHAR(100) NOT NULL,
  description TEXT,
  urutan      INT DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO experience (position, company, period, description, urutan) VALUES
('Freelance Web Developer', 'Self Employed',  '2023 - Present', 'Membangun 20+ proyek website pribadi dan klien menggunakan teknologi modern.', 1),
('Data Engineer',           'Tech Company',   '2022 - 2023',    'Mengolah dan menganalisis data skala besar untuk kebutuhan bisnis perusahaan.', 2);

-- -------------------------------------------------------
-- TABLE: education
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS education (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  institution VARCHAR(200) NOT NULL,
  degree      VARCHAR(150) NOT NULL,
  field       VARCHAR(150),
  year_start  YEAR,
  year_end    YEAR,
  description TEXT,
  urutan      INT DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO education (institution, degree, field, year_start, year_end, description, urutan) VALUES
('Universitas Mulawarman',  'S1 Teknik Informatika',    'Ilmu Komputer',           2022, 2026, 'Belajar pemrograman web, basis data, dan pengembangan software.', 1),
('SMK Negeri 7 Samarinda', 'Rekayasa Perangkat Lunak', NULL,                      2019, 2022, 'Mempelajari dasar-dasar pemrograman dan pengembangan aplikasi.', 2);

-- -------------------------------------------------------
-- TABLE: projects
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS projects (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  title       VARCHAR(200) NOT NULL,
  description TEXT NOT NULL,
  tech_stack  VARCHAR(255),
  image       VARCHAR(255),
  demo_url    VARCHAR(255),
  github_url  VARCHAR(255),
  category    VARCHAR(100) DEFAULT 'Web',
  featured    TINYINT(1) DEFAULT 0,
  created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO projects (title, description, tech_stack, image, demo_url, github_url, category, featured) VALUES
('Portfolio Website',  'Website portofolio personal dengan desain modern dan responsif.',                 'HTML, CSS, Bootstrap, Vue JS, PHP, MySQL', 'assets/images/project1.jpg', '#', 'https://github.com/sayidrafi', 'Web', 1),
('E-Commerce App',     'Aplikasi toko online dengan fitur keranjang belanja dan pembayaran.',             'PHP, MySQL, Bootstrap, jQuery',            'assets/images/project2.jpg', '#', 'https://github.com/sayidrafi', 'Web', 1),
('Data Dashboard',     'Dashboard analitik data dengan visualisasi grafik interaktif.',                  'Vue JS, Chart.js, PHP, MySQL',             'assets/images/project3.jpg', '#', 'https://github.com/sayidrafi', 'Web', 0);

-- -------------------------------------------------------
-- TABLE: certificates
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS certificates (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  title       VARCHAR(200) NOT NULL,
  issuer      VARCHAR(150),
  description TEXT,
  image       VARCHAR(255),
  issued_date DATE,
  cert_url    VARCHAR(255),
  created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO certificates (title, issuer, description, image, issued_date, cert_url) VALUES
('Secretary & Treasurer', 'Organization Institute', 'Certified Secretary & Treasurer dalam kegiatan organisasi kampus.', 'assets/images/cert1.png', '2024-01-15', '#'),
('AI Upskilling Program', 'Digital Talent Scholarship', 'Advanced AI Training untuk pengembangan skill kecerdasan buatan.',   'assets/images/cert2.png', '2024-06-20', '#'),
('Moderator & Speaker',   'Tech Conference',            'Professional Public Speaker dan Moderator dalam acara teknologi.',    'assets/images/cert3.png', '2024-09-10', '#');

-- -------------------------------------------------------
-- TABLE: thankyou (pesan masuk dari pengunjung)
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS thankyou (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  name       VARCHAR(150) NOT NULL,
  email      VARCHAR(150),
  message    TEXT NOT NULL,
  is_read    TINYINT(1) DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
```

---

## 📁 Struktur Folder Proyek

```
portofolio_sayid/
│
├── index.php                  ← Halaman utama publik (SPA-like)
├── login.php                  ← Halaman login
├── logout.php                 ← Proses logout & destroy session
├── project-detail.php         ← Halaman detail proyek
├── aksi_thankyou.php          ← Proses POST form kontak
├── aksi_hapus.php             ← Universal delete handler (semua tabel)
├── reset_pass.php             ← (Buat sementara saat setup awal, hapus setelahnya)
│
├── config/
│   ├── koneksi.php            ← Koneksi PDO MySQL (define DB_HOST, dll.)
│   └── session.php            ← session_start(), requireAdmin(), setFlash(), dll.
│
├── app/
│   ├── models/
│   │   ├── AboutModel.php     ← Model CRUD tabel about
│   │   └── Models.php         ← Model: Skill, Experience, Education,
│   │                             Project, Certificate, Thankyou
│   ├── controllers/           ← Tersedia untuk pengembangan lanjutan
│   └── views/
│       ├── admin/             ← Tersedia untuk pengembangan lanjutan
│       ├── auth/              ← Tersedia untuk pengembangan lanjutan
│       └── public/            ← Tersedia untuk pengembangan lanjutan
│
├── admin/
│   ├── index.php              ← Dashboard admin
│   ├── about.php              ← Edit profil + upload foto
│   ├── skills.php             ← CRUD skills
│   ├── experience.php         ← CRUD pengalaman kerja
│   ├── education.php          ← CRUD pendidikan
│   ├── projects.php           ← CRUD proyek + upload gambar
│   ├── certificates.php       ← CRUD sertifikat + upload gambar
│   ├── messages.php           ← Kelola pesan masuk pengunjung
│   └── partials/
│       ├── sidebar.php        ← Komponen sidebar (di-include semua halaman admin)
│       └── topbar.php         ← Komponen topbar (di-include semua halaman admin)
│
├── assets/
│   ├── css/
│   │   ├── style.css          ← CSS halaman publik (dark navy + crimson theme)
│   │   └── admin.css          ← CSS panel admin (dark theme)
│   ├── js/
│   │   └── main.js            ← JS publik: filter, tab, animasi, smooth scroll
│   └── images/                ← Folder upload gambar (harus writable)
│
└── database/
    └── portofolio.sql         ← File SQL schema + data awal
```

---

## ⚙️ Cara Setup & Instalasi

### Prasyarat
- **Laragon** (atau XAMPP/WAMP) sudah terinstall
- **PHP 8.0+**
- **MySQL 5.7+** atau **MariaDB**
- Browser modern (Chrome, Firefox, Edge)

### Langkah 1 — Letakkan File
Ekstrak folder proyek ke dalam direktori web server:
```
C:\laragon\www\portofolio_sayid\
```

### Langkah 2 — Buat Database
1. Buka browser → akses `http://localhost/phpmyadmin`
2. Klik **New** di sidebar kiri
3. Beri nama database: `portofolio_sayid`
4. Klik **Create**

### Langkah 3 — Import SQL
1. Klik database `portofolio_sayid` di sidebar
2. Klik tab **Import** di menu atas
3. Klik **Choose File** → pilih `database/portofolio.sql`
4. Klik **Go / Import**
5. Pastikan muncul pesan "Import has been successfully finished"

### Langkah 4 — Konfigurasi Koneksi
Buka `config/koneksi.php` dan sesuaikan:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');     // Laragon default: kosong
define('DB_NAME', 'portofolio_sayid');
define('BASE_URL', 'http://localhost/portofolio_sayid/');
```

### Langkah 5 — Reset Password Admin
Buat file baru `reset_pass.php` di root folder, isi dengan:
```php
<?php
require_once 'config/koneksi.php';
$hash = password_hash('admin123', PASSWORD_DEFAULT);
$pdo->prepare("UPDATE users SET password=? WHERE username='sayidrafi'")->execute([$hash]);
echo "Berhasil! Login dengan: sayidrafi / admin123";
echo "<br><a href='login.php'>Ke halaman login</a>";
?>
```
Akses `http://localhost/portofolio_sayid/reset_pass.php` → setelah berhasil, **hapus file ini**.

### Langkah 6 — Akses Website

| URL | Halaman |
|-----|---------|
| `http://localhost/portofolio_sayid/` | Halaman publik utama |
| `http://localhost/portofolio_sayid/login.php` | Halaman login |
| `http://localhost/portofolio_sayid/admin/` | Dashboard admin |

---

## 🧑‍💻 Cara Penggunaan sebagai User (Pengunjung)

1. **Buka** `http://localhost/portofolio_sayid/` di browser
2. **Scroll** ke bawah atau klik menu navigasi untuk melihat setiap seksi:
   - **Home** → Foto profil, nama, jabatan, tombol navigasi
   - **About** → Bio, info kontak, skill bar, tab pengalaman & pendidikan
   - **Projects** → Klik tombol filter kategori untuk menyaring proyek → klik **Detail** untuk melihat halaman penuh proyek
   - **Certificates** → Lihat semua sertifikat → klik **Lihat** untuk membuka sertifikat online (jika tersedia)
   - **Contact** → Isi form nama, email (opsional), dan pesan → klik **Kirim Pesan**
3. Semua konten yang ditampilkan bersumber langsung dari database MySQL

> Pengunjung **tidak perlu login** untuk melihat seluruh konten portofolio.

---

## 🛠️ Cara Penggunaan sebagai Admin

### Login
1. Buka `http://localhost/portofolio_sayid/login.php`
2. Masukkan username dan password admin
3. Klik **Masuk** → diarahkan ke dashboard admin

### Mengelola About (Profil)
1. Klik **About** di sidebar
2. Edit nama, title, bio, email, telepon, lokasi
3. Upload foto profil dan/atau gambar hero baru
4. Klik **Simpan Perubahan** → perubahan langsung tampil di website

### Mengelola Skills
1. Klik **Skills** di sidebar
2. Klik **Tambah** untuk menambah skill baru → isi nama, level (0-100), kategori, urutan → **Simpan**
3. Klik ikon ✏️ untuk mengedit skill yang ada
4. Klik ikon 🗑️ → konfirmasi → skill dihapus

### Mengelola Pengalaman / Pendidikan
1. Klik **Experience** atau **Education** di sidebar
2. Proses sama: **Tambah** → isi form → **Simpan**, atau edit/hapus dari tabel

### Mengelola Proyek
1. Klik **Projects** di sidebar
2. Klik **Tambah Proyek** → isi:
   - Judul proyek
   - Kategori (Web / Mobile / Design / Other)
   - Deskripsi lengkap
   - Tech stack (pisahkan dengan koma, contoh: `PHP, MySQL, Bootstrap`)
   - Upload gambar proyek
   - URL Demo (opsional)
   - URL GitHub (opsional)
   - Centang **Featured** jika ingin ditampilkan dengan badge khusus
3. Klik **Tambah Proyek** → langsung tampil di website

### Mengelola Sertifikat
1. Klik **Certificates** di sidebar
2. Klik **Tambah** → isi:
   - Judul sertifikat
   - Penerbit/Issuer (contoh: "Dicoding", "Google", "Kampus")
   - Deskripsi singkat
   - Upload gambar/scan sertifikat (JPG/PNG)
   - Tanggal terbit
   - URL Sertifikat → link Google Drive / Credly / platform lain (opsional, untuk tombol "Lihat")
3. Klik **Simpan**

### Melihat & Mengelola Pesan
1. Klik **Messages** di sidebar (ada badge merah jika ada pesan baru)
2. Baca pesan dari pengunjung
3. Klik ✓ untuk menandai pesan sudah dibaca
4. Klik 🗑️ untuk menghapus pesan

### Logout
Klik **Logout** di bagian bawah sidebar → session dihapus → diarahkan ke halaman login

---

## 🔒 Keamanan

- Password disimpan dalam bentuk **hash bcrypt** menggunakan `password_hash()` dan diverifikasi dengan `password_verify()`
- Semua input dari form disanitasi menggunakan `htmlspecialchars()` sebelum ditampilkan
- Query database menggunakan **PDO Prepared Statement** untuk mencegah SQL Injection
- Halaman admin dilindungi fungsi `requireAdmin()` yang mengecek session setiap kali halaman dimuat
- Folder `config/` dilindungi `.htaccess` agar tidak bisa diakses langsung via browser
- Daftar tabel yang boleh dihapus dibatasi (whitelist) di `aksi_hapus.php`

---

## 📝 Catatan Penting

- Folder `assets/images/` harus memiliki permission **writable** agar upload gambar berhasil
- Jika upload gagal di Windows: klik kanan folder `images/` → Properties → Security → Edit → centang **Full Control** untuk Users
- File `reset_pass.php` yang dibuat saat setup **harus dihapus** setelah digunakan
- Kolom `BASE_URL` di `config/koneksi.php` harus disesuaikan jika nama folder berbeda atau saat deploy ke hosting

---
