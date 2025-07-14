<?php
require '../../connect.php';

$designation = $_POST['designation'];
$users = [];

if ($designation == '24' || $designation == '25') {
    // BCM or BDM from employees
    $stmt = $conn->prepare("SELECT employee_id AS user_id, CONCAT(name, ' (', employee_id, ')') AS fullname FROM employees WHERE user_type = :designation AND status = 1");
    $stmt->execute(['designation' => $designation]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} elseif ($designation == '26') {
    // BM from business_mentor
    $stmt = $conn->prepare("SELECT business_mentor_id AS user_id, CONCAT(firstname, ' ', lastname, ' (', business_mentor_id, ')') AS fullname FROM business_mentor WHERE status = 1");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($designation == '16') {
    // BM from corporate_agency
    $stmt = $conn->prepare("SELECT corporate_agency_id AS user_id, CONCAT(firstname, ' ', lastname, ' (', corporate_agency_id, ')') AS fullname FROM corporate_agency WHERE status = 1");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode($users);
