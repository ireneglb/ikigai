<?php

namespace Controllers;

use Models\Admin;

class TeaController extends VerificationController{

    public function displayAdminTea(): void{
        $_SESSION['csrf_token_product']= bin2hex(random_bytes(32));
        $_SESSION['csrf_token_image']= bin2hex(random_bytes(32));

        $admin = new Admin();
        $productsByType = [];
        $categories = [7, 8, 9, 10, 11, 12, 13];
        foreach ($categories as $category) {
            $productsByType[$category] = $admin->getProductByCategory($category);
        }

        $images = $admin->getAllImages();
        $template = "Views/admin/teaManagement.phtml";
        include_once 'Views/common/layout.phtml';
    }

    public function insertNewProduct(): void{
        unset($_SESSION['formErrors']);
        unset($_SESSION['error']);
    
        if(!empty($_POST['csrf_token_product']) && $_POST['csrf_token_product'] === $_SESSION['csrf_token_product']) {
            unset($_SESSION['csrf_token_product']);
    
            // Validation du formulaire de produit
            $errors = $this->verifFormProduct();
    
            if (!empty($errors)) {
                $_SESSION['formErrors'] = $errors;
                header('Location: index.php?route=admin_tea');
                exit();
            }
            $product_type = $_POST['product_type'];
            
            $parameters = [
                'name' => htmlspecialchars($_POST['product_name']),
                'type_id' => $product_type,
                'description' => htmlspecialchars($_POST['product_info']),
                'price' => htmlspecialchars($_POST['product_price']),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $product = new Admin();
            $product->insertProduct($parameters);
    
            $_SESSION['messageSent'] = "Le produit a bien été ajouté.";
            header('Location: index.php?route=admin_tea');
            exit();
        } else {
            $_SESSION['error'] = "Erreur lors de l'envoi du formulaire."; 
            header ("Location: index.php?route=admin_tea");
            exit();
        }
    }
    
    public function insertImage(){
        unset($_SESSION['formErrors']);
        unset($_SESSION['error']);

        $type_id = $_POST['image_type'];
        $imageModel = new Admin();
        $imageExist = $imageModel->checkImageExist($type_id);
      
        if ($imageExist) {
            $_SESSION['formErrors'][] = "Il existe déjà une image pour cette catégorie.";
            header('Location: index.php?route=admin_tea');
            exit();
        }

        $destination = $this->uploadFile();

        if(is_array($destination)) {
            $_SESSION['formErrors'] = $destination;
            header('Location: index.php?route=admin_tea');
            exit();
        } else {
            if ($destination) {

                $_SESSION['uploaded_image_name'] = $destination;
                $type_id = $_POST['image_type']; 

                $parameters = [
                    'image_name' => basename($destination),
                    'type_id'=> $type_id,
                    'file_path' => $destination,//'public/upload/', => chemin de l'image en BDD 
                ];
                $image = new Admin();
                $image->insertImage($parameters);

                $_SESSION['messageSent'] = "L'image a bien été ajoutée.";
            } else {
                $errors[] = "Une erreur est survenue lors de l'envoi du formulaire";
                $_SESSION['formErrors'] = $errors;
            }
            
            header('Location: index.php?route=admin_tea');
            exit();
        }
    }
    
    private function uploadFile():string|array{
        $errors = [];
    
        if (isset($_FILES['upload_image']['tmp_name']) && !empty($_FILES['upload_image']['tmp_name'])) {
            if ($_FILES['upload_image']['size'] > 3000000) {
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
                            $newFileName = uniqid() . '.' . $fileExtension;
                            $destination = 'public/upload/' . $newFileName;

                            if (!move_uploaded_file($_FILES['upload_image']['tmp_name'], $destination)) {
                                $errors[]  = "Une erreur est survenue lors de l'envoi du formulaire";
                                return $errors;
                            }else{
                                return $destination;
                            }
                        } 
                    } 
                }
            }
        } else {
            $errors[] = "Aucun fichier n'a été téléchargé.";
            return $errors;
        }
    }
}