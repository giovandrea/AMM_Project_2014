<?php

/**
 * Classe che descrive le proprietà di un generico CD
 */

class Modello {
    /**
     * artista dell'artista del CD
     * @var String
     */
    private $artista;

    /**
     * artista del CD
     * @var String
     */
    private $titolo;

    /**
     * Anno di pubblicazione del CD
     * @var int
     */
    private $anno;
    
    /**
     * Prezzo del CD
     * @var double
     */
    private $prezzo;

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

    public function getAnno() {
        return $this->anno;
    }

    public function setAnno($anno) {
        $this->anno = $anno;
    }

}

?>
