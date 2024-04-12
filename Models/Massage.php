<?php

namespace Models;

use Services\Database;
use \PDO;

class Massage{

protected PDO $db ;

    public function __construct()
    {
        $this->db = Database::getConnection() ;
    }

    public function selectMassages(){
        $sql = "SELECT `name`,`description`,`type`,`price30`,`price60`,`price90` FROM `massage`ORDER BY `type`";
        $result = $this->db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }

    public function updateMassageData($parameters,$id){
        $sql = "UPDATE `massage` SET `name`=:name,`description`=:description,`type`=:type,`price30`=:price30,`price60`=:price60, `price90`=:price90 WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters[':id'] = $id;
        return $query->execute($parameters);
    }

    public function deleteMassageAdmin (int $id){
        $sql = "DELETE FROM `massage` WHERE id = :id";
        $query = $this->db->prepare($sql);
        return $query->execute(['id'=> $id]);
    }
}