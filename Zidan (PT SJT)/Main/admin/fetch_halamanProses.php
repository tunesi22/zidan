<?php
header('Content-Type: application/json');

$jsonFile = '../data/transaksi.json';

$jsonData = file_get_contents($jsonFile);

$data = json_decode($jsonData, true);

if (isset($_GET['idTransaksi'])) {
    $idTransaksi = $_GET['idTransaksi'];

    $selectedTransaksi = array_filter($data, function ($transaksi) use ($idTransaksi) {
        return $transaksi['idTransaksi'] == $idTransaksi;
    });

    echo json_encode(array_values($selectedTransaksi));
} else {
    echo json_encode($data);
}
?>
