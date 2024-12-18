document.addEventListener('DOMContentLoaded', function () {
    const fullname = document.getElementById('full_name');
    const date = document.getElementById('date');
    const gender = document.getElementById('gender');
    const password = document.getElementById('reset_password');
    const email = document.getElementById('email');
    const avatar = document.getElementById('avatar');
    const submitFullname = document.getElementById('submit-fullname');
    const submitDate = document.getElementById('submit-date');
    const submitGender = document.getElementById('submit-gender');
    const submitPassword = document.getElementById('submit-password');
    const submitEmail = document.getElementById('submit-email');
    const submitAvatar = document.getElementById('submit-avatar');
    const overlay = document.getElementById('overlay');
    const cancelBtn = document.querySelector('.form_submit_cancel');

    fullname.addEventListener('click', function () {
        submitFullname.style.display = "block";
        overlay.style.display = "block";
    });

    date.addEventListener('click', function () {
        submitDate.style.display = "block";
        overlay.style.display = "block";
    });

    gender.addEventListener('click', function () {
        submitGender.style.display = "block";
        overlay.style.display = "block";
    });

    password.addEventListener('click', function () {
        submitPassword.style.display = "block";
        overlay.style.display = "block";
    });
    
    email.addEventListener('click', function () {
        submitEmail.style.display = "block";
        overlay.style.display = "block";
    });

    avatar.addEventListener('click', function () {
        submitAvatar.style.display = "block";
        overlay.style.display = "block";
    });

    cancelBtn.addEventListener('click', function (e) {
        e.preventDefault();
        submitFullname.style.display = "none"; 
        submitDate.style.display = "none";
        submitGender.style.display = "none";
        submitPassword.style.display = "none";
        submitEmail.style.display = "none";
        submitAvatar.style.display = "none";
        overlay.style.display = "none";
    });

    overlay.addEventListener('click', function () {
        submitFullname.style.display = "none"; 
        submitFullname.style.display = "none"; 
        submitDate.style.display = "none";
        submitGender.style.display = "none";
        submitPassword.style.display = "none";
        submitEmail.style.display = "none";
        submitAvatar.style.display = "none";
        overlay.style.display = "none";
    });
});


document.getElementById('add_avatar').addEventListener('click', function() {
    document.getElementById('fileInput').click();
});

document.getElementById('fileInput').addEventListener('change', function () {
    document.getElementById('submit_file').click();
});
