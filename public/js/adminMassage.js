"use strict";

document.addEventListener('DOMContentLoaded', function() {
    const showAddMassageButton = document.getElementById("showAddMassage");
    const massageForm = document.getElementById("massageForm");

    const modifyButtons = document.querySelectorAll(".modify-button");
    const massageInfos = document.querySelectorAll(".massage-info");

    modifyButtons.forEach(function(button, index) {
        button.addEventListener("click", function() {
            const card = this.closest(".card");
            const form = card.querySelector(".modify-form");
            const massageId = form.querySelector("input[name='id']").value; 
            
            massageInfos.forEach(function(massageInfo) {
                const infoMassageId = massageInfo.dataset.massageId; 
                
                if (infoMassageId === massageId) {
                    massageInfo.style.display = "none"; 
                } else {
                    massageInfo.style.display = "block"; 
                }
            });

            const deleteForm = card.querySelector(".delete-form"); 
            if (deleteForm) {
                deleteForm.style.display = "none";
            }

            if (button.textContent === "Annuler") {
                button.textContent = "Modifier";
                form.style.display = "none"; 
                const deleteForm = card.querySelector(".delete-form");
                if (deleteForm) {
                    deleteForm.style.display = "block"; 
                }
                massageInfos.forEach(function(massageInfo) {
                    massageInfo.style.display = "block"; 
                });
                button.classList.remove("active"); 
            } else {
                button.textContent = "Annuler";
                form.style.display = "block"; 
                button.classList.add("active");
            }
        });

    });


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