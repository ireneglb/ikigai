<?php

namespace Controllers;

use Models\Admin;
class MessageController extends VerificationController{

    public function displayClientMessage():void{

        $_SESSION['csrf_token_delete_msg']= bin2hex(random_bytes(32));

        $admin = new Admin();
        $totalMsg = $admin->getTotalMsg();
        $displayMsg = $admin-> displayMsgClient();

        $template = "Views/admin/msgManagement.phtml";
        include_once 'Views/common/layout.phtml';
    }

    public function deleteMsg(){

        $user_id = $_POST['admin_msg_id'];

        $adminModel = new Admin();
        $success = $adminModel->deleteMsg($user_id);

        if ($success) {
            $_SESSION['message'] = "Le message a bien été supprimé";
            header ("Location: index.php?route=admin_message");
            exit;
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression. Veuillez réessayer.";
            header ("Location: index.php?route=admin_message");
            exit;
        }
    }
}