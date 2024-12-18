
document.querySelectorAll('.fa-ellipsis-vertical').forEach(icon => {
    icon.addEventListener('click', function (event) {
        event.stopPropagation(); // Ngăn không cho sự kiện click lan ra ngoài

        // Ẩn tất cả các context menu khác
        document.querySelectorAll('.context-menu').forEach(menu => {
            menu.style.display = 'none'; // Ẩn tất cả các menu khác trước khi hiển thị menu hiện tại
        });

        // Lấy context menu tương ứng với biểu tượng vừa được click
        const contextMenu = this.parentElement.parentElement.querySelector('.context-menu');

        // Kiểm tra xem có tìm thấy context menu không
        if (contextMenu) {
            // Hiển thị menu
            contextMenu.style.display = 'block';
        }
    });
});

// Ẩn context menu khi nhấn ra ngoài
document.addEventListener('click', function () {
    document.querySelectorAll('.context-menu').forEach(menu => {
        menu.style.display = 'none';
    });
});


// Khi nhấn vào nút "Đổi tên"
document.querySelectorAll('.context-menu-rename').forEach(menu => {
    menu.addEventListener('click', function (event) {
        event.stopPropagation();

        // Ẩn tất cả context menu khác
        document.querySelectorAll('.context-menu').forEach(menu => {
            menu.style.display = 'none';
        });

        // Hiển thị form đổi tên
        const rename = this.closest('.menu-folder').querySelector('.form-rename');
        if (rename) {
            rename.style.display = 'block';

            // Hiển thị lớp phủ để chặn tương tác bên ngoài
            document.getElementById('overlay').style.display = 'block';

            // Lấy tên folder và đưa vào input
            const folderName = this.closest('.menu-folder').querySelector('.name-folder').textContent;
            const renameInput = rename.querySelector('input.rename');
            renameInput.value = folderName;
            renameInput.focus();
            renameInput.select();
        }
    });
});

// Khi nhấn "Hủy" hoặc "X" để đóng form
document.querySelectorAll('.btn-cancel input, .label-rename i').forEach(btn => {
    btn.addEventListener('click', function (event) {
        // Ẩn form đổi tên
        const rename = this.closest('.form-rename');
        rename.style.display = 'none';

        // Ẩn lớp phủ overlay
        document.getElementById('overlay').style.display = 'none';
    });
});


document.querySelectorAll('.delete-container').forEach(icon => {
    icon.addEventListener('click', function (event) {
        event.stopPropagation();
        const form = this.closest('form'); // Lấy form gần nhất
        form.submit(); // Gửi form nếu xác nhận
    });
});




document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll('.center-left a');

    // Lấy URL hiện tại
    const currentPage = window.location.pathname.split('/').pop(); // Lấy tên file hiện tại

    // Thêm lớp active cho mục tương ứng
    menuItems.forEach(item => {
        if (item.getAttribute('href') === currentPage) {
            item.closest('li').classList.add('active'); // Thêm lớp active cho thẻ <li>
        }
    });

});


// Chọn tất cả các phần tử li trong danh sách
const items = document.querySelectorAll('.folder>ul>li');
let clickTimeout;
let selectedImg = new Set();
// Thêm sự kiện click cho từng phần tử
items.forEach(item => {
    item.addEventListener('click', function (event) {
        // Ngăn sự kiện click lan ra ngoài
        event.stopPropagation();

        // Xóa lớp 'clicked' từ tất cả các phần tử
        items.forEach(i => i.classList.remove('clicked'));

        // Sử dụng setTimeout để trì hoãn hành động click
        clearTimeout(clickTimeout);
        clickTimeout = setTimeout(() => {
            // Thêm lớp 'clicked' vào phần tử đang được nhấn
            this.classList.add('clicked');
            item.style.border = '2px solid red';
            console.log("Đã nhấn");
        }, 25); // Trì hoãn 250ms để xem người dùng có nhấp đúp không

    });
});

// Thêm sự kiện dblclick cho từng thẻ li
items.forEach(item => {
    item.addEventListener('dblclick', function (event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định nếu có

        // Xóa setTimeout của sự kiện click
        clearTimeout(clickTimeout);

        // Lấy thẻ a bên trong thẻ li
        const link = this.querySelector('a');

        // Kiểm tra xem có thẻ a không
        if (link) {
            window.location.href = link.href; // Chuyển đến trang được chỉ định trong thẻ a
        }
    });
});

// Thêm sự kiện click cho toàn bộ tài liệu
document.addEventListener('click', function () {
    // Xóa lớp 'clicked' từ tất cả các phần tử khi nhấn ra ngoài
    items.forEach(i => i.classList.remove('clicked'));
});

let currentIndex = 0;
const modal = document.getElementById('modal');
const modalImg = document.getElementById('img01');
const modalImgDetail = document.getElementById('img02');
const closeBtn = document.querySelector('.close');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const detail = document.getElementById('detail');
const thumbnails = document.querySelectorAll('.thumbnail');
thumbnails.forEach((thumbnail, index) => {
    thumbnail.addEventListener('dblclick', function () {
        modal.style.display = "block";
        modalImg.src = this.src;
        currentIndex = index;
    });
});

thumbnails.forEach((thumbnail, index) => {
    thumbnail.addEventListener('click', function () {
        setTimeout(() => {
            detail.style.display = "block";
            modalImgDetail.src = this.src;

            const imageType = this.getAttribute('data-type');
            const imageSize = this.getAttribute('data-size');
            const imageDate = this.getAttribute('data-date');
            const imageDimensions = this.getAttribute('data-dimensions');

            document.getElementById('type').textContent = imageType;
            document.getElementById('size').textContent = imageSize;
            document.getElementById('time').textContent = imageDate;
            document.getElementById('dimensions').textContent = imageDimensions;
        }, 200);
    });
});

document.addEventListener('click', function (event) {
    const isClickInsideDetail = detail.contains(event.target);
    const isClickInsideThumbnail = Array.from(thumbnails).some(thumbnail => thumbnail.contains(event.target));

    if (!isClickInsideDetail && !isClickInsideThumbnail) {
        detail.style.display = "none";
    }
});


// Đóng modal khi nhấp vào dấu "X"
closeBtn.addEventListener('click', function () {
    modal.style.display = "none";
});

// Di chuyển qua ảnh trước đó
prevBtn.addEventListener('click', function () {
    currentIndex = (currentIndex > 0) ? currentIndex - 1 : thumbnails.length - 1;
    modalImg.src = thumbnails[currentIndex].src;
});

// Di chuyển qua ảnh tiếp theo
nextBtn.addEventListener('click', function () {
    currentIndex = (currentIndex < thumbnails.length - 1) ? currentIndex + 1 : 0;
    modalImg.src = thumbnails[currentIndex].src;
});

// Đóng modal khi nhấp ra ngoài hình ảnh
modal.addEventListener('click', function (event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});

document.getElementById('new-folder').addEventListener('click', function () {
    document.getElementById('fileInput').click();
});


const uploadname = document.getElementById('upload-name');
const submitimg = document.getElementById('submit-img');
const fileInput = document.getElementById('fileInput');
const loading = document.getElementById('loading');
//Tải ảnh lên web
fileInput.addEventListener('change', function (event) {
    const files = fileInput.files;
    if (files.length > 0) {
        const formData = new FormData();
        formData.append('image', files[0]);

        fetch('../../View/home/See_Picture.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                console.log("Server raw response:", data);
                try {
                    const jsonData = JSON.parse(data);
                    console.log("Parsed JSON data:", jsonData);
                    if (jsonData.error) {
                        alert(jsonData.error);
                    } else {
                        alert(jsonData.success);
                        location.reload();
                    }
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                    alert("Có lỗi xảy ra khi xử lý phản hồi từ server.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Có lỗi xảy ra khi gửi ảnh lên server.");
            })
    }
});



//Kiểm tra ảnh được chọn
document.querySelectorAll('.img-checkbox').forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        const allCheckboxes = document.querySelectorAll('.img-checkbox');
        const imageList = document.getElementById('imageList');
        const option = document.getElementById('options');
        const download = document.getElementById('download');
        // Nếu có ít nhất một checkbox được chọn
        if (Array.from(allCheckboxes).some(cb => cb.checked)) {
            imageList.classList.add('show-checkbox'); // Hiển thị tất cả checkbox
            option.style.visibility = 'visible';
            //Hiển thị button xóa
        } else {
            imageList.classList.remove('show-checkbox'); // Ẩn checkbox nếu không có checkbox nào được chọn
            option.style.visibility = 'hidden';
        }
        if (options.style.visibility === 'visible') {
            let cmt = document.getElementById('cmt');
            let count = 0;
            document.querySelectorAll('.img-checkbox:checked').forEach(checkbox => {
                count++;
            });
            if (count > 1) {
                download.disabled = true;
                download.style.filter = "blur(0.7px)";
            }
            else {
                download.disabled = false;
            }
            cmt.innerHTML = 'Có ' + count + ' ảnh được chọn';
        }
    });
});

//Xóa ảnh
document.getElementById('delete').addEventListener('click', function () {
    const selectedImages = [];
    document.querySelectorAll('.img-checkbox:checked').forEach(checkbox => {
        selectedImages.push(checkbox.value);
    });

    if (selectedImages.length === 0) {
        alert("Vui lòng chọn ảnh để xóa.");
        return;
    }

    console.log("Dữ liệu gửi đi:", selectedImages); 
    if (confirm("Bạn có chắc chắn muốn xóa các ảnh đã chọn không?")) {
        const formData = new FormData();
        selectedImages.forEach((image_id, index) => {
            formData.append('image_ids[]', image_id);
        });

        fetch('../../View/home/See_Picture.php?controller=Image&action=delete_image', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text())
            .then(data => console.log("Phản hồi từ server:", data)) 
            .catch(error => console.error("Lỗi:", error));
        
    }
})


document.getElementById('download').addEventListener('click', function () {
    const selectedImages = [];
    document.querySelectorAll('.img-checkbox:checked').forEach(checkbox => {
        selectedImages.push(checkbox.value);
    });
    if (selectedImages.length != 1) return;
    const imgID = selectedImages[0];
    const image = document.getElementById(imgID);
    const imagePath = image.src;
    const link = document.createElement('a');
    link.href = imagePath;
    link.download = 'image.jpg'; 
    link.click();  
});

