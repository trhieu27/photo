
<?php
    
    require_once '../../Model/Entity_User.php';
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
        $controllerFile = '../../Controller/' . $controllerClass . '.php';if (file_exists($controllerFile)) {
        require_once $controllerFile;
            $controller = new $controllerClass();
            if (method_exists($controller, $actionName)) {
                if ($actionName == 'updateUser' || $actionName == 'deleteUser') $controller->$actionName($_GET['username'], $_GET['page']); else $controller->$actionName();
            }
          }
        } 
    } 
    $users = getSession('users');
    if (!isset($users)) {
        $controllerName = 'Admin';
        $actionName = 'getAllUser';
        $controllerClass = 'Controller_' . $controllerName;
        $controllerFile = '../../Controller/' . $controllerClass . '.php';if (file_exists($controllerFile)) {
        require_once $controllerFile;
            $controller = new $controllerClass();
            if (method_exists($controller, $actionName)) {
                $controller->$actionName();
            }
        }
        $users = getSession('users');
    }
    $totalUsers = count($users);

    $usersPerPage = 18;
    $totalPages = ceil($totalUsers / $usersPerPage);
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($current_page>$totalPages) $current_page = 1;

    $startIndex = ($current_page - 1) * $usersPerPage;
    $endIndex = $startIndex + $usersPerPage;

    $usersOnPage = array_slice($users, $startIndex, $usersPerPage);
    $error = null;
    $error=getSession('errorupdate');
    $updateUser = null;
    $updateUser = getSession('updateUser');
    removeSession('updateUser');
    removeSession('errorupdate');  
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản</title>
    <link rel="stylesheet" href="../templates/css/ad-Home.css">
    <script src="../templates/js/ad-account.js"></script>
    <script src="../templates/js/app.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <a class="iconic" href=""><img src="../templates/image/Cloud.png" alt="" id="cloud-icon"></a>
            <p class="welcom">Welcom to Admin's Home</p>
        </div>
        <div class="main-container">
            <?php
            if (!empty($updateUser) || !empty($error))
            {
            echo'
            <div id="overlay" style="display : block;"></div>
            <form action="Account.php?controller=Admin&action=updateUser&username='.$updateUser->username.'&page='.$current_page.'" method="post">
                <div class="submit-fullname" id="submit_update" style="display: block;">
                    <div class="label-fullname">
                        <label>Thông tin chung</label>
                    </div>
                    <div class="lb-user">
                        <label>Họ và tên</label>
                    </div>
                    <div>
                        <input class="txt_account" type="text" name="full_name" value="'.$updateUser->full_name.'">
                    </div>
                    <div class="lb-user">
                        <label>Ngày sinh</label>
                    </div>';
                            if (!empty($error['date']))
                            echo '<tr><td class = "error_tr"><div class="error">* '. reset($error['date']).'</div></td></tr>';
                        echo'
                        <div>    
                            <input class="txt_account" type="date" name="date" value="'.$updateUser->date.'">
                        </div>
                        <div class="lb-user">
                            <label>Giới tính</label>
                        </div>
                        <div class="gender-admin">
                            <div class="gender">
                                <input class="radio-gender" type="radio" name="gender" value="Nam"'; if ($updateUser->gender == 'Nam') echo 'checked'; echo '> 
                                <label>Nam</label>
                            </div>
                            <div class="gender">
                                <input class="radio-gender" type="radio" name="gender" value="Nữ"';if ($updateUser->gender == 'Nữ') echo 'checked'; echo'> 
                                <label>Nữ</label>
                            </div>
                        </div>
                        <div class="lb-user">
                            <label>Email</label>
                        </div>
                        <div>';
                                if (!empty($error['email']))
                                echo '<tr><td class = "error_tr"><div class="error">* '. reset($error['email']).'</div></td></tr>';
                            echo'
                            <div>
                                <input class="txt_account" type="email" name="email" value="'.$updateUser->email.'">
                            </div>
                        </div>
                        <div class="lb-user">
                            <label>Đặt lại mật khẩu mới</label>
                        </div>
                        <div class="_password">
                            <input class="txt_password" type="password" name="password" placeholder="Mật khẩu">
                            <div id="eye" class="account_eye">
                                <i class="fa-solid fa-eye-slash"></i>
                            </div>
                        </div>
                        <div class="form_submit">
                            <input class="form_submit_cancel" type="submit" name="cancel" value="Hủy">
                            <input class="form_submit_save" type="submit" name="save" value="Lưu">
                        </div>
                    </div>
                </form>';} else echo '<div id="overlay"></div>'
            ?>
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
                <div class="content">    
                    <form action="Account.php?controller=Admin&action=searchUser" method="post">
                        <div class="search">
                            <input type="text" name="search" placeholder="Tìm kiếm">
                            <input type="submit" value="Tìm kiếm">
                        </div>
                    </form>
                    <table class = "table">
                        <caption>Dữ liệu bảng User</caption>
                        <tr>
                            <td class = "title-table">Họ và tên</td>
                            <td class = "title-table">Tài khoản</td>
                            <td class = "title-table">Email</td>
                            <td class = "title-table">Chức năng</td>
                        </tr>
                        <?php foreach ($usersOnPage as $key => $value) {
                        echo '<tr>
                            <td class = "sub-table">'. $value->full_name.'</td>
                            <td class = "sub-table">'. $value->username .'</td>
                            <td class = "sub-table">'. $value->email .'</td>
                            <td class = "sub-table">
                                <form action="Account.php?controller=Admin&action=updateUser&username='.$value->username.'&page='.$current_page.'" method="post" style="display:inline;">
                                    <input type="submit" class="submit_update" value="Sửa">
                                </form>
                                <form action="Account.php?controller=Admin&action=deleteUser&username='.$value->username.'&page='.$current_page.'" method="post" style="display:inline;"  onsubmit="return confirmDelete()">
                                    <input type="submit" class="submit_update" value="Xóa">
                                </form>
                            </td>
                        </tr>';
                    }?>
                    </table>
                </div>
                <div class="pagination">
                    <a href="?page=<?php echo '1'; ?>">
                        <?php echo 'Đầu';?>
                    </a>
                    <a href="<?php if ($current_page > 1) echo "?page=".$current_page - 1; ?>"><i class="fa-solid fa-arrow-left"></i></a>
                <?php 
                        $start = 0;
                        $end = 0;
                        
                        if ($totalPages<=3) { $start = $current_page-1; $end = $totalPages - $current_page;} else {
                            if ($current_page == 1) { $start = 0; $end = 2;}
                            if ($current_page>=2 && $current_page<=$totalPages-1) { $start = 1; $end = 1;}
                            if ($current_page == $totalPages) { $start = 2; $end = 0;}
                        }
                        for ($i = $current_page-$start; $i <= $current_page+$end; $i++){ ?>
                            <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $current_page) ? 'active' : ''; ?>">
                                <?php echo $i;?>
                            </a>
                        <?php } ?>
                    <a href="<?php if ($current_page < $totalPages) echo '?page='.$current_page + 1; ?>"><i class="fa-solid fa-arrow-right"></i></a>
                    <a href="?page=<?php echo $totalPages; ?>">
                        <?php echo 'Cuối';?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

