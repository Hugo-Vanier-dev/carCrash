<?php

class accidents extends database {

    public $id = 0;
    public $longitude = '';
    public $latitude = '';
    public $badlyInjured = 0;
    public $lightlyInjured = 0;
    public $deaths = 0;
    public $adressOrRoadName = NULL;
    public $postedAt = NULL;
    public $accidentTime = NULL;
    public $id_cities = NULL;
    public $id_materialDamagesCost = NULL;
    public $id_maxSpeed = NULL;
    public $id_numbersOfImplicateCars = NULL;
    public $id_users = NULL;
    public $database = NULL;

    public function __construct() {
        $this->postedAt = date('Y-m-d h:i');
        $this->database = parent::getOrCreateInstance();
    }

    public function addNewAccident() {
        $query = 'INSERT INTO `' . DB_PREFIX . 'accidents` (`longitude`, `latitude`, `badlyInjured`, `lightlyInjured`, `deaths`, `adressOrRoadName`, `postedAt`, `accidentTime`, `id_' . DB_PREFIX . 'cities`, `id_' . DB_PREFIX . 'materialDamagesCost`, '
                . '`id_' . DB_PREFIX . 'maxSpeed`, `id_' . DB_PREFIX . 'numbersOfImplicateCars`, `id_' . DB_PREFIX . 'users`) '
                . 'VALUES (:longitude, :latitude, :badlyInjured, :lightlyInjured, :deaths, :adressOrRoadName, :postedAt, :accidentTime, :id_cities, :id_materialDamagesCost, :id_maxSpeed, :id_numbersOfImplicateCars, :id_users)';

        $pdoStatement = $this->database->prepare($query);
        $pdoStatement->bindValue(':longitude', $this->longitude, PDO::PARAM_STR);
        $pdoStatement->bindValue(':latitude', $this->latitude, PDO::PARAM_STR);
        $pdoStatement->bindValue(':badlyInjured', $this->badlyInjured, PDO::PARAM_INT);
        $pdoStatement->bindValue(':lightlyInjured', $this->lightlyInjured, PDO::PARAM_INT);
        $pdoStatement->bindValue(':deaths', $this->deaths, PDO::PARAM_INT);
        $pdoStatement->bindValue(':adressOrRoadName', $this->adressOrRoadName, PDO::PARAM_STR);
        $pdoStatement->bindValue(':postedAt', $this->postedAt, PDO::PARAM_STR);
        $pdoStatement->bindValue(':accidentTime', $this->accidentTime, PDO::PARAM_STR);
        $pdoStatement->bindValue(':id_cities', $this->id_cities, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id_materialDamagesCost', $this->id_materialDamagesCost, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id_maxSpeed', $this->id_maxSpeed, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id_numbersOfImplicateCars', $this->id_numbersOfImplicateCars, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id_users', $this->id_users, PDO::PARAM_INT);


        return $pdoStatement->execute();
    }

    public function verifiIfTheUserAlreadyInsertTheAccident() {
        $query = 'SELECT COUNT(`id`) AS `idNumbers` '
                . 'FROM `ujrgugr_accidents` '
                . 'WHERE `id_ujrgugr_users` = :id_users '
                . 'AND (DATEDIFF(LEFT(`accidentTime`, 10), :accidentTime) = 0 '
                . 'OR DATEDIFF(LEFT(`accidentTime`, 10), :accidentTime) = 0 '
                . 'OR TIMEDIFF(RIGHT(`accidentTime`, 8), :accidentTime) > \'-00:30\' '
                . 'OR TIMEDIFF(RIGHT(`accidentTime`, 8), :accidentTime) < \'00:30\') '
                . 'AND(`latitude` LIKE :latitude '
                . 'AND `longitude` LIKE :longitude)';

        $pdoStatement = $this->database->prepare($query);

        $pdoStatement->bindValue(':id_users', $this->id_users, PDO::PARAM_INT);
        $pdoStatement->bindValue(':accidentTime', $this->accidentTime, PDO::PARAM_STR);
        $pdoStatement->bindValue(':latitude', $this->latitude, PDO::PARAM_STR);
        $pdoStatement->bindValue(':longitude', $this->longitude, PDO::PARAM_STR);

        $pdoStatement->execute();

        return $pdoStatement->fetch(PDO::FETCH_OBJ);
    }

    public function verifyIftheAccidentAlreadyBeenregistered() {
        $query = 'SELECT `id` '
                . 'FROM `ujrgugr_accidents` '
                . 'WHERE (DATEDIFF(LEFT(`accidentTime`, 10), :accidentTime) = 0 '
                . 'OR DATEDIFF(LEFT(`accidentTime`, 10), :accidentTime) = 0 '
                . 'OR TIMEDIFF(RIGHT(`accidentTime`, 8), :accidentTime) > \'-00:30\' '
                . 'OR TIMEDIFF(RIGHT(`accidentTime`, 8), :accidentTime) < \'00:30\') '
                . 'AND(`latitude` LIKE :latitude '
                . 'AND `longitude` LIKE :longitude)';

        $pdoStatement = $this->database->prepare($query);

        $pdoStatement->bindValue(':id_users', $this->id_users, PDO::PARAM_INT);
        $pdoStatement->bindValue(':accidentTime', $this->accidentTime, PDO::PARAM_STR);
        $pdoStatement->bindValue(':latitude', $this->latitude, PDO::PARAM_STR);
        $pdoStatement->bindValue(':longitude', $this->longitude, PDO::PARAM_STR);

        $pdoStatement->execute();

        return $pdoStatement->fetch(PDO::FETCH_OBJ);
    }

    public function countNumberOfAccidents() {
        $query = 'SELECT COUNT(`id`) AS `numberAccidents` '
                . 'FROM `' . DB_PREFIX . 'accidents`';


        $pdoStatment = $this->database->query($query);

        return $pdoStatment->fetch(PDO::FETCH_OBJ);
    }

    public function selectAccidentsCoor() {
        $query = 'SELECT `latitude`, `longitude` '
                . 'FROM `' . DB_PREFIX . 'accidents`';

        $pdoStatment = $this->database->query($query);

        return $pdoStatment->fetchAll(PDO::FETCH_OBJ);
    }

    public function uptadeAnAccident() {
        $query = 'UPDATE `' . DB_PREFIX . 'accidents` '
                . 'SET `longitude` = :longitude '
                . '`latitude` = :latitude '
                . '`badlyInjured` = :badlyInjured '
                . '`lightlyInjured` = :lightlyInjured '
                . '`deaths` = :deaths '
                . '`adressOrRoadName` = :adressOrRoadName '
                . '`postedAt` = :postedAt '
                . '`accidentTime` = :accidentTime '
                . '`id_cities` = :id_cities '
                . '`id_materialDamagesCost` = :id_materialDamagesCost '
                . '`id_maxSpeed` = :id_maxSpeed '
                . '`id_numbersOfImplicateCars` = :id_numbersOfImplicateCars '
                . '`id_users` = :id_users '
                . 'WHERE `id` = :id';

        $pdoStatement = $this->database->prepare($query);
        $pdoStatement->bindValue(':longitude', $this->longitude, PDO::PARAM_STR);
        $pdoStatement->bindValue(':latitude', $this->latitude, PDO::PARAM_STR);
        $pdoStatement->bindValue(':badlyInjured', $this->badlyInjured, PDO::PARAM_INT);
        $pdoStatement->bindValue(':lightlyInjured', $this->lightlyInjured, PDO::PARAM_INT);
        $pdoStatement->bindValue(':deaths', $this->deaths, PDO::PARAM_INT);
        $pdoStatement->bindValue(':adressOrRoadName', $this->adressOrRoadName, PDO::PARAM_STR);
        $pdoStatement->bindValue(':postedAt', $this->postedAt, PDO::PARAM_STR);
        $pdoStatement->bindValue(':accidentTime', $this->accidentTime, PDO::PARAM_STR);
        $pdoStatement->bindValue(':id_cities', $this->id_cities, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id_materialDamagesCost', $this->id_materialDamagesCost, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id_maxSpeed', $this->id_maxSpeed, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id_numbersOfImplicateCars', $this->id_numbersOfImplicateCars, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id_users', $this->id_users, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);


        return $pdoStatement->execute();
    }

}
