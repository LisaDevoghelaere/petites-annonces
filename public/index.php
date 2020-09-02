<?php

require '../vendor/autoload.php';
use App\Twig;
use App\Annonce;

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
            //test if unique_id exists
    if((!\App\Annonce::Exists($ann_unique_id))||(\App\Annonce::IsValidated($ann_unique_id))){
        header('Location: /');
    }
    
    $annonce = new Annonce($ann_unique_id);

        //render template
    $twig = new Twig('annonce.html.twig');
    $twig->render([
            'annonce' => $annonce->data[0],
            'ann_unique_id' => $ann_unique_id,
        ]);
       
    });

    // // Page Ajout d'une annonce ajout.html.twig
    // $router->map('POST', '/ajax-post-add', function(){
    //     \App\Ajout::Add();
    // });
    
// Lancer les map du routeur
$match = $router->match();
if ($match !== null) {
call_user_func_array($match['target'], $match['params']);
}


