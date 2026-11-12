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

    /* =========================================================
       GET USER ID
    ========================================================= */

    $user_id = $input['userId'] ?? null;

    if (empty($user_id)) {

        echo json_encode([
            'status'  => false,
            'message' => 'userId is required.'
        ]);

        exit;
    }


    /* =========================================================
       GET PACKAGE ID
    ========================================================= */

    $package_id = $input['packageId'] ?? null;

    $package_id = (int) $package_id;

    if ($package_id <= 0) {

        echo json_encode([
            'status'  => false,
            'message' => 'Invalid package ID.'
        ]);

        exit;
    }


    /* =========================================================
       CHECK PACKAGE EXISTS
    ========================================================= */

    $stmt = $conn->prepare("

        SELECT id
        FROM package
        WHERE id = ?
          AND status = '1'
        LIMIT 1

    ");

    $stmt->execute([
        $package_id
    ]);

    $package = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$package) {

        echo json_encode([
            'status'  => false,
            'message' => 'Package not found.'
        ]);

        exit;
    }


    /* =========================================================
       CHECK EXISTING ACTIVE WISHLIST
    ========================================================= */

    $stmt = $conn->prepare("

        SELECT id
        FROM wishlist
        WHERE user_id = ?
          AND package_id = ?
          AND status = 1
        LIMIT 1

    ");

    $stmt->execute([
        $user_id,
        $package_id
    ]);

    $existingWishlist =
        $stmt->fetch(PDO::FETCH_ASSOC);


    /* =========================================================
       ALREADY SAVED - REMOVE FROM WISHLIST
    ========================================================= */

    if ($existingWishlist) {

        $stmt = $conn->prepare("

            UPDATE wishlist
            SET
                status = 0,
                deleted_date = CURRENT_TIMESTAMP
            WHERE id = ?

        ");

        $stmt->execute([
            $existingWishlist['id']
        ]);

        echo json_encode([
            'status'      => true,
            'message'     => 'Package removed from wishlist.',
            'saved'       => false,
            'wishlist_id' => $existingWishlist['id']
        ]);

        exit;
    }


    /* =========================================================
       CHECK PREVIOUS DELETED RECORD
    ========================================================= */

    $stmt = $conn->prepare("

        SELECT id
        FROM wishlist
        WHERE user_id = ?
          AND package_id = ?
          AND status = 0
        ORDER BY id DESC
        LIMIT 1

    ");

    $stmt->execute([
        $user_id,
        $package_id
    ]);

    $deletedWishlist =
        $stmt->fetch(PDO::FETCH_ASSOC);


    /* =========================================================
       RESTORE PREVIOUS RECORD
    ========================================================= */

    if ($deletedWishlist) {

        $stmt = $conn->prepare("

            UPDATE wishlist
            SET
                status = 1,
                deleted_date = NULL,
                created_date = CURRENT_TIMESTAMP
            WHERE id = ?

        ");

        $stmt->execute([
            $deletedWishlist['id']
        ]);

        echo json_encode([
            'status'      => true,
            'message'     => 'Package saved successfully.',
            'saved'       => true,
            'wishlist_id' => $deletedWishlist['id']
        ]);

        exit;
    }


    /* =========================================================
       INSERT NEW WISHLIST
    ========================================================= */

    $stmt = $conn->prepare("

        INSERT INTO wishlist
        (
            user_id,
            package_id,
            created_date,
            deleted_date,
            status
        )
        VALUES
        (
            ?,
            ?,
            CURRENT_TIMESTAMP,
            NULL,
            1
        )

    ");

    $stmt->execute([
        $user_id,
        $package_id
    ]);

    $wishlist_id =
        $conn->lastInsertId();


    /* =========================================================
       SUCCESS
    ========================================================= */

    echo json_encode([
        'status'      => true,
        'message'     => 'Package saved successfully.',
        'saved'       => true,
        'wishlist_id' => $wishlist_id
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'status'  => false,
        'message' => 'Database error.',
        'error'   => $e->getMessage()
    ]);

} catch (Exception $e) {

    echo json_encode([
        'status'  => false,
        'message' => $e->getMessage()
    ]);
}