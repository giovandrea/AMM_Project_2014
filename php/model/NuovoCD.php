<?php

/**
 * Classe che descrive un nuovo CD
 */
class NuovoCD {
    
    private $artista;
    
    private $titolo;
    
    public function setArtista($artista){
        $this->artista=$artista;
    }
    
    public function getArtista(){
        return $this->artista;
    }
    
    public function setTitolo($titolo){
        $this->titolo=$titolo;
    }
    
    public function getTitolo(){
        return $this->titolo;
    }
}

?>
