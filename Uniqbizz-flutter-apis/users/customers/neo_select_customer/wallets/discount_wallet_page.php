<?php

header('Content-Type: application/json');
require '../../../../../connect.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method");
    }

    $requestData = json_decode(file_get_contents("php://input"), true);

    $userId = $requestData['userId'] ?? '';

    if (empty($userId)) {
        throw new Exception("userId is required");
    }

    $sqlDiscountWallet = $conn->prepare("

        SELECT *

        FROM customer_discount_wallet_utilization

        WHERE customer_id = :user_id

        ORDER BY created_date DESC

    ");

    $sqlDiscountWallet->execute([
        ':user_id' => $userId
    ]);

    $rows = $sqlDiscountWallet->fetchAll(PDO::FETCH_ASSOC);

    $responseData = [];

    foreach ($rows as $row) {

        /*
        TYPE
        */
        $type = !empty($row['used_amount'])
            ? 'used'
            : 'earned';

        /*
        AMOUNT
        */
        $amount = !empty($row['used_amount'])
            ? $row['used_amount']
            : $row['earned_amount'];

        
        /*
        STATUS
        */
        $status = !empty($row['used_amount'])
            ? 'used'
            : 'credited';
            
        /*
        DESCRIPTION
        */
        $description = !empty($row['used_amount'])
            ? 'Discount Used'
            : 'Discount Earned';

        /*
        MESSAGE
        */
        $message = !empty($row['used_on'])
            ? $row['used_on']
            : $row['earned_on'];

        $responseData[] = [

            'id' => $row['id'],

            'type' => $type,

            'status' => $status,

            'description' => $description,

            'message' => $message,

            'amount' => number_format(
                (float)$amount,
                2
            ),

            'balance' => number_format(
                (float)$row['balance'],
                2
            ),

            'transaction_id' =>
                $row['transaction_id'] ?? '-',

            'created_date' =>
                $row['created_date'],

            'created_date_text' =>
                !empty($row['created_date'])
                ? date(
                    'd M Y h:i A',
                    strtotime($row['created_date'])
                )
                : '-'
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => $responseData
    ]);

} catch (Exception $e) {

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

}
?>