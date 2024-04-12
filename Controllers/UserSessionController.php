<?php

namespace Controllers;

use Models\User;
use Models\Reservation;
use Services\SessionManager;

class UserSessionController extends VerificationController {

    public function displayUserHomepage():void{
        
        $template = "Views/user/index.phtml";
        include_once 'Views/common/layout.phtml';                                      
    }

    public function displayUserReservation():void{
        
        $_SESSION['csrf_token_reservation'] = bin2hex(random_bytes(32));

        $reservation = new Reservation();
        $displayMassages = $reservation->getReservationTypeAndName();

        $template = "Views/user/reservation.phtml";
        include_once 'Views/common/layout.phtml';
    }

    public function displayUserAppointment():void{

        $_SESSION['csrf_token_delete_reserv'] = bin2hex(random_bytes(32));

        $user = new User();
        $userReservations = $user->getUserReservations($_SESSION['connectedUser']['id']);
        
        if(empty($userReservations)) {
            $message = "Aucune réservation à venir";
        } else {
            $message = "";
        }

        $template = "Views/user/appointment.phtml";
        include_once 'Views/common/layout.phtml';
    }

    public function deleteUserReservation():void{
        if(!empty($_POST['csrf_token_delete_reserv']) && $_POST['csrf_token_delete_reserv'] === $_SESSION['csrf_token_delete_reserv']) {
            unset($_SESSION['csrf_token_delete_reserv']);

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(!empty($_POST['id'])){
                    
                    $reservationId = $_POST['id'];
                    $userId = $_SESSION['connectedUser']['id'];
                   
                    $reservation = new User();
                    $data = $reservation->deleteMassageReservation($reservationId, $userId);
    
                    if($data === true) {
                        $_SESSION['message'] = "Votre réservation a bien été supprimée";
                        header("location: index.php?route=user_appointment"); 
                        exit();
                    } 
                    else {
                        $_SESSION['error'] = "Erreur lors de la suppression de votre réservation. Veuillez réessayer ultérieurement";
                        header("location: index.php?route=user_appointment"); 
                        exit();
                    }    
                }  
            }
        }else{
            $_SESSION['error'] = "Erreur lors de l'envoi du formulaire."; 
            header ("Location: index.php?route=user_appointment");
            exit();
        }
    }

    public function displayUserInformation():void{
        
        $_SESSION['csrf_token_modif']= bin2hex(random_bytes(32));
        $_SESSION['csrf_token_delete']= bin2hex(random_bytes(32));

        $template = "Views/user/modifUser.phtml";
        include_once 'Views/common/layout.phtml';
    }

    public function modifUser():void{
        
        $message = null; 

        if(!empty($_POST['csrf_token_modif']) && $_POST['csrf_token_modif'] === $_SESSION['csrf_token_modif']) {
            unset($_SESSION['csrf_token_modif']);

            try{
                if(!empty ($_POST)){

                    $errors = $this->verifyForm();
                    if (!empty($errors)) {
                        $_SESSION['error']= "Erreur lors de la modification";
                        header("location: index.php?route=user_information");
                        exit();
                    }

                    $update = $this->updateInfoUser([
                        'lastname' => $_POST ['user_lastname'],
                        'firstname' => $_POST ['user_firstname'],
                        'phone' => $_POST ['user_number'],
                        'email' => $_POST ['user_mail']
                    ], $_POST ['id']);
                
                    if($update === true){
                        $_SESSION['message'] = "Les modifications ont bien été effectués";}
                    else{
                        $_SESSION['error']="Erreur lors de la modification ";
                        header("location: index.php?route=user_information");
                        exit();
                    }
                    $_SESSION['connectedUser']['lastname'] = $_POST ['user_lastname'];
                    $_SESSION['connectedUser']['firstname'] = $_POST ['user_firstname'];
                    $_SESSION['connectedUser']['phone'] = $_POST ['user_number'];
                    $_SESSION['connectedUser']['email'] = $_POST ['user_mail'];

                header ("location: index.php?route=user_homepage");
                }
            }catch(\Exception $exception){
            die($exception->getMessage());
            }
        }else{
            $_SESSION['error'] = "Erreur lors de l'envoi du formulaire."; 
            header ("Location: index.php?route=user_information");
            exit();
        }  
    } 

    private function updateInfoUser($parameters, $id):bool{ 
        $user = new User();
        return $user->updateInfoUser($parameters, $id);
    }

    public function deleteUser():void{ 
        if(!empty($_POST['csrf_token_delete']) && $_POST['csrf_token_delete'] === $_SESSION['csrf_token_delete']) {
            unset($_SESSION['csrf_token_modif']);

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(!empty($_POST['id'])){
                    
                    $id= $_POST['id'];

                    $user = new User();
                    $hasUpcomingReservation = $user->verifInfoBeforeDelete($id);
    
                    if ($hasUpcomingReservation === true) {
                        $_SESSION['error'] = "Vous ne pouvez pas supprimer votre compte car vous avez une réservation en cours";
                        header("location: index.php?route=user_homepage"); 
                        exit();
                    } 
                    else {
                    
                        $data = $user->deleteUserAccount($id);
    
                        if($data === true) {
                            SessionManager::destroySession();
                            $_SESSION['message'] = "Votre compte a bien été supprimé";
                            header("location: index.php?route=homepage"); 
                            exit();
                        } 
                        else {
                            $_SESSION['errorDelete'] = "Erreur lors de la suppression de votre compte. Veuillez réessayer ultérieurement";
                            header("location: index.php?route=user_homepage"); 
                            exit();
                        }
                    }    
                }  
            }
        }else{
            $_SESSION['error'] = "Erreur lors de l'envoi du formulaire."; 
            header ("Location: index.php?route=user_information");
            exit();
        }   
    }    
}