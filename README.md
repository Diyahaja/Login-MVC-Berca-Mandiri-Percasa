# Login Form - PHP Native (MVC) + PostgreSQL

Form login sederhana dengan pola **MVC (Model-View-Controller)** murni PHP native (tanpa framework), terkoneksi ke **PostgreSQL** lewat PDO. Tampilan dibuat mirip referensi desain (kartu putih membulat, logo bulat merah, tombol biru, background garis diagonal).

## Struktur Folder

```
berca-login/
├── app/
│   ├── Controllers/
│   │   └── AuthController.php   # Logika login, logout
│   ├── Models/
│   │   └── User.php             # Query ke tabel users
│   ├── Core/
│   │   ├── Database.php         # Koneksi PDO PostgreSQL (Singleton)
│   │   └── Router.php           # Router sederhana
│   └── Views/
│       ├── auth/login.php       # Tampilan form login
│       └── dashboard.php        # Halaman setelah login berhasil
├── config/
│   └── config.php               # Konfigurasi DB & aplikasi
├── database/
│   └── schema.sql                # Script SQL untuk pgAdmin
└── public/
    ├── index.php                 # Entry point / front controller
    └── assets/
        ├── css/style.css
        └── js/login.js
```

## Cara Menjalankan

### 1. Siapkan Database di pgAdmin

1. Buka **pgAdmin**, buat database baru bernama `berca_login`.
2. Buka **Query Tool** pada database tersebut, lalu jalankan isi file `database/schema.sql`.
   Ini akan membuat tabel `users` dan 1 akun contoh:
   - **Username:** `admin`
   - **Password:** `password123`

### 2. Atur Koneksi Database

Edit `config/config.php`, sesuaikan dengan pengaturan PostgreSQL kamu:

```php
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '5432');
define('DB_NAME', 'berca_login');
define('DB_USER', 'postgres');
define('DB_PASS', 'password_kamu');
```

### 3. Pastikan Ekstensi PDO PostgreSQL Aktif

Di `php.ini`, pastikan baris berikut tidak dikomentari (hapus tanda `;` di depan jika ada):

```
extension=pdo_pgsql
extension=pgsql
```

### 4. Jalankan Server

Dari folder project (bukan folder `public`), jalankan:

```bash
php -S localhost:8000 -t public
```

Lalu buka di browser: `http://localhost:8000/index.php`

## Alur Aplikasi

- `index.php?page=auth&action=login` → tampilkan form login (GET)
- `index.php?page=auth&action=login` → proses login (POST)
- `index.php?page=auth&action=logout` → logout
- `index.php?page=dashboard` → halaman setelah login (butuh session aktif)

## Catatan Keamanan

- Password disimpan dengan `password_hash()` (bcrypt) dan diverifikasi dengan `password_verify()` — **tidak pernah** disimpan plain text.
- Semua query menggunakan **prepared statement** (PDO) untuk mencegah SQL Injection.
- Validasi input dasar sudah diterapkan di `AuthController::login()`.

## Pengembangan Lanjutan (opsional)

- Tambahkan CSRF token pada form.
- Tambahkan rate limiting / lockout setelah beberapa kali gagal login.
- Ganti `logo-circle` dengan file gambar logo asli (taruh di `public/assets/img/` lalu ganti `<span class="logo-text">` dengan `<img>`).
