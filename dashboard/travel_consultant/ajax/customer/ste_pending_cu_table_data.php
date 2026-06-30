<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $sql = $conn->prepare("
            SELECT *
            FROM (

                SELECT
                    cu.id,
                    cu.ca_customer_id,
                    cu.firstname,
                    cu.lastname,
                    cu.contact_no,
                    cu.email,
                    cu.added_on,
                    cu.status,

                    ta.ca_travelagency_id,
                    ta.firstname AS ref_firstname,
                    ta.lastname AS ref_lastname

                FROM ca_customer cu

                INNER JOIN ca_travelagency ta
                    ON cu.ta_reference_no = ta.ca_travelagency_id

                WHERE cu.ta_reference_no = :user_id
                AND cu.status IN(2,0)

            ) x

            ORDER BY x.id DESC
        ");

        $sql->execute([
            ':user_id' => $userId
        ]);

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status'  => true,
            'message' => 'CU data fetched successfully',
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