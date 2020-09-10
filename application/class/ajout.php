<?php

namespace App;
use App\Mail;
use Respect\Validation\Validator as v;

class Ajout{
    public $data=[];
    public static function add(){

            $validation= (new self)->Validation();
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
                $ann_image_url = "public/media/logo/back-popy.png";
            };

            //Connexion
            $base = new \App\Db();

            // Ajouter un utilisateur
            $req = $base->q('SELECT id FROM utilisateur WHERE usr_courriel = :usr_courriel',
            array(
                array('usr_courriel', $usr_courriel,\PDO::PARAM_STR),
            ));
            
            if(!empty($req)){
                $utilisateur_id = $req;
                $utilisateur_id = intval($utilisateur_id[0]->id);  
            }

            // si l'id est null alors on insere
            else{
                
                $base->qw('INSERT INTO utilisateur (usr_nom, usr_prenom, usr_telephone, usr_courriel) VALUES (:usr_nom, :usr_prenom, :usr_telephone, :usr_courriel)',
                array(
                    array('usr_nom', $usr_nom,\PDO::PARAM_STR),
                    array('usr_prenom', $usr_prenom,\PDO::PARAM_STR),
                    array('usr_telephone', $usr_telephone,\PDO::PARAM_STR),
                    array('usr_courriel', $usr_courriel,\PDO::PARAM_STR),
                    
                ));
                $utilisateur_id = $base->q('SELECT max(id) as `id` FROM utilisateur');
                $utilisateur_id = intval($utilisateur_id[0]->id);
            }

            //avoir la id de la categorie
            $req = $base->q("SELECT `cat_id` FROM `categorie` WHERE `cat_libelle` = :cat_libelle",
            array(array('cat_libelle',$cat_libelle,\PDO::PARAM_STR)));
            $categorie_id = $req[0]->cat_id;
            $categorie_id = intval($categorie_id);
            
            // // définir dernier id
            // $req = $base->q("SELECT MAX(`ann_unique_id`) FROM `annonce`");
            // $ann_unique_id = $req[0]->ann_unique_id;
            // $ann_unique_id += 1;

            //set unique id
            $crypto = \App\Crypt::encrypt_decrypt("encrypt", $usr_courriel. strval($utilisateur_id));
            
            
            // date_creation
            $ann_date_ecriture = date("Y-m-d");

            // ADD POST
            $base->qw("INSERT INTO annonce(`utilisateur_id`, `crypto`, `ann_titre`, `categorie_id`, `ann_description`, `ann_date_ecriture`, `ann_prix`, `ann_image_url` )
                      VALUES (:utilisateur_id, :crypto, :ann_titre, :categorie_id, :ann_description, :ann_date_ecriture, :ann_prix, :ann_image_url )",
            array(
                array('utilisateur_id',$utilisateur_id,\PDO::PARAM_INT),
                array('crypto',$crypto,\PDO::PARAM_STR),
                array('ann_titre',$ann_titre,\PDO::PARAM_STR),
                array('categorie_id',$categorie_id,\PDO::PARAM_INT),
                array('ann_description',$ann_description,\PDO::PARAM_STR),
                array('ann_prix',$ann_prix,\PDO::PARAM_INT),
                array('ann_date_ecriture',$ann_date_ecriture,\PDO::PARAM_STR),
                array('ann_image_url',$ann_image_url,\PDO::PARAM_STR)
                )
            );
            // Envoi de mail pour validation de l'annonce après ajout
            $sendMail = new Mail('valid', $usr_courriel, $usr_nom, $usr_prenom, $crypto);
            echo json_encode($validation);
        }


        public static function Update(){

            $validation= (new self)->Validation();
    
    
            if($validation ==="OK"){
    
                //image
                if(isset($_POST['ann_image_url']) && !empty($_POST['ann_image_url'])){
                    $ann_image_url = $_POST['ann_image_url'];
                }else{
                    $ann_image_url = "public/media/logo/back-popy.png";
                }
                if(isset($_POST['ann_unique_id']) && !empty($_POST['ann_unique_id'])){
                    $ann_unique_id = $_POST['ann_unique_id'];
                }else{
                    echo json_encode("Cette annonce n'existe pas");
                    return;
                }
                //valeurs
                $ann_titre = $_POST['ann_titre'];
                $ann_description = $_POST['ann_description'];
                $usr_courriel  = $_POST['usr_courriel'];
                $usr_nom  = $_POST['usr_nom'];
                $usr_prenom  = $_POST['usr_prenom'];
                $categorie  = $_POST['categorie'];
    
    
                //Connexion
                $base = new \App\Db();
    
                 //avoir la id de la categorie
                $req = $base->q("SELECT `cat_id` FROM `categorie` WHERE `cat_libelle` = :cat_libelle",
                array(array('cat_libelle',$cat_libelle,\PDO::PARAM_STR)));
                $categorie_id = $req[0]->cat_id;
                $categorie_id = intval($categorie_id);

                //set date_validation
                $ann_date_validation=date("Y-m-d");
                $ann_est_valide = 1;
    
                //UPDATE ANNONCE
                $base->qw('UPDATE annonce SET `ann_titre` = :ann_titre, `ann_description` = :ann_description, `categorie_id` = :categorie_id, `ann_est_valide` = :ann_est_valide, `ann_date_validation` = :ann_date_validation, `ann_image_url` = :ann_image_url
                          WHERE `ann_unique_id` = :ann_unique_id',
                array(
                    array('ann_unique_id',$ann_unique_id,\PDO::PARAM_INT),
                    array('ann_titre',$ann_titre,\PDO::PARAM_STR),
                    array('ann_description',$ann_description,\PDO::PARAM_STR),
                    array('categorie_id',$categorie_id,\PDO::PARAM_INT),
                    array('ann_est_valide',$ann_est_valide,\PDO::PARAM_INT),
                    array('ann_date_validation',$ann_date_validation,\PDO::PARAM_STR),
                    array('ann_image_url',$ann_image_url,\PDO::PARAM_STR)
                    )
                );
            }
            $sendMail = new Mail('delete', $usr_courriel, $usr_nom, $usr_prenom, $ann_unique_id);
           
            echo json_encode($validation);
        }
    
        // public static function Supprimer(){
    
        //     if(isset($_POST['ann_unique_id']) && !empty($_POST['ann_unique_id'])){
        //         $ann_unique_id = $_POST['ann_unique_id'];
        //     }else{
        //         echo json_encode("Cette annonce n'existe pas");
        //         return;
        //     }
    
        //     //Connexion
        //     $base = new \App\Db();
    
        //     //DELETE POST
        //     $base->qw('DELETE FROM annonce WHERE ann_unique_id = :ann_unique_id',
        //         array(array('ann_unique_id',$ann_unique_id,\PDO::PARAM_INT)));
    
        //     echo json_encode('OK ');
        // }
        public static function Supprimer($crypto){

            //Connexion
            $base = new \App\Db();
            
            //supprimer l'annonce
            $base->qw('DELETE FROM annonce WHERE crypto = :crypto',
            array(array('crypto',$crypto,\PDO::PARAM_STR)));
            
            echo json_encode('OK ');
            }


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
                    return 'Déscription invalide';
                }
            }else{
                return 'Veuillez entrer une description';
            }
    
            if(isset($_POST['usr_courriel']) && !empty($_POST['usr_courriel'])){
                if(v::email()->validate($_POST['usr_courriel']) == false){
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
                return 'Veuillez choisir une categorie';
            }
            return "OK";
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
