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
                bm.executive_techno_enterprise_id AS ref_id,

                'institution' AS source_table

            FROM institution i

            INNER JOIN executive_techno_enterprise bm
                ON i.reference_no = bm.executive_techno_enterprise_id

            INNER JOIN chief_techno_enterprise e
                ON bm.reference_no = e.chief_techno_enterprise_id

            WHERE e.chief_techno_enterprise_id = :user_id
            AND i.status IN (0,2,4)
            AND bm.status = 1
            AND e.status = 1

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