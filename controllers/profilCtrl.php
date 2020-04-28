<?php

/**
 * On vérifie si notre $_GET['formMailValue'] existe.
 * Si c'est le cas c'est que une requète ajax a été initialisé.
 * On stocke un tableau vide dans une variable.
 * On stockera notre reponse au fichier js dans ce tableau
 */
if (isset($_GET['formMailValue'])) {
    $responseToAjax = array();
    /**
     * Si le $_GET['formMailValue'] n'est pas vide, on include les fichier dont on va avoir
     * besoin pour vérifier la donnée entrée puis on démarre une session. Si le champ est vide
     * on associe un message d'erreur et un status d'erreur au clé message et status de
     * notre tableau de réponse ajax.
     */
    if (!empty($_GET['formMailValue'])) {
        include_once '../helpers/const.php';
        include_once '../helpers/formHelper.php';
        include_once '../models/database.php';
        include_once '../models/users.php';
        session_start();
        /**
         * On vérifie que notre variable de session "userId" existe (ce n'est normalement 
         * pas possible qu'elle n'existe pas sauf si l'utilisateur a supprimer sa variable de 
         * session apres être arrivé sur la page). Si elle existe on instancie une nouvel objet
         * $checkForm à partir de notre class formHelper. Puis on stocke dans les attributs
         * fieldName et postValue de l'objet $checkForm les valeurs "id" et la valeur entrée 
         * par l'utilisateur.
         */
        if (isset($_SESSION['userId'])) {
            $checkForm = new formHelper();
            $checkForm->fieldName = 'int';
            $checkForm->postValue = htmlspecialchars($_SESSION['userId']);
            /**
             * On appelle la méthode checkFormEnter de notre objet $checkForm si elle renvoie true
             * (que la valeur de la variable de session "userId" ait une valeur attendue).
             * Alors on instancie un nouvel objet $userB à partir de notre class users.
             * On stocke dans l'attribut id de l'objet $userB la valeur de la variable de session
             * "userId". Puis on stocke le retour de la méthode getAllInfoUserWithId de l'objet
             * $userB dans un objet $userInfo.
             */
            if ($checkForm->checkFormEnter()) {
                $userB = new users();
                $userB->id = htmlspecialchars($_SESSION['userId']);
                $userInfo = $userB->getAllInfoUserWithId();
            }
        }
        /**
         * On instancie un nouvel objet $user à partir de la class users. 
         * On donne aux attribut fieldName et postValue de l'objet $checkForm les valeurs
         * "mail" et la valeur entrée par l'utilisateur.
         */
        $user = new users();
        $checkForm->fieldName = 'mail';
        $checkForm->postValue = htmlspecialchars($_GET['formMailValue']);
        /**
         * On vérifie que la valeur entré par l'utilisateur est bien un mail grâce au
         * retour de notre méthode checkFormEnter. Si c'est le cas on stocke dans 
         * l'attribut mail de notre objet $user la valeur entrée par l'utilisateur.
         * Si ce n'ets pas le cas on associe un message d'erreur et un status d'erreur 
         * au clé message et status de notre tableau de réponse ajax.
         */
        if ($checkForm->checkFormEnter()) {
            $user->mail = htmlspecialchars($_GET['formMailValue']);
            /**
             * On vérifie que le mail entré par l'utilisateur n'est pas le même que celui
             * déjà enregistrer dans notre base de données. Si c'est le cas on associe un 
             * message vide et status de succes à notre réponse ajax. Sinon on stocke
             * dans la variable $mailexist le retour de la méthode checkmail de l'objet $user.
             */
            if ($userInfo->mail != $user->mail) {
                $mailExist = $user->checkMail();
                /**
                 * Si le mail rentré par l'utilisateur n'est pas déjà dans notre base de données,
                 * alors on associe un message de réussite et un status de succes à notre 
                 * réponse ajax. Sinon on associe un message d'erreur et un status d'erreur à notre
                 * réponse ajax.
                 */
                if (!$mailExist->mailExist) {
                    $responseToAjax['message'] = 'Le mail est valide';
                    $responseToAjax['status'] = 'success';
                } else {
                    $responseToAjax['message'] = 'Cette adresse mail est déjà utilisée';
                    $responseToAjax['status'] = 'error';
                }
            } else {
                $responseToAjax['message'] = '';
                $responseToAjax['status'] = 'success';
            }
        } else {
            $responseToAjax['message'] = 'Cette adresse mail n\'est pas valide';
            $responseToAjax['status'] = 'error';
        }
    } else {
        $responseToAjax['message'] = 'Veuillez renseigner une adresse mail';
        $responseToAjax['status'] = 'error';
    }
    /**
     * On précise à notre javascript que la réponse est du json et on echo la réponse pour
     * la renvoyé à notre fichier javascript.
     */
    header('Content-Type: application/json');
    echo json_encode($responseToAjax);
    /**
     * Exactement le même principe que pour la gestion du mail en ajax
     * mais cette foi-ci avec le username.
     */
} elseif (isset($_GET['formUsernameValue'])) {
    $responseToAjax = array();
    if (!empty($_GET['formUsernameValue'])) {
        include_once '../helpers/const.php';
        include_once '../helpers/formHelper.php';
        include_once '../models/database.php';
        include_once '../models/users.php';
        session_start();
        if (isset($_SESSION['userId'])) {
            $userB = new users();
            $userB->id = htmlspecialchars($_SESSION['userId']);
            $userInfo = $userB->getAllInfoUserWithId();
        }
        $user = new users();
        $user->username = htmlspecialchars($_GET['formUsernameValue']);
        if ($user->username != $userInfo->username) {
            $usernameExist = $user->checkUsername();
            if (!$usernameExist->usernameExist) {
                $responseToAjax['message'] = 'Le nom d\'utilisateur est valide';
                $responseToAjax['status'] = 'success';
            } else {
                $responseToAjax['message'] = 'Ce nom d\'utilisateur est déjà utilisé';
                $responseToAjax['status'] = 'error';
            }
        } else {
            $responseToAjax['message'] = '';
            $responseToAjax['status'] = 'success';
        }
    } else {
        $responseToAjax['message'] = 'Veuillez renseigner un nom d\'utilisateur';
        $responseToAjax['status'] = 'error';
    }
    header('Content-Type: application/json');
    echo json_encode($responseToAjax);
} else {
    /**
     * On vérifie que la variable de session "userId" existe. Si c'est le cas, on instancie
     * deux nouveaux objet un $user à partir de la class users et un $checkForm à partir
     * de la class formHelper. On attribut au attribut fieldName et postValue de l'objet
     * $checkForm les valeurs "id" et la valeur de la variable de session "userId".
     * Si la variable de session n'existe pas on deconnect l'utilisateur ce qui le 
     * renverra vers la page d'accueil.
     */
    if (isset($_SESSION['userId'])) {
        $user = new users();
        $checkForm = new formHelper();
        $checkForm->fieldName = 'int';
        $checkForm->postValue = htmlspecialchars($_SESSION['userId']);
        /**
         * Si le retour de notre méthode checkFormEnter vaut true, on stocke dans l'attribut
         * id de notre objet user la valeur de la variable de session "userId".
         * Puis on stocke dans une variable $userHash le retour de la méthode getTheHashWithId.
         */
        if ($checkForm->checkFormEnter()) {
            $user->id = htmlspecialchars($_SESSION['userId']);
            $userHash = $user->getTheHashWithId();
            /**
             * Si le tokenHash de la session et celui enregistrer dans la base de données correspondent,
             * on passe aux instructions. Sinon on deconnect l'utilisateur ce qui le renverra sur la page
             * d'accueil.
             */
            if ($userHash->tokenHash == $_SESSION['tokenHash']) {
                /**
                 * Si le formulaire pour changer son adresse mail et/ou son nom d'utilisateur a été
                 * envoyé. On stocke dans deux variables $endMessage et $endMessageClass un message
                 * et ça class.
                 */
                if (isset($_POST['submitForm'])) {
                    $endMessage = 'Il y a eu un problème lors du changement des données';
                    $endMessageClass = 'text-danger';
                    /**
                     * On vérifie que le champs username n'est pas vide, si c'est le cas on stocke
                     * dans l'attribut username de notre objet $user la valeur entrée par l'utilisateur.
                     * Sinon on associe à la clé username de notre tableau $formErrors un message d'erreur.
                     */
                    if (!empty($_POST['username'])) {
                        $user->username = htmlspecialchars($_POST['username']);
                    } else {
                        $formErrors['username'] = 'Veuillez entrez un nouveau nom d\'utilisateur';
                    }
                    /**
                     * Pareil pour le mail sauf que l'on vérifie en plus que la donnée entrée est du bon type.
                     */
                    if (!empty($_POST['mail'])) {
                        $checkForm->fieldName = 'mail';
                        $checkForm->postValue = $_POST['mail'];
                        if ($checkForm->checkFormEnter()) {
                            $user->mail = htmlspecialchars($_POST['mail']);
                        } else {
                            $formErrors['mail'] = 'L\'adresse mail renseignée n\'est pas valide';
                        }
                    } else {
                        $formErrors['mail'] = 'Veuillez renseigner une adresse mail';
                    }

                    /**
                     * Si il n'y a pas eu d'erreur dans les données entrées par l'utilisateur, on stocke
                     * dans la variable $userInfo le retour de la méthode getAllInfoUserWithId et on change
                     * la valeur de la variable $endMessage.
                     */
                    if (!isset($formErrors) && $_SESSION['userId'] != 27) {
                        $userInfo = $user->getAllInfoUserWithId();
                        $endMessage = 'Mot de passe incorrect';
                        /**
                         * On vérifie que le mot de passe de l'utilisateur correspond bien avec celui qu'il a entré lors de 
                         * son inscription à l'aide de la fonction password_verif qui nous permet de comparer une donnée
                         * hashé(mot de passe enregistrer dans notre base de données) et une donnée non hashé(la valeur entré par l'utilisateur).
                         */
                        if (password_verify($_POST['password'], $userInfo->password)) {
                            $user->updateAUserMailAndUsername();
                            $endMessage = 'Nous avons bien mis à jour votre profil.';
                            $endMessageClass = 'text-success';
                        }
                    }
                    /**
                     * On vérifie si le formulaire pour changer son mot de passe a été envoyé, si c'est le cas on stocke dans deux variables
                     * un message d'erreur et sa class
                     */
                }if (isset($_POST['submitFormPassword'])) {
                    $endMessage = 'Il y a eu un problème lors du changement';
                    $endMessageClass = 'text-danger';
                    /**
                     * On vérifie que les champs newPassword, verifNewPassword et ancientPassword ont bien été remplis.
                     * Si ce n'est pas le cas on stocke dans notre tableau $formErrors des messages d'erreur.
                     */
                    if (empty($_POST['newPassword'])) {
                        $formErrors['newPassword'] = 'Veuillez choisir un nouveau mot de passe.';
                    }
                    if (empty($_POST['verifNewPassword'])) {
                        $formErrors['verifNewPassword'] = 'Veuillez vérifier votre nouveau mot de passe';
                    }
                    if (empty($_POST['ancientPassword'])) {
                        $formErrors['ancientPassword'] = 'Veulliez entrer votre mot de passe pour pouvoir le changer';
                    }
                    /**
                     * Si notre tableau $formErrors n'existe pas on stocke dans l'objet $userInfo le retour de la méthode getAllInfoUserWithId.
                     */
                    if (!isset($formErrors) && $_SESSION['userId'] != 27) {
                        $userInfo = $user->getAllInfoUserWithId();
                        /**
                         * On vérifie que le mot de passe qu'il avait avant de vouloir changer correspond bien à celui enregistré dans notre base de données.
                         * Si ce n'est pas le cas on stocke dans notre tableau $formErrors un message d'erreur. 
                         */
                        if (password_verify($_POST['ancientPassword'], $userInfo->password)) {
                            /**
                             * On vérifie que le mot de passe fais au moins 12 caractères, si ce n'est pas le cas on stocke 
                             * dans notre tableau $formErrors un message d'erreur.
                             */
                            if (strlen($_POST['newPassword']) >= 12) {
                                /**
                                 * On vérifie que les valeur des champ nouveau mot de passe et vérifier votre nouveau mot de passe correspondent.
                                 * Si c'est le cas on hash le nouveau mot de passe de l'utilisateur puis on le stocke dans l'attribut
                                 * password de l'objet $user. On fait ensuite appelle à la méthode updateAUserPassword pour changer le mot de passe
                                 * enregistrer dans la basse de données. Enfin on change les valeurs de $endMessage et $endMessageClass.
                                 */
                                if ($_POST['newPassword'] == $_POST['verifNewPassword']) {
                                    $user->password = password_hash($_POST['newPassword'], PASSWORD_BCRYPT);
                                    $user->updateAUserPassword();
                                    $endMessage = 'Le changement a bien été pris en compte';
                                    $endMessageClass = 'text-success';
                                } else {
                                    $formErrors['newPassword'] = 'Votre nouveau mot de passe et la vérification de mot de passe ne correspondent pas';
                                }
                            } else {
                                $formErrors['newPassword'] = 'Votre nouveau mot de passe doit faire au moins 12 caractères';
                            }
                        } else {
                            $formErrors['ancientPassword'] = 'Mot de passe incorrect';
                        }
                    }
                    /**
                     * Si le formulaire de suppression a été envoyé
                     */
                } if (isset($_POST['submitFormDelete'])) {
                    /**
                     * Si le $_POST['deleteUser'] n'existe pas on redirige l'utilisateur sur la page d'acccueil.
                     */
                    if (!empty($_POST['deleteUser'])) {
                        /**
                         * Si la valeur de $_POST['deleteUser'] vaut oui 
                         */
                        if ($_POST['deleteUser'] == 'oui' && $_SESSION['userId'] != 27) {
                            /**
                             * Si la méthode deleteUserWithHisId vaut true on stocke dans nos attribut id et tokenHash de l'objet $user
                             * les valeurs $_SESSION['userId'] et null. Puis on lance notre méthode pour supprimer un utilisateur.
                             * On détruit toutes nos variables de session et on redirige l'utilisateur sur la page d'accueil.
                             * Sinon on change la valeur du $endMessage.
                             */
                            if ($user->deleteUserWithHisId()) {
                                $user->id = $_SESSION['userId'];
                                $user->tokenHash = null;
                                $user->uptadeTokenHash();
                                unset($_SESSION['tokenHash']);
                                unset($_SESSION['userId']);
                                unset($_SESSION['username']);
                                header('location: ../index.php');
                            } else {
                                $endMessage = 'Il y a eu un problème lors de la suppression de votre compte';
                            }
                        }
                    } else {
                        header('location: ../index.php');
                    }
                }
                $userInfo = $user->getAllInfoUserWithId();
                if (!is_object($userInfo)) {
                    header('location: ../index.php?action=disconnect');
                }
            } else {
                header('location: ../index.php?action=disconnect');
            }
        } else {

            header('location: ../index.php?action=disconnect');
        }
    } else {

        header('location: ../index.php?action=disconnect');
    }
}

