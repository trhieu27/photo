<?php
    
    require_once '../../Model/Entity_User.php';
    require_once '../../Model/Model_Image.php';
    require_once '../../Model/Entity_Image.php';
    require_once "../../Controller/Session.php";
    require_once "../../Controller/Function.php";
    if (session_status() == PHP_SESSION_NONE) session_start(); 
    $account = getSession('account');
    if (empty($account))
    {
        die('Access denied...');
    }
    if (isset($_GET['controller'])) {
        $controllerName = $_GET['controller'];
    } else {
        $controllerName = 'Image'; 
    }
    if (isset($_GET['action'])) {
        $actionName = $_GET['action'];
    } else {
        $actionName = 'sp_upload';
    }
    $controllerClass = 'Controller_' . $controllerName;
    $controllerFile = '../../Controller/' . $controllerClass . '.php';

    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controller = new $controllerClass();

        if (method_exists($controller, $actionName)) {
            $controller->$actionName();
        }
    }
    $picture = getSession('picture');
    removeSession('pictute');   
    $data=['pageTitle' => 'Xem ảnh'];
?>

<!DOCTYPE html>
<html lang="en">

<?php layouts('Header', $data); ?>
<link rel="stylesheet" href="../templates/css/home.css">
<link rel="stylesheet" href="../templates/css/picture.css">
<body>
    <?php layouts('Center', $data, $account) ?>  
    <div class="center">
        <?php layouts('Menu') ?>
        <div class="center-center">
            <div class="display-picture" id="display-pic">
                <div class="folders">
                    <div class="title-folder">
                        <p>
                            Ảnh của tôi
                        </p>
                    </div>
                    <div class="create-folder"> 
                        <form action="See_Picture.php?controller=Image&action=delete_image" method="post" class="select-form">
                            <div class="options" id="options">
                                <input type="image" width="20" src="../templates/image/delete.png" alt="Submit" name="delete" class="delete" id="delete">
                                <input type="image" width="20" src="../templates/image/download.png" alt="Submit" name="download" id="download">
                                <div id="cmt"></div>
                            </div>
                        </form>
                        <form action="See_Picture.php?controller=Image&action=sp_upload"></form>
                            <div class="upload-img">
                                <div class="new-folder" id="new-folder">
                                    <i class="fa-solid fa-plus"></i>Tải ảnh lên
                                </div>
                                <input type="file" id="fileInput" name="image" accept=".jpg,.png" style="display: none;">
                            </div>
                        </form>
                    </div>
                    <form action="See_Picture.php" method="post">
                        <div class="Image-list" id="imageList">                            
                            <?php
                                if (!empty($picture))
                                    {
                                    $picture = array_reverse($picture);
                                    foreach ($picture as $key => $value) 
                                    {                                   
                                        echo '
                                            <div class="image">
                                                <input type="checkbox" class="img-checkbox" value="'.$value->id.'">
                                                <img class="thumbnail" id="'.$value->id.'" src="'.$value->photo_url.'" alt="" width="200"
                                                data-type="' . htmlspecialchars($value->type_img) . '"
                                                data-size="' . htmlspecialchars($value->size_img) . '"
                                                data-date="' . htmlspecialchars($value->date_img) . '"
                                                data-dimensions="' . htmlspecialchars($value->dimensions) . '">
                                            </div>';
                                    }
                                }?>
                        </div>
                    </form>
                    <div id="modal" class="modal">
                        <span class="close">&times;</span>
                        <img class="modal-content" id="img01">
                        <a class="prev" id="prevBtn">&#10094;</a>
                        <a class="next" id="nextBtn">&#10095;</a>
                    </div>   
                </div>
                <div class="detail" id="detail">
                    <div class="detail-img">
                        <img id="img02"> 
                    </div>
                    <div class="detail-list">
                        <ul>
                            <li class="detail-li">
                                <label class="detail-label">Chi tiết</label>
                            </li>
                            <li class="detail-li">
                                <label>Loại tệp</label>
                                <label class="detail-li-label" id="type"></label>
                            </li>
                            <li class="detail-li">
                                <label>Kích cỡ</label>
                                <label class="detail-li-label" id="size"></label>
                            </li>
                            <li class="detail-li">
                                <label>Thời gian</label>
                                <label class="detail-li-label" id="time"></label>
                            </li>
                            <li class="detail-li">
                                <label>Kích thước (w x h)</label>
                                <label class="detail-li-label" id="dimensions"></label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <link rel="stylesheet" href="../templates/css/reset.css">
        <script src="../templates/js/main.js" defer></script>
        <script src="../templates/js/see_picture.js" defer></script>
</body>

</html>