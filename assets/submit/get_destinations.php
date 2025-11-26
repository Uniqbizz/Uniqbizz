<?php
require '../../connect.php';
//changed destination to location for DB query by SV on 19-11-2025 
$sql = 'SELECT id, name, location FROM `package` WHERE status = 1';
$stmt = $conn->prepare($sql);
$stmt->execute(); // ✅ Execute the prepared statement

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convert data to Select2 format
$data = [];

foreach ($results as $row) {
    $data[] = [
        "id" => $row['id'],
        "text" => $row['name'],
        "description" => $row['location']
    ];
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
