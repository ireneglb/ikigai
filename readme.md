# Nom du Projet
Ikigai - Salon de thé et de massage

## Description

Le projet Ikigai est un site web destinée à faire connaitre un salon de thé sur Bordeaux qui propose aussi des massages.
Respect du W3C, mobileFirst et responsive, accessibilité (RGAA)

Il dispose de 5 pages : 
- page Accueil : présensation du lieu et de l'équipe
- page Salon de thé : carte des en-cas et boissons proposés
- page Massage : description des différents massage proposés
- page Reservation : authentification pour réserver un massage
- page de Contact : adresse, horaire et un formulaire de contact

Le système de reservation est accessible seulement aux utilisteurs connectés.
Une fois enregistré, les utilisateurs peuvent ainsi réserver un massage via leur espace client.

## Statut du Projet

Le développement de ce projet est actuellement en cours. Nous travaillons activement sur l'implémentation des fonctionnalités restantes et l'amélioration générale. 

Le site peut actuellement permettre aux utilisateurs connectés de :
- consulter les rendez-vous à venir et/ou de les supprimer 
- réserver un massage
- modifier leur indormations ou de supprimer leur compte. 

Les utilisateurs non connectés peuvent accéder aux 5 pages. 
Il ne peuvent pas réserver de massages mais ils peuvent envoyer un message via un formulaire dans la page Contact.

La partie administration est en cours de développement, mais elle est déjà fonctionnelle pour:
- l'ajout, la suppression et la modification de nouveaux massages 
- l'ajout de nouveaux produits ou images pour la page de salon de thé
- l'affichage et la suppression des massages réservés
- l'affichage et la suppression des utilisateurs
- l'affichage et la suppression des messages 

Autres informations: 
-Sécurité lors de l'inscription: impossible si mail déjà existant.
-On passe par la le formulaire d'identification pour la reservation pour accéder au statue d'administrateur. 

## Evolution du Projet 

Le projet prévoit des évolutions, notamment :
- Le nombre de rendez-vous de massage par utilisateur sera limité à deux maximum. 
- La réinitialisation du mot de passe via email.
- La vérification d'email avec PHP.
- FAQ dans la page Contact
- partie administrateur : 
    possibilité de modifier et/ou supprimer les produits et images
    possibilité de mofifier les informations des utilisateurs
- Le système de reservation actuel est provisoire : possibilité de passer par un service tiers.

## Technologies Utilisées et Contrainte

- utilisation de FullCalendar (en View seulement car bootstrap non désiré)
- utilisation de flatpickr pour la prise de rendez-vous.
- POO et MVC
- VanillaPHP, VanillaJS et SCSS

## Ameliorations : 

- la création d'un fichier robots.txt à la racine pour contrôler l'indexation du site par les robots.
- Une page d'erreur est également prévue.

## Identifiant :
