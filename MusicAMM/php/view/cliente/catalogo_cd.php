<h2>Catalogo CD</h2>
<table>
    <tr>
        <th>Artista</th>
        <th>Titolo Album</th>
        <th>Anno Pubblicazione</th>
        <th>Prezzo</th>
        <th>Cancella</th>
    </tr>
    <?
    foreach($CDs as $CD){
    ?>
    <tr>
        <td><?= $CD->getArtista() ?></td>
        <td><?= $CD->getTitolo() ?></td>
        <td><?= $CD->getAnno() ?></td>
        <td><?= $CD->getPrezzo() ?></td>
            <td><a href="cliente/ordini?cmd=prenota&CD=<?= $CD->getId() ?>" title="Compra il CD">
                    <img src="../images/button_buy.png" alt="Acquista"></a></td>
        </tr>
    <? } ?>
</table>
