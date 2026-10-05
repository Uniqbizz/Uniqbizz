<?php

require '../../connect.php';

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {

    /* =========================================================
       CHECK LOGIN
    ========================================================= */

    $user_id = $_SESSION['user_id'] ?? null;

    if (empty($user_id)) {

        echo json_encode([
            'status'  => false,
            'message' => 'User is not logged in.'
        ]);

        exit;
    }


    /* =========================================================
       GET PACKAGE ID
    ========================================================= */

    $package_id = $_POST['package_id'] ?? null;

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
       ALREADY SAVED
    ========================================================= */

    if ($existingWishlist) {

        echo json_encode([
            'status'  => true,
            'message' => 'Package already saved.',
            'saved'   => true,
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