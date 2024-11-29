<?php
header('Content-Type: application/json');

$jsonFile = '../data/transaksi.json';
$jsonData = file_get_contents($jsonFile);
$data = json_decode($jsonData, true);

if (isset($_POST['idTransaksi']) && isset($_POST['status'])) {
    $idTransaksi = $_POST['idTransaksi'];
    $status = $_POST['status'];
    $disetujui = isset($_POST['disetujui']) ? $_POST['disetujui'] : null;

    foreach ($data as &$transaksi) {
        if ($transaksi['idTransaksi'] == $idTransaksi) {
            $transaksi['status'] = $status;
            
            if ($disetujui) {
                $transaksi['disetujui'] = $disetujui;
            }

            break;
        }
    }

    $updatedJsonData = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($jsonFile, $updatedJsonData);

    echo json_encode(['message' => 'Status updated successfully']);
} else {
    echo json_encode(['message' => 'Invalid request']);
}
?>
