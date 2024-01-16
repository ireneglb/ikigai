<?php

namespace Models;

use Services\Database;
use \PDO;

class User 
{
    protected PDO $db ;

    public function __construct()
    {
        $this->db = Database::getConnection() ;
    }

    public function insertUser($parameters){
        $sql = "INSERT INTO `user`(`role_id`,`lastname`, `firstname`,`phone`,`email`,`password`, `created_at`) VALUES (:role_id, :lastname, :firstname,:phone,:email,:password, :created_at)";
        $query = $this->db->prepare($sql);
        return $query->execute($parameters);
    }

    public function findByEmail($email){
        $sql = "SELECT `id`, `role_id`, `firstname`, `lastname`, `phone`, `email`, `password`, `created_at` FROM user WHERE email = :email ";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':email',$email);
        $stm->execute();
        $userFound = $stm->fetch((PDO::FETCH_ASSOC));
        return $userFound;
    }

    public function updateInfoUser($parameters,$id){
        $sql = "UPDATE `user` SET `lastname`=:lastname,`firstname`=:firstname,`phone`=:phone,`email`=:email WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters[':id'] = $id;
        return $query->execute($parameters);
    }

    public function getUserReservations($userId){
        $sql = "SELECT reservation.id as reservation_id, massage.name as massage_name, reservation.price, reservation.duration, reservation.created_at 
            FROM reservation 
            INNER JOIN massage ON reservation.massage_id = massage.id 
            WHERE reservation.user_id = :userId";
        $query = $this->db->prepare($sql);
        $query->execute([':userId' => $userId]);
        $reservations = $query->fetchAll(PDO::FETCH_ASSOC);
        return $reservations;
    }
    
    public function deleteMassageReservation($reservationId, $userId){
        $sql = "DELETE FROM reservation WHERE id = :reservationId AND user_id = :userId";
        $query = $this->db->prepare($sql);
        return $query->execute([':reservationId' => $reservationId, ':userId' => $userId]);
    }

    public function verifInfoBeforeDelete($userId){
        $currentDate = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM reservation WHERE user_id = :userId AND datetime_start > :currentDate";
        $query = $this->db->prepare($sql);
        $parameters = [
            ':userId' => $userId,
            ':currentDate' => $currentDate
        ];
        $query->execute($parameters);
        
        return $query->rowCount() > 0;
    }

    public function deleteUserAccount (int $id)
    {
        $sql = "DELETE FROM `user` WHERE id = :id";
        $query = $this->db->prepare($sql);
        return $query->execute(['id'=> $id]);
    }
        

}