<?php

class users extends database {

    public $id = 0;
    public $mail = '';
    public $username = '';
    public $password = '';
    public $createdAt = NULL;
    public $validationHash = NULL;
    public $validation = false;
    public $tokenHash = NULL;
    public $id_userTypes = 0;
    public $database = NULL;

    public function __construct() {
        $this->createdAt = date('Y-m-d h:i');
        $this->id_userTypes = 1;
        $this->database = parent::getOrCreateInstance();
    }

    /**
     * On vérifie qu'un mail n'existe pas en effectuant une requète préparé qui compte le nombre 
     * d'id ou notre colonne mail vaut la valeur de notre marqueur nominatif. 
     * @return type obj
     */
    public function checkMail() {
        $query = 'SELECT COUNT(`id`) AS `mailExist` '
                . 'FROM `' . DB_PREFIX . 'users` '
                . 'WHERE `mail` = :mail';

        $pdoStatement = $this->database->prepare($query);

        $pdoStatement->bindValue(':mail', $this->mail, PDO::PARAM_STR);

        $pdoStatement->execute();

        return $pdoStatement->fetch(PDO::FETCH_OBJ);
    }

    //Exactement la même chose que pour le check mail mais avec le username
    public function checkUsername() {
        $query = 'SELECT COUNT(`id`) AS `usernameExist` '
                . 'FROM `' . DB_PREFIX . 'users` '
                . 'WHERE `username` = :username';

        $pdoStatement = $this->database->prepare($query);

        $pdoStatement->bindValue(':username', $this->username, PDO::PARAM_STR);

        $pdoStatement->execute();

        return $pdoStatement->fetch(PDO::FETCH_OBJ);
    }

    /**
     * On insère à l'aide d'une requète préparé dans notre table DB_PREFIXusers les valeur des attributs de notre class users
     * @return type bool
     */
    public function registerANewUser() {
        $query = 'INSERT INTO `' . DB_PREFIX . 'users` (`mail`, `username`, `password`, `createdAt`, `validationHash`, `validation`, `tokenHash`, `id_' . DB_PREFIX . 'userTypes`) '
                . 'VALUES (:mail, :username, :password, :createdAt, :validationHash, :validation, :tokenHash, :id_userTypes)';

        $pdoStatment = $this->database->prepare($query);

        $pdoStatment->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $pdoStatment->bindValue(':username', $this->username, PDO::PARAM_STR);
        $pdoStatment->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatment->bindValue(':createdAt', $this->createdAt, PDO::PARAM_STR);
        $pdoStatment->bindValue(':validationHash', $this->validationHash, PDO::PARAM_STR);
        $pdoStatment->bindValue(':validation', $this->validation, PDO::PARAM_BOOL);
        $pdoStatment->bindValue(':tokenHash', $this->tokenHash, PDO::PARAM_STR);
        $pdoStatment->bindValue(':id_userTypes', $this->id_userTypes, PDO::PARAM_INT);

        return $pdoStatment->execute();
    }
    /**
     * On change la valeur de la colonne token hash de notre table DB_PREFIXusers par la valeur de l'attribut
     * token hash de la class user lorsque la colonne id est égale à l'attribut id de la même class.
     * @return type bool
     */
    public function uptadeTokenHash() {
        $query = 'UPDATE `' . DB_PREFIX . 'users` '
                . 'SET `tokenHash` = :tokenHash '
                . 'WHERE `id` = :id';
        
        $pdoStatement = $this->database->prepare($query);
        
        $pdoStatement->bindValue(':tokenHash', $this->tokenHash, PDO::PARAM_STR);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        
        return $pdoStatement->execute();
       
    }
    /**
     * On récupère le tokenHash de l'utilisateur grâce à son id. 
     * @return type obj
     */
    public function getTheHashWithId() {
        
        $query = 'SELECT `tokenHash` '
                . 'FROM `' . DB_PREFIX . 'users` '
                . 'WHERE `id` = :id';
        
        $pdoStatement = $this->database->prepare($query);
        
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        
        $pdoStatement->execute();
        
        return $pdoStatement->fetch(PDO::FETCH_OBJ);
        
    }
    /**
     * On récupère la valeur des colonnes username id et password de notre table DB_PREFIXusers 
     * si la colonne mail et égale à l'attribut mail de la class users ou si la colonne username
     * est égale à l'attribut username de la class users et que la colonne validation est égale à 1.
     * @return type obj
     */
    public function getInfoUserWithMailOrusername() {
        $query = 'SELECT `username`, `id`, `password` '
                . 'FROM `' . DB_PREFIX . 'users` '
                . 'WHERE `mail` = :mail '
                . 'OR `username` = :username '
                . 'AND `validation` = 1';

        $pdoStatment = $this->database->prepare($query);

        $pdoStatment->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $pdoStatment->bindValue(':username', $this->username, PDO::PARAM_STR);

        $pdoStatment->execute();

        return $pdoStatment->fetch(PDO::FETCH_OBJ);
    }
    /**
     * On récupère le mail , le username, le mot de passe, et la date de création du compte d'un utilisateur que l'on identifie grâce à son id.
     * @return type obj
     */
    public function getAllInfoUserWithId() {
        $query = 'SELECT `mail`, `username`, `password`, DATE_FORMAT(`createdAt`, \'%d/%m/%Y à %h:%i\') AS createdAt '
                . 'FROM `' . DB_PREFIX . 'users` '
                . 'WHERE `id` = :id';

        $pdoStatment = $this->database->prepare($query);

        $pdoStatment->bindValue(':id', $this->id, PDO::PARAM_INT);

        $pdoStatment->execute();

        return $pdoStatment->fetch(PDO::FETCH_OBJ);
    }
    /**
     * On change le contenu de nos colonnes des colonnes mail et username dans notre table users que l'on identifie grâce à l'id.
     * @return bool
     */
    public function updateAUserMailAndUsername() {
        $query = 'UPDATE `' . DB_PREFIX . 'users` '
                . 'SET `mail` = :mail, `username` = :username '
                . 'WHERE id = :id';

        $pdoStatment = $this->database->prepare($query);

        $pdoStatment->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $pdoStatment->bindValue(':username', $this->username, PDO::PARAM_STR);
        $pdoStatment->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $pdoStatment->execute();
    }
    /**
     * On change le contenu de la colonne mot de passe de notre table users que l'on identifie grâce à l'id
     * @return type
     */
    public function updateAUserPassword() {
        $query = 'UPDATE `' . DB_PREFIX . 'users` '
                . 'SET `password` = :password '
                . 'WHERE `id` = :id';

        $pdoStatment = $this->database->prepare($query);

        $pdoStatment->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatment->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $pdoStatment->execute();
    }
    /**
     * On supprime un utilisateur de notre base de données que l'on identifie grâce à son id
     * @return bool
     */
    public function deleteUserWithHisId() {
        $query = 'DELETE '
                . 'FROM `' . DB_PREFIX . 'users` '
                . 'WHERE `id` = :id';

        $pdoStatment = $this->database->prepare($query);

        $pdoStatment->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $pdoStatment->execute();
    }
    
    public function selectMailValidationHashAndId() {
        $query = 'SELECT `validationHash`, `mail`, `id`, `username` '
                . 'FROM `' . DB_PREFIX . 'users` '
                . 'WHERE `validationHash` = :validationHash';
        
        $pdoStatment = $this->database->prepare($query);

        $pdoStatment->bindValue(':validationHash', $this->validationHash, PDO::PARAM_STR);

        $pdoStatment->execute();
        
        return $pdoStatment->fetch(PDO::FETCH_OBJ);
    }
    
    public function uptdateValidation() {
        $query = 'UPDATE `' . DB_PREFIX . 'users` '
                . 'SET `validation` = 1, `validationHash` = NULL '
                . 'WHERE `validationHash` = :validationHash';
        
        $pdoStatement = $this->database->prepare($query);
        
        $pdoStatement->bindValue(':validationHash', $this->validationHash, PDO::PARAM_STR);
        
        return $pdoStatement->execute();
    }
    
    public function uptadeMailAndValisationHash() {
        $qurey = 'UPTADE `' . DB_PREFIX . 'users` '
                . ' SET `mail` = :mail, `validationHash` = :validationHash '
                . ' WHERE `id` = :id';
        
        $pdoStatement = $this->database->prepare($query);
        
        $pdoStatement->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $pdoStatement->bindValue(':validationHash', $this->validationHash, PDO::PARAM_STR);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        
        return $pdoStatement->execute();
    }
    
    public function countNumberUser() {
        $query = 'SELECT COUNT(`id`) AS `numberUsers` '
                . 'FROM `' . DB_PREFIX . 'users`';
                  
        
        $pdoStatment = $this->database->query($query);
        
        return $pdoStatment->fetch(PDO::FETCH_OBJ);
        
    }

}

    
