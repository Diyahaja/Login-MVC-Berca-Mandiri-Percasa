<?php

require_once __DIR__ . '/../Models/Unit.php';

/**
 * UnitController
 * Menangani halaman Master Unit: list (DataTable), tambah, edit, hapus.
 * store/update/delete dipanggil lewat AJAX dan mengembalikan JSON,
 * supaya bisa langsung ditangkap SweetAlert2 di sisi JS.
 */
class UnitController
{
    private Unit $unitModel;

    public function __construct()
    {
        $this->unitModel = new Unit();
    }

    /** Tampilkan halaman daftar unit */
    public function index(): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?page=auth&action=login');
            exit;
        }

        $units = $this->unitModel->getAll();

        require __DIR__ . '/../Views/unit/index.php';
    }

    /** Simpan unit baru (dipanggil via AJAX) */
    public function store(): void
    {
        header('Content-Type: application/json');

        $code  = trim($_POST['mst_unit_code'] ?? '');
        $name  = trim($_POST['name'] ?? '');
        $brand = trim($_POST['brand'] ?? '');
        $price = $_POST['price'] ?? '';

        if ($code === '' || $name === '' || $brand === '' || $price === '') {
            echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi.']);
            return;
        }

        if ($this->unitModel->isCodeExists($code)) {
            echo json_encode(['status' => 'error', 'message' => "Kode unit '$code' sudah dipakai."]);
            return;
        }

        $success = $this->unitModel->create([
            'mst_unit_code' => $code,
            'name'          => $name,
            'brand'         => $brand,
            'price'         => $price,
        ]);

        if ($success) {
            $_SESSION['flash_success'] = 'Unit berhasil ditambahkan.';
        }

        echo json_encode($success
            ? ['status' => 'success', 'message' => 'Unit berhasil ditambahkan.']
            : ['status' => 'error', 'message' => 'Gagal menyimpan unit.']
        );
    }

    /** Update unit yang sudah ada (dipanggil via AJAX) */
    public function update(): void
    {
        header('Content-Type: application/json');

        $code  = trim($_POST['mst_unit_code'] ?? '');
        $name  = trim($_POST['name'] ?? '');
        $brand = trim($_POST['brand'] ?? '');
        $price = $_POST['price'] ?? '';

        if ($code === '' || $name === '' || $brand === '' || $price === '') {
            echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi.']);
            return;
        }

        $success = $this->unitModel->update($code, [
            'name'  => $name,
            'brand' => $brand,
            'price' => $price,
        ]);

        if ($success) {
            $_SESSION['flash_success'] = 'Unit berhasil diperbarui.';
        }

        echo json_encode($success
            ? ['status' => 'success', 'message' => 'Unit berhasil diperbarui.']
            : ['status' => 'error', 'message' => 'Gagal memperbarui unit.']
        );
    }

    /** Hapus unit (dipanggil via AJAX) */
    public function delete(): void
    {
        header('Content-Type: application/json');

        $code = trim($_POST['mst_unit_code'] ?? '');

        if ($code === '') {
            echo json_encode(['status' => 'error', 'message' => 'Kode unit tidak valid.']);
            return;
        }

        try {
            $success = $this->unitModel->delete($code);

            if ($success) {
                $_SESSION['flash_success'] = 'Unit berhasil dihapus.';
            }

            echo json_encode($success
                ? ['status' => 'success', 'message' => 'Unit berhasil dihapus.']
                : ['status' => 'error', 'message' => 'Gagal menghapus unit.']
            );
        } catch (PDOException $e) {
            // Biasanya kena constraint FK karena unit masih dipakai di trn_unit
            echo json_encode([
                'status'  => 'error',
                'message' => 'Unit tidak bisa dihapus karena masih dipakai di data transaksi.',
            ]);
        }
    }
}
