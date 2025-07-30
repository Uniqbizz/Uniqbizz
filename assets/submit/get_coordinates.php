<?php
require_once("../../connect.php");
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Read incoming JSON
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Filters
$destination = $data['destination'] ?? null;
$durationMin = $data['durationMin'] ?? null;
$durationMax = $data['durationMax'] ?? null;
$priceMin = $data['priceMin'] ?? null;
$priceMax = $data['priceMax'] ?? null;
$categoryHotel = $data['hotelCategory'] ?? [];

// Function to geocode using Nominatim
function geocodeDestination($placeName) {
    $url = "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($placeName);
    $opts = [
        "http" => [
            "header" => "User-Agent: MyTravelApp/1.0\r\n"
        ]
    ];
    $context = stream_context_create($opts);
    $response = file_get_contents($url, false, $context);
    $data = json_decode($response, true);

    if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
        return [
            'lat' => $data[0]['lat'],
            'lng' => $data[0]['lon']
        ];
    }
    return ['lat' => null, 'lng' => null];
}

try {
    $sql = "SELECT 
                p.id, 
                p.name, 
                p.destination, 
                (p.tour_days - 1) AS duration, 
                pr.total_package_price_per_adult AS price,
                p.description
            FROM package p 
            LEFT JOIN package_pricing pr ON p.id = pr.package_id 
            WHERE 1=1";

    $params = [];

    if (!empty($durationMin) && !empty($durationMax)) {
        $sql .= " AND (p.tour_days - 1) BETWEEN :durationMin AND :durationMax";
        $params[':durationMin'] = $durationMin;
        $params[':durationMax'] = $durationMax;
    }

    if (!empty($priceMin) && !empty($priceMax)) {
        $sql .= " AND pr.total_package_price_per_adult BETWEEN :priceMin AND :priceMax";
        $params[':priceMin'] = $priceMin;
        $params[':priceMax'] = $priceMax;
    }

    if (!empty($categoryHotel)) {
        $placeholders = [];
        foreach ($categoryHotel as $index => $id) {
            $key = ":category_id_$index";
            $placeholders[] = $key;
            $params[$key] = $id;
        }
        $sql .= " AND p.category_hotel_id IN (" . implode(',', $placeholders) . ")";
    }

    if (!empty($destination)) {
        $sql .= " AND p.destination = :destination";
        $params[':destination'] = $destination;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$packages) {
        echo json_encode(['destinations' => []]);
        exit;
    }

    // Get all package IDs
    $packageIds = array_column($packages, 'id');
    $inQuery = implode(',', array_fill(0, count($packageIds), '?'));
    $stmtImages = $conn->prepare("SELECT package_id, image FROM package_pictures WHERE package_id IN ($inQuery)");
    $stmtImages->execute($packageIds);
    $imageRows = $stmtImages->fetchAll(PDO::FETCH_ASSOC);

    // Group images by package_id
    $imagesByPackage = [];
    foreach ($imageRows as $row) {
        $imagesByPackage[$row['package_id']][] = $row['image'];
    }

    // Append images + coordinates to each package
    foreach ($packages as &$pkg) {
        $pkg['images'] = $imagesByPackage[$pkg['id']] ?? [];

        // Geocode destination
        $coords = geocodeDestination($pkg['destination']);
        $pkg['lat'] = $coords['lat'];
        $pkg['lng'] = $coords['lng'];
    }

    echo json_encode(['destinations' => $packages]);

} catch (PDOException $e) {
    echo json_encode([
        "error" => $e->getMessage(),
        "query" => $sql,
        "params" => $params
    ]);
}
?>
