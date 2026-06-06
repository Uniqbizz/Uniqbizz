<?php

    include_once(__DIR__ . '/../../dashboard_user_details.php');

    header('Content-Type: application/json');

    $sqlAllCoupons = $conn->prepare("

        SELECT 
            c.code,
            c.coupon_amt,
            c.usage_status,
            c.created_date,
            c.used_date,
            c.user_id,
            c.earned_on,
            c.expiry_date,
            cu.used_on,
            cu.transaction_id

        FROM loyalty_coupon c

        LEFT JOIN loyalty_coupon_utilization cu 
            ON c.code = cu.coupon_code

        WHERE c.user_id = :user_id

        ORDER BY 
            c.usage_status DESC,
            c.created_date DESC
    ");

    $sqlAllCoupons->execute([
        ":user_id" => $userId
    ]);

    $coupons = $sqlAllCoupons->fetchAll(PDO::FETCH_ASSOC);

    $data = [];

    foreach ($coupons as $row) {

        /*
        CHECK EXPIRED
        */
        $isExpired = false;

        if (
            !empty($row['expiry_date']) &&
            strtotime($row['expiry_date']) < time() &&
            $row['usage_status'] == 0
        ) {

            $isExpired = true;
        }

        /*
        STATUS
        */
        if ($row['usage_status'] == 1) {

            $status = "Used";
        }
        elseif ($isExpired) {

            $status = "Expired";
        }
        else {

            $status = "Available";
        }

        /*
        VALID TILL
        */
        $validTill = !empty($row['expiry_date'])
            ? date('d M Y', strtotime($row['expiry_date']))
            : '-';

        /*
        USED DATE
        */
        $usedDate = !empty($row['used_date'])
            ? date('d M Y h:i A', strtotime($row['used_date']))
            : '-';

        /*
        CREATED DATE
        */
        $createdDate = !empty($row['created_date'])
            ? date('d M Y h:i A', strtotime($row['created_date']))
            : '-';

        $data[] = [

            "code"              => $row['code'],

            "coupon_amt"        => $row['coupon_amt'],

            "usage_status"      => $row['usage_status'],

            "status"            => $status,

            "is_expired"        => $isExpired ? 1 : 0,

            "created_date"      => $row['created_date'],

            "created_date_text" => $createdDate,

            "expiry_date"       => $row['expiry_date'],

            "expiry_date_text"  => $validTill,

            "used_date"         => $row['used_date'],

            "used_date_text"    => $usedDate,

            "used_on"           => $row['used_on'] ?? '-',

            "transaction_id"    => $row['transaction_id'] ?? '-',

            "earned_for"        => $row['earned_on']
        ];
    }

    echo json_encode([

        "status" => true,

        "data" => $data
    ]);
?>