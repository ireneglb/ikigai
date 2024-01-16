<?php

namespace Controllers;

class MessageController{
    public function displayMessagePage(): void{
        $template = "Views/home/message.phtml";
        include_once 'Views/common/layout.phtml';                                     
    }
}