<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require '../vendor/autoload.php';

// Le routeur
$uri = $_SERVER['REQUEST_URI'];
// créer une instance
$router = new AltoRouter();
// projet dans sous dossier
$router->setBasePath('');


    // Page Liste des annonces index.html.twig
    
    $router->map('GET', '/', function () {

        // echo 'page index.php';

        $loader = new \Twig\Loader\FilesystemLoader('../application/template');
        $twig = new \Twig\Environment($loader, [
            'cache'=> '../application/cache',
            'debug' => true,
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        function liste_annonces(){
            $sql = "SELECT ann_titre, ann_description, ann_prix, ann_image_url, ann_date_validation, usr_nom,  cat_libelle FROM annonce INNER JOIN categorie ON categorie_id = cat_id INNER JOIN utilisateur ON id = utilisateur_id";
            $sth = $dbh->prepare($sql);  
            $sth->execute();
            return $sth;
        }
        
        $template = $twig->load('index.html.twig');
        echo $template->render();
    });


    
    // Page de l'annonce sélectionnée
    $router->map('GET', '/annonce-[*:slug]-[i:id]', function ($slug, $id) {
        echo "Visualisation de l'annonce: $slug qui a l'index: $id";
        
    });


// Lancer les map du routeur
$match = $router->match();
if ($match !== null) {
call_user_func_array($match['target'], $match['params']);
}
