<?php
$tittle = 'Validation|Car Crash';
include_once 'header.php';
include_once '../helpers/const.php';
include_once '../helpers/randomHash.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../controllers/accountValidationCtrl.php';
?>
<div class="smallContainer">
    <h1 class="h1">Validation de compte</h1>
    <p class="<?= $messageClass ?>"><?= $message ?></p>
    <?php if ($messageClass == 'text-success') { ?> 
    <p>Vous pouvez cliquer sur le bouton suivant pour vous connecter : <a class="btn btn-success" href="/views/connection.php">Se connecter</a></p>
    <?php } elseif (isset($userInfo) && is_object($userInfo)) { ?>
        <form action="accountValidation.php?validationHash=<?php
        if (isset($_GET['validationHash'])) {
            echo $_GET['validationHash'];
        }
        ?>&mail=<?php
              if (isset($_GET['mail'])) {
                  echo $_GET['mail'];
              }
              ?>" method="POST">
            <div class="form-group">
                <label for="mail">Reconfirmé votre adresse mail</label>
                <input id="mail" name="mail" type="mail" class="form-control" />
                <input value="reconfirmer votre adresse" type="submit" class="btn btn-success" name="submitForm"/>
            </div>
        </form>
    <?php } ?>
</div>
<?php
include_once 'footer.php';
?>

