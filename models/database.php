<?php

class database {
    
    protected $database = NULL;
    private static $instance = NULL;

    public function __construct() {
        try {
            $this->database = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DBNAME . ';charset=utf8', DB_USER, DB_PWD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (Exception $exception) {
            die('Il y a eu un problème avec la base de donné');
        }
    }
    
    public static function getOrCreateInstance(){
        if(is_null(self::$instance)){
            self::$instance = new database();
        }
        return self::$instance->database;
    }
}
