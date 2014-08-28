<?php
switch ($vd->getSottoPagina()) {
    case 'anagrafica':
        include 'anagrafica.php';
        break;

    case 'ordini':
        include 'ordini.php';
        break;

    case 'ordini_json':
        include 'ordini_json.php';
        break;

    case 'catalogo_cd':
        include 'catalogo_cd.php';
        break;
    
    case 'aggiungi_nuovo_cd':
        include 'aggiungi_nuovo_cd.php';
        break;
        ?>


    <?php default: ?>
        <h2>Menu</h2>
        <p>
            Benvenuto, <?= $user->getNome() ?>
        </p>
        <p>
            Scegli una fra le seguenti sezioni:
        </p>
        <ul>
            <li><a href="amministratore/anagrafica">Anagrafica</a></li>
            <li><a href="amministratore/catalogo">Catalogo</a></li>
            <li><a href="amministratore/ordini">Ordini</a></li>
        </ul>
        <?php
        break;
}
?>
