document.addEventListener('DOMContentLoaded', function () {
    const eye = document.getElementById('eye');
    if (eye) {
        eye.addEventListener('click', function () {
            this.classList.toggle('open');
            const icon = this.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            }
            const input = this.previousElementSibling;
            if (input) {
                input.type = this.classList.contains('open') ? 'text' : 'password';
            }
        });
    }

    const eye1 = document.getElementById('eye1');
    if (eye1) {
        eye1.addEventListener('click', function () {
            this.classList.toggle('open');
            const icon = this.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            }
            const input = this.previousElementSibling;
            if (input) {
                input.type = this.classList.contains('open') ? 'text' : 'password';
            }
        });
    }

    const eyeButtons = document.querySelectorAll('#account_eye, #account_eye_1, #account_eye_2, #account_eye_3, #account_eye_4');
    eyeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            this.classList.toggle('open');
            const icon = this.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            }
            const input = this.previousElementSibling;
            if (input) {
                input.type = this.classList.contains('open') ? 'text' : 'password';
            }
        });
    });
});
