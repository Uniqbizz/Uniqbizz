<?php
require '../connect.php';

$year = $_POST['year'] ?? '';
$month = $_POST['month'] ?? '';
$type = strtolower($_POST['type'] ?? 'all'); // normalize to lowercase

$rows = [];

// Base SQL query
$sql = "
    SELECT 
        added_on AS created_date,
        firstname,
        lastname,
        paid_amount AS amount,
        customer_type AS membership,
        CASE comp_chek 
            WHEN 1 THEN 'Yes' 
            WHEN 2 THEN 'No' 
            ELSE 'Unknown' 
        END AS complementary,
        status
    FROM ca_customer 
    WHERE status NOT IN (2)"; // Exclude 2 pending

$params = [];

// Filter by customer type if specific type is selected
if (in_array($type, ['prime', 'premium', 'premium_plus'])) {
    $sql .= " AND customer_type = :type";
    $params[':type'] = $type;
}

// Filter by month and year if provided
if (!empty($month) && !empty($year)) {
    $sql .= " AND MONTH(added_on) = :month AND YEAR(added_on) = :year";
    $params[':month'] = $month;
    $params[':year'] = $year;
}

// Execute the query
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Set headers for CSV download
header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=\"{$type}_customers_{$month}_{$year}.csv\"");

// Open output stream
$output = fopen("php://output", "w");

// CSV column headers
fputcsv($output, ['Registered Date', 'Name', 'Amount', 'Membership', 'Complementary', 'Status']);

// Output each row
foreach ($rows as $row) {
    fputcsv($output, [
        $row['created_date'] ?? '',
        trim(($row['firstname'] ?? '') . ' ' . ($row['lastname'] ?? '')),
        (float)($row['amount'] ?? 0),
        $row['membership'] ?? '',
        $row['complementary'] ?? '',
        $row['status'] == 1 ? 'Registered' : ($row['status'] == 0 ? 'Deleted' : ($row['status'] == 3 ? 'Unregistered(Inactive)' : 'Unknown'))
    ]);
}

// Close the stream
fclose($output);
exit;
