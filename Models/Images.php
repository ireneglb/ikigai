<?php

namespace Models;

use Services\Database;
use \PDO;

class Images{

    protected PDO $db ;

    public function __construct()
    {
        $this->db = Database::getConnection() ;
    }

    public function getImageByCategory($categoryId) {
        $sql = "SELECT file_path FROM images WHERE type_id = :category_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute([':category_id' => $categoryId]);
        
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}