<?php

    include_once(__DIR__ . '/../../dashboard_user_details.php');

    header('Content-Type: application/json');

    $sqlDiscountWallet = $conn->prepare("

        SELECT *

        FROM customer_discount_wallet_utilization

        WHERE customer_id = :user_id

        ORDER BY created_date DESC
    ");

    $sqlDiscountWallet->execute([
        ":user_id" => $userId
    ]);

    $rows = $sqlDiscountWallet->fetchAll(PDO::FETCH_ASSOC);

    $data = [];

    foreach($rows as $row){

        /*
        TYPE
        */
        $type =
            !empty($row['used_amount'])
            ? "used"
            : "earned";

        /*
        STATUS
        */
        $status =
            !empty($row['used_amount'])
            ? "used"
            : "credited";

        /*
        AMOUNT
        */
        $amount =
            !empty($row['used_amount'])
            ? $row['used_amount']
            : $row['earned_amount'];

        /*
        DESCRIPTION
        */
        $description =
            !empty($row['used_amount'])
            ? "Discount Used"
            : "Discount Earned";

        /*
        MESSAGE
        */
        $message =
            !empty($row['used_on'])
            ? $row['used_on']
            : $row['earned_on'];

        $data[] = [

            "id" => $row['id'],

            "type" => $type,

            "status" => $status,

            "description" => $description,

            "message" => $message,

            "amount" => number_format((float)$amount, 2),

            "balance" => number_format((float)$row['balance'], 2),

            "transaction_id" =>
                $row['transaction_id'] ?? '-',

            "created_date" =>
                $row['created_date'],

            "created_date_text" =>
                date(
                    "d M Y h:i A",
                    strtotime($row['created_date'])
                )
        ];
    }

    echo json_encode([

        "status" => true,

        "data" => $data
    ]);
?>