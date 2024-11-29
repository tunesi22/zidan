<?php
header('Content-Type: application/json');

$file = '../data/admin.json';

if (file_exists($file)) {
    $admin = json_decode(file_get_contents($file), true);
    $lastIdAdmin = !empty($admin) ? max(array_column($admin, 'idAdmin')) : 0;
} else {
    $lastIdAdmin = 0;
}

echo json_encode(['lastIdAdmin' => $lastIdAdmin]);
?>