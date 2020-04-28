<?php

class formHelper {
    
    public $postValue = '';
    public $fieldName = '';
    private $filterType = '';
    private $usedFilter = '';
    private $filterMail = '';
    private $filterInt = '';
    private $filterDate = '';
    private $filterTime = '';


    public function __construct() {
        $this->filterMail = FILTER_VALIDATE_EMAIL;
        $this->filterInt = FILTER_VALIDATE_INT;
        $this->filterDate = '/^[0-9]{4}\-((0[1-9])|(1[0-2]))\-((0[1-9])|([12][0-9])|(3[01]))$/';
        $this->filterTime = '/^[0-9]{2}:[0-9]{2}$/'; 
    }
    /**
     * On vérifie le nom du champ pour savoir quel type de filtre utilisé
     */
    private function checkFieldNameType() {
        if ($this->fieldName == 'mail') {
            $this->filterType = 'mail';
        }elseif($this->fieldName == 'int'){
            $this->filterType = 'int';
        }elseif($this->fieldName == 'date'){
            $this->filterType = 'date';
        }elseif($this->fieldName == 'time'){
            $this->filterType = 'time';
        }
    }
    /**
     * On donne à notre filtre une valeur en fonction de son type
     */
    private function whichFilter(){
        $this->checkFieldNameType();
        if($this->filterType == 'mail'){
            $this->usedFilter = $this->filterMail;
        }elseif($this->filterType == 'int'){
            $this->usedFilter = $this->filterInt;
        }elseif($this->filterType == 'date'){
            $this->usedFilter = $this->filterDate;
        }elseif($this->filterType == 'time'){
            $this->usedFilter = $this->filterTime;
        }
    }
    /**
     * On fait la vérification de nos données qui retourne true si la valeur de l'utilisateur est bonne sinon un false
     * @return bool
     */
    public function checkFormEnter() {
            $this->whichFilter();
            if($this->filterType == 'mail' || $this->filterType == 'int'){
                $returnBool = filter_var($this->postValue, $this->usedFilter);
            }else {
                $returnBool = preg_match($this->usedFilter, $this->postValue);
            }
            return $returnBool;
    }

}
