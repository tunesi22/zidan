<?php
header('Content-Type: application/json');

$jsonFile = '../data/transaksi.json';

$jsonData = file_get_contents($jsonFile);
$data = json_decode($jsonData, true);

$currentDate = date('m/d/Y');

foreach ($data as &$transaksi) {
    if ($transaksi['status'] === 'Diproses' && isset($transaksi['disetujui']) && !empty($transaksi['disetujui'])) {
        $disetujuiDate = DateTime::createFromFormat('m/d/Y', $transaksi['disetujui']);
        $currentDateObj = DateTime::createFromFormat('m/d/Y', $currentDate);

        if ($currentDateObj > $disetujuiDate) {
            $transaksi['status'] = 'Sukses';
        }
    }
}

file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));

echo json_encode($data);
?>
