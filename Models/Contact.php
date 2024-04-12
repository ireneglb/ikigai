<?php

namespace Models;

use Services\Database;
use \PDO;

class Contact{

protected PDO $db ;

    public function __construct()
    {
        $this->db = Database::getConnection() ;
    }

    public function insert($parameters){
        $sql = "INSERT INTO `contact`(`firstname`, `lastname`, `phone`,`email`,`message`,`created_at`) VALUES (:firstname, :lastname, :phone,:email, :message, :created_at)";
        $query = $this->db->prepare($sql);
        return $query->execute($parameters);
    }

    public function countMessagesByEmailOrPhone($email, $phone) {
        $sql = "SELECT COUNT(*) FROM contact WHERE email = :email OR phone = :phone";
        $query = $this->db->prepare($sql);
        $query->execute([':email' => $email, ':phone' => $phone]);
        return $query->fetchColumn();
    }
}