<?php

include_once 'NuovoCD.php';
include_once 'Db.php';

class NuovoCDFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
     * Restiuisce un singleton per creare CD
     * @return CDFactory
     */
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new CDFactory();
        }

        return self::$singleton;
    }

    public function &getCDPerId($artista) {
        $cd = new CD();
        $query = "select * from CD where artista = ?";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getCDPerId] impossibile inizializzare il database");
            $mysqli->close();
            return $cd;
        }

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getCDPerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $cd;
        }

        if (!$stmt->bind_param('i', $artista)) {
            error_log("[getCDPerId] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return $cd;
        }

        if (!$stmt->execute()) {
            error_log("[getCDPerId] impossibile" .
                    " eseguire lo statement");
            return $cd;
        }

        $artista = 0;
        $titolo = "";

        if (!$stmt->bind_result($artista, $titolo)) {
            error_log("[getCDPerId] impossibile" .
                    " effettuare il binding in output");
            return null;
        }
        while ($stmt->fetch()) {
            $cd->setId($artista);
            $cd->setNome($titolo);
        }

        $mysqli->close();
        return $cd;
    }

    /**
     * Restituisce la lista di tutti i NuoviCD
     */
    public function &getNuovoCD() {

        $NuovoCD = array();
        $query = "select * from NuovoCD";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getNuovoCD] impossibile inizializzare il database");
            $mysqli->close();
            return $NuovoCD;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getNuovoCD] impossibile eseguire la query");
            $mysqli->close();
            return $NuovoCD;
        }

        while ($row = $result->fetch_array()) {
            $NuovoCD[] = self::getCD($row);
        }

        $mysqli->close();
        return $NuovoCD;
    }

    /**
     * Crea un oggetto di tipo CD a partire da una riga del DB
     * @param type $row
     * @return \CD
     */
    private function getCD($row) {
        $cd = new CD();
        $cd->setId($row['artista']);
        $cd->setNome($row['titolo']);
        return $cd;
    }

}

?>