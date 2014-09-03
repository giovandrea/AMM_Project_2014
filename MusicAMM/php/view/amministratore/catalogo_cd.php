<h2>Catalogo CD</h2>
<table>
    <tr>
        <th>Artista</th>
        <th>Titolo</th>
        <th>Anno Pubblicazione</th>
        <th>Prezzo</th>
        <th>Cancella</th>
    </tr>
    <?
    foreach($cds as $cd){
    ?>
    <tr>
        <td><?= $cd->getCaratterizzazione()->getArtista()->getNome() ?></td>
        <td><?= $cd->getCaratterizzazione()->getTitolo() ?></td>
        <td><?= $cd->getAnno() ?></td>
        <td><?= $cd->getCaratterizzazione()->getPrezzo() ?> €</td>
        <td><a href="amministratore/catalogo?cmd=cancella_cd&cd=<?= $cd->getId()?>" title="Elimina il cd">
            <img src="../images/delete.png" alt="Elimina"></a>
    </tr>
    <? } ?>
</table>

<div class="input-form">

    <form method="post" action="amministratore/catalogo">
        <button type="submit" name="cmd" value="new_cd">Inserisci nuovo cd</button>
    </form>

</div>
