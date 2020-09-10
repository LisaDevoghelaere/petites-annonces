<?php

namespace App;

class Valid
{
    public $data=[];

    function __construct($crypto) {
        $base = new \App\Db();

        $req = $base->q(
            "SELECT crypto, ann_titre, ann_description, ann_prix, ann_image_url, ann_date_validation, usr_nom, cat_libelle, usr_prenom, usr_courriel, usr_telephone FROM annonce INNER JOIN categorie ON categorie_id = cat_id INNER JOIN utilisateur ON id = utilisateur_id where crypto = :crypto",
            array(array('crypto',$crypto,\PDO::PARAM_STR)));
        $this->data = $req;
    }

    public static function Exists($crypto){

        //Connexion
        $base = new \App\Db();

        //Test if ann_unique_id exist
        $req = $base->q("SELECT `crypto` FROM `annonce` WHERE `crypto` = :crypto",
            array(array('crypto',$crypto,\PDO::PARAM_STR)));

        $slug = $req[0]->crypto;

        if($slug === $crypto){
            return true;
        }
        return false;
    }

    public static function IsValidated($crypto){

        //Connexion
        $base = new \App\Db();

        //Test if unique_id exist
        $req = $base->q("SELECT `ann__est_valide` FROM `annonce` WHERE `crypto` = :crypto",
            array(array('crypto',$crypto,\PDO::PARAM_STR)));

        $valid = $req[0]->ann__est_valide;

        if($valid === 1){
            return true;
        }
        return false;
    }

}