<?php
require '../../connect.php';

header('Content-Type: application/json');

$uniqueCode = trim($_POST['uniqueCode'] ?? '');

$stmt = $conn->prepare("SELECT COUNT(*) FROM package WHERE unique_code = ?");
$stmt->execute([$uniqueCode]);

echo json_encode([
    "exists" => $stmt->fetchColumn() > 0
]);