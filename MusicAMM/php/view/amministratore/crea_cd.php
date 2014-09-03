<div class="input-form">
    <h3>Inserisci nuovo cd</h3>
    <form method="post" action="amministratore/crea_cd">
        <input type="hidden" name="cmd" value="nuovo_cd"/>
        <label for="artista">Artista</label>
        <select name="artista" id="artista">
            <?php foreach ($caratterizzazioni as $caratterizzazione) { ?>
                <option value="<?= $caratterizzazione->getId() ?>" >
                    <?= $caratterizzazione->getArtista()->getNome()
                    ?></option>
            <?php } ?>
        </select>
        <br/>
        	<label for="titolo">Titolo</label>
        	<input type="titolo" name="titolo" id="titolo"/>
	<br/>
		<label for="anno">Anno</label>
        	<input type="anno" name="anno" id="anno"/>
	<br/>
		<label for="prezzo">Prezzo</label>
        	<input type="prezzo" name="prezzo" id="prezzo"/>
        <div class="btn-group">
            <button type="submit" name="cmd" value="cd_nuovo">Inserisci</button>
            <button type="submit" name="cmd" value="a_annulla">Annulla</button>
        </div>
    </form>
</div>
