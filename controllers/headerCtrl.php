<?php
$regexvalidationUrl = '/^\/views\/accountValidation.php$/';
session_start();
if (isset($_SERVER['REQUEST_URI'])) {
    $url = $_SERVER['REQUEST_URI'];
}
if ($url == '/index.php' || $url == '/') {

    $tittle = 'Accueil|Car Crash';
    include_once 'helpers/const.php';
    include_once 'models/database.php';
    include_once 'models/users.php';
    include_once 'models/accidents.php';
    include_once 'controllers/indexCtrl.php';
} elseif ($url == '/views/map.php') {

    $tittle = 'Carte|Car Crash';
} elseif ($url == '/views/accident.php') {

    $tittle = 'Accident|Car Crash';
    
    include_once '../helpers/const.php';
    include_once '../helpers/formHelper.php';
    include_once '../models/database.php';
    include_once '../models/accidents.php';
    include_once '../models/causesAccidentLink.php';
    include_once '../controllers/accidentCtrl.php';
} elseif ($url == '/views/forum.php') {

    $tittle = 'Forum|Car Crash';
} elseif ($url == '/views/connection.php') {

    $tittle = 'Connexion|Car Crash';
    include_once '../helpers/const.php';
    include_once '../helpers/randomHash.php';
    include_once '../models/database.php';
    include_once '../models/users.php';
    include_once '../controllers/connectionCtrl.php';
} elseif ($url == '/views/profil.php') {

    $tittle = 'Carte|Car Crash';
    include_once '../helpers/const.php';
    include_once '../helpers/formHelper.php';
    include_once '../models/database.php';
    include_once '../models/users.php';
    include_once '../controllers/profilCtrl.php';
} elseif ($url == '/views/contact.php') {

    $tittle = 'Contact|Car Crash';
} elseif ($url == '/views/inscription.php') {

    $tittle = 'Inscription|Car Crash';
    include_once '../helpers/const.php';
    include_once '../helpers/randomHash.php';
    include_once '../helpers/formHelper.php';
    include_once '../models/database.php';
    include_once '../models/users.php';
    include_once '../controllers/inscriptionCtrl.php';
}
function addActive($url, $requiredUrl) {
    if ($url == $requiredUrl) {
        return 'active';
    }
}

function addSpanCurrent($url, $requiredUrl) {
    if ($url == $requiredUrl) {
        return '<span class="sr-only">(current)</span>';
    }
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'disconnect') {
        if ($url == '/?action=disconnect' || $url == '/index.php?action=disconnect' || $url == '/' || $url == '/index.php') {
            include_once 'helpers/const.php';
            include_once 'helpers/formHelper.php';
            include_once 'models/database.php';
            include_once 'models/users.php';
        } else {
            include_once '../helpers/const.php';
            include_once '../helpers/formHelper.php';
            include_once '../models/database.php';
            include_once '../models/users.php';
        }
        $user = new users();
        $user->id = $_SESSION['userId'];
        $user->tokenHash = null;
        $user->uptadeTokenHash();
        unset($_SESSION['tokenHash']);
        unset($_SESSION['userId']);
        unset($_SESSION['username']);
        header('location: ../index.php');
    }
}