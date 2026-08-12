<?php

require_once __DIR__ . '/../Models/User.php';

/**
 * AuthController
 * Menangani tampilan form login serta proses autentikasi.
 */
class AuthController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Tampilkan halaman login.
     */
    public function showLogin(): void
    {
        // Kalau sudah login, langsung arahkan ke Master Unit
        if (!empty($_SESSION['user_id'])) {
            header('Location: index.php?page=unit&action=index');
            exit;
        }

        $errors = $_SESSION['errors'] ?? [];
        $old    = $_SESSION['old'] ?? [];
        unset($_SESSION['errors'], $_SESSION['old']);

        require __DIR__ . '/../Views/auth/login.php';
    }

    /**
     * Proses submit form login.
     */
    public function login(): void
    {
        $identifier = trim($_POST['identifier'] ?? '');
        $password   = $_POST['password'] ?? '';

        $errors = [];

        if ($identifier === '') {
            $errors[] = 'Username wajib diisi.';
        }

        if ($password === '') {
            $errors[] = 'Password wajib diisi.';
        }

        if (empty($errors)) {
            $user = $this->userModel->findByEmailOrUsername($identifier);

            if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
                $errors[] = 'Email/Username atau password salah.';
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old']    = ['identifier' => $identifier];
            header('Location: index.php?page=auth&action=login');
            exit;
        }

        // Login berhasil: simpan data user ke session
        $_SESSION['user_id']  = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['employee_id'] = $user['employee_id'];

        $_SESSION['login_success'] = $user['username'];

        header('Location: index.php?page=unit&action=index');
        exit;
    }

    /**
     * Logout & hancurkan session.
     */
    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        header('Location: index.php?page=auth&action=login');
        exit;
    }
}
