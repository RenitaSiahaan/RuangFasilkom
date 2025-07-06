# RuangFasilkom Web-App

**RuangFasilkom** adalah sistem peminjaman ruang kelas berbasis web yang dibangun menggunakan Laravel 9.
Aplikasi ini bertujuan untuk menggantikan proses peminjaman manual yang masih menggunakan kertas, menjadi sistem digital yang efisien, cepat, dan terintegrasi dengan antarmuka modern serta fitur gamifikasi.

---

## 🚀 Fitur

- Pengajuan peminjaman ruang secara online
- Persetujuan dan pengelolaan peminjaman oleh admin fakultas
- Riwayat lengkap peminjaman ruang
- XP dan badge untuk pengguna aktif (fitur gamifikasi)

---

## 🔑 Akses Pengguna

| Role        | Email           | Password      | Hak Akses                                                |
|-------------|-----------------|---------------|----------------------------------------------------------|
| Admin       | `admin@example.com` | `password`    | Kelola ruang, verifikasi peminjaman, atur user & XP      |
| Dosen       | `dosen@example.com` | `password`    | Mengajukan peminjaman, lihat status, dapatkan XP & badge |
| Mahasiswa   | `mahasiswa@example.com` | `password`    | Mengajukan peminjaman, lihat status, dapatkan XP & badge |

> *Catatan:* email & password default bisa diubah setelah login.

---

## ⚙️ Cara Menjalankan Aplikasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi secara lokal:

1. Clone Repository
```bash
git clone [https://github.com/namamu/ruangfasilkom.git](https://github.com/namamu/ruangfasilkom.git)
cd ruangfasilkom
Install Dependency Laravel

Bash

composer install
Copy File Environment

Bash

cp .env.example .env
Generate Application Key

Bash

php artisan key:generate
Konfigurasi Database
Buka file .env dan ubah konfigurasi database sesuai lokal kamu, contoh:

Bash

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ruangfasilkom
DB_USERNAME=root
DB_PASSWORD=12345
Jalankan Migrasi Database

Bash

php artisan migrate
php artisan db:seed
Jalankan NPM untuk Fitur Frontend

Bash

npm install
npm run dev
Jalankan Server Laravel

Bash

php artisan serve
