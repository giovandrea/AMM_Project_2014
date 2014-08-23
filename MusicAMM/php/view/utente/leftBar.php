<h2>Utente</h2>
<ul>
    <li class="<?= $vd->getSottoPagina() == 'home' || $vd->getSottoPagina() == null ? 'current_page_item' : '' ?>"><a href="cliente">Home</a></li>
    <li class="<?= $vd->getSottoPagina() == 'anagrafica' ? 'current_page_item' : '' ?>"><a href="cliente/anagrafica">Anagrafica</a></li>
    <li class="<?= $vd->getSottoPagina() == 'noleggi' ? 'current_page_item' : '' ?>"><a href="cliente/noleggi">Catalogo</a></li>
</ul>
