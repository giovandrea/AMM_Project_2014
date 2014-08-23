<h2>Elenco ordini effettuati</h2>
<table id="tabella_ordini">
    <thead>
        <tr>
            <th>Artista</th>
            <th>Album</th>
            <th>Costo</th>
        </tr>
    </thead>
    <tbody>
        <? foreach($ordini as $ordine) { ?>
        <tr>
            <td><?= $ordine->getArtista() ?></td>
            <td><?= $ordine->getAlbum() ?></td>
            <td><?= $ordine->getCosto() ?> €</td>
        </tr>                
        <? } ?>
    </tbody>
</table>
