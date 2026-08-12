<?php

/**
 * Database
 * Kelas koneksi database menggunakan PDO dengan driver pgsql.
 * Menerapkan pola Singleton agar koneksi hanya dibuat sekali.
 */
class Database
{
    private static ?PDO $instance = null;

    private function __construct()
    {
        // Sengaja dikosongkan, gunakan getInstance()
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                $dsn = 'pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;

                self::$instance = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                // Jangan tampilkan detail koneksi ke user di production
                die('Koneksi database gagal: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
