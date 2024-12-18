
<?php
if (!defined('_CODE'))
{
    // die('Access denied...');
}
?>

<div id="header">
    <nav class="container">
        <div id="main-menu">
            <?php if (!empty($data['pageTitle'])) echo $data['pageTitle']; else echo 'Trang chủ1'; ?>
        </div>
        <div class="user"><i class="fa-solid fa-circle-user"></i> Xin chào,
            <?php echo $account->full_name?>
            <i class="fa-solid fa-chevron-down" id="toggleMenu"></i>
            <div class="menuUser">
                <div class="menuContent">
                    <ul>
                        <li>
                            <a href="Account.php"><i class="fa-solid fa-circle-user"></i>Thông tin tài khoản</a>
                        </li>
                        <li>
                            <a href="../auth/Logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i>Đăng xuất</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>