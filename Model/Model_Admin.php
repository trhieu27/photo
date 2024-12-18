<?php
    require_once "Entity_Admin.php";
    require_once "DB.php";

    class Model_Admin
    {
        public $db;
        public function __construct() {
            $this->db = new DB();
        }
        public function getAdmin($condition) {
            $sql = "SELECT * FROM admin WHERE " . $condition;
            $result = $this->db->query($sql);
            $user = null;
            
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                if ($row) {
                    $username = $row['username'];
                    $password = $row['password'];
                    $user = new Entity_Admin($username, $password);
                }
            }
            return $user;
        }
    }
?>