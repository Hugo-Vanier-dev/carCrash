<?php
if($url == '/views/inscription.php'){
    $loadedScript = '../assets/js/inscription.js';
}elseif($url == '/views/connection.php'){
    $loadedScript = '../assets/js/connection.js';
}elseif ($url == '/views/profil.php') {
    $loadedScript = '../assets/js/profil.js';
}elseif($url == '/views/accident.php'){
    $loadedScript = '../assets/js/accident.js';
}elseif ($url == '/index.php' || $url == '/') {
    $loadedScript = 'assets/js/index.js';
}