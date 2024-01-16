document.getElementById('deletReserv').addEventListener('submit', function(event) {
    let confirmation = confirm('Voulez-vous vraiment supprimer cette réservation ?');
    if (!confirmation) {
        event.preventDefault();
    }
});