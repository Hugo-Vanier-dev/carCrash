<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
/**
 * On vérifie si notre $_GET['formMailValue'] existe.
 * Si c'est le cas c'est que une requète ajax a été initialisé.
 * On stocke un tableau vide dans une variable.
 * On stockera notre reponse au fichier js dans ce tableau
 */
if (isset($_GET['formMailValue'])) {
    $responseToAjax = array();
    /**
     * On vérifie que notre $_GET['formMailValue'] n'est pas vide.
     * Si c'est le cas on doit réinclure les fichiers dont ont a besoin,
     * car les fichier include dans la vue ne le sont pas dans le controller lors d'une requète ajax.
     * Une fois les fichier dont on a besoin inclue on instancie deux nouveau objet,
     * un $user et un $checkForm à partir de nos class users et formHelper.
     * Puis on donne aux attribut fieldName et postValue les valeur 'mail' et la valeur envoyé en ajax.
     * On utilise le htmlspecialChar pour désactiver le potentiel code html et pour éviter une faille xss
     * Si notre param get est vide alors on stocke dans notre tableau de réponse des valeurs de retour.
     */
    if (!empty($_GET['formMailValue'])) {
        include_once '../helpers/const.php';
        include_once '../helpers/formHelper.php';
        include_once '../models/database.php';
        include_once '../models/users.php';
        $user = new users();
        $checkForm = new formHelper();
        $checkForm->fieldName = 'mail';
        $checkForm->postValue = htmlspecialchars($_GET['formMailValue']);
        /**
         * On vérifie le retour de la méthode checkFormEnter de notre objet checkForm
         * Si c'est true on stocke la valeur envoyé par l'utilisateur dans l'attribut mail 
         * de notre objet user. On stocke ensuite dans la variable $mailExist le retour de 
         * la méthode checkMail.
         * Si checkForm renvoie false alors on stocke dans notre tableau de réponse des valeurs de retour.
         */
        if ($checkForm->checkFormEnter()) {
            $user->mail = htmlspecialchars($_GET['formMailValue']);
            $mailExist = $user->checkMail();
            /**
             * On vérifie la valeur de l'attribut mailExist de notre objet mailExist
             * Si il vaut false alors on stocke dans notre tableau de réponse des valeurs de retour
             * Sinon on stocke dans notre tableau de réponse des valeurs de retour.
             */
            if (!$mailExist->mailExist) {
                // Message de retour
                $responseToAjax['message'] = 'Le mail est valide';
                //Status de la donnée envoyé par l'utilisateur
                $responseToAjax['status'] = 'success';
            } else {
                $responseToAjax['message'] = 'Cette adresse mail est déjà utilisée';
                $responseToAjax['status'] = 'error';
            }
        } else {
            $responseToAjax['message'] = 'Cette adresse mail n\'est pas valide';
            $responseToAjax['status'] = 'error';
        }
    } else {
        $responseToAjax['message'] = 'Veuillez renseigner une adresse mail';
        $responseToAjax['status'] = 'error';
    }
    //On précise à notre Js dans l'entête du retour le type de données 
    header('Content-Type: application/json');
    /**
     * On encode notre tableau de réponse sous la forme d'un JSON qui est facilement interpretable en js.
     * Puis on le echo pour dire que c'est ce que l'on souhaite renvoyé.
     */
    echo json_encode($responseToAjax);
    /**
     * On utilise le même principe que pour le champ mail mais cette fois ci avec
     * le champ username on ne vérifie juste pas avec un filtre la donné entré 
     * par l'utilisateur
     */
} elseif (isset($_GET['formUsernameValue'])) {
    $responseToAjax = array();
    if (!empty($_GET['formUsernameValue'])) {
        include_once '../helpers/const.php';
        include_once '../models/database.php';
        include_once '../models/users.php';
        $user = new users();
        $user->username = htmlspecialchars($_GET['formUsernameValue']);
        $usernameExist = $user->checkUsername();
        if (!$usernameExist->usernameExist) {
            $responseToAjax['message'] = 'Le nom d\'utilisateur est valide';
            $responseToAjax['status'] = 'success';
        } else {
            $responseToAjax['message'] = 'Ce nom d\'utilisateur est déjà utilisé';
            $responseToAjax['status'] = 'error';
        }
    } else {
        $responseToAjax['message'] = 'Veuillez renseigner un nom d\'utilisateur';
        $responseToAjax['status'] = 'error';
    }
    header('Content-Type: application/json');
    echo json_encode($responseToAjax);
    //Si il n'y a pas d'ajax
} else {
    /**
     * Si le formulaire a été envoyé On stocke dans deux variable un message final et sa class
     * et on instancie un nouvel objet $user à partir de notre class users.
     */
    if (isset($_POST['submitForm'])) {
        $endMessage = 'Il y a eu un problème lors de l\'inscription';
        $endMessageClass = 'text-danger';
        $user = new users();
        /**
         * Si la valeur du $_POST['username'] n'est pas vide, on stocke dans l'attribut username
         * de notre objet $user la valeur du saisie par l'utilisateur.
         * Sinon on crée un tableau $formErorrs et on associe un message d'erreur à sa clé username. 
         */
        if (!empty($_POST['username'])) {
            $user->username = htmlspecialchars($_POST['username']);
        } else {
            $formErrors['username'] = 'Veuillez choisir un nom d\'utilisateur';
        }
        /**
         * Si la valeur du $_POST['mail'] n'est pas vide, on instancie un nouvel objet $checkForm à
         * partir de notre class formHelper puis on stocke dans les attributs fieldName et postValue de notre 
         * $checkForm la valeur 'mail' et la valeur entré par l'utilisateur.
         * Sinon on crée un tableau $formErorrs et on associe un message d'erreur à sa clé mail.
         */
        if (!empty($_POST['mail'])) {
            $checkForm = new formHelper();
            $checkForm->fieldName = 'mail';
            $checkForm->postValue = $_POST['mail'];
            /**
             * Si le retour de la méthode checkFormEnter de notre objet $checkForm vaut true
             * on stocke dans l'attribut mail de l'objet $user la valeur entrée par l'utilisateur.
             * Sinon on crée un tableau $formErorrs et on associe un message d'erreur à sa clé mail.
             */
            if ($checkForm->checkFormEnter()) {
                $user->mail = htmlspecialchars($_POST['mail']);
            } else {
                $formErrors['mail'] = 'L\'adresse mail renseignée n\'est pas valide';
            }
        } else {
            $formErrors['mail'] = 'Veuillez renseigner une adresse mail';
        }
        /**
         * On vérifie que notre $_POST['password'] n'est pas vide si c'est le cas on vérifie que le
         * $_POST['verifPassword'] n'est pas vide. Si le premier est vide, on crée un tableau $formErorrs 
         * et on associe un message d'erreur à sa clé password. Si le second est vide on crée un tableau 
         * $formErorrs et on associe un message d'erreur à sa clé passwordVerif.
         * Si aucun des deux n'est vide on vérifie qu'ils sont égaux. Si ils ne le sont pas 
         * on crée un tableau $formErorrs et on associe un message d'erreur à sa clé password.
         * Si les deux sont égaux on vérifie la longueur du mot de passe, si celle-ci est supérieur a 12
         * on stocke dans l'attribut password de l'objet $user le mot de passe entré par l'utilisateur 
         * hashé avec la fonction password_hash et la "méthode" BCRYPT qui renvoie une chaîne de 
         * 60 caractères. Si la longueur du mot de passe entré par l'utilisateur est inférieur à 12
         * on crée un tableau $formErorrs et on associe un message d'erreur à sa clé password.
         */
        if (!empty($_POST['password'])) {
            if (!empty($_POST['verifPassword'])) {
                if ($_POST['password'] == $_POST['verifPassword']) {
                    if (strlen($_POST['password']) >= 12) {
                        $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    } else {
                        $formErrors['password'] = 'Votre mot de passe doit faire au moins 12 caractères';
                    }
                } else {
                    $formErrors['password'] = 'Les mots de passe ne correspondent pas';
                }
            } else {
                $formErrors['verifPassword'] = 'Veuillez vérifier le mot de passe entré';
            }
        } else {
            $formErrors['password'] = 'Veuillez remplir le mot de passe';
        }
        /**
         * Si notre tableau $formerrors n'existe pas (donc qu'il n'y a pas eu d'erreur dans l'entré utilisateur)
         * On stocke dans la variable $usernameExist le retour de notre méthode checkUsername.
         */
        if (!isset($formErrors)) {
            $usernameExist = $user->checkUsername();
            /**
             * Si l'attribut usernameExist du retour vaut false (que le pseudo n'est pas encore utilisé), 
             * on stocke cette fois-ce le retour de notre méthode checkMail dans la variable $mailExist
             */
            if (!$usernameExist->usernameExist) {
                $mailExist = $user->checkMail();
                /**
                 * Si l'attribut mailExist du retour vaut false (que le mail n'est pas encore utilisé),
                 * on stocke dans notre variable $hash le retour de notre méthode generateHash de notre class
                 * randomHash que l'on appelle grâce à l'opérateur de résolution de portée qui nous permet 
                 * d'appeller une méthode static d'un objet sans l'instancier. Puis on stocke dans l'attribut
                 * hash de l'objet $user la variable $hash. On stocke ensuite le retour de la méthode 
                 * registerANewUser de l'objet $user dans une variable $insertUser.
                 */
                if (!$mailExist->mailExist) {
                    $hash = randomHash::generateHash();
                    $user->validationHash = $hash;
                    if($is_localhost == '127.0.0.1' || $is_localhost == '::1'){
                        $adressMessage = 'http://carcrash/views/accountValidation.php?validationHash=';
                    }else{
                        $adressMessage = 'http://carcrash.hv-web-dev.com/views/accountValidation.php?validationHash=';
                    }
                    /**
                     * Si $insertUser vaut true (que notre insertion en base de donnée s'est déroulé sans encombre) alors on change 
                     * les valeurs du message final et de sa class.
                     */
                    $subject = 'Confirmer votre compte';
                    
                    $message = '<h1>Validez votre compte carCrash</h1>';
                    $message .= '<p>Veuillez cliquer sur le bouton suivant pour valider votre compte :<br/>';
                    $message .= '<a href="' . $adressMessage . $user->validationHash . '&mail=' . $user->mail . '">';
                    $message .= '<button style="padding: 15px; background-color: #28a745;">Validez votre compte</button>';
                    $message .= '</a>';
                    $message .= '</p>';
                    $message .= '<p>Sinon, vous pouvez aussi cliquer sur le liens suivant pour valider votre compte : ';
                    $message .= '<a href="' . $adressMessage . $user->validationHash . '&mail=' . $user->mail . '">';
                    $message .= $adressMessage . $user->validationHash . '&mail=' . $user->mail;
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
                    $mail->addAddress($user->mail, $user->username);
                    //Set the subject line
                    $mail->Subject = $subject;
                    //Read an HTML message body from an external file, convert referenced images to embedded,
                    //convert HTML into a basic plain-text alternative body
                    $mail->msgHTML($message);
                    //Replace the plain text body with one created manually
                    $mail->AltBody = 'Veuillez utiliser le lien suivant pour valider votre adresse mail' . $adressMessage . $user->validationHash . '&mail=' . $user->mail;
                    //send the message, check for errors
                    if (!$mail->send()) {
                        $endMessage = 'Mailer Error: ' . $mail->ErrorInfo;
                        $endMessageClass = 'text-danger';
                    } else {
                        $insertUser = $user->registerANewUser();
                        $endMessage = 'Nous vous avons envoyé un mail pour validez votre inscription.';
                        $endMessageClass = 'text-success';
                    }
                } else {
                    $formErrors['mail'] = 'Cette adresse mail est déjà utilisée';
                }
            } else {
                $formErrors['username'] = 'Ce nom d\'utilisateur existe déjà';
            }
        }
    }
}


