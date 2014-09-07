<div class="input-form">
    <h3>Nuova prenotazione</h3>
    <form method="post" action="cliente/acquista">
        <input type="hidden" name="cmd" value="nuovo_acquisto"/>
        <input type="hidden" name="idcd" value="<?= $idcd ?>" />
        <label for="datainizio">Data inizio</label>
        <input type="andatainiziono" name="datainizio" id="datainizio"/>
        <br/>
        <label for="datafine">Data fine</label>
        <input type="datafine" name="datafine" id="datafine"/>
        <br/>
        <div class="btn-group">
            <button type="submit" name="cmd" value="nuovo_acquisto">Prenota</button>
            <button type="submit" name="cmd" value="p_annulla">Indietro</button>
        </div>
    </form>
</div>
