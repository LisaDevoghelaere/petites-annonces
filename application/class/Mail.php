<?php

namespace App;

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



class Mail
{
    function __construct($type, $mailto, $prenom, $nom, $motdepasse)
    {
        // $host = './';
        $host = 'https://lisad.promo-39.codeur.online/popy';

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            // $mail->SMTPDebug = true; // Enable verbose debug output

            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.mail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'popylisa@mail.com';                     // SMTP username
            $mail->Password   = 'popysecure';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom('popylisa@mail.com', 'Popy');
            $mail->addAddress($mailto, $prenom . ' ' . $nom);     // Add a recipient
       
            // Content
            $mail->isHTML(true);  
            
            if ($type === 'valid') {
                $link = $host . '/valid-' . $motdepasse;
                $Subject = 'Confirmez votre annonce';
                $mail->Subject = utf8_decode($Subject);
                $mail->Body ='<h1><a href="./"><img src="./media/logo/popy1-2.png" alt=""> POPY</a></h1><br><br><p>Bonjour '.$prenom.' !</p><br><a href="'.$link .'">Cliquez sur ce lien pour confirmer votre annonce.</a>';
            } elseif ($type === 'delete') {
                $link = $host . '/del-' . $motdepasse;
                $Subject = 'Votre annonce a été publiée';
                $mail->Subject = utf8_decode($Subject);
                $mail->Body ='<h1><a href="./"><img src="./media/logo/popy1-2.png" alt=""> POPY</a></h1><br><br><p>Bonjour '.$prenom.' !</p><br><a href="'.$link .'">Cliquez sur ce lien pour supprimer votre annonce.</a>';
            } else {
                echo 'Wrong Type Parameter';
                return;
            }
            
        
            $mail->send();
            // echo 'Le message a été envoyé';
        } catch (Exception $e) {
            echo "Le message n'a pas pu être envoyé. Erreur de l'expéditeur: {$mail->ErrorInfo}";
        }
    }
}




