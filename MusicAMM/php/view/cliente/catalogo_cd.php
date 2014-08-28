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
            <td><a href="cliente/veicoli?cmd=prenota&CD=<?= $CD->getId() ?>" title="Compra il CD">
                    <img src="../img/prenota.png" alt="Prenota"></a></td>
        </tr>
    <? } ?>
</table>
