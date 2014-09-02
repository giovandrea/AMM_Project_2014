<?php

/**
 * Classe per l'acquisto di un CD
 */

class Acquisto{
    
    private $id;
    
    private $cd;

    private $cliente;   
 
    private $costo;
   
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCd() {
        return $cd->cd;
    }

    public function setCd($cd) {
        $this->cd = $cd;
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
