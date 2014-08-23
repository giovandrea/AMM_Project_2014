<?php

include_once 'Artista.php';
include_once 'Db.php';

class ArtistaFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
     * Restituisce un singleton per creare un Artista
     * @return ArtistaFactory
     */
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new ArtistaFactory();
        }

        return self::$singleton;
    }

    public function &getArtistaPerId($id) {
        $artista = new Artista();
        $query = "select * from artisti where id = ?";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getArtistaPerId] impossibile inizializzare il database");
            $mysqli->close();
            return $artista;
        }

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getArtistaPerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $artista;
        }

        if (!$stmt->bind_param('i', $id)) {
            error_log("[getArtistaPerId] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return $artista;
        }

        if (!$stmt->execute()) {
            error_log("[getArtistaPerId] impossibile" .
                    " eseguire lo statement");
            return $artista;
        }

        $id = 0;
        $nome = "";

        if (!$stmt->bind_result($id, $nome)) {
            error_log("[getArtistaPerId] impossibile" .
                    " effettuare il binding in output");
            return null;
        }
        while ($stmt->fetch()) {
            $artista->setId($id);
            $artista->setNome($nome);
        }

        $mysqli->close();
        return $artista;
    }

    /**
     * Restituisce la lista di tutti gli artisti
     */
    public function &getArtisti() {

        $artisti = array();
        $query = "select * from artisti";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getArtisti] impossibile inizializzare il database");
            $mysqli->close();
            return $artisti;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getArtisti] impossibile eseguire la query");
            $mysqli->close();
            return $artisti;
        }

        while ($row = $result->fetch_array()) {
            $artisti[] = self::getArtista($row);
        }

        $mysqli->close();
        return $artisti;
    }

    /**
     * Crea un oggetto di tipo Artista a partire da una riga del DB
     * @param type $row
     * @return Artista
     */
    private function getArtista($row) {
        $artista = new Artista();
        $artista->setId($row['id']);
        $artista->setNome($row['nome']);
        return $artista;
    }
}

?>
