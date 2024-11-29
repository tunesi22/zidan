<?php
header('Content-Type: application/json'); 

$jsonFilePath = '../data/rekening.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = file_get_contents('php://input');
    $request = json_decode($postData, true);

    $newRekening = $request['nomorRekeningBaru'] ?? '';

    if (!empty($newRekening)) {
        $jsonData = file_get_contents($jsonFilePath);
        $data = json_decode($jsonData, true);

        $data['rekening'] = $newRekening;

        if (file_put_contents($jsonFilePath, json_encode($data, JSON_PRETTY_PRINT))) {
            echo json_encode(['status' => 'success', 'message' => 'Rekening berhasil diperbarui!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui rekening.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Nomor rekening baru tidak boleh kosong.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
