<?php

require '../../../../../connect.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "status" => false,
        "message" => "Invalid request method.",
        "data" => []
    ]);
    exit;
}

try {

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!$data) {
        throw new Exception("Invalid JSON data.");
    }

    if (!isset($data['userId']) || empty(trim($data['userId']))) {
        throw new Exception("User ID is required.");
    }

    $userId = trim($data['userId']);

    /*
    |--------------------------------------------------------------------------
    | Limit
    |--------------------------------------------------------------------------
    */

    $limit = 5;

    /*
    |--------------------------------------------------------------------------
    | Today's Date
    |--------------------------------------------------------------------------
    */

    $today = date('Y-m-d');

    /*
    |--------------------------------------------------------------------------
    | Upcoming Trips
    |--------------------------------------------------------------------------
    */

    $sql = "
        SELECT
            b.id,
            b.order_id,
            b.package_id,
            b.date,
            b.confirm_status,
            b.status,
            p.name AS package_name,
            p.tour_days,

            (
                SELECT image
                FROM package_pictures
                WHERE package_id = b.package_id
                LIMIT 1
            ) AS package_image,

            CASE
                WHEN o.pay_type = 1 THEN
                    o.status = 1

                WHEN o.pay_type = 2 THEN
                    CASE
                        WHEN o.part_pay_1_status = 1
                         AND o.part_pay_2_status = 2
                         AND o.status = 2
                        THEN 1
                        ELSE 0
                    END

                WHEN o.pay_type = 3 THEN
                    CASE
                        WHEN o.part_pay_1_status = 1
                         AND o.part_pay_2_status = 1
                         AND o.part_pay_3_status = 1
                         AND o.status = 1
                        THEN 1
                        ELSE 0
                    END

                ELSE 0
            END AS payment_completed

        FROM bookings b

        LEFT JOIN package p
            ON p.id = b.package_id

        LEFT JOIN booking_direct_bill o
            ON o.bookings_id = b.id

        WHERE
            b.customer_id = :userId
            AND DATE(b.date) >= :today

        ORDER BY b.date ASC

        LIMIT :limit
    ";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':userId', $userId);
    $stmt->bindValue(':today', $today);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

    $stmt->execute();

    $upcomingTrips = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Format Upcoming Trips
    |--------------------------------------------------------------------------
    */

    $formattedTrips = [];

    foreach ($upcomingTrips as $trip) {

        $startDateObj = new DateTime($trip['date']);

        $endDateObj = clone $startDateObj;

        $days = (int)$trip['tour_days'];
        $nights = max($days - 1, 0);

        $endDateObj->modify('+' . ($days - 1) . ' days');

        /*
        |----------------------------------------------------------------------
        | Dates
        |----------------------------------------------------------------------
        */

        $startDate = $startDateObj->format('Y-m-d');
        $endDate = $endDateObj->format('Y-m-d');

        $displayStartDate = $startDateObj->format('d M Y');
        $displayEndDate = $endDateObj->format('d M Y');

        /*
        |----------------------------------------------------------------------
        | Trip Status
        |----------------------------------------------------------------------
        */

        if ($trip['status'] == 2) {

            $tripStatus = "Cancelled";

        } elseif ($trip['status'] == 3) {

            $tripStatus = "Refunded";

        } elseif ($trip['confirm_status'] == 0) {

            $tripStatus = "Pending";

        } elseif ($today < $startDate) {

            $tripStatus = "Confirmed";

        } elseif ($today >= $startDate && $today <= $endDate) {

            $tripStatus = "Traveling";

        } else {

            $tripStatus = "Completed";
        }

        /*
        |----------------------------------------------------------------------
        | Badge Class
        |----------------------------------------------------------------------
        */

        switch ($tripStatus) {

            case "Confirmed":
                $badgeClass = "confirmBtn";
                break;

            case "Traveling":
                $badgeClass = "confirmBtn travelingBtn";
                break;

            case "Pending":
                $badgeClass = "confirmBtn pendingBtn";
                break;

            case "Completed":
                $badgeClass = "confirmBtn completedBtn";
                break;

            case "Cancelled":
                $badgeClass = "confirmBtn cancelledBtn";
                break;

            case "Refunded":
                $badgeClass = "confirmBtn refundedBtn";
                break;

            default:
                $badgeClass = "confirmBtn upcomingBtn";
        }

        /*
        |----------------------------------------------------------------------
        | Final Response Data
        |----------------------------------------------------------------------
        */

        $formattedTrips[] = [
            "id" => $trip['id'],
            "order_id" => $trip['order_id'],
            "package_id" => $trip['package_id'],
            "package_name" => $trip['package_name'],
            "package_image" => $trip['package_image'] ?: "",

            "start_date" => $startDate,
            "end_date" => $endDate,

            "display_start_date" => $displayStartDate,
            "display_end_date" => $displayEndDate,

            "tour_days" => $days,
            "nights" => $nights,

            "confirm_status" => $trip['confirm_status'],
            "status" => $trip['status'],

            "trip_status" => $tripStatus,
            "badge_class" => $badgeClass,

            "payment_completed" => $trip['payment_completed']
        ];
    }

    echo json_encode([
        "status" => true,
        "message" => "Upcoming trips fetched successfully.",
        "data" => $formattedTrips
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);
}

exit;