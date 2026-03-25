<?php
header('Content-Type: application/json');

require '../../../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

try {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
        exit;
    }

    function getData($key, $default = null)
    {
        global $data;
        return isset($data[$key]) ? trim($data[$key]) : $default;
    }

    $ta_id = getData('userId');

    // Prepare SQL query
    $sql = "SELECT 
                bookings.order_id,
                bookings.name,
                package.name AS package_name,
                booking_direct_bill.total_net_payable AS amount,
                bookings.created_date AS booking_date,
                bookings.date AS travel_date
            FROM bookings
            INNER JOIN booking_direct_bill ON booking_direct_bill.bookings_id = bookings.id
            INNER JOIN package ON package.id = package_id AND package.status = 1
            WHERE bookings.ta_id = :userId
            ORDER BY bookings.id DESC
            LIMIT 5";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $ta_id);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Response handling
    if (count($data) > 0) {
        echo json_encode([
            "status" => "success",
            "total" => count($data),
            "data" => $data
        ], JSON_PRETTY_PRINT);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "No records found"
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $e->getMessage()
    ]);
}
