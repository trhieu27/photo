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
        $actionName = 'forgot';
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
    $data=['pageTitle' => 'Quên mật khẩu'];

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
                        <a href="../../index.php" id="index ">
                            <i class="fa-solid fa-house "></i>Trang chủ
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
            <form method="post" action="Forgot.php?controller=User&action=forgot" id="form-login">
                <h1 class="form-heading">Quên mật khẩu</h1>
                <?php 
                    if (!empty($error['forgot']))
                     echo '<div class="alert">'. reset($error['forgot']).'</div>';
                ?>
                <div class="form-group">
                    <i class="fa-solid fa-envelope"></i>
                    <input name="email" type="email" class="form-input" placeholder="Email"
                           value="<?php echo $old['email'] ?? ''; ?>"> 
                </div>
                <button  class="form-submit">Gửi</button>
            </form>
        </div>
    </div>
    <link rel="stylesheet" href="../templates/css/reset.css">
    <link rel="stylesheet" href="../templates/css/app.css">
    <script src="../templates/js/app.js"></script>
</body>

</html>