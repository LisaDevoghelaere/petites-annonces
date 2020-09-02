<?php

namespace App;
use App\Annonce;

class Ajout{
    public $data=[];
    public static function Add(){
        
        $validation= (new self)->Validation();
        echo 'coucou';
        if($validation ==="OK"){
            
            // les valeurs
            $ann_titre = $_POST['ann_titre'];
            $categorie  = $_POST['categorie'];
            $ann_description  = $_POST['ann_description'];
            $ann_prix  = $_POST['ann_prix'];
            $usr_nom  = $_POST['usr_nom'];
            $usr_prenom  = $_POST['usr_prenom'];
            $usr_courriel  = $_POST['usr_courriel'];
            $usr_telephone  = $_POST['usr_telephone'];

            //Connexion
            $base = new \App\Db();

            //avoir la id de la categorie
            $req = $base->q("SELECT `id` FROM `categorie` WHERE `cat_libelle` = :categorie",
            array(array('categorie',$categorie,\PDO::PARAM_STR)));
            $cat_id = $req[0]->id;

            // définir dernier id
            $req = $base->q("SELECT MAX(id) FROM `annonce`");
            $id = $req[0]->id;
            $id += 1;


            // date_creation
            $ann_date_ecriture = date("Y-m-d");

            //ADD POST
            // $base->q('INSERT INTO annonce(`ann_unique_id`, `ann_titre`, `cat_id`, `ann_description`, `ann_prix`, `usr_nom`, `usr_prenom`, `usr_courriel`, `usr_telephone`, `ann_date_ecriture`, ann_image_url)
            //           VALUES (:ann_unique_id, :ann_titre, :categorie, :ann_description, :ann_prix, :usr_nom, :usr_prenom, :usr_courriel, :usr_telephone, :ann_date_ecriture, :ann_image_url)',
            array(
                array('ann_unique_id',$ann_unique_id,\PDO::PARAM_STR),
                array('ann_titre',$ann_titre,\PDO::PARAM_STR),
                array('cat_id',$cat_id,\PDO::PARAM_STR),
                array('ann_description',$ann_description,\PDO::PARAM_STR),
                array('ann_prix',$ann_prix,\PDO::PARAM_STR),
                array('usr_nom',$usr_nom,\PDO::PARAM_INT),
                array('usr_prenom',$usr_prenom,\PDO::PARAM_STR),
                array('usr_courriel',$usr_courriel,\PDO::PARAM_STR),
                array('usr_telephone',$usr_telephone,\PDO::PARAM_STR),
                array('ann_date_ecriture',$ann_date_ecriture,\PDO::PARAM_STR),
                array('ann_image_url',$ann_image_url,\PDO::PARAM_STR)
                )
            );
        }
    }
    // Fonction validation d'une annonce
    public function Validation(){
        if(isset($_POST['ann_titre']) && !empty($_POST['ann_titre'])){
            if(v::stringVal()->validate($_POST['ann_titre']) == false){
                return 'Titre invalide';
            }
        }else{
            return 'Veuillez entrer un titre';
        }

        if(isset($_POST['ann_description']) && !empty($_POST['ann_description'])){
            if(v::stringVal()->validate($_POST['ann_description']) == false){
                return 'Description invalide';
            }
        }else{
            return 'Veuillez entrer une description';
        }

        if(isset($_POST['usr_courriel']) && !empty($_POST['usr_courriel'])){
            if(v::email()->validate($_POST['user_mail']) == false){
                return 'Adresse mail invalide';
            }
        }else{
            return 'Veuillez entrer une adresse mail';
        }

        if(isset($_POST['usr_nom']) && !empty($_POST['usr_nom'])){
            if(v::stringVal()->validate($_POST['usr_nom']) == false){
                return 'Nom invalide';
            }
        }else{
            return 'Veuillez entrer votre nom';
        }

        if(isset($_POST['usr_prenom']) && !empty($_POST['usr_prenom'])){
            if(v::stringVal()->validate($_POST['usr_prenom']) == false){
                return 'Prénom invalide';
            }
        }else{
            return 'Veuillez entrer votre prénom';
        }

        if(isset($_POST['usr_telephone']) && !empty($_POST['usr_telephone'])){
            if(v::stringVal()->validate($_POST['usr_telephone']) == false){
                return 'Téléphone invalide';
            }
        }else{
            return 'Veuillez entrer votre numero de téléphone';
        }

        if(isset($_POST['categorie']) && !empty($_POST['categorie'])){
            if(v::stringVal()->validate($_POST['categorie']) == false){
                return 'Catégorie invalide';
            }
        }else{
            return 'Veuillez choisir une catégorie';
        }
        return "OK";
    }

    // Fonction télécharger une photo dans l'annonce
    public function telecharger_photo(){
        // Vérifier si le formulaire a été soumis
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // Vérifie si le fichier a été uploadé sans erreur.
            if(isset($_FILES["ann_image_url"]) && $_FILES["ann_image_url"]["error"] == 0){
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                $filename = $_FILES["ann_image_url"]["name"];
                $filetype = $_FILES["ann_image_url"]["type"];
                $filesize = $_FILES["ann_image_url"]["size"];

                // Vérifie l'extension du fichier
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");

                // Vérifie la taille du fichier - 5Mo maximum
                $maxsize = 5 * 1024 * 1024;
                if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");

                // Vérifie le type MIME du fichier
                if(in_array($filetype, $allowed)){
                    // Vérifie si le fichier existe avant de le télécharger.
                    if(file_exists("media/annonce/" . $_FILES["ann_image_url"]["name"])){
                        echo $_FILES["ann_image_url"]["name"] . " existe déjà.";
                    } else{
                        move_uploaded_file($_FILES["ann_image_url"]["tmp_name"], "media/annonce/" . $_FILES["ann_image_url"]["name"]);
                        echo "Votre fichier a été téléchargé avec succès.";
                    } 
                } else{
                    echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer."; 
                }
            } else{
                echo "Error: " . $_FILES["ann_image_url"]["error"];
            }
        }
    }


    
}
