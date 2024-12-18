document.addEventListener("DOMContentLoaded", function () {
    // Phần xử lý thêm lớp active cho menu
    const menuItems = document.querySelectorAll('.center-left a');
    const currentPage = window.location.pathname.split('/').pop(); // Lấy tên file hiện tại

    menuItems.forEach(item => {
        if (item.getAttribute('href') === currentPage) {
            item.closest('li').classList.add('active'); // Thêm lớp active cho thẻ <li>
        }
    });

    // Phần xử lý hiển thị và ẩn menuUser
    const toggleMenu = document.getElementById('toggleMenu');
    const menuUser = document.querySelector('.menuUser');

    toggleMenu.addEventListener('click', function () {
        menuUser.style.display = menuUser.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function (event) {
        if (!toggleMenu.contains(event.target) && !menuUser.contains(event.target)) {
            menuUser.style.display = 'none';
        }
    });
});

// Lấy tất cả các phần tử li
const items_menu = document.querySelectorAll('.center-left>ul>li');

// Thêm sự kiện click cho từng thẻ li
items_menu.forEach(item => {
    item.addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định nếu có

        // Lấy thẻ a bên trong thẻ li
        const link = this.querySelector('a');

        // Kiểm tra xem có thẻ a không
        if (link) {
            window.location.href = link.href; // Chuyển đến trang được chỉ định trong thẻ a
        }
    });
});
