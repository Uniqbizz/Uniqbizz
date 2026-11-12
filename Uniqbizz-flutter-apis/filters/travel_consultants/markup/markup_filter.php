<?php
header("Content-Type: application/json");
require '../../../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => false, "message" => "Invalid request method"]);
    exit;
}

try {
    $data = json_decode(file_get_contents("php://input"), true);

    $userId      = $data['user_id'] ?? '';
    $userType    = $data['user_type'] ?? '';
    $search      = trim($data['search'] ?? '');
    $packageType = trim($data['package_type'] ?? '');

    if (empty($userId) || empty($userType)) {
        echo json_encode([
            "status" => false,
            "message" => "user_id and user_type are required"
        ]);
        exit;
    }

    // Base query
    $query = "SELECT 
                p.id,
                p.name,
                c.category_name,
                t.total_package_price_per_adult,
                t.total_package_price_per_child,
                pt.ca_direct_commission,
                pt.ta_markup
              FROM package p
              JOIN package_pricing t ON p.id = t.package_id
              JOIN category c ON p.category_id = c.id
              JOIN package_pricing_markup pt ON p.id = pt.package_id
              WHERE p.status = '1' AND c.status = '1'";

    // ✅ 1. APPLY STRICT FILTER FIRST
    if (!empty($packageType)) {
    $query .= " AND LOWER(TRIM(c.category_name)) LIKE :package_type";
    }

    // ✅ 2. THEN APPLY SEARCH
    if (!empty($search)) {
        $query .= " AND (LOWER(p.name) LIKE :search OR LOWER(c.category_name) LIKE :search)";
    }

    $query .= " ORDER BY p.id DESC";

    $stmt = $conn->prepare($query);

    // Bind package_type FIRST
    if (!empty($packageType)) {
        $packageTypeParam = "%" . strtolower(trim($packageType)) . "%";
        $stmt->bindParam(':package_type', $packageTypeParam);
    }

    // Bind search
    if (!empty($search)) {
        $searchParam = "%" . strtolower($search) . "%";
        $stmt->bindParam(':search', $searchParam);
    }

    $stmt->execute();

    $packages = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $package_id = $row['id'];
        $adult_price = (float)$row['total_package_price_per_adult'];
        $child_price = (float)$row['total_package_price_per_child'];

        $commission = ($userType == '11')
            ? (float)$row['ta_markup']
            : (float)$row['ca_direct_commission'];

        $markup = 0;
        $selling_price = $adult_price;

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
                $selling_price = (float)$ta_markup['selling_price_adult'];
            }
        }

        $packages[] = [
            "package_id"   => $package_id,
            "package_name" => $row['name'],
            "package_type" => $row['category_name'],
            "adult_price"  => $adult_price,
            "child_price"  => $child_price,
            "commission"   => $commission,
            "markup"       => $markup,
            "selling_price"=> $selling_price
        ];
    }

    if (count($packages) > 0) {
        echo json_encode([
            "status" => true,
            "count"  => count($packages),
            "data"   => $packages
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "No matching packages found"
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ]);
}