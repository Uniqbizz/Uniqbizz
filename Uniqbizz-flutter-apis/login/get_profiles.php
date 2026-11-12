<?php

require '../../connect.php';
header('Content-Type: application/json');

try {

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        throw new Exception("Invalid request method");
    }

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!$data) {
        throw new Exception("Invalid JSON data");
    }

    $email = trim($data['email'] ?? '');

    if (empty($email)) {
        throw new Exception("Email is required");
    }

    // Future user types:
    // 24, 25, 26, 16, 11, 10, 28, 29, 30, 32, 33, 34, 35, 36

    // Future user_id prefixes:
    // CTE, ETE, STE, BH, BM, MF, SF, TE, CA, I, F, TA, IBR, CU

    $sql = "
        SELECT
            l.user_id,
            l.user_type_id,
            ut.name AS user_type_name

        FROM login l

        LEFT JOIN user_type ut
            ON ut.id = l.user_type_id

        WHERE l.username = :email
        AND l.user_type_id IN (11, 10, 29, 16)
        AND (
            l.user_id LIKE 'F%'
            OR l.user_id LIKE 'TA%'
            OR l.user_id LIKE 'CU%'
            OR l.user_id LIKE 'TE%'
            OR l.user_id LIKE 'CA%'
        )
        AND l.status = 1

        ORDER BY l.id
    ";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':email' => $email
    ]);

    $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($profiles)) {
        throw new Exception("No profiles found for this email");
    }

    echo json_encode([
        "status" => true,
        "message" => "Profiles fetched successfully",
        "profiles" => $profiles
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ]);
}