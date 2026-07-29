<?php

require '../../connect.php';

$stmt = $conn->prepare("
    SELECT gst
    FROM gst
    ORDER BY id DESC
    LIMIT 1
");

$stmt->execute();

echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));