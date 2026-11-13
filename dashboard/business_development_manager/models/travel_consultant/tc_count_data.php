
<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    // ==========================================
    // 1. USER VALIDATION
    // ==========================================

    if (empty($userId)) {
        throw new Exception('User ID not found.');
    }

    $params = [
        ':user_id_1' => $userId,
        ':user_id_2' => $userId,
        ':user_id_3' => $userId,
        ':user_id_4' => $userId,
        ':user_id_5' => $userId,
        ':user_id_6' => $userId
    ];

    // ==========================================
    // 2. FETCH ALL REFERRAL-CHAIN RECORDS
    // ==========================================

    $sql = "

        SELECT

            COUNT(
                CASE
                    WHEN combined.status IN (0, 2, 4) THEN 1
                END
            ) AS pending_count,

            COUNT(
                CASE
                    WHEN combined.status IN (1, 3) THEN 1
                END
            ) AS registered_count,

            COUNT(*) AS total_count

        FROM (

            /* ==================================
               1. DIRECT CORPORATE AGENCY
            ================================== */

            SELECT
                ta.id,
                ta.status

            FROM ca_travelagency ta

            INNER JOIN corporate_agency ca
                ON ta.reference_no = ca.corporate_agency_id

            WHERE ca.reference_no = :user_id_1
            AND ta.status IN (0, 1, 2, 3, 4)
            AND ca.status IN (1, 3)


            UNION ALL


            /* ==================================
               2. BUSINESS MENTOR -> CORPORATE AGENCY
            ================================== */

            SELECT
                ta.id,
                ta.status

            FROM ca_travelagency ta

            INNER JOIN corporate_agency ca
                ON ta.reference_no = ca.corporate_agency_id

            INNER JOIN business_mentor bm
                ON ca.reference_no = bm.business_mentor_id

            WHERE bm.reference_no = :user_id_2
            AND ta.status IN (0, 1, 2, 3, 4)
            AND ca.status IN (1, 3)
            AND bm.status IN (1, 3)


            UNION ALL


            /* ==================================
               3. DIRECT SUB-FRANCHISEE
            ================================== */

            SELECT
                ta.id,
                ta.status

            FROM ca_travelagency ta

            INNER JOIN sub_franchisee ca
                ON ta.reference_no = ca.sub_franchisee_id

            WHERE ca.reference_no = :user_id_3
            AND ta.status IN (0, 1, 2, 3, 4)
            AND ca.status IN (1, 3)


            UNION ALL


            /* ==================================
               4. BUSINESS MENTOR -> SUB-FRANCHISEE
            ================================== */

            SELECT
                ta.id,
                ta.status

            FROM ca_travelagency ta

            INNER JOIN sub_franchisee ca
                ON ta.reference_no = ca.sub_franchisee_id

            INNER JOIN business_mentor bm
                ON ca.reference_no = bm.business_mentor_id

            WHERE bm.reference_no = :user_id_4
            AND ta.status IN (0, 1, 2, 3, 4)
            AND ca.status IN (1, 3)
            AND bm.status IN (1, 3)


            UNION ALL


            /* ==================================
               5. DIRECT INSTITUTION
            ================================== */

            SELECT
                ta.id,
                ta.status

            FROM institution_branch_manager ta

            INNER JOIN institution ca
                ON ta.reference_no = ca.institution_id

            WHERE ca.reference_no = :user_id_5
            AND ta.status IN (0, 1, 2, 3, 4)
            AND ca.status IN (1, 3)


            UNION ALL


            /* ==================================
               6. BUSINESS MENTOR -> INSTITUTION
            ================================== */

            SELECT
                ta.id,
                ta.status

            FROM institution_branch_manager ta

            INNER JOIN institution ca
                ON ta.reference_no = ca.institution_id

            INNER JOIN business_mentor bm
                ON ca.reference_no = bm.business_mentor_id

            WHERE bm.reference_no = :user_id_6
            AND ta.status IN (0, 1, 2, 3, 4)
            AND ca.status IN (1, 3)
            AND bm.status IN (1, 3)

        ) AS combined

    ";

    // ==========================================
    // 3. EXECUTE QUERY
    // ==========================================

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // ==========================================
    // 4. JSON RESPONSE
    // ==========================================

    echo json_encode([
        'status' => true,
        'message' => 'Data fetched successfully',
        'data' => [
            'pending_count' => (int) ($data['pending_count'] ?? 0),
            'registered_count' => (int) ($data['registered_count'] ?? 0),
            'total_count' => (int) ($data['total_count'] ?? 0)
        ]
    ]);

} catch (PDOException $e) {

    error_log('Travel Agency Count API PDO Error: ' . $e->getMessage());

    echo json_encode([
        'status' => false,
        'message' => 'Database error occurred.',
        'data' => []
    ]);

} catch (Exception $e) {

    error_log('Travel Agency Count API Error: ' . $e->getMessage());

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage(),
        'data' => []
    ]);
}

exit;

?>