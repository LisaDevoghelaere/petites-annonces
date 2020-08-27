<?php

namespace App;

public function Validation(){
    // Nom
    if(isset($_POST['usr_nom']) && !empty($_POST['usr_nom'])){
        if(v::stringVal()->validate($_POST['usr_nom']) == false){
            return 'Nom invalide';
        }
    }else{
        return 'Veuillez entrer votre nom';
    }

    // Prenom
    if(isset($_POST['user_prenom']) && !empty($_POST['user_prenom'])){
        if(v::stringVal()->validate($_POST['user_prenom']) == false){
            return 'Prénom invalide';
        }
    }else{
        return 'Veuillez entrer votre prénom';
    }

    // Titre
    if(isset($_POST['ann_titre']) && !empty($_POST['ann_titre'])){
        if(v::stringVal()->validate($_POST['ann_titre']) == false){
            return 'Titre invalide';
        }
    }else{
        return 'Veuillez entrer un titre';
    }

    // Description
    if(isset($_POST['ann_description']) && !empty($_POST['ann_description'])){
        if(v::stringVal()->validate($_POST['ann_description']) == false){
            return 'Déscription invalide';
        }
    }else{
        return 'Veuillez entrer une description';
    }

    // Adresse mail
    if(isset($_POST['usr_courriel']) && !empty($_POST['usr_courriel'])){
        if(v::email()->validate($_POST['usr_courriel']) == false){
            return 'Adresse mail invalide';
        }
    }else{
        return 'Veuillez entrer une adresse mail';
    }

    // Numéro de téléphone
    if(isset($_POST['user_telephone']) && !empty($_POST['user_telephone'])){
        if(v::stringVal()->validate($_POST['user_telephone']) == false){
            return 'Téléphone invalide';
        }
    }else{
        return 'Veuillez entrer votre numero de téléphone';
    }

    // Catégorie
    if(isset($_POST['categorie']) && !empty($_POST['categorie'])){
        if(v::stringVal()->validate($_POST['categorie']) == false){
            return 'Catégorie invalide';
        }
    }else{
        return 'Veuillez choisir une categorie';
    }
    return "OK";
}