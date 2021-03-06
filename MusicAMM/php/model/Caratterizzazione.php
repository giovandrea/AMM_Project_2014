<?php

/**
 * Classe che descrive le proprietà di un generico cd
 */

class Caratterizzazione {
    /**
     * Id univoco della caratterizzazione del cd
     * @var int
     */
    private $id;
    /**
     * artista del cd
     * @var String
     */
    private $artista;

    /**
     * titolo del cd
     * @var String
     */
    private $titolo;
    
    /**
     * Prezzo del cd
     * @var double
     */
    private $prezzo;

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

    public function setArtista($artista) {
        $this->artista = $artista;
        return true;
    }

    public function getArtista() {
        return $this->artista;
    }

    public function setTitolo($titolo) {
        $this->titolo = $titolo;
        return true;
    }

    public function getTitolo() {
        return $this->titolo;
    }
    
    public function getPrezzo() {
        return $this->prezzo;
    }

    public function setPrezzo($prezzo) {
        $this->prezzo = $prezzo;
    }
}

?>
