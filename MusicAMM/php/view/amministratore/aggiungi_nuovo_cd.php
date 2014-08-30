<div class="input-form">
    <h3>Inserisci nuovo CD</h3>
    <form method="post" action="amministratore/crea_cd">
        <input type="hidden" name="cmd" value="nuovo_cd"/>
        <label for="artista">Artista</label>
	<input type="artista" name="artista" id="artista"/>        
        <br/>
        <label for="anno">Anno</label>
        <input type="anno" name="anno" id="anno"/>
        <br/>
        <label for="titolo">Titolo</label>
        <input type="titolo" name="titolo" id="titolo"/>
        <br/>
        <label for="prezzo">Prezzo</label>
        <input type="prezzo" name="prezzo" id="prezzo"/>
        <br/>
        <div class="btn-group">
            <button type="submit" name="cmd" value="CD_nuovo">Salva</button>
            <button type="submit" name="cmd" value="a_annulla">Annulla</button>
        </div>
    </form>
</div>
