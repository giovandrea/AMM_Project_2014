<h2>Ricerca cd</h2>
<div class="error">
    <div>
        <ul><li>Testo</li></ul>
    </div>
</div>
<div class="input-form">
    <h3>Filtro</h3>
    <form method="get" action="amministratore/ordini">
        <label for="cd">Cd</label>
        <select name="cd" id="cd">
            <option value="">Qualsiasi</option>
            <?php foreach ($cds as $cd) { ?>
                <option value="<?= $cd->getId() ?>" ><?= $cd->getCaratterizzazione()->getTitolo() . " " ?></option>
            <?php } ?>
        </select>
        <br/>
        <label for="cliente">Cliente</label>
        <select name="cliente" id="cliente">
            <option value="">Qualsiasi</option>
            <?php foreach ($clienti as $cliente) { ?>
                <option value="<?= $cliente->getId() ?>" ><? echo $cliente->getNome() . " " . $cliente->getCognome()?></option>
            <?php } ?>
        </select>
        <br/>
        <button id="filtra" type="submit" name="cmd">Cerca</button>
    </form>
</div>

<h3>Elenco Ordini</h3>

<p id="nessuno">Nessun ordine trovato</p>

<table id="tabella_ordini">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Cd</th>
            <th>Costo</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
