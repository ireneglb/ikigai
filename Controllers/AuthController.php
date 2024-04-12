<?php

namespace Controllers;

use Models\User;
use Services\SessionManager;

class AuthController extends VerificationController{

    public function register(): void{
        unset($_SESSION['formErrors']);
        unset($_SESSION['error']);
            
        if(!empty($_POST['csrf_token_register']) && $_POST['csrf_token_register'] === $_SESSION['csrf_token_register']) {
            unset($_SESSION['csrf_token_register']);

            $errors = $this->verifyForm();
            $errors = array_merge($errors, $this->verifyEmailandPassword());

            if(empty($errors)) {

                $originalpassword = $_POST['user_password'];
                $hashpassword = password_hash($originalpassword, PASSWORD_BCRYPT);   
                
                try{
                    $user = new User();
                    $existingUser = $user->findByEmail($_POST['email']);

                    if($existingUser){
                        $_SESSION['error'] =  "Erreur : L'utilisateur existe déjà.Veuillez réessayer.";
                        header ("Location: index.php?route=reservation");
                        exit();
                    }else{ 
                        date_default_timezone_set('Europe/Paris');
                        $user->insertUser([
                        'role_id'=> 2,  
                        'lastname'=> $_POST['user_lastname'],
                        'firstname'=> $_POST['user_firstname'],
                        'phone'=> $_POST['user_number'], 
                        'email'=> $_POST['user_mail'], 
                        'password'=> $hashpassword,
                        'created_at' => date('Y-m-d H:i:s')
                        ]);

                        $_SESSION['message'] = "Bien enregistré. Vous pouvez maintenant vous connecter.";

                        header('Location: index.php?route=reservation'); 
                        exit();
                    }    
                } catch (\PDOException) {    
                    $_SESSION['error'] = "Erreur lors de l'insertion en base de données";  
                    header("Location: index.php?route=reservation"); 
                    exit();
                }   

            } else {
                $_SESSION['formErrors'] = $errors;  
                header ("Location: index.php?route=reservation");
                exit();
            }    

        }else{
            $_SESSION['error'] = "Erreur lors de l'envoi du formulaire."; 
            header ("Location: index.php?route=reservation");
            exit();
        }   
    }
     
    public function login(): void{
        unset($_SESSION['formErrors']);
        unset($_SESSION['error']);
        

        if(!empty($_POST['csrf_token_login']) && $_POST['csrf_token_login'] === $_SESSION['csrf_token_login']) {
            unset($_SESSION['csrf_token_login']);

            $errors = $this->verifyEmailandPassword();

            if(empty($errors)) {
                try{
                    $user =new User();
                    $userFound = $user->findByEmail($_POST['user_mail']); 

                    if(!$userFound){
                        $_SESSION['error'] =  "Erreur : L'utilisateur n'existe pas.";
                        header ("Location: index.php?route=reservation");
                        exit();
                    }else{
                        if ($userFound && password_verify($_POST['user_password'], $userFound['password'])) {                  
                            
                            $_SESSION['connectedUser'] =  [
                                    'id' => $userFound['id'],
                                    'role_id' => $userFound['role_id'],
                                    'lastname' => $userFound['lastname'],
                                    'firstname' => $userFound['firstname'],
                                    'phone' => $userFound['phone'],
                                    'email' => $userFound['email'],
                            ]; 
                            
                                if ($userFound['role_id'] === 1) {
                                    header("Location: index.php?route=admin_homepage");
                                    exit();
                                } else {
                                    header("Location: index.php?route=user_homepage");
                                    exit();
                                }
                        }else{
                            $_SESSION['error'] =  "Erreur : Le mot de passe est incorrect.";
                            header ("Location: index.php?route=reservation");
                            exit();
                        }
                    }
                } catch (\PDOException) {
                    $_SESSION['error'] = "Erreur lors de la connexion ";  
                    header("Location: index.php?route=reservation"); 
                    exit();
                }
            } else {
                $errors = $_SESSION['formErrors']; 
                $_SESSION['error']="Erreur lors de la connexion";
                header ("Location: index.php?route=reservation");
                exit();
            }
        }else{
            $_SESSION['error'] = "Erreur lors de l'envoi du formulaire.";
            header ("Location: index.php?route=reservation");
            exit();
        }
    }

    public function logout(): void{
        SessionManager::destroySession();
        $_SESSION['message'] = "Vous êtes déconnecté";
        header("Location: index.php?route=reservation");
        exit();
    }
}