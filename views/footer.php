<?php
if ($url == '/index.php' || $url == '/') {
    include_once 'controllers/footerCtrl.php';
} else {
    include_once '../controllers/footerCtrl.php';
}
?>
<footer class="row d-flex justify-content-between">
    <div class="col-md-3 col-sm-12">
        <h2 class="h2">Où nous trouver ?</h2>
        <p>CarCrash<br />
            112 rue Pasteur<br />
            60320 Béthisy Saint Martin<br />
            07 82 20 99 87<br />
            Du Lundi au jeudi de 14h à 17h30</p>
    </div>
    <div class="col-md-3 col-sm-12">
        |<br />
        |<br />
        |<br />
        |
    </div>
    <div class="col-md-3 col-sm-12">
        |<br />
        |<br />
        |<br />
        |
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<?php if($url == '/index.php' || $url == '/' || $url == '/views/accident.php'){ ?>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
        integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
crossorigin=""></script>
<?php } ?>
<script src="<?= $loadedScript ?>"></script>
</body>
</html>