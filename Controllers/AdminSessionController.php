<?php

namespace Controllers;

use Models\Admin;

class AdminSessionController extends VerificationController{
    private $newFileName;
   
    public function displayAdminHomepage(): void{
        $template = "Views/admin/index.phtml";
        include_once 'Views/common/layout.phtml';                                      
    }

    public function displayAdminMassage(): void{
        $_SESSION['csrf_token_massage']= bin2hex(random_bytes(32));

        $admin = new Admin();
        $massages = $admin->getAllMassages();

        $template = "Views/admin/massageManagement.phtml";
        include_once 'Views/common/layout.phtml';
    }

    public function insertMassage(): void{
        if (!empty($_POST['csrf_token_massage']) && $_POST['csrf_token_massage'] === $_SESSION['csrf_token_massage']) {
            unset($_SESSION['csrf_token_massage']);

            $errors = $this->verifyMassage();

            if(empty($errors)) {

                $admin = new Admin();
                date_default_timezone_set('Europe/Paris');
                $data = $admin->insertMassage([
                    'name' => $_POST['massage_name'],
                    'description' => $_POST['massage_info'],
                    'type' => $_POST['massage_type'],
                    'price' => $_POST['massage_price'], 
                    'created_at' => date('Y-m-d H:i:s'),
                    'modified_at' => date('Y-m-d H:i:s')
                ]);
                if($data === true) {
                    $_SESSION['message'] = "Votre Massage a bien été enregistré.";
                    header("location: index.php?route=admin_massage");
                    exit();
                } 
                else {
                    $_SESSION['error'] = "Erreur. Veuillez réessayer ultérieurement";
                    header("location: index.php?route=admin_massage"); 
                    exit();
                }
            }else{
                $_SESSION['formErrors'] = $errors;  
                header ("Location: index.php?route=admin_massage");
                exit();
            }
        }else{
            $_SESSION['error'] = "Erreur lors de l'envoi du formulaire."; 
            header ("Location: index.php?route=admin_massage");
            exit();
        }   
    }

    public function displayAdminTea(): void{
        $_SESSION['csrf_token_product']= bin2hex(random_bytes(32));

        $admin = new Admin();
        $products = $admin->getAllProducts();

        $template = "Views/admin/teaManagement.phtml";
        include_once 'Views/common/layout.phtml';
    }

    public function insertNewProduct(): void{
        unset($_SESSION['formErrors']);
        unset($_SESSION['error']);
    
        if(!empty($_POST['csrf_token_product']) && $_POST['csrf_token_product'] === $_SESSION['csrf_token_product']) {
            unset($_SESSION['csrf_token_product']);
    
            $newFileName = $this->uploadFile();

            if(is_array($newFileName)) {
                $_SESSION['formErrors'] = $newFileName;
                header('Location: index.php?route=admin_tea');
                exit();
            } else {
                if ($_FILES['upload_image']['error'] === 0) {
                    if (!$newFileName) {
                        $errors[] = $_SESSION['error'];
                    } else {

                        $errors = $this->verifFormProduct();
                
                        if (!empty($errors)) {
                            $_SESSION['formErrors'] = $errors;
                            header('Location: index.php?route=admin_tea');
                            exit();
                        }

                        $parameters = [
                            'name' => htmlspecialchars($_POST['product_name']),
                            'description' => htmlspecialchars($_POST['product_info']),
                            'price' => htmlspecialchars($_POST['product_price']),
                            'image' =>  $newFileName,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];
                        $product = new Admin();
                        $product->insertProduct($parameters);

                        $_SESSION['messageSent'] = "Le produit a bien été ajouté.";
                        header('Location: index.php?route=admin_tea');
                    }
                }else{
                    $_SESSION['error'] = "Une erreur est survenue lors de l'envoi du formulaire";
                    header('Location: index.php?route=admin_tea');
                    exit();
                }
            }  
        }else{
            $_SESSION['error'] = "Erreur lors de l'envoi du formulaire."; 
            header ("Location: index.php?route=admin_tea");
            exit();
        }
    }
    
    private function uploadFile():string|array{
        $errors = [];
    
        if ($_FILES['upload_image']['size'] > 2000000) {
            $errors[]  = "Le fichier est trop volumineux.";
            return $errors;
        } else {
            $fileExtension = "";
            $fileParts = explode('.', $_FILES['upload_image']['name']);
    
            if (count($fileParts) > 2) {
                $errors[]  = "Le fichier a plus d'une extension.";
                return $errors;
            } else {
                $fileExtension = strtolower(end($fileParts));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    
                if (!in_array($fileExtension, $allowedExtensions)) {
                    $errors[]  = "Veuillez sélectionner le bon format de fichier.";
                    return $errors;
                } else {
                    $mime_types = [
                        'jpg' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'png' => 'image/png',
                        'gif' => 'image/gif'
                    ];
                    
                    $expectedContent = $mime_types[$fileExtension];
                    $actualContentType = mime_content_type($_FILES['upload_image']['tmp_name']);
                                 
                    if ($expectedContent !== $actualContentType) {
                        $errors[] = "Le fichier n'est pas une image.";
                        return $errors;
                    } else {
                        $this->newFileName = uniqid() . '.' . $fileExtension;
                        $destination = 'public/upload/' . $this->newFileName;
    
                        if (!move_uploaded_file($_FILES['upload_image']['tmp_name'], $destination)) {
                            $errors[]  = "Une erreur est survenue lors de l'envoi du formulaire";
                            return $errors;
                        }else{
                            return $this->newFileName;
                        }
                    } 
                } 
            }
        }
    }
  
    public function displayMassageReservation():void{

        $admin = new Admin();
        $reservations = $admin->getTotalReservations();
        $userMassageDetails = $admin->getUserMassageDetails();

        $template = "Views/admin/displayReservation.phtml";
        include_once 'Views/common/layout.phtml';
    }

    public function displayClientMessage():void{
        $template = "Views/admin/msgManagement.phtml";
        include_once 'Views/common/layout.phtml';
    }

    public function displayUserInformation():void{
        $template = "Views/admin/userManagement.phtml";
        include_once 'Views/common/layout.phtml';
    }
}