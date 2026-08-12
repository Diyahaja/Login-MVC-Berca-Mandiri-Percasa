<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#4d8dee;">
    <div class="container">
        <a class="navbar-brand" href="index.php?page=dashboard"><?= htmlspecialchars(APP_NAME) ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=unit&action=index">Master Unit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=trnunit&action=index">Transaksi Unit</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=auth&action=logout">
                        Logout (<?= htmlspecialchars($_SESSION['username'] ?? '') ?>)
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
