<?php
    
    require_once '../../Model/Entity_Folder.php';
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
                $controller->$actionName();
                }
            }
        } 
    } 
    $folder = getSession('fols');
    if (!isset($folder)) {
        $controllerName = 'Admin';
        $actionName = 'getAllFolder';
        $controllerClass = 'Controller_' . $controllerName;
        $controllerFile = '../../Controller/' . $controllerClass . '.php';if (file_exists($controllerFile)) {
        require_once $controllerFile;
            $controller = new $controllerClass();
            if (method_exists($controller, $actionName)) {
                $controller->$actionName();
            }
        }
        $Folder = getSession('fols');
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thư viện</title>
    <link rel="stylesheet" href="../templates/css/library.css">
    <script src="../templates/js/library.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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
                        <a href="Library.php?controller=Adminr&action=getAllFolder">
                        <img class="icon" src="../templates/image/gallery.png" alt="">Thư viện
                        </a>
                    </li>
                </ul>
            </div>
            <div class="main-content" id="main-content"> 
                <div class="content">    
                    <form action="Library.php?controller=Admin&action=searchFolder" method="post">
                        <div class="search">
                            <input type="text" name="search" placeholder="Tìm kiếm">
                            <input type="submit" value="Tìm kiếm">
                        </div>
                    </form>
                    <div class="content-center">
                        <div class="folders">
                                <?php
                                if (!empty($folder))
                                {
                                    foreach ($folder as $key=>$value)
                                    { 
                                        echo '<form id="form-folder-' . $value->id . '" action="Lib_file.php?controller=Admin&action=getAllImage&folder_id=' . $value->id . '" method="post">
                                            <div class="new-folder" id="folder" ondblclick="submitForm(' . $value->id . ')">
                                                <div class="name-folder">' . $value->name . '</div>
                                            </div>
                                        </form>';
                                    }
                                }
                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

