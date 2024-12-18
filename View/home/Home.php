<?php
    
    require_once '../../Model/Entity_User.php';
    require_once "../../Controller/Session.php";
    require_once "../../Controller/Function.php";
    if (session_status() == PHP_SESSION_NONE) session_start(); 
    $account = getSession('account');
    if (empty($account))
    {
        die('Access denied...');
    }

    $account = getSession('account');
    $data=['pageTitle' => 'Trang chủ'];
?>

<!DOCTYPE html>
<html lang="en">

<?php layouts('Header', $data); ?>

<body>
<?php layouts('Center', $data, $account) ?>  
    <div class="center">
        <?php layouts('Menu') ?>  
        <div class="center-center">
            <div class="use" id="guideContent">
                <div class="manual">
                    <div class="header">
                        <p>HƯỚNG DẪN</p>
                    </div>
                    <div class="use-content">
                        <p>1. Kết nối Webcam: Đảm bảo webcam đã được kết nối và nhận diện bởi ứng dụng.</p>
                        <p>2. Chọn Chế Độ Chụp: Mở ứng dụng và chọn chế độ chụp ảnh. </p>
                        <p>3. Chụp Ảnh: Nhấn nút "Chụp" để ghi lại hình ảnh.</p>
                        <p>4. Xác Nhận: Kiểm tra thông báo xác nhận gửi thành công. </p>
                        <p>5. Xem ảnh: Chọn chế độ xem ảnh để xem tất cả các ảnh đã chụp hoặc tải lên. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="../templates/css/reset.css">
    <link rel="stylesheet" href="../templates/css/home.css">
    <script src="../templates/js/main.js" defer></script>
</body>
</html>