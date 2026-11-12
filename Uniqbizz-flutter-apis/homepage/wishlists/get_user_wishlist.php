<?php

require '../../../connect.php';

header('Content-Type: application/json');

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['status' => false, 'message' => 'Method not allowed']);
        exit;
    }

    $input = json_decode(file_get_contents("php://input"), true);

    $userId = $input['userId'] ?? null;

    if (empty($userId)) {

        echo json_encode([
            'status' => true,
            'data'   => []
        ]);

        exit;
    }

    $sql = "
        SELECT package_id
        FROM wishlist
        WHERE user_id = :user_id
          AND status = 1
          AND deleted_date IS NULL
    ";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':user_id' => $userId
    ]);

    $wishlist = $stmt->fetchAll(
        PDO::FETCH_COLUMN
    );

    $wishlist = array_values(
        array_unique(
            array_map(
                'strval',
                $wishlist
            )
        )
    );

    echo json_encode([
        'status' => true,
        'data'   => $wishlist
    ]);

} catch (Throwable $e) {

    echo json_encode([
        'status'  => false,
        'message' => $e->getMessage()
    ]);
}