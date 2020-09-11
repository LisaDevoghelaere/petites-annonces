<?php
namespace App;

class Categories
{
    public $data=[];

    function __construct() {
        $base = new \App\Db();

        $req = $base->q("SELECT * FROM `categorie`");
        $this->data = $req;
    }
}