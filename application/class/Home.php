<?php

namespace App;

class Home{
    public static function homePage(){

        $liste = self::liste_annonces();
        // echo"<pre>";
        // print_r ($liste);
        // echo"</pre>";
        // die();
        $loader = new \Twig\Loader\FilesystemLoader('../application/template');
        $twig = new \Twig\Environment($loader, [
            'cache'=> '../application/cache',
            'debug' => true,
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        
        // render template
        $template = $twig->load('index.html.twig');
        echo $template->render(array(
            'liste' => $liste
        ));
    
    }

    private static function liste_annonces(){
        //Connexion
        $base = new \App\Db();

        $sql = "SELECT ann_unique_id, ann_titre, ann_description, ann_prix, ann_image_url, ann_date_validation, usr_nom,  cat_libelle FROM annonce INNER JOIN categorie ON categorie_id = cat_id INNER JOIN utilisateur ON id = utilisateur_id";
        $data = $base->q($sql);  
        return $data;
    }
}