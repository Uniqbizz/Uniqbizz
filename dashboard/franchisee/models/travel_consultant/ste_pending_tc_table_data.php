<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $sql = $conn->prepare("
            SELECT *
            FROM (

                SELECT
                    ta.id,
                    ta.ca_travelagency_id,
                    ta.firstname,
                    ta.lastname,
                    ta.contact_no,
                    ta.email,
                    ta.added_on,
                    ta.status,

                    ca.sub_franchisee_id AS reference_id,
                    ca.firstname AS ref_firstname,
                    ca.lastname AS ref_lastname

                FROM ca_travelagency ta

                INNER JOIN sub_franchisee ca
                    ON ta.reference_no = ca.sub_franchisee_id

                WHERE ta.reference_no = :user_id
                AND ta.status IN (0,4)

            ) AS combined

            ORDER BY id DESC
        ");

        $sql->execute([
            ':user_id' => $userId
        ]);

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status'  => true,
            'message' => 'TC data fetched successfully',
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