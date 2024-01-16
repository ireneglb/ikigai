"use strict";

document.addEventListener('DOMContentLoaded', function() {
    const showAddMassageButton = document.getElementById("showAddMassage");
    const massageForm = document.getElementById("massageForm");

    showAddMassageButton.addEventListener("click", function(event) {
        event.preventDefault();

        if (massageForm.style.display === "none" || massageForm.style.display === "") {
            massageForm.style.display = "block";
            showAddMassageButton.textContent = "Annuler";
        } else {
            massageForm.style.display = "none";
            showAddMassageButton.textContent = "Ajouter un massage";
        }
    }); 
});