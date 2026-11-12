<?php

header('Content-Type: application/json');
require '../../../../../connect.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method");
    }

    $requestData = json_decode(file_get_contents("php://input"), true);

    if (!$requestData) {
        throw new Exception("Invalid JSON data");
    }

    if (!isset($requestData['userId']) || empty(trim($requestData['userId']))) {
        throw new Exception("userId is required");
    }

    if (!isset($requestData['year']) || empty(trim($requestData['year']))) {
        throw new Exception("year is required");
    }

    $userId = trim($requestData['userId']);
    $year   = (int)$requestData['year'];

    $sqlRef = $conn->prepare("
        SELECT
            YEAR(created_date) AS year,
            MONTH(created_date) AS month_number,
            MONTHNAME(created_date) AS month_name,
            COALESCE(SUM(referral_amount), 0) AS total_amount
        FROM customer_reference_payout
        WHERE customer_id = :user_id
        AND referral_level = 'Level1'
        AND YEAR(created_date) = :year
        GROUP BY
            YEAR(created_date),
            MONTH(created_date),
            MONTHNAME(created_date)
        ORDER BY
            MONTH(created_date) ASC
    ");

    $sqlRef->execute([
        ':user_id' => $userId,
        ':year'    => $year
    ]);

    $refArray = $sqlRef->fetchAll(PDO::FETCH_ASSOC);

    // Jan-Dec initialized to 0
    $monthlyData = array_fill(0, 12, 0);

    // Fill actual values
    foreach ($refArray as $row) {
        $monthIndex = (int)$row['month_number'] - 1;
        $monthlyData[$monthIndex] = (float)$row['total_amount'];
    }

    echo json_encode([
        "status" => true,
        "data"   => $monthlyData
    ]);

    } catch (Exception $e) {

    echo json_encode([
        "status"  => false,
        "message" => $e->getMessage()
    ]);

}