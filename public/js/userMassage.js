"use strict";

import Reservation from './modules/reservation.js';

let reservation = new Reservation();

document.addEventListener('DOMContentLoaded', function() {

    reservation.hidePrixSection();

    document.getElementById("types_massage").addEventListener('click', function() {
        reservation.updatePrix();
    });

    document.getElementById("duree_massage").addEventListener('change', function() {
        reservation.updatePrix();
        reservation.showPrixSection();
    });
    
    document.getElementById("offre_speciale").addEventListener('click', function() {
        reservation.updatePrix();
        reservation.showPrixSection();
    });

    document.getElementById("flatpickr").addEventListener('click', function() {
        reservation.updatePrix(); 
        reservation.showPrixSection();
    });
    
    document.getElementById("reservationForm").addEventListener('submit', async function(e) {
        e.preventDefault();
        reservation.verification().then(response => {
            if (response.status ==="error") {
                alert(response.message);
                return false;
            }else{
                alert(response.message);
                e.target.submit();
                return true
            }
        })  
    });
    
});


