"use strict";

class Reservation {

  constructor() {
    // Récupère les dates réservées dès la création de l'objet
    this.fetchReservedDates();
    // Initialise le sélecteur de date et d'heure
    this.initFlatpickr();
  }
  // Récupère les dates réservées depuis le serveur
  fetchReservedDates() {
    fetch('index.php?route=fetchReservedDates')
        .then(response => response.json())
        .then(data => {
            this.plagesHorairesPrises = data.map(reservation => {
                const datetime_start = new Date(reservation.datetime_start.replace(' ', 'T'));
                if (isNaN(datetime_start)) {
                    throw new Error(`Invalid date: ${reservation.datetime_start}`);
                }
                // Convertit la durée en millisecondes
                const durationParts = reservation.duration.split(':');
                const duration = durationParts[0] * 60 * 60 * 1000 + durationParts[1] * 60 * 1000;
                return {
                    title: 'Réservée',
                    start: datetime_start.toISOString(),
                    end: new Date(datetime_start.getTime() + duration).toISOString()
                };
            });
            // Initialise le calendrier avec les événements récupérés
            this.initCalendar();
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des dates réservées:', error);
        });
  }

  initCalendar() {
    let calendarEl = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, { 
      locale: 'fr',
      initialView: 'dayGridDay',
      firstDay: 3,
      headerToolbar:{
          left : 'prev,next today',
          center : 'title',
          right : 'dayGridMonth,timeGridWeek,dayGridDay' 
      },
      events: this.plagesHorairesPrises,
      eventDidMount: function (info) {
        info.el.style.backgroundColor = 'red';
      },
      eventTimeFormat: { 
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
      },
      slotLabelFormat: { 
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
      },
      slotMinTime: '11:00:00', 
      slotMaxTime: '22:00:00',
      hiddenDays: [1, 2]  
    });
    calendar.render();
  }

  initFlatpickr() { 
    flatpickr("#flatpickr", {  
        enableTime: true,
        inline:true,
        minDate: "today",
        minTime: "11:00", 
        maxTime: "19:30",
        defaultHour: 11,
        time_24hr: true,
        minuteIncrement: 30,
        disable: [
            function(date) {
                return (date.getDay() === 1 || date.getDay() === 2);
            }
        ],
        locale: flatpickr.l10ns.fr,
    });
  }

  updatePrix() {
    let dureeMassage = document.getElementById('duree_massage').value;
    let dureeParts = dureeMassage.split(':');
    let dureeEnMinutes = parseInt(dureeParts[0]) * 60 + parseInt(dureeParts[1]);
    
    let offreSpeciale = document.getElementById('offre_speciale').value === "1";
    let tarif;

    let tarifMassageSeul30min = 35;
    let tarifMassageSeul60min = 70; 
    let tarifMassageSeul90min = 95; 

    let tarifOffreSpeciale30min = 45;
    let tarifOffreSpeciale60min = 80;
    let tarifOffreSpeciale90min = 105;
    
    switch (dureeEnMinutes) { 
      case 30:
        tarif = offreSpeciale ? tarifOffreSpeciale30min : tarifMassageSeul30min;
        break;
      case 60:
        tarif = offreSpeciale ? tarifOffreSpeciale60min : tarifMassageSeul60min;
        break;
      case 90:
        tarif = offreSpeciale ? tarifOffreSpeciale90min : tarifMassageSeul90min;
        break;
      default:
        tarif = "Erreur";
    }

    if (tarif === "Erreur") {
      document.getElementById('prix').innerText = "Calcul du prix en cours...";
    } else {
      document.getElementById('prix').innerText = "Prix : " + tarif + " €";
    }
    document.getElementById('tarif').value = tarif; 
    document.getElementById('duree_tarif').value = dureeMassage; 
  }

  hidePrixSection() {
    let prixSection = document.getElementById('prixSection');
    prixSection.classList.add('hidden');
  }

  showPrixSection() {
    const prixSection = document.getElementById('prixSection');
    prixSection.classList.remove('hidden');
  }
 // Vérifie la disponibilité de la réservation
  async verification() {
    const formData =  new FormData();
    formData.append('datetime_start', document.getElementById("flatpickr").value);
    formData.append('duration', document.getElementById("duree_massage").value);

    return await fetch('index.php?route=verifReservation',{
      method:'POST',
      body : formData
    }).then (response => response.json())
    .catch(error => {
      console.error('Erreur lors de la vérification de la réservation:', error);
    });
  }
}
export default Reservation;