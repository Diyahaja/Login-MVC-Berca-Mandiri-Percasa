<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi - <?= htmlspecialchars(APP_NAME) ?></title>
    <link rel="icon" type="image/png" href="assets/img/logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
        <h4 class="mb-0">Transaksi Unit</h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTrn" onclick="resetForm()">
            + Tambah Transaksi
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="tableTrn" class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>Kode Transaksi</th>
                        <th>Unit</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Customer</th>
                        <th>Sales</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $trx): ?>
                        <tr>
                            <td><?= htmlspecialchars($trx['trn_unit_code']) ?></td>
                            <td><?= htmlspecialchars($trx['mst_unit_code']) ?> - <?= htmlspecialchars($trx['unit_name']) ?></td>
                            <td><?= number_format((float) $trx['price'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($trx['qty']) ?></td>
                            <td><?= htmlspecialchars($trx['customer']) ?></td>
                            <td><?= htmlspecialchars($trx['sales_name']) ?></td>
                            <td><?= htmlspecialchars($trx['date']) ?></td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-warning btn-edit"
                                    data-code="<?= htmlspecialchars($trx['trn_unit_code']) ?>"
                                    data-unit="<?= htmlspecialchars($trx['mst_unit_code']) ?>"
                                    data-price="<?= htmlspecialchars($trx['price']) ?>"
                                    data-qty="<?= htmlspecialchars($trx['qty']) ?>"
                                    data-customer="<?= htmlspecialchars($trx['customer']) ?>"
                                    data-employee="<?= htmlspecialchars($trx['employee_id']) ?>"
                                    data-date="<?= htmlspecialchars($trx['date']) ?>"
                                >
                                    <i class="fi fi-rr-edit"></i>
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-danger btn-delete"
                                    data-code="<?= htmlspecialchars($trx['trn_unit_code']) ?>"
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

<!-- Modal Tambah / Edit Transaksi -->
<div class="modal fade" id="modalTrn" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formTrn">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTrnTitle">Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="formMode" value="create">

                    <div class="mb-3">
                        <label class="form-label">Kode Transaksi</label>
                        <input type="text" class="form-control" id="trn_unit_code" name="trn_unit_code" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Unit</label>
                        <select class="form-select" id="mst_unit_code" name="mst_unit_code" required>
                            <option value="">-- Pilih Unit --</option>
                            <?php foreach ($units as $unit): ?>
                                <option value="<?= htmlspecialchars($unit['mst_unit_code']) ?>" data-price="<?= htmlspecialchars($unit['price']) ?>">
                                    <?= htmlspecialchars($unit['mst_unit_code']) ?> - <?= htmlspecialchars($unit['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control" id="price" name="price" required min="0" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Qty</label>
                        <input type="number" class="form-control" id="qty" name="qty" required min="1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Customer</label>
                        <input type="text" class="form-control" id="customer" name="customer" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sales</label>
                        <select class="form-select" id="employee_id" name="employee_id" required>
                            <option value="">-- Pilih Sales --</option>
                            <?php foreach ($employees as $emp): ?>
                                <option value="<?= htmlspecialchars($emp['employee_id']) ?>">
                                    <?= htmlspecialchars($emp['name']) ?> (<?= htmlspecialchars($emp['nik']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="date" name="date" required>
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
    $('#tableTrn').DataTable();

    var modalTrn = new bootstrap.Modal(document.getElementById('modalTrn'));

    $('#mst_unit_code').on('change', function () {
        var selectedPrice = $(this).find(':selected').data('price');
        $('#price').val(selectedPrice ?? '');
    });

    $('#tableTrn').on('click', '.btn-edit', function () {
        $('#formMode').val('update');
        $('#modalTrnTitle').text('Edit Transaksi');

        $('#trn_unit_code').val($(this).data('code'));
        $('#trn_unit_code').prop('readonly', true);
        $('#mst_unit_code').val($(this).data('unit'));
        $('#price').val($(this).data('price'));
        $('#qty').val($(this).data('qty'));
        $('#customer').val($(this).data('customer'));
        $('#employee_id').val($(this).data('employee'));
        $('#date').val($(this).data('date'));

        modalTrn.show();
    });

    $('#formTrn').on('submit', function (e) {
        e.preventDefault();

        var mode = $('#formMode').val();
        var action = (mode === 'update') ? 'update' : 'store';

        $.ajax({
            url: 'index.php?page=trnunit&action=' + action,
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    modalTrn.hide();
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

    $('#tableTrn').on('click', '.btn-delete', function () {
        var code = $(this).data('code');

        Swal.fire({
            icon: 'warning',
            title: 'Yakin hapus transaksi ini?',
            text: 'Data yang sudah dihapus tidak bisa dikembalikan.',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'index.php?page=trnunit&action=delete',
                    method: 'POST',
                    data: { trn_unit_code: code },
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

function resetForm() {
    $('#formTrn')[0].reset();
    $('#formMode').val('create');
    $('#modalTrnTitle').text('Tambah Transaksi');
    $('#trn_unit_code').prop('readonly', false);
}
</script>

</body>
</html>
