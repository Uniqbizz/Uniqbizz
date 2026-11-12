<?php
header("Content-Type: application/json");
require '../../connect.php';

try {
    $sql = "
    SELECT * FROM (
        SELECT 
            p.id, 
            p.destination, 
            pi.image, 
            p.tour_days, 
            p.name,
            p.status,
            MAX(b.created_date) AS last_booking_date,
            pp.total_package_price_per_adult
        FROM package p
        LEFT JOIN bookings b ON b.package_id = p.id
        LEFT JOIN package_pricing pp ON pp.package_id = p.id
        INNER JOIN (
            SELECT package_id, image
            FROM package_pictures
            WHERE id IN (
                SELECT MAX(id)
                FROM package_pictures
                GROUP BY package_id
            )
        ) pi ON pi.package_id = p.id
        WHERE p.status = 1 AND b.id IS NOT NULL
        GROUP BY p.id, p.destination, pi.image, p.tour_days, p.name, p.status, pp.total_package_price_per_adult
        ORDER BY last_booking_date ASC
    ) AS recent_booked

    UNION

    SELECT * FROM (
        SELECT 
            p.id, 
            p.destination, 
            pi.image, 
            p.tour_days, 
            p.name,
            p.status,
            NULL AS last_booking_date,
            pp.total_package_price_per_adult
        FROM package p
        LEFT JOIN package_pricing pp ON pp.package_id = p.id
        INNER JOIN (
            SELECT package_id, image
            FROM package_pictures
            WHERE id IN (
                SELECT MAX(id)
                FROM package_pictures
                GROUP BY package_id
            )
        ) pi ON pi.package_id = p.id
        WHERE p.status = 1
        GROUP BY p.id, p.destination, pi.image, p.tour_days, p.name, p.status, pp.total_package_price_per_adult
        ORDER BY p.id ASC
    ) AS recent_added
";


    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $packages = $stmt->fetchAll();

    echo json_encode([
        "status" => "success",
        "count" => count($packages),
        "packages" => $packages
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
