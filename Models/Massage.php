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

}