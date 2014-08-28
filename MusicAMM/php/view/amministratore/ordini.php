<h2>Ricerca cd</h2>
<div class="error">
    <div>
        <ul><li>Testo</li></ul>
    </div>
</div>
<div class="input-form">
    <h3>Filtro</h3>
    <form method="get" action="amministratore/ordini">
        <label for="cd">CD</label>
        <select name="cd" id="cd">
            <option value="">Qualsiasi</option>
            <?php foreach ($CDs as $CD) { ?>
                <option value="<?= $CD->getId() ?>" ><?= $CD->getModello()->getNome() . " " . $CD->getTarga() ?></option>
            <?php } ?>
        </select>
        <br/>
        <label for="utente">utente</label>
        <select name="utente" id="utente">
            <option value="">Qualsiasi</option>
            <?php foreach ($clienti as $utente) { ?>
                <option value="<?= $utente->getId() ?>" ><? echo $utente->getNome() . " " . $utente->getCognome()?></option>
            <?php } ?>
        </select>
        <br/>
        <button id="filtra" type="submit" name="cmd">Cerca</button>
    </form>
</div>



<h3>Elenco Catalogo</h3>

<p id="nessuno">Nessun CD trovato</p>

<table id="tabella_ordini">
    <thead>
        <tr>
            <th>Utente</th>
            <th>Album</th>
            <th>Costo</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
