<?php
// Set headers to allow cross-origin requests and return JSON
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

    if (!empty($data["country_id"])) {
        // Fetch states by country_id
        $stmt = $conn->prepare("SELECT id, state_name FROM states WHERE country_id = :country_id AND status = 1 ORDER BY state_name ASC");
        $stmt->bindParam(":country_id", $data["country_id"]);
        $stmt->execute();
        $states = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($states) {
            $response = [
                "status" => "success",
                "type" => "state",
                "data" => $states
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "No states found."
            ];
        }
    } elseif (!empty($data["state_id"])) {
        // Fetch cities by state_id
        $stmt = $conn->prepare("SELECT id, city_name FROM cities WHERE state_id = :state_id AND status = 1 ORDER BY city_name ASC");
        $stmt->bindParam(":state_id", $data["state_id"]);
        $stmt->execute();
        $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($cities) {
            $response = [
                "status" => "success",
                "type" => "city",
                "data" => $cities
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "No cities found."
            ];
        }
    } else {
        $response = [
            "status" => "error",
            "message" => "Invalid request. Provide 'country_id' or 'state_id'."
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
