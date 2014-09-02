<?php

/**
 * Classe che rappresenta un generico cd
 *
 * @author Andrea Atzeni
 */
class CD {

    /**
     * Id univoco del cd
     * @var int
     */
    private $id;

    /**
     * Caratterizzazione del cd
     * @var Caratterizzazione
     */
    private $caratterizzazione;

    /**
     * Anno di pubblicazione
     * @var int
     */
    private $anno;

    /**
     * Flag che memorizza se il cd è acquistabile
     * @var boolean
     */
    private $acquistabile;

    /**
     * Costruttore
     */
    public function __costruct() {
        
    }

    /**
     * Restituisce un identificatore unico per il cd
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Imposta un identificatore unico per il cd
     * @param int $id
     * @return boolean true se il valore e' stato aggiornato correttamente,
     * false altrimenti
     */
    public function setId($id) {
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        $this->id = $intVal;
    }

    public function setAnno($anno) {
        $intVal = filter_var($anno, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (isset($intVal)) {
            if ($intVal > 1930 && $intVal <= date("Y")) {
                $this->anno = $intVal;
                return true;
            }
        }
        return false;
    }

    public function getAnno() {
        return $this->anno;
    }

    public function setAcquistabile($flag) {
        $bool = filter_var($flag, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if (isset($bool)) {
            $this->acquistabile = $bool;
            return true;
        }
        return false;
    }

    public function isAcquistabile() {
        return $this->acquistabile;
    }

    public function setCaratterizzazione($caratterizzazione) {
        $this->caratterizzazione = $caratterizzazione;
    }

    public function getCaratterizzazione() {
        return $this->caratterizzazione;
    }

}

?>
