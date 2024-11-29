<?php
$jsonData = file_get_contents('../data/transaksi.json');
$mobilData = file_get_contents('../data/mobil.json');

$data = json_decode($jsonData, true);
$dataMobil = json_decode($mobilData, true);

$mobilMap = [];
foreach ($dataMobil as $mobil) {
    $mobilMap[$mobil['idMobil']] = $mobil['namaMobil'];
}

$filteredData = array_filter($data, function($transaction) {
    return $transaction['status'] === 'Reject';
});

$html = '';
foreach ($filteredData as $transaction) {
    $idMobil = $transaction['mobil'];
    $namaMobil = isset($mobilMap[$idMobil]) ? $mobilMap[$idMobil] : 'Unknown Mobil';
    $tanggal = is_array($transaction['tanggal']) ? implode(', ', $transaction['tanggal']) : $transaction['tanggal'];

    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($transaction['nama']) . '</td>';
    $html .= '<td>' . htmlspecialchars($transaction['user']) . '</td>';
    $html .= '<td>' . htmlspecialchars($transaction['submit']) . '</td>';
    $html .= '<td>' . htmlspecialchars($transaction['idTransaksi']) . '</td>';
    $html .= '<td>' . htmlspecialchars($transaction['noTelp']) . '</td>';
    $html .= '<td><a href="#" data-bs-toggle="modal" data-bs-target="#buktiModal" onclick="showImageModal(\'' . htmlspecialchars($transaction['bukti']) . '\')">' . htmlspecialchars($transaction['bukti']) . '</a></td>';
    $html .= '<td>' . htmlspecialchars($transaction['alamat']) . '</td>';
    $html .= '<td>' . htmlspecialchars($transaction['kota']) . '</td>';
    $html .= '<td>' . htmlspecialchars($tanggal) . '</td>';
    $html .= '<td>' . htmlspecialchars($transaction['totalBayar']) . '</td>';
    $html .= '<td>' . htmlspecialchars($namaMobil) . '</td>';
    $html .= '<td>' . htmlspecialchars($transaction['status']) . '</td>';
    $html .= '<td><button class="btn btn-primary" id="cekSuksesBtn" onClick="suksesCek(' . $transaction['idTransaksi'] . ')">Cek</button></td>';
    $html .= '</tr>';
}

echo $html;
?>
