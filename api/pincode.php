<?php
header("Content-Type: application/json; charset=UTF-8");

// Include DB config
require 'connect.php';

$response = [];

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["status" => "error", "message" => "Invalid request method"]);
        exit;
    }

    // Capture JSON data
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
        exit;
    }

    if (!empty($data["city_id"])) {
        $city_id = $data["city_id"];

        // Secure query using parameterized statements
        $stmt = $conn->prepare("SELECT pincode FROM cities WHERE id = :city_id AND status = 1");
        $stmt->bindParam(":city_id", $city_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetch();

        if ($result) {
            $response = [
                "status" => "success",
                "data" => [
                    "pincode" => $result["pincode"]
                ]
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "Pincode not found for the given city."
            ];
        }
    } else {
        $response = [
            "status" => "error",
            "message" => "Missing 'city_id' parameter."
        ];
    }
} catch (PDOException $e) {
    $response = [
        "status" => "error",
        "message" => "Database error: " . $e->getMessage()
    ];
}

// Return JSON response
echo json_encode($response);
?>
