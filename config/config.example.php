<?php
/**
 * Konfigurasi aplikasi & koneksi database PostgreSQL.
 * Sesuaikan nilai di bawah dengan pengaturan pgAdmin / PostgreSQL kamu.
 */

// ==== Konfigurasi Database ====
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_PORT', getenv('DB_PORT') ?: '5432');
define('DB_NAME', getenv('DB_NAME') ?: 'berca');
define('DB_USER', getenv('DB_USER') ?: 'postgres');
define('DB_PASS', getenv('DB_PASS') ?: '');

// ==== Konfigurasi Aplikasi ====
define('APP_NAME', 'PT. BERCA MANDIRI PERKASA');
define('BASE_URL', '/'); // sesuaikan jika project ada di subfolder, contoh: '/berca-login/public/'

// Mulai session di satu tempat saja
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
