<?php

/**
 * Classe per l'acquisto di un CD
 */

class Acquisto{
    
    private $id;
    
    private $cd;

    private $cliente;

    private $costo;

    private $datainizio;

    private $datafine;   
   
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCd() {
        return $this->cd;
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

    public function getDatainizio() {
        return $this->datainizio;
    }

    public function setDatainizio($datainizio) {
        $this->datainizio = $datainizio;
    }

    public function getDatafine() {
        return $this->datafine;
    }

    public function setDatafine($datafine) {
        $this->datafine = $datafine;
    }
}

?>
