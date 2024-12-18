<?php
    if (session_status() == PHP_SESSION_NONE) session_start(); 
    require_once "../../Controller/Session.php";
    require_once "../../Controller/Function.php";

    if (isset($_GET['controller'])) {
        $controllerName = $_GET['controller'];
    } else {
        $controllerName = 'Admin'; 
    }
    if (isset($_GET['action'])) {
        $actionName = $_GET['action'];
    } else {
        $actionName = 'login';
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

    $old = getSession('old');
    $error = getSession('error');
    removeSession('old');
    removeSession('error');
    $data=['pageTitle' => 'Đăng nhập'];
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
                        <a href="Login.php">Đăng nhập</a>
                    </li>
                    <li>
                        <a href="Register.php">Đăng ký</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div id="wrapper">
            <form method="post" action="Login.php?controller=Admin&action=login" id="form-login">
                <h1 class="form-heading">Đăng nhập</h1>
                <?php 
                    if (!empty($error['login']))
                     echo '<div class="alert">'. reset($error['login']).'</div>';
                ?>
                <div class="form-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" id="username" name="username" class="form-input" placeholder="Tên đăng nhập"
                        value="<?php echo $old['username'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <i class="fa-solid fa-key "></i>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Mật khẩu">
                    <div id="eye">
                        <i class="fa-solid fa-eye-slash "></i>
                    </div>
                </div>
                <button  class="form-submit">Đăng nhập</button>
            </form>
        </div>
    </div>
    <link rel="stylesheet" href="../templates/css/reset.css">
    <link rel="stylesheet" href="../templates/css/app.css">
    <script src="../templates/js/app.js"></script>
</body>

</html>