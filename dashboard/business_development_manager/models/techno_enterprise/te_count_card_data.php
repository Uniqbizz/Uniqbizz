<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    $params = [
        ':user_id' => $userId
    ];

    // ==========================================
    // 1. FETCH ALL STATUS COUNTS
    // ==========================================
    
    
    $countSql = "
        SELECT
            COUNT(*) AS total_count,

            COALESCE(SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END), 0) AS pending_count,

            COALESCE(SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END), 0) AS active_count,

            COALESCE(SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END), 0) AS deactivated_count

        FROM (

            -- Corporate Agency (Direct)
            SELECT ca.status
            FROM corporate_agency ca

            INNER JOIN employees bm
                ON ca.reference_no = bm.employee_id

            WHERE ca.reference_no = :ca_direct
            AND ca.status IN (1, 2, 3)

            UNION ALL

            -- Corporate Agency (Through BM)
            SELECT ca.status
            FROM corporate_agency ca

            INNER JOIN business_mentor bm
                ON ca.reference_no = bm.business_mentor_id

            WHERE bm.reference_no = :ca_bm
            AND ca.status IN (1, 2, 3)
            AND bm.status = 1

            UNION ALL

            -- Sub Franchisee (Direct)
            SELECT sf.status
            FROM sub_franchisee sf

            INNER JOIN employees bm
                ON sf.reference_no = bm.employee_id

            WHERE sf.reference_no = :sf_direct
            AND sf.status IN (1, 2, 3)

            UNION ALL

            -- Sub Franchisee (Through BM)
            SELECT sf.status
            FROM sub_franchisee sf

            INNER JOIN business_mentor bm
                ON sf.reference_no = bm.business_mentor_id

            WHERE bm.reference_no = :sf_bm
            AND sf.status IN (1, 2, 3)
            AND bm.status = 1

        ) AS combined_records
    ";

    $countParams = [
        ':ca_direct' => $userId,
        ':ca_bm'     => $userId,
        ':sf_direct' => $userId,
        ':sf_bm'     => $userId
    ];

    $countStmt = $conn->prepare($countSql);
    $countStmt->execute($countParams);

    $counts = $countStmt->fetch(PDO::FETCH_ASSOC);


    // ==========================================
    // 2. JSON RESPONSE
    // ==========================================

    echo json_encode([
        'status' => true,
        'message' => 'Data fetched successfully',

        'counts' => [
            'total'       => (int) $counts['total_count'],
            'pending'     => (int) $counts['pending_count'],
            'active'      => (int) $counts['active_count'],
            'deactivated' => (int) $counts['deactivated_count']
        ],
    ]);

} catch (Exception $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage(),
        'counts' => [
            'total' => 0,
            'pending' => 0,
            'active' => 0,
            'deactivated' => 0
        ]
    ]);
}
?>
