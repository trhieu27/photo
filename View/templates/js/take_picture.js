let cameraStream;
let videoStream;

const video = document.getElementById("video");
const canvas = document.getElementById("canvas");
const context = canvas.getContext("2d");

if (!videoStream) {
    navigator.mediaDevices.getUserMedia({
        video: true
    })
        .then(stream => {
            video.srcObject = stream;
            videoStream = stream;
        })
        .catch(err => {
            console.error("Error accessing webcam: ", err);
        });
}

const imageList = document.getElementById('imageList');
const modal = document.getElementById('modal');
const modalImg = document.getElementById('img01');
const closeBtn = document.querySelector('.close');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
let currentIndex = 0;

document.getElementById('capture').addEventListener('click', () => {
    canvas.width = 800; 
    canvas.height = 600; 
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    canvas.toBlob(blob => {
        const formData = new FormData();
        formData.append("image", blob, "captured_image.png");

        const item = document.createElement('div');
        const img = document.createElement('img');
        img.id = 'thumbnail';
        img.src = URL.createObjectURL(blob);
        let currentIndex = 0;
        item.appendChild(img);
        imageList.insertBefore(item, imageList.firstChild);
        const thumbnails = document.querySelectorAll('#thumbnail');
        thumbnails.forEach((thumbnail, index) => {
            if (index > 0 && thumbnails.length != 1)
                thumbnail.style.display = 'none';
        });
        img.addEventListener('click', function () {
            modal.style.display = "block";
            modalImg.src = this.src;
            currentIndex = Array.from(imageList.querySelectorAll('img')).indexOf(this); // Lưu chỉ số ảnh hiện tại
        });

        closeBtn.addEventListener('click', () => {
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

        fetch('../../View/home/Take_Picture.php', {
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
                        img.src = jsonData.filePath;
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
    }, 'image/png');
});
