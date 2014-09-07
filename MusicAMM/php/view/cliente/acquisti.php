<h2>Elenco ordini effettuati</h2>
<table id="tabella_acquisti">
    <thead>
        <tr>
            <th>Cd</th>
	    <th>Data inizio</th>
	    <th>Data fine</th>
            <th>Costo</th>
        </tr>
    </thead>
    <tbody>
        <? foreach($acquisti as $acquisto) { ?>
        <tr>
            <td><?= $acquisto->getCd()->getCaratterizzazione()->getArtista()->getNome() . " - " . $acquisto->getCd()->getCaratterizzazione()->getTitolo() ?></td>
	    <td><?= $acquisto->getDatainizio() ?></td>
	    <td><?= $acquisto->getDatafine() ?></td>
            <td><?= $acquisto->getCosto() ?> €</td>
        </tr>                
        <? } ?>
    </tbody>
</table>
