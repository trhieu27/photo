<?php


//setFlashData('msg', 'cai dat');
//echo getFlashData('msg');

//sendmail('nguyentrunghieutin92018@gmail.com', 'Hello', 'Body');
//var_dump($ss);

// $module = _MODULE;
// $action = _ACTION;

// if (!empty($_GET['module'])) {
//     if (is_string($_GET['module']))
//     {
//         $module = trim($_GET['module']);
//     }
//     if (is_string($_GET['action']))
//     {
//         $action = trim($_GET['action']);
//     }
// }

// $path = 'modules/'. $module .'/'. $action .'.php';
// if (file_exists($path)) require($path); else
//     require_once 'modules/error/404.php';

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Index</title>
        <link rel="stylesheet" href="View/templates/css/reset.css">
        <link rel="stylesheet" href="View/templates/css/index.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    </head>

    <body>
        <div id="wrapper">
            <div id="header">
                <nav class="container">
                    <ul id="main-menu">
                        <li>
                            <a href="" id="index">
                                <i class="fa-solid fa-house"></i>Trang chủ
                            </a>
                        </li>
                    </ul>
                    <ul id="main-menu">
                        <li>
                            <a href="View/auth/Login.php">Đăng nhập</a>
                        </li>
                        <li>
                            <a href="View/auth/Register.php">Đăng ký</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

    </body>

    </html>