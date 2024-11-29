<?php
// fab.php

header('Content-Type: application/json');

// Define the path to the fab.json file
$jsonFilePath = 'data/fab.json';

// Check if the fab.json file exists
if (file_exists($jsonFilePath)) {
    // Read the JSON file contents
    $jsonData = file_get_contents($jsonFilePath);

    // Convert JSON data into an associative array
    $data = json_decode($jsonData, true);

    // Check if the data is valid
    if ($data === null) {
        // JSON decode failed
        echo json_encode(['error' => 'Invalid JSON format in fab.json']);
    } else {
        // Send the data as a response
        echo json_encode($data);  // Send the data directly as it matches the expected structure
    }
} else {
    // Handle the case where fab.json doesn't exist
    echo json_encode(['error' => 'fab.json file not found']);
}
?>
