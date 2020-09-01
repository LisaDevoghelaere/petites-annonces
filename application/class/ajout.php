<?php

namespace App;


class Ajout{
    public static function pageAjout(){

        $annonce = self::ajout_annonce();
        $ann_unique_id = ':ann_unique_id';
        
        $loader = new \Twig\Loader\FilesystemLoader('../application/template');
        $twig = new \Twig\Environment($loader, [
            'cache'=> '../application/cache',
            'debug' => true,
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        
        // render template
        $template = $twig->load('ajout.html.twig');
        echo $template->render(array(
            'annonce' => $annonce,
            'ann_unique_id' => $ann_unique_id
        ));
    
    }

    private static function ajout_annonce(){
        //Connexion
        $base = new \App\Db();
        
        
        $sql = "INSERT INTO annonce (ann_unique_id, ann_titre, ann_description, ann_prix, `ann_date_ecriture`, ann_image_url, cat_libelle, usr_nom, usr_prenom, usr_courriel INNER JOIN categorie ON categorie_id = cat_id INNER JOIN utilisateur ON id = utilisateur_id VALUES (:ann_unique_id, :ann_titre, :ann_description, :ann_prix, :ann_date_ecriture, :ann_image_url, :cat_libelle, :usr_nom, :usr_prenom, :usr_courriel)";
        $data = $base->q($sql);  
        return $data;
        }
    
}