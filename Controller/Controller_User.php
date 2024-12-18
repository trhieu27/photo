<?php

    if (session_status() == PHP_SESSION_NONE) session_start(); 
    require_once "../../Model/Model_User.php";
    require_once "../../Model/Model_Image.php";
    require_once realpath(__DIR__ . "/../Controller/Controller_Image.php");
    require_once "Function.php";
    require_once "Session.php";

    class Controller_User {
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
                    $modelUser = new Model_User();
                    $user = $modelUser->getUser("username = '".$filterAll['username']."'");
                    if (!password_verify($filterAll['password'], $user->password))$error['login']['require'] = 'Tài khoản hoặc mật khẩu không đúng';
                    if (empty($user)) $error['login']['require'] = 'Tài khoản hoặc mật khẩu không đúng';
                }
                if (empty($error))
                {
                    setSession('account', $user);
                    redirect('../home/Home.php');
                } else{
                    setSession('error', $error);
                    setSession('old', $filterAll);
                    redirect('../auth/Login.php');
                }
            }
        }
        public function register()
        {
            if (isPost())
            {
                $filterAll = filter();
                
                $error = [];
                
                if (empty($filterAll['full_name']))
                {
                    $error['full_name']['require'] = 'Họ tên không được để trống';
                } else if (strlen($filterAll['full_name']) < 5) {
                    $error['full_name']['min'] = 'Họ tên phải có ít nhất 5 ký tự';
                } 
                if (empty($filterAll['date'])) {
                    $error['date']['require'] = 'Ngày sinh không được để trống';
                } else {
                    $date = DateTime::createFromFormat('Y-m-d', $filterAll['date']);
                    if ($date === false) {
                        $error['date']['invalid'] = 'Ngày sinh không hợp lệ';
                    } else {
                        $currentDate = new DateTime();
                        if ($date > $currentDate) {
                            $error['date']['future'] = 'Ngày sinh không được là ngày trong tương lai.';
                        }
                    }
                }
                if (empty($filterAll['gender'])) $error['gender']['require'] = 'Giới tính không được để trống';
                if (empty($filterAll['email']))
                {
                    $error['email']['require'] = 'Email không được để trống';
                } else {
                    $email = $filterAll['email'];
                    $modelUser = new Model_User();
                    $user = $modelUser->getUser( "email = '".$email."'");
                    if (!empty($user))
                    {
                        $error['email']['unique'] = 'Email đã tồn tại';
                    }
                }
                if (empty($filterAll['username']))
                {
                    $error['username']['require'] = 'Tài khoản không được để trống';
                } else if (strlen($filterAll['username']) < 5) {
                    $error['username']['min'] = 'Tài khoản phải có ít nhất 5 ký tự';
                } else if (!preg_match('/^[a-zA-Z0-9_]+$/', $filterAll['username'])) {
                    $error['username']['invalid'] = 'Tài khoản chỉ được chứa chữ cái không dấu, số và dấu gạch dưới (_).';
                }
                else 
                {
                    $modelUser = new Model_User();
                    $user = $modelUser->getUser( "username = '".$filterAll['username']."'");
                    if (!empty($user)) 
                    $error['username']['exist'] = 'Tài khoản đã tồn tại';
                }
                if (empty($filterAll['password'])) {
                    $error['password']['require'] = 'Mật khẩu không được để trống';
                } else {
                    $password = $filterAll['password'];
                    if (strlen($password) < 8) {
                        $error['password']['min'] = 'Mật khẩu phải có ít nhất 8 ký tự';
                    } else if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
                        $error['password']['kt'] = 'Mật khẩu phải chứa ít nhất một ký tự đặc biệt';
                    } else if (!preg_match('/[A-Z]/', $password)) {
                        $error['password']['cch'] = 'Mật khẩu phải chứa ít nhất một chữ cái viết hoa';
                    } else if (!preg_match('/[a-z]/', $password)) {
                        $error['password']['cct'] = 'Mật khẩu phải chứa ít nhất một chữ cái viết thường';
                    } else if (!preg_match('/[0-9]/', $password)) {
                        $error['password']['ccs'] = 'Mật khẩu phải chứa ít nhất một chữ số';
                    }
                }
                
                if (empty($error))
                {
                    $imageUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/uploads/default_avatar/avatar.png';
                    $data = [
                        'avatar' => $imageUrl,
                        'full_name' => $filterAll['full_name'],
                        'date' => $filterAll['date'],
                        'gender' => $filterAll['gender'],
                        'email' => $filterAll['email'],
                        'username'=> $filterAll['username'],
                        'password'=> password_hash($filterAll['password'], PASSWORD_DEFAULT)
                    ];
                    $modelUser = new Model_User();
                    $modelUser->insertUser($data);
                    $user = $modelUser->getUser("username = '".$filterAll['username']."'");
                    setSession('account', $user);
                    redirect('../home/Home.php');
                } else{
                    setSession('smg', 'Vui lòng kiểm tra lại dữ liệu');
                    setSession('error', $error);
                    setSession('old',$filterAll);
                    redirect('../auth/Register.php');
                }
            }
        }
        public function account() {
            if (isPost())
            {
                $modelUser = new Model_User();
                $account = getSession('account');
                if (isset($_POST['save']))
                { 
                    unset($_POST['save']); 
                    $filterAll = filter();
                    $filterAll['id'] = $account->id;
                    $error = [];
                    if (isset($filterAll['date']))
                    {
                        if (empty($filterAll['date'])) {
                            $error['date']['require'] = 'Ngày sinh không được để trống';
                        } else {
                            $date = DateTime::createFromFormat('Y-m-d', $filterAll['date']);
                            if ($date === false) {
                                $error['date']['require'] = 'Ngày sinh không hợp lệ';
                            } else {
                                $currentDate = new DateTime();
                                if ($date > $currentDate) {
                                    $error['date']['require'] = 'Ngày sinh không được là ngày trong tương lai.';
                                }
                            }
                        }
                    }
                    if (isset($filterAll['password_old']))
                    {
                        $acc = $modelUser->getUser("id = '" . $account->id . "'");
                        if (empty($filterAll['password_old'])) $error['password']['require'] = 'Vui lòng nhập mật khẩu cũ'; else
                            if (empty($filterAll['password'])) $error['password']['require'] = 'Vui lòng nhập mật khẩu mới'; else
                                if (empty($filterAll['re_enter_password'])) $error['password']['require'] = 'Vui lòng nhập lại mật khẩu mới'; else
                                    if (!password_verify($filterAll['password_old'], $acc->password)) $error['password']['require'] = 'Mật khẩu cũ không đúng'; else
                                        if ($filterAll['password'] != $filterAll['re_enter_password']) $error['password']['require'] = 'Mật khẩu nhập lại không đúng'; else
                                            if ($filterAll['password'] === $filterAll['password_old']) $error['password']['require'] = 'Mật khẩu trùng với mật khẩu cũ'; else                                    
                                                if (strlen($filterAll['password']) < 8) {
                                                    $error['password']['min'] = 'Mật khẩu phải có ít nhất 8 ký tự';
                                                } else if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $filterAll['password'])) {
                                                    $error['password']['kt'] = 'Mật khẩu phải chứa ít nhất một ký tự đặc biệt';
                                                } else if (!preg_match('/[A-Z]/', $filterAll['password'])) {
                                                    $error['password']['cch'] = 'Mật khẩu phải chứa ít nhất một chữ cái viết hoa';
                                                } else if (!preg_match('/[a-z]/', $filterAll['password'])) {
                                                    $error['password']['cct'] = 'Mật khẩu phải chứa ít nhất một chữ cái viết thường';
                                                } else if (!preg_match('/[0-9]/', $filterAll['password'])) {
                                                    $error['password']['ccs'] = 'Mật khẩu phải chứa ít nhất một chữ số';
                                                } else if ($filterAll['password'] !== $filterAll['reEnterPassword']) {
                                                    $error['password']['same'] = 'Mật khẩu nhập lại không đúng';
                                                } else
                                                    {
                                                        $filterAll = [
                                                            'id' => $account->id,
                                                            'password' => password_hash($filterAll['password'], PASSWORD_DEFAULT)
                                                        ];
                                                    }
                    }
                    if (isset($filterAll['password_email']))
                    {
                        $acc = $modelUser->getUser("id = '" . $account->id . "'");
                        if (empty($filterAll['password_email'])) $error['email']['require'] = 'Vui lòng nhập mật khẩu'; else
                            if (!password_verify($filterAll['password_email'], $acc->password)) $error['email']['require'] = 'Mật khẩu không đúng'; else                                   
                                if (!empty($filterAll['email']))
                                    {
                                        $check = $modelUser->getUser( "email = '".$filterAll['email']."'");
                                        if (!empty($check))
                                        {
                                            if ($check->id != $account->id) $error['email']['require'] = 'Email đã tồn tại';
                                                else
                                                {
                                                    $filterAll = [
                                                        'id' => $account->id,
                                                        'email' => $filterAll['email']
                                                    ];
                                                }
                                        } else
                                            {
                                                $filterAll = [
                                                    'id' => $account->id,
                                                    'email' => $filterAll['email']
                                                ];
                                            }
                                    } else $error['email']['require']="Vui lòng nhập địa chỉ email";
                          
                    }
                    if (empty($error))
                    {
                        $modelUser->updateUser( $filterAll, "id = '" . $account->id . "'");
                        removeSession('account');
                        $acc = $modelUser->getUser("id = '" . $account->id . "'");
                        setSession('account', $acc);
                        redirect('../home/Account.php');
                    } else {
                        $user = $modelUser->getUser("id = '" . $account->id . "'");
                        setSession('account', $user);
                        setSession('error', $error);
                        redirect('../home/Account.php');
                    }
                } else {
                    $acc = $modelUser->getUser("id = '" . $account->id . "'");
                    setSession('account', $acc);
                    redirect('../home/Account.php');
                }
            }
        }
        public function avatar(){
            $account = getSession('account');
            $modelUser = new Model_User();
           
            if(empty($account->id)) {
                echo json_encode(['error' => 'User not logged in']);
                exit();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
                $username = $account->username;
                $user_id = $account->id;
                $targetDir = "D:/uploads/" . $username . "/";
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);  
                }
                $fileName =basename($_FILES['image']['name']);
                $targetFile = $targetDir . $fileName;
            
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    error_log('File uploaded successfully: ' . $targetFile); 
                    $imageUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/uploads/' . $username . '/' . $fileName; $filterAll = [
                        'id' => $account->id,
                        'avatar' =>$imageUrl
                    ];
                    setSession('acc', $filterAll);
                    $modelUser->updateUser( $filterAll, "id = '" . $account->id . "'");
                    $user = $modelUser->getUser("id = '" . $account->id . "'");
                    setSession('account', $user);
                   
                }
            }
            redirect('../home/Account.php');
        }
        public function forgot() {
            if (isPost())
            {
                $modelUser = new Model_User();
                $filterAll = filter();
                $error = [];
                if (empty($filterAll['email']))
                {
                    $error['forgot']['require'] = 'Vui lòng nhập địa chỉ email';
                } else 
                {
                    $data = $modelUser->getUser("email = '".$filterAll['email']."'");
                    if (empty($data)) $error['forgot']['require'] = 'Địa chỉ email không đúng';
                }
        
                if (empty($error))
                {
                    $currentUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/PBL4/View/auth/Resetpassword.php';
                    $subject = 'Yêu cầu khôi phục mật khẩu.';
                    $content = 'Chào bạn.</br> Chúng tôi nhận được yêu cầu khôi phục mật khẩu từ bạn. Vui lòng click vào link sau để đổi mật khẩu: </br>';
                    $content .= $currentUrl.'</br>';
                    $content .= 'Trân trọng cảm ơn!';
                    setSession('email', $filterAll['email']);
                    sendmail($filterAll['email'], $subject, $content);
                    redirect('Forgot.php');
                } else{
                    setSession('error', $error);
                    setSession('old',$filterAll);
                    redirect('../auth/Forgot.php');
                }
            }
        }
        public function resetpassword() {
            $email = getSession('email');

            if (isPost())
            {
                $filterAll = filter();
                $error = [];
                
                if (empty($filterAll['password'])) {
                    $error['password']['require'] = 'Mật khẩu không được để trống';
                } else {
                    $password = $filterAll['password'];
                    if (strlen($password) < 8) {
                        $error['password']['min'] = 'Mật khẩu phải có ít nhất 8 ký tự';
                    } else if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
                        $error['password']['kt'] = 'Mật khẩu phải chứa ít nhất một ký tự đặc biệt';
                    } else if (!preg_match('/[A-Z]/', $password)) {
                        $error['password']['cch'] = 'Mật khẩu phải chứa ít nhất một chữ cái viết hoa';
                    } else if (!preg_match('/[a-z]/', $password)) {
                        $error['password']['cct'] = 'Mật khẩu phải chứa ít nhất một chữ cái viết thường';
                    } else if (!preg_match('/[0-9]/', $password)) {
                        $error['password']['ccs'] = 'Mật khẩu phải chứa ít nhất một chữ số';
                    } else if ($password !== $filterAll['reEnterPassword']) {
                        $error['password']['same'] = 'Mật khẩu nhập lại không đúng';
                    }
                }
                
                if (empty($error))
                {
                    $data = [
                        'password'=> password_hash($filterAll['password'], PASSWORD_DEFAULT)
                    ];
                    $modelUser = new Model_User();
                    $modelUser->updateUser($data,"email = '" . $email."'");
                    removeSession('email');
                    redirect('Login.php');
                } else{
                    setSession('error', $error);
                    setSession('old',$filterAll);
                    redirect('../auth/Resetpassword.php');
                }
            }
        }
    }
?>