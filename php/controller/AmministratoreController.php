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

    const elenco = 'elenco';

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
                        $ordini = CatalogoFactory::instance()->getCatalogo();
 			$clienti = UserFactory::instance()->getListaClienti();
                        $vd->setSottoPagina('ordine');

                        $vd->addScript("../js/jquery-2.1.1.min.js");
                        $vd->addScript("../js/elencoAcquisti.js");
                        break;

                    // gestione della richiesta ajax di filtro ordini
                    case 'filtra_ordini':
                        $vd->toggleJson();
                        $vd->setSottoPagina('ordini_json');
                        $errori = array();

                        if (isset($request['CD']) && ($request['CD'] != '')) {
                            $CD_id = filter_var($request['CD'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if ($CD_id == null) {
                                $errori['CD'] = "Specificare un identificatore valido";
                            }
                        } else {
                            $CD_id = null;
                        }

                        if (isset($request['cliente']) && ($request['cliente'] != '')) {
                            $cliente_id = filter_var($request['cliente'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if ($cliente_id == null) {
                                $errori['cliente'] = "Specificare una matricola valida";
                            }
                        } else {
                            $cliente_id = null;
                        }

                        $ordini = OrdiniFactory::instance()->ricercaOrdine(
                                $user, $CD_id, $cliente_id);

                        break;

                    //visualizzazione del catalogo
                    case 'catalogo':
                        $veicoli = CatalogoFactory::instance()->getCatalogo();                        
                        $vd->setSottoPagina('parco_auto');
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

                    // l'utente non vuole modificare l'ordine selezionato
                    case 'a_annulla':
                        $vd->setSottoPagina('catalogo');
                        $this->showHomeUtente($vd);
                        break;

                    // creazione di un nuovo CD
                    case 'CD_nuovo':
                        $vd->setSottoPagina('catalogo_CD');
                        $msg = array();
                        $nuovo = new CD();
                        $nuovo->setId(-1);
                        $nuovo->setModello(ModelloFactory::instance()->getModelloPerId($request['modello']));

                        if ($request['artista'] != "") {
                            $nuovo->setArtista($request['artista']);
                        } else {
                            $msg[] = '<li> Inserire un artista valido </li>';
                        }
                        if ($request['titolo'] != "") {
                            $nuovo->setTitolo($request['titolo']);
                        } else {
                            $msg[] = '<li> Inserire un titolo valido </li>';
                        }

                        if (count($msg) == 0) {
                            $vd->setSottoPagina('catalogo_CD');
                            if (CatalogoFactory::instance()->nuovo($nuovo) != 1) {
                                $msg[] = '<li> Impossibile aggiungere il CD</li>';
                            }
                        }
                        
                        $this->creaFeedbackUtente($msg, $vd, "Nuovo CD inserito");
                        
                        $veicoli = CatalogoFactory::instance()->getCatalogo();
                        $this->showHomeUtente($vd);
                        break;

                    // cancella un CD
                    case 'cancella_CD':
                        if (isset($request['CD'])) {
                            $intVal = filter_var($request['CD'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {

                                if (CatalogoFactory::instance()->cancellaPerId($intVal) < 1) {
                                    $msg[] = '<li> Impossibile cancellare il CD </li>';
                                }

                                $this->creaFeedbackUtente($msg, $vd, "CD eliminato");
                            }
                        }
                        $veicoli = CatalogoFactory::instance()->getCatalogo();
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
       }
      }
}

?>
