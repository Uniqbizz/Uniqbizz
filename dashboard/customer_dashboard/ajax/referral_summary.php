<?php
    include_once(__DIR__ . '/../../dashboard_user_details.php');
    $sqlRef = $conn->prepare("
                SELECT 
                    YEAR(created_date) AS year,
                    MONTH(created_date) AS month_number,
                    MONTHNAME(created_date) AS month_name,
                    COALESCE(SUM(referral_amount), 0) AS total_amount

                FROM customer_reference_payout

                WHERE customer_id = :user_id

                GROUP BY 
                    YEAR(created_date),
                    MONTH(created_date),
                    MONTHNAME(created_date)

                ORDER BY 
                    YEAR(created_date) ASC,
                    MONTH(created_date) ASC
            ");
    $sqlRef->execute([
        ":user_id" =>$userId
    ]);
    //get data
    $refArray = $sqlRef->fetch(PDO::FETCH_ASSOC);
    // return json
    header('Content-Type: application/json');

    echo json_encode([
        "status" => true,
        "data" => $refArray
    ]);
?>