<?php

    if (session_status() == PHP_SESSION_NONE) session_start(); 
    require_once "../../Controller/Session.php";
    require_once "../../Controller/Function.php";

    if (isset($_GET['controller'])) {
        $controllerName = $_GET['controller'];
    } else {
        $controllerName = 'User'; 
    }
    if (isset($_GET['action'])) {
        $actionName = $_GET['action'];
    } else {
        $actionName = 'resetpassword';
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
    $error = getSession('error');  
    $old = getSession('old');  
    removeSession('error');
    removeSession('old');
    $data=['pageTitle' => 'Nhập lại nật khẩu'];

?>

<!DOCTYPE html>
<html lang="en">

<?php layouts('header', $data); ?>

<body>
    <div>
        <div id="header">
            <nav class="container">
                <ul id="main-menu">
                    <li>
                        <a href="../pages/index.html" id="index">
                            <i class="fa-solid fa-house"></i>Trang chủ
                        </a>
                    </li>
                </ul>
                <ul id="main-menu">
                    <li>
                        <a href="login.php">Đăng nhập</a>
                    </li>
                    <li>
                        <a href="register.php">Đăng ký</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div id="wrapper">
            <form method="post" action="Resetpassword.php?controller=User&action=resetpassword" id="form-register">
                <h1 class="form-heading">Đặt lại mật khẩu</h1>
                <?php 
                if (!empty($error['password']))
                echo '<div class="error">* '. reset($error['password']).'</div>';
                ?>
                <div class="form-group">
                    <i class="fa-solid fa-key"></i>
                    <input name="password" type="password" class="form-input" placeholder="Mật khẩu">
                    <div id="eye" class="eye">
                        <i class="fa-solid fa-eye-slash"></i>
                    </div>
                </div>
                <div class="form-group">
                    <i class="fa-solid fa-key"></i>
                    <input name="reEnterPassword" type="password" class="form-input" placeholder="Nhập lại mật khẩu">
                    <div id="eye1" class="eye">
                        <i class="fa-solid fa-eye-slash"></i>
                    </div>
                </div>
                <input  type="submit" class="form-submit" value="Xác nhận">
            </form>
        </div>
    </div>
    <link rel="stylesheet" href="../templates/css/reset.css">
    <link rel="stylesheet" href="../templates/css/register.css">
    <script src="../templates/js/app.js "></script>
</body>

</html>
