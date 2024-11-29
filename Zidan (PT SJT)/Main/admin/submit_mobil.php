<?php
header('Content-Type: application/json'); // Set header for JSON response
ob_start(); // Start output buffering

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = file_get_contents('../data/mobil.json');
    $mobilData = json_decode($jsonData, true);

    // Ensure $mobilData is an array
    if (!is_array($mobilData)) {
        $mobilData = []; // Initialize as an empty array if JSON is invalid or empty
    }

    $namaMobil = $_POST['namaMobil'];
    $hargaMobil = (int)$_POST['hargaMobil'];
    $noPol = $_POST['noPol'];

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $targetDir = "../uploads/mobil/";
        $fileName = basename($_FILES["gambar"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {
            $gambarUrl = $targetFilePath;
        } else {
            ob_end_clean(); // Clean any output buffering before sending JSON response
            echo json_encode(["success" => false, "message" => "Failed to upload the image."]);
            exit;
        }
    } else {
        ob_end_clean(); // Clean any output buffering before sending JSON response
        echo json_encode(["success" => false, "message" => "No image file uploaded."]);
        exit;
    }

    $lastIdMobil = count($mobilData) > 0 ? max(array_column($mobilData, 'idMobil')) : 0;
    $newIdMobil = $lastIdMobil + 1;

    $newMobil = [
        "idMobil" => strval($newIdMobil),
        "namaMobil" => $namaMobil,
        "hargaMobil" => $hargaMobil,
        "gambar" => $gambarUrl,
        "noPol" => $noPol,
        "status" => "Tersedia"
    ];

    $mobilData[] = $newMobil;

    if (file_put_contents('../data/mobil.json', json_encode($mobilData, JSON_PRETTY_PRINT))) {
        ob_end_clean(); // Clean any output buffering before sending JSON response
        echo json_encode(["success" => true, "message" => "Data mobil berhasil ditambahkan!"]);
    } else {
        ob_end_clean(); // Clean any output buffering before sending JSON response
        echo json_encode(["success" => false, "message" => "Failed to save data to JSON file."]);
    }
} else {
    ob_end_clean(); // Clean any output buffering before sending JSON response
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

ob_end_flush(); // Flush the output buffer
?>
