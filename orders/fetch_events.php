<?php
require '../connect.php';
header('Content-Type: application/json');

// Handle POST request
$request = json_decode(file_get_contents('php://input'), true);

try {
    // Extract parameters from the request
    $userId = $request['userId'];
    $userType = $request['userType'];
    $selected_date = isset($request['selected_date']) ? $request['selected_date'] : null;

    // Validate required parameters
    if (!$userId || !$userType) {
        echo json_encode(["error" => "userId and userType are required parameters"]);
        exit;
    }

    $ta_list = [];
    $sql0 = '';
    $params = ['userId' => $userId];

    switch ($userType) {
        case '24': // BCM
            $sql0 = "
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                INNER JOIN business_mentor bm ON bm.business_mentor_id = co.reference_no AND bm.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                WHERE ca.status = 1 AND bcm.employee_id = :userId

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN business_mentor bm ON bm.business_mentor_id = ca.reference_no AND bm.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                WHERE ca.status = 1 AND bcm.employee_id = :userId

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN master_franchisee mf ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                WHERE ca.status = 1 AND bcm.employee_id = :userId

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                INNER JOIN master_franchisee mf ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                WHERE ca.status = 1 AND bcm.employee_id = :userId

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                INNER JOIN sponsor_franchisee sf ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = sf.reference_no AND bdm.status = 1
                INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                WHERE ca.status = 1 AND bcm.employee_id = :userId

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN employees bdm ON bdm.employee_id = ca.reference_no AND bdm.status = 1
                INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                WHERE ca.status = 1 AND bcm.employee_id = :userId
            ";
            break;

        case '25': // BDM
            $sql0 = "
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                INNER JOIN business_mentor bm ON bm.business_mentor_id = co.reference_no AND bm.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = :userId

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN business_mentor bm ON bm.business_mentor_id = ca.reference_no AND bm.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = :userId

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN master_franchisee mf ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = :userId

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                INNER JOIN master_franchisee mf ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = :userId

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                INNER JOIN sponsor_franchisee sf ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = sf.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = :userId

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN employees bdm ON bdm.employee_id = ca.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = :userId
            ";
            break;

        case '31': // RM
            $sql0 = "
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN master_franchisee mf ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = :userId

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                INNER JOIN master_franchisee mf ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = :userId

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                INNER JOIN sponsor_franchisee sf ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = sf.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = :userId

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN employees bdm ON bdm.employee_id = ca.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = :userId
            ";
            break;

        case '26': // BM
            $sql0 = "
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                INNER JOIN business_mentor bm ON co.reference_no = bm.business_mentor_id AND bm.status = 1
                WHERE ca.status = 1 AND bm.business_mentor_id = :userId

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                WHERE ca.status = 1 AND ca.reference_no = :userId
            ";
            break;

        case '28': // MF
            $sql0 = "
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN master_franchisee mf ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
                WHERE ca.status = 1 AND mf.master_franchisee_id = :userId
            ";
            break;

        case '30': // SF
            $sql0 = "
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                INNER JOIN sponsor_franchisee sf ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
                WHERE ca.status = 1 AND sf.sponsor_franchisee_id = :userId
            ";
            break;

        case '29': // F
            $sql0 = "
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                WHERE ca.status = 1 AND f.sub_franchisee_id = :userId
            ";
            break;

        case '16': // TE
            $sql0 = "
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                WHERE ca.status = 1 AND co.corporate_agency_id = :userId
            ";
            break;

        case '11': // TC
            $sql0 = "
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                WHERE ca.status = 1 AND ca_travelagency_id = :userId
            ";
            break;

        case '10': // Customer
            $sql0 = "
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN ca_customer ccu ON ccu.ta_reference_no = ca.ca_travelagency_id AND ccu.status = 1
                WHERE ca.status = 1 AND ccu.ca_customer_id = :userId
            ";
            break;

        default:
            echo json_encode(["error" => "Invalid userType provided"]);
            exit;
    }

    // Get TA IDs for the user
    $ta_ids = [];
    if ($sql0 !== '') {
        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute($params);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);
        $ta_ids = array_column($ta_list, 'ca_travelagency_id');
    }

    // Build the main query for bookings/events
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

    // Apply date filter if provided
    if ($selected_date) {
        $conditions[] = "DATE(b.date) = :selected_date";
        $binds[':selected_date'] = $selected_date;
    }

    // Apply user-specific filters
    if ($userType === '10') {
        // Customer: only their own bookings
        $conditions[] = "b.customer_id = :userId";
        $binds[':userId'] = $userId;
    } elseif (!empty($ta_ids)) {
        // For other user types: restrict to customers of their TAs
        $placeholders = [];
        foreach ($ta_ids as $index => $id) {
            $placeholders[] = ":ta_id_$index";
            $binds[":ta_id_$index"] = $id;
        }
        $placeholdersString = implode(',', $placeholders);
        $conditions[] = "b.customer_id IN (
            SELECT ca_customer_id FROM ca_customer WHERE ta_reference_no IN ($placeholdersString)
        )";
    } else {
        // No valid TA IDs found for the user (except TC who should always have their own)
        if ($userType !== '11') {
            echo json_encode(["events" => [], "message" => "No travel agencies found for this user"]);
            exit;
        }
    }

    // Build WHERE clause if conditions exist
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    // Add ordering by date
    $sql .= " ORDER BY b.date DESC";

    // Execute the main query
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    foreach ($binds as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare response
    $response = [
        "success" => true,
        "events" => $events ?: []
    ];

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "error" => "Database error: " . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => "Error: " . $e->getMessage()
    ]);
}