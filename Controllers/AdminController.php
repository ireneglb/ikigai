<?php

namespace Controllers;

use Models\Admin;
use Models\Reservation;

class AdminController extends VerificationController{
   
    public function displayAdminHomepage(): void{

        $template = "Views/admin/index.phtml";
        include_once 'Views/common/layout.phtml';                                      
    }

    public function displayUserInformation():void{

        $_SESSION['csrf_token_delete_admin'] = bin2hex(random_bytes(32));

        $admin = new Admin();
        $totalUser = $admin->getTotalUser();
        $displayUsers = $admin->getAllUsers();

        $template = "Views/admin/userManagement.phtml";
        include_once 'Views/common/layout.phtml';
    }

    public function AdminDeleteUser() {
        if (empty($_POST['admin_user_id'])) {
            $_SESSION['error'] = "ID utilisateur invalide.";
            header ("Location: index.php?route=admin_userManagement");
            exit;
        }    
        $user_id = $_POST['admin_user_id']; 
        $adminModel = new Admin();
        $success = $adminModel->deleteUserAndReservations($user_id);

        if ($success) {
            $_SESSION['message'] = "L'utilisateur a bien été supprimé";
            header ("Location: index.php?route=admin_userManagement");
            exit;
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression. Veuillez réessayer.";
            header ("Location: index.php?route=admin_userManagement");
            exit;
        }
    }

    public function deleteReservationbyAdmin():void{
        if(!empty($_POST['csrf_token_delete_reserv_admin']) && $_POST['csrf_token_delete_reserv_admin'] === $_SESSION['csrf_token_delete_reserv_admin']) {
            unset($_SESSION['csrf_token_delete_reserv_admin']);

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(!empty($_POST['admin_reserv_id'])){
                    
                    $reservationId = $_POST['admin_reserv_id'];
                   
                    $reservation = new Reservation();
                    $succes = $reservation->deleteReservation($reservationId);
    
                    if($succes === true) {
                        $_SESSION['message'] = "La réservation a bien été supprimée";
                        header("location: index.php?route=admin_reservation"); 
                        exit();
                    } 
                    else {
                        $_SESSION['error'] = "Erreur lors de la suppression de la réservation. Veuillez réessayer ultérieurement";
                        header("location: index.php?route=admin_reservation"); 
                        exit();
                    }    
                }   
                $_SESSION['error'] = "ID de réservation invalide.";
                header("location: index.php?route=admin_reservation"); 
                exit();
            }
        }else{
            $_SESSION['error'] = "Erreur lors de l'envoi du formulaire."; 
            header ("Location: index.php?route=admin_reservation");
            exit();
        }
    }
}