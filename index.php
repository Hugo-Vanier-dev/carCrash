<?php
include_once 'controllers/headerCtrl.php';
include_once 'views/header.php';
?>
<div class="smallContainer">
    <h1 class="text-danger">Le site est en cours de développement</h1>
    <p class="text-danger">Certaines fonctionnalitées ne marchent pas encore.</p>
    <p>CarCrash est un projet participatif qui a pour but de recenser les zones accidentogenes en France.<br/>Ainsi une fois les zones aux forts taux d'accident identifiées les conducteurs pourront faire preuves de plus de prudence dans ces zones.</p>
    <div class="row">
        <div id="map" class="col-12 col-md-6"></div>
        <div class="col-12 col-md-6">
            <ul>
                <li class="mt-4">Aujourd'hui il y a <?= $numberOfUsers ?> inscrits sur carCrash.</li>
                <li class="mt-4"><?= $numberOfAccidents ?> accidents ont déjà été recensés sur carCrash.</li>
            </ul>
        </div>
    </div>
    <p>Pour renseigner un accident vous devez être connectez</p>
    <div class="row w-100 d-flex justify-content-center">
        <a class="col-12 col-md-6" href="views/connection.php"><button class="btn btn-info w-100">Se connecter</button></a>
    </div>
</div>
<?php
include_once 'views/footer.php';
