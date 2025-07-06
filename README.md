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
```
git clone [https://github.com/namamu/ruangfasilkom.git](https://github.com/namamu/ruangfasilkom.git)
cd ruangfasilkom
```

2. Install Dependency Laravel
```
composer install
```

3. Copy File Environment
```
cp .env.example .env
```

4. Generate Application Key
```
php artisan key:generate
```

6. Konfigurasi Database
Buka file .env dan ubah konfigurasi database sesuai lokal kamu, contoh:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ruangfasilkom
DB_USERNAME=root
DB_PASSWORD=12345
```

7. Jalankan Migrasi Database
```
php artisan migrate --seed
```

8. Jalankan NPM untuk Fitur Frontend
```
npm install
npm run dev
```

9. Jalankan Server Laravel
```
php artisan serve
```

## Tampilan Aplikasi
1. Login Page
<img width="1304" height="637" alt="Image" src="https://github.com/user-attachments/assets/79eefa12-0b59-4e0a-816b-df0d0b92eaa1" />

2. User Home
<img width="1366" height="629" alt="Image" src="https://github.com/user-attachments/assets/cec6996a-9969-411d-9b39-20614251d364" />

3. User Room
<img width="1366" height="639" alt="Image" src="https://github.com/user-attachments/assets/6216aa01-5109-41d4-82b1-4aa764577470" />

4. User History
<img width="1366" height="626" alt="Image" src="https://github.com/user-attachments/assets/372e841b-a084-494a-b806-9e7e8b4f6831" />

5. Form Peminjaman
<img width="1366" height="683" alt="Image" src="https://github.com/user-attachments/assets/51ae61fe-a6bd-4c5d-b479-4f7cc366f82c" />

6. Admin Home
<img width="1366" height="628" alt="Image" src="https://github.com/user-attachments/assets/940fe9eb-e81c-4042-9cad-c91b1db6a620" />
   
8. Daftar Peminjaman Masuk
<img width="1366" height="599" alt="Image" src="https://github.com/user-attachments/assets/cb3a2696-4626-4bf7-91eb-9149f8892427" />

9. Proses Admin
<img width="1366" height="635" alt="Image" src="https://github.com/user-attachments/assets/95f1fb19-864e-49f5-b0b5-8c42a492902f" />

## Author
👩‍🎓 Renita Siahaan

📧 renitaenjelsiahaan@gmail.com

🎓 Informatika, UPN Veteran Jawa Timur
