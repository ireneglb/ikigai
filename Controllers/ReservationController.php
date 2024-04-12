<?php

namespace Controllers;

use Models\Reservation;
class ReservationController extends VerificationController{

    public function fetchReservedDates(): void{
        $reservation = new Reservation();
        $reservedDates = $reservation->getReservationsTimeAndDuration();
        echo json_encode($reservedDates);
    }

    public function checkAvailability(): void{
        $reservation = new Reservation();
        $check = $reservation->check($_POST['datetime_start'], $_POST['duration']);

        $response = ['status' => 'success', 'message' => 'La date ou l\'heure est actuellement disponible.'];
        
        if(!$check) {
            $response = ['status' => 'error', 'message' => 'La date ou l\'horaire est déjà réservée.'];
        }
        echo json_encode($response);
    }

    public function insertReservation(): void{
        
        if (!empty($_POST['csrf_token_reservation']) && $_POST['csrf_token_reservation'] === $_SESSION['csrf_token_reservation']) {
            unset($_SESSION['csrf_token_reservation']);

            $errors = $this->verifyReservation();
            
            if(empty($errors)) {
                
                $user = new Reservation();
                date_default_timezone_set('Europe/Paris');
                $data = $user->submitReservation([
                    'user_id' => $_SESSION['connectedUser']['id'], 
                    'massage_id' => $_POST['types_massage'],
                    'datetime_start' => $_POST['select_date'],
                    'duration' => $_POST['duration'],
                    'offer' =>  intval(!empty($_POST['special_offer'])),
                    'price' => $_POST['tarif'],
                    'created_at' => date('Y-m-d H:i:s')
                ]);
              
                if($data === true) {
                    $_SESSION['message'] = "Votre réservation a bien été prise en compte";
                    header("location: index.php?route=user_appointment"); 
                    exit();
                } 
                else {
                    $_SESSION['error'] = "Erreur lors de la réservation. Veuillez réessayer ultérieurement";
                    header("location: index.php?route=user_reservation"); 
                    exit();
                }
            }else{
                $_SESSION['formErrors'] = $errors;  
                header ("Location: index.php?route=user_reservation");
                exit();
            }
        }else{
            $_SESSION['error'] = "Erreur lors de l'envoi du formulaire."; 
            header ("Location: index.php?route=user_reservation");
            exit();
        }   
    }
}