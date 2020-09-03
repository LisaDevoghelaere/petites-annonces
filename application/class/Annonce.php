<?php

namespace App;


// class Annonce{
//     public static function pageAnnonce(){

//         $annonce = self::voir_annonce();
    
        
//         // echo"<pre>";
//         // print_r ($annonce);
//         // echo"</pre>";
//         // die();
//         $loader = new \Twig\Loader\FilesystemLoader('../application/template');
//         $twig = new \Twig\Environment($loader, [
//             'cache'=> '../application/cache',
//             'debug' => true,
            
//         ]);
       
//         $twig->addExtension(new \Twig\Extension\DebugExtension());
//         // self pour accéder aux propriétés ou méthodes de la classe
        
        
//         // render template
//         $template = $twig->load('annonce.html.twig');
//         echo $template->render(array(
//             'annonce' => $annonce,
//             'ann_unique_id' => $ann_unique_id,
//             'ann_description' => $ann_description
//         ));
        
//     }

//     private static function voir_annonce(){
//         //Connexion
//         $base = new \App\Db();
        
//         if(isset($_GET['ann_unique_id']) && !empty($_GET['ann_unique_id'])){
//             $ann_unique_id = $_POST['ann_unique_id'];
//         $sql = "SELECT ann_unique_id, ann_titre, ann_description, ann_prix, ann_image_url, ann_date_validation, usr_nom, cat_libelle FROM annonce INNER JOIN categorie ON categorie_id = cat_id INNER JOIN utilisateur ON id = utilisateur_id where ann_unique_id = :ann_unique_id";
//         $data = $base->q($sql);  
        
//         return $data;


//         }else{
//             echo "erreur";
//         }
        
//     }
// }

class Annonce
{
    public $data=[];

    function __construct($ann_unique_id) {
        $base = new \App\Db();

        $req = $base->q(
            "SELECT ann_unique_id, ann_titre, ann_description, ann_prix, ann_image_url, ann_date_validation, usr_nom, cat_libelle, usr_prenom, usr_courriel, usr_telephone FROM annonce INNER JOIN categorie ON categorie_id = cat_id INNER JOIN utilisateur ON id = utilisateur_id where ann_unique_id = :ann_unique_id",
            array(array('ann_unique_id',$ann_unique_id,\PDO::PARAM_STR)));
        $this->data = $req;
    }

    public static function Exists($ann_unique_id){

        //Connexion
        $base = new \App\Db();

        //Test if ann_unique_id exist
        $req = $base->q("SELECT `ann_unique_id` FROM `annonce` WHERE `ann_unique_id` = :ann_unique_id",
            array(array('ann_unique_id',$ann_unique_id,\PDO::PARAM_STR)));

        $slug = $req[0]->ann_unique_id;

        if($slug === $ann_unique_id){
            return true;
        }
        return false;
    }

    public static function IsValidated($ann_unique_id){

        //Connexion
        $base = new \App\Db();

        //Test if unique_id exist
        $req = $base->q("SELECT `ann__est_valide` FROM `annonce` WHERE `ann_unique_id` = :ann_unique_id",
            array(array('ann_unique_id',$ann_unique_id,\PDO::PARAM_STR)));

        $valid = $req[0]->ann__est_valide;

        if($valid === 1){
            return true;
        }
        return false;
    }

}








