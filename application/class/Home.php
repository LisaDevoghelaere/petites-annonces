<?php

namespace App;

class Home{
    public static function homePage(){

        // self pour accéder aux propriétés ou méthodes de la classe
        // echo"<pre>";
        // print_r ($liste);
        // echo"</pre>";
        // die();
        $loader = new \Twig\Loader\FilesystemLoader('../application/template');
        $twig = new \Twig\Environment($loader, [
            'cache'=> false,
            //'../application/cache'
            'debug' => true,
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        
        // render template
        $template = $twig->load('index.html.twig');
        echo $template->render();
    
    }

}
