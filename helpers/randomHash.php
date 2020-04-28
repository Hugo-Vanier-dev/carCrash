<?php
                                                                                                                                                                                                                                
class randomHash {

    public static function generateHash($length = 80) {
        //Création du tableau de minuscule.
        $alphabetMinTab = array();
        $letter = 'a';
        for ($i = 0; $i <= 25; $i++) {
            $alphabetMinTab[] = $letter;
            $letter++;
        }
        //Création du tableau majuscules.
        $alphabetMaxTab = array_map('strtoupper', $alphabetMinTab);
        //Création du tableau chiffre.
        $digitTab = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        /**
         * On fusionne tous nos tableaux en un seul gros tableau
         */
        $finalTab = array_merge($alphabetMinTab, $alphabetMaxTab, $digitTab);
        //On stocke dans une variable hash une chaine vide
        $hash = '';
        /**
         * On fait une boucle for qui se stop lorsqu'elle a fait autant de tour 
         * que la valeur de $length. Dans la boucle on commence par mélanger notre tableau
         * Puis on stocke dans notre variable $nbRandom un nombre aléatoire compris entre 0 et la taille de notre tableauFinale-1.
         * Puis on incrémente notre variable $hash en concaténant le $hash existant avec l'index
         * de notre tableau final égale au $nbRandom 
         */
        for ($i = 0; $i <= $length - 1; $i++) {
            shuffle($finalTab);
            $nbRandom = random_int(0, rand(0, count($finalTab) - 1));
            $hash .= $finalTab[$nbRandom];
        }
        //On return noter $hash
        return $hash;
    }
}
