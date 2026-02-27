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
} elseif ($designation == '28') {
    // MF from master_franchisee
    $stmt = $conn->prepare("SELECT master_franchisee_id AS user_id, CONCAT(firstname, ' ', lastname, ' (', master_franchisee_id, ')') AS fullname FROM master_franchisee WHERE status = 1");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($designation == '30') {
    // SF from sponsor_franchisee
    $stmt = $conn->prepare("SELECT sponsor_franchisee_id AS user_id, CONCAT(firstname, ' ', lastname, ' (', sponsor_franchisee_id, ')') AS fullname FROM sponsor_franchisee WHERE status = 1");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}elseif ($designation == '29') {
    // F from sub_franchisee
    $stmt = $conn->prepare("SELECT sub_franchisee_id AS user_id, CONCAT(firstname, ' ', lastname, ' (', sub_franchisee_id, ')') AS fullname FROM sub_franchisee WHERE status = 1");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}  elseif ($designation == '16') {
    // TE from corporate_agency
    $stmt = $conn->prepare("SELECT corporate_agency_id AS user_id, CONCAT(firstname, ' ', lastname, ' (', corporate_agency_id, ')') AS fullname FROM corporate_agency WHERE status = 1");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode($users);
