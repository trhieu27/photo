//Kiểm tra ảnh được chọn
document.querySelectorAll('.img-checkbox').forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        const allCheckboxes = document.querySelectorAll('.img-checkbox');
        const imageList = document.getElementById('imageList');
        const option = document.getElementById('options');
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
    const imgList = document.getElementById('imageList');
    const id = imgList.getAttribute('data-id');
    if (selectedImages.length === 0) {
        alert("Vui lòng chọn ảnh để xóa.");
        return;
    }
    console.log("Dữ liệu gửi đi:", selectedImages); // Kiểm tra dữ liệu được gửi

    if (confirm("Bạn có chắc chắn muốn xóa các ảnh đã chọn không?")) {
        const formData = new FormData();
        selectedImages.forEach((image_id, index) => {
            formData.append('image_ids[]', image_id);
        });

        const folder_id = document.getElementById('folder_id').value;
        fetch('../../View/admin_home/Lib_file.php?controller=Admin&action=ad_delete_image&folder_id='+folder_id, {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text()) // Dự kiến phản hồi dạng text
            .then(data => {
                window.location.href = '../../View/admin_home/Lib_file.php?controller=Image&action=getAllImage&folder_id='+folder_id;
            })
            .catch(error => alert("Lỗi: " + error));
    }
})

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