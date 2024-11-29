<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['idMobil']) && isset($data['status'])) {
    $file = '../data/mobil.json';
    $mobilData = json_decode(file_get_contents($file), true);

    foreach ($mobilData as &$car) {
        if ($car['idMobil'] == $data['idMobil']) {
            $car['status'] = $data['status'];
            break;
        }
    }

    if (file_put_contents($file, json_encode($mobilData, JSON_PRETTY_PRINT))) {
        echo json_encode(['status' => 'success', 'message' => 'Mobil status updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating mobil status']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
}
?>
