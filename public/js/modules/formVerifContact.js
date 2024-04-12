'use strict';

class VerifContact{

    validateAndSubmitContact(){
        const errors = this.verifyContactForm();

        document.querySelectorAll('.error').forEach(element => {
            element.textContent = ''; 
            element.classList.add('hidden'); 
        });

        errors.forEach(error => {
            const inputId = error.inputId;
            const errorMessage = error.message;
            const errorDiv = document.getElementById('error' + inputId.charAt(0).toUpperCase() + inputId.slice(1));
            errorDiv.textContent = errorMessage;
            errorDiv.classList.remove('hidden'); 
        });

        const hasErrors = errors.length > 0;
        if (!hasErrors) {
            document.getElementById('contactForm').submit();
        }
    }

    verifyContactForm(){
        const errors = [];

        const lastName = document.getElementById('msg_lastname').value.trim();
        if (lastName === '') {
            errors.push({ inputId: 'LastNameContact', message:"Veuillez saisir votre nom."}); 
        } else if (lastName.length < 3) {
            errors.push({ inputId: 'LastNameContact', message:"Votre nom doit comporter au moins 3 caractères."});
        } else if (!/^[a-zA-Z]+$/.test(lastName)) {
            errors.push({ inputId: 'LastNameContact', message:"Votre nom ne doit contenir que des lettres."});
        }

        const firstName = document.getElementById('msg_firstname').value.trim();
        if (firstName === '') {
            errors.push({ inputId: 'FirstNameContact', message:"Veuillez saisir votre prénom."});
        } else if (firstName.length < 3) {
            errors.push({ inputId: 'FirstNameContact', message:"Votre prénom doit comporter au moins 3 caractères."});
        } else if (!/^[a-zA-Z]+$/.test(firstName)) {
            errors.push({ inputId: 'FirstNameContact', message:"Votre prénom ne doit contenir que des lettres."});
        }

        const number = document.getElementById('msg_number').value.trim();
        if (number === '') {
            errors.push({ inputId: 'NumberContact', message:"Veuillez saisir votre numéro de téléphone."});
        } else if (number.length < 10 || number.length > 12) {
            errors.push({ inputId: 'NumberContact', message:"Votre numéro de téléphone doit comporter entre 10 et 12 chiffres."});
        } else if (!/^\d+$/.test(number)) {
            errors.push({ inputId: 'NumberContact', message:"Votre Numéro ne doit contenir que des chiffres."});
        }  
        
        const email = document.getElementById('msg_email').value.trim();
        if (email === '') {
            errors.push({ inputId: 'MailContact', message:"Veuillez saisir une adresse e-mail."});
        }else if (!/^\S+@\S+\.\S+$/.test(email)) {
            errors.push({ inputId: 'MailContact', message:"Veuillez saisir une adresse email valide."});
        }

        const message = document.getElementById('msg').value.trim();
        if (message === '') {
            errors.push({ inputId: 'MsgContact', message:"Merci de saisir un message."});
        }else if(message.length < 12){
            errors.push({ inputId: 'MsgContact', message:"Votre message doit comporter au moins 12 caractères"})
        }

        return errors;
    }
}
export default VerifContact;



