<?php

/**
 * Classe per l'acquisto di un CD
 *
 */

class Acquisto{
    
    private $artista;
    
    private $titolo;

    private $cliente;   
 
    private $costo;
   
    public function getArtista() {
        return $this->artista;
    }

    public function setArtista($artista) {
        $this->artista = $artista;
    }

    public function getTitolo() {
        return $this->titolo;
    }

    public function setTitolo($titolo) {
        $this->titolo = $titolo;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function setCliente($idCliente) {
        $this->cliente = $idCliente;
    }

    public function getCosto() {
        return $this->costo;
    }

    public function setCosto($costo) {
        $this->costo = $costo;
    }    
}

?>
