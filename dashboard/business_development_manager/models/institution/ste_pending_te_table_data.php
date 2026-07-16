<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $sql = $conn->prepare("
        
            SELECT
                i.id,
                i.firstname,
                i.lastname,
                i.contact_no,
                i.email,
                i.added_on,
                i.status,
                i.user_type,
                'I' AS userTypeStr,

                e.name AS ref_firstname,
                '' AS ref_lastname,
                e.employee_id AS ref_id,

                'institution' AS source_table

            FROM institution i

            INNER JOIN employees e
                ON i.reference_no = e.employee_id

            WHERE i.reference_no = :user_id
            AND i.status IN (0,2,4)
            AND e.status = 1

            UNION ALL

            SELECT
                i.id,
                i.firstname,
                i.lastname,
                i.contact_no,
                i.email,
                i.added_on,
                i.status,
                i.user_type,
                'I' AS userTypeStr,

                bm.firstname AS ref_firstname,
                bm.lastname AS ref_lastname,
                bm.business_mentor_id AS ref_id,

                'institution' AS source_table

            FROM institution i

            INNER JOIN business_mentor bm
                ON i.reference_no = bm.business_mentor_id

            INNER JOIN employees e
                ON bm.reference_no = e.employee_id

            WHERE e.employee_id = :user_id
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