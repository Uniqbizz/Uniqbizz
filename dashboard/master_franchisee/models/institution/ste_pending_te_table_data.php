<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $sql = $conn->prepare("
        
            SELECT
                ca.id,
                ca.firstname,
                ca.lastname,
                ca.contact_no,
                ca.email,
                ca.added_on,
                ca.status,
                ca.user_type,
                'I' AS userTypeStr,

                ste.firstname AS ref_firstname,
                ste.lastname AS ref_lastname,
                ste.master_franchisee_id,

                'institution' AS source_table

            FROM institution ca

            INNER JOIN master_franchisee ste
                ON ca.reference_no = ste.master_franchisee_id

            WHERE ca.reference_no = :user_id
            AND ca.status IN (0,2,4)
            ORDER BY id DESC;
        ");

        $sql->execute([
            ':user_id' => $userId
        ]);

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => true,
            'message' => 'Data fetched successfully',
            'data' => $data
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'status' => false,
            'message' => $e->getMessage(),
            'data' => []
        ]);
    }

    exit;
?>