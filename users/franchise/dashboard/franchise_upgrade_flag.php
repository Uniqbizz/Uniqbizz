<?php
require '../../../connect.php';
header('Content-Type: application/json');

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode([
            'status' => false,
            'message' => 'Method not allowed'
        ]);
        exit;
    }

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!isset($data['id'])) {
        echo json_encode([
            "status" => false,
            "message" => "Missing id"
        ]);
        exit;
    }

    $id = $data['id'];

    $stmt3 = $conn->prepare("SELECT upgrade_status FROM sub_franchisee WHERE sub_franchisee_id = :id LIMIT 1");
    $stmt3->bindParam(':id', $id);
    $stmt3->execute();

    if ($stmt3->rowCount() > 0) {

        $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
        $franchise_upgrade_flag = $row3['upgrade_status'] ?? '';

        $initial_inv = 0;

        $sql = "SELECT amount 
                FROM sub_franchisee 
                WHERE sub_franchisee_id = :id 
                AND status = 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $initial_inv = $row['amount'];
        }

        $tamount = $initial_inv;

        $sql = "SELECT upgrade_amt
                FROM sub_franchisee_upgrade
                WHERE sub_franchisee_id = :id
                AND upgrade_status = 1
                ORDER BY upgrade_approval_date DESC
                LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tamount = $row['upgrade_amt'];
        }

        echo json_encode([
            "status" => true,
            "message" => "Franchise upgrade flag & total investment fetched",
            "total_investment" => (float)$tamount,
            "franchise_upgrade_flag" => $franchise_upgrade_flag
        ]);

    } else {

        echo json_encode([
            "status" => false,
            "message" => "No franchise found with this id",
            "franchise_upgrade_flag" => null
        ]);
    }

} catch (PDOException $e) {

    http_response_code(500);
    echo json_encode([
        "status" => false,
        "message" => "DB Error",
        "error" => $e->getMessage()
    ]);
}