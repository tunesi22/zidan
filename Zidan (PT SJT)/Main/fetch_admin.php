<?php
header('Content-Type: application/json');

$filePath = 'data/admin.json';

if (file_exists($filePath)) {
    $jsonData = file_get_contents($filePath);
    echo $jsonData;
} else {
    http_response_code(404);
    echo json_encode(["error" => "File not found"]);
}
?>
