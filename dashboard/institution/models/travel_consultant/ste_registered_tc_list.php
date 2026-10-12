<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    $startDate = $_POST['start_date'] ?? '';
    $endDate   = $_POST['end_date'] ?? '';

    /*
    |--------------------------------------------------------------------------
    | Date Filter
    |--------------------------------------------------------------------------
    */

    $whereDate = '';

    $params = [];

    /*
    |--------------------------------------------------------------------------
    | TRAVEL CONSULTANT
    |--------------------------------------------------------------------------
    */

    $params[] = $userId;

    if (!empty($startDate) && !empty($endDate)) {

        $whereDate = "
            AND ta.register_date >= ?
            AND ta.register_date < DATE_ADD(?, INTERVAL 1 DAY)
        ";

        $params[] = $startDate;
        $params[] = $endDate;
    }


    /*
    |--------------------------------------------------------------------------
    | INSTITUTION BRANCH MANAGER
    |--------------------------------------------------------------------------
    */

    $params[] = $userId;

    if (!empty($startDate) && !empty($endDate)) {

        $params[] = $startDate;
        $params[] = $endDate;
    }


    /*
    |--------------------------------------------------------------------------
    | Query
    |--------------------------------------------------------------------------
    */

    $sql = "
        SELECT *
        FROM (

            /* =====================================================
               TRAVEL CONSULTANT
            ===================================================== */

            SELECT
                ta.id,
                ta.ca_travelagency_id AS user_reference_id,

                ta.firstname,
                ta.lastname,

                ta.contact_no,
                ta.email,

                ta.register_date,
                ta.status,
                ta.amount,

                DATE_FORMAT(
                    ta.deleted_date,
                    '%d %b %Y'
                ) AS deleted_date,

                ca.name AS ref_firstname,
                '' AS ref_lastname,

                ca.institution_id AS reference_id,

                'I' AS ref_type,

                11 AS user_type

            FROM ca_travelagency ta

            INNER JOIN institution ca
                ON ta.reference_no = ca.institution_id

            WHERE ta.reference_no = ?
            AND ta.status IN (1, 3)

            $whereDate


            UNION ALL


            /* =====================================================
               INSTITUTION BRANCH MANAGER
            ===================================================== */

            SELECT
                ta.id,
                ta.institution_branch_manager_id AS user_reference_id,

                ta.firstname,
                ta.lastname,

                ta.contact_no,
                ta.email,

                ta.register_date,
                ta.status,
                ta.amount,

                DATE_FORMAT(
                    ta.deleted_date,
                    '%d %b %Y'
                ) AS deleted_date,

                ca.name AS ref_firstname,
                '' AS ref_lastname,

                ca.institution_id AS reference_id,

                'I' AS ref_type,

                33 AS user_type

            FROM institution_branch_manager ta

            INNER JOIN institution ca
                ON ta.reference_no = ca.institution_id

            WHERE ta.reference_no = ?
            AND ta.status IN (1, 3)

            $whereDate

        ) x

        ORDER BY x.id DESC
    ";


    /*
    |--------------------------------------------------------------------------
    | Execute
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare($sql);

    $stmt->execute($params);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */
    echo json_encode([
        'status'  => true,
        'message' => 'Data fetched successfully',
        'data'    => $data
    ]);

} catch (Exception $e) {

    echo json_encode([
        'status'  => false,
        'message' => $e->getMessage(),
        'data'    => []
    ]);
}

exit;

?>