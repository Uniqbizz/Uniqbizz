<?php
header("Content-Type: application/json");
require '../../../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}
 
 
try {
    // Get input (from POST or JSON body)
    $data = json_decode(file_get_contents("php://input"), true);

    $userId = $data['user_id'] ?? '';
    $userType = $data['user_type'] ?? '';
    $travelType = $data['travelType'] ?? '';

    if (empty($userId) || empty($userType)) {
        echo json_encode(["status" => false, "message" => "Missing required parameters"]);
        exit;
    }

    // Base Query
    $query = "SELECT p.id, p.name, c.category_name, 
                     t.total_package_price_per_adult, 
                     t.total_package_price_per_child, 
                     pt.ca_direct_commission, 
                     pt.ta_markup
              FROM package p
              JOIN package_pricing t ON p.id = t.package_id
              JOIN category c ON p.category_id = c.id
              JOIN package_pricing_markup pt ON p.id = pt.package_id
              WHERE p.status = '1' AND c.status = '1'";

    // Apply travelType filter
    if (!empty($travelType)) {
        $query .= " AND c.category_name = :category";
    }

    $query .= " ORDER BY p.id DESC";

    $stmt = $conn->prepare($query);
    if (!empty($travelType)) {
        $stmt->bindParam(':category', $travelType);
    }
    $stmt->execute();

    $packages = [];
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $package_id = $row['id'];
            $adult_price = (float)$row['total_package_price_per_adult'];
            $child_price = (float)$row['total_package_price_per_child'];
            $commission = ($userType == '11') ? (float)$row['ta_markup'] : (float)$row['ca_direct_commission'];

            // Fetch markup info for travel agent (userType = 11)
            $markup = 0;
            $markup_total = $adult_price;
            if ($userType == '11') {
                $stmt2 = $conn->prepare("SELECT * FROM package_markup_travelagent 
                                         WHERE travelagent_id = :userId 
                                         AND package_id = :pkgId");
                $stmt2->bindParam(':userId', $userId);
                $stmt2->bindParam(':pkgId', $package_id);
                $stmt2->execute();
                $ta_markup = $stmt2->fetch(PDO::FETCH_ASSOC);
                if ($ta_markup) {
                    $markup = (float)$ta_markup['markup'];
                    $markup_total = (float)$ta_markup['selling_price_adult'];
                }
            }

            $packages[] = [
                "package_id" => $package_id,
                "package_name" => $row['name'],
                "package_type" => $row['category_name'],
                "adult_price" => $adult_price,
                "child_price" => $child_price,
                "commission" => $commission,
                "markup" => $markup,
                "selling_price" => $markup_total
            ];
        }

        echo json_encode(["status" => true, "data" => $packages]);
    } else {
        echo json_encode(["status" => false, "message" => "No products found"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => false, "message" => $e->getMessage()]);
}
