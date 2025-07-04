<?php
require '../connect.php';
require '../dashboard_user_details.php';
header('Content-Type: application/json');

try {
    $ta_list = [];
    $sql0 = '';
    $params = ['userId' => $userId];

    switch ($userType) {
        case '24': // BCM
            $sql0 = "SELECT ca_travelagency.ca_travelagency_id FROM ca_travelagency
                INNER JOIN corporate_agency ON corporate_agency.corporate_agency_id = ca_travelagency.reference_no AND corporate_agency.status = 1
                INNER JOIN business_mentor ON corporate_agency.reference_no = business_mentor.business_mentor_id AND business_mentor.status = 1
                INNER JOIN employees ON employees.employee_id = business_mentor.reference_no AND employees.status = 1
                INNER JOIN employees AS bcm ON bcm.employee_id = employees.reporting_manager AND bcm.status = 1
                WHERE ca_travelagency.status = 1 AND bcm.employee_id = :userId";
            break;

        case '25': // BDM
            $sql0 = "SELECT ca_travelagency.ca_travelagency_id FROM ca_travelagency
                INNER JOIN corporate_agency ON corporate_agency.corporate_agency_id = ca_travelagency.reference_no AND corporate_agency.status = 1
                INNER JOIN business_mentor ON corporate_agency.reference_no = business_mentor.business_mentor_id AND business_mentor.status = 1
                INNER JOIN employees ON employees.employee_id = business_mentor.reference_no AND employees.status = 1
                WHERE ca_travelagency.status = 1 AND employees.employee_id = :userId";
            break;

        case '26': // BM
            $sql0 = "SELECT ca_travelagency.ca_travelagency_id FROM ca_travelagency
                INNER JOIN corporate_agency ON corporate_agency.corporate_agency_id = ca_travelagency.reference_no AND corporate_agency.status = 1
                INNER JOIN business_mentor ON corporate_agency.reference_no = business_mentor.business_mentor_id AND business_mentor.status = 1
                WHERE ca_travelagency.status = 1 AND business_mentor.business_mentor_id = :userId";
            break;

        case '16': // TE
            $sql0 = "SELECT ca_travelagency.ca_travelagency_id FROM ca_travelagency
                INNER JOIN corporate_agency ON corporate_agency.corporate_agency_id = ca_travelagency.reference_no AND corporate_agency.status = 1
                WHERE ca_travelagency.status = 1 AND corporate_agency.corporate_agency_id = :userId";
            break;

        case '11': // TC
            $sql0 = "SELECT ca_travelagency.ca_travelagency_id FROM ca_travelagency
                WHERE ca_travelagency.status = 1 AND ca_travelagency_id = :userId";
            break;

        case '10': // Customer
            $sql0 = "SELECT ca_travelagency.ca_travelagency_id FROM ca_travelagency
                INNER JOIN ca_customer ON ca_customer.ta_reference_no = ca_travelagency.ca_travelagency_id AND ca_customer.status = 1
                WHERE ca_travelagency.status = 1 AND ca_customer.ca_customer_id = :userId";
            break;
    }

    if ($sql0 !== '') {
        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute($params);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);
        $ta_ids = array_column($ta_list, 'ca_travelagency_id');
        $placeholders = [];
        foreach ($ta_ids as $index => $id) {
            $placeholders[] = ":id$index";
        }
        $placeholdersString = implode(',', $placeholders);
    }

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
                p.tour_days
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
