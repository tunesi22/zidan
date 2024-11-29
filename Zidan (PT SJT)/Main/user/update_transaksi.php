<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$uploadDir = '../uploads/bukti/';

// Ensure the directory exists
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && isset($_POST['transaksiData'])) {
        $file = $_FILES['file'];
        $transaksiData = json_decode($_POST['transaksiData'], true);

        // Check for upload errors
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = basename($file['name']);
            $filePath = $uploadDir . $fileName;
            $fileUrl = str_replace('../', '', $filePath); // Create URL-friendly path for storage

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                // Update the bukti field with the URL of the uploaded image
                $transaksiData['bukti'] = $fileUrl;

                // Read the existing JSON file
                $jsonFile = '../data/transaksi.json';
                $currentData = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

                // Determine the next `idTransaksi`
                $lastId = 0;
                foreach ($currentData as $item) {
                    if (isset($item['idTransaksi']) && $item['idTransaksi'] > $lastId) {
                        $lastId = $item['idTransaksi'];
                    }
                }
                $transaksiData['idTransaksi'] = $lastId + 1; // Increment the last ID by 1

                // Append the new data
                $currentData[] = $transaksiData;

                // Save back to the JSON file
                if (file_put_contents($jsonFile, json_encode($currentData, JSON_PRETTY_PRINT))) {
                    echo json_encode(['status' => 'success', 'message' => 'Data saved successfully']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error saving data']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'File upload error']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data or missing file']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
