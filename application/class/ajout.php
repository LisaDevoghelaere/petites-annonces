<?php

namespace App;


class Ajout{
    public $data=[];
    public static function Add(){
        
        
            // les valeurs
            
            $ann_titre = $_POST['ann_titre'];
            $cat_libelle  = $_POST['cat_libelle'];
            $ann_description  = $_POST['ann_description'];
            $ann_prix  = $_POST['ann_prix'];
            $usr_nom  = $_POST['usr_nom'];
            $usr_prenom  = $_POST['usr_prenom'];
            $usr_courriel  = $_POST['usr_courriel'];
            $usr_telephone  = $_POST['usr_telephone'];

            // image 
            if(isset($_POST['ann_image_url'])){
                $ann_image_url = $_POST['ann_image_url'];
            }else{
                $ann_image_url = "public/media/annonce/sandman.jpg";
            };

            //Connexion
            $base = new \App\Db();

            // Ajouter un utilisateur
            
            // $req = $base->q('SELECT id FROM utilisateur WHERE usr_courriel = :usr_courriel',
            // array(
            //     array('usr_courriel', $usr_courriel,\PDO::PARAM_STR),
            // ));
            

            // // si l'id est différent de nul alors on insere
            // if($req == NULL ){
                
            //     $base->qw('INSERT INTO utilisateur (usr_nom, usr_prenom, usr_telephone, usr_courriel) VALUES ( :usr_nom, :usr_prenom, :usr_telephone, :usr_courriel)',
            //     array(
            //         array('usr_nom', $usr_nom,\PDO::PARAM_STR),
            //         array('usr_prenom', $usr_prenom,\PDO::PARAM_STR),
            //         array('usr_telephone', $usr_telephone,\PDO::PARAM_STR),
            //         array('usr_courriel', $usr_courriel,\PDO::PARAM_STR),
            //     ));
            // }

            //avoir la id de la categorie
            $req = $base->q("SELECT `cat_id` FROM `categorie` WHERE `cat_libelle` = :cat_libelle",
            array(array('cat_libelle',$cat_libelle,\PDO::PARAM_STR)));
            $categorie_id = $req[0]->cat_id;

            // // définir dernier id
            // $req = $base->q("SELECT MAX(`ann_unique_id`) FROM `annonce`");
            // $ann_unique_id = $req[0]->ann_unique_id;
            // $ann_unique_id += 1;

            $crypto = "gogogogo";
          
            // $ann_date_ecriture = date("Y-m-d");

            // // ADD POST
            // $base->qw('INSERT INTO annonce(`crypto`, `ann_titre`, `categorie_id`, `ann_description`, `ann_prix`, `ann_date_ecriture`, ann_image_url)
            //           VALUES (:crypto, :ann_titre, :cat_id, :ann_description, :ann_prix, :ann_date_ecriture, :ann_image_url)',
            // array(
            //     array('crypto',$crypto,\PDO::PARAM_STR),
            //     array('ann_titre',$ann_titre,\PDO::PARAM_STR),
            //     array('categorie_id',$cat_id,\PDO::PARAM_STR),
            //     array('ann_description',$ann_description,\PDO::PARAM_STR),
            //     array('ann_prix',$ann_prix,\PDO::PARAM_STR),
            //     array('ann_date_ecriture',$ann_date_ecriture,\PDO::PARAM_STR),
            //     array('ann_image_url',$ann_image_url,\PDO::PARAM_STR)
            //     )
            // );




// $cat_id = 5;

            // date_creation
            $ann_date_ecriture = date("Y-m-d");

            // ADD POST
            $base->qw("INSERT INTO annonce(`crypto`, `ann_titre`, `categorie_id`, `ann_description`, `ann_date_ecriture`, `ann_prix`, `ann_image_url` )
                      VALUES (:crypto, :ann_titre, :categorie_id, :ann_description, :ann_date_ecriture, :ann_prix, :ann_image_url )",
            array(
                array('crypto',$crypto,\PDO::PARAM_STR),
                array('ann_titre',$ann_titre,\PDO::PARAM_STR),
                array('categorie_id',$categorie_id,\PDO::PARAM_INT),
                array('ann_description',$ann_description,\PDO::PARAM_STR),
                array('ann_prix',$ann_prix,\PDO::PARAM_STR),
                array('ann_date_ecriture',$ann_date_ecriture,\PDO::PARAM_STR),
                array('ann_image_url',$ann_image_url,\PDO::PARAM_STR)
                )
            );
        }
    
    

    // // Fonction télécharger une photo dans l'annonce
    // public function telecharger_photo(){
    //     // Vérifier si le formulaire a été soumis
    //     if($_SERVER["REQUEST_METHOD"] == "POST"){
    //         // Vérifie si le fichier a été uploadé sans erreur.
    //         if(isset($_FILES["ann_image_url"]) && $_FILES["ann_image_url"]["error"] == 0){
    //             $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
    //             $filename = $_FILES["ann_image_url"]["name"];
    //             $filetype = $_FILES["ann_image_url"]["type"];
    //             $filesize = $_FILES["ann_image_url"]["size"];

    //             // Vérifie l'extension du fichier
    //             $ext = pathinfo($filename, PATHINFO_EXTENSION);
    //             if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");

    //             // Vérifie la taille du fichier - 5Mo maximum
    //             $maxsize = 5 * 1024 * 1024;
    //             if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");

    //             // Vérifie le type MIME du fichier
    //             if(in_array($filetype, $allowed)){
    //                 // Vérifie si le fichier existe avant de le télécharger.
    //                 if(file_exists("media/annonce/" . $_FILES["ann_image_url"]["name"])){
    //                     echo $_FILES["ann_image_url"]["name"] . " existe déjà.";
    //                 } else{
    //                     move_uploaded_file($_FILES["ann_image_url"]["tmp_name"], "media/annonce/" . $_FILES["ann_image_url"]["name"]);
    //                     echo "Votre fichier a été téléchargé avec succès.";
    //                 } 
    //             } else{
    //                 echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer."; 
    //             }
    //         } else{
    //             echo "Error: " . $_FILES["ann_image_url"]["error"];
    //         }
    //     }
    // }


    
}
