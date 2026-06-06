<?php
require '../../connect.php';
require '../dashboard_user_details.php';
header('Content-Type: application/json');

try {
    $ta_list = [];
    $sql0 = '';
    $params = ['userId' => $userId];

    switch ($userType) {

        case '24': // BCM
            $sql0 = "
                -- BCM: all TA under BDM -> BM / MF / SF -> F / TE -> TC
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
                -- BDM: all TA under BM / MF / SF -> F / TE -> TC
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
                -- BDM: all TA under BM / MF / SF -> F / TE -> TC
                
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
                -- BM: TE -> TC AND TC directly
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
                -- MF: TC directly under MF
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN master_franchisee mf ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
                WHERE ca.status = 1 AND mf.master_franchisee_id = :userId
            ";
            break;

        case '30': // SF
            $sql0 = "
                -- SF: F -> TC under SF
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                INNER JOIN sponsor_franchisee sf ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
                WHERE ca.status = 1 AND sf.sponsor_franchisee_id = :userId
            ";
            break;

        case '29': // F
            $sql0 = "
                -- F: TC under F directly
                SELECT ca_travelagency_id FROM ca_travelagency ca
                WHERE status = 1 AND reference_no = :userId
            ";
            break;

        case '16': // TE
            $sql0 = "
                SELECT ca_travelagency_id FROM ca_travelagency ca
                WHERE status = 1 AND reference_no = :userId
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
