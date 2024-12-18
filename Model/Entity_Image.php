<?php
    class Entity_Image
    {
        public $id;
        public $folder_id;
        public $photo_url;
        public $name_img;
        public $type_img;
        public $size_img;
        public $date_img;
        public $dimensions;
        public function __construct($id, $folder_id, $photo_url, $name_img, $type_img, $size_img, $date_img, $dimensions)
        {
            $this->id = $id;
            $this->folder_id = $folder_id;
            $this->photo_url = $photo_url;
            $this->name_img = $name_img;
            $this->type_img = $type_img;
            $this->size_img = $size_img;
            $this->date_img = $date_img;
            $this->dimensions = $dimensions;
        }
    }
?>