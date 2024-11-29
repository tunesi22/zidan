<?php
$jsonData = file_get_contents('../data/transaksi.json');
$mobilData = file_get_contents('../data/mobil.json');

$data = json_decode($jsonData, true);
$dataMobil = json_decode($mobilData, true); 

$mobilMap = [];
foreach ($dataMobil as $mobil) {
    $mobilMap[$mobil['idMobil']] = $mobil['namaMobil'];
}

$uniqueUsers = [];
foreach ($data as $transaction) {
    if (!empty($transaction['user']) && !isset($uniqueUsers[$transaction['user']])) {
        $uniqueUsers[$transaction['user']] = $transaction;
    }
}

$html = '';
foreach ($uniqueUsers as $user => $transaction) {
    $idMobil = $transaction['mobil'];
    $namaMobil = isset($mobilMap[$idMobil]) ? $mobilMap[$idMobil] : 'Unknown Mobil';
    $tanggal = is_array($transaction['tanggal']) ? implode(', ', $transaction['tanggal']) : $transaction['tanggal'];

    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($transaction['nama']) . '</td>';
    $html .= '<td>' . htmlspecialchars($transaction['user']) . '</td>';
    $html .= '<td>' . htmlspecialchars($transaction['noTelp']) . '</td>';
    $html .= '<td>' . htmlspecialchars($transaction['alamat']) . '</td>';
    $html .= '<td>' . htmlspecialchars($transaction['kota']) . '</td>';
    $html .= '<td>' . htmlspecialchars($namaMobil) . '</td>';
    $html .= '<td><button class="btn btn-primary" onclick="userCek(\'' . htmlspecialchars($transaction['user']) . '\')">Cek</button></td>';
    $html .= '</tr>';
}

echo $html;
?>
