<?php
require '../../connect.php';

$sql = 'SELECT id, name, destination FROM `package` WHERE status = 1';
$stmt = $conn->prepare($sql);
$stmt->execute(); // ✅ Execute the prepared statement

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convert data to Select2 format
$data = [];

foreach ($results as $row) {
    $data[] = [
        "id" => $row['id'],
        "text" => $row['name'],
        "description" => $row['destination']
    ];
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
