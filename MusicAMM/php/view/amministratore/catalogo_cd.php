<h2>Parco auto</h2>
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
        <td><a href="amministratore/auto?cmd=cancella_CD&CD=<?= $CD->getId()?>" title="Elimina il CD">
            <img src="../images/cancella.png" alt="Elimina"></a>
    </tr>
    <? } ?>
</table>

<div class="input-form">

    <form method="post" action="amministratores/cd">as
        <button type="submit" name="cmd" value="new_CD">Inserisci nuovo CD</button>
    </form>

</div>
