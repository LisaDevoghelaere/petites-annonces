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


    
    // // Page de l'annonce sélectionnée
    // $router->map('GET', '/annonce-[*:slug]-[i:id]', function ($slug, $id) {
    //     echo "Visualisation de l'annonce: $slug qui a l'index: $id";
        
    // });


// Lancer les map du routeur
$match = $router->match();
if ($match !== null) {
call_user_func_array($match['target'], $match['params']);
}
