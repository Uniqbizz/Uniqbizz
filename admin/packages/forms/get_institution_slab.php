<?php

require '../../connect.php';

$data = $conn->prepare("
    SELECT id, lower_limit, upper_limit, institution_commission
    FROM institution_slab
    WHERE status = 1
    ORDER BY id
");

$data->execute();

echo json_encode($data->fetchAll(PDO::FETCH_ASSOC));