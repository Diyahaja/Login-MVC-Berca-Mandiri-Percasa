<?php

require_once __DIR__ . '/../Models/TrnUnit.php';
require_once __DIR__ . '/../Models/Unit.php';
require_once __DIR__ . '/../Models/Employee.php';

/**
 * TrnUnitController
 * Menangani halaman Transaksi Unit: list (DataTable), tambah, edit, hapus.
 */
class TrnUnitController
{
    private TrnUnit  $trnModel;
    private Unit     $unitModel;
    private Employee $employeeModel;

    public function __construct()
    {
        $this->trnModel      = new TrnUnit();
        $this->unitModel     = new Unit();
        $this->employeeModel = new Employee();
    }

    /** Tampilkan halaman daftar transaksi */
    public function index(): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?page=auth&action=login');
            exit;
        }

        $transactions = $this->trnModel->getAll();
        $units        = $this->unitModel->getAll();     // untuk dropdown pilihan unit
        $employees    = $this->employeeModel->getAll();  // untuk dropdown pilihan sales

        require __DIR__ . '/../Views/trnunit/index.php';
    }

    /** Simpan transaksi baru (AJAX) */
    public function store(): void
    {
        header('Content-Type: application/json');

        $data = $this->collectInput();

        if ($error = $this->validate($data)) {
            echo json_encode(['status' => 'error', 'message' => $error]);
            return;
        }

        if ($this->trnModel->isCodeExists($data['trn_unit_code'])) {
            echo json_encode(['status' => 'error', 'message' => "Kode transaksi '{$data['trn_unit_code']}' sudah dipakai."]);
            return;
        }

        try {
            $success = $this->trnModel->create($data);

            if ($success) {
                $_SESSION['flash_success'] = 'Transaksi berhasil ditambahkan.';
            }

            echo json_encode($success
                ? ['status' => 'success', 'message' => 'Transaksi berhasil ditambahkan.']
                : ['status' => 'error', 'message' => 'Gagal menyimpan transaksi.']
            );
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /** Update transaksi (AJAX) */
    public function update(): void
    {
        header('Content-Type: application/json');

        $data = $this->collectInput();

        if ($error = $this->validate($data)) {
            echo json_encode(['status' => 'error', 'message' => $error]);
            return;
        }

        try {
            $success = $this->trnModel->update($data['trn_unit_code'], $data);
            
            if ($success) {
                $_SESSION['flash_success'] = 'Transaksi berhasil diperbarui.';
            }

            echo json_encode($success
                ? ['status' => 'success', 'message' => 'Transaksi berhasil diperbarui.']
                : ['status' => 'error', 'message' => 'Gagal memperbarui transaksi.']
            );
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Data unit atau sales tidak valid.']);
        }
    }

    /** Hapus transaksi (AJAX) */
    public function delete(): void
    {
        header('Content-Type: application/json');

        $code = trim($_POST['trn_unit_code'] ?? '');

        if ($code === '') {
            echo json_encode(['status' => 'error', 'message' => 'Kode transaksi tidak valid.']);
            return;
        }

        $success = $this->trnModel->delete($code);
        if ($success) {
            $_SESSION['flash_success'] = 'Transaksi berhasil dihapus.';
        }

        echo json_encode($success
            ? ['status' => 'success', 'message' => 'Transaksi berhasil dihapus.']
            : ['status' => 'error', 'message' => 'Gagal menghapus transaksi.']
        );
    }

    /** Ambil & rapikan input dari $_POST */
    private function collectInput(): array
    {
        return [
            'trn_unit_code' => trim($_POST['trn_unit_code'] ?? ''),
            'price'         => $_POST['price'] ?? '',
            'qty'           => $_POST['qty'] ?? '',
            'customer'      => trim($_POST['customer'] ?? ''),
            'employee_id'   => $_POST['employee_id'] ?? '',
            'date'          => $_POST['date'] ?? '',
            'mst_unit_code' => $_POST['mst_unit_code'] ?? '',
        ];
    }

    /** Validasi sederhana, return pesan error atau null kalau lolos */
    private function validate(array $data): ?string
    {
        foreach ($data as $key => $value) {
            if ($value === '' || $value === null) {
                return 'Semua field wajib diisi.';
            }
        }

        if (!is_numeric($data['price']) || !is_numeric($data['qty'])) {
            return 'Harga dan Qty harus berupa angka.';
        }

        return null;
    }
}
