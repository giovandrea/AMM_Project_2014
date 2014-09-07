<h2>Catalogo cd</h2>
<table>
    <tr>
        <th>Artista</th>
        <th>Titolo Album</th>
        <th>Anno Pubblicazione</th>
        <th>Prezzo</th>
        <th>Richiedi</th>
    </tr>
    <?
    foreach($cds as $cd){
    ?>
    <tr>
        <td><?= $cd->getCaratterizzazione()->getArtista()->getNome() ?></td>
        <td><?= $cd->getCaratterizzazione()->getTitolo() ?></td>
        <td><?= $cd->getAnno() ?></td>
        <td><?= $cd->getCaratterizzazione()->getPrezzo() ?> €</td>
        <td><a href="cliente/cds?cmd=acquista&cd=<?= $cd->getId() ?>" title="Acquista il cd">
                    <img src="../images/button_buy.png" alt="Acquista"></a></td>
        </tr>
    <? } ?>
</table>
