<?php
    class Entity_Folder
    {
        public $id;
        public $user_id;
        public $name;
        public function __construct($id, $user_id, $name)
        {
            $this->id = $id;
            $this->user_id = $user_id;
            $this->name = $name;
        }
    }
?>