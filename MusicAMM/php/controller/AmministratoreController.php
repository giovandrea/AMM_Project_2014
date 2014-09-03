<?php

include_once 'BaseController.php';
include_once basename(__DIR__) . '/../model/CD.php';
include_once basename(__DIR__) . '/../model/CDFactory.php';
include_once basename(__DIR__) . '/../model/UserFactory.php';
include_once basename(__DIR__) . '/../model/CaratterizzazioneFactory.php';

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

                    // visulizzazione elenco acquisti
                    case 'acquisti':
                        $cds = CDFactory::instance()->getCd();
 			$clienti = UserFactory::instance()->getListaClienti();
                        $vd->setSottoPagina('acquisti');

                        $vd->addScript("../js/jquery-2.1.1.min.js");
                        $vd->addScript("../js/elencoAcquisti.js");
                        break;

                    // gestione della richiesta ajax di filtro acquisti
                    case 'filtra_acquisti':
                        $vd->toggleJson();
                        $vd->setSottoPagina('acquisti_json');
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

                        $acquisti = AcquistoFactory::instance()->ricercaAcquisti(
                                $user, $cd_id, $cliente_id);

                        break;

                    //visualizzazione del catalogo
                    case 'catalogo':
                        $cds = CDFactory::instance()->getCd();                        
                        $vd->setSottoPagina('catalogo_cd');
                        break;

 		     default:
		         $vd->setSottoPagina('home');
                         break;
                              }
                      }

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

		    case 'new_cd':
			$caratterizzazioni = CaratterizzazioneFactory::instance()->getCaratterizzazioni();
			$vd->setSottoPagina('crea_cd');
			$this->showHomeUtente($vd);
			break;

                    // creazione di un nuovo cd
                    case 'cd_nuovo':
                        $vd->setSottoPagina('catalogo_cd');
                        $msg = array();
                        $nuovo = new Cd();
                        $nuovo->setId(-1);
                        //$nuovo->setCaratterizzazione(CaratterizzazioneFactory::instance()->getCaratterizzazionePerId($request['caratterizzazione']));

 			if ($request['anno'] != "") {
				$nuovo->setAnno($request['anno']);
			} else {
				$msg[] = '<li> Inserire un anno valido </li>';
			}

			if ($request['titolo'] != "") {
				$nuovo->setTitolo($request['titolo']);
			} else {
				$msg[] = '<li> Inserire un titolo valido </li>';
			}

			if ($request['artista'] != "") {
				$nuovo->setArtista($request['artista']);
			} else {
				$msg[] = '<li> Inserire un artista valido </li>';
			}

			if ($request['prezzo'] != "") {
				$nuovo->setPrezzo($request['prezzo']);
			} else {
				$msg[] = '<li> Inserire un prezzo valido </li>';
			}

                        if (count($msg) == 0) {
                            $vd->setSottoPagina('catalogo_cd');
                            if (CDFactory::instance()->nuovo($nuovo) != 1) {
                                $msg[] = '<li> Impossibile aggiungere il cd</li>';
                            }
                        }
                        
                        $this->creaFeedbackUtente($msg, $vd, "Nuovo cd inserito");
                        
                        $cds= CDFactory::instance()->getCd();
                        $this->showHomeUtente($vd);
                        break;

                    // cancella un cd
                    case 'cancella_cd':
                        if (isset($request['cd'])) {
                            $intVal = filter_var($request['cd'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {

                                if (CDFactory::instance()->cancellaPerId($intVal) != 1) {
                                    $msg[] = '<li> Impossibile cancellare il cd </li>';
                                }

                                $this->creaFeedbackUtente($msg, $vd, "Cd eliminato");
                            }
                        }
                        $cds = CDFactory::instance()->getCd();
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

?>
