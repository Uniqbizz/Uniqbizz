<?php
// api/get_top_referrals.php

// Set headers for JSON response
header('Content-Type: application/json');

// Database configuration
require '../../../connect.php';

// Only allow POST method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed. Use POST method.'
    ]);
    exit;
}

// Get parameters from POST request
$input = json_decode(file_get_contents('php://input'), true);

// If no JSON input, check form-data
if (empty($input)) {
    $input = $_POST;
}

$userType = $input['userType'] ?? null;
$userId = $input['userId'] ?? null;

// Validate required parameters
if (!$userType || !$userId) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters: userType and userId are required'
    ]);
    exit;
}

try {
    // Initialize response array
    $response = [
        'success' => true,
        'data' => [],
        'total' => 0
    ];

    // Set table configurations based on user type
    if ($userType == '3') { // business_consultant
        $tableName1 = 'corporate_agency';
        $tableId1 = 'corporate_agency_id';
        $tableNameDesignation = 'Corporate Agency';
        $tableName2 = 'ca_travelagency';
        $tableId2 = 'ca_travelagency_id';
        $tableColumnName = 'reference_no';
        $tableColumnName2 = 'reference_no';
    }
    // corporate_agency
    elseif ($userType == '16') {
        $tableName1 = 'ca_travelagency';
        $tableId1 = 'ca_travelagency_id';
        $tableNameDesignation = 'Travel Agency';
        $tableName2 = 'ca_customer';
        $tableId2 = 'ca_customer_id';
        $tableColumnName = 'reference_no';
        $tableColumnName2 = 'ta_reference_no';
    }
    // travel_agent
    elseif ($userType == '11') {
        $tableName1 = 'ca_customer';
        $tableId1 = 'ca_customer_id';
        $tableNameDesignation = 'Customer';
        $tableName2 = 'ca_customer';
        $tableId2 = 'ca_customer_id';
        $tableColumnName = 'ta_reference_no';
        $tableColumnName2 = 'reference_no';
    }
    // customer
    elseif ($userType == '10') {
        $tableName1 = 'ca_customer';
        $tableId1 = 'ca_customer_id';
        $tableNameDesignation = 'Customer';
        $tableName2 = 'ca_customer';
        $tableId2 = 'ca_customer_id';
        $tableColumnName = 'reference_no';
        $tableColumnName2 = 'reference_no';
    }
    // channel_business_director
    elseif ($userType == '18') {
        $tableName1 = 'business_consultant';
        $tableId1 = 'business_consultant_id';
        $tableNameDesignation = 'Business Consultant';
        $tableName2 = 'corporate_agency';
        $tableId2 = 'corporate_agency_id';
        $tableColumnName = 'reference_no';
        $tableColumnName2 = 'reference_no';
    }
    // CA Franchisee
    elseif ($userType == '19') {
        $tableName1 = 'business_operation_executive';
        $tableId1 = 'business_operation_executive_id';
        $tableNameDesignation = 'Business Operation Executive';
        $tableName2 = 'training_manager';
        $tableId2 = 'training_manager_id';
        $tableColumnName = 'reference_no';
        $tableColumnName2 = 'reference_no';
    }
    // Business Operation Executive
    elseif ($userType == '20') {
        $tableName1 = 'training_manager';
        $tableId1 = 'training_manager_id';
        $tableNameDesignation = 'Training Manager';
        $tableName2 = 'sales_executive';
        $tableId2 = 'sales_executive_id';
        $tableColumnName = 'reference_no';
        $tableColumnName2 = 'reference_no';
    }
    // Training Manager
    elseif ($userType == '21') {
        $tableName1 = 'sales_executive';
        $tableId1 = 'sales_executive_id';
        $tableNameDesignation = 'Sales Executive';
        $tableName2 = 'sales_executive';
        $tableId2 = 'sales_executive_id';
        $tableColumnName = 'reference_no';
        $tableColumnName2 = 'reference_no';
    }
    // Business Channel manager
    elseif ($userType == '24') {
        $tableName1 = 'employees';
        $tableId1 = 'employee_id';
        $tableNameDesignation = 'Business Development Manager';
        $tableName2 = 'business_mentor';
        $tableId2 = 'business_mentor_id';
        $tableColumnName = 'reporting_manager';
        $tableColumnName2 = 'reference_no';
    }
    // Business Development manager
    elseif ($userType == '25') {
        $tableName1 = 'business_mentor';
        $tableId1 = 'business_mentor_id';
        $tableNameDesignation = 'Business Development Manager';
        $tableName2 = 'corporate_agency';
        $tableId2 = 'corporate_agency_id';
        $tableColumnName = 'reference_no';
        $tableColumnName2 = 'reference_no';
        
        $tableName3 = 'ca_travelagency';
        $tableId3 = 'ca_travelagency_id';
        $tableNameDesignation2 = 'Travel Consultant';
        $tableName4 = 'ca_customer';
        $tableId4 = 'ca_customer_id';
        $tableColumnName3 = 'reference_no';
        $tableColumnName4 = 'ta_reference_no';
        
        $tableName5 = 'corporate_agency';
        $tableId5 = 'corporate_agency_id';
        $tableNameDesignation3 = 'Techno Enterprise';
        $tableName6 = 'ca_travelagency';
        $tableId6 = 'ca_travelagency_id';
        $tableColumnName5 = 'reference_no';
        $tableColumnName6 = 'reference_no';
        
        $tableName7 = 'sub_franchisee';
        $tableId7 = 'sub_franchisee_id';
        $tableNameDesignation4 = 'Franchisee';
        $tableName8 = 'ca_travelagency';
        $tableId8 = 'ca_travelagency_id';
        $tableColumnName7 = 'reference_no';
        $tableColumnName8 = 'reference_no';
        
        $tableName9 = 'master_franchisee';
        $tableId9 = 'master_franchisee_id';
        $tableNameDesignation5 = 'Master Franchisee';
        $tableName10 = 'sub_franchisee_id';
        $tableId10 = 'sub_franchisee_id_id';
        $tableColumnName9 = 'reference_no';
        $tableColumnName10 = 'reference_no';
        
        $tableName11 = 'ca_travelagency';
        $tableId11 = 'ca_travelagency_id';
        $tableColumnName11 = 'reference_no';
        
        $tableName12 = 'sponsor_franchisee';
        $tableId12 = 'sponsor_franchisee_id';
        $tableNameDesignation6 = 'Sponsor Franchisee';
        $tableName13 = 'sub_franchisee';
        $tableId13 = 'sub_franchisee_id';
        $tableColumnName12 = 'reference_no';
        $tableColumnName13 = 'reference_no';
    }
    // Business Mentor
    elseif ($userType == '26') {
        $tableName1 = 'corporate_agency';
        $tableId1 = 'corporate_agency_id';
        $tableNameDesignation = 'Techno Enterprise';
        $tableName2 = 'ca_travelagency';
        $tableId2 = 'ca_travelagency_id';
        $tableColumnName = 'reference_no';
        $tableColumnName2 = 'reference_no';
        
        $tableName3 = 'ca_travelagency';
        $tableId3 = 'ca_travelagency_id';
        $tableNameDesignation1 = 'Travel Consultant';
        $tableName4 = 'ca_customer';
        $tableId4 = 'ca_customer_id';
        $tableColumnName1 = 'reference_no';
        $tableColumnName3 = 'ta_reference_no';
    }
    // Master Franchisee
    elseif ($userType == '28') {
        $tableName1 = 'sub_franchisee';
        $tableId1 = 'sub_franchisee_id';
        $tableNameDesignation = 'Franchisee';
        $tableName2 = 'ca_travelagency';
        $tableId2 = 'ca_travelagency_id';
        $tableColumnName = 'reference_no';
        $tableColumnName2 = 'reference_no';
        
        $tableName3 = 'ca_travelagency';
        $tableId3 = 'ca_travelagency_id';
        $tableNameDesignation2 = 'Travel Consultant';
        $tableName4 = 'ca_customer';
        $tableId4 = 'ca_customer_id';
        $tableColumnName3 = 'reference_no';
        $tableColumnName4 = 'ta_reference_no';
    }
    // Franchisee(sub_franchisee)
    elseif ($userType == '29') {
        $tableName1 = 'ca_travelagency';
        $tableId1 = 'ca_travelagency_id';
        $tableNameDesignation = 'Travel Agency';
        $tableName2 = 'ca_customer';
        $tableId2 = 'ca_customer_id';
        $tableColumnName = 'reference_no';
        $tableColumnName2 = 'ta_reference_no';
    }
    // Sponsor Franchisee(sub_franchisee)
    elseif ($userType == '30') {
        $tableName1 = 'sub_franchisee';
        $tableId1 = 'sub_franchisee_id';
        $tableNameDesignation = 'Franchisee';
        $tableName2 = 'ca_travelagency';
        $tableId2 = 'ca_travelagency_id';
        $tableColumnName = 'reference_no';
        $tableColumnName2 = 'reference_no';
    }
    // Relationship Manager
    elseif ($userType == '31') {
        $tableName1 = 'sub_franchisee';
        $tableId1 = 'sub_franchisee_id';
        $tableNameDesignation = 'Franchisee';
        $tableName2 = 'ca_travelagency';
        $tableId2 = 'ca_travelagency_id';
        $tableColumnName1 = 'reference_no';
        $tableColumnName2 = 'reference_no';
        
        $tableName3 = 'master_franchisee';
        $tableId3 = 'master_franchisee_id';
        $tableNameDesignation2 = 'Master Franchisee';
        $tableName4 = 'sub_franchisee';
        $tableId4 = 'sub_franchisee_id';
        $tableColumnName3 = 'reference_no';
        $tableColumnName4 = 'reference_no';
        
        $tableName5 = 'ca_travelagency';
        $tableId5 = 'ca_travelagency_id';
        $tableColumnName5 = 'reference_no';
        
        $tableName6 = 'sponsor_franchisee';
        $tableId6 = 'sponsor_franchisee_id';
        $tableNameDesignation3 = 'Sponsor Franchisee';
        $tableName7 = 'sub_franchisee';
        $tableId7 = 'sub_franchisee_id';
        $tableColumnName6 = 'reference_no';
        $tableColumnName7 = 'reference_no';
    }
    else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid user type'
        ]);
        exit;
    }

    // Fetch referrals based on user type
    if ($userType == '28') {
        // Master Franchisee logic
        $selectSF = $conn->prepare("SELECT COUNT(id) as total FROM sub_franchisee WHERE reference_no=? AND status='1'");
        $selectSF->execute([$userId]);
        $resultSF = $selectSF->fetch(PDO::FETCH_ASSOC);
        $countSF = $resultSF['total'];
        
        $selectTC = $conn->prepare("SELECT COUNT(id) as total FROM ca_travelagency WHERE reference_no=? AND status='1'");
        $selectTC->execute([$userId]);
        $resultTC = $selectTC->fetch(PDO::FETCH_ASSOC);
        $countTC = $resultTC['total'];
        
        if ($countSF > 0 && $countTC > 0) {
            $stmt2 = $conn->prepare("SELECT id,user_id,firstname,lastname,register_date FROM(
                SELECT id,sub_franchisee_id as user_id,firstname,lastname,register_date FROM $tableName1 WHERE reference_no=? AND status='1'
                UNION
                SELECT id,ca_travelagency_id as user_id,firstname,lastname,register_date FROM $tableName3 WHERE reference_no=? AND status='1'
            ) AS combined ORDER BY id DESC limit 5");
            $stmt2->execute([$userId, $userId]);
        } elseif ($countSF > 0) {
            $stmt2 = $conn->prepare("SELECT id,sub_franchisee_id as user_id,firstname,lastname,register_date FROM $tableName1 WHERE reference_no=? AND status='1' ORDER BY id DESC limit 5");
            $stmt2->execute([$userId]);
        } elseif ($countTC > 0) {
            $stmt2 = $conn->prepare("SELECT id,ca_travelagency_id as user_id,firstname,lastname,register_date FROM $tableName3 WHERE reference_no=? AND status='1' ORDER BY id DESC limit 5");
            $stmt2->execute([$userId]);
        } else {
            $stmt2 = null;
        }
    }
    elseif ($userType == '26') {
        // Business Mentor logic
        $selectSF = $conn->prepare("SELECT COUNT(id) as total FROM corporate_agency WHERE reference_no=? AND status='1'");
        $selectSF->execute([$userId]);
        $resultSF = $selectSF->fetch(PDO::FETCH_ASSOC);
        $countSF = $resultSF['total'];
        
        $selectTC = $conn->prepare("SELECT COUNT(id) as total FROM ca_travelagency WHERE reference_no=? AND status='1'");
        $selectTC->execute([$userId]);
        $resultTC = $selectTC->fetch(PDO::FETCH_ASSOC);
        $countTC = $resultTC['total'];
        
        if ($countSF > 0 && $countTC > 0) {
            $stmt2 = $conn->prepare("SELECT id,user_id,firstname,lastname,register_date FROM(
                SELECT id,corporate_agency_id as user_id,firstname,lastname,register_date FROM $tableName1 WHERE reference_no=? AND status='1'
                UNION
                SELECT id,ca_travelagency_id as user_id,firstname,lastname,register_date FROM $tableName3 WHERE reference_no=? AND status='1'
            ) AS combined ORDER BY id DESC limit 5");
            $stmt2->execute([$userId, $userId]);
        } elseif ($countSF > 0) {
            $stmt2 = $conn->prepare("SELECT id,corporate_agency_id as user_id,firstname,lastname,register_date FROM $tableName1 WHERE reference_no=? AND status='1' ORDER BY id DESC limit 5");
            $stmt2->execute([$userId]);
        } elseif ($countTC > 0) {
            $stmt2 = $conn->prepare("SELECT id,ca_travelagency_id as user_id,firstname,lastname,register_date FROM $tableName3 WHERE reference_no=? AND status='1' ORDER BY id DESC limit 5");
            $stmt2->execute([$userId]);
        } else {
            $stmt2 = null;
        }
    }
    elseif ($userType == '25') {
        // Business Development Manager logic
        $sql = "SELECT combined.id,
                    combined.user_id,
                    combined.firstname,
                    combined.lastname,
                    combined.register_date,
                    combined.type
                FROM (
                    -- BM
                    SELECT bm.id,
                        bm.business_mentor_id AS user_id,
                        bm.firstname,
                        bm.lastname,
                        bm.register_date,
                        'BM' AS type
                    FROM business_mentor bm
                    WHERE bm.reference_no = :userId AND bm.status = '1'
                    UNION ALL
                    -- TC
                    SELECT tc.id,
                        tc.ca_travelagency_id AS user_id,
                        tc.firstname,
                        tc.lastname,
                        tc.register_date,
                        'TC' AS type
                    FROM ca_travelagency tc
                    WHERE tc.reference_no = :userId AND tc.status = '1'
                    UNION ALL
                    -- TE
                    SELECT te.id,
                        te.corporate_agency_id AS user_id,
                        te.firstname,
                        te.lastname,
                        te.register_date,
                        'TE' AS type
                    FROM corporate_agency te
                    WHERE te.reference_no = :userId AND te.status = '1'
                    UNION ALL
                    -- F
                    SELECT f.id,
                        f.sub_franchisee_id AS user_id,
                        f.firstname,
                        f.lastname,
                        f.register_date,
                        'F' AS type
                    FROM sub_franchisee f
                    WHERE f.reference_no = :userId AND f.status = '1'
                    UNION ALL
                    -- MF
                    SELECT mf.id,
                        mf.master_franchisee_id AS user_id,
                        mf.firstname,
                        mf.lastname,
                        mf.register_date,
                        'MF' AS type
                    FROM master_franchisee mf
                    WHERE mf.reference_no = :userId AND mf.status = '1'
                    UNION ALL
                    -- SF
                    SELECT sf.id,
                        sf.sponsor_franchisee_id AS user_id,
                        sf.firstname,
                        sf.lastname,
                        sf.register_date,
                        'SF' AS type
                    FROM sponsor_franchisee sf
                    WHERE sf.reference_no = :userId AND sf.status = '1'
                ) AS combined
                ORDER BY combined.id DESC
                LIMIT 5";
        
        $stmt2 = $conn->prepare($sql);
        $stmt2->execute(['userId' => $userId]);
    }
    elseif ($userType == '31') {
        // Relationship Manager logic
        $sql = "SELECT combined.id,
                    combined.user_id,
                    combined.firstname,
                    combined.lastname,
                    combined.register_date,
                    combined.type
                FROM (
                    -- F
                    SELECT f.id,
                        f.sub_franchisee_id AS user_id,
                        f.firstname,
                        f.lastname,
                        f.register_date,
                        'F' AS type
                    FROM sub_franchisee f
                    WHERE f.reference_no = :userId AND f.status = '1'
                    UNION ALL
                    -- MF
                    SELECT mf.id,
                        mf.master_franchisee_id AS user_id,
                        mf.firstname,
                        mf.lastname,
                        mf.register_date,
                        'MF' AS type
                    FROM master_franchisee mf
                    WHERE mf.reference_no = :userId AND mf.status = '1'
                    UNION ALL
                    -- SF
                    SELECT sf.id,
                        sf.sponsor_franchisee_id AS user_id,
                        sf.firstname,
                        sf.lastname,
                        sf.register_date,
                        'SF' AS type
                    FROM sponsor_franchisee sf
                    WHERE sf.reference_no = :userId AND sf.status = '1'
                    UNION ALL
                    -- TC
                    SELECT tc.id,
                        tc.ca_travelagency_id AS user_id,
                        tc.firstname,
                        tc.lastname,
                        tc.register_date,
                        'TC' AS type
                    FROM ca_travelagency tc
                    WHERE tc.reference_no = :userId AND tc.status = '1'
                ) AS combined
                ORDER BY combined.id DESC
                LIMIT 5";
        
        $stmt2 = $conn->prepare($sql);
        $stmt2->execute(['userId' => $userId]);
    }
    else {
        // Other user types
        if ($userType == '24') {
            $name_column = ',name,';
        } else {
            $name_column = ',firstname,lastname,';
        }
        
        if ($userType == '16') {
            $stmt2 = $conn->prepare("SELECT $tableId1 as user_id $name_column register_date,
                CASE WHEN tm.te_id IS NOT NULL THEN 1 ELSE 0 END AS alloted_check
                FROM $tableName1 
                LEFT JOIN tc_mapping tm on tc_id=ca_travelagency_id and te_id = :userId
                WHERE ($tableColumnName = :userId OR tm.te_id = :userId) AND status='1' 
                order by $tableId1 desc limit 5");
        } else {
            $stmt2 = $conn->prepare("SELECT $tableId1 as user_id $name_column register_date FROM $tableName1 WHERE $tableColumnName = :userId AND status='1' order by $tableId1 desc limit 5");
        }
        $stmt2->execute(['userId' => $userId]);
    }

    // If no statement was created, return empty data
    if (!isset($stmt2) || !$stmt2) {
        echo json_encode($response);
        exit;
    }

    $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    // Process each referral
    foreach ($referrals as $referral) {
        $rd = new DateTime($referral['register_date']);
        $rdate = $rd->format('d-m-Y');
        $id = $referral['user_id'];
        
        if ($userType == '24') {
            $firstName = $referral['name'];
            $lastName = ' ';
        } else {
            $firstName = $referral['firstname'];
            $lastName = $referral['lastname'] ?? '';
            
            if ($userType == '16' && isset($referral['alloted_check']) && $referral['alloted_check'] == 1) {
                $lastName .= ' (Allotted TC)';
            }
        }

        $count = 0;
        $activeCount = 0;
        $inactiveCount = 0;

        // Calculate counts based on user type and referral type
        if ($userType == '28') {
            if (substr($id, 0, 1) == 'F') {
                // Franchisee
                $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1'");
                $stmt4->execute([$id]);
                $count = $stmt4->rowCount();
                
                $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                $stmt4->execute([$id]);
                $activeCount = $stmt4->rowCount();
                
                $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE()))");
                $stmt4->execute([$id]);
                $inactiveCount = $stmt4->rowCount();
            }
            elseif (substr($id, 0, 2) == 'TA') {
                // Travel Agency
                $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName4 = ? AND status='1'");
                $stmt4->execute([$id]);
                $count = $stmt4->rowCount();
                
                $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName4 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                $stmt4->execute([$id]);
                $activeCount = $stmt4->rowCount();
                
                $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName4 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE()))");
                $stmt4->execute([$id]);
                $inactiveCount = $stmt4->rowCount();
            }
        }
        elseif ($userType == '26') {
            if (substr($id, 0, 2) == 'TE' || substr($id, 0, 2) == 'CA') {
                // Techno Enterprise
                $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1'");
                $stmt4->execute([$id]);
                $count = $stmt4->rowCount();
                
                $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                $stmt4->execute([$id]);
                $activeCount = $stmt4->rowCount();
                
                $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE()))");
                $stmt4->execute([$id]);
                $inactiveCount = $stmt4->rowCount();
            }
            elseif (substr($id, 0, 2) == 'TA') {
                // Travel Agency
                $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName3 = ? AND status='1'");
                $stmt4->execute([$id]);
                $count = $stmt4->rowCount();
                
                $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName3 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                $stmt4->execute([$id]);
                $activeCount = $stmt4->rowCount();
                
                $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName3 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE()))");
                $stmt4->execute([$id]);
                $inactiveCount = $stmt4->rowCount();
            }
        }
        // Add similar logic for other user types (25, 31) as needed
        else {
            // Default logic for other user types
            $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1'");
            $stmt4->execute([$id]);
            $count = $stmt4->rowCount();
            
            $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
            $stmt4->execute([$id]);
            $activeCount = $stmt4->rowCount();
            
            $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE()))");
            $stmt4->execute([$id]);
            $inactiveCount = $stmt4->rowCount();
        }

        // Add referral data to response
        $response['data'][] = [
            'id' => $id,
            'name' => trim($firstName . ' ' . $lastName),
            'registerDate' => $rdate,
            'totalReferrals' => $count,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
        ];
        
        $response['total']++;
    }

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>