<?php

require '../../connect.php';

header('Content-Type: application/json');

session_start();

try {

    /*
    |--------------------------------------------------------------------------
    | GET LOGGED-IN USER
    |--------------------------------------------------------------------------
    */

    $userId = $_SESSION['user_id'] ?? null;


    /*
    |--------------------------------------------------------------------------
    | GET PACKAGE IDS
    |--------------------------------------------------------------------------
    */

    $packageIds = json_decode(
        $_POST['package_ids'] ?? '[]',
        true
    );


    if (!is_array($packageIds)) {

        echo json_encode([
            'status' => false,
            'message' => 'Invalid wishlist data'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | CONVERT IDS TO INTEGER
    |--------------------------------------------------------------------------
    */

    $packageIds = array_values(
        array_unique(
            array_filter(
                array_map(
                    'intval',
                    $packageIds
                )
            )
        )
    );


    if (empty($packageIds)) {

        echo json_encode([
            'status' => true,
            'data'   => []
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | PLACEHOLDERS
    |--------------------------------------------------------------------------
    */

    $placeholders = implode(
        ',',
        array_fill(
            0,
            count($packageIds),
            '?'
        )
    );


    /*
    |--------------------------------------------------------------------------
    | SAVED STATUS
    |--------------------------------------------------------------------------
    */

    if (!empty($userId)) {

        $isSavedSQL = "
            CASE
                WHEN EXISTS (
                    SELECT 1
                    FROM wishlist w
                    WHERE w.package_id = p.id
                      AND w.user_id = ?
                      AND w.status = 1
                      AND w.deleted_date IS NULL
                )
                THEN 1
                ELSE 0
            END AS is_saved
        ";

    } else {

        $isSavedSQL = "0 AS is_saved";
    }


    /*
    |--------------------------------------------------------------------------
    | GET PACKAGES
    |--------------------------------------------------------------------------
    */

    $sql = "

        SELECT

            p.id,

            p.name AS package_name,

            pp.image AS cover_image,

            t.total_package_price_per_adult AS final_price,

            t.guest_amount,

            t.guest_percentage,

            $isSavedSQL


        FROM package p


        /*
        |--------------------------------------------------------------------------
        | COVER IMAGE
        |--------------------------------------------------------------------------
        */

        LEFT JOIN package_pictures pp
            ON pp.id = (

                SELECT pp2.id

                FROM package_pictures pp2

                WHERE pp2.package_id = p.id

                ORDER BY
                    CASE
                        WHEN pp2.type = 'cover_image' THEN 1
                        ELSE 2
                    END,
                    pp2.id ASC

                LIMIT 1

            )


        /*
        |--------------------------------------------------------------------------
        | PRICING
        |--------------------------------------------------------------------------
        */

        LEFT JOIN package_pricing t

            ON t.package_id = p.id


        /*
        |--------------------------------------------------------------------------
        | PACKAGE FILTER
        |--------------------------------------------------------------------------
        */

        WHERE p.id IN ($placeholders)

          AND p.status = '1'


        /*
        |--------------------------------------------------------------------------
        | KEEP LOCAL STORAGE ORDER
        |--------------------------------------------------------------------------
        */

        ORDER BY FIELD(
            p.id,
            $placeholders
        )

    ";


    /*
    |--------------------------------------------------------------------------
    | PARAMETERS
    |--------------------------------------------------------------------------
    */

    if (!empty($userId)) {

        $params = array_merge(
            [$userId],
            $packageIds,
            $packageIds
        );

    } else {

        $params = array_merge(
            $packageIds,
            $packageIds
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EXECUTE
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare($sql);

    $stmt->execute($params);


    $packages =
        $stmt->fetchAll(PDO::FETCH_ASSOC);


    /*
    |--------------------------------------------------------------------------
    | CALCULATE DISPLAY PRICE
    |--------------------------------------------------------------------------
    */

    foreach ($packages as &$package) {

        $finalPrice =
            (float) (
                $package['final_price'] ?? 0
            );


        $guestAmount =
            (float) (
                $package['guest_amount'] ?? 0
            );


        $guestPercentage =
            (float) (
                $package['guest_percentage'] ?? 0
            );


        /*
        |--------------------------------------------------------------------------
        | DISPLAY PRICE
        |--------------------------------------------------------------------------
        */

        if ($guestAmount > 0) {

            $displayPrice =
                $finalPrice - $guestAmount;

        } elseif ($guestPercentage > 0) {

            $displayPrice =
                $finalPrice -
                (
                    $finalPrice *
                    $guestPercentage /
                    100
                );

        } else {

            $displayPrice =
                $finalPrice;
        }


        /*
        |--------------------------------------------------------------------------
        | PREVENT NEGATIVE
        |--------------------------------------------------------------------------
        */

        $displayPrice =
            max(
                0,
                $displayPrice
            );


        /*
        |--------------------------------------------------------------------------
        | RESPONSE VALUES
        |--------------------------------------------------------------------------
        */

        $package['net_price_adult'] =
            round(
                $displayPrice,
                2
            );


        $package['original_price'] =
            round(
                $finalPrice,
                2
            );


        $package['has_guest_adjustment'] =
            (
                $guestAmount > 0 ||
                $guestPercentage > 0
            );


        $package['is_saved'] =
            (int) (
                $package['is_saved'] ?? 0
            );


        /*
        |--------------------------------------------------------------------------
        | IMAGE
        |--------------------------------------------------------------------------
        */

        if (!empty($package['cover_image'])) {

            $package['cover_image'] =
                ltrim(
                    $package['cover_image'],
                    '/'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | REMOVE INTERNAL FIELDS
        |--------------------------------------------------------------------------
        */

        unset(
            $package['final_price'],
            $package['guest_amount'],
            $package['guest_percentage']
        );
    }

    unset($package);


    /*
    |--------------------------------------------------------------------------
    | RESPONSE
    |--------------------------------------------------------------------------
    */

    echo json_encode([
        'status' => true,
        'data'   => $packages
    ]);


} catch (Throwable $e) {

    echo json_encode([
        'status'  => false,
        'message' => $e->getMessage()
    ]);
}