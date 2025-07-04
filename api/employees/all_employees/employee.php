<?php
require '../../connect.php'; // Include your database connection
header('Content-Type: application/json');
 
$action = isset($_GET['action']) ? $_GET['action'] : '';
 
if ($action == 'pending_employees') {
    getPendingEmployees();
} elseif ($action == 'registered_employees') {
    getRegisteredEmployees();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid action"]);
}
 
function getPendingEmployees() {
    global $conn;
   
    $sql = "SELECT * FROM `employees` WHERE status = '2' OR status = '0' ORDER BY employee_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    foreach ($employees as &$row) {
        $row['date_of_birth'] = date('d-m-Y', strtotime($row['date_of_birth']));
        $row['register_date'] = formatDate($row['register_date']);
       
        $row['reporting_manager_name'] = getReportingManagerName($row['reporting_manager']);
    }
 
    echo json_encode(["status" => "success", "data" => $employees]);
}
 
function getRegisteredEmployees() {
    global $conn;
   
    $sql = "SELECT * FROM `employees` WHERE (status = '1' OR status = '3') AND (employee_id != 'null' AND employee_id != '') ORDER BY employee_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    foreach ($employees as &$row) {
        $row['date_of_birth'] = date('d-m-Y', strtotime($row['date_of_birth']));
        $row['register_date'] = formatDate($row['register_date']);
       
        $row['reporting_manager_name'] = getReportingManagerName($row['reporting_manager']);
    }
 
    echo json_encode(["status" => "success", "data" => $employees]);
}
 
function formatDate($date) {
    return (!empty($date) && strtotime($date)) ? date('d-m-Y', strtotime($date)) : 'N/A';
}
 
function formatDateTime($dateTime) {
    return (!empty($dateTime) && strtotime($dateTime)) ? date('d-m-Y H:i:s', strtotime($dateTime)) : 'N/A';
}
 
function getReportingManagerName($managerId) {
    global $conn;
 
    if (!empty($managerId) && $managerId != 'null' && $managerId != NULL) {
        $stmt = $conn->prepare("SELECT name FROM `employees` WHERE employee_id = :manager_id");
        $stmt->execute(['manager_id' => $managerId]);
        $manager = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($manager && isset($manager['name'])) ? $manager['name'] : 'N/A';
    }
    return 'N/A';
}
 
?>