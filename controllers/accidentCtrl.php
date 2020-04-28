<?php

$regexDate = '/^[0-9]{4}\-((0[1-9])|(1[0-2]))\-((0[1-9])|([12][0-9])|(3[01]))$/';
$regexHour = '/^[0-9]{2}:[0-9]{2}$/';
$thisYear = date('Y');
$thisMonth = date('m');
$thisDay = date('d');
$thisHour = date('H') + 3;
$thisMin = date('i');
if (!isset($_SESSION['userId'])) {
    header('location: ../index.php');
}
if (isset($_POST['submitForm'])) {
    $endMessage = 'Il y a eu un problème lors de la saisie des données.';
    $endMessageClass = 'text-danger';
    $accident = new accidents();
    $checkForm = new formHelper();
    if (!empty($_POST['latitude']) && !empty($_POST['longitude'])) {
        if (is_numeric($_POST['latitude']) && is_numeric($_POST['longitude'])) {
            $latitude = htmlspecialchars($_POST['latitude']);
            $longitude = htmlspecialchars($_POST['longitude']);
        } else {
            $formErrors['map'] = 'Veuillez séléctionner la zone où l\'accident a eu lieu ou cliquer de façon plus précise.';
        }
    } else {
        $formErrors['map'] = 'Veuillez séléctionner la zone où l\'accident a eu lieu ou cliquer de façon plus précise.';
    }
    if (!empty($_POST['roadSpeed'])) {
        $checkForm->fieldName = 'int';
        $checkForm->postValue = $_POST['roadSpeed'];
        if ($checkForm->checkFormEnter()) {
            $accident->id_maxSpeed = htmlspecialchars($_POST['roadSpeed']);
        } else {
            $formErrors['speed'] = 'Veuillez séléctionner la vitesse maximum autorisé sur la route.';
        }
    } else {
        $formErrors['speed'] = 'Veuillez séléctionner la vitesse maximum autorisé sur la route.';
    }
    if (!empty($_POST['date'])) {
        $checkForm->fieldName = 'date';
        $checkForm->postValue = $_POST['date'];
        if ($checkForm->checkFormEnter()) {
            /*
             * On utilise une fonction php appellé explode qui prend en paramètre un séparateur et une chaîne de caractère
             * A chaque fois que dans notre chaîne de caractère on rencontre notre séparateur ('-')
             * Tout ce qui se situe entre le début de notre chaîne ou un séparateur devient une nouvelle chaîne
             * stocker dans notre tableau indexé $returnTabRdvDate.
             */
            $returnTabRdvDate = explode('-', $_POST['date']);
            //On stoque l'année retourner dans une variable $year
            $year = $returnTabRdvDate[0];
            //On stoque l'année retourner dans une variable $month
            $month = $returnTabRdvDate[1];
            //On stoque l'année retourner dans une variable $day
            $day = $returnTabRdvDate[2];
            /*
             * Si l'année entrée est supérieure à celle en cours ou
             * Si l'année entrée est égale à celle en cours et  le mois est supérieur ou
             * Si l'année entrée est égale et le mois entré est égal et le jour est supérieur ou égal.
             * Alors on attribue à $appointmentDate notre $_POST['rdvDate']
             * Sinon on stocke dans notre tableau d'erreur un message.
             */
            if ($year < $thisYear || ( $year == $thisYear && $month < $thisMonth) || ($year == $thisYear && $month == $thisMonth && $day <= $thisDay)) {
                $accidentDate = htmlspecialchars($_POST['date']);
            } else {
                $formErrors['date'] = 'Veuillez ne pas prendre une date future';
            }
        } else {
            $formErrors['date'] = 'Veuillez utiliser le champ qui ouvre un calendrier à votre disposition si vous n\'avez pas de calendrier entrer la date sous la forme année-mois-jour';
        }
    } else {
        $formErrors['date'] = 'Veuillez remplir le champ pour indiquer la date de l\'accidents';
    }
    if (!empty($_POST['time'])) {
        $checkForm->fieldName = 'time';
        $checkForm->postValue = $_POST['time'];
        if ($checkForm->checkFormEnter()) {
            $returnTabRdvTime = explode(':', $_POST['time']);
            $hour = $returnTabRdvTime[0];
            $minute = $returnTabRdvTime[1];
            if ($year == $thisYear && $month == $thisMonth && $day == $thisDay) {
                if ($hour <= $thisHour) {
                    $accidentTime = htmlspecialchars($_POST['time']);
                } else {
                    $formErrors['time'] = 'Cette heure est déjà passé';
                }
            } else {
                $accidentTime = htmlspecialchars($_POST['time']);
            }
        } else {
            $formErrors['time'] = 'Veuillez utilisé le champ à votre disposition si vous n\'avez pas de champ spécifique à l\'heure entrer l\'heure sous la forme heure:minute';
        }
    } else {
        $formErrors['time'] = 'Veuillez choisir l\'heure à laquelle l\'accident a eu lieu';
    }
    if (!empty($_POST['nbCar'])) {
        $checkForm->fieldName = 'int';
        $checkForm->postValue = $_POST['nbCar'];
        if ($checkForm->checkFormEnter()) {
            $accident->id_numbersOfImplicateCars = htmlspecialchars($_POST['nbCar']);
        } else {
            $formErrors['nbCar'] = 'Veuillez séléctionner une des valeurs de la liste.';
        }
    }
    if (!empty($_POST['damageCost'])) {
        $checkForm->fieldName = 'int';
        $checkForm->postValue = $_POST['damageCost'];
        if ($checkForm->checkFormEnter()) {
            $accident->id_materialDamagesCost = htmlspecialchars($_POST['damageCost']);
        } else {
            $formErrors['damageCost'] = 'Veuillez séléctionner une des valeurs de la liste.';
        }
    }
    if (!empty($_POST['adressOrRoadName'])) {
        $accident->adressOrRoadName = htmlspecialchars($_POST['adressOrRoadName']);
    }
    if (!empty($_POST['lightlyInjured'])) {
        $checkForm->fieldName = 'int';
        $checkForm->postValue = $_POST['lightlyInjured'];
        if ($checkForm->checkFormEnter()) {
            $accident->lightlyInjured = htmlspecialchars($_POST['lightlyInjured']);
        } else {
            $formErrors['lightlyInjured'] = 'Veuillez séléctionner un entier.';
        }
    }
    if (!empty($_POST['badlyInjured'])) {
        $checkForm->fieldName = 'int';
        $checkForm->postValue = $_POST['badlyInjured'];
        if ($checkForm->checkFormEnter()) {
            $accident->badlyInjured = htmlspecialchars($_POST['badlyInjured']);
        } else {
            $formErrors['badlyInjured'] = 'Veuillez séléctionner un entier.';
        }
    }
    if (!empty($_POST['deaths'])) {
        $checkForm->fieldName = 'int';
        $checkForm->postValue = $_POST['deaths'];
        if ($checkForm->checkFormEnter()) {
            $accident->deaths = htmlspecialchars($_POST['deaths']);
        } else {
            $formErrors['deaths'] = 'Veuillez séléctionner un entier.';
        }
    }
    $accident->id_users = htmlspecialchars($_SESSION['userId']);
    if (!isset($formErrors)) {
        $accident->accidentTime = $accidentDate . ' ' . $accidentTime;
        $longitudeExploTab = explode('.', $longitude);
        $latitudeExploTab = explode('.', $latitude);
        $longitudeTab = str_split($longitudeExploTab[1]);
        $latitudeTab = str_split($latitudeExploTab[1]);
        $longitudeRight = '';
        $latitudeRight = '';
        for ($i = 0; $i < 3; $i++) {
            $longitudeRight .= $longitudeTab[$i];
            $latitudeRight .= $latitudeTab[$i];
        }
        $longitudeExploTab[1] = $longitudeRight;
        $latitudeExploTab[1] = $latitudeRight;
        $longitudeCheck = implode('.', $longitudeExploTab);
        $latitudeCheck = implode('.', $latitudeExploTab);
        $accident->longitude = $longitudeCheck . '%';
        $accident->latitude = $latitudeCheck . '%';
        if ($accident->verifiIfTheUserAlreadyInsertTheAccident()->idNumbers == 0) {
            $accidentId = $accident->verifyIftheAccidentAlreadyBeenregistered();
            if (is_object($accidentId)) {
                $accident->longitude = $longitude;
                $accident->latitude = $latitude;
                $accident->id = $accidentId->id;
                if (!empty($_POST['causes'])) {
                    if (is_array($_POST['causes'])) {
                        $accidentCauses = new causesAccidentLink();
                        try {
                            $accident->database->beginTransaction();
                            $accident->uptadeAnAccident();
                            $accidentCauses->id = $accidentId->id;
                            $checkForm->fieldName = 'int';
                            foreach ($_POST['causes'] as $causes) {
                                $checkForm->postValue = $causes;
                                if ($checkForm->checkFormEnter() && $causes > 0 && $causes < 7) {
                                    $accidentCauses->id_causes = $causes;
                                    $accidentCauses->addNewAccidentCauses();
                                } else {
                                    $formErrors['causes'] = 'Veuillez séléctionner des valeurs de la liste.';
                                    $accident->database->rollBack();
                                }
                            }
                            $accident->database->commit();
                            $endMessage = 'Bravo l\'accident a bien été pris en compte.';
                            $endMessageClass = 'text-success';
                        } catch (Exception $ex) {
                            $accident->database->rollBack();
                        }
                    }
                } else {
                    $accident->addNewAccident();
                    $endMessage = 'Bravo l\'accident a bien été pris en compte.';
                    $endMessageClass = 'text-success';
                }
            } else {
                $accident->longitude = $longitude;
                $accident->latitude = $latitude;
                if (!empty($_POST['causes'])) {
                    if (is_array($_POST['causes'])) {
                        $accidentCauses = new causesAccidentLink();
                        try {
                            $accident->database->beginTransaction();
                            $accident->addNewAccident();
                            $accidentCauses->id = $accident->database->lastInsertId();
                            $checkForm->fieldName = 'int';
                            foreach ($_POST['causes'] as $causes) {
                                $checkForm->postValue = $causes;
                                if ($checkForm->checkFormEnter() && $causes > 0 && $causes < 7) {
                                    $accidentCauses->id_causes = $causes;
                                    $accidentCauses->addNewAccidentCauses();
                                } else {
                                    $formErrors['causes'] = 'Veuillez séléctionner des valeurs de la liste.';
                                    $accident->database->rollBack();
                                }
                            }
                            $accident->database->commit();
                            $endMessage = 'Bravo l\'accident a bien été pris en compte.';
                            $endMessageClass = 'text-success';
                        } catch (Exception $ex) {
                            $accident->database->rollBack();
                        }
                    }
                } else {
                    $accident->addNewAccident();
                    $endMessage = 'Bravo l\'accident a bien été pris en compte.';
                    $endMessageClass = 'text-success';
                }
            }
        } else {
            $endMessage = 'Vous avez déjà renseigné cet accident.';
            $endMessageClass = 'text-danger';
        }
    }
}