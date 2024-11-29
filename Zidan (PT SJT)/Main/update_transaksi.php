<?php
header('Content-Type: application/json');

$jsonFile = '../data/transaksi.json';

$jsonData = file_get_contents($jsonFile);
$data = json_decode($jsonData, true);

$updatedTransactions = json_decode(file_get_contents('php://input'), true);

if ($updatedTransactions) {
    foreach ($updatedTransactions as $updatedTransaksi) {
        foreach ($data as &$transaksi) {
            if ($transaksi['idTransaksi'] == $updatedTransaksi['idTransaksi']) {
                $transaksi['status'] = $updatedTransaksi['status'];
                break;
            }
        }
    }

    file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));

    echo json_encode(['message' => 'Transactions updated successfully']);
} else {
    echo json_encode(['message' => 'No transactions to update']);
}
?>
