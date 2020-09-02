<?php

namespace App;

class Annonce
{
    public $data=[];

    function __construct($ann_unique_id) {
        $base = new \App\Db();

        $req = $base->q(
            "SELECT ann_unique_id, ann_titre, ann_description, ann_prix, ann_image_url, ann_date_validation, usr_nom, cat_libelle FROM annonce INNER JOIN categorie ON categorie_id = cat_id INNER JOIN utilisateur ON id = utilisateur_id where ann_unique_id = :ann_unique_id",
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

        //Test if ann_unique_id exist
        $req = $base->q("SELECT `ann__est_valide` FROM `annonce` WHERE `ann_unique_id` = :ann_unique_id",
            array(array('ann_unique_id',$ann_unique_id,\PDO::PARAM_STR)));

        $valid = $req[0]->ann__est_valide;

        if($valid === 1){
            return true;
        }
        return false;
    }

}