<?php
require '../connect.php'; // Include your database connection
header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'pending_te') {
    getPendingTE();
} elseif ($action == 'registered_te') {
    getRegisteredTE();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid action"]);
}

function getPendingTE() {
    global $conn;
    
    $sql = "SELECT * FROM `corporate_agency` WHERE status = '2' OR status = '0' ORDER BY corporate_agency_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($employees as &$row) {
        $row['date_of_birth'] = formatDate($row['date_of_birth']);
        $row['register_date'] = formatDate($row['register_date']);
    }

    echo json_encode(["status" => "success", "data" => $employees]);
}

function getRegisteredTE() {
    global $conn;
    
    $sql = "SELECT * FROM `corporate_agency` WHERE status = '1' OR status = '3' ORDER BY corporate_agency_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($employees as &$row) {
        $row['date_of_birth'] = formatDate($row['date_of_birth']);
        $row['register_date'] = formatDate($row['register_date']);
    }

    echo json_encode(["status" => "success", "data" => $employees]);
}

function formatDate($date) {
    return (!empty($date) && strtotime($date)) ? date('d-m-Y', strtotime($date)) : 'N/A';
}

function formatDateTime($dateTime) {
    return (!empty($dateTime) && strtotime($dateTime)) ? date('d-m-Y H:i:s', strtotime($dateTime)) : 'N/A';
}

?>
