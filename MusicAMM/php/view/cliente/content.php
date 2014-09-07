<?php
switch ($vd->getSottoPagina()) {
    case 'anagrafica':
        include_once 'anagrafica.php';
        break;

    case 'catalogo_cd':
        include_once 'catalogo_cd.php';
        break;
    
    case 'acquisti':
        include_once 'acquisti.php';
        break;

    case 'ordine':
	include_once 'ordine.php';
	break;

    case 'readme':
	include_once 'readme.php';
	break;

    default:
        ?>
        <h2>Menu</h2>
        <p>
            Benvenuto, <?= $user->getNome() ?>
        </p>
        <p>
            Scegli una fra le seguenti azioni:
        </p>
        <ul>
            <li><a href="cliente/anagrafica">Visiona Anagrafica</a></li>
            <li><a href="cliente/acquisti">Ordini Effettuati</a></li>
            <li><a href="cliente/cds">Catalogo CD</a></li>
	    <li><a href="cliente/readme">Informazioni Sul Sito</a></li>           
        </ul>
        <?php
        break;
}
?>
