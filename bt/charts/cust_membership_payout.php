<?php
require '../connect.php'; // Assumes $conn is a PDO instance

$type = $_POST['type'] ?? 'all';
$month = $_POST['month'] ?? '';
$year = $_POST['year'] ?? '';

$where = "status NOT IN (0, 3)"; // exclude deleted & unregistered
$params = [];

// Membership filter
if ($type !== 'all') {
    $where .= " AND customer_type = :type";
    $params[':type'] = $type;
}

// Date filter
if (!empty($month) && !empty($year)) {
    $where .= " AND MONTH(added_on) = :month AND YEAR(added_on) = :year";
    $params[':month'] = $month;
    $params[':year'] = $year;
}

// Complementary Paid
$sql1 = "SELECT SUM(paid_amount) AS total FROM ca_customer WHERE $where AND comp_chek = 1 AND paid_amount > 0";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute($params);
$complementary_paid = (float)($stmt1->fetchColumn() ?? 0);

// Non-Complementary Paid
$sql2 = "SELECT SUM(paid_amount) AS total FROM ca_customer WHERE $where AND comp_chek = 2 AND paid_amount > 0";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute($params);
$non_complementary_paid = (float)($stmt2->fetchColumn() ?? 0);

echo json_encode([
    "complementary_paid" => $complementary_paid,
    "non_complementary_paid" => $non_complementary_paid
]);
?>
