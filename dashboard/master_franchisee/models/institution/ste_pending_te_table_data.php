<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $sql = $conn->prepare("
        
            SELECT
                i.id,
                i.name AS firstname,
                '' AS lastname,
                i.contact_no,
                i.email,
                i.added_on,
                i.status,
                i.user_type,
                'I' AS userTypeStr,

                bm.firstname AS ref_firstname,
                bm.lastname AS ref_lastname,
                bm.master_franchisee_id AS ref_id,

                'institution' AS source_table

            FROM institution i

            INNER JOIN master_franchisee bm
                ON i.reference_no = bm.master_franchisee_id

            WHERE bm.master_franchisee_id= :user_id
            AND i.status IN (0,2,4)
            AND bm.status = 1

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