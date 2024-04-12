"use strict";

import FormVerification from './modules/formVerification.js';

let formVerif = new FormVerification();  

document.addEventListener('DOMContentLoaded', function() {
    
    document.getElementById("register_form").addEventListener('submit', function(e){
        e.preventDefault();
        return formVerif.validateRegister();
    });

    document.getElementById("login_form").addEventListener('submit', function(e){  
        e.preventDefault();
        return formVerif.validateLogin();
    });

    document.getElementById("btnShowPasswordRegister").addEventListener('click', function() {
        formVerif.showPasswordRegisterTemporarily();
        return false;
    });

    document.getElementById("btnShowPasswordLogin").addEventListener('click', function(){
        formVerif.showPasswordLoginTemporarily();
        return false;
    });


  
}); 