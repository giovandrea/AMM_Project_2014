<h2>Amministratore</h2>
<ul>
    <li class="<?= $vd->getSottoPagina() == 'home' || $vd->getSottoPagina() == null ? 'current_page_item' : ''?>"><a href="dipendente/home">Home</a></li>
    <li class="<?= $vd->getSottoPagina() == 'anagrafica' ? 'current_page_item' : '' ?>"><a href="dipendente/anagrafica">Anagrafica</a></li>
    <li class="<?= $vd->getSottoPagina() == 'catalogo' ? 'current_page_item' : '' ?>"><a href="dipendente/auto">Catalogo CD</a></li>
    <li class="<?= $vd->getSottoPagina() == 'ordini' ? 'current_page_item' : '' ?>"><a href="dipendente/noleggi">Elenco ordini</a></li></ul>
