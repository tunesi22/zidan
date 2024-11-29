<?php
header('Content-Type: application/json');

$jsonFilePath = '../data/rekening.json';

if (file_exists($jsonFilePath)) {
    $jsonData = file_get_contents($jsonFilePath);
    $data = json_decode($jsonData, true);

    if (isset($data['rekening'])) {
        echo json_encode(['status' => 'success', 'rekening' => $data['rekening']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Rekening data not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Rekening file not found.']);
}
?>
