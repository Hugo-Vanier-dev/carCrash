<?php

if (isset($_GET['getAccidents'])) {
    include_once '../helpers/const.php';
    include_once '../models/database.php';
    include_once '../models/accidents.php';
    include_once '../models/users.php';
    $accident = new accidents();
    $user = new users();
    $accidentCoor = $accident->selectAccidentsCoor();
    header('Content-type: application/json');
    echo json_encode($accidentCoor);
    $numberOfUsers = $user->countNumberUser()->numberUsers;
    $numberOfAccidents = $accident->countNumberOfAccidents()->numberAccidents;
} else {
    $user = new users();
    $accident = new accidents();
    $numberOfUsers = $user->countNumberUser()->numberUsers;
    $numberOfAccidents = $accident->countNumberOfAccidents()->numberAccidents;
}

