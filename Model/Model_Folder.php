<?php
require_once "Entity_Folder.php";
require_once "DB.php";

class Model_Folder
{
    public $db;
    public function __construct()
    {
        $this->db = new DB();
    }
    public function getAllFolder($condition = "")
    {
        if (!empty($condition)) {
            $sql = "SELECT * FROM folder WHERE " . $condition;
        } else {
            $sql = "SELECT * FROM folder";
        }
        $result = $this->db->query($sql);
        $folders = [];
        $i = 0;
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['id'];
                $user_id = $row['user_id'];
                $name = $row['name'];
                $fol = new Entity_Folder($id, $user_id, $name);
                $folders[$i++] = $fol;
            }
        }
        return $folders;
    }
    public function getFolder($condition)
    {
        $sql = "SELECT * FROM folder WHERE " . $condition;
        $result = $this->db->query($sql);
        $fol = null;

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                $id = $row['id'];
                $user_id = $row['user_id'];
                $name = $row['name'];
                $fol = new Entity_Folder($id, $user_id, $name);
            }
        }
        return $fol;
    }
    public function insertFolder($data)
    {
        $keys = implode(',', array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
        $sql = "INSERT INTO folder (" . $keys . ") VALUES (" . $values . ")";
        $result = $this->db->query($sql);
        return $result;
    }
    public function updateFolder($data, $condition = '')
    {
        $update = '';

        foreach ($data as $key => $value) {
            $update .= $key . " = '" . $value . "', ";
        }
        $update = rtrim($update, ', ');

        if (!empty($condition)) {
            $sql = 'UPDATE folder SET ' . $update . ' WHERE ' . $condition;
        } else {
            $sql = 'UPDATE folder SET ' . $update;
        }

        $result = $this->db->query($sql);
        return $result;
    }


    public function deleteFolder($condition = '')
    {
        if (!empty($condition)) {
            $sql = 'DELETE FROM folder WHERE ' . $condition;
        } else {
            $sql = 'DELETE FROM folder';
        }

        $result = $this->db->query($sql);
        return $result;
    }
    public function searchFolder($condition) {
        $sql = "SELECT * FROM folder WHERE ".'name'." LIKE '%".$condition."%'";
        $result = $this->db->query($sql);
        $folder = [];
        $i = 0;
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $user_id = $row['user_id'];
                $name = $row['name'];
                $folder[$i++] = new Entity_Folder($id, $user_id, $name);
            }
        }
        return $folder;
    }
}
