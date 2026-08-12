<div class="app-sidebar d-flex flex-column p-3 text-white">
    <a href="index.php?page=unit&action=index" class="sidebar-brand d-flex align-items-center gap-2 mb-3 text-white text-decoration-none">
        <img src="assets/img/logo.png" alt="logo" class="sidebar-logo" onerror="this.style.display='none'">
        <span class="fw-bold sidebar-brand-text"><?= htmlspecialchars(APP_NAME) ?></span>
    </a>
    <hr class="text-secondary">

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="index.php?page=unit&action=index"
               class="nav-link text-white <?= ($_GET['page'] ?? '') === 'unit' ? 'active' : '' ?>">
                Master
            </a>
        </li>
        <li class="nav-item">
            <a href="index.php?page=trnunit&action=index"
               class="nav-link text-white <?= ($_GET['page'] ?? '') === 'trnunit' ? 'active' : '' ?>">
                Transaksi 
            </a>
        </li>
    </ul>

    <hr class="text-secondary">
    <div class="small text-secondary mb-2">
        Login sebagai <strong class="text-white"><?= htmlspecialchars($_SESSION['username'] ?? '') ?></strong>
    </div>
    <a href="index.php?page=auth&action=logout" id="btnLogout" class="nav-link text-white">Logout</a>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    var btnLogout = document.getElementById('btnLogout');
    if (btnLogout) {
        btnLogout.addEventListener('click', function (e) {
            e.preventDefault();
            var logoutUrl = this.href;

            Swal.fire({
                icon: 'question',
                title: 'Yakin mau keluar?',
                text: 'Kamu akan keluar dari sistem.',
                showCancelButton: true,
                confirmButtonText: 'Ya, keluar',
                cancelButtonText: 'Batal'
            }).then(function (result) {
                if (result.isConfirmed) {
                    window.location.href = logoutUrl;
                }
            });
        });
    }
});
</script>