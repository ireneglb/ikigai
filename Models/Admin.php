<?php

namespace Models;

use Services\Database;
use \PDO;

class Admin 
{
    protected PDO $db ;

    public function __construct()
    {
        $this->db = Database::getConnection() ;
    }

    public function insertMassage($parameters){
        $sql = "INSERT INTO `massage`(`name`, `description`, `type`, `price`, `created_at`,`modified_at`) VALUES (:name, :description, :type, :price, :created_at,:modified_at)";
        $query = $this->db->prepare($sql);
        return $query->execute($parameters);
    }

    public function getAllMassages(){
        $sql = "SELECT `id`,`name`,`description`,`type`,`price30`,`price60`,`price90`,`created_at`,`modified_at` FROM massage";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProducts(){
        $sql = "SELECT `id`,`name`,`image`,`description`,`price`,`created_at`,`updated_at` FROM product";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } 
    
    public function insertProduct($parameters){
        $sql = "INSERT INTO `product`(`name`, `image`, `description`, `price`, `created_at`, `updated_at`) VALUES (:name, :image, :description, :price, :created_at, :updated_at)";
        $query = $this->db->prepare($sql);
        return $query->execute($parameters);
    }

    public function getUserMassageDetails(){
        $query="SELECT reservation.duration, reservation.datetime_start, reservation.offer, 
                    user.firstname AS user_firstname, 
                    user.lastname AS user_lastname, 
                    massage.name AS massage_name,
                    massage.type AS massage_type,
                    massage.price30 AS massage_price30,
                    massage.price60 AS massage_price60,
                    massage.price90 AS massage_price90
                FROM 
                    reservation
                INNER JOIN 
                    user ON reservation.user_id = user.id
                INNER JOIN 
                    massage ON reservation.massage_id = massage.id
            ";
    
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalReservations(){
        $query = "SELECT COUNT(*) AS total_reservations FROM reservation";
    
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_reservations'];
    }

   
}