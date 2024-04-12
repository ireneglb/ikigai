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
        $sql = "INSERT INTO `massage`(`name`, `description`, `type`, `price30`, `price60`,`price90`,`created_at`,`modified_at`) VALUES (:name, :description, :type, :price30, :price60, :price90, :created_at,:modified_at)";
        $query = $this->db->prepare($sql);

        return $query->execute($parameters);
    }

    public function getAllMassages(){
        $sql = "SELECT `id`,`name`,`description`,`type`,`price30`,`price60`,`price90`,`created_at`,`modified_at` FROM massage";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertProduct($parameters){
        $sql = "INSERT INTO `product`(`name`,`description`, `price`, `created_at`, `updated_at`,`type_id`) VALUES (:name, :description, :price, :created_at, :updated_at, :type_id)";
        $query = $this->db->prepare($sql);

        return $query->execute($parameters);
    }

    public function getProductByCategory($type_id) {
        $sql = "SELECT `id`,`name`,`description`,`price`,`created_at`,`updated_at`,`type_id` FROM product WHERE type_id = :type_id";
        $query = $this->db->prepare($sql);
        $query->execute([':type_id' => $type_id]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsers(){
        $sql = "SELECT `id`,`firstname`,`lastname`,`phone`,`email`,`created_at` FROM user WHERE role_id = 2";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    } 

    public function getTotalUser(){
        $sql = "SELECT COUNT(*) AS total_user FROM user";
        $query = $this->db->prepare($sql);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);

        return $row['total_user'];
    }

    public function checkImageExist($type_id) {
        $sql = "SELECT COUNT(*) FROM images WHERE type_id = :type_id";
        $query = $this->db->prepare($sql);
        $query->execute(['type_id' => $type_id]);
        $count = $query->fetchColumn();

        return ($count > 0);
    }

    public function insertImage($parameters){
        $sql = "INSERT INTO `images` (`file_name`,`file_path`, `type_id`) VALUES (:image_name,:file_path,:type_id)";
        $query = $this->db->prepare($sql);

        return $query->execute($parameters);
    }

    public function getAllImages(){
        $sql = "SELECT `file_name` FROM images";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserMassageDetails(){
        $sql = "SELECT reservation.id,reservation.duration, reservation.datetime_start, reservation.offer, 
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
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalReservations(){
        $sql = "SELECT COUNT(*) AS total_reservations FROM reservation";
        $query = $this->db->prepare($sql);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);

        return $row['total_reservations'];
    }

    public function getTotalMsg(){
        $sql = "SELECT COUNT(*) AS total_message FROM contact";
        $query = $this->db->prepare($sql);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_message'];
    }

    public function deleteMsg($msg_id){
        $sql="DELETE FROM `contact` WHERE id = :msg_id";
        $query = $this->db->prepare($sql);

        return $query->execute(['msg_id'=> $msg_id]);
    }
    
    public function displayMsgClient(){
        $sql="SELECT `id`,`firstname`,`lastname`,`phone`,`email`,`message`,`created_at` FROM contact";  
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }  

    public function deleteUserAndReservations($user_id) {
        try {
            $this->db->beginTransaction();

            // Supprimer les réservations de l'utilisateur
            $sql_delete_reservations = "DELETE FROM reservation WHERE user_id = :user_id";
            $query_delete_reservations = $this->db->prepare($sql_delete_reservations);
            $query_delete_reservations->execute([':user_id' => $user_id]);

            // Supprimer l'utilisateur lui-même
            $sql_delete_user = "DELETE FROM user WHERE id = :user_id";
            $query_delete_user = $this->db->prepare($sql_delete_user);
            $query_delete_user->execute([':user_id' => $user_id]);

            $this->db->commit();
            return true;
        } catch (\PDOException $e) {
            $this->db->rollBack();
            $_SESSION['error'] = "Erreur lors de la suppression. Veuillez rééssayer.";
            header ("Location: index.php?route=admin_homepage");
            exit;
            return false;
        }
    }
}