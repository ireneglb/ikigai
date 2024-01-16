"use strict";

class FormVerification{

    validateRegister(){ 
        const FormValid = this.verifyFormRegister();
       
        if(FormValid.length === 0){
            document.getElementById('register_form').submit();
        }else {
            let errorsRegister = FormValid;
            let ul = document.createElement('ul');
            errorsRegister.forEach(errorRegister => {
                let li = document.createElement('li');
                li.innerHTML = errorRegister;
                ul.appendChild(li);
            });
            document.getElementById('errorsRegister').innerHTML = '';
            document.getElementById('errorsRegister').appendChild(ul);  
            document.getElementById('errorsRegister').style.display = 'block';
        }
    } 

    verifyFormRegister() {
        const errors = [];

        const lastName = document.getElementById('register_lastname').value.trim();
        if (lastName === '') {
            errors.push("Le champ Nom est vide."); 
        } else if (lastName.length < 3) {
            errors.push("Le champ Nom doit contenir au moins 3 caractères.");
        } else if (!/^[a-zA-Z]+$/.test(lastName)) {
            errors.push("Le champ Nom ne doit contenir que des lettres.");
        }

        const firstName = document.getElementById('register_firstname').value.trim();
        if (firstName === '') {
            errors.push("Le champ Prénom est vide.");
        } else if (firstName.length < 3) {
            errors.push("Le champ Prénom doit contenir au moins 3 caractères.");
        } else if (!/^[a-zA-Z]+$/.test(firstName)) {
            errors.push("Le champ Prénom ne doit contenir que des lettres.");
        }

        const number = document.getElementById('register_number').value.trim();
        if (number === '') {
            errors.push("Le champ Numéro de téléphone est vide.");
        } else if (number.length < 10 || number.length > 12) {
            errors.push("Le champ Numéro doit contenir entre 10 et 12 chiffres.");
        } else if (!/^\d+$/.test(number)) {
            errors.push("Le champ Numéro ne doit contenir que des chiffres.");
        }  
                                   
        const password = document.getElementById('register_password').value.trim();
        if (password === '') {
            errors.push("Le champ mot de passe est vide.");
        } else if (password.length < 8) {
            errors.push("Le champ mot de passe doit contenir au moins 8 caractères.");
        } else if (!/\d/.test(password)) {
            errors.push("Le champ mot de passe doit contenir au moins un chiffre.");
        } else if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@!?;()&]).{8,}$/.test(password)) {
            errors.push("Le champ mot de passe doit contenir au moins une majuscule et un des caractères spéciaux suivants : &@!?;()");
        }

        const email = document.getElementById('register_mail').value.trim();
        if (email === '') {
            errors.push("Le champ Email est vide.");
        }

        return errors;
    }

    validateLogin(){
        const PasswordAndMailValid= this.verifyLogin();

        if(PasswordAndMailValid.length ===0){
           return true;
        }else {
            let errorLogin = PasswordAndMailValid;
            let ul = document.createElement('ul');
            errorLogin.forEach(errorLogin => {
                let li = document.createElement('li');
                li.innerHTML = errorLogin;
                ul.appendChild(li);
            });
            document.getElementById('errorsLogin').innerHTML = '';
            document.getElementById('errorsLogin').appendChild(ul); 
            document.getElementById('errorsLogin').style.display = 'block'; 
            return false;
        }   
    }

    verifyLogin() {
        const errors = [];
                                            
        const password = document.getElementById('login_password').value.trim();
        if (password === '') {
            errors.push("Le champ mot de passe est vide.");
        } else if (password.length < 8) {
            errors.push("Le champ mot de passe doit contenir au moins 8 caractères.");
        } else if (!/\d/.test(password)) {
            errors.push("Le champ mot de passe doit contenir au moins un chiffre.");
        } else if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@!?;()&]).{8,}$/.test(password)) {
            errors.push("Le champ mot de passe doit contenir au moins une majuscule et un des caractères spéciaux suivants : &@!?;()");
        }

        const email = document.getElementById('login_email').value.trim();
        if (email === '') {
            errors.push("Le champ Email est vide.");
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