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

| Role       | Email     | Password      | Hak Akses                                               |
|------------|--------------|---------------|----------------------------------------------------------|
| Admin  | `admin@example.com` | `password`    | Kelola ruang, verifikasi peminjaman, atur user & XP     |
| Dosen  | `dosen@example.com`      | `password`    | Mengajukan peminjaman, lihat status, dapatkan XP & badge         |
| Mahasiswa  | `mahasiswa@example.com` | `password`     | Mengajukan peminjaman, lihat status, dapatkan XP & badge|

> *Catatan:* email & password default bisa diubah setelah login.

---

## ⚙️ Cara Menjalankan Aplikasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi secara lokal:

### 1. Clone Repository

```bash
git clone https://github.com/namamu/ruangfasilkom.git
cd ruangfasilkom

### 2. Install Dependency Laravel
```bash
composer install

### 3. Copy File Environment
```bash
cp .env.example .env

### 4. Generate Application Key
```bash
php artisan key:generate

### 5. Konfigurasi Database
Buka file .env dan ubah konfigurasi database sesuai lokal kamu, contoh:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ruangfasilkom
DB_USERNAME=root
DB_PASSWORD=12345

### 6. Jalankan Migrasi Database
```bash
php artisan migrate

```bash
php artisan db:seed

### 7.  Jalankan NPM untuk Fitur Frontend
```bash
npm install

```bash
npm run dev

### 8.  Jalankan Server Laravel
```bash
php artisan serve

