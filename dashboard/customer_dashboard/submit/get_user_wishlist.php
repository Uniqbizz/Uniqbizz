<?php

require '../../connect.php';

header('Content-Type: application/json');

session_start();

try {

    $userId = $_SESSION['user_id'] ?? null;

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