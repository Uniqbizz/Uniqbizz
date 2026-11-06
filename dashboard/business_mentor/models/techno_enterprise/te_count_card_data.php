
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

            -- Corporate Agency
            SELECT ca.status
            FROM corporate_agency ca

            WHERE ca.reference_no = :ca_user_id
            AND ca.status IN (1, 2, 3)

            UNION ALL

            -- Sub Franchisee
            SELECT sf.status
            FROM sub_franchisee sf

            WHERE sf.reference_no = :sf_user_id
            AND sf.status IN (1, 2, 3)


        ) AS combined_records
    ";

    $countParams = [
        ':ca_user_id' => $userId,
        ':sf_user_id' => $userId
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
