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
     * Restiuisce un singleton per creare CD
     * @return CaratterizzazioneFactory
     */
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new CaratterizzazioneFactory();
        }

        return self::$singleton;
    }

    /**
     * Restituisce il caratterizzazione che ha l'artistaentificatore passato
     * @param int $artista
     * @return \Caratterizzazione
     */
    public function &getCaratterizzazionePerId($artista) {
        $caratterizzazione = new Caratterizzazione();
        $query = "select * from caratterizzazioni where artista = ?";
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

        if (!$stmt->bind_param('i', $artista)) {
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

        $artista = "";
        $titolo = "";
        $anno = 0;
        $prezzo = 0;

        if (!$stmt->bind_result($artista, $titolocaratterizzazione, $artistacostruttore, $cilindrata, $potenza, $prezzo)) {
            error_log("[getCaratterizzazionePerId] impossibile" .
                    " effettuare il binding in output");
            return $caratterizzazione;
        }
        while ($stmt->fetch()) {
            $caratterizzazione->setArtista($artista);
            $caratterizzazione->setTitolo($titolo);
            $caratterizzazione->NuovoCD(NuovoCDFactory::instance()->getCDPerId($artista));
            $caratterizzazione->setAnno($anno);
            $caratterizzazione->setPrezzo($prezzo);
        }

        $mysqli->close();
        return $caratterizzazione;
    }

    /**
     * Restituisce la lista di tutte le caratterizzazioni
     * @return array|\Caratterizzazione
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
     * @return \Caratterizzazione
     */
    private function getCaratterizzazione($row) {
        $caratterizzazione = new Caratterizzazione();
        $caratterizzazione->setArtista($row['artista']);
        $caratterizzazione->setTitolo($row['titolocaratterizzazione']);
        $caratterizzazione->setNuovoCD(NuovoCDFactory::instance()->getCDPerId($row['artista']));
        $caratterizzazione->setAnno($row['anno']);
        $caratterizzazione->setPrezzo($row['prezzo']);
        return $caratterizzazione;
    }

}

?>
