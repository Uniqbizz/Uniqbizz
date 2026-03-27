<?php
require '../connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => false, 'message' => 'Method not allowed']);
    exit;
}

$request = json_decode(file_get_contents('php://input'), true);

if (!is_array($request)) {
    echo json_encode([
        'status' => false,
        'message' => 'Invalid JSON body'
    ]);
    exit;
}

try {
    $userId   = $request['userId'] ?? null;
    $userType = $request['userType'] ?? null;

    if (!$userId || !$userType) {
        echo json_encode([
            "success" => false,
            "error"   => "userId and userType are required"
        ]);
        exit;
    }

    $checkStmt = $conn->prepare("
    SELECT 1 
    FROM ca_travelagency 
    WHERE reference_no = :user_ref 
    LIMIT 1
    ");
    $checkStmt->bindValue(':user_ref', $userId, PDO::PARAM_STR);
    $checkStmt->execute();

    if (!$checkStmt->fetchColumn()) {
        echo json_encode([
            "status" => false,
            "message" => "franchisee id invalid"
        ]);
        exit;
    }

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

    $ta_ids = [];

    if ($userType !== '10' && $sql0 !== '') {
        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute($params);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);
        $ta_ids = array_column($ta_list, 'ca_travelagency_id');
    }

    // MAIN QUERY (DATES + STATUS ONLY)
    $sql = "
        SELECT 
            DATE_FORMAT(b.date, '%Y-%m-%d') AS booking_date,
            b.status
        FROM bookings b
    ";

    $conditions = [];
    $binds = [];

    if ($userType === '10') {
        $conditions[] = "b.customer_id = :userId";
        $binds[':userId'] = $userId;

    } elseif (!empty($ta_ids)) {

        $placeholders = [];

        foreach ($ta_ids as $index => $id) {
            $key = ":ta_id_$index";
            $placeholders[] = $key;
            $binds[$key] = $id;
        }

        $conditions[] = "b.customer_id IN (
            SELECT ca_customer_id 
            FROM ca_customer 
            WHERE ta_reference_no IN (" . implode(',', $placeholders) . ")
        )";

    } else {
        if ($userType !== '11') {
            echo json_encode([
                "success" => true,
                "dates" => [],
                "status" => []
            ]);
            exit;
        }
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $sql .= " ORDER BY b.date ASC";

    $stmt = $conn->prepare($sql);

    foreach ($binds as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ✅ EMPTY CHECK
    if (empty($results)) {
        echo json_encode([
            "status"  => false,
            "message" => "No bookings found",
            "dates"   => []
        ], JSON_PRETTY_PRINT);
        exit;
    }

    $dates = [];

    foreach ($results as $row) {
        $dates[] = $row['booking_date'];
    }

    // Remove duplicate dates
    $dates = array_values(array_unique($dates));

    echo json_encode([
        "status"  => true,
        "message" => "Bookings fetched successfully",
        "dates"   => $dates
    ], JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "error" => "Database error: " . $e->getMessage()
    ]);
}
?>