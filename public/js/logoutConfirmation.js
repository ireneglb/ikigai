"use strict";

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("btnLogout").addEventListener('click', function(event) {
        event.preventDefault;
        confirmLogout(); 
    });
});

function confirmLogout(){
    let confirmation = confirm("Êtes-vous sûr de vouloir vous déconnecter ?");
    if (confirmation) {
        window.location.href = 'index.php?route=logout';
    }
}