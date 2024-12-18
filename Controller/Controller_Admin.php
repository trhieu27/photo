<?php

    if (session_status() == PHP_SESSION_NONE) session_start(); 
    require_once "../../Model/Model_User.php";
    require_once "../../Model/Model_Admin.php";
    require_once "../../Model/Model_Image.php";
    require_once realpath(__DIR__ . "/../Controller/Controller_Image.php");
    require_once realpath(__DIR__ . "/../Controller/Controller_User.php");
    require_once "Function.php";
    require_once "Session.php";

    class Controller_Admin {
        public function login() {
            if (isPost())
            {
                $filterAll = filter();
                $error = [];
                if (empty($filterAll['username']) || empty($filterAll['password']))
                {
                    $error['login']['require'] = 'Tài khoản hoặc mật khẩu không đúng';
                } else 
                {
                    $modelAdmin = new Model_Admin();
                    $user = $modelAdmin->getAdmin("username = '".$filterAll['username']."'");
                    if ($filterAll['password']!= $user->password) $error['login']['require'] = 'Tài khoản hoặc mật khẩu không đúng';
                    if (empty($user)) $error['login']['require'] = 'Tài khoản hoặc mật khẩu không đúng';
                }
                if (empty($error))
                {
                    setSession('admin', $user);
                    redirect('../admin_home/Account.php');
                } else{
                    setSession('error', $error);
                    setSession('old', $filterAll);
                    redirect('../admin_home/Login.php');
                }
            }
        }
        public function getAllUser() {
            $modelUser = new Model_User();
            $users = $modelUser->getALLUser();
            setSession('users', $users);
        }
        public function updateUser($username, $page) {
            if (isPost())
            {
                $modelUser = new Model_User(); 
                $user = $modelUser->getUser("username = '".$username."'");
                if (isset($_POST['save']))
                { 
                    if (empty($_POST['password'])) unset($_POST['password']); 
                    unset($_POST['save']); 
                    $filterAll = filter();
                    $filterAll['id'] = $user->id;
                    if (isset($filterAll['password'])) $filterAll['password'] = password_hash($filterAll['password'], PASSWORD_DEFAULT);
                    $error = [];
                    $date = DateTime::createFromFormat('Y-m-d', $filterAll['date']);
                    if ($date === false) {
                        $error['date']['require'] = 'Ngày sinh không hợp lệ';
                    } else {
                        $currentDate = new DateTime();
                        if ($date > $currentDate) {
                            $error['date']['require'] = 'Ngày sinh không được là ngày trong tương lai.';
                        }
                    }
                    $check = $modelUser->getUser( "email = '".$filterAll['email']."'");
                    if (!empty($check))
                    {
                        if ($check->id != $user->id) $error['email']['require'] = 'Email đã tồn tại';
                    } 
                    if (empty($error)) 
                    {
                        $modelUser->updateUser($filterAll, "id = '" . $user->id . "'");
                    }
                        else 
                        { 
                            setSession('errorupdate', $error);
                            $user = $modelUser->getUser("id ='".$user->id."'");
                            setSession('updateUser', $user);
                        }
                } else
                    if (isset($_POST['cancel']))
                    {
                        redirect('../admin_home/Account.php?controller=User&action=getAllUser&page='.$page);
                    } else
                        if (isset($_GET['username']))
                        {
                            $modelUser = new Model_User();
                            $user = $modelUser->getUser("username ='".$_GET['username']."'");
                            setSession('updateUser', $user);
                        }
                        
            } 
            redirect('../admin_home/Account.php?controller=Admin&action=getAllUser&page='.$page);
        }
        public function deleteUser($username, $page) {
            $modelUser = new Model_User();
            $user = $modelUser->getUser("username = '".$username."'");
            $modelFolder = new Model_Folder();
            $fol = $modelFolder->getFolder("user_id ='".$user->id."'");
            if (!empty($fol))
            {
                $modelImage = new Model_Image();
                $modelImage->deleteImage("folder_id ='".$fol->id."'");
                $modelFolder->deleteFolder("user_id ='".$user->id."'");
            }
            $modelUser->deleteUser("id ='".$user->id."'");
            $folderPath = 'D:/uploads/'.$username;
            if (is_dir($folderPath)) {
                $files = array_diff(scandir($folderPath), ['.', '..']);
                foreach ($files as $file) {
                    $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
                    unlink($filePath);
                }   
                rmdir($folderPath);
            }
            redirect('../admin_home/Account.php?controller=Admin&action=getAllUser&page='.$page);
        }
        public function searchUser() {
            if (isPost())
            {
                $filterAll = filter();
                $modelUser = new Model_User();
                $users = $modelUser->searchUser($filterAll['search']);
                setSession('users', $users);
            }
            redirect('../admin_home/Account.php');
        }
        
    public function getAllImage($id)
    {
        $modelImage = new Model_Image();
        global $imgs;
        $imgs = $modelImage->getAllImage("folder_id = '" . $id. "'");
        setSession('imgs', $imgs);
        require_once("../admin_Home/Lib_file.php");
    }
    public function ad_delete_image($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['image_ids'])) {
                $image_ids = $_POST['image_ids'];
                $modelFolder = new Model_Folder();
                $folder = $modelFolder->getFolder("id ='".$id."'");
                $modelImage = new Model_Image();
                
                foreach ($image_ids as $image_id) {
                    $image = $modelImage->getImage("id = '".$image_id."'");
                    if ($image) {
                        $customer_folder = "D:/uploads/".$folder->name."/";
                        $filePath = $customer_folder . basename($image->photo_url); 
                        
                        if (file_exists($filePath)) {
                            unlink($filePath); 
                        }
                        $modelImage->deleteImage(" id = '".$image_id."'");
                    }
                }
                if (!empty($image_ids)) {
                    
                    echo json_encode([
                        'success' => 'Các ảnh đã được xóa thành công.'
                    ]);
                } else {
                    echo json_encode([
                        'error' => 'Không có ảnh nào được chọn hoặc ID ảnh không hợp lệ.'
                    ]);
                }

            } else {
                echo json_encode([
                    'error' => 'Danh sách ID ảnh không hợp lệ.'
                ]);
            }
        }
    }               
    public function getAllFolder() {
        $modelFolder = new Model_Folder();
        $fols = $modelFolder->getAllFolder();
        setSession('fols', $fols);
    }
    public function searchFolder() {
        if (isPost())
        {
            $filterAll = filter();
            $modelFolder = new Model_Folder();
            $fols = $modelFolder->searchFolder($filterAll['search']);
            setSession('fols', $fols);
        }
        redirect('../admin_home/Library.php');
    }
}
?>