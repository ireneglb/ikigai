'use strict';

class VerifContact{

    validateAndSubmitContact(){
        const verifyContactForm = this.verifyContactForm();

        if(verifyContactForm.length === 0){
            document.getElementById('contactForm').submit();
        }else {
            let errorsContact = verifyContactForm;
            let ul = document.createElement('ul');
            errorsContact.forEach(errorContact => {
                let li = document.createElement('li');
                li.innerHTML = errorContact;
                ul.appendChild(li);
            });
            document.getElementById('errorContact').innerHTML = '';
            document.getElementById('errorContact').appendChild(ul);
            document.getElementById('errorContact').style.display = 'block';  
        }
    }

    verifyContactForm(){
        const errors = [];

        const lastName = document.getElementById('msg_lastname').value.trim();
        if (lastName === '') {
            errors.push("Le champ Nom est vide."); 
        } else if (lastName.length < 3) {
            errors.push("Le champ Nom doit contenir au moins 3 caractères.");
        } else if (!/^[a-zA-Z]+$/.test(lastName)) {
            errors.push("Le champ Nom ne doit contenir que des lettres.");
        }

        const firstName = document.getElementById('msg_firstname').value.trim();
        if (firstName === '') {
            errors.push("Le champ Prénom est vide.");
        } else if (firstName.length < 3) {
            errors.push("Le champ Prénom doit contenir au moins 3 caractères.");
        } else if (!/^[a-zA-Z]+$/.test(firstName)) {
            errors.push("Le champ Prénom ne doit contenir que des lettres.");
        }

        const number = document.getElementById('msg_number').value.trim();
        if (number === '') {
            errors.push("Le champ Numéro de téléphone est vide.");
        } else if (number.length < 10 || number.length > 12) {
            errors.push("Le champ Numéro doit contenir entre 10 et 12 chiffres.");
        } else if (!/^\d+$/.test(number)) {
            errors.push("Le champ Numéro ne doit contenir que des chiffres.");
        }  
        
        const email = document.getElementById('msg_email').value.trim();
        if (email === '') {
            errors.push("Le champ Email est vide.");
        }else if (!/^\S+@\S+\.\S+$/.test(email)) {
            errors.push("Le champ Email doit être une adresse email valide.");
        }

        const message = document.getElementById('msg').value.trim();
        if (message === '') {
            errors.push("Le champ message est vide.");
        }
        
        return errors;
    }
}
export default VerifContact;



