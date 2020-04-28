<?php
if (!isset($url)) {
    include_once '../controllers/headerCtrl.php';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no" />
        <?php if ($url == '/views/accident.php' || $url == '/index.php' || $url == '/') { ?>
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
                  integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
                  crossorigin="" />
              <?php } ?>
        <link href="<?php
        if ($url == '/' || $url == '/index.php') {
            echo '/assets/FontAwesome/css/all.css';
        } else {
            echo '../assets/FontAwesome/css/all.css';
        }
        ?>" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="<?php
        if ($url == '/' || $url == '/index.php') {
            echo '/assets/css/style.css';
        } else {
            echo '../assets/css/style.css';
        }
        ?>" />
        <title><?= $tittle ?></title>
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark row">
                <div class="navElements">
                    <a class="navbar-brand" href="/index.php">car crash</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item <?= addActive($url, '/index.php') ?>">
                                <a class="nav-link" href="/index.php">accueil <?= addSpanCurrent($url, '/index.php') ?></a>
                            </li>
                            <?php if(isset($_SESSION['userId'])){ ?>
                            <li class="nav-item <?= addActive($url, '/views/accident.php') ?>">
                                <a class="nav-link" href="/views/accident.php">renseigner un accident  <i class="fas fa-car-crash"></i> <?= addSpanCurrent($url, '/views/accident.php') ?></a>
                            </li>
                            <?php } ?>
                            <li class="nav-item <?= addActive($url, '/views/forum.php') ?>">
                                <a class="nav-link" href="/views/forum.php">forum  <i class="fas fa-comments"></i> <?= addSpanCurrent($url, '/views/forum.php') ?></a>
                            </li>
                            <li class="nav-item <?= addActive($url, '/views/contact.php') ?>">
                                <a class="nav-link" href="/views/contact.php">contact   <i class="fas fa-envelope"></i><?= addSpanCurrent($url, '/views/contact.php') ?></a>
                            </li>
                            <?php if (!isset($_SESSION['userId'])) { ?>
                                <li class="nav-item <?=
                                addActive($url, '/views/connection.php');
                                echo addActive($url, '/views/inscription.php')
                                ?>">
                                    <a class="nav-link" href="/views/connection.php">connexion / inscription <?=
                                        addSpanCurrent($url, '/views/connection.php');
                                        echo addSpanCurrent($url, '/view/inscription.php')
                                        ?></a>
                                </li>   
                            <?php } else { ?>
                                <li class="nav-item <?= addActive($url, '/views/profil.php') ?>">
                                    <a class="nav-link" href="/views/profil.php"> <?=
                                        $_SESSION['username'];
                                        addSpanCurrent($url, '/views/profil.php')
                                        ?>  <i class="far fa-user"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="?action=disconnect">deconnexion  <i class="fas fa-exclamation-triangle"></i></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
            </nav>
                                    