# AGS (Academic Guidance System)

Aplikasi AGS berbasis web yang dibangun menggunakan **Laravel 11**.

## Persyaratan Sistem
Sebelum menjalankan aplikasi ini, pastikan laptop Anda sudah terinstal:
- **XAMPP** (Mendukung PHP versi 8.2 atau lebih baru)
- **Composer** (Package manager untuk PHP)
- **Node.js** (Termasuk NPM, dibutuhkan untuk frontend)

## Cara Instalasi & Menjalankan Aplikasi

Ikuti langkah-langkah berikut secara berurutan:

### 1. Pindahkan Folder Aplikasi
Pastikan folder aplikasi (misal `AGS`) sudah di-*copy* ke dalam folder XAMPP di laptop Anda. Disarankan diletakkan di `C:\xampp\htdocs\AGS` atau `D:\xampp\htdocs\AGS`.

### 2. Nyalakan Database (MySQL)
- Buka aplikasi **XAMPP Control Panel**.
- Klik tombol **Start** pada modul **Apache** dan **MySQL**.

### 3. Buat Database di phpMyAdmin
- Buka browser dan akses URL: `http://localhost/phpmyadmin`
- Klik menu **New** (Baru) di panel kiri.
- Buat database baru dengan nama persis: **`db-ags`**.
- Biarkan kosong (jangan buat tabel apa pun), lalu klik tombol **Create**.

### 4. Buka Terminal (Command Prompt / PowerShell)
Buka terminal dan arahkan ke dalam folder proyek AGS. Sebagai contoh:
```bash
cd D:\xampp\htdocs\AGS
```

### 5. Install Dependencies Backend (Composer)
Jalankan perintah berikut untuk mengunduh semua library yang dibutuhkan aplikasi (PHP):
```bash
composer install
```
*(Tunggu hingga proses selesai 100%)*

### 6. Install Dependencies Frontend (NPM)
Karena aplikasi ini menggunakan Alpine.js dan TailwindCSS, Anda juga wajib menginstal library frontend dan melakukan *compile* asset. Jalankan dua perintah berikut berurutan:
```bash
npm install
npm run build
```
*(Langkah ini tidak perlu install `alpinejs` secara spesifik, karena semuanya sudah otomatis dibaca dari file package.json Anda).*

### 7. Konfigurasi File .env
- Di dalam folder `AGS`, cari file bernama `.env.example`.
- Ubah nama file tersebut (Rename) menjadi `.env` saja (tanpa `.example`).
- Buka file `.env` tersebut dan pastikan baris database sudah sesuai seperti ini:
  ```env
  DB_DATABASE=db-ags
  DB_USERNAME=root
  DB_PASSWORD=
  ```
*(Catatan: Jika file .env sudah otomatis terbawa dari copy-an teman Anda, pastikan saja isi database-nya benar).*

### 8. Generate Application Key
Jalankan perintah ini untuk membuat kunci keamanan aplikasi:
```bash
php artisan key:generate
```

### 9. Migrasi dan Seeding Database
Jalankan perintah ini untuk membangun seluruh struktur tabel database sekaligus memasukkan data akun dummy awal:
```bash
php artisan migrate:fresh --seed
```

### 10. Jalankan Aplikasi
Langkah terakhir, nyalakan server lokal Laravel dengan perintah:
```bash
php artisan serve
```

Aplikasi sekarang sudah menyala! Buka browser Anda dan akses URL: 
**[http://localhost:8000](http://localhost:8000)**

---

## Akun Uji Coba

Untuk mencoba masuk ke aplikasi, Anda bisa login menggunakan salah satu akun default di bawah ini. Semua akun menggunakan password yang sama.

**Password Default: `password123`**

| Role | Email Login |
|------|-------------|
| **Operator** | `op@gmail.com` |
| **Mahasiswa** | `mhs@gmail.com` |
| **Dosen PA** | `dos@gmail.com` |
