<?php
$jsonData = file_exists('../data/transaksi.json') ? file_get_contents('../data/transaksi.json') : '';
$mobilData = file_exists('../data/mobil.json') ? file_get_contents('../data/mobil.json') : '';


$data = json_decode($jsonData, true);
$dataMobil = json_decode($mobilData, true);

$mobilMap = [];
if (is_array($dataMobil)) {
    foreach ($dataMobil as $mobil) {
        $mobilMap[$mobil['idMobil']] = $mobil['namaMobil'];
    }
}

$groupedData = [];
if (is_array($data)) {
    foreach ($data as $transaction) {
        if ($transaction['status'] === 'Belum Diproses') {
            $date = $transaction['submit'];
            if (!isset($groupedData[$date])) {
                $groupedData[$date] = [];
            }
            $groupedData[$date][] = $transaction;
        }
    }
}

krsort($groupedData);

$html = '';

if (empty($groupedData)) {
    $html = '<p>Data tidak tersedia di database, Belum ada data yang masuk</p>';
} else {
    foreach ($groupedData as $date => $transactions) {
        $html .= '<div class="separator">';
        $html .= '<p class="tanggalBulan">' . $date . '</p>';
        $html .= '<div class="cardProfile">';

        foreach ($transactions as $transaction) {
            $idMobil = $transaction['mobil'];
            $namaMobil = isset($mobilMap[$idMobil]) ? $mobilMap[$idMobil] : 'Unknown Mobil';

            $html .= '<div class="leftContent" onclick="saveDataAndRedirect(' . $transaction['idTransaksi'] . ')">';
            $html .= '<div class="isiContentLeft">';
            $html .= '<a href="#" class="namaUser">' . $transaction['nama'] . '</a>';
            $html .= '<a href="#" class="jenisNamaMobil">' . $namaMobil . '</a>';
            $html .= '<a href="#" class="kodePesanan">Kode Pesanan : ' . $transaction['idTransaksi'] . '</a>';
            $html .= '<a href="#" class="statusMobil">Status : ' . $transaction['status'] . '</a>';
            $html .= '</div>';
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';
    }
}

echo $html;
?>
