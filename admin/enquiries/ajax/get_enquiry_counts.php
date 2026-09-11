<?php

include(__DIR__ . '/../../connect.php');

header('Content-Type: application/json');

try {

    // ============================================================
    // STATUS MAPPING
    // ============================================================

    $statusMap = [
        'new_enquiries'      => 1,
        'in_progress'        => 2,
        'quotation_sent'     => 3,
        'awaiting_response'  => 4,
        'closed'             => 5
    ];


    // ============================================================
    // GET COUNTS
    // ============================================================

    $query = "
        SELECT
            SUM(CASE WHEN status = :new_enquiry THEN 1 ELSE 0 END) AS new_enquiries,
            SUM(CASE WHEN status = :in_progress THEN 1 ELSE 0 END) AS in_progress,
            SUM(CASE WHEN status = :quotation_sent THEN 1 ELSE 0 END) AS quotation_sent,
            SUM(CASE WHEN status = :awaiting_response THEN 1 ELSE 0 END) AS awaiting_response,
            SUM(CASE WHEN status = :closed THEN 1 ELSE 0 END) AS closed
        FROM request_details
    ";

    $stmt = $conn->prepare($query);

    $stmt->bindValue(
        ':new_enquiry',
        $statusMap['new_enquiries'],
        PDO::PARAM_INT
    );

    $stmt->bindValue(
        ':in_progress',
        $statusMap['in_progress'],
        PDO::PARAM_INT
    );

    $stmt->bindValue(
        ':quotation_sent',
        $statusMap['quotation_sent'],
        PDO::PARAM_INT
    );

    $stmt->bindValue(
        ':awaiting_response',
        $statusMap['awaiting_response'],
        PDO::PARAM_INT
    );

    $stmt->bindValue(
        ':closed',
        $statusMap['closed'],
        PDO::PARAM_INT
    );

    $stmt->execute();

    $counts = $stmt->fetch(PDO::FETCH_ASSOC);


    // ============================================================
    // RESPONSE
    // ============================================================

    echo json_encode([
        'status' => true,

        'data' => [
            'new_enquiries' => (int)($counts['new_enquiries'] ?? 0),
            'in_progress' => (int)($counts['in_progress'] ?? 0),
            'quotation_sent' => (int)($counts['quotation_sent'] ?? 0),
            'awaiting_response' => (int)($counts['awaiting_response'] ?? 0),
            'closed' => (int)($counts['closed'] ?? 0)
        ]
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}
?>