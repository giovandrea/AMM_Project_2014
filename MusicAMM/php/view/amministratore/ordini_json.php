<?php

$json = array();
$json['errori'] = $errori;
$json['noleggi'] = array();
foreach ($ordini as $ordine) {

    $element = array();
    $element['cliente'] = $ordine->getCliente()->getNome() . " " . $ordine->getCliente()->getCognome();
    $element['album'] = $ordine->getAlbum();
    $element['costo'] = $ordine->getCosto();

    $json['noleggi'][] = $element;
}

echo json_encode($json);

?>
