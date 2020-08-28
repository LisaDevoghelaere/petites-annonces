<?php

namespace App;


class Annonce{
    public static function pageAnnonce(){

        $annonce = self::voir_annonce();
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

    private static function voir_annonce(){
        //Connexion
        $base = new \App\Db();

        $sql = "SELECT ann_titre, ann_description, ann_prix, ann_image_url, ann_date_validation, usr_nom, cat_libelle FROM annonce INNER JOIN categorie ON categorie_id = cat_id INNER JOIN utilisateur ON id = utilisateur_id where ann_unique_id = :ann_unique_id";
        $data = $base->q($sql);  
        return $data;
    }
}