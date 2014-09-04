<?php

include_once 'Acquisto.php';
include_once 'UserFactory.php';
include_once 'CDFactory.php';

static $numero=10; /* prova per numero MAX di CD */

class AcquistoFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
     * Restituisce un singleton per creare Acquisti
     * @return AcquistoFactory
     */
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new AcquistoFactory();
        }

        return self::$singleton;
    }

    /**
     * Controlla che il cd passato come parametro sia acquistabile
     * @param int $id del CD
     * @return Boolean true se il cd è acquistabile, false altrimenti
     */
    public function isCdAcquistabile($id) {
        $acquistabile = true;

        $query = "SELECT * FROM acquisti WHERE `idcd` = ?";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[isCdAcquistabile] impossibile inizializzare il database");
            $mysqli->close();
            return $acquistabile;
        }

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[isCdAcquistabile] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $acquistabile;
        }

        if (!$stmt->bind_param('i', $id)) {
            error_log("[isCdAcquistabile] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return $acquistabile;
        }

        if (!$stmt->execute()) {
            error_log("[isCdAcquistabile] impossibile" .
                    " eseguire lo statement");
            return $acquistabile;
        }

	$id = 0;
        $idcd = 0;
        $idcliente = 0;
        $costo = 0;

        if (!$stmt->bind_result($id, $idcd, $idcliente, $costo)) {
            error_log("[isCdAcquistabile] impossibile" .
                    " effettuare il binding in output");
            return false;
        }
        while ($stmt->fetch() && $acquistabile) {

	    $numero--;	
            if ($numero < 0) {
                $acquistabile = false;
            }
        }

        $mysqli->close();

        return $acquistabile;
    }

    /**
     * Cerca un acquisto corrispondente ai parametri passati
     * @param User $user
     * @param int $cd_id
     * @param int $cliente_id
     * @return array di cd
     */
    public function &ricercaAcquisti($user, $cd_id, $cliente_id) {
        $acquisti = array();

        /* La where viene costruita a seconda di quante 
         * variabili sono definite
	 */
        $bind = "";
        $where = " where acquisti.id >= 0 ";
        $par = array();


        if (isset($cd_id)) {
            $where .= " and idcd = ? ";
            $bind .="i";
            $par[] = $cd_id;
        }

        if (isset($cliente_id)) {
            $where .= " and idcliente = ? ";
            $bind .="i";
            $par[] = $cliente_id;
        }

        $query = "SELECT * 
                FROM acquisti
                JOIN clienti ON idcliente = clienti.id
                JOIN cds ON idcd = cd.id
                  " . $where;

        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[ricercaAcquisti] impossibile inizializzare il database");
            $mysqli->close();
            return $acquisti;
        }

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[ricercaAcquisti] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $acquisti;
        }

        switch (count($par)) {
            case 1:
                if (!$stmt->bind_param($bind, $par[0])) {
                    error_log("[ricercaAcquisti] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    return $acquisti;
                }
                break;
            case 2:
                if (!$stmt->bind_param($bind, $par[0], $par[1])) {
                    error_log("[ricercaAcquisti] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    return $acquisti;
                }
                break;
        }

        $acquisti = self::caricaAcquistiDaStmt($stmt);

        $mysqli->close();
        return $acquisti;
    }

    public function &caricaAcquistiDaStmt(mysqli_stmt $stmt) {
        $acquisti = array();
        if (!$stmt->execute()) {
            error_log("[caricaAcquistiDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }

        $row = array();
        $bind = $stmt->bind_result(
                $row['acquisti_id'], $row['acquisti_idcd'], $row['acquisti_idcliente'], $row['acquisti_costo'], $row['clienti_id'], $row['clienti_nome'], $row['clienti_cognome'], $row['clienti_email'], $row['clienti_via'], $row['clienti_numero_civico'], $row['clienti_citta'], $row['clienti_username'], $row['clienti_password'], $row['cd_id'], $row['cd_idcaratterizzazione'], $row['cd_anno']);

        if (!$bind) {
            error_log("[caricaAcquistiDaStmt] impossibile" .
                    " effettuare il binding in output");
            return null;
        }

        while ($stmt->fetch()) {
            $acquisti[] = self::creaDaArray($row);
        }

        $stmt->close();

        return $acquisti;
    }

    public function creaDaArray($row) {
        $acquisto = new Acquisto();
        $acquisto->setId($row['acquisti_id']);
        $acquisto->setCliente(UserFactory::instance()->creaClienteDaArray($row));
        $acquisto->setCd(CDFactory::instance()->creaCdDaArray($row));
        $acquisto->setCosto($row['acquisti_costo']);
        return $acquisto;
    }

    /**
     * Salva l'acquisto passato come parametro nel database, con transazione
     * @param Acquisto $acquisto
     * @return true se il salvataggio è andato a buon fine, false altrimenti
     */
    public function nuovo($acquisto) {
        $query = "insert into acquisti (idcd, idcliente, costo)
                  values (?, ?, ?)";

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

        if (!$stmt->bind_param('iid', $acquisto->getCD()->getId(), $acquisto->getCliente()->getId(), $acquisto->getCosto())) {
            error_log("[nuovo] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return 0;
        }

        // inizio la transazione
        $mysqli->autocommit(false);

        if (!$stmt->execute()) {
            error_log("[nuovo] impossibile" .
                    " eseguire lo statement");
            $mysqli->rollback();
            $mysqli->close();
            return 0;
        }

        //query eseguita correttamente, termino la transazione
        $mysqli->commit();
        $mysqli->autocommit(true);

        $mysqli->close();
        return $stmt->affected_rows;
    }

    /**
     * Restituisce un array contenente gli acquisti fatti dal cliente passato come parametro
     * @param Cliente $user
     * @return array di Acquisti
     */
    public function &acquistiPerCliente($user) {
        $acquisti = array();

        $query = "SELECT * 
                FROM acquisti
                JOIN clienti ON idcliente = clienti.id
                JOIN cds ON idcd = cd.id
                WHERE acquisti.idcliente = ?";

        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[acquistiPerCliente] impossibile inizializzare il database");
            $mysqli->close();
            return $acquisti;
        }

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[acquistiPerCliente] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $acquisti;
        }

        if (!$stmt->bind_param("i", $user->getId())) {
            error_log("[acquistiPerCliente] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return $acquisti;
        }

        $acquisti = self::caricaAcquistiDaStmt($stmt);

        $mysqli->close();
        return $acquisti;
    }
}

?>
