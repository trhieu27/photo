<?php
    require_once '../../Model/Entity_Image.php';
    require_once "../../Controller/Session.php";
    require_once "../../Controller/Function.php";
    if (session_status() == PHP_SESSION_NONE) session_start(); 
    $account = getSession('admin');
    if (empty($account))
    {
        die('Access denied...');
    }
    if (isset($_GET['controller'])) {
        $controllerName = $_GET['controller'];
    if (isset($_GET['action'])) {
        $actionName = $_GET['action'];
        $controllerClass = 'Controller_' . $controllerName;
        $controllerFile = '../../Controller/' . $controllerClass . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
                $controller = new $controllerClass();
                if (method_exists($controller, $actionName)) {
                    $controller->$actionName($_GET['folder_id']); 
                }
            }
        } 
    } 
    $imgs = getSession('imgs');
    if (!isset($folder)) {
        $controllerName = 'Admin';
        $actionName = 'getAllImage';
        $controllerClass = 'Controller_' . $controllerName;
        $controllerFile = '../../Controller/' . $controllerClass . '.php';if (file_exists($controllerFile)) {
        require_once $controllerFile;
            $controller = new $controllerClass();
            if (method_exists($controller, $actionName)) {
                $controller->$actionName($_GET['folder_id']);
            }
        }
        $Folder = getSession('fols');
    }
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thư viện ảnh</title>
    <script src="../templates/js/picture.js" defer></script>
    <link rel="stylesheet" href="../templates/css/lib-file.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <a class="iconic" href=""><img src="../templates/image/Cloud.png" alt="" id="cloud-icon"></a>
            <p class="welcom">Welcom to Admin's Home</p>
        </div>
        <div class="main-container">
            <div class="menu">
                <ul class="selection">
                    <li>
                        <a href="Account.php?controller=Admin&action=getAllUser">
                        <img class="icon" src="../templates/image/account.png" alt="">Tài khoản
                        </a>
                    </li>
                    <li>
                        <a href="Library.php?controller=Admin&action=getAllFolder">
                        <img class="icon" src="../templates/image/gallery.png" alt="">Thư viện
                        </a>
                    </li>
                </ul>
            </div>
            <div class="main-content" id="main-content"> 
                <div class="options" id="options">
                        <div id="cmt"></div>
                        <input type="hidden" name="" id="folder_id" value="<?php if (!empty($_GET['folder_id'])) echo $_GET['folder_id']?>">
                        <input type="image" width="20" src="../templates/image/delete.png" alt="Submit" name="delete" class="delete" id="delete">
                    </div>
                <div class="content_detail">
                    <div class="content">    
                        <div class="files" id="files">
                            <div class="Image-list" id="imageList" data-id="<?php echo $id; ?>">
                            <?php
                            if (!empty($imgs))
                            {
                            foreach ($imgs as $key => $value) {
                                echo '
                                <div class="image">
                                    <input type="checkbox" class="img-checkbox" value="' . $value->id . '">
                                    <img class="thumbnail" id="' . $value->id . '" src="' . $value->photo_url . '" alt="" width="200"
                                    data-type="' . htmlspecialchars($value->type_img) . '"
                                    data-size="' . htmlspecialchars($value->size_img) . '"
                                    data-date="' . htmlspecialchars($value->date_img) . '"
                                    data-dimensions="' . htmlspecialchars($value->dimensions) . '">
                                </div>';
                                }
                            }
                            ?>
                            </div>
                            <div id="modal" class="modal">
                                <span class="close">&times;</span>
                                <img class="modal-content" id="img01">
                                <a class="prev" id="prevBtn">&#10094;</a>
                                <a class="next" id="nextBtn">&#10095;</a>
                            </div>
                        </div>
                    </div>
                        <div class="detail-container" id="detail">
                            <div class="detail">
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
                </div>
            </div>
        </div>
    </div>
</body>

</html>