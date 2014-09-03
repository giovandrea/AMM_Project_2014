<?php

$json = array();
$json['errori'] = $errori;
$json['acquisti'] = array();
foreach ($acquisti as $acquisto) {

    $element = array();
    $element['cliente'] = $acquisto->getCliente()->getNome() . " " . $acquisto->getCliente()->getCognome();
    $element['cd'] = $acquisto->getCd()->getCaratterizzazione()->getArtista()->getNome() . " " . $acquisto->getCd()->getCaratterizzazione()->getTitolo();
    $element['costo'] = $acquisto->getCosto();

    $json['acquisti'][] = $element;
}

echo json_encode($json);

?>
