<?php
    require '../../../../connect.php';

    header('Content-Type: application/json');

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode([
            "status" => false,
            "message" => "Invalid request method.",
            "data" => []
        ]);
        exit;
    }

    try {

        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        if (!$data) {
            throw new Exception("Invalid JSON data.");
        }

        if (!isset($data['userId']) || empty(trim($data['userId']))) {
            throw new Exception("User ID is required.");
        }

        $userId = trim($data['userId']);

        $sqlSTE = $conn->prepare("
            SELECT *
            FROM super_techno_enterprise
            WHERE super_techno_enterprise_id = :user_id
            AND status = 1
        ");

        $sqlSTE->execute([
            ':user_id' => $userId
        ]);

        $steData = $sqlSTE->fetch(PDO::FETCH_ASSOC);

        if ($steData) {

            echo json_encode([
                'status'  => true,
                'message' => 'Data fetched successfully',
                'data'    => $steData
            ]);

        } else {

            echo json_encode([
                'status'  => false,
                'message' => 'No record found',
                'data'    => null
            ]);

        }

    } catch (PDOException $e) {

        echo json_encode([
            'status'  => false,
            'message' => $e->getMessage(),
            'data'    => null
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'status'  => false,
            'message' => $e->getMessage(),
            'data'    => null
        ]);

    }

    exit;
?>