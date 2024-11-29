<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $adminFile = '../data/admin.json';
    
    $currentAdmins = file_exists($adminFile) ? json_decode(file_get_contents($adminFile), true) : [];
    
    $lastIdAdmin = 0;
    foreach ($currentAdmins as $admin) {
        if ((int)$admin['idAdmin'] > $lastIdAdmin) {
            $lastIdAdmin = (int)$admin['idAdmin'];
        }
    }
    
    $newIdAdmin = $lastIdAdmin + 1;
    
    $newAdmin = array(
        'idAdmin' => $newIdAdmin,
        'username' => $data['username'],
        'password' => $data['password']
    );
    
    $currentAdmins[] = $newAdmin;
    
    if (file_put_contents($adminFile, json_encode($currentAdmins, JSON_PRETTY_PRINT))) {
        echo json_encode(['status' => 'success', 'message' => 'Admin registered successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error saving admin data']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
}
?>
