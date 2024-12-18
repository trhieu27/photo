<?php
    require_once "Entity_User.php";
    require_once "DB.php";

    class Model_User
    {
        public $db;
        public function __construct() {
            $this->db = new DB();
        }
        public function getALLUser() {
            $sql = "SELECT * FROM users";
            $result = $this->db->query($sql);
            $user = [];
            $i = 0;
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $avatar = $row['avatar'];
                    $full_name = $row['full_name'];
                    $date = $row['date'];
                    $gender = $row['gender'];
                    $email = $row['email'];
                    $username = $row['username'];
                    $password = $row['password'];
                    $user[$i++] = new Entity_User($id, $avatar,$full_name, $date, $gender, $email, $username, $password);
                }
            }
            return $user;
        }
        public function getUser($condition) {
            $sql = "SELECT * FROM users WHERE " . $condition;
            $result = $this->db->query($sql);
            $user = null;
            
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                if ($row) {
                    $id = $row['id'];
                    $avatar = $row['avatar'];
                    $full_name = $row['full_name'];
                    $date = $row['date'];
                    $gender = $row['gender'];
                    $email = $row['email'];
                    $username = $row['username'];
                    $password = $row['password'];
                    $user = new Entity_User($id, $avatar,$full_name, $date, $gender, $email, $username, $password);
                }
            }
            return $user;
        }
        public function insertUser($data) {
            $keys = implode(',', array_keys($data));
            $values = "'" . implode("', '", array_values($data)). "'";
            $sql = "INSERT INTO users (" . $keys . ") VALUES (" . $values . ")";
            $result = $this->db->query($sql);
            return $result;
        }
        public function updateUser($data, $condition = '') {
            $update = '';
            
            foreach ($data as $key => $value) {
                $update .= $key . " = '" . $value . "', "; 
            }
            $update = rtrim($update, ', ');
            
            if (!empty($condition)) {
                $sql = 'UPDATE USERS SET ' . $update . ' WHERE ' . $condition;
            } else {
                $sql = 'UPDATE USERS SET ' . $update;
            }
            
            $result = $this->db->query($sql); 
            return $result;
        }
        
        public function deleteUser($condition = '') {
            if (!empty($condition)) {
                $sql = 'DELETE FROM USERS WHERE ' . $condition;
            } else {
                $sql = 'DELETE FROM USERS';
            }
            
            $result = $this->db->query($sql);
            return $result;
        }
        public function searchUser($condition) {
            $sql = "SELECT * FROM users WHERE username LIKE '%".$condition."%'";
            $result = $this->db->query($sql);
            $user = [];
            $i = 0;
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $avatar = $row['avatar'];
                    $full_name = $row['full_name'];
                    $date = $row['date'];
                    $gender = $row['gender'];
                    $email = $row['email'];
                    $username = $row['username'];
                    $password = $row['password'];
                    $user[$i++] = new Entity_User($id, $avatar,$full_name, $date, $gender, $email, $username, $password);
                }

            }
            return $user;
        }
    }
?>