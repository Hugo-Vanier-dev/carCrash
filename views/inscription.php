<?php
include_once 'header.php';
?>
<div class="container-fluid">
    <div class="smallContainer">
        <h1 class="h1">Inscrivez vous</h1>
        <form action="/views/inscription.php" method="POST" class="pb-5 pt-5 formBox">
            <div class="form-group row m-0">
                <label for="mail" class="col-sm-12 col-md-4 text-sm-left text-md-right">Adresse mail :</label>
                <input type="mail" name="mail" id="mail" class="form-control col-sm-12 col-md-8" placeholder="JeanDupont@gmail.com" value="<?php
                if (isset($_POST['mail']) && isset($formErrors)) {
                    echo $_POST['mail'];
                }
                ?>" />
            </div>
            <div class="row m-0 mb-5 mt-1 text-center">
                <p class="col-md-12 text-danger" id="mailMessage">
                    <?php
                    if (isset($formErrors['mail']) && !isset($_GET['formMailValue'])) {
                        echo $formErrors['mail'];
                    }
                    ?>
                </p>
            </div>
            <div class="form-group row m-0">
                <label for="username" class="col-sm-12 col-md-4 text-sm-left text-md-right">Nom d'utilisateur :</label>
                <input type="text" name="username" id="username" class="form-control col-sm-12 col-md-8" placeholder="XxdarkSasukedu93xX" value="<?php
                if (isset($_POST['username']) && isset($formErrors)) {
                    echo $_POST['username'];
                }
                ?>" />
            </div>
            <div class="row m-0 mb-5 mt-1 text-center">
                <p class="col-md-12 text-danger" id="usernameMessage">
                    <?php
                    if (isset($formErrors['username']) && !isset($_GET['formUsernameValue'])) {
                        echo $formErrors['username'];
                    }
                    ?>
                </p>
            </div>
            <div class="form-group row m-0" id="formGroupPassword">
                <label for="password" class="col-sm-12 col-md-4 text-sm-left text-md-right">Mot de passe :</label>
                <input type="password" name="password" id="password" class="form-control col-sm-12 col-md-8">
            </div>
            <div class="row m-0">
                <div id="progressVerifPassword" class="offset-md-4 offset-sm-0"></div>
            </div>
            <div class="row m-0 mb-5 mt-1 text-center" >
                <p class="col-md-12 text-danger" id="messageErrorPassword">
                    <?php
                    if (isset($formErrors['password'])) {
                        echo $formErrors['password'];
                    }
                    ?>
                </p>
            </div>
            <div class="form-group row m-0">
                <label for="verifPassword" class="col-sm-12 col-md-4 text-sm-left text-md-right">Vérifier le mot de passe :</label>
                <input type="password" name="verifPassword" id="verifPassword" class="form-control col-sm-12 col-md-8">
            </div>
            <div class="row m-0 mb-5 mt-1 text-center">
                <p class="col-md-12 text-danger"><?php
                    if (isset($formErrors['verifPassword'])) {
                        echo $formErrors['verifPassword'];
                    }
                    ?>
            </div>
            </p>
            <?php if (isset($_POST['submitForm'])) { ?>
                <div class="row">
                    <p class="col-md-12 text-center <?= $endMessageClass ?>"><?= $endMessage ?></p>
                </div>
            <?php } ?>
            <div class="row m-0 mb-5">
                <input type="submit" name="submitForm" value="S'inscrire" class="btn btn-success offset-md-3 col-md-6 col-sm-12" />
            </div>
            <div class="row">
                <a href="/views/connection.php" class="col-12 text-center">Déjà inscrit, connecte toi</a>
            </div>
        </form>
    </div>
</div>
<?php
include_once 'footer.php';
