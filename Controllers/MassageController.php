<?php

namespace Controllers;

use Models\Admin;
use Models\Massage;

class MassageController extends VerificationController{

    public function displayAdminMassage(): void{
        $_SESSION['csrf_token_massage']= bin2hex(random_bytes(32));
        $_SESSION['csrf_token_delete_massage']= bin2hex(random_bytes(32));
        $_SESSION['csrf_token_update_massage']= bin2hex(random_bytes(32));
   
        $admin = new Admin();
        $massages = $admin->getAllMassages();

        $template = "Views/admin/massageManagement.phtml";
        include_once 'Views/common/layout.phtml';
    }

    public function insertMassage(): void{
        if (!empty($_POST['csrf_token_massage']) && $_POST['csrf_token_massage'] === $_SESSION['csrf_token_massage']) {
            unset($_SESSION['csrf_token_massage']);

            $errors = $this->verifyMassage();

            if(empty($errors)) {

                $admin = new Admin();
                date_default_timezone_set('Europe/Paris');
                $data = $admin->insertMassage([
                    'name' => $_POST['massage_name'],
                    'description' => $_POST['massage_info'],
                    'type' => $_POST['massage_type'],
                    'price30' => $_POST['massage_price30'], 
                    'price60' => $_POST['massage_price60'], 
                    'price90' => $_POST['massage_price90'], 
                    'created_at' => date('Y-m-d H:i:s'),
                    'modified_at' => date('Y-m-d H:i:s')
                ]);
                if($data === true) {
                    $_SESSION['message'] = "Votre Massage a bien été enregistré.";
                    header("location: index.php?route=admin_massage");
                    exit();
                } 
                else {
                    $_SESSION['error'] = "Erreur. Veuillez réessayer ultérieurement";
                    header("location: index.php?route=admin_massage"); 
                    exit();
                }
            }else{
                $_SESSION['formErrors'] = $errors;  
                header ("Location: index.php?route=admin_massage");
                exit();
            }
        }else{
            $_SESSION['error'] = "Erreur lors de l'envoi du formulaire."; 
            header ("Location: index.php?route=admin_massage");
            exit();
        }   
    }

    public function displayMassageReservation():void{

        $_SESSION['csrf_token_delete_reserv_admin']= bin2hex(random_bytes(32));
        
        $admin = new Admin();
        $reservations = $admin->getTotalReservations();
        $userMassageDetails = $admin->getUserMassageDetails();

        $template = "Views/admin/displayReservation.phtml";
        include_once 'Views/common/layout.phtml';
    }

    public function deleteMassage(){
   
        if (!empty($_POST['csrf_token_delete_massage']) && $_POST['csrf_token_delete_massage'] === $_SESSION['csrf_token_delete_massage']) {
            unset($_SESSION['csrf_token_delete_massage']);

            $id = $_POST['massage_id'];

            $inst = new Massage();
            $data = $inst->deleteMassageAdmin($id);

            if($data === true){
                $_SESSION['message'] = "Votre Massage a bien été supprimer.";
                header("location: index.php?route=admin_massage");
                exit();
            } 
            else {
                $_SESSION['error'] = "Erreur. Veuillez réessayer ultérieurement";
                header("location: index.php?route=admin_massage"); 
                exit();
            }
        }else{
            $_SESSION['error']="Erreur de sécurité. Veuillez retenter";
            header("location: index.php?route=admin_massage");
            exit();
        }
    }

    public function updateMassage(){
        if (!empty($_POST['csrf_token_update_massage']) && $_POST['csrf_token_update_massage'] === $_SESSION['csrf_token_update_massage']) {
            unset($_SESSION['csrf_token_update_massage']);

            $massage = new Massage();
            $data = $massage->updateMassageData([
                'name' => $_POST["name"],
                'type' => $_POST["type"],
                'description' => $_POST["description"],
                'price30' => $_POST["price30"],
                'price60' => $_POST["price60"],
                'price90'=> $_POST["price90"]
            ], $_POST ['id']);

            if($data === true) {
                $_SESSION['message'] = "Votre Massage a bien été modifié.";
                header("location: index.php?route=admin_massage");
                exit();
            } 
            else {
                $_SESSION['error'] = "Erreur. Veuillez réessayer ultérieurement";
                header("location: index.php?route=admin_massage"); 
                exit();
            }

        }else{
            $_SESSION['error']="Erreur de sécurité. Veuillez retenter";
            header("location: index.php?route=admin_massage");
            exit();
        }
    } 
}