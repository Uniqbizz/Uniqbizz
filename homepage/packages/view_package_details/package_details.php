<?php
require '../../../connect.php'; // Include your database connection
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$package_id = isset($data['id']) ? $data['id'] : '';

try {

    //basic pakage details

    $sql = "SELECT id,package_type,name,unique_code,package_keywords,description,sightseeing_type,status,validity,tour_days FROM `package` WHERE `id` = :package_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $package_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //pricing

    $sql2 = "SELECT total_package_price_per_adult,total_package_price_per_child FROM `package_pricing` WHERE `package_id` = :package_id";
    $stmt = $conn->prepare($sql2);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $package_price = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //pictures

    $sql3 = "SELECT package_id,image FROM `package_pictures` WHERE `package_id` = :package_id";
    $stmt = $conn->prepare($sql3);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $package_pictures = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Vehicles → multiple possible
    $sql4 = "SELECT TRIM(h.name) AS vehicles
         FROM package_to_category_vehicle p
         INNER JOIN category_vehicle h ON p.vehicle_id = h.id
         WHERE p.package_id = :package_id";
    $stmt = $conn->prepare($sql4);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();

    $package_vehicles = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (!empty($row['vehicles'])) {
            $package_vehicles[] = trim($row['vehicles']);
        }
    }

    // Meals → split properly
    $sql5 = "SELECT TRIM(m.name) AS meals
         FROM package p
         INNER JOIN category_meal m ON p.category_meal_id = m.id
         WHERE p.id = :package_id";
    $stmt = $conn->prepare($sql5);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $package_meals = $stmt->fetchColumn();

    // Clean spaces & split
    $package_meals = $package_meals
        ? array_filter(array_map('trim', preg_split('/\s+/', $package_meals)))
        : [];

    // Hotels → multiple possible, return as array
    $sql6 = "SELECT TRIM(h.name) AS hotel
         FROM package p
         INNER JOIN category_hotel h ON p.category_hotel_id = h.id
         WHERE p.id = :package_id";
    $stmt = $conn->prepare($sql6);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();

    $package_hotels = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (!empty($row['hotel'])) {
            $package_hotels[] = trim($row['hotel']);
        }
    }

    //occupancy type

    $sql7 = "SELECT TRIM(h.name) AS hotel_type
         FROM package_to_category_occupancy p
         INNER JOIN category_occupancy h ON p.occupancy_id = h.id
         WHERE p.package_id = :package_id";
    $stmt = $conn->prepare($sql7);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();

    $package_occupancy = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (!empty($row['hotel_type'])) {
            $package_occupancy[] = trim($row['hotel_type']);
        }
    }

    //included/excluded/remarks

    $sql8 = "SELECT package_id,inclusion,exclusion,remark FROM `package_itinerary_details` WHERE `package_id` = :package_id";
    $stmt = $conn->prepare($sql8);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $package_itenary = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //tour plan

    $sql9 = "SELECT 
            CONCAT('Day ', @rownum := @rownum + 1) AS day,
            title,
            day_details,
            day_tansport,
            meal_plan
         FROM package_trip_days, (SELECT @rownum := 0) r
         WHERE package_id = :package_id
         ORDER BY id ASC";

    $stmt = $conn->prepare($sql9);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $package_tour_plan = $stmt->fetchAll(PDO::FETCH_ASSOC);




    if ($package_id) {
        echo json_encode([
            "status" => "success",
            "package_details" => $package_details,
            "package_price" => $package_price,
            "package_pictures" => $package_pictures,
            "package_hotels" => $package_hotels,
            "package_meals" => $package_meals,
            "package_vehicles" => $package_vehicles,
            "package_occupancy_type" => $package_occupancy,
            "package_itenary" => $package_itenary,
            "package_tour_plan" => $package_tour_plan
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "No package found"]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
