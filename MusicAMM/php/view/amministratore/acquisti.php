<h2>Ricerca acquisti</h2>
<div class="error">
    <div>
        <ul><li>Testo</li></ul>
    </div>
</div>
<div class="input-form">
    <h3>Filtro</h3>
    <form method="get" action="amministratore/acquisti">
        <label for="cd">Cd</label>
        <select name="cd" id="cd">
            <option value="">Tutto</option>
            <?php foreach ($cds as $cd) { ?>
                <option value="<?= $cd->getId() ?>" ><?= $cd->getCaratterizzazione()->getTitolo() . " " ?></option>
            <?php } ?>
        </select>
        <br/>
        <label for="cliente">Cliente</label>
        <select name="cliente" id="cliente">
            <option value="">Tutti</option>
            <?php foreach ($clienti as $cliente) { ?>
                <option value="<?= $cliente->getId() ?>" ><? echo $cliente->getNome() . " " . $cliente->getCognome()?></option>
            <?php } ?>
        </select>
        <br/>
 	<label for="datainizio">Data inizio</label>
	<input name="datainizio" id="datainizio" type="text"/>
	<br/>
	<label for="datafine">Data fine</label>
	<input name="datafine" id="datafine" type="text"/>
	<br/>
        <button id="filtra" type="submit" name="cmd">Cerca</button>
    </form>
</div>

<h3>Elenco Acquisti</h3>

<p id="nessuno">Nessun acquisto trovato</p>

<table id="tabella_acquisti">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Cd</th>
            <th>Costo</th>
 	    <th>Data inizio</th>
	    <th>Data fine</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
