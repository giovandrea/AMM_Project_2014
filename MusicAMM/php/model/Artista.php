<?php

/**
 * Classe che descrive l'artista di un cd
 */
class Artista {
    
    private $id;
    
    private $nome;
    
    public function setNome($nome){
        $this->nome=$nome;
    }
    
    public function getNome(){
        return $this->nome;
    }
    
    /**
     * Restituisce un identificatore unico per l'artista
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
}

?>
