<?php

namespace Controllers;

use Models\Massage;

class HomeController{
    public function displayHomePage(): void{
        $template = "Views/home/home.phtml";
        include_once 'Views/common/layout.phtml';                                     
    }

    public function displayContactPage(): void{  
        $_SESSION['contact_form_csrf_token'] = bin2hex(random_bytes(32));
        $template = "Views/home/contact.phtml";
        include_once 'Views/common/layout.phtml';                                      
    }

    public function displayMassagePage(): void{

        $massage = new Massage();
        $massageUsers = $massage->selectMassages();
        $groupedMassages = [];
        foreach ($massageUsers as $massageUser) {
            $groupedMassages[$massageUser['type']][] = $massageUser;
        }
        $template = "Views/home/massage.phtml";
        include_once 'Views/common/layout.phtml';                                      
    } 

    public function displayHomeReservPage(): void{
        $_SESSION['csrf_token_register'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_login'] = bin2hex(random_bytes(32));

        $template = "Views/auth/index.phtml";
        include_once 'Views/common/layout.phtml';      
    } 

    public function displayTeaPage(): void{
        $template = "Views/home/tea.phtml";
        include_once 'Views/common/layout.phtml';                                     
    } 

};