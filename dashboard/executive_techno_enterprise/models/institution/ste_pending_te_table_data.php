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
                DATE_FORMAT(i.deleted_date, '%d %b %Y') AS deleted_date,
                e.firstname AS ref_firstname,
                e.lastname AS ref_lastname,
                e.executive_techno_enterprise_id AS ref_id,

                'institution' AS source_table

            FROM institution i

            INNER JOIN executive_techno_enterprise e
                ON i.reference_no = e.executive_techno_enterprise_id

            WHERE e.executive_techno_enterprise_id = :user_id
            AND i.status IN (0,2,4)
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