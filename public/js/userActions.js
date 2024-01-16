"use strict";

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("btnDelete").addEventListener('click', function(event) {
        event.preventDefault;
        confirmDelete();  
    });
    
    document.getElementById('editButton').addEventListener('click', function() {
        Array.from(document.getElementById('modifyForm').elements).forEach(function(element) {
            element.readOnly = false;
        });
        document.getElementById('submitButton').disabled = false;
    });
});

function confirmDelete(){
    let confirmation = confirm("Êtes-vous sûr de vouloir supprimer votre compte ?");
    if (confirmation) {
        window.location.href = 'index.php?route=user_delete';
    }
}