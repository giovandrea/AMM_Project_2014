<?php

include_once 'Artista.php';
include_once 'ArtistaFactory.php';
include_once 'Caratterizzazione.php';
include_once 'Db.php';

class CaratterizzazioneFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
     * Restituisce un singleton per creare Caratterizzazioni
     * @return CaratterizzazioneFactory
     */
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new CaratterizzazioneFactory();
        }

        return self::$singleton;
    }

    /**
     * Restituisce la caratterizzazione che ha l'identificatore passato
     * @param int $id
     * @return Caratterizzazione
     */
    public function &getCaratterizzazionePerId($id) {
        $caratterizzazione = new Caratterizzazione();
        $query = "select * from caratterizzazioni where id = ?";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getCaratterizzazionePerId] impossibile inizializzare il database");
            $mysqli->close();
            return $caratterizzazione;
        }

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getCaratterizzazionePerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $caratterizzazione;
        }

        if (!$stmt->bind_param('i', $id)) {
            error_log("[getCaratterizzazionePerId] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return $caratterizzazione;
        }

        if (!$stmt->execute()) {
            error_log("[getCaratterizzazionePerId] impossibile" .
                    " eseguire lo statement");
            return $caratterizzazione;
        }
	
	$id = 0;
	$idartista = 0;
        $titolo = "";
        $prezzo = 0;

        if (!$stmt->bind_result($id, $titolo, $idartista, $prezzo)) {
            error_log("[getCaratterizzazionePerId] impossibile" .
                    " effettuare il binding in output");
            return $caratterizzazione;
        }
        while ($stmt->fetch()) {
	    $caratterizzazione->setId($id);
	    $caratterizzazione->setTitolo($titolo);
            $caratterizzazione->setPrezzo($prezzo);
            $caratterizzazione->setArtista(ArtistaFactory::instance()->getArtistaPerId($idartista));
        }

        $mysqli->close();
        return $caratterizzazione;
    }

    /**
     * Restituisce la lista di tutte le caratterizzazioni
     * @return array di caratterizzazioni
     */
    public function &getCaratterizzazioni() {

        $caratterizzazioni = array();
        $query = "select * from caratterizzazioni";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getCaratterizzazioni] impossibile inizializzare il database");
            $mysqli->close();
            return $caratterizzazioni;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getCaratterizzazioni] impossibile eseguire la query");
            $mysqli->close();
            return $caratterizzazioni;
        }

        while ($row = $result->fetch_array()) {
            $caratterizzazioni[] = self::getCaratterizzazione($row);
        }

        $mysqli->close();
        return $caratterizzazioni;
    }

    /**
     * Crea un oggetto di tipo Caratterizzazione a partire da una riga del DB
     * @param type $row
     * @return Caratterizzazione
     */
    private function getCaratterizzazione($row) {
        $caratterizzazione = new Caratterizzazione();
        $caratterizzazione->setId($row['id']);
        $caratterizzazione->setTitolo($row['titolo']);
        $caratterizzazione->setArtista(ArtistaCDFactory::instance()->getArtistaPerId($row['idartista']));
        $caratterizzazione->setPrezzo($row['prezzo']);
        return $caratterizzazione;
    }
}

?>
