<?php

namespace App;

use Dompdf\Dompdf;

class PdfExport {

    public static function pdf(){
    if(isset($_GET['ann_unique_id'])){
        $ann_unique_id = $_GET['ann_unique_id'];

    //request post data
    $annonce = new Annonce($ann_unique_id);

    //render template
    $loader = new \Twig\Loader\FilesystemLoader('../application/template');
    $twig = new \Twig\Environment($loader, [
        'cache' => '../application/cache',
        'debug' => true,
    ]);
    $twig->addExtension(new \Twig\Extension\DebugExtension());

    $temp = $twig->load('pdf.html.twig');

    // Instantiate Dompdf with our options
    $dompdf = new Dompdf();

    $dompdf->loadHtml($temp->render(['annonce' => $annonce->data[0],]));

    // // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // // Render the HTML as PDF
    $dompdf->render();

    // // Output the generated PDF to Browser
    $dompdf->stream('annonce'.$ann_unique_id.'pdf');
    }
    }
}