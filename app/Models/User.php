<?php

require_once __DIR__ . '/../Core/Database.php';

/**
 * User (Model)
 * Bertanggung jawab atas semua query terkait tabel "users".
 */
class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Cari user berdasarkan email ATAU username.
     */
    public function findByEmailOrUsername(string $identifier): array|false
    {
        $sql = 'SELECT user_id, username, password, employee_id
                FROM "User"
                WHERE username = :identifier
                LIMIT 1';

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['identifier' => $identifier]);

        return $stmt->fetch();
    }

    /**
     * Verifikasi password plain terhadap hash yang tersimpan.
     */
    public function verifyPassword(string $plainPassword, string $hashedPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }

    /**
     * Buat user baru (opsional, untuk kebutuhan seeding/registrasi).
     */
    public function create(string $username, string $plainPassword, int $employeeId): bool
    {
        $sql = 'INSERT INTO "User" (username, password, employee_id)
                VALUES (:username, :password, :employee_id)';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'username'    => $username,
            'password'    => password_hash($plainPassword, PASSWORD_DEFAULT),
            'employee_id' => $employeeId,
        ]);
    }
}
