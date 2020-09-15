<?php

namespace App;
use App\Mail;
use Respect\Validation\Validator as v;

class Ajout{
    public $data=[];
    public static function add(){


            // $validation= (new self)->Validation();
            $path = './media/annonce/';

            //charger l'image
            if($_FILES['file']['name']!==''){
                $info = new \SplFileInfo($_FILES['file']['name']);
                $extension = $info->getExtension();
                $code=bin2hex(openssl_random_pseudo_bytes(16));
                $upload = (new self)->ChargerImage($code,$extension);
                if($upload == !false){
                    $ann_image_url = $path.basename($code.'.'.$extension);
                }else{
                    echo json_encode("Echec lors de l'envoi du fichier");
                    return;
                }
            }else{
                $ann_image_url ='./media/logo/back-popy.png';
            }


            // les valeurs
            $ann_titre = $_POST['ann_titre'];
            $cat_libelle  = $_POST['cat_libelle'];
            $ann_description  = $_POST['ann_description'];
            $ann_prix  = $_POST['ann_prix'];
            $usr_nom  = $_POST['usr_nom'];
            $usr_prenom  = $_POST['usr_prenom'];
            $usr_courriel  = $_POST['usr_courriel'];
            $usr_telephone  = $_POST['usr_telephone'];
           

            // // image 
            // if(isset($_POST['ann_image_url'])){
            //     $ann_image_url = $_POST['ann_image_url'];
            // }else{
            //     $ann_image_url = "public/media/logo/back-popy.png";
            // };

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
            echo json_encode("ok");
        }


        public static function Update(){

            // $validation= (new self)->Validation();
    
            $path = './media/annonce/';

            //charger l'image
            if($_FILES['file']['name']!==''){
                $info = new \SplFileInfo($_FILES['file']['name']);
                $extension = $info->getExtension();
                $code=bin2hex(openssl_random_pseudo_bytes(16));
                $upload = (new self)->ChargerImage($code,$extension);
                if($upload == !false){
                    $ann_image_url = $path.basename($code.'.'.$extension);
                }else{
                    echo json_encode("Echec lors de l'envoi du fichier");
                    return;
                }
            }else{
                // $ann_image_url ='./media/logo/back-popy.png';
                if(isset($_POST['ann_image_url']) && !empty($_POST['ann_image_url'])){
                    $ann_image_url = $_POST['ann_image_url'];
                }else{
                    $ann_image_url = "./media/logo/back-popy.png";
                }
            }




            // if($validation ==="OK"){
    
                //image
                // if(isset($_POST['ann_image_url']) && !empty($_POST['ann_image_url'])){
                //     $ann_image_url = $_POST['ann_image_url'];
                // }else{
                //     $ann_image_url = "public/media/logo/back-popy.png";
                // }


                if(isset($_POST['crypto']) && !empty($_POST['crypto'])){
                    $crypto = $_POST['crypto'];
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
                $cat_libelle = $_POST['cat_libelle'];
    
    
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
                          WHERE `crypto` = :crypto',
                array(
                    array('crypto',$crypto,\PDO::PARAM_STR),
                    array('ann_titre',$ann_titre,\PDO::PARAM_STR),
                    array('ann_description',$ann_description,\PDO::PARAM_STR),
                    array('categorie_id',$categorie_id,\PDO::PARAM_INT),
                    array('ann_est_valide',$ann_est_valide,\PDO::PARAM_INT),
                    array('ann_date_validation',$ann_date_validation,\PDO::PARAM_STR),
                    array('ann_image_url',$ann_image_url,\PDO::PARAM_STR)
                    )
                );
            // }
            $sendMail = new Mail('delete', $usr_courriel, $usr_nom, $usr_prenom, $crypto);
           
            echo json_encode("ok");
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
            
            // echo json_encode('OK');
            }


        public function Validation(){

            // Captcha
            // Ma clé privée
            $secret = "private_key";
            // Paramètre renvoyé par le recaptcha
            $response = $_POST['g-recaptcha-response'];
            // On récupère l'IP de l'utilisateur
            $remoteip = $_SERVER['REMOTE_ADDR'];

            $api_url = "https://www.google.com/recaptcha/api/siteverify?secret="
            . $secret
            . "&response=" . $response
            . "&remoteip=" . $remoteip ;

            $decode = json_decode(file_get_contents($api_url), true);

            if($decode['success'] == false){
            return 'CAPTCHA Invalide';
            }


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
    
            if(isset($_POST['cat_libelle']) && !empty($_POST['cat_libelle'])){
                if(v::stringVal()->validate($_POST['cat_libelle']) == false){
                    return 'Catégorie invalide';
                }
            }else{
                return 'Veuillez choisir une categorie';
            }
            return "OK";
        }
        

        //function pour charger l'image
        public function ChargerImage($code,$extension){
            $files_tmp = $_FILES['file']['tmp_name'];
            $url = './media/annonce';
            $newName = basename($code.'.'.$extension);
            $path = "$url" . '/' . "$newName";
            move_uploaded_file($files_tmp, $path);
            if (file_exists($path)) {
                return true;
            }
            return false;
        }
        
    
        

    

    
}
