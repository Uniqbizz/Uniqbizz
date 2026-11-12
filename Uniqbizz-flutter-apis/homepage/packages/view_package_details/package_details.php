<?php
require '../../../../connect.php'; // Include your database connection
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$package_id = isset($data['id']) ? $data['id'] : '';
$userType   = isset($data['userType']) ? $data['userType'] : '';

try {

    //basic pakage details
    // NOTE: added destination + location so the "similar packages" query below has
    // something to match against. Remove them from this SELECT if those columns
    // don't exist on `package` in your schema.
    $sql = "SELECT id,package_type,name,unique_code,package_keywords,description,sightseeing_type,status,validity,tour_days,destination,location FROM `package` WHERE `id` = :package_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $package_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //highlights

    $sql10 = "SELECT * FROM package_itinerary_details WHERE package_id = :package_id";
    $stmt = $conn->prepare($sql10);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $package_highlights = $stmt->fetch(PDO::FETCH_ASSOC);

    //policies

    $sql11 = "SELECT title, file_name FROM package_policy_document WHERE package_id = :package_id ORDER BY id ASC";
    $stmt = $conn->prepare($sql11);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $package_policies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //FAQs

    $sql12 = "SELECT * FROM package_policy_document WHERE package_id = :package_id AND LOWER(title) = 'faq' LIMIT 1";
    $stmt = $conn->prepare($sql12);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $package_faqs = $stmt->fetch(PDO::FETCH_ASSOC);

    //remarks & things to know

    $sql13 = "SELECT * FROM package_itinerary_details WHERE package_id = :package_id";
    $stmt = $conn->prepare($sql13);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $package_itenaries = $stmt->fetch(PDO::FETCH_ASSOC);

    //pricing

    $sql2 = "SELECT * FROM `package_pricing` WHERE `package_id` = :package_id";
    $stmt = $conn->prepare($sql2);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $package_price_raw = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $showGuestPrice = !empty($userType) && !in_array((int)$userType, [1, 17, 15]);

    $package_price = [];

    foreach ($package_price_raw as $pricing) {

        $adult_price = $pricing['total_package_price_per_adult'] ?? 0;
        $child_price = $pricing['total_package_price_per_child'] ?? 0;

        $adultDisplayPrice = $adult_price;
        $childDisplayPrice = $child_price;

        if ($showGuestPrice) {

            if (!empty($pricing['guest_amount'])) {
                $guestAmount = (float) $pricing['guest_amount'];

                $adultDisplayPrice = $adult_price - $guestAmount;
                $childDisplayPrice = $child_price - $guestAmount;

            } elseif (!empty($pricing['guest_percentage'])) {
                $percentage = (float) $pricing['guest_percentage'];

                $adultDisplayPrice = $adult_price / (1 + ($percentage / 100));
                $childDisplayPrice = $child_price / (1 + ($percentage / 100));
            }
        }

        $package_price[] = [
            "adult_price"        => $adult_price,
            "child_price"        => $child_price,
            "adultDisplayPrice"  => $adultDisplayPrice,
            "childDisplayPrice"  => $childDisplayPrice,
        ];
    }


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
            meal_plan,
            stay
         FROM package_trip_days, (SELECT @rownum := 0) r
         WHERE package_id = :package_id
         ORDER BY id ASC";

    $stmt = $conn->prepare($sql9);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $package_tour_plan = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //similar packages

    $package_array = [];

    if (!empty($package_details)) {

        $current_package    = $package_details[0];
        $package_keywords   = $current_package['package_keywords'] ?? '';
        $destination        = $current_package['destination'] ?? '';
        $location           = $current_package['location'] ?? '';

        // Get latest 10 similar packages
        $sqlPack = $conn->prepare("
            SELECT *
            FROM package
            WHERE status = 1
            AND id != ?
            AND (
                    package_keywords LIKE ?
                    OR destination LIKE ?
                    OR location LIKE ?
                )
            ORDER BY id DESC
            LIMIT 10
        ");

        $sqlPack->execute([
            $package_id,
            "%$package_keywords%",
            "%$destination%",
            "%$location%"
        ]);

        $similar_packages = $sqlPack->fetchAll(PDO::FETCH_ASSOC);

        foreach ($similar_packages as $similarPackage) {

            $sqlPackPrice = $conn->prepare("
                SELECT total_package_price_per_adult
                FROM package_pricing
                WHERE package_id = ?
                ORDER BY id DESC
                LIMIT 1
            ");
            $sqlPackPrice->execute([$similarPackage['id']]);
            $packagePrice = $sqlPackPrice->fetch(PDO::FETCH_ASSOC);

            $sqlPackImage = $conn->prepare("
                SELECT image
                FROM package_pictures
                WHERE package_id = ?
                AND type NOT IN ('video')
                ORDER BY id ASC
            ");
            $sqlPackImage->execute([$similarPackage['id']]);
            $packageImages = $sqlPackImage->fetchAll(PDO::FETCH_COLUMN);

            $days   = (int) $similarPackage['tour_days'];
            $nights = max(0, $days - 1);

            $package_duration = $nights . "N / " . $days . "D";

            $package_array[] = [
                "packid"   => $similarPackage['id'],
                "title"    => $similarPackage['name'],
                "duration" => $package_duration,
                "price"    => $packagePrice['total_package_price_per_adult'] ?? 0,
                "images"   => $packageImages,
                "link"     => "tour-details.php?pacId=" . $similarPackage['id']
            ];
        }
    }

    // related videos

    $sql14 = "SELECT image FROM package_pictures WHERE package_id = :package_id AND type = 'video' ORDER BY id ASC";
    $stmt = $conn->prepare($sql14);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $package_videos = $stmt->fetchAll(PDO::FETCH_COLUMN);
    


    if ($package_id) {
        echo json_encode([
            "status" => "success",
            "package_details" => $package_details,
            "package_highlights" => $package_highlights['highlights'],
            "package_policies" => $package_policies,
            "package_faqs" => $package_faqs['file_name'],
            "package_price" => $package_price,
            "package_pictures" => $package_pictures,
            "package_hotels" => $package_hotels,
            "package_meals" => $package_meals,
            "package_vehicles" => $package_vehicles,
            "package_occupancy_type" => $package_occupancy,
            "package_itenary" => $package_itenary,
            "package_tour_plan" => $package_tour_plan,
            "package_remarks" => $package_itenaries['remark'],
            "package_things_to_know" => $package_itenaries['travel_info'],
            "package_similar" => $package_array,
            "package_related_videos" => $package_videos
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "No package found"]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}