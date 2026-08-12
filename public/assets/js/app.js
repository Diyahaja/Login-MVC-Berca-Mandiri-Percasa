// Konfirmasi logout pakai SweetAlert2 - dipasang di semua halaman yang punya sidebar
document.addEventListener('DOMContentLoaded', function () {
    var btnLogout = document.getElementById('btnLogout');

    if (btnLogout) {
        btnLogout.addEventListener('click', function (e) {
            e.preventDefault(); // cegah link langsung jalan
            var logoutUrl = btnLogout.getAttribute('href');

            Swal.fire({
                icon: 'question',
                title: 'Yakin mau logout?',
                text: 'Kamu akan keluar dari sistem.',
                showCancelButton: true,
                confirmButtonText: 'Ya, logout',
                cancelButtonText: 'Batal'
            }).then(function (result) {
                if (result.isConfirmed) {
                    window.location.href = logoutUrl;
                }
            });
        });
    }
});