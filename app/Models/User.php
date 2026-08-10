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
        $sql = 'SELECT id, username, email, password, full_name
                FROM users
                WHERE email = :identifier OR username = :identifier
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
    public function create(string $username, string $email, string $plainPassword, string $fullName = ''): bool
    {
        $sql = 'INSERT INTO users (username, email, password, full_name, created_at)
                VALUES (:username, :email, :password, :full_name, NOW())';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'username'  => $username,
            'email'     => $email,
            'password'  => password_hash($plainPassword, PASSWORD_DEFAULT),
            'full_name' => $fullName,
        ]);
    }
}
