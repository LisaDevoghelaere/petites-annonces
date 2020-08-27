<?php
namespace App;


// classe Twig pour éviter de répeter toutes les déclarations de twig avant de faire le rendu twig dans le PHP
class Twig{
    private $template;

    // Fonction constructor qui permet de récupérer le nom des templates que l'on voudra afficher dans twig
    public function __construct($template_name)
    {
        $loader = new \Twig\Loader\FilesystemLoader('../application/template');
        $twig = new \Twig\Environment($loader, [
            'cache' => '../application/cache',
            'debug' => true,
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        $this->template = $twig->load($template_name);
    }

    public function render($arr=[]){
        echo $this->template->render($arr);
    }
}