
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

            SUM(CASE WHEN ca.status = 2 THEN 1 ELSE 0 END) AS pending_count,

            SUM(CASE WHEN ca.status = 1 THEN 1 ELSE 0 END) AS active_count,

            SUM(CASE WHEN ca.status = 3 THEN 1 ELSE 0 END) AS deactivated_count

        FROM corporate_agency ca

        WHERE ca.reference_no = :user_id
    ";

    $countStmt = $conn->prepare($countSql);
    $countStmt->execute($params);

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
