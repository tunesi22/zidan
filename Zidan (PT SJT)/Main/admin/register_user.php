<?php
header('Content-Type: application/json');

// Ambil data dari request
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $userFile = '../data/user.json';

    $currentUsers = [];
    if (file_exists($userFile)) {
        $fileContent = file_get_contents($userFile);
        $currentUsers = json_decode($fileContent, true);
        
        if (!is_array($currentUsers)) {
            $currentUsers = [];
        }
    }
    
    // Cari ID terakhir
    $lastIdUser = 0;
    foreach ($currentUsers as $user) {
        if (isset($user['idUser']) && (int)$user['idUser'] > $lastIdUser) {
            $lastIdUser = (int)$user['idUser'];
        }
    }
    
    // Buat ID baru
    $newIdUser = $lastIdUser + 1;
    
    // Buat data user baru
    $newUser = array(
        'idUser' => $newIdUser,
        'username' => $data['username'],
        'password' => $data['password'],
        'noTelp' => $data['noTelp'],
        'alamat' => $data['alamat'],
        'kota' => $data['kota'],
        'mobil' => $data['mobil']
    );
    
    // Tambahkan user baru ke array
    $currentUsers[] = $newUser;
    
    // Simpan data ke file
    if (file_put_contents($userFile, json_encode($currentUsers, JSON_PRETTY_PRINT))) {
        echo json_encode(['status' => 'success', 'message' => 'User registered successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error saving user data']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
}
?>
