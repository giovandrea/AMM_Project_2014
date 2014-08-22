<?php

include_once 'Db.php';
include_once 'CD.php';
include_once 'CaratterizzazioneFactory.php';
include_once 'AcquistoFactory.php';

class CDFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
     * Restiuisce un singleton per creare CD
     * @return \CDFactory
     */
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new CDFactory();
        }

        return self::$singleton;
    }

    /**
     * Restituisce tutti i CD esistenti
     * @return array|\CD
     */
    public function &getCD() {
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getCD] impossibile inizializzare il database");
            return array();
        }

        $query = "SELECT * from CD";
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getCD] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return array();
        }

        $toRet = self::inizializzaListaCD($stmt);
        $mysqli->close();
        return $toRet;
    }

    /**
     * Popola una lista di CD con una query variabile
     * @param mysqli_stmt $stmt
     * @return array|\CD
     */
    private function &inizializzaListaCD(mysqli_stmt $stmt) {
        $CD = array();

        if (!$stmt->execute()) {
            error_log("[inizializzaListaCD] impossibile" .
                    " eseguire lo statement");
            return $CD;
        }

        $id = 0;
        $id_caratterizzazione = 0;
        $anno = 0;
        
        if (!$stmt->bind_result($id, $id_caratterizzazione, $anno)) {
            error_log("[inizializzaListaCD] impossibile" .
                    " effettuare il binding in output");
            return array();
        }
        while ($stmt->fetch()) {
            $cd = new CD();
            $cd->setId($id);
            $cd->setCaratterizzazione(CaratterizzazioneFactory::instance()->getCaratterizzazionePerId($idcaratterizzazione));
            $cd->setAnno($anno);
            $cd->setAcquistabile(AcquistoFactory::instance()->isCDAcquistabile($id, "now"));
            $CD[] = $cd;
        }
        return $CD;
    }

    public function creaCDDaArray($row) {
        $cd = new CD();
        $cd->setId($row['CD_id']);
        $cd->setCaratterizzazione(CaratterizzazioneFactory::instance()->getCaratterizzazionePerId($row['CD_idcaratterizzazione']));
        $cd->setAnno($row['CD_anno']);
        $cd->setAcquistabile(AcquistoFactory::instance()->isCDAcquistabile($row['CD_id'], "now"));
        return $cd;
    }
    
    /**
     * Salva il cd passato come parametro nel database
     * @param CD $cd
     * @return true se il salvataggio è andato a buon fine
     */
    public function nuovo($cd) {
        $query = "insert into CD (id_caratterizzazione, anno)
                  values (?, ?)";

        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[nuovo] impossibile inizializzare il database");
            return 0;
        }

        $stmt = $mysqli->stmt_init();

        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[nuovo] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return 0;
        }

        if (!$stmt->bind_param('iis', $cd->getCaratterizzazione()->getId(), $cd->getAnno())){
        error_log("[nuovo] impossibile" .
                " effettuare il binding in input");
        $mysqli->close();
        return 0;
        }

        if (!$stmt->execute()) {
            error_log("[nuovo] impossibile" .
                    " eseguire lo statement");
            $mysqli->close();
            return 0;
        }

        $mysqli->close();
        return $stmt->affected_rows;
    }
    
    /**
     * Cancella il cd che ha l'identificatore passato come parametro
     * @param int $id
     * @return true se la cancellazione è andata a buon fine, false altrimenti
     */
    public function cancellaPerId($id) {
        $query = "delete from CD where id = ?";

        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cancellaPerId] impossibile inizializzare il database");
            return 0;
        }

        $stmt = $mysqli->stmt_init();

        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[cancellaPerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return 0;
        }

        if (!$stmt->bind_param('i', $id)){
        error_log("[cancellaPerId] impossibile" .
                " effettuare il binding in input");
        $mysqli->close();
        return 0;
        }

        if (!$stmt->execute()) {
            error_log("[cancellaPerId] impossibile" .
                    " eseguire lo statement");
            $mysqli->close();
            return 0;
        }

        $mysqli->close();
        return $stmt->affected_rows;
    }
    
    /**
     * Restituisce il cd che ha l'identificatore passato come parametro
     * @param int $id Identificatore
     * @return \CD
     */
    public function &getCDPerId($id){
        $cd = new CD();
        $query = "select * from CD where id = ?";
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

        if (!$stmt->bind_param('i', $id)) {
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

        $id = 0;
        $id_caratterizzazione = 0;
        $anno = 0;

        if (!$stmt->bind_result($id, $id_caratterizzazione, $anno)) {
            error_log("[getCDPerId] impossibile" .
                    " effettuare il binding in output");
            return $cd;
        }
        while ($stmt->fetch()) {
            $cd->setId($id);
            $cd->setAnno($anno);
            $cd->setCaratterizzazione(CaratterizzazioneFactory::instance()->getCaratterizzazionePerId($id_caratterizzazione));
            $cd->setAcquistabile(AcquistoFactory::instance()->isCDAcquistabile($id, "now"));
          }

        $mysqli->close();
        return $cd;
    }
}

?>
