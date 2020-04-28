<?php
include_once 'header.php';
?>
<div class="smallContainer">
    <h1 class="h1"><?php
        if (isset($_SESSION['username'])) {
            echo $_SESSION['username'];
        } else {
            echo 'Bienvenue';
        }
        ?></h1>
    <?php if ($_SESSION['userId'] == 27) { ?>
        <p>Ceci est un compte de test vous ne pouvez pas modifiez ses informations</p>
    <?php } ?>
    <div class="container-fluid"> 
        <div class="row pt-5">
            <div class="col-md-6 col-sm-12">
                <ul>
                    <li class="mb-3 ml-md-5">Adresse mail : <?= $userInfo->mail ?></li>
                    <li class="mb-3 ml-md-5">Nom d'utilisateur : <?= $userInfo->username ?></li>
                    <li class="mb-3 ml-md-5">Compte créer le : <?= $userInfo->createdAt ?></li>
                    <li class="mb-3 ml-md-5">Mot de passe : ************</li>
                </ul>
                <div class="row">
                    <button class="btn btn-info offset-md-2 col-md-8 mb-5" id="buttonDisplayInfoForm">Modifier vos information</button>
                </div>
                <div class="row">
                    <button class="btn btn-info offset-md-2 col-md-8 mb-5" id="buttonDisplayPasswordForm">Modifier votre mot de passe</button>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 formContainer" id="changeInfoFormContainer">
                <form action="/views/profil.php" method="POST" class="formChangeData">
                    <div class="form-group row m-0">
                        <label for="mail" class="col-sm-12 col-md-5 text-sm-left text-md-right">Nouvelle adresse mail :</label>
                        <input type="mail" name="mail" id="mail" class="form-control col-sm-12 col-md-7" placeholder="JeanDupont@gmail.com" value="<?php
                        if (isset($_POST['mail']) && isset($formErrors)) {
                            echo $_POST['mail'];
                        } else {
                            echo $userInfo->mail;
                        }
                        ?>" />
                    </div>
                    <div class="row m-0 mb-2 mt-1 text-center">
                        <p class="col-md-12 text-danger" id="mailMessage">
                            <?php
                            if (isset($formErrors['mail']) && !isset($_GET['formMailValue'])) {
                                echo $formErrors['mail'];
                            }
                            ?>
                        </p>
                    </div>
                    <div class="form-group row m-0">
                        <label for="username" class="col-sm-12 col-md-5 text-sm-left text-md-right">Nouveau nom d'utilisateur :</label>
                        <input type="text" name="username" id="username" class="form-control col-sm-12 col-md-7" placeholder="XxdarkSasukedu93xX" value="<?php
                        if (isset($_POST['username']) && isset($formErrors)) {
                            echo $_POST['username'];
                        } else {
                            echo $userInfo->username;
                        }
                        ?>" />
                    </div>
                    <div class="row m-0 mb-2 mt-1 text-center">
                        <p class="col-md-12 text-danger" id="usernameMessage">
                            <?php
                            if (isset($formErrors['username']) && !isset($_GET['formUsernameValue'])) {
                                echo $formErrors['username'];
                            }
                            ?>
                        </p>
                    </div>
                    <div class="form-group row m-0">
                        <label for="password" class="col-sm-12 col-md-5 text-sm-left text-md-right">Mot de passe :</label>
                        <input type="password" name="password" id="password" class="form-control col-sm-12 col-md-7">
                    </div>
                    <div class="row">
                        <small class="text-center text-info offset-md-1 offset-sm-0 col-md-11 col-sm-12">Mot de passe pour valider</small>
                    </div>
                    <div class="row m-0 mb-2 mt-1 text-center" >
                        <p class="col-md-12 text-danger">
                            <?php
                            if (isset($formErrors['password'])) {
                                echo $formErrors['password'];
                            }
                            ?>
                        </p>
                    </div>
                    <div class="row m-0 mb-5">
                        <input type="submit" name="submitForm" value="Sauvegarder" class="btn btn-info offset-md-3 col-md-6 col-sm-12" />
                    </div>
                </form>
            </div>
            <div class="col-md-6 col-sm-12 formContainer" id="changePasswordFormContainer">
                <form action="/views/profil.php" method="POST" class="formChangeData">
                    <div class="form-group row m-0" id="formGroupPassword">
                        <label for="newPassword" class="col-sm-12 col-md-5 text-sm-left text-md-right">Nouveau mot de passe : </label>
                        <input type="password" name="newPassword" id="newPassword" class="form-control col-sm-12 col-md-7" />
                    </div>
                    <div class="row m-0">
                        <div id="progressVerifPassword" class="offset-md-5 offset-sm-0"></div>
                    </div>
                    <div class="row m-0 mb-2 mt-1 text-center">
                        <p class="col-md-12 text-danger" id="messageNewPassword">
                            <?php
                            if (isset($formErrors['newPassword'])) {
                                echo $formErrors['newPassword'];
                            }
                            ?>
                        </p>
                    </div>
                    <div class="form-group row m-0">
                        <label for="verifNewPassword" class="col-sm-12 col-md-5 text-sm-left text-md-right">Vérification nouveau mot de passe : </label>
                        <input type="password" name="verifNewPassword" id="verifNewPassword" class="form-control col-sm-12 col-md-7" />
                    </div>
                    <div class="row m-0 mb-2 mt-1 text-center" >
                        <p class="col-md-12 text-danger">
                            <?php
                            if (isset($formErrors['verifNewPassword'])) {
                                echo $formErrors['verifNewPassword'];
                            }
                            ?>
                        </p>
                    </div>
                    <div class="form-group row m-0">
                        <label for="ancientPassword" class="col-sm-12 col-md-5 text-sm-left text-md-right">Mot de passe actuel :</label>
                        <input type="password" name="ancientPassword" id="ancientPassword" class="form-control col-sm-12 col-md-7">
                    </div>
                    <div class="row">
                        <small class="text-center text-info offset-md-1 offset-sm-0 col-md-11 col-sm-12">Mot de passe pour valider</small>
                    </div>
                    <div class="row m-0 mb-2 mt-1 text-center" >
                        <p class="col-md-12 text-danger">
                            <?php
                            if (isset($formErrors['ancientPassword'])) {
                                echo $formErrors['ancientPassword'];
                            }
                            ?>
                        </p>
                    </div>
                    <div class="row m-0 mb-5">
                        <input type="submit" name="submitFormPassword" value="Sauvegarder" class="btn btn-info offset-md-3 col-md-6 col-sm-12" />
                    </div>
                </form>
            </div>
            <?php if (isset($_POST['submitForm']) || isset($_POST['submitFormPassword'])) { ?>
                <div class="row">
                    <p class="col-md-12 text-center <?= $endMessageClass ?>"><?= $endMessage ?></p>

                </div>
            <?php } ?>
        </div>
        <div class="row d-flex justify-content-around">
            <a href="?action=disconnect" class="col-md-4 mb-4 col-sm-12 btn btn-danger">Déconnexion</a>
            <button class="btn btn-danger col-md-4 col-sm-12 mb-4" data-toggle="modal" data-target="#deleteModal">Supprimer</button>
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteMoal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="text-danger h2">Supprimer</h2>
                            <button type="button" class="close text-right" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/views/profil.php" method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row m-0">
                                        <p>Voulez vous vraiment supprimer votre compte ?</p>
                                    </div>
                                    <div class="row m-0">
                                        <label for="oui" class="col-2">Oui</label><input name="deleteUser" id="oui" value="oui" type="radio" class="col-1" />
                                        <label for="non" class=" offset-3 col-2">Non</label><input name="deleteUser" id="non" value="non" type="radio" checked class="col-1" />
                                    </div>
                                </div> 
                            </div>
                            <div class="modal-footer justify-content-around">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="submit" name="submitFormDelete" value="Supprimer" class="btn btn-danger" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once 'footer.php';
