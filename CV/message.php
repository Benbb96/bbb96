<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 28/02/2017
 * Time: 22:13
 */

if (isset($_POST['nom']) && !empty($_POST['nom'])) {
    $nom = $_POST['nom'];
    if (isset($_POST['mail']) && !empty($_POST['mail'])) {
        $mail = $_POST['mail'];
        if (isset($_POST['message']) && !empty($_POST['message'])) {
            $message = $_POST['message'];
            if (isset($_POST['sondage']) && !empty($_POST['sondage'])) {
                $sondage = $_POST['sondage'];
            }
            else {
                $sondage = null;
            }

            $headers = 'From: bbb96@free.fr' . "\r\n" .
                'Reply-To: benbb96@gmail.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            $sent = mail('benbb96@gmail.com', 'CV - Contacté par ' . $nom, $message, $headers);
            if ($sent) echo 'Mail envoyé.<br />';
            else echo 'Le mail n\a pas pu être envoyé.';

            echo 'Votre message a bien été envoyé.<br /><br />';

            echo 'Nom = '. $nom .'<br />';
            echo 'Adresse Mail = '. $mail .'<br />';
            echo 'Message = '. $message .'<br />';
            if(is_null($sondage)) echo 'Sondage = '. $sondage  .'<br />';
        }
        else {
            echo "Veuillez saisir un message.<br />";
        }
    }
    else {
        echo "Veuillez saisir un mail.<br />";
    }
}
else {
    echo "Veuillez rentrer votre nom.<br />";
}

echo '<br /><a href="contact.html">Retour</a>';