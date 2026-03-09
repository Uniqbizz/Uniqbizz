<?php
require '../../connect.php';
require '../../dashboard_user_details.php';
header('Content-Type: application/json');

try {
    $ta_list = [];
    $sql0 = '';
    $params = ['userId' => $userId];


    //data load from models file
    include '../../models/orders/all_channels.php';
    
    $ta_ids = array_column($ta_list, 'ca_travelagency_id');
    $placeholders = [];
    foreach ($ta_ids as $index => $id) {
        $placeholders[] = ":id$index";
    }
    $placeholdersString = implode(',', $placeholders);

    $selected_date = isset($_GET['selected_date']) ? $_GET['selected_date'] : null;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 4;

    $sql = "SELECT 
                b.id, 
                b.order_id, 
                b.package_id, 
                DATE_FORMAT(b.date, '%Y-%m-%d') AS date, 
                b.customer_id, 
                b.name, 
                b.status, 
                b.ta_id,
                p.name AS package_name, 
                c.profile_pic AS customer_profile_pic,
                (SELECT image FROM package_pictures WHERE package_id = b.package_id LIMIT 1) AS package_image,
                p.tour_days,
                b.confirm_status
            FROM bookings b
            LEFT JOIN package p ON b.package_id = p.id
            LEFT JOIN ca_customer c ON b.customer_id = c.ca_customer_id";

    $conditions = [];
    $binds = [];

    if ($selected_date) {
        $conditions[] = "DATE(b.date) = :selected_date";
        $binds[':selected_date'] = $selected_date;
    }

    if ($userType === '10') {
        $conditions[] = "b.customer_id = :userId";
        $binds[':userId'] = $userId;
    } elseif (!empty($ta_ids)) {
        // Restrict bookings to customers of the TAs only
        $conditions[] = "b.customer_id IN (
            SELECT ca_customer_id FROM ca_customer WHERE ta_reference_no IN ($placeholdersString)
        )";
        foreach ($ta_ids as $index => $id) {
            $binds[":id$index"] = $id;
        }
    } else {
        // No valid TA IDs found for the user
        echo json_encode(["bookings" => []], JSON_PRETTY_PRINT);
        exit;
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $sql .= " ORDER BY b.date DESC LIMIT $limit";

    $stmt = $conn->prepare($sql);
    foreach ($binds as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["bookings" => $bookings ?: []], JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
