"use strict";

import VerifContact from './modules/formVerifContact.js';

let formVerifContact = new VerifContact(); 

document.addEventListener('DOMContentLoaded', function() {
    
    document.getElementById('btnSubmit').addEventListener('click', function(event){
        event.preventDefault(); 
        formVerifContact.validateAndSubmitContact();
    });
});