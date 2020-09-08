<?php

namespace App;

class AjaxCarte{
    public static function homePage(){
        if($_POST['categorie'] !== "0"){
            $liste = self::liste_par_categorie();
            
        }else{
            $liste = self::liste_annonces();
            

        }
        // self pour accéder aux propriétés ou méthodes de la classe
        // echo"<pre>";
        // print_r ($liste);
        // echo"</pre>";
        // die();
        $loader = new \Twig\Loader\FilesystemLoader('../application/template');
        $twig = new \Twig\Environment($loader, [
            'cache'=> false,
            //'../application/cache'
            'debug' => true,
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        
        // render template
        $template = $twig->load('/carte-annonce.html.twig');
        echo $template->render(array(
            'liste' => $liste
        ));
    
    }

    private static function liste_annonces(){
        //Connexion
        $base = new \App\Db();

        $sql = "SELECT ann_unique_id, ann_titre, ann_description, ann_prix, ann_image_url, ann_date_validation, usr_nom, cat_libelle FROM annonce INNER JOIN categorie ON categorie_id = cat_id INNER JOIN utilisateur ON id = utilisateur_id";
        $data = $base->q($sql);  
        return $data;
    }
    private static function liste_par_categorie(){
        
        $categorie = $_POST['categorie'];
       
        $base = new \App\Db();
        $sql = "SELECT ann_unique_id, ann_titre, ann_description, ann_prix, ann_image_url, ann_date_validation, usr_nom, cat_libelle FROM annonce INNER JOIN categorie ON categorie_id = cat_id INNER JOIN utilisateur ON id = utilisateur_id WHERE cat_id = :categorie";    
        $data = $base->q($sql, array(array('categorie', $categorie, \PDO::PARAM_INT)));  
        return $data;
    }
}