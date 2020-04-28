<?php
include_once 'header.php';
?>
<div class="smallContainer">
    <h1 class="h1">Renseigner un accident</h1>
    <div class="container">
        <?php if (isset($endMessage)) { ?>
            <p class="text-center <?= $endMessageClass ?>"><?= $endMessage ?></p>
        <?php } ?>
        <form action='/views/accident.php' method="POST" class="ml-2 row">
            <div class="col-md-6 col-sm-12">
                <p>Veuillez séléctionné la zone où a eu lieu l'accident :</p>
                <div id="map" class="mb-4"></div>
                <?php if (isset($formErrors['map'])) { ?>
                    <p class="text-danger"><?= $formErrors['map'] ?></p>
                <?php } ?>
                <div class="row mt-2 form-group">
                    <label for="lightlyInjured" class="col-9">Nombres de bléssés légers :</label>
                    <input type="number" name="lightlyInjured" min="0" id="lightlyInjured" class="col-3 form-control" value="<?php
                    if (isset($_POST['lightlyInjured'])) {
                        echo $_POST['lightlyInjured'];
                    }
                    ?>" />
                </div>
                <?php if (isset($formErrors['lightlyInjured'])) { ?>
                    <p class="text-danger"><?= $formErrors['lightlyInjured'] ?></p>
                <?php } ?>
                <div class="row mt-2 form-group">
                    <label for="badlyInjured" class="col-9">Nombres de bléssés graves :</label>
                    <input type="number" name="badlyInjured" min="0" id="badlyInjured" class="col-3 form-control" value="<?php
                    if (isset($_POST['badlyInjured'])) {
                        echo $_POST['badlyInjured'];
                    }
                    ?>" />
                </div>
                <?php if (isset($formErrors['badlyInjured'])) { ?>
                    <p class="text-danger"><?= $formErrors['badlyInjured'] ?></p>
                <?php } ?>
                <div class="row mt-2 form-group">
                    <label for="deaths" class="col-9">Nombres de morts :</label>
                    <input type="number" name="deaths" id="deaths" min="0" class="col-3 form-control" value="<?php
                    if (isset($_POST['deaths'])) {
                        echo $_POST['deaths'];
                    }
                    ?>"/>
                </div>
                <?php if (isset($formErrors['deaths'])) { ?>
                    <p class="text-danger"><?= $formErrors['deaths'] ?></p>
                <?php } ?>
                <div class="row mt-2 form-group">
                    <label for="date" class="col-md-9 col-sm-12">Cet accident a eu lieu le :</label>
                    <input type="date" name="date" max="<?= $thisYear . '-' . $thisMonth . '-' . $thisDay ?> "id="date" class="col-md-3 col-sm-12 form-control" value="<?php
                    if (isset($_POST['date']) && !isset($formErrors['date'])) {
                        echo $_POST['date'];
                    } else {
                        echo $thisYear . '-' . $thisMonth . '-' . $thisDay;
                    }
                    ?>" />
                </div>
                <?php if (isset($formErrors['date'])) { ?>
                    <p class="text-danger"><?= $formErrors['date'] ?></p>
                <?php } ?>
                <div class="row mt-2 form-group">
                    <label for="time" class="col-md-9 col-sm-12">à :</label>
                    <input type="time" name="time" id="time" class="col-md-3 col-sm-12 form-control" <?php
                    if (isset($_POST['time']) && !isset($formErrors['time'])) {
                        echo $_POST['time'];
                    }
                    ?>  />
                </div>
                <?php if (isset($formErrors['time'])) { ?>
                    <p class="text-danger"><?= $formErrors['time'] ?></p>
                <?php } ?>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row mb-4">
                    <p class="col-12 w-100 text-center" id="messageField">Si vous ne pouvez pas répondre vous pouvez laisser les champs ci-dessous vides</p>
                </div>
                <input type="hidden" name="latitude" id="latitude" />
                <input type="hidden" name="longitude" id="longitude" />
                <input type="hidden" name="city" id="city" />
                <input type="hidden" name="adressOrRoadName" id="adressOrRoadName" />
                <div class="form-group">
                    <div class="row">
                        <label class="col-12" for="causes">Causes probable de l'accident :</label>
                    </div>
                    <div class="row">
                        <small class="col-12">(Plusieurs choix possible)</small>
                    </div>
                    <div class="row mt-4 mb-md-2">
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="speed" class="col-9">Vitesse : </label>
                                <input name="causes[]" id="speed" class="col-3" type="checkbox" value="1" <?php
                                if (isset($_POST['causes'])) {
                                    foreach ($_POST['causes'] as $cause) {
                                        if ($cause == '1') {
                                            echo 'checked';
                                        }
                                    }
                                }
                                ?> />
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="slipperyRoad" class="col-9">Route glissante : </label>
                                <input name="causes[]" id="slipperyRoad" type="checkbox" class="col-3" value="2" <?php
                                if (isset($_POST['causes'])) {
                                    foreach ($_POST['causes'] as $cause) {
                                        if ($cause == '2') {
                                            echo 'checked';
                                        }
                                    }
                                }
                                ?> />
                            </div>
                        </div>
                    </div>    
                    <div class="row mb-md-2">
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="tiredness" class="col-9">Fatigue : </label>
                                <input name="causes[]" id="tiredness" type="checkbox" class="col-3" value="3" <?php
                                if (isset($_POST['causes'])) {
                                    foreach ($_POST['causes'] as $cause) {
                                        if ($cause == '3') {
                                            echo 'checked';
                                        }
                                    }
                                }
                                ?> />
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="inattention" class="col-9">Inattention : </label>
                                <input name="causes[]" id="inattention" class="col-3" type="checkbox" value="4" <?php
                                if (isset($_POST['causes'])) {
                                    foreach ($_POST['causes'] as $cause) {
                                        if ($cause == '4') {
                                            echo 'checked';
                                        }
                                    }
                                }
                                ?> />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-md-2">
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="mecanniqueTrouble" class="col-9">Problème mécannique : </label>
                                <input name="causes[]" id="mecanniqueTrouble" class="col-3" type="checkbox" value="5" <?php
                                if (isset($_POST['causes'])) {
                                    foreach ($_POST['causes'] as $cause) {
                                        if ($cause == '5') {
                                            echo 'checked';
                                        }
                                    }
                                }
                                ?> />
                            </div>
                        </div>    
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="others" class="col-9">Autres : </label>
                                <input name="causes[]" id="others" type="checkbox" class="col-3" value="6" <?php
                                if (isset($_POST['causes'])) {
                                    foreach ($_POST['causes'] as $cause) {
                                        if ($cause == '6') {
                                            echo 'checked';
                                        }
                                    }
                                }
                                ?> />
                            </div>
                        </div>
                    </div>                       
                </div>
                <?php if (isset($formErrors['causes'])) { ?>
                    <p class="text-danger"><?= $formErrors['causes'] ?></p>
                <?php } ?>
                <div class="form-group">
                    <div class="row">
                        <label class="col-12" for="nbCar">Nombre de véhicule impliqué :</label>
                    </div>
                    <div class="row">
                        <small class="col-12">(un seul choix possible choix possible)</small>
                    </div>
                    <div class="row mt-4 mb-md-2">
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="1car" class="col-9">1</label>
                                <input name="nbCar" id="1car" type="radio" class="col-3" value="1" <?php if(isset($_POST['nbCar']) && $_POST['nbCar'] == 1) { echo 'checked'; } ?> />
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="2car" class="col-9">2</label>
                                <input name="nbCar" id="2car" type="radio" class="col-3" value="2" <?php if(isset($_POST['nbCar']) && $_POST['nbCar'] == 2) { echo 'checked'; } ?> />
                            </div>
                        </div>
                    </div>    
                    <div class="row mb-md-2">
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="3to5Car" class="col-9">De 3 à 5</label>
                                <input name="nbCar" id="3to5Car" class="col-3" type="radio" value="3" <?php if(isset($_POST['nbCar']) && $_POST['nbCar'] == 3) { echo 'checked'; } ?> />
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="5to10Car" class="col-9">De 5 à 10</label>
                                <input name="nbCar" id="5to10Car" class="col-3" type="radio" value="4" <?php if(isset($_POST['nbCar']) && $_POST['nbCar'] == 4) { echo 'checked'; } ?> />
                            </div>
                        </div> 
                    </div>
                    <div class="row mb-md-2">
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="moreThan10" class="col-9">10 et +</label>
                                <input name="nbCar" id="moreThan10" type="radio" class="col-3" value="5" <?php if(isset($_POST['nbCar']) && $_POST['nbCar'] == 5) { echo 'checked'; } ?> />
                            </div>
                        </div>
                    </div>                       
                </div>
                <?php if (isset($formErrors['nbCar'])) { ?>
                    <p class="text-danger"><?= $formErrors['nbCar'] ?></p>
                <?php } ?>
                <div class="form-group">
                    <div class="row">
                        <label class="col-12" for="damageCost">Coût probable des dégats de l'accident :</label>
                    </div>
                    <div class="row">
                        <small class="col-12">(Un seul choix possible)</small>
                    </div>
                    <div class="row mt-4 mb-md-2">
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100">
                                <label for="0damageCost" class="col-9">0€</label>
                                <input name="damageCost" id="0damageCost" class="col-3" type="radio" value="1" <?php if(isset($_POST['damageCost']) && $_POST['damageCost'] == 1) { echo 'checked'; } ?> />
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="lessThan1000DamageCost" class="col-9">Moins de 1000€</label>
                                <input name="damageCost" id="lessThan1000DamageCost" type="radio" class="col-3" value="2" <?php if(isset($_POST['damageCost']) && $_POST['damageCost'] == 2) { echo 'checked'; } ?> />
                            </div>
                        </div>
                    </div>    
                    <div class="row mb-md-2">
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="1000To2000" class="col-9">1000€ à 2000€</label>
                                <input name="damageCost" id="1000To2000" type="radio" class="col-3" value="3" <?php if(isset($_POST['damageCost']) && $_POST['damageCost'] == 3) { echo 'checked'; } ?> />
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="2000To5000" class="col-9">2000€ à 5000€ : </label>
                                <input name="damageCost" id="2000To5000" class="col-3" type="radio" value="4" <?php if(isset($_POST['damageCost']) && $_POST['damageCost'] == 4) { echo 'checked'; } ?> />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-md-2">
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="5000To10000" class="col-9">5000€ à 10000€</label>
                                <input name="damageCost" id="5000To10000" class="col-3" type="radio" value="5" <?php if(isset($_POST['damageCost']) && $_POST['damageCost'] == 5) { echo 'checked'; } ?> />
                            </div>
                        </div>    
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="10000To50000" class="col-9">10000€ à 50000€</label>
                                <input name="damageCost" id="10000To50000" type="radio" class="col-3" value="6" <?php if(isset($_POST['damageCost']) && $_POST['damageCost'] == 6) { echo 'checked'; } ?> />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-md-2">
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="moreThan50000" class="col-9">Plus de 50000€</label>
                                <input name="damageCost" id="moreThan50000" class="col-3" type="radio" value="7" <?php if(isset($_POST['damageCost']) && $_POST['damageCost'] == 7) { echo 'checked'; } ?> />
                            </div>
                        </div>    
                    </div> 
                </div>
                <?php if (isset($formErrors['damageCost'])) { ?>
                    <p class="text-danger"><?= $formErrors['damageCost'] ?></p>
                <?php } ?> 
                <div class="form-group">
                    <div class="row">
                        <label class="col-12" for="roadSpeed">Vitesse max autorisé :</label>
                    </div>
                    <div class="row">
                        <small class="col-12">(Un seul choix possible !ATTENTION champ obligatoire)</small>
                    </div>
                    <div class="row mt-4 mb-md-2">
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100">
                                <label for="20kmh" class="col-9">20km/h</label>
                                <input name="roadSpeed" id="20kmh" class="col-3" type="radio" value="1" <?php if(isset($_POST['roadSpeed']) && $_POST['roadSpeed'] == 1) { echo 'checked'; } ?> />
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="30kmh" class="col-9">30km/h</label>
                                <input name="roadSpeed" id="30kmh" type="radio" class="col-3" value="2" <?php if(isset($_POST['roadSpeed']) && $_POST['roadSpeed'] == 2) { echo 'checked'; } ?> />
                            </div>
                        </div>
                    </div>    
                    <div class="row mb-md-2">
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="50kmh" class="col-9">50km/h</label>
                                <input name="roadSpeed" id="50kmh" type="radio" class="col-3" value="3" <?php if(isset($_POST['roadSpeed']) && $_POST['roadSpeed'] == 3) { echo 'checked'; } ?> />
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="70kmh" class="col-9">70km/h </label>
                                <input name="roadSpeed" id="70kmh" class="col-3" type="radio" value="4" <?php if(isset($_POST['roadSpeed']) && $_POST['roadSpeed'] == 4) { echo 'checked'; } ?> />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-md-2">
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="80kmh" class="col-9">80km/h</label>
                                <input name="roadSpeed" id="80kmh" class="col-3" type="radio" value="5" <?php if(isset($_POST['roadSpeed']) && $_POST['roadSpeed'] == 5) { echo 'checked'; } ?> />
                            </div>
                        </div>    
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="90kmh" class="col-9">90km/h</label>
                                <input name="roadSpeed" id="90kmh" type="radio" class="col-3" value="6" <?php if(isset($_POST['roadSpeed']) && $_POST['roadSpeed'] == 6) { echo 'checked'; } ?> />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-md-2">
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="100kmh" class="col-9">100km/h</label>
                                <input name="roadSpeed" id="100kmh" class="col-3" type="radio" value="7" <?php if(isset($_POST['roadSpeed']) && $_POST['roadSpeed'] == 7) { echo 'checked'; } ?> />
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="110kmh" class="col-9">110km/h</label>
                                <input name="roadSpeed" id="110kmh" type="radio" class="col-3" value="8" <?php if(isset($_POST['roadSpeed']) && $_POST['roadSpeed'] == 8) { echo 'checked'; } ?> />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-md-2">
                        <div class="col-md-6 d-flex justify-content-md-center">
                            <div class="row w-100 mb-2">
                                <label for="130kmh" class="col-9">130km/h</label>
                                <input name="roadSpeed" id="130kmh" class="col-3" type="radio" value="9" <?php if(isset($_POST['roadSpeed']) && $_POST['roadSpeed'] == 9) { echo 'checked'; } ?> />
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (isset($formErrors['speed'])) { ?>
                    <p class="text-danger"><?= $formErrors['speed'] ?></p>
                <?php } ?>

                <div class="row mt-5 d-flex justify-content-md-center">
                    <input name="submitForm" class="btn btn-success col-md-6 col-sm-12" type="submit" value="Valider les informations" />
                </div>
            </div>
        </form>
    </div>
</div>
<?php
include_once 'footer.php';
?>