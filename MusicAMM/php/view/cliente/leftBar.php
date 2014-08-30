<h2>Cliente</h2>
<ul>
    <li class="<?= $vd->getSottoPagina() == 'home' || $vd->getSottoPagina() == null ? 'current_page_item' : '' ?>"><a href="cliente">Home</a></li>
    <li class="<?= $vd->getSottoPagina() == 'anagrafica' ? 'current_page_item' : '' ?>"><a href="cliente/anagrafica">Anagrafica</a></li>
    <li class="<?= $vd->getSottoPagina() == 'ordini' ? 'current_page_item' : '' ?>"><a href="cliente/ordini">Ordini</a></li>
    <li class="<?= $vd->getSottoPagina() == 'catalogo_cd' ? 'current_page_item' : '' ?>"><a href="cliente/catalogo_cd">Catalogo CD</a></li>
</ul>
