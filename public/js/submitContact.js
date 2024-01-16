"use strict";

import VerifContact from './modules/verifContact.js';

let formVerifContact = new VerifContact(); 

document.addEventListener('DOMContentLoaded', function() {
    
    document.getElementById('btnSubmit').addEventListener('click', function(event){
        event.preventDefault(); 
        formVerifContact.validateAndSubmitContact();
    });
});