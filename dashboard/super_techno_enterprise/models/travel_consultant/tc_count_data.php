<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {


    $params = [
        ':user_id' => $userId
    ];

    $sql = "
        SELECT

            COUNT(
                CASE
                    WHEN ta.status IN (0, 2, 4) THEN 1
                END
            ) AS pending_count,

            COUNT(
                CASE
                    WHEN ta.status IN (1, 3) THEN 1
                END
            ) AS registered_count,

            COUNT(*) AS total_count

        FROM ca_travelagency ta

        INNER JOIN corporate_agency ca
            ON ta.reference_no = ca.corporate_agency_id

        WHERE ca.reference_no = :user_id
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'status'  => true,
        'message' => 'Data fetched successfully',
        'data'    => [
            'pending_count'    => (int) ($data['pending_count'] ?? 0),
            'registered_count' => (int) ($data['registered_count'] ?? 0),
            'total_count'      => (int) ($data['total_count'] ?? 0)
        ]
    ]);

} catch (Exception $e) {

    error_log('Travel Agency Count API Error: ' . $e->getMessage());

    echo json_encode([
        'status'  => false,
        'message' => 'Something went wrong while fetching data.',
        'data'    => []
    ]);
}

exit;

?>