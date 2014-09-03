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

    default:
        ?>
        <h2>Menu</h2>
        <p>
            Benvenuto, <?= $user->getNome() ?>
        </p>
        <p>
            Scegli una fra le seguenti sezioni:
        </p>
        <ul>
            <li><a href="cliente/anagrafica">Anagrafica</a></li>
            <li><a href="cliente/acquisti">acquisti</a></li>
            <li><a href="cliente/catalogo_cd">Catalogo CD</a></li>            
        </ul>
        <?php
        break;
}
?>
