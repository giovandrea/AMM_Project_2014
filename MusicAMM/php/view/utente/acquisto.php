<div class="input-form">
    <h3>Nuovo acquisto</h3>
    <form method="post" action="utente/prenota">
        <input type="hidden" name="cmd" value="nuovo_acquisto"/>
        <input type="hidden" name="idCD" value="<?= $idCD ?>" />
	<label for="artista">Artista</label>
        <input type="artista" name="artista" id="artista"/>
	<label for="titolo">Titolo</label>
        <input type="titolo" name="titolo" id="titolo"/>
        <div class="btn-group">
            <button type="submit" name="cmd" value="nuova_acquisto">Acquista</button>
            <button type="submit" name="cmd" value="p_annulla">Annulla</button>
        </div>
    </form>
</div>
