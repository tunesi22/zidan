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

$disabledDatesList = [];

$today = date("Y-m-d");

foreach ($filteredData as $transaksi) {
    list($startDate, $endDate) = explode(' / ', $transaksi['tanggal']);
    
    if ($startDate <= $today && $endDate >= $today) {
        $disabledDatesList[] = $transaksi['tanggal'];
    } elseif ($startDate >= $today) {
        $disabledDatesList[] = $transaksi['tanggal'];
    }
}

header('Content-Type: application/json');
echo json_encode(array_values(array_unique($disabledDatesList)));
?>
