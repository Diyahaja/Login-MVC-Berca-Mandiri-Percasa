<?php $pageTitle = 'Login - ' . APP_NAME; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="page-wrapper">

    <div class="login-card">
        <div class="logo-circle">
            <img src="assets/img/logo.png" alt="logo-berca" class="logo-img">
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert-error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="index.php?page=auth&action=login" method="POST" class="login-form" novalidate>

            <div class="input-group">
                <input
                    type="text"
                    name="identifier"
                    placeholder="Email or Username"
                    value="<?= htmlspecialchars($old['identifier'] ?? '') ?>"
                    autocomplete="username"
                    required
                >
            </div>

            <div class="input-group password-group">
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Password"
                    autocomplete="current-password"
                    required
                >
                <span class="toggle-password" id="togglePassword">&#128065;</span>
            </div>

            <div class="forgot-wrapper">
                <a href="#" class="forgot-link">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-signin">Sign in</button>

            <p class="register-text">
                Don't have an account? <a href="#" class="register-link">
                    <img src="assets/img/headphone.png" alt="contact" class="headphone-icon">
                </a>
            </p>
        </form>
    </div>

    <footer class="page-footer">
        Copyright &copy; <?= date('Y') ?> &nbsp;&bull;&nbsp;
        <a href="#"><?= htmlspecialchars(APP_NAME) ?></a>
    </footer>

</div>

<script src="assets/js/login.js"></script>
</body>
</html>
