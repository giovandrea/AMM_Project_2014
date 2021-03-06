<?php
switch ($vd->getSottoPagina()) {
    case 'anagrafica':
        include 'anagrafica.php';
        break;

    case 'acquisti':
        include 'acquisti.php';
        break;

    case 'acquisti_json':
        include 'acquisti_json.php';
        break;

    case 'catalogo_cd':
        include 'catalogo_cd.php';
        break;
    
    case 'crea_cd':
        include 'crea_cd.php';
        break;

    case 'readme':
        include 'readme.php';
        break;
        ?>


    <?php default: ?>
        <h2>Menu</h2>
        <p>
            Benvenuto, <?= $user->getNome() ?>
        </p>
        <p>
            Scegli una fra le seguenti azioni:
        </p>
        <ul>
            <li><a href="amministratore/anagrafica">Visiona Anagrafica</a></li>
            <li><a href="amministratore/catalogo">Catalogo CD</a></li>
            <li><a href="amministratore/acquisti">Elenco Ordini Ricevuti</a></li>
	    <li><a href="amministratore/readme">Informazioni Sul Sito</a></li>
        </ul>
        <?php
        break;
}
?>
