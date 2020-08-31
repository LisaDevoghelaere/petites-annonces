<?php

namespace App;


class Annonce{
    public static function pageAnnonce(){

        $annonce = self::voir_annonce();
        // echo"<pre>";
        // print_r ($annonce);
        // echo"</pre>";
        // die();
        $loader = new \Twig\Loader\FilesystemLoader('../application/template');
        $twig = new \Twig\Environment($loader, [
            'cache'=> '../application/cache',
            'debug' => true,
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        
        // render template
        $template = $twig->load('annonce.html.twig');
        echo $template->render(array(
            'annonce' => $annonce
        ));
    
    }

    private static function voir_annonce($ann_unique_id){
        //Connexion
        $base = new \App\Db();
        $ann_unique_id = ":unique_id";
        if(isset($_GET['ann_unique_id']) && !empty($_GET['ann_unique_id'])){
        $sql = "SELECT ann_unique_id, ann_titre, ann_description, ann_prix, ann_image_url, ann_date_validation, usr_nom, cat_libelle FROM annonce INNER JOIN categorie ON categorie_id = cat_id INNER JOIN utilisateur ON id = utilisateur_id where ann_unique_id = :ann_unique_id";
        $data = $base->q($sql);  
        return $data;
        }
    }
}



// class Annonce{
//     public static function pageAnnonce(){
//         error_reporting(E_ALL);
// ini_set("display_errors", 1);


// require_once('db.php');

// //initialisation des variables
// $ann_unique_id = '';
// $ann_titre = '';
// $ann_description = '';
// $ann_prix = '';
// $ann_date  = '';
// $ann_image_url = '';

// $error = false;

// //condition pour savoir si l'on a bien reçu l'id
// if(isset($_GET['ann_unique_id']) && !empty($_GET['ann_unique_id'])){
//     $sql = "SELECT ann_unique_id, ann_titre, ann_description, ann_prix, ann_image_url, ann_date_validation, usr_nom,  cat_libelle FROM annonce INNER JOIN categorie ON categorie_id = cat_id INNER JOIN utilisateur ON id = utilisateur_id";

//     $sth = $dbh->prepare($sql);
//     $sth->bindParam(':ann_unique_id', $_GET['ann_unique_id'], PDO::PARAM_INT);
        
//     $sth->execute();
//     $data = $sth->fetch(PDO::FETCH_ASSOC);
//     //Condition pour sécuriser le formulaire 
//     //si pas de résultat de la requête
//     //data est booléen
//     if(gettype($data) === "boolean"){
//         header('Location: index.php');
//         exit;
//     }
//     $ann_unique_id = $data['ann_unique_id'];
//     $ann_titre = $data['ann_titre'];
//     $ann_description = $data['ann_description'];
//     $ann_prix = $data['ann_prix'];
//     $ann_date  = $data['ann_date'];
//     $ann_image_url = $data['ann_image_url'];
    
//     $ann_unique_id = htmlentities($_GET['ann_unique_id']);


// }

//         $loader = new \Twig\Loader\FilesystemLoader('../application/template');
//         $twig = new \Twig\Environment($loader, [
//             'cache'=> '../application/cache',
//             'debug' => true,
//         ]);
//         $twig->addExtension(new \Twig\Extension\DebugExtension());

        
//         // render template
//         $template = $twig->load('annonce.html.twig');
//         echo $template->render(array(
//             'ann_unique_id' => $ann_unique_id,
//             'ann_titre' => $ann_titre,
//             'ann_description' => $ann_description,
//             'ann_prix' => $ann_prix,
//             'ann_date' => $ann_date,
//             'ann_image_url' => $ann_image_url,
//             'ann_unique_id' => $ann_unique_id,
            
//         ));
//     }
// }






