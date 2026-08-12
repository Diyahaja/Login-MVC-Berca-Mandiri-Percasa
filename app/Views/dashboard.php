<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - <?= htmlspecialchars(APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php require __DIR__ . '/partials/navbar.php'; ?>

<div class="page-wrapper">
    <div class="login-card" style="text-align:center;">
        <div class="logo-circle">
            <span class="logo-text">BERCA</span>
        </div>
        <h2 style="margin-top:20px;">Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
        <p style="color:#666; margin-bottom:24px;">Kamu berhasil login.</p>
        <a href="index.php?page=auth&action=logout" class="btn-signin" style="display:inline-block; text-decoration:none; box-sizing:border-box;">Logout</a>
    </div>
</div>
</body>
</html>
