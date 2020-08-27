<?php

namespace App;



class Annonce{
    
    if(isset($_POST['ann_unique_id']) && !empty($_POST['ann_unique_id'])){
        $id = $_POST['ann_unique_id'];
    }else{
        echo "Erreur";
        return;
    }

    //Connexion
    $base = new Connexion();

    //SHOW POST
    $req = $base->q(
                    "SELECT
                        pann_titre,
                        p.description,
                        p.picture,
                        p.date_validation,
                        p.user_mail,
                        p.user_name,
                        p.user_firstname,
                        p.user_phone,
                        p.category_id,
                        cat.name as category_name
                    FROM post as p
                    INNER JOIN category cat ON p.category_id = cat.ID
                    WHERE p.id LIKE :id",
        array(array('id',$id,\PDO::PARAM_STR)));

    echo json_encode($req);
}
}






















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