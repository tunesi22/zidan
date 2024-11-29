<?php
session_start();

$userId = isset($_GET['userId']) ? intval($_GET['userId']) : null;

if ($userId === null) {
    echo json_encode(['error' => 'User ID is required']);
    exit;
}

$transaksiData = json_decode(file_get_contents('../data/transaksi.json'), true);

$filteredData = array_filter($transaksiData, function ($transaksi) use ($userId) {
    return $transaksi['user'] == $userId;
});

header('Content-Type: application/json');
echo json_encode(array_values($filteredData));
?>
