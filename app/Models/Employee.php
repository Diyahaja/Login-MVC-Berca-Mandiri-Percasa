<?php

require_once __DIR__ . '/../Core/Database.php';

/**
 * Employee (Model)
 * Dipakai untuk ambil daftar pegawai sebagai pilihan "Sales" di form transaksi.
 *
 * CATATAN: kalau waktu bikin tabel di pgAdmin nama tabelnya ditulis dengan huruf besar
 * dan diberi tanda kutip dua (misal "Employee"), PostgreSQL akan simpan case-sensitive.
 * Kalau nanti muncul error "relation employee does not exist", ganti nama tabel di
 * query bawah ini jadi "Employee" (pakai tanda kutip dua persis) sesuai nama aslinya.
 */
class Employee
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /** Ambil semua pegawai untuk dropdown (id + nik + nama) */
    public function getAll(): array
    {
        $sql = 'SELECT employee_id, nik, name
                FROM "Employee"
                ORDER BY name ASC';

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }
}
