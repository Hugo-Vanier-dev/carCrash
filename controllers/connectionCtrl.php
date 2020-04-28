<?php
/**
 * On vérifie la présence du $_GET['formMailUsernameValue'], si il existe on stocke dans la
 * variable $responseAjaxMessage le retour que l'on va renvoyé au javascript
 */
if (isset($_GET['formMailUsernameValue'])) {
    $responseAjaxMessage = '';
    /**
     * ON vérifie que les données récupérées ne sont pas vide, si elle ne sont pas vide,
     * on include les fichier dont on va avoir besoin pour faire notre requête.
     * Puis on instancie un objet $user à partir de notre class users.
     * On donne ensuite aux attributs username et mail la valeur entrée par l'utilisateur
     * On stocke ensuite dans une variable $mailExist le retour de notre méthode checkmail
     * de notre objet $user et dans une variable $usernameExist le retour de notre méthode 
     * checkUsername de notre objet user. Si les données récupérer sont vide on stocke dans 
     * notre variable de réponse un message.
     */
    if (!empty($_GET['formMailUsernameValue'])) {
        include_once '../helpers/const.php';
        include_once '../models/database.php';
        include_once '../models/users.php';
        $user = new users();
        $user->username = $user->mail = htmlspecialchars($_GET['formMailUsernameValue']);
        $mailExist = $user->checkMail();
        $usernameExist = $user->checkUsername();
        /**
         * Si l'envoie de données saisies par l'utilisateur ne correspondent ni à un mail ou a un
         * nom d'utilisateur on stocke un autre message dans notre variable de réponse. 
         */
        if (!$usernameExist->usernameExist && !$mailExist->mailExist) {
            $responseAjaxMessage = 'Nom d\'utilisateur ou adresse mail non valide.';
        }
    } else {
        $responseAjaxMessage = 'Veulliez remplir un nom d\'utilisateur ou une adresse mail.';
    }
    //On envoie le message stocké dans notre variable de réponse via un echo à notre javascript.
    echo $responseAjaxMessage;
    //Sinon si il n'y a pas d'ajax
} else {
    /**
     * Si le formulaire de connection a bien été envoyé(si $_GET['submitForm'] existe bien).
     * On instancie un nouvel objet $user à partir de notre class users
     */
    if (isset($_POST['submitForm'])) {
        $user = new users();
        /**
         * Si notre champ mailUsername n'est pas vide lors de l'envoie alors on stocke 
         * dans nos attribut username et mail la valeur de la donnée saisie par l'utilisateur.
         * Sinon on associe un message d'erreur à la clé mailUsername de notre tableau $formErrors.
         */
        if (!empty($_POST['mailUsername'])) {
            $user->mail = $user->username = htmlspecialchars($_POST['mailUsername']);
        } else {
            $formErrors['mailUsername'] = 'Veulliez remplir un nom d\'utilisateur ou une adresse mail.';
        }
        /**
         * On vérifie que l'utilisateur a bien rempli le champ mot de passe.
         * Si il ne l'as pas fait on associe un message d'erreur à la clé password de notre tableau $formErrors.
         */
        if (empty($_POST['password'])) {
            $formErrors['password'] = 'Veulliez remplir votre mot de passe.';
        }
        /**
         * Si jamais l'utilisateur n'as pas commis une des erreur ci-dessus.
         * On stocke dans la variable $userInfo le retour de notre méthode getInfoUserWithMailOrusername
         */
        if (!isset($formErrors)) {
            $userInfo = $user->getInfoUserWithMailOrusername();
            /**
             * Si le retour n'est pas un objet alors l'utilisateur a rentrée une valeur qui n'existe pas 
             * dans la base de données donc on associe un message d'erreur à la clé mailUsername de notre tableau $formErrors.
             * Sinon on passe aux instructions suivantes.
             */
            if (is_object($userInfo)) {
                /**
                 * On vérifie que le mot de passe de l'utilisateur correspond bien avec celui qu'il a entré lors de 
                 * son inscription à l'aide de la fonction password_verif qui nous permet de comparer une donnée
                 * hashé(mot de passe enregistrer dans notre base de données) et une donnée non hashé(la valeur entré par l'utilisateur).
                 * Si les mots de passe correspondent on génère un hash en appelant une méthode statique de notre class randomHash
                 * grâce au "::". On stocke dans l'attribut tokenHash de notre objet $user le hash créé plus tôt.
                 * On stocke dans l'attribut id de $user et dans la variable de session "userId" l'attribut id de l'objet $userInfo.
                 * On stocke dans la variable de session "username" l'attribut username de l'objet $userInfo.
                 * On stocke dans la variable de session "tokenHash" la valeur de l'attibut tokenHash de l'objet $user donc
                 * du hash généré précèdemment. Sinon on associe un message d'erreur à la clé password de notre tableau $formErrors.
                 */
                if (password_verify($_POST['password'], $userInfo->password)) { 
                    $user->tokenHash = randomHash::generateHash();
                    $user->id = $userInfo->id;
                    $_SESSION['userId'] = $userInfo->id;
                    $_SESSION['username'] = $userInfo->username;
                    $_SESSION['tokenHash'] = $user->tokenHash;
                    /**
                     * Si la méthode uptadeTokenHash de l'objet $user renvoie true alors on redirige 
                     * l'utilisateur vers notre page d'accueil.
                     * Sinon on associe un message d'erreur à la clé password de notre tableau $formErrors
                     */
                    if($user->uptadeTokenHash()){
                        header('location: ../index.php');
                        
                    }else{
                        $formErrors['password'] = 'Problème lors de la connexion.';
                    }
                    
                } else {
                    $formErrors['password'] = 'Mot de passe incorrect.';
                }
            } else {
                $formErrors['mailUsername'] = 'Nom d\'utilisateur ou adresse mail incorrect.';
            }
        }
    }
}
