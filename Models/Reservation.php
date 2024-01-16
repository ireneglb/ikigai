<?php

namespace Models;

use Services\Database;
use \PDO;

class Reservation{

protected PDO $db ;

    public function __construct()
    {
        $this->db = Database::getConnection() ;
    }

    public function getReservationsTimeAndDuration(){
        $sql = "SELECT datetime_start, duration FROM reservation ORDER BY datetime_start";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getReservationTypeAndName(){
        $sql = "SELECT id, name, type FROM massage";
        $result = $this->db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }

    public function getMassagebyId(){
        $sql = "SELECT name, type FROM massage WHERE id = :id";
        $result = $this->db->prepare($sql);
        $result->execute([':id' => $_GET['id']]);
        return $result->fetch();
    }

    public function submitReservation($parameters){
        $sql = "INSERT INTO reservation (user_id, massage_id, datetime_start, duration, offer, price,created_at) VALUES (:user_id, :massage_id, :datetime_start, :duration, :offer, :price,:created_at)";
        $query = $this->db->prepare($sql);
        return $query->execute($parameters);
    }

    public function check($datetime_start, $duration){
        $sql = "SELECT `id`,`user_id`,`massage_id`,`datetime_start`,`duration`,`offer`,`price`,`created_at` FROM reservation 
        WHERE datetime_start = :start_time 
        OR (datetime_start < :start_time AND ADDTIME(`datetime_start`,`duration`)> :start_time) 
        OR (datetime_start >= :start_time AND datetime_start < ADDTIME(:start_time, :duration))";
        $parameters = [
            ':start_time' => $datetime_start,
            ':duration' => $duration
        ];
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->rowCount() === 0;
    }
}