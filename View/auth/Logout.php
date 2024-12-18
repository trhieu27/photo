
<?php   
    require_once '../../Model/Entity_User.php';
    if (session_status() == PHP_SESSION_NONE) session_start(); 
    require_once "../../Controller/Session.php";
    require_once "../../Controller/Function.php";
    removeSession('account');
    redirect('../../Index.php');
?>