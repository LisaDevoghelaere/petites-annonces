<?php

require '../vendor/autoload.php';
use App\Twig;
use App\Annonce;
use App\Valid;

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


    // Page ajout
    $router->map('GET', '/ajout', function (){
    //render template
    $twig = new Twig('ajout.html.twig');
    $twig->render();
    });

    $router->map('POST', '/ajax-ajout', function (){
        \App\Ajout::add();
    });
    

    //page validation
    $router->map('GET', '/valid-[:ann_unique_id]', function ($crypto){
        // test if unique_id exists
    // if((!\App\Annonce::Exists($ann_unique_id))||(!\App\Annonce::IsValidated($ann_unique_id))){
    //     header('Location: /');
    // }
    $annonce = new Valid($crypto);
    var_dump($annonce->data);
    // echo 'Page validation lisa';
    $twig = new Twig('validation.html.twig');
        $twig->render([
            'annonce' => $annonce->data[0],
            'crypto' => $crypto,
            
        ]);

    });

    // Ajax valider
    $router->map('POST', '/ajax-valider', function(){
        \App\Ajout::Update();
    });


     //mail suppression
     $router->map('GET', '/del-[:crypto]', function ($crypto){
        
        $twig = new Twig('suppression.html.twig');
            $twig->render([
                'crypto' => $crypto
            ]);

    });

    
   
    
  //catégories
$router->map('POST', '/choixcategorie', function () {
    \App\AjaxCarte::homePage($_POST);
});  
// Lancer les map du routeur
$match = $router->match();
if ($match !== null) {
call_user_func_array($match['target'], $match['params']);
}