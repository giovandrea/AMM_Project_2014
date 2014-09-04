<?php

include_once 'BaseController.php';

/**
 * Controller che gestisce la modifica dei dati dell'applicazione relativa ai
 * clienti
 *
 * @author Andrea Atzeni
 */
class ClienteController extends BaseController {

    /**
     * Costruttore
     */
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

        // gestione dei comandi
        // tutte le variabili che vengono create senza essere utilizzate 
        // direttamente in questo switch, sono quelle che vengono poi lette
        // dalla vista, ed utilizzano le classi del modello

        if (!$this->loggedIn()) {
            // utente non autenticato, rimando alla home

            $this->showLoginPage($vd);
        } else {
            // utente autenticato
            $user = UserFactory::instance()->cercaUtentePerId(
                            $_SESSION[BaseController::user], $_SESSION[BaseController::role]);


            // verifico quale sia la sottopagina della categoria
            // Cliente da servire ed imposto il descrittore 
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

                    // visualizzazione degli acquisti effettuati
                    case 'acquisti':
                        $acquisti = AcquistoFactory::instance()->acquistiPerCliente($user);
                        $vd->setSottoPagina('acquisti');
                        break;

                    // visualizzazione del catalogo
                    case 'catalogo':
                        $catalogo = CDFactory::instance()->getCd();
                        $vd->setSottoPagina('catalogo_cd');
                        break;

                    default:
                        $vd->setSottoPagina('home');
                        break;
                }
            }

            // gestione dei comandi inviati dall'utente
            if (isset($request["cmd"])) {
                // abbiamo ricevuto un comando
                switch ($request["cmd"]) {

                    // logout
                    case 'logout':
                        $this->logout($vd);
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

                    // cambio email
                    case 'email':

                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaEmail($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Email aggiornata");
                        $this->showHomeUtente($vd);
                        break;

                    // cambio password
                    case 'password':

                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaPassword($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Password aggiornata");
                        $this->showHomeStudente($vd);
                        break;

                    // instaurazione acquisto
                    case 'acquista':

                        $idcd = filter_var($request['cd'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                        if (isset($idcd)) {

                            $vd->setSottoPagina('acquisto');
                        }
                        $this->showHomeCliente($vd);
                        break;

		    // creazione di un nuovo acquisto
		    case 'nuovo_acquisto':
			$vd->setSottoPagina('catalogo_cd');
                        $msg = array();
                        $nuova = new Acquisto();

			$nuova->setCd(CDFactory::instance()->getCdPerId($request['idcd']));
                        $nuova->setCliente($user);
 			$this->creaFeedbackUtente($msg, $vd, "Acquisto eseguito, costo: ". $nuova->getCosto()." €");
			$cds = CDFactory::instance()->getCd();
			$this->showHomeUtente($vd);
			break;

                    default : 
			$this->showLoginPage($vd);
                }
            } else {
                // nessun comando
                $user = UserFactory::instance()->cercaUtentePerId(
                                $_SESSION[BaseController::user], $_SESSION[BaseController::role]);
                $this->showHomeUtente($vd);
            }
        }

        // includo la vista
        require basename(__DIR__) . '/../view/master.php';
    }
}

?>
