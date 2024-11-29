<?php
header('Content-Type: application/json');

$file = '../data/user.json';

if (file_exists($file)) {
    $users = json_decode(file_get_contents($file), true);
    $lastIdUser = !empty($users) ? max(array_column($users, 'idUser')) : 0;
} else {
    $lastIdUser = 0;
}

echo json_encode(['lastIdUser' => $lastIdUser]);
?>
