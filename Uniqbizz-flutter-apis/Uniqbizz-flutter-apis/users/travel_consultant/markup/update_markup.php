<?php
header("Content-Type: application/json");
require '../../../connect.php';
date_default_timezone_set("Asia/Kolkata");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}
 
try {
    // Read and decode JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    // Validate input
    if (
        !isset(
            $data['ta_id'],
            $data['package_id'],
            $data['product_price_adult'],
            $data['product_price_child'],
            $data['markup']
        )
    ) {
        echo json_encode([
            "status" => false,
            "message" => "Missing required parameters"
        ]);
        exit;
    }

    // Extract and sanitize input
    $ta_id = $data['ta_id'];
    $package_id = (int)$data['package_id'];
    $product_price_adult = (float)$data['product_price_adult'];
    $product_price_child = (float)$data['product_price_child'];
    $markup_price = (float)$data['markup'];

    // Calculate totals
    $total_adult = $product_price_adult + $markup_price;
    $total_child = $product_price_child;

    // Check if record exists
    $stmt = $conn->prepare("SELECT id FROM package_markup_travelagent WHERE travelagent_id = :ta_id AND package_id = :package_id");
    $stmt->execute([
        ':ta_id' => $ta_id,
        ':package_id' => $package_id
    ]);
    $exists = $stmt->fetchColumn();

    if ($exists) {
        // Update existing record
        $sql = "UPDATE package_markup_travelagent 
                SET markup = :markup, 
                    selling_price_adult = :total_adult, 
                    selling_price_child = :total_child, 
                    status = '1'
                WHERE travelagent_id = :ta_id AND package_id = :package_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':markup' => $markup_price,
            ':total_adult' => $total_adult,
            ':total_child' => $total_child,
            ':ta_id' => $ta_id,
            ':package_id' => $package_id
        ]);

        echo json_encode([
            "status" => true,
            "action" => "updated",
            "message" => "Markup updated successfully",
            "data" => [
                "markup" => $markup_price,
                "selling_price_adult" => $total_adult,
                "selling_price_child" => $total_child,
                "TC_ID" => $ta_id
            ]
        ]);
    } else {
        // Insert new record
        $sql = "INSERT INTO package_markup_travelagent 
                (travelagent_id, package_id, markup, selling_price_adult, selling_price_child, status) 
                VALUES (:ta_id, :package_id, :markup, :total_adult, :total_child, '1')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':ta_id' => $ta_id,
            ':package_id' => $package_id,
            ':markup' => $markup_price,
            ':total_adult' => $total_adult,
            ':total_child' => $total_child
        ]);

        echo json_encode([
            "status" => true,
            "action" => "inserted",
            "message" => "Markup added successfully",
            "data" => [
                "markup" => $markup_price,
                "selling_price_adult" => $total_adult,
                "selling_price_child" => $total_child,
                "TC_ID" => $ta_id
            ]
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        "status" => false,
        "message" => "Server Error: " . $e->getMessage()
    ]);
}
