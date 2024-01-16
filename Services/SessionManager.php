<?php

namespace Services;
/**
 * Gestionnaire de sessions pour la gestion des utilisateurs et des administrateurs.
 */
class SessionManager {
    /**
     * Vérifie si l'utilisateur est connecté.
     * @return bool Renvoie true si l'utilisateur est connecté, sinon redirige vers la page de réservation et renvoie false.
     */
    public static function checkUserSession():bool { 
        if (!empty($_SESSION['connectedUser'])) {
            return true;
        } else {
            $_SESSION['error'] = "Vous n'êtes pas connecté.";
            header("Location: index.php?route=reservation");
            return false;
        }
    }
    /**
    *Vérifie si l'utilisateur est un administrateur.
    * @return bool Renvoie true si l'utilisateur est un administrateur et a accès aux pages d'administration, sinon redirige vers la page d'accueil et renvoie false.
    */
    public static function checkAdminSession():bool{
        if($_REQUEST['route'] === 'admin_homepage' || 
            $_REQUEST['route'] === 'admin_massage' || 
            $_REQUEST['route'] === 'admin_tea' || 
            $_REQUEST['route'] === 'admin_reservation' || 
            $_REQUEST['route'] === 'admin_message' || 
            $_REQUEST['route'] === 'admin_information'){
    
            if(empty($_SESSION['connectedUser']) || 
                (!empty($_SESSION['connectedUser']) && ((int)$_SESSION['connectedUser']['role_id'] !== 1))) {
                header("Location: index.php?route=home");
                exit();
            } else {
                return true;
            }
        }
        return false;
    }
    /**
     * Détruit la session utilisateur.
     */
    public static function destroySession():void {
        session_destroy();
        session_start();
    }
}
