<?php
    class Entity_User
    {
        public $id;
        public $avatar;
        public $full_name;
        public $date;
        public $gender;
        public $email;
        public $username;
        public $password;
        public function __construct($id, $avatar, $full_name, $date, $gender, $email, $username, $password)
        {
            $this->id = $id;
            $this->avatar = $avatar;
            $this->full_name = $full_name;
            $this->date = $date;
            $this->gender = $gender;
            $this->email = $email;
            $this->username = $username;
            $this->password = $password;
        }
    }
?>