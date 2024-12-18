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
    if (isset($_GET['controller'])) {
        $controllerName = $_GET['controller'];
    } else {
        $controllerName = 'User'; 
    }
    if (isset($_GET['action'])) {
        $actionName = $_GET['action'];
    } else {
        $actionName = 'account';
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
    removeSession('error');
    $data=['pageTitle' => 'Tài khoản'];
?>

<!DOCTYPE html>
<html lang="en">

<?php layouts('Header', $data); ?>

<body>  
    <?php 
        if (!empty($error['date']) || !empty($error['password']) || !empty($error['email'])) 
        {
            echo '<div id="overlay" style="display: block;"></div>';
        }
            else echo '<div id="overlay" style="display: none;"></div>';
    ?>
    <form action="Account.php?controller=User&action=account" method="post">
        <div class="submit-fullname" id="submit-fullname">
            <div class="label-fullname">
                <label>Họ và tên</label>
            </div>
            <div>
                <input class="txt_account" type="text" name="full_name" value="<?php echo $account->full_name; ?>">
            </div>
            <div class="form_submit">
                <input class="form_submit_cancel" type="submit" name="cancel" value="Hủy">
                <input class="form_submit_save" type="submit" name="save" value="Lưu">
            </div>
        </div>
    </form>
    <form action="Account.php?controller=User&action=account" method="post">
        <?php 
            if (!empty($error['date'])) 
            {
                echo '<div class="submit-fullname" id="submit-date" style="display: block;">';
            }
                else echo '<div class="submit-fullname" id="submit-date" style="display: none;">';
        ?>
            <div class="label-fullname">
                <label>Ngày sinh</label>
            </div>
            <?php 
                if (!empty($error['date']))
                echo '<tr><td class = "error_tr"><div class="error">* '. reset($error['date']).'</div></td></tr>';
            ?>
            <div>    
                <input class="txt_account" type="date" name="date" value="<?php echo $account->date; ?>">
            </div>
            <div class="form_submit">
                <input class="form_submit_cancel" type="submit" name="cancel" value="Hủy">
                <input class="form_submit_save" type="submit" name="save" value="Lưu">
            </div>
        </div>
    </form>
    <form action="Account.php?controller=User&action=account" method="post">
        <div class="submit-fullname" id="submit-gender">
            <div class="label-fullname">
                <label>Giới tính</label>
            </div>
            <div>
                <div class="gender">
                    <input class="radio-gender" type="radio" name="gender" value="Nam" <?php if ($account->gender == 'Nam') echo 'checked'; ?>> 
                    <label>Nam</label>
                </div>
                <div class="gender">
                    <input class="radio-gender" type="radio" name="gender" value="Nữ" <?php if ($account->gender == 'Nữ') echo 'checked'; ?>> 
                    <label>Nữ</label>
                </div>
            </div>
            <div class="form_submit">
                <input class="form_submit_cancel" type="submit" name="cancel" value="Hủy">
                <input class="form_submit_save" type="submit" name="save" value="Lưu">
            </div>
        </div>
    </form>
    <form action="Account.php?controller=User&action=account" method="post">
        <?php 
            if (!empty($error['password'])) 
            {
                echo '<div class="submit-fullname" id="submit-password" style="display: block;">';
            }
                else echo '<div class="submit-fullname" id="submit-password" style="display: none;">';
        ?>
            <div class="label-fullname">
                <label>Đổi mật khẩu</label>
            </div>
            <div>
                <?php 
                    if (!empty($error['password']))
                    echo '<tr><td class = "error_tr"><div class="error">* '. reset($error['password']).'</div></td></tr>';
                ?>
                <div class="space">
                    <div>
                        <label>Mật khẩu cũ</label>
                    </div>
                    <div class="_password">
                        <input class="txt_password" type="password" name="password_old" placeholder="Vui lòng nhập mật khẩu cũ">
                        <div id="account_eye_1" class="account_eye">
                            <i class="fa-solid fa-eye-slash"></i>
                        </div>
                    </div>
                </div>
                <div class="space">
                    <div>
                        <label>Mật khẩu mới</label>
                    </div>
                    <div class="_password">
                        <input class="txt_password" type="password" name="password" placeholder="Vui lòng nhập mật khẩu mới">
                        <div id="account_eye_2" class="account_eye">
                            <i class="fa-solid fa-eye-slash"></i>
                        </div>
                    </div>
                </div>
                <div class="space">
                    <div>
                        <label>Mật khẩu mới</label>
                    </div>
                    <div class="_password">
                        <input class="txt_password" type="password" name="re_enter_password" placeholder="Vui lòng nhập lại mật khẩu mới">
                        <div id="account_eye_3" class="account_eye">
                            <i class="fa-solid fa-eye-slash"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form_submit">
                <input class="form_submit_cancel" type="submit" name="cancel" value="Hủy">
                <input class="form_submit_save" type="submit" name="save" value="Lưu">
            </div>
        </div>
    </form>
    <form action="Account.php?controller=User&action=account" method="post">
        <?php 
            if (!empty($error['email'])) 
            {
                echo '<div class="submit-fullname" id="submit-email" style="display: block;">';
            }
                else echo '<div class="submit-fullname" id="submit-email" style="display: none;">';
        ?>
            <div class="label-fullname">
                <label>Đổi Email</label>
            </div>
            <div>
                <?php 
                    if (!empty($error['email']))
                    echo '<tr><td class = "error_tr"><div class="error">* '. reset($error['email']).'</div></td></tr>';
                ?>
                <div class="space">
                    <div>
                        <label>Mật khẩu</label>
                    </div>
                    <div class="_password">
                        <input class="txt_password" type="password" name="password_email" placeholder="Vui lòng nhập mật khẩu">
                        <div id="account_eye" class="account_eye">
                            <i class="fa-solid fa-eye-slash"></i>
                        </div>
                    </div>
                </div>
                <div class="space">
                    <div>
                        <label>Email</label>
                    </div>
                    <div>
                        <input class="txt_account" type="email" name="email" value="<?php echo $account->email; ?>">
                    </div>
                </div>
            </div>
            <div class="form_submit">
                <input class="form_submit_cancel" type="submit" name="cancel" value="Hủy">
                <input class="form_submit_save" type="submit" name="save" value="Lưu">
            </div>
        </div>
    </form>
    <form action="Account.php?controller=User&action=avatar" method="post" enctype="multipart/form-data">
        <div class="submit-fullname" id="submit-avatar">
            <div class="label-fullname">
                <label>Ảnh hồ sơ</label>
            </div>
            <div class="change_avatar">
                <img src="<?php echo $account->avatar ?>">
            </div>
            <div class="add_avatar" id="add_avatar">
                <i class="fa-solid fa-camera"></i>Thêm ảnh hồ sơ
            </div>
            <input type="file" id="fileInput" name="image" accept=".jpg,.png" style="display: none;">
            <input type="submit" id="submit_file" style="display: none;">
        </div>
    </form>
    <?php layouts('Center', $data, $account) ?>  
    <div class="center">
        <?php layouts('Menu') ?>       
        <div class="center-center">
            <div class="account">
                <div class="account-basic">
                    <h2 class="account-title">Thông tin tài khoản</h2>
                    <div class="account-inform" id="avatar">
                        <label class="title-first">Ảnh hồ sơ</label>
                        <label class="title-second">Thêm ảnh hồ sơ để cá nhân hóa tài khoản của bản</label>
                        <div class="avatar">
                            <img src="<?php echo $account->avatar ?>" alt="">
                        </div>
                    </div>
                    <div class="account-inform" id="username">
                        <label class="title-first">Tên tài khoản</label>
                        <label class="title-second"><?php echo $account->username; ?></label>
                    </div>
                    <div class="account-inform" id="full_name">
                        <label class="title-first">Họ và tên</label>
                        <label class="title-second"><?php echo $account->full_name; ?></label>
                    </div>
                    <div class="account-inform" id="date">
                        <label class="title-first">Ngày sinh</label>
                        <label class="title-second"><?php echo $account->date; ?></label>
                    </div>
                    <div class="account-inform" id="gender">
                        <label class="title-first">Giới tính</label>
                        <label class="title-second"><?php echo $account->gender; ?></label>
                    </div>
                    <div class="account-inform1" id="email">
                        <label class="title-first">Email</label>
                        <label class="title-second"><?php echo $account->email; ?></label>
                    </div>
                </div>
                <div class="reset_password">
                    <input class="input_password" type="submit" id="reset_password" value="Đổi mật khẩu">
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="../templates/css/reset.css">
    <link rel="stylesheet" href="../templates/css/home.css">
    <script src="../templates/js/main.js" defer></script>
    <script src="../templates/js/app.js" defer></script>
    <script src="../templates/js/account.js" defer></script>
</body>
</html>