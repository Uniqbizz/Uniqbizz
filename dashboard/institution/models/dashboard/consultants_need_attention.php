<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    $sql = $conn->prepare("
        SELECT *
        FROM (

            /* Travel Agency / TC */
            SELECT
                ca.ca_travelagency_id AS tc_id,

                CONCAT(
                    COALESCE(ca.firstname, ''),
                    ' ',
                    COALESCE(ca.lastname, '')
                ) AS tc_name,

                MAX(cu.register_date) AS last_customer_date,

                DATEDIFF(
                    CURDATE(),
                    MAX(cu.register_date)
                ) AS inactive_days

            FROM ca_travelagency ca

            LEFT JOIN ca_customer cu
                ON cu.ta_reference_no = ca.ca_travelagency_id
                AND cu.status IN (1, 3)

            WHERE ca.reference_no = ?

            AND ca.status IN (1, 3)

            GROUP BY
                ca.ca_travelagency_id,
                ca.firstname,
                ca.lastname

            HAVING
                MAX(cu.register_date) IS NULL
                OR DATEDIFF(
                    CURDATE(),
                    MAX(cu.register_date)
                ) >= 15


            UNION ALL


            /* Institution Branch Manager / IBR */
            SELECT
                ca.institution_branch_manager_id AS tc_id,

                CONCAT(
                    COALESCE(ca.firstname, ''),
                    ' ',
                    COALESCE(ca.lastname, '')
                ) AS tc_name,

                MAX(cu.register_date) AS last_customer_date,

                DATEDIFF(
                    CURDATE(),
                    MAX(cu.register_date)
                ) AS inactive_days

            FROM institution_branch_manager ca

            LEFT JOIN ca_customer cu
                ON cu.ta_reference_no = ca.institution_branch_manager_id
                AND cu.status IN (1, 3)

            WHERE ca.reference_no = ?

            AND ca.status IN (1, 3)

            GROUP BY
                ca.institution_branch_manager_id,
                ca.firstname,
                ca.lastname

            HAVING
                MAX(cu.register_date) IS NULL
                OR DATEDIFF(
                    CURDATE(),
                    MAX(cu.register_date)
                ) >= 15

        ) AS inactive_users

        ORDER BY inactive_days DESC

        LIMIT 6
    ");

    $sql->execute([
        $userId,
        $userId
    ]);

    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => true,
        'data'   => $data
    ]);

} catch (Exception $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}
?>