<?php
$loginSuccessUser = $_SESSION['login_success'] ?? null;
unset($_SESSION['login_success']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master - <?= htmlspecialchars(APP_NAME) ?></title>
    <link rel="icon" type="image/png" href="assets/img/logo.png">

    <!-- Bootstrap 5 (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables (CDN) -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- SweetAlert2 (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
</head>
<body class="bg-light">

<div class="app-wrapper">
<?php require __DIR__ . '/../partials/sidebar.php'; ?>

<div class="app-content">
    
    <?php require __DIR__ . '/../partials/alert.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Master</h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUnit" onclick="resetForm()">
            + Tambah Unit
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="tableUnit" class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>Kode Unit</th>
                        <th>Nama</th>
                        <th>Brand</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($units as $unit): ?>
                        <tr>
                            <td><?= htmlspecialchars($unit['mst_unit_code']) ?></td>
                            <td><?= htmlspecialchars($unit['name']) ?></td>
                            <td><?= htmlspecialchars($unit['brand']) ?></td>
                            <td><?= number_format((float) $unit['price'], 0, ',', '.') ?></td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-warning btn-edit"
                                    data-code="<?= htmlspecialchars($unit['mst_unit_code']) ?>"
                                    data-name="<?= htmlspecialchars($unit['name']) ?>"
                                    data-brand="<?= htmlspecialchars($unit['brand']) ?>"
                                    data-price="<?= htmlspecialchars($unit['price']) ?>"
                                >
                                    <i class="fi fi-rr-edit"></i>
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-danger btn-delete"
                                    data-code="<?= htmlspecialchars($unit['mst_unit_code']) ?>"
                                >
                                    <i class="fi fi-rr-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<!-- /app-wrapper -->

<!-- Modal Tambah / Edit Unit -->
<div class="modal fade" id="modalUnit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formUnit">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUnitTitle">Tambah Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="formMode" value="create">

                    <div class="mb-3">
                        <label class="form-label">Kode Unit</label>
                        <input type="text" class="form-control" id="mst_unit_code" name="mst_unit_code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control" id="price" name="price" required min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/app.js"></script>

<script>
$(document).ready(function () {
    // Inisialisasi DataTable standar, langsung enhance tabel yang sudah ada
    <?php if ($loginSuccessUser): ?>
    Swal.fire({
        icon: 'success',
        title: 'Login berhasil!',
        text: 'Selamat datang, <?= htmlspecialchars($loginSuccessUser) ?>.',
        timer: 2000,
        showConfirmButton: false
    });
    <?php endif; ?>

    // Inisialisasi DataTable standar, langsung enhance tabel yang sudah ada
    $('#tableUnit').DataTable();

    var modalUnit = new bootstrap.Modal(document.getElementById('modalUnit'));

    // Isi form saat tombol Edit diklik
    $('#tableUnit').on('click', '.btn-edit', function () {
        $('#formMode').val('update');
        $('#modalUnitTitle').text('Edit Unit');

        $('#mst_unit_code').val($(this).data('code'));
        $('#mst_unit_code').prop('readonly', true); // kode tidak boleh diubah saat edit
        $('#name').val($(this).data('name'));
        $('#brand').val($(this).data('brand'));
        $('#price').val($(this).data('price'));

        modalUnit.show();
    });

    // Submit form (dipakai untuk Tambah & Edit)
    $('#formUnit').on('submit', function (e) {
        e.preventDefault();

        var mode = $('#formMode').val();
        var action = (mode === 'update') ? 'update' : 'store';

        $.ajax({
            url: 'index.php?page=unit&action=' + action,
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    modalUnit.hide();
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan pada server.'
                });
            }
        });
    });

    // Hapus unit
    $('#tableUnit').on('click', '.btn-delete', function () {
        var code = $(this).data('code');

        Swal.fire({
            icon: 'warning',
            title: 'Yakin hapus unit ini?',
            text: 'Data yang sudah dihapus tidak bisa dikembalikan.',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'index.php?page=unit&action=delete',
                    method: 'POST',
                    data: { mst_unit_code: code },
                    dataType: 'json',
                    success: function (res) {
                        if (res.status === 'success') {
                            location.reload();
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    }
                });
            }
        });
    });
});

// Reset form saat tombol "Tambah Unit" diklik
function resetForm() {
    $('#formUnit')[0].reset();
    $('#formMode').val('create');
    $('#modalUnitTitle').text('Tambah Unit');
    $('#mst_unit_code').prop('readonly', false);
}
</script>

</body>
</html>
