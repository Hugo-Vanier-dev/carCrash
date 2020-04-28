<?php
include_once 'header.php';
?>
<div class="container-fluid">
    <div class="smallContainer">
        <h1 class="h1">Connectez vous</h1>
        <form action="/views/connection.php" method="POST" class="pb-5 pt-5 formBox">
            <div class="form-group">
                <div class="row m-0">
                    <label for="mailUsername" class="col-12 text-sm-left">Adresse mail ou nom d'utilisateur :</label>
                </div>
                <div class="row m-0">
                    <input type="text" name="mailUsername" id="mailUsername" class="form-control col-sm-12 offset-sm-0 offset-md-4 col-md-8" placeholder="JeanDupont@gmail.com" value="<?php
                    if(isset($_SESSION['username'])){
                        echo $_SESSION['username'];
                    }
                    elseif (isset($_POST['mailUsername']) && isset($formErrors)) {
                        echo $_POST['mailUsername'];
                    }
                    ?>" />
                </div>
            </div>
            <div class="row m-0 mb-5 mt-1 text-center">
                <p class="col-md-12 text-danger" id="mailUsernameMessage">
                    <?php
                    if (isset($formErrors['mailUsername']) && !isset($_GET['formMailUsernameValue'])) {
                        echo $formErrors['mailUsername'];
                    }
                    ?>
                </p>
            </div>
            <div class="form-group row m-0" id="formGroupPassword">
                <label for="password" class="col-sm-12 col-md-4 text-sm-left text-md-right">Mot de passe :</label>
                <input type="password" name="password" id="password" class="form-control col-sm-12 col-md-8">
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
            <div class="row m-0 mb-5">
                <input type="submit" name="submitForm" value="Se connecter" class="btn btn-success offset-md-3 col-md-6 col-sm-12" />               
            </div>
            <div class="row">                
                <a href="/views/inscription.php" class="col-12 text-center">Pas encore inscrit ?</a>
            </div>
        </form>
        <button class="btn btn-info col-md-5 col-sm-12 mt-5" id="testButton">Utilisez un compte de test</button>
    </div>
</div>
<?php
include_once 'footer.php';
?>