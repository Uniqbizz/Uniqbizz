<?php

require '../../../../connect.php';

header('Content-Type: application/json');

// ==========================================
// 1. REQUEST METHOD VALIDATION
// ==========================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);

    echo json_encode([
        'status' => false,
        'message' => 'Invalid request method.',
        'counts' => [
            'total' => 0,
            'pending' => 0,
            'active' => 0,
            'deactivated' => 0
        ]
    ]);

    exit;
}

try {

    // ==========================================
    // 2. READ JSON INPUT
    // ==========================================

    $postData = json_decode(file_get_contents('php://input'), true);

    if (!is_array($postData)) {

        echo json_encode([
            'status' => false,
            'message' => 'Invalid JSON data.',
            'counts' => [
                'total' => 0,
                'pending' => 0,
                'active' => 0,
                'deactivated' => 0
            ]
        ]);

        exit;
    }

    // ==========================================
    // 3. VALIDATE USER ID
    // ==========================================

    $userId = trim($postData['userId'] ?? '');

    if ($userId === '') {

        echo json_encode([
            'status' => false,
            'message' => 'User ID is required.',
            'counts' => [
                'total' => 0,
                'pending' => 0,
                'active' => 0,
                'deactivated' => 0
            ]
        ]);

        exit;
    }

    // ==========================================
    // 4. FETCH ALL STATUS COUNTS
    // ==========================================

    $countSql = "
        SELECT
            COUNT(*) AS total_count,

            COALESCE(
                SUM(
                    CASE
                        WHEN ca.status IN (2, 4) THEN 1
                        ELSE 0
                    END
                ), 0
            ) AS pending_count,

            COALESCE(
                SUM(
                    CASE
                        WHEN ca.status = 1 THEN 1
                        ELSE 0
                    END
                ), 0
            ) AS active_count,

            COALESCE(
                SUM(
                    CASE
                        WHEN ca.status = 3 THEN 1
                        ELSE 0
                    END
                ), 0
            ) AS deactivated_count

        FROM corporate_agency ca

        WHERE ca.reference_no = :user_id
    ";

    $countStmt = $conn->prepare($countSql);

    $countStmt->execute([
        ':user_id' => $userId
    ]);

    $counts = $countStmt->fetch(PDO::FETCH_ASSOC);

    // ==========================================
    // 5. JSON RESPONSE
    // ==========================================

    echo json_encode([
        'status' => true,
        'message' => 'Data fetched successfully',

        'counts' => [
            'total' => (int) $counts['total_count'],
            'pending' => (int) $counts['pending_count'],
            'active' => (int) $counts['active_count'],
            'deactivated' => (int) $counts['deactivated_count']
        ]
    ]);

    exit;

} catch (PDOException $e) {

    error_log('Corporate Agency Count API Database Error: ' . $e->getMessage());

    http_response_code(500);

    echo json_encode([
        'status' => false,
        'message' => 'Database error occurred.',
        'counts' => [
            'total' => 0,
            'pending' => 0,
            'active' => 0,
            'deactivated' => 0
        ]
    ]);

    exit;

} catch (Exception $e) {

    error_log('Corporate Agency Count API Error: ' . $e->getMessage());

    http_response_code(500);

    echo json_encode([
        'status' => false,
        'message' => 'Something went wrong.',
        'counts' => [
            'total' => 0,
            'pending' => 0,
            'active' => 0,
            'deactivated' => 0
        ]
    ]);

    exit;
}

?>