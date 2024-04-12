"use strict";

document.addEventListener('DOMContentLoaded', function() {
    const editButton = document.getElementById('editButton');
    const submitButton = document.getElementById('submitButton');

    submitButton.style.display = 'none';
    editButton.addEventListener('click', function() {
        editClicked();
    });


    function editClicked() {
    
        editButton.textContent = "Annuler";
        submitButton.style.display = 'inline-block';
        submitButton.disabled = false;

        editButton.removeEventListener('click', editClicked);
        editButton.addEventListener('click', cancelEdit);
    }

    function cancelEdit() {
      
        editButton.textContent = "Modifier";
        submitButton.style.display = 'none';
        submitButton.disabled = true;

        editButton.removeEventListener('click', cancelEdit);
        editButton.addEventListener('click', editClicked);
    }
});