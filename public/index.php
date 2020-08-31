<?php

require '../vendor/autoload.php';

// Le routeur
$uri = $_SERVER['REQUEST_URI'];
// créer une instance
$router = new AltoRouter();
// projet dans sous dossier
$router->setBasePath('');


    // Page Liste des annonces index.html.twig
    $router->map('GET', '/', function () {
        \App\Home::homePage();
    });

    // Page d'une annonce annonce.html.twig
    $router->map('GET', '/annonce[:ann_unique_id]', function ($ann_unique_id){
        
            \App\Annonce::pageAnnonce();
        
        // echo 'salut';
        
    });
    
// Lancer les map du routeur
$match = $router->match();
if ($match !== null) {
call_user_func_array($match['target'], $match['params']);
}
