<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = 'Il y a eu un problème lors de la validation de votre compte';
$messageClass = 'text-danger';
if (isset($_GET['validationHash'])) {
    $user = new users();
    $user->validationHash = htmlspecialchars($_GET['validationHash']);
    $userInfo = $user->selectMailValidationHashAndId();
    if (is_object($userInfo)) {
        if (isset($_GET['mail'])) {
            if ($userInfo->mail == $_GET['mail']) {
                if ($user->uptdateValidation()) {
                    $message = 'Votre compte a bien été validé';
                    $messageClass = 'text-success';
                    $_SESSION['username'] = $userInfo->username;
                } else {
                    $message = 'Il y a eu un problème';
                    $messageClass = 'text-danger';
                }
            } else {
                $message = 'Il y a eu un problème avec votre adresse mail';
                $messageClass = 'text-danger';
            }
        } else {
            $message = 'Il y a eu un problème get mail existe pas';
            $messageClass = 'text-danger';
        }
    } else {
        $message = 'Il y a eu un problème pas un obj';
        $messageClass = 'text-danger';
    }
}
if (isset($_POST['submitForm']) && isset($userInfo)) {
    $user->id = $userInfo->id;
    $user->validationHash = randomHash::generateHash();
    if ($user->uptadeMailAndValisationHash()) {
        if ($is_localhost == '127.0.0.1' || $is_localhost == '::1') {
            $adressMessage = 'http://carcrash/views/accountValidation.php?validationHash=';
        } else {
            $adressMessage = 'http://carcrash.hv-web-dev.com/views/accountValidation.php?validationHash=';
        }
        $subject = 'Confirmer votre compte';

        $message = '<h1>Validez votre compte carCrash</h1>';
        $message .= '<p>Veuillez cliquer sur le bouton suivant pour valider votre compte :<br/>';
        $message .= '<a href="' . $adressMessage . $user->validationHash . '&mail=' . htmlspecialchars($_POST['mail']) . '">';
        $message .= '<button style="padding: 15px; background-color: #28a745;">Validez votre compte</button>';
        $message .= '</a>';
        $message .= '</p>';
        $message .= '<p>Sinon, vous pouvez aussi cliquer sur le liens suivant pour valider votre compte : ';
        $message .= '<a href="' . $adressMessage . $user->validationHash . '&mail=' . htmlspecialchars($_POST['mail']) . '">';
        $message .= $adressMessage . $user->validationHash . '&mail=' . htmlspecialchars($_POST['mail']);
        $message .= '</a>';
        $message .= '</p>';
        $message .= '<p>Merci de ne pas répondre à ce mail qui est généré automatiquement.</p>';
        //Create a new PHPMailer instance                        
        $mail = new PHPMailer;
        //Set who the message is to be sent from
        $mail->setFrom('carcrashentreprise@gmail.com', 'carCrash');
        //Set an alternative reply-to address
        $mail->addReplyTo('NoreplyPls@noReply.com', 'carCrash');
        //Set who the message is to be sent to
        $mail->addAddress(htmlspecialchars($_POST['mail']), $userInfo->username);
        //Set the subject line
        $mail->Subject = $subject;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML($message);
        //Replace the plain text body with one created manually
        $mail->AltBody = 'Veuillez utiliser le lien suivant pour valider votre adresse mail' . $adressMessage . $user->validationHash . '&mail=' . htmlspecialchars($_POST['mail']);
        //send the message, check for errors
        if (!$mail->send()) {
            $message = 'Mailer Error: ' . $mail->ErrorInfo;
            $messageClass = 'text-danger';
        } else {
            $message = 'Nous vous avons envoyé un mail pour valider votre compte.';
            $messageClass = 'text-success';
        }
    }
}
if (!isset($userInfo)) {
    $message = 'Il y a eu un problème lors de la validation de votre compte. Veuillez réutiliser le lien envoyé';
    $messageClass = 'text-danger';
}