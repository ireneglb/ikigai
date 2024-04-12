<?php

namespace Controllers;

use Models\Massage;
use Models\Images;
use Models\Admin;

class PageController{
    public function displayHomePage(): void{
        $template = "Views/pages/home.phtml";
        include_once 'Views/common/layout.phtml';                                     
    }

    public function displayContactPage(): void{  
        $_SESSION['contact_form_csrf_token'] = bin2hex(random_bytes(32));
        $template = "Views/pages/contact.phtml";
        include_once 'Views/common/layout.phtml';                                      
    }

    public function displayMassagePage(): void{

        $massage = new Massage();
        $massageUsers = $massage->selectMassages();
        $groupedMassages = [];
        foreach ($massageUsers as $massageUser) {
            $groupedMassages[$massageUser['type']][] = $massageUser;
        }
        $template = "Views/pages/massage.phtml";
        include_once 'Views/common/layout.phtml';                                      
    } 

    public function displayHomeReservPage(): void{
        $_SESSION['csrf_token_register'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_login'] = bin2hex(random_bytes(32));

        $template = "Views/auth/index.phtml";
        include_once 'Views/common/layout.phtml';      
    } 

    public function displayTeaPage(): void{

        $image = new Images();
        $imageCafes = $image->getImageByCategory(7); // Cafés
        $imageThes = $image->getImageByCategory(8); // Thés & Infusions
        $imageChocolat = $image->getImageByCategory(9); // Chocolats Chauds
        $imageRaffraichis = $image->getImageByCategory(10); // Rafraichissements
        $imageSales = $image->getImageByCategory(11); // Gourmandises salées
        $imageDamas = $image->getImageByCategory(12); // Délices de Damas
        $imageSucres = $image->getImageByCategory(13); // Douceurs Sucrées

        $admin = new Admin();
        $productsByType = [];
        $categories = [7, 8, 9, 10, 11, 12, 13];
        foreach ($categories as $category) {
            $productsByType[$category] = $admin->getProductByCategory($category);
        }

        $template = "Views/pages/tea.phtml";
        include_once 'Views/common/layout.phtml';                                     
    } 
};