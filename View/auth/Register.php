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
        $actionName = 'register';
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

    $smg = getSession('smg');
    $error = getSession('error');  
    $old = getSession('old');  
    removeSession('smg');
    removeSession('old');
    removeSession('error');
    $data=['pageTitle' => 'Đăng ký'];
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
            <form method="post" action="Register.php?controller=User&action=register" id="form-register">
                <h1 class="form-heading">Đăng ký</h1>
                <?php 
                    if (!empty($smg))
                     echo '<div class="alert">'. $smg.'</div>';
                ?>
                <?php 
                if (!empty($error['full_name']))
                echo '<div class="error">* '. reset($error['full_name']).'</div>';
                ?>
                <div class="form-group">    
                    <i class="fa-solid fa-user"></i>
                    <input name="full_name" type="text" class="form-input" placeholder="Họ và tên" 
                           value="<?php echo $old['full_name'] ?? ''; ?>">
                </div>
                <?php 
                if (!empty($error['date']))
                echo '<div class="error">* '. reset($error['date']).'</div>';
                ?>
                <div class="form-group">    
                    <i class="fa-solid fa-calendar-days"></i>
                    <input name="date" type="date" class="form-input" placeholder="Ngày sinh" 
                           value="<?php echo $old['date'] ?? ''; ?>">
                </div>
                <?php 
                if (!empty($error['gender']))
                echo '<div class="error">* '. reset($error['gender']).'</div>';
                ?>
                <div class="form-group">    
                    <i class="fa-solid fa-mars-and-venus"></i>
                    <div><input class="radio-gender" type="radio" name="gender" value="Nam" <?php if (!empty($old['gender'])) if ($old['gender'] == 'Nam') echo 'checked'; ?>> 
                    <label>Nam</label>
                    <input class="radio-gender" type="radio" name="gender" value="Nữ" <?php if (!empty($old['gender'])) if ($old['gender'] == 'Nữ') echo 'checked'; ?>> 
                    <label>Nữ</label>
                    </div>
                </div>
                <?php 
                if (!empty($error['email']))
                echo '<div class="error">* '. reset($error['email']).'</div>';
                ?>
                <div class="form-group">
                    <i class="fa-solid fa-envelope"></i>
                    <input name="email" type="email" class="form-input" placeholder="Email"
                           value="<?php echo $old['email'] ?? ''; ?>"> 
                </div>
                <?php 
                if (!empty($error['username']))
                echo '<div class="error">* '. reset($error['username']).'</div>';
                ?>
                <div class="form-group">
                    <i class="fa-solid fa-user"></i>
                    <input name="username" type="text" class="form-input" placeholder="Tên đăng nhập"
                           value="<?php echo $old['username'] ?? ''; ?>"> 
                </div>
                <?php 
                if (!empty($error['password']))
                echo '<div class="error">* '. reset($error['password']).'</div>';
                ?>
                <div class="form-group">
                    <i class="fa-solid fa-key"></i>
                    <input name="password" type="password" class="form-input" placeholder="Mật khẩu">
                    <div id="eye">
                        <i class="fa-solid fa-eye-slash"></i>
                    </div>
                </div>
                <input  type="submit" class="form-submit" value="Đăng ký">
            </form>
        </div>
    </div>
    <link rel="stylesheet" href="../templates/css/reset.css">
    <link rel="stylesheet" href="../templates/css/register.css">
    <script src="../templates/js/app.js "></script>
</body>

</html>
