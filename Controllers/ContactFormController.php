<?php

namespace Controllers;

use Models\Contact;

class ContactFormController extends VerificationController{

    public function displayContactForm(): void {
        $_SESSION['contact_form_csrf_token'] = bin2hex(random_bytes(32));
        
        $template = "Views/home/contactForm.phtml";
        include_once 'Views/common/layout.phtml';      
    } 

    public function insertMessage(): void {
        $_SESSION['formErrors'] = [];
        
        $errors = $this->verifyForm();
        $errors = array_merge($errors, $this->verifyMessageAndEmail());

        if (!empty($_POST['csrf_token_formMessage']) && $_POST['csrf_token_formMessage'] === $_SESSION['contact_form_csrf_token']) {
            unset($_SESSION['contact_form_csrf_token']);

            if(empty($errors)) {

                date_default_timezone_set('Europe/Paris');

                $contact = new Contact();
                $email = $_POST['user_mail'];
                $phone = $_POST['user_number'];

                if ($contact->countMessagesByEmailOrPhone($email, $phone) >= 2) {
                    $_SESSION['formErrors'][] = "Vous avez déjà envoyé plus de deux messages.Merci d'attendre une réponse.";
                    header("Location: index.php?route=contact");
                    exit();
                }

                $contact->insert([
                    'lastname'=> $_POST['user_lastname'],
                    'firstname'=> $_POST['user_firstname'],
                    'phone'=> $_POST['user_number'],
                    'email'=> $_POST['user_mail'],
                    'message'=> $_POST['user_text'],
                    'created_at' => date('Y-m-d H:i:s')
                    ]);
            
                $_SESSION['message'] = "Le message a bien été envoyé";
                
                $_SESSION['contact_form_csrf_token'] = bin2hex(random_bytes(32));
                header("Location: index.php?route=contact");
                exit();

            } else {
                $_SESSION['formErrors'] = $errors;
                header("Location: index.php?route=contact");
                exit();
            }
        }else{
            $_SESSION['error'] = "Erreur lors de l'envoi du message";
            header("Location: index.php?route=contact"); 
            exit();  
        }  
    }
}