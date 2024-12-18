<?php
require_once "Entity_Image.php";
require_once "DB.php";

class Model_Image
{
    public $db;
    public function __construct()
    {
        $this->db = new DB();
    }
    public function getAllImage($condition)
    {
        $sql = "SELECT * FROM photos WHERE " . $condition;
        $result = $this->db->query($sql);
        $images = [];
        $i = 0;
        if (!$result || mysqli_num_rows($result) == 0) {
            return null; // Trả về null nếu không có kết quả
        }
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['id'];
                $folder_id = $row['folder_id'];
                $photo_url = $row['photo_url'];
                $name_img = $row['name_img'];
                $type_img = $row['type_img'];
                $size_img = $row['size_img'];
                $date_img = $row['date_img'];
                $dimensions = $row['dimensions'];
                $img = new Entity_Image(
                    $id,
                    $folder_id,
                    $photo_url,
                    $name_img,
                    $type_img,
                    $size_img,
                    $date_img,
                    $dimensions
                );
                $images[$i++] = $img;
            }
        }
        return $images;
    }
    public function getImage($condition)
    {
        $sql = "SELECT * FROM photos WHERE " . $condition;
        $result = $this->db->query($sql);
        $img = null;

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                $id = $row['id'];
                $folder_id = $row['folder_id'];
                $photo_url = $row['photo_url'];
                $name_img = $row['name_img'];
                $type_img = $row['type_img'];
                $size_img = $row['size_img'];
                $date_img = $row['date_img'];
                $dimensions = $row['dimensions'];
                $img = new Entity_Image(
                    $id,
                    $folder_id,
                    $photo_url,
                    $name_img,
                    $type_img,
                    $size_img,
                    $date_img,
                    $dimensions
                );
            }
        }
        return $img;
    }
    public function insertImage($data)
    {
        $keys = implode(',', array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
        $sql = "INSERT INTO photos (" . $keys . ") VALUES (" . $values . ")";
        $result = $this->db->query($sql);
        return $result;
    }
    public function updateImage($data, $condition = '')
    {
        $update = '';

        foreach ($data as $key => $value) {
            $update .= $key . " = '" . $value . "', ";
        }
        $update = rtrim($update, ', ');

        if (!empty($condition)) {
            $sql = 'UPDATE photos SET ' . $update . ' WHERE ' . $condition;
        } else {
            $sql = 'UPDATE photos SET ' . $update;
        }

        $result = $this->db->query($sql);
        return $result;
    }


    public function deleteImage($condition = '')
    {
        if (!empty($condition)) {
            $sql = 'DELETE FROM photos WHERE ' . $condition;
        } else {
            $sql = 'DELETE FROM photos';
        }

        $result = $this->db->query($sql);
        return $result;
    }
}
