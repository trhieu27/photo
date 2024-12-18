document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('overlay');
    
    overlay.addEventListener('click', function () {    
        overlay.style.display = "none";  
        submit_update = document.getElementById('submit_update');
        submit_update.style.display = "none";
    });
});

function confirmDelete() {
    return confirm("Bạn có chắc chắn muốn xóa người dùng này không?");
}

const items_menu = document.querySelectorAll('.selection>li');

items_menu.forEach(item => {
    item.addEventListener('click', function(event) {
        event.preventDefault();

        const link = this.querySelector('a');

        if (link) {
            window.location.href = link.href; 
        }
    });
});