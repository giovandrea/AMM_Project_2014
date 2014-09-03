<div class="input-form">
    <h3>Inserisci nuovo cd</h3>
    <form method="post" action="amministratore/crea_cd">
        <input type="hidden" name="cmd" value="nuovo_cd"/>
        <label for="caratterizzazione">Caratterizzazione</label>
        <select name="caratterizzazione" id="caratterizzazione">
            <?php foreach ($caratterizzazioni as $caratterizzazione) { ?>
                <option value="<?= $caratterizzazione->getId() ?>" >
                    <?= $caratterizzazione->getArtista()->getNome() . " " . $caratterizzazione->getTitolo() 
                    ?></option>
            <?php } ?>
        </select>
        <br/>
        <label for="anno">Anno</label>
        <input type="anno" name="anno" id="anno"/>
        <div class="btn-group">
            <button type="submit" name="cmd" value="cd_nuovo">Inserisci</button>
            <button type="submit" name="cmd" value="cd_annulla">Annulla</button>
        </div>
    </form>
</div>
