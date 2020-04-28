<?php

class causesAccidentLink extends database {

    public $id = 0;
    public $id_causes = 0;
    public $database = NULL;
    
    public function __construct() {
        $this->database = parent::getOrCreateInstance();
    }
    
    public function addNewAccidentCauses() {
        $query = 'INSERT INTO `' . DB_PREFIX . 'accidentcauses` (`id`, `id_' . DB_PREFIX . 'causes`) '
                . 'VALUES (:id, :id_causes)';
        
        $pdoStatement = $this->database->prepare($query);
        
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id_causes', $this->id_causes, PDO::PARAM_INT);
        
        return $pdoStatement->execute();
    }
}
