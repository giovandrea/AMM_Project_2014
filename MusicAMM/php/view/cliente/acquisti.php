<h2>Elenco ordini effettuati</h2>
<table id="tabella_acquisti">
    <thead>
        <tr>
            <th>Cd</th>
            <th>Costo</th>
        </tr>
    </thead>
    <tbody>
        <? foreach($acquisti as $acquisto) { ?>
        <tr>
            <td><?= $acquisto->getCd()->getArtista()->getNome() . " " . $acquisto->getCd()->getCostruttore()->getTitolo() ?></td>
            <td><?= $acquisto->getCosto() ?> €</td>
        </tr>                
        <? } ?>
    </tbody>
</table>
