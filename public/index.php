<?php

// Affiche toutes les informations, comme le ferait INFO_ALL
phpinfo();


$router->map( 'GET', '/', function() {
    Namespace\\Ma_classe_de_traitement::Méthode_statique_de_traitement() ;
});


$loader = new \Twig\Loader\FilesystemLoader('/path/to/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => '/path/to/compilation_cache',
]);
echo $twig->render('index.html.twig', ['the' => 'variables', 'go' => 'here']); 