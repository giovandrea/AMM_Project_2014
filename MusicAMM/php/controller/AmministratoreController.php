<?php

include_once 'BaseController.php';
include_once basename(__DIR__) . '/../model/CD.php';
include_once basename(__DIR__) . '/../model/CDFactory.php';
include_once basename(__DIR__) . '/../model/UserFactory.php';

/**
 * Controller che gestisce la modifica dei dati dell'applicazione relativa agli
 * amministratori
 *
 * @author Andrea Atzeni
 */
class AmministratoreController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Metodo per gestire l'input dell'utente. 
     * @param type $request la richiesta da gestire
     */
    public function handleInput(&$request) {

        // creo il descrittore della vista
        $vd = new ViewDescriptor();

        // imposto la pagina
        $vd->setPagina($request['page']);

        if (!$this->loggedIn()) {
            // utente non autenticato, rimando alla home
            $this->showLoginPage($vd);
        } else {
            // utente autenticato
            $user = UserFactory::instance()->cercaUtentePerId(
                    $_SESSION[BaseController::user], $_SESSION[BaseController::role]);

            // verifico quale sia la sottopagina della categoria
            // Amministratore da servire ed imposto il descrittore 
            // della vista per caricare i "pezzi" delle pagine corretti
            // tutte le variabili che vengono create senza essere utilizzate 
            // direttamente in questo switch, sono quelle che vengono poi lette
            // dalla vista, ed utilizzano le classi del modello
            if (isset($request["subpage"])) {
                switch ($request["subpage"]) {

                    // modifica dei dati anagrafici
                    case 'anagrafica':
                        $vd->setSottoPagina('anagrafica');
                        break;

                    // visulizzazione elenco ordini
                    case 'ordini':
                        $ordini = CDFactory::instance()->getCD();
 			$clienti = UserFactory::instance()->getListaClienti();
                        $vd->setSottoPagina('ordini');

                        $vd->addScript("../js/jquery-2.1.1.min.js");
                        $vd->addScript("../js/elencoAcquisti.js");
                        break;

                    // gestione della richiesta ajax di filtro ordini
                    case 'filtra_ordini':
                        $vd->toggleJson();
                        $vd->setSottoPagina('ordini_json');
                        $errori = array();

                        if (isset($request['cd']) && ($request['cd'] != '')) {
                            $cd_id = filter_var($request['cd'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if ($cd_id == null) {
                                $errori['cd'] = "Specificare un identificatore valido";
                            }
                        } else {
                            $cd_id = null;
                        }

                        if (isset($request['cliente']) && ($request['cliente'] != '')) {
                            $cliente_id = filter_var($request['cliente'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if ($cliente_id == null) {
                                $errori['cliente'] = "Specificare un nome valido";
                            }
                        } else {
                            $cliente_id = null;
                        }

                        $ordini = AcquistoFactory::instance()->ricercaAcquisti(
                                $user, $cd_id, $cliente_id);

                        break;

                    //visualizzazione del catalogo
                    case 'catalogo':
                        $ordini = CDFactory::instance()->getCD();                        
                        $vd->setSottoPagina('catalogo_cd');
                        break;

            // gestione dei comandi inviati dall'utente
            if (isset($request["cmd"])) {

                switch ($request["cmd"]) {

                    // logout
                    case 'logout':
                        $this->logout($vd);
                        break;

		   // cambio email
                    case 'email':
                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaEmail($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Email aggiornata");
                        $this->showHomeUtente($vd);
                        break;

                    // aggiornamento indirizzo
                    case 'indirizzo':

                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaIndirizzo($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Indirizzo aggiornato");
                        $this->showHomeUtente($vd);
                        break;

                    // modifica della password
                    case 'password':
                        $msg = array();
                        $this->aggiornaPassword($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Password aggiornata");
                        $this->showHomeUtente($vd);
                        break;

                    // l'utente vuole annullare l'ordine selezionato
                    case 'cd_annulla':
                        $vd->setSottoPagina('catalogo_cd');
                        $this->showHomeUtente($vd);
                        break;

                    // creazione di un nuovo cd
                    case 'cd_nuovo':
                        $vd->setSottoPagina('catalogo_cd');
                        $msg = array();
                        $nuovo = new CD();
                        $nuovo->setId(-1);
                        $nuovo->setCaratterizzazione(CaratterizzazioneFactory::instance()->getCaratterizzazionePerId($request['caratterizzazione']));

 			if ($request['anno'] != "") {
				$nuovo->setAnno($request['anno']);
			} else {
				$msg[] = '<li> Inserire un anno valido </li>';
			}

                        if (count($msg) == 0) {
                            $vd->setSottoPagina('catalogo_cd');
                            if (CatalogoFactory::instance()->nuovo($nuovo) != 1) {
                                $msg[] = '<li> Impossibile aggiungere il cd</li>';
                            }
                        }
                        
                        $this->creaFeedbackUtente($msg, $vd, "Nuovo cd inserito");
                        
                        $ordini = CD::instance()->getCD();
                        $this->showHomeUtente($vd);
                        break;

                    // cancella un cd
                    case 'cancella_cd':
                        if (isset($request['cd'])) {
                            $intVal = filter_var($request['cd'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {

                                if (CDFactory::instance()->cancellaPerId($intVal) < 1) {
                                    $msg[] = '<li> Impossibile cancellare il cd </li>';
                                }

                                $this->creaFeedbackUtente($msg, $vd, "cd eliminato");
                            }
                        }
                        $ordini = CDFactory::instance()->getCD();
                        $this->showHomeUtente($vd);
                        break;
               
                    // default
                    default:
                        $this->showHomeUtente($vd);
                        break;
                }
                   
            } else {
                // nessun comando, dobbiamo semplicemente visualizzare 
                // la vista
                $user = UserFactory::instance()->cercaUtentePerId(
                        $_SESSION[BaseController::user], $_SESSION[BaseController::role]);
                $this->showHomeUtente($vd);
            }
        }

        // richiamo la vista
        require basename(__DIR__) . '/../view/master.php';
    	}
/**
     * Aggiorna i dati relativi ad un appello in base ai parametri specificati
     * dall'utente
     * @param Appello $mod_appello l'appello da modificare
     * @param array $request la richiesta da gestire 
     * @param array $msg array dove inserire eventuali messaggi d'errore
     */
    public function updateAppello($mod_appello, &$request, &$msg) {
        if (isset($request['insegnamento'])) {
            $insegnamento = InsegnamentoFactory::instance()->creaInsegnamentoDaCodice($request['insegnamento']);
            if (isset($insegnamento)) {
                $mod_appello->setInsegnamento($insegnamento);
            } else {
                $msg[] = "<li>Insegnamento non trovato</li>";
            }
        }
        if (isset($request['data'])) {
            $data = DateTime::createFromFormat("d/m/Y", $request['data']);
            if (isset($data) && $data != false) {
                $mod_appello->setData($data);
            } else {
                $msg[] = "<li>La data specificata non &egrave; corretta</li>";
            }
        }
        if (isset($request['posti'])) {
            if (!$mod_appello->setCapienza($request['posti'])) {
                $msg[] = "<li>La capienza specificata non &egrave; corretta</li>";
            }
        }
    }

    /**
     * Ricerca un apperllo per id all'interno di una lista
     * @param int $id l'id da cercare
     * @param array $appelli un array di appelli
     * @return Appello l'appello con l'id specificato se presente nella lista,
     * null altrimenti
     */
    public function cercaAppelloPerId($id, &$appelli) {
        foreach ($appelli as $appello) {
            if ($appello->getId() == $id) {
                return $appello;
            }
        }

        return null;
    }

    /**
     * Calcola l'id per un nuovo appello
     * @param array $appelli una lista di appelli
     * @return int il prossimo id degli appelli
     */
    public function prossimoIdAppelli(&$appelli) {
        $max = -1;
        foreach ($appelli as $a) {
            if ($a->getId() > $max) {
                $max = $a->getId();
            }
        }
        return $max + 1;
    }

    /**
     * Restituisce il prossimo id per gli elenchi degli esami
     * @param array $elenco un elenco di esami
     * @return int il prossimo identificatore
     */
    public function prossimoIndiceElencoListe(&$elenco) {
        if (!isset($elenco)) {
            return 0;
        }

        if (count($elenco) == 0) {
            return 0;
        }

        return max(array_keys($elenco)) + 1;
    }

    /**
     * Restituisce l'identificatore dell'elenco specificato in una richiesta HTTP
     * @param array $request la richiesta HTTP
     * @param array $msg un array per inserire eventuali messaggi d'errore
     * @return l'identificatore dell'elenco selezionato
     */
    public function getIdElenco(&$request, &$msg) {
        if (!isset($request['elenco'])) {
            $msg[] = "<li> Non &egrave; stato selezionato un elenco</li>";
        } else {
            // recuperiamo l'elenco dalla sessione
            $elenco_id = filter_var($request['elenco'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            if (!isset($elenco_id) || !array_key_exists($elenco_id, $_SESSION[self::elenco])
                    || $elenco_id < 0) {
                $msg[] = "L'elenco selezionato non &egrave; corretto</li>";
                return null;
            }
            return $elenco_id;
        }
        return null;
    }

    /**
     * Restituisce l'appello specificato dall'utente tramite una richiesta HTTP
     * @param array $request la richiesta HTTP
     * @param array $msg un array dove inserire eventuali messaggi d'errore
     * @return Appello l'appello selezionato, null se non e' stato trovato
     */
    public function getAppello(&$request, &$msg) {
        if (isset($request['appello'])) {
            $appello_id = filter_var($request['appello'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            $appello = AppelloFactory::instance()->cercaAppelloPerId($appello_id);
            if ($appello == null) {
                $msg[] = "L'appello selezionato non &egrave; corretto</li>";
            }
            return $appello;
        } else {
            return null;
        }
    }

}

?>
