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
     * Restituisce un singleton per creare Cd
     * @return CDFactory
     */
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new CDFactory();
        }

        return self::$singleton;
    }

    /**
     * Restituisce tutti i cd esistenti
     * @return array di cd
     */
    public function &getCd() {
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getCd] impossibile inizializzare il database");
            return array();
        }

        $query = "SELECT * from cds";
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getCd] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return array();
        }

        $catalogo = self::inizializzaListaCd($stmt);
        $mysqli->close();
        return $catalogo;
    }

    /**
     * Popola una lista di Cd con una query variabile
     * @param mysqli_stmt $stmt
     * @return array di cd
     */
    private function &inizializzaListaCd(mysqli_stmt $stmt) {
        $cds = array();

        if (!$stmt->execute()) {
            error_log("[inizializzaListaCd] impossibile" .
                    " eseguire lo statement");
            return $cds;
        }

        $id = 0;
        $idcaratterizzazione = 0;
        $anno = 0;
        
        if (!$stmt->bind_result($id, $idcaratterizzazione, $anno)) {
            error_log("[inizializzaListaCd] impossibile" .
                    " effettuare il binding in output");
            return array();
        }
        while ($stmt->fetch()) {
            $cd = new Cd();
            $cd->setId($id);
            $cd->setCaratterizzazione(CaratterizzazioneFactory::instance()->getCaratterizzazionePerId($idcaratterizzazione));
            $cd->setAnno($anno);
            $cd->setAcquistabile(AcquistoFactory::instance()->isCdAcquistabile($id, "now"));
            $cds[] = $cd;
        }
        return $cds;
    }

    public function creaCdDaArray($row) {
        $cd = new Cd();
        $cd->setId($row['cds_id']);
        $cd->setCaratterizzazione(CaratterizzazioneFactory::instance()->getCaratterizzazionePerId($row['cds_idcaratterizzazione']));
        $cd->setAnno($row['cds_anno']);
        $cd->setAcquistabile(AcquistoFactory::instance()->isCdAcquistabile($row['cds_id'], "now"));
        return $cd;
    }
    
    /**
     * Salva il cd passato come parametro nel database
     * @param Cd $cd
     * @return true se il salvataggio è andato a buon fine, false altrimenti
     */
    public function nuovo($cd) {
        $query = "insert into cds (idcaratterizzazione, anno)
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

        if (!$stmt->bind_param('ii', $cd->getCaratterizzazione()->getId(), $cd->getAnno())){
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
        $query = "delete from cds where id = ?";

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
     * @return cd
     */
    public function &getCdPerId($id){
        $cd = new Cd();
        $query = "select * from cds where id = ?";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getCdPerId] impossibile inizializzare il database");
            $mysqli->close();
            return $cd;
        }

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getCdPerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $cd;
        }

        if (!$stmt->bind_param('i', $id)) {
            error_log("[getCdPerId] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return $cd;
        }

        if (!$stmt->execute()) {
            error_log("[getCdPerId] impossibile" .
                    " eseguire lo statement");
            return $cd;
        }

        $id = 0;
        $idcaratterizzazione = 0;
        $anno = 0;

        if (!$stmt->bind_result($id, $idcaratterizzazione, $anno)) {
            error_log("[getCdPerId] impossibile" .
                    " effettuare il binding in output");
            return $cd;
        }
        while ($stmt->fetch()) {
            $cd->setId($id);
            $cd->setAnno($anno);
            $cd->setCaratterizzazione(CaratterizzazioneFactory::instance()->getCaratterizzazionePerId($idcaratterizzazione));
            $cd->setAcquistabile(AcquistoFactory::instance()->isCdAcquistabile($id, "now"));
          }

        $mysqli->close();
        return $cd;
    }
}

?>
