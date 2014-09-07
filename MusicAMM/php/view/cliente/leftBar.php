<h2>Cliente</h2>
<ul>
    <li class="<?= $vd->getSottoPagina() == 'home' || $vd->getSottoPagina() == null ? 'current_page_item' : '' ?>"><a href="cliente">Home</a></li>
    <li class="<?= $vd->getSottoPagina() == 'anagrafica' ? 'current_page_item' : '' ?>"><a href="cliente/anagrafica">Visiona Anagrafica</a></li>
    <li class="<?= $vd->getSottoPagina() == 'acquisti' ? 'current_page_item' : '' ?>"><a href="cliente/acquisti">Ordini Effettuati</a></li>
    <li class="<?= $vd->getSottoPagina() == 'cds' ? 'current_page_item' : '' ?>"><a href="cliente/cds">Catalogo CD</a></li>
    <li class="<?= $vd->getSottoPagina() == 'readme' ? 'current_page_item' : '' ?>"><a href="cliente/readme">Informazioni Sul Sito</a></li>
</ul>
