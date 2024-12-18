<?php 
    require_once "Session.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require_once 'PHPMailer/PHPMailer.php';
    require_once 'PHPMailer/SMTP.php';
    require_once 'PHPMailer/Exception.php';
    // function saveUrl($url) {
    //     $filePath = 'linkIMG.txt';    
    //     file_put_contents($filePath, $url . PHP_EOL, FILE_APPEND);
    // }
    function sendmail($to, $subject= '', $content= ''){


    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'trhieu271004@gmail.com';                     //SMTP username
            $mail->Password   = 'amyhyvxoyrsoxthy';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
            $mail->CharSet = 'UTF-8';  
            $mail->isHTML(true);
            //Recipients
            $mail->setFrom('trhieu271004@gmail.com', 'Gmail');
            $mail->addAddress($to);  

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $content;

            $mail->send();
        } catch (Exception $e) {
            echo "Gửi mail thất bại. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    function isGet()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') return true; 
        return false;
    }

    function isPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') return true; 
        return false;
    }

    function filter()
    {
        $filterArray =[];
        if (isGet()) {
            if (!empty($_GET)) {
                foreach($_GET as $key => $value) {
                    $key = strip_tags($key);
                    if (is_array($value))
                    {
                        $filterArray[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else $filterArray[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                        
                }
            }
        }
        if (isPost()) {
            if (!empty($_POST)) {
                foreach($_POST as $key => $value) {
                    $key = strip_tags($key);
                    if (is_array($value))
                    {
                        $filterArray[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else $filterArray[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                        
                }
            }
        }
        return $filterArray;
    } 
    function redirect($path = 'index.php')
    {
        header("Location: $path");
        exit();
    }

    function layouts($layoutname, $data=[], $account=[])
    {
        require_once '../templates/layout/'.$layoutname.'.php';
    }
?>