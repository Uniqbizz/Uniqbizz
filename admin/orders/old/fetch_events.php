<?php
require '../connect.php'; // Ensure this sets up a PDO connection
header('Content-Type: application/json');

try {
    $selected_date = isset($_GET['selected_date']) ? $_GET['selected_date'] : null;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 4; // Default limit: 5

    $sql = "SELECT 
                b.id, 
                b.order_id, 
                b.package_id, 
                DATE_FORMAT(b.date, '%Y-%m-%d') AS date, 
                b.customer_id, 
                b.name, 
                b.status, 
                p.name AS package_name, 
                c.profile_pic AS customer_profile_pic,
                (SELECT image FROM package_pictures WHERE package_id = b.package_id LIMIT 1) AS package_image,
                p.tour_days
            FROM bookings b
            LEFT JOIN package p ON b.package_id = p.id
            LEFT JOIN ca_customer c ON b.customer_id = c.ca_customer_id";

    // If a date is selected, filter by date
    if ($selected_date) {
        $sql .= " WHERE b.date = :selected_date";
    }

    $sql .= " ORDER BY b.date DESC LIMIT $limit"; // Append limit directly

    $stmt = $conn->prepare($sql); // ✅ Using $conn as requested

    if ($selected_date) {
        $stmt->bindParam(':selected_date', $selected_date);
    }

    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["bookings" => $bookings ?: []], JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
