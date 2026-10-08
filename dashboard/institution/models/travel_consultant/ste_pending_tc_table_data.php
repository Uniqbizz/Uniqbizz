<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    $sql = $conn->prepare("
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
                ta.added_on,
                ta.status,
                DATE_FORMAT(ta.deleted_date, '%d %b %Y') AS deleted_date,

                ca.institution_id AS techno_enterprise_id,
                ca.name AS ref_firstname,
                '' AS ref_lastname,

                11 AS user_type

            FROM ca_travelagency ta

            INNER JOIN institution ca
                ON ta.reference_no = ca.institution_id

            WHERE ta.reference_no = ?
            AND ta.status IN (2, 0, 4)


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
                ta.added_on,
                ta.status,
                DATE_FORMAT(ta.deleted_date, '%d %b %Y') AS deleted_date,

                ca.institution_id AS techno_enterprise_id,
                ca.name AS ref_firstname,
                '' AS ref_lastname,

                33 AS user_type

            FROM institution_branch_manager ta

            INNER JOIN institution ca
                ON ta.reference_no = ca.institution_id

            WHERE ta.reference_no = ?
            AND ta.status IN (2, 0, 4)

        ) AS combined

        ORDER BY id DESC
    ");

    $sql->execute([
        $userId,
        $userId
    ]);

    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status'  => true,
        'message' => 'TC and IBR data fetched successfully',
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