<?php

    require 'vendor/autoload.php'; 
    require_once __DIR__ .'/Controller_Image.php';
    require_once realpath(__DIR__ . "/../Model/Model_User.php");
    require_once realpath(__DIR__ . "/../Model/Model_Image.php");
    require_once realpath(__DIR__ . "/../Model/Model_Folder.php");
    require_once "Function.php";
    require_once "Session.php";
    
    if (session_status() == PHP_SESSION_NONE) session_start(); 
    class Controller_Image {
        
        public function tp_upload() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
                $account = getSession('account');           
                $username = $account->username;
                $user_id = $account->id;
                $modelFolder = new Model_Folder();
                $fol = $modelFolder->getFolder("user_id = '".$user_id."'");
                if (empty($fol)) {
                    $folder = [
                        'user_id' =>$user_id,
                        'name' =>$username
                    ];
                    $modelFolder->insertFolder($folder);
                    $fol = $modelFolder->getFolder("user_id = '".$user_id."'");
                }
                $targetDir = "D:/uploads/" . $username . "/";
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);  
                }
            
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $targetFile = $targetDir . $fileName;
            
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    error_log('File uploaded successfully: ' . $targetFile); 
                    $imageUrl = 'https://' . $_SERVER['SERVER_NAME'] . '/uploads/' . $username . '/' . $fileName;
                    $name = basename($fileName);
                    $type = mime_content_type($targetFile);  
                    $size = round(filesize($targetFile) / (1024 * 1024), 2) . ' MB'; 
                    
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $date = date('d/m/Y h:i A');
            
                    list($width, $height) = getimagesize($targetFile);
                    $dimensions = "{$width} x {$height}";
                    $data = [
                        'folder_id' => $fol->id,
                        'photo_url' => $imageUrl,
                        'name_img' => $name,
                        'type_img' => $type,
                        'size_img' => $size,
                        'date_img' => $date,
                        'dimensions' => $dimensions
                    ];
                    $modelImage = new Model_Image();
                    $modelImage->insertImage($data);

                    echo json_encode([
                        'success' => 'Ảnh đã được tải lên thành công',
                        'filePath' => 'https://'.$_SERVER['SERVER_NAME'].'/uploads/' . $username . '/' . $fileName
                    ]);
                } else {
                    error_log('Error moving uploaded file: ' . $_FILES['image']['error']); 
                    echo json_encode(['error' => 'Không thể lưu ảnh.']);
                }
                exit; 
            }
        }
        public function sp_upload() {
            $account = getSession('account');
            $modelFolder = new Model_Folder();
            $fol = $modelFolder->getFolder("user_id = '".$account->id."'");
            $imgs = null;
            if (!empty($fol))
            {
                $modelImage = new Model_Image();
                $imgs = $modelImage->getAllImage("folder_id = '".$fol->id."'");
                
            }
            setSession('picture', $imgs);
           
            if(empty($account->id)) {
                echo json_encode(['error' => 'User not logged in']);
                exit();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
                $username = $account->username;
                $user_id = $account->id;
                if (empty($fol)) {
                    $folder = [
                        'user_id' =>$user_id,
                        'name' =>$username
                    ];
                    $modelFolder->insertFolder($folder);
                    $fol = $modelFolder->getFolder("user_id = '".$user_id."'");
                }
                $targetDir = "D:/uploads/" . $username . "/";
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);  
                }
            
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $targetFile = $targetDir . $fileName;
            
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    error_log('File uploaded successfully: ' . $targetFile); 
                    $imageUrl = 'https://' . $_SERVER['SERVER_NAME'] . '/uploads/' . $username . '/' . $fileName;
                    $name = basename($fileName);
                    $type = mime_content_type($targetFile);  
                    $size = round(filesize($targetFile) / (1024 * 1024), 2) . ' MB'; 
                    
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $date = date('d/m/Y h:i A');
            
                    list($width, $height) = getimagesize($targetFile);
                    $dimensions = "{$width} x {$height}";
                    $data = [
                        'folder_id' => $fol->id,
                        'photo_url' => $imageUrl,
                        'name_img' => $name,
                        'type_img' => $type,
                        'size_img' => $size,
                        'date_img' => $date,
                        'dimensions' => $dimensions
                    ];
                    $modelImage = new Model_Image();
                    $modelImage->insertImage($data);

                    echo json_encode([
                        'success' => 'Ảnh đã được tải lên thành công',
                        'filePath' => 'https://'.$_SERVER['SERVER_NAME'].'/uploads/' . $username . '/' . $fileName
                    ]);
                } else {
                    error_log('Error moving uploaded file: ' . $_FILES['image']['error']); // Log error
                    echo json_encode(['error' => 'Không thể lưu ảnh.']);
                }
                exit; 
            }
        }
        public function delete_image() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['image_ids'])) {
                    $account = getSession('account');
                    $username = $account->username;
                    $image_ids = $_POST['image_ids'];
                    $modelImage = new Model_Image();
                    
                    foreach ($image_ids as $image_id) {
                        $image = $modelImage->getImage("id = '".$image_id."'");
                        
                        if ($image) {
                            $customer_folder = "D:/uploads/".$username."/";
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
            redirect('../home/See_Picture.php'); 
            }
        }              

}
