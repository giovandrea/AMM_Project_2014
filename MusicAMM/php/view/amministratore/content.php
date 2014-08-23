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
            <li><a href="dipendente/anagrafica">Anagrafica</a></li>
            <li><a href="dipendente/auto">Catalogo</a></li>
            <li><a href="dipendente/noleggi">Ordini</a></li>
        </ul>
        <?php
        break;
}
?>
