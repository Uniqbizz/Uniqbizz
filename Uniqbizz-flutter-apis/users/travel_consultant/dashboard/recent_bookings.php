<?php

require '../../../../connect.php';
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
    | Recent Bookings
    |--------------------------------------------------------------------------
    */

    $sql = $conn->prepare("
        SELECT
            bookings.id,
            bookings.order_id,
            bookings.name,
            bookings.customer_id,
            package.name AS package_name,
            (
                SELECT image
                FROM package_pictures pp
                WHERE pp.package_id = bookings.package_id
                ORDER BY pp.id ASC
                LIMIT 1
            ) AS package_image,
            booking_direct_bill.total_net_payable AS amount,
            bookings.created_date AS booking_date,
            bookings.date AS travel_date,
            DATE_ADD(bookings.date, INTERVAL (package.tour_days - 1) DAY) AS end_date,
            bookings.status,
            bookings.confirm_status
        FROM bookings
        INNER JOIN booking_direct_bill
            ON booking_direct_bill.bookings_id = bookings.id
        INNER JOIN package
            ON package.id = bookings.package_id
        WHERE bookings.ta_id = :userId
        ORDER BY bookings.created_date DESC
        LIMIT 5
    ");

    $sql->execute([
        ':userId' => $userId
    ]);

    $bookings = $sql->fetchAll(PDO::FETCH_ASSOC);

    $today = date('Y-m-d');

    foreach ($bookings as &$booking) {

        $startDate = date('Y-m-d', strtotime($booking['travel_date']));
        $endDate   = date('Y-m-d', strtotime($booking['end_date']));

        if ($booking['status'] == 2) {

            $booking['booking_status'] = 'Canceled';

        } elseif ($booking['status'] == 3) {

            $booking['booking_status'] = 'Refunded';

        } elseif ($booking['confirm_status'] == 0) {

            $booking['booking_status'] = 'Pending';

        } elseif ($booking['confirm_status'] == 1 && $today < $startDate) {

            $booking['booking_status'] = 'Confirmed';

        } elseif ($booking['confirm_status'] == 1 && $today >= $startDate && $today <= $endDate) {

            $booking['booking_status'] = 'Traveling';

        } elseif ($booking['confirm_status'] == 1 && $today > $endDate) {

            $booking['booking_status'] = 'Completed';

        } else {

            $booking['booking_status'] = 'Unknown';

        }

        // Optional: cast numeric fields
        $booking['id'] = (int)$booking['id'];
        $booking['customer_id'] = (int)$booking['customer_id'];
        $booking['amount'] = (float)$booking['amount'];
        $booking['status'] = (int)$booking['status'];
        $booking['confirm_status'] = (int)$booking['confirm_status'];
    }

    echo json_encode([
        "status" => true,
        "message" => "Recent bookings fetched successfully.",
        "data" => $bookings
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);
}