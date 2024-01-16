<?php

namespace Services;

use Controllers\ContactFormController;
use Controllers\HomeController;
use Controllers\UserController;
use Controllers\AdminSessionController;
use Controllers\UserSessionController;
use Controllers\ReservationController;


class Routing{
    /**
     * Fonction principale de routage.
     *
     * Cette fonction examine la valeur de la clé 'route' dans la variable $_GET
     * et appelle le contrôleur approprié en fonction de la route spécifiée.
     */
    public function routing():void
    {
        if(array_key_exists('route',$_GET)):

            switch  ($_GET['route']){  
                //Route pour les pages publiques (non connecté)
                case 'home':
                    $controller = new HomeController();
                    $controller->displayHomePage();
                break;
            
                case 'teahouse':
                    $controller = new HomeController();
                    $controller->displayTeaPage();
                break;
                
                case 'massage':
                    $controller = new HomeController();
                    $controller->displayMassagePage();
                break;
                
                case 'reservation':
                    $controller = new HomeController();
                    $controller->displayHomeReservPage();
                break;

                case 'contact':
                    $controller = new HomeController();
                    $controller->displayContactPage();
                break; 

                case 'submit_message':
                    $controller = new ContactFormController();
                    $controller->insertMessage(); 
                break;   

                //Route pour les pages de connexion et d'inscription

                case 'register':
                    $controller = new UserController();
                    $controller->register();
                break;

                case 'login': 
                    $controller = new UserController();
                    $controller->login();
                break;

                case 'logout':
                    $controller = new UserController();
                    $controller->logout();
                break;
                
                //Routes pour les pages de l'espace utilisateur

                case"user_homepage":
                    $controller = new UserSessionController();
                    $controller->displayUserHomepage();
                break;

                case 'user_appointment':
                    $controller = new UserSessionController();
                    $controller->displayUserAppointment();
                break;

                case "submitDelete":
                    $controller = new UserSessionController();
                    $controller->deleteUserReservation();
                break;

                case 'user_reservation':
                    $controller = new UserSessionController();
                    $controller->displayUserReservation();
                break;

                case 'user_information':
                    $controller = new UserSessionController();
                    $controller->displayUserInformation();
                break;
                
                case 'user_modification':
                    $controller = new UserSessionController();
                    $controller->modifUser(); 
                break;

                case 'user_delete':
                    $controller = new UserSessionController();
                    $controller->deleteUser();
                break;

                //Routes pour les pages de l'espace administrateur

                case 'admin_homepage':
                    $controller = new AdminSessionController();
                    $controller->displayAdminHomepage();
                break;

                case 'admin_massage':
                    $controller = new AdminSessionController();
                    $controller->displayAdminMassage();
                break;

                case "submitMassage":
                    $controller = new AdminSessionController();
                    $controller->insertMassage();
                break;

                case 'admin_tea':
                    $controller = new AdminSessionController();
                    $controller->displayAdminTea();
                break;

                case 'submitProduct':
                    $controller = new AdminSessionController();
                    $controller->insertNewProduct();
                break;

                case 'admin_reservation':
                    $controller = new AdminSessionController();
                    $controller->displayMassageReservation();
                break;

                case 'admin_message':
                    $controller = new AdminSessionController();
                    $controller->displayClientMessage();
                break;

                case 'admin_userManagement':
                    $controller = new AdminSessionController();
                    $controller->displayUserInformation();
                break;
                
                //Routes pour les pages de réservation de massage

                case 'fetchReservedDates':
                    $controller = new ReservationController();
                    $controller->fetchReservedDates();
                break;

                case 'verifReservation':
                    $controller = new ReservationController();
                    $controller->checkAvailability();
                break;

                case "submitReservation":
                    $controller = new ReservationController();
                    $controller->insertReservation();
                break;
                default:
                    header('Location: index.php?route=home');
                    exit;
                break;

            }
            else:
                header ('Location: index.php?route=home');
                exit;
        endif;
    }              
};

    
