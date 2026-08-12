<?php

require_once __DIR__ . '/../Core/Database.php';

class Unit
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $sql = 'SELECT mst_unit_code, name, brand, price
                FROM mst_unit
                ORDER BY mst_unit_code ASC';

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function findByCode(string $code): array|false
    {
        $sql = 'SELECT mst_unit_code, name, brand, price
                FROM mst_unit
                WHERE mst_unit_code = :code';

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['code' => $code]);

        return $stmt->fetch();
    }

    public function create(array $data): bool
    {
        $sql = 'INSERT INTO mst_unit (mst_unit_code, name, brand, price)
                VALUES (:code, :name, :brand, :price)';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'code'  => $data['mst_unit_code'],
            'name'  => $data['name'],
            'brand' => $data['brand'],
            'price' => $data['price'],
        ]);
    }

    public function update(string $code, array $data): bool
    {
        $sql = 'UPDATE mst_unit
                SET name = :name, brand = :brand, price = :price
                WHERE mst_unit_code = :code';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'name'  => $data['name'],
            'brand' => $data['brand'],
            'price' => $data['price'],
            'code'  => $code,
        ]);
    }

    public function delete(string $code): bool
    {
        $sql = 'DELETE FROM mst_unit WHERE mst_unit_code = :code';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute(['code' => $code]);
    }

    /** Cek apakah kode unit sudah dipakai (untuk validasi sebelum insert) */
    public function isCodeExists(string $code): bool
    {
        $sql = 'SELECT 1 FROM mst_unit WHERE mst_unit_code = :code';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['code' => $code]);

        return (bool) $stmt->fetchColumn();
    }
}
