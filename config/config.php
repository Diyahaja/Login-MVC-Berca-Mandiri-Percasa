<?php
/**
 * Konfigurasi aplikasi & koneksi database PostgreSQL.
 * Sesuaikan nilai di bawah dengan pengaturan pgAdmin / PostgreSQL kamu.
 */

// ==== Konfigurasi Database ====
define('DB_HOST', '127.0.0.1');      // host PostgreSQL, biasanya localhost
define('DB_PORT', '5432');           // port default PostgreSQL
define('DB_NAME', 'BMP_database');    // nama database (buat lewat pgAdmin)
define('DB_USER', 'postgres');       // username PostgreSQL
define('DB_PASS', 'kerjainaja');       // password PostgreSQL

// ==== Konfigurasi Aplikasi ====
define('APP_NAME', 'PT BERCA MANDIRI PERKASA');
define('BASE_URL', '/'); // sesuaikan jika project ada di subfolder, contoh: '/berca-login/public/'
define('APP_DEBUG', true); // set ke false kalau sudah production / mau dikumpulkan

// Mulai session di satu tempat saja
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
