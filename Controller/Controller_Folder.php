<?php
    if (session_status() == PHP_SESSION_NONE) session_start(); 
    require_once "../../Model/Model_User.php";
    require_once "../../Model/Model_Image.php";
    require_once "../../Model/Model_Folder.php";
    require_once realpath(__DIR__ . "/../Controller/Controller_Image.php");
    require_once "Function.php";
    require_once "Session.php";

    class Controller_Folder {
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