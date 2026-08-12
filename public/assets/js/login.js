document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.getElementById('togglePassword');
    var passwordInput = document.getElementById('password');

    if (toggle && passwordInput) {
        toggle.addEventListener('click', function () {
            var isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            toggle.style.opacity = isHidden ? '1' : '0.6';
        });
    }
});
