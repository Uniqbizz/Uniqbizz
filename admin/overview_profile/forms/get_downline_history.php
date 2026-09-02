<?php

header('Content-Type: application/json');

require_once '../../connect.php';

try {

    $institutionId = $_POST['institution_id'] ?? '';

    if (empty($institutionId)) {

        echo json_encode([
            'status' => false,
            'message' => 'Institution ID is required.',
            'data' => []
        ]);

        exit;
    }


    $sql = "
        SELECT
            id,
            institution_id,
            downline_tc,
            downline_ibr,
            payout_holiday_account_tc,
            payout_holiday_account_ibr,
            payout_holiday_booking_tc,
            payout_holiday_booking_ibr,
            DATE(create_date) AS create_date,
            DATE(deleted_date) AS deleted_date,
            status
        FROM institute_downline_details
        WHERE institution_id = :institution_id
        ORDER BY id DESC
    ";


    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':institution_id' => $institutionId
    ]);


    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode([
        'status' => true,
        'data' => $data
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'status' => false,
        'message' => 'Database error occurred.',
        'data' => []
    ]);
}

exit;