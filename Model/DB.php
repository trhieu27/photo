<?php
    class DB {
        protected $servername = "localhost";
        protected $username = "root";
        protected $password = "";
        protected $dbname = "post_photo";
        protected $port = "3306";
        public $conn;
        public $link;
        public function __construct() {
            $this->link = mysqli_connect($this->servername, $this->username, $this->password) or die ("Không thể kết nối đến CSDL MYSQL");
            mysqli_select_db($this->link, $this->dbname);
        }
        public function query($sql) {
            $rs = mysqli_query($this->link, $sql);
            return $rs;
        }
    }
?>