<?php

namespace Services;

use Controllers\AdminController;
use Controllers\AuthController;
use Controllers\ContactFormController;
use Controllers\MassageController;
use Controllers\MessageController;
use Controllers\PageController;
use Controllers\ReservationController;
use Controllers\TeaController;
use Controllers\UserSessionController;

class Routing {
    // Fonction principale de routage.
             
    public function routing(): void {

        $routes = [
            // Routes pour les pages publiques (non connecté)
            'home' => ['controller' => PageController::class, 'method' => 'displayHomePage'],
            'teahouse' => ['controller' => PageController::class, 'method' => 'displayTeaPage'],
            'massage' => ['controller' => PageController::class, 'method' => 'displayMassagePage'],
            'reservation' => ['controller' => PageController::class, 'method' => 'displayHomeReservPage'],
            'contact' => ['controller' => PageController::class, 'method' => 'displayContactPage'],
            'submit_message' => ['controller' => ContactFormController::class, 'method' => 'insertMessage'],

            // Routes pour la gestion de l'authentification
            'register' => ['controller' => AuthController::class, 'method' => 'register'],
            'login' => ['controller' => AuthController::class, 'method' => 'login'],
            'logout' => ['controller' => AuthController::class, 'method' => 'logout'],

            // Routes pour l'espace utilisateur
            'user_homepage' => ['controller' => UserSessionController::class, 'method' => 'displayUserHomepage'],
            'user_appointment' => ['controller' => UserSessionController::class, 'method' => 'displayUserAppointment'],
            'submitDelete' => ['controller' => UserSessionController::class, 'method' => 'deleteUserReservation'],
            'user_reservation' => ['controller' => UserSessionController::class, 'method' => 'displayUserReservation'],
            'user_information' => ['controller' => UserSessionController::class, 'method' => 'displayUserInformation'],
            'user_modification' => ['controller' => UserSessionController::class, 'method' => 'modifUser'],
            'user_delete' => ['controller' => UserSessionController::class, 'method' => 'deleteUser'],

            // Routes pour l'espace administrateur
            'admin_homepage' => ['controller' => AdminController::class, 'method' => 'displayAdminHomepage'],
            'admin_massage' => ['controller' => MassageController::class, 'method' => 'displayAdminMassage'],
            'submitMassage' => ['controller' => MassageController::class, 'method' => 'insertMassage'],
            'admin_tea' => ['controller' => TeaController::class, 'method' => 'displayAdminTea'],
            'submitProduct' => ['controller' => TeaController::class, 'method' => 'insertNewProduct'],
            'submitImage' => ['controller' => TeaController::class, 'method' => 'insertImage'],
            'admin_reservation' => ['controller' => MassageController::class, 'method' => 'displayMassageReservation'],
            'admin_message' => ['controller' => MessageController::class, 'method' => 'displayClientMessage'],
            'admin_userManagement' => ['controller' => AdminController::class, 'method' => 'displayUserInformation'],
            'admin_delete_user' => ['controller' => AdminController::class, 'method' => 'AdminDeleteUser'],
            'admin_deleteMassage' => ['controller' => MassageController::class, 'method' => 'deleteMassage'],
            'admin_updateMassage' => ['controller' => MassageController::class, 'method' => 'updateMassage'],
            'admin_delete_msg' => ['controller' => MessageController::class, 'method' => 'deleteMsg'],
            'admin_delete_reserv' => ['controller' => AdminController::class, 'method' => 'deleteReservationbyAdmin'],

            // Routes pour les pages de réservation de massage
            'fetchReservedDates' => ['controller' => ReservationController::class, 'method' => 'fetchReservedDates'],
            'verifReservation' => ['controller' => ReservationController::class, 'method' => 'checkAvailability'],
            'submitReservation' => ['controller' => ReservationController::class, 'method' => 'insertReservation'],
        ];

        // Vérifie si la route demandée existe dans le tableau $routes
        if (isset($_GET['route']) && array_key_exists($_GET['route'], $routes)) {
            $route = $routes[$_GET['route']];
            $controllerName = $route['controller'];
            $methodName = $route['method'];

            $controller = new $controllerName();
            $controller->$methodName();
        } else {
            header('Location: index.php?route=home');
            exit;
        }
    } 
};
