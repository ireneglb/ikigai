"use strict";

class FormVerification{

    validateRegister() { 
        const errors = this.verifyFormRegister();

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
            document.getElementById('register_form').submit();
        }
    }

    verifyFormRegister() {
        const errors = [];
    
        const lastName = document.getElementById('register_lastname').value.trim();
        if (lastName === '') {
            errors.push({ inputId: 'LastName', message: "Veuillez saisir votre nom." }); 
        } else if (lastName.length < 3) {
            errors.push({ inputId: 'LastName', message: "Votre nom doit comporter au moins 3 caractères" });
        } else if (!/^[a-zA-Z]+$/.test(lastName)) {
            errors.push({ inputId: 'LastName', message: "Votre nom ne doit contenir que des lettres." });
        }
    
        const firstName = document.getElementById('register_firstname').value.trim();
        if (firstName === '') {
            errors.push({ inputId: 'FirstName', message: "Veuillez saisir votre prénom." });
        } else if (firstName.length < 3) {
            errors.push({ inputId: 'FirstName', message: "Votre prénom doit comporter au moins 3 caractères." });
        } else if (!/^[a-zA-Z]+$/.test(firstName)) {
            errors.push({ inputId: 'FirstName', message: "Votre prénm ne doit contenir que des lettres." });
        }
    
        const number = document.getElementById('register_number').value.trim();
        if (number === '') {
            errors.push({ inputId: 'Number', message: "Veuillez saisir votre numéro de téléphone." });
        } else if (number.length < 10 || number.length > 12) {
            errors.push({ inputId: 'Number', message: "Votre numéro de téléphone doit comporter entre 10 et 12 chiffres." });
        } else if (!/^\d+$/.test(number)) {
            errors.push({ inputId: 'Number', message: "Votre Numéro ne doit contenir que des chiffres." });
        }  
    
        const password = document.getElementById('register_password').value.trim();
        if (password === '') {
            errors.push({ inputId: 'Password', message: "Veuillez entrer un mot de passe." });
        } else if (password.length < 8) {
            errors.push({ inputId: 'Password', message: "Le mot de passe doit contenir au moins 8 caractères." });
        } else if (!/\d/.test(password)) {
            errors.push({ inputId: 'Password', message: "Le mot de passe doit contenir au moins un chiffre." });
        } else if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@!?;()&]).{8,}$/.test(password)) {
            errors.push({ inputId: 'Password', message: "Le mot de passe doit contenir au moins une majuscule et un des caractères spéciaux suivants : &@!?;()" });
        }
    
        const email = document.getElementById('register_mail').value.trim();
        if (email === '') {
            errors.push({ inputId: 'Mail', message: "Veuillez saisir une adresse e-mail." });
        }
    
        return errors;
    }


    validateLogin() { 
        const errors= this.verifyLogin();
    
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

            document.getElementById('login_form').submit();
        }
    }

    verifyLogin() {
        const errors = [];
                                            
        const password = document.getElementById('login_password').value.trim();
        if (password === '') {
            errors.push({ inputId: 'PasswordLog', message: "Veuillez entrer votre mot de passe."});
        } else if (password.length < 8) {
            errors.push({ inputId: 'PasswordLog', message: "Le mot de passe doit contenir au moins 8 caractères."});
        } else if (!/\d/.test(password)) {
            errors.push({ inputId: 'PasswordLog', message: "Le mot de passe doit contenir au moins un chiffre."});
        } else if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@!?;()&]).{8,}$/.test(password)) {
            errors.push({ inputId: 'PasswordLog', message:"Le mot de passe doit contenir au moins une majuscule et un des caractères spéciaux suivants  &@!?;()"});
        }

        const email = document.getElementById('login_email').value.trim();
        if (email === '') {
            errors.push({ inputId: 'MailLog', message: "Le champ Email est vide."});
        }

        return errors;
    }


    showPasswordRegisterTemporarily() {
        let passwordInput = document.getElementById('register_password');
        let svgElement = document.getElementById('eye');
        let originalSvg = svgElement.innerHTML;
    
        let newSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
    
        passwordInput.type = 'text';
        svgElement.innerHTML = newSvg;
    
        setTimeout(() => {
            passwordInput.type = 'password';
            svgElement.innerHTML = originalSvg;
        }, 2000);
    }

    showPasswordLoginTemporarily() {
        let passwordInput = document.getElementById('login_password');
        let svgElement = document.getElementById('eyeBis');
        let originalSvg = svgElement.innerHTML;
        
        let newSvgbis = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
    
        passwordInput.type = 'text';
        svgElement.innerHTML = newSvgbis;
    
        setTimeout(() => {
            passwordInput.type = 'password';
            svgElement.innerHTML = originalSvg;
        }, 2000);
    }

}

export default FormVerification ;