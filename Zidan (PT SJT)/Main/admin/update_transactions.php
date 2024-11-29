<?php
$dataFile = '../data/transaksi.json';

if (file_exists($dataFile) && filesize($dataFile) > 0) {
    $transaksiData = json_decode(file_get_contents($dataFile), true);

    if ($transaksiData) {
        $today = new DateTime();

        foreach ($transaksiData as &$transaksi) {
            if ($transaksi['status'] === "Sedang Diproses") {
                $transaksiDate = new DateTime($transaksi['tanggal']); 

                if ($today->format('Y-m-d') !== $transaksiDate->format('Y-m-d')) {
                    $transaksi['status'] = "Selesai";
                }
            }
        }

        file_put_contents($dataFile, json_encode($transaksiData, JSON_PRETTY_PRINT));

        echo json_encode(["status" => "success", "message" => "Transactions updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to read transactions data"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Data transaksi masih kosong"]);
}
?>
