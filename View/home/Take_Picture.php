
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
        $actionName = 'tp_upload';
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
    $data=['pageTitle' => 'Chụp ảnh'];

?>

<!DOCTYPE html>
<html lang="en">

<?php layouts('Header', $data); ?>

<body>
    <?php layouts('Center', $data, $account) ?>  
    <div class="center">
        <?php layouts('Menu') ?>
        <div class="center-center">
            <div class="take-picture" id="pictureContent">
                <div class="take-picture-main">
                    <div class="picture">
                        <video class="_video" id="video" autoplay playsinline></video>
                        <div class="func">  
                            <div class="_button">
                                <input type="submit" id="in_capture" style="display: none"><i class="fa-solid fa-camera" id="capture"></i>
                            </div>
                        </div>
                    </div>
                    <div class="upload">
                        <canvas class="_video" id="canvas" name="image"></canvas>
                        <div id="imageList"></div>
                    </div>
                </div>
                <div id="modal" class="modal">
                    <span class="close">&times;</span>
                    <img class="modal-content" id="img01">
                    <a class="prev" id="prevBtn">&#10094;</a>
                    <a class="next" id="nextBtn">&#10095;</a>
                </div>
            </div>
        </div>
        
    </div>
    <link rel="stylesheet" href="../templates/css/reset.css">
    <link rel="stylesheet" href="../templates/css/home.css">
    <script src="../templates/js/main.js" defer></script>
    <script src="../templates/js/take_picture.js" defer></script>
</body>

</html>

