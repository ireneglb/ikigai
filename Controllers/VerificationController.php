<?php

namespace Controllers;

use Services\SessionManager;
class VerificationController{

    public function __construct(){
        SessionManager::checkUserSession();
        SessionManager::checkAdminSession();
    }

    protected function verifyForm(): array {
        $errors = [];
        $lastName = trim($_POST['user_lastname'] ?? ''); 
        $firstName = trim($_POST['user_firstname'] ?? '');
        $phone = trim($_POST['user_number'] ?? '');

        if (empty($lastName)) {
            $errors[] = "Le champ Nom est vide.";
        } elseif (strlen($lastName) < 2) {                                          
            $errors[] = "Le champ Nom doit contenir au moins 2 caractères.";
        } elseif (!preg_match('/^[a-zA-ZÀ-ÿ]+$/', $lastName)){                      
            $errors[] = "Le champ Nom ne doit contenir que des lettres.";
        } 

        if (empty($firstName)) {
            $errors[] = "Le champ Prénom est vide.";
        } elseif (strlen($firstName) < 2) {
            $errors[] = "Le champ Prénom doit contenir au moins 2 caractères.";
        } elseif (!preg_match('/^[a-zA-ZÀ-ÿ]+$/', $firstName)) {
            $errors[] = "Le champ Prénom ne doit contenir que des lettres.";
        } 

        if (empty($phone)) {
            $errors[] = "Le champ Numéro de téléphone est vide.";  
        }else if(!preg_match('/^\d{10,12}$/', $phone)) {
            $errors[] = "Le champ Numéro de téléphone doit contenir entre 10 et 12 chiffres.";
        }

        return $errors;
    }

    protected function verifyMessageandEmail(): array {
        $errors = [];
        $message = trim($_POST['user_text'] ?? '');
        $email = trim($_POST['user_mail'] ?? '');

        if (empty($message)) {
            $errors[] = "Le champ message est vide.";
        }
    
        if (empty($email)) {
            $errors[] = "Le champ email est vide.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Le champ email n'est pas valide.";
        }
    
        return $errors;
    }

    protected function verifyEmailAndPassword(): array{
        $errors = [];
        $email = trim($_POST['user_mail'] ?? '');
        $password = trim($_POST['user_password'] ?? '');
    
        if (empty($email)) {
        $errors[] = "Le champ email est vide.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Le champ email n'est pas valide.";
        }

        if (empty($password)) {
            $errors[] = "Le champ mot de passe est vide.";
        } elseif (strlen($password) < 8) {
            $errors[] = "Le champ mot de passe doit contenir au moins 8 caractères.";
        } elseif (!preg_match('/[0-9]/', $password)) {
            $errors[] = "Le champ mot de passe doit contenir au moins un chiffre.";
        } elseif (!preg_match('/[&@!?;()]/', $password)) {
            $errors[] = "Le champ mot de passe doit contenir au moins un des caractères spéciaux suivants : &@!?;()";
        }
        
        return $errors;
    }

    protected function verifyReservation(): array{
        
        $errors = [];
        $select_date = trim($_POST['select_date'] ?? '');
        $massage_type = trim($_POST['types_massage'] ?? '');
        $massage_time = trim($_POST['duration'] ?? '');
    
        if (empty($select_date)) {
            $errors[] = "Le champ date et heure est vide.";
        }
        if (empty($massage_type)) {
            $errors[] = "Le champ type de massage est vide.";
        }
        if (!in_array($massage_time, ['00:30:00', '01:00:00', '01:30:00'])) {
            $errors[] = "Le champ durée du massage est invalide.";
        }
        return $errors;
 
    }

    protected function verifyMassage(): array{
        $errors = [];
        $massage_name = trim($_POST['massage_name'] ?? '');
        $massage_type = trim($_POST['massage_type'] ?? '');
        $massage_info = trim($_POST['massage_info'] ?? '');
        $massage_price30 = trim($_POST['massage_price30'] ?? '');
        $massage_price60 = trim($_POST['massage_price60'] ?? '');
        $massage_price90 = trim($_POST['massage_price90'] ?? '');

        if (empty($massage_name)) {
            $errors[] = "Le champ nom du massage est vide.";
        } 
        if (empty($massage_type)) {
            $errors[] = "Le champ type du massage est vide.";
        } 
        if (empty($massage_info)) {
            $errors[] = "Le champ description du massage est vide.";
        } 
        if (empty($massage_price30) || empty($massage_price60) || empty($massage_price90)) {
            $errors[] = "Veuillez remplir tous les prix.";
        } elseif (!is_numeric($massage_price30) || !is_numeric($massage_price60) || !is_numeric($massage_price90)) {
            $errors[] = "Le champ prix du massage doit contenir uniquement des chiffres.";
        }
    
        return $errors;
    }

    protected function verifFormProduct(): array{
        $errors = [];
        
        $name = trim($_POST['product_name']);
        $type = trim($_POST['product_type']);
        $description = trim($_POST['product_info']);
        $price = trim($_POST['product_price']);
        

        if (empty($name) ) {
            $errors[] = "Veuillez renseigner le nom du produit.";
        }elseif (strlen($name) < 3) {
            $errors[] = "Le nom du produit doit contenir au moins 3 caractères.";
        }

        if (empty($type)) {
                $errors[] = "Veuillez sélectionner une catégorie pour le produit.";
        }

        if (empty(trim($description))) {
            $errors[] = "Veuillez renseigner la description du produit.";
        } elseif (strlen(trim($description)) < 10) {
            $errors[] = "La description du produit doit contenir au moins 10 caractères.";
        }

        if (empty($price)) {
            $errors[] = "Veuillez renseigner le prix du produit.";
        } elseif (!preg_match('/^\d+(\.\d+)?$/', $price)) {
            $errors[] = "Le prix du produit doit être un nombre entier ou décimal.";
        }

        return $errors;
    }
}                         