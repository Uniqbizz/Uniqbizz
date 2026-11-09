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

            COALESCE(SUM(CASE WHEN sf.status = 2 THEN 1 ELSE 0 END), 0) AS pending_count,

            COALESCE(SUM(CASE WHEN sf.status = 1 THEN 1 ELSE 0 END), 0) AS active_count,

            COALESCE(SUM(CASE WHEN sf.status = 3 THEN 1 ELSE 0 END), 0) AS deactivated_count

        FROM sub_franchisee sf

        WHERE sf.reference_no = :user_id
    ";

    $countParams = [
        ':user_id' => $userId
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
