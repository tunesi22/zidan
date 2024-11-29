<?php
header('Content-Type: application/json');

$jsonFilePath = '../data/transaksi.json';

if (!file_exists($jsonFilePath)) {
    echo json_encode(['error' => 'File transaksi.json tidak ditemukan.']);
    exit;
}

$jsonData = file_get_contents($jsonFilePath);

if (empty(trim($jsonData))) {
    echo json_encode(['error' => 'Data kosong di file transaksi.json.']);
    exit;
}

$data = json_decode($jsonData, true);

if ($data === null) {
    echo json_encode(['error' => 'Gagal decode JSON, format tidak valid.']);
    exit;
}

echo json_encode($data);
?>
