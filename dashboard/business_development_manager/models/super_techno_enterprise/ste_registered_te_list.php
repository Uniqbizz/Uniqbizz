<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $startDate = $_POST['start_date'] ?? '';
        $endDate   = $_POST['end_date'] ?? '';

        $whereDateCA = '';
        $whereDateSF = '';
        $whereDateI = '';

        $params = [
            ':user_id' => $userId
        ];

        if (!empty($startDate) && !empty($endDate)) {

            $whereDateCA = "
                AND ca.register_date >= :start_date
                AND ca.register_date < DATE_ADD(:end_date, INTERVAL 1 DAY)
            ";

            $params[':start_date'] = $startDate;
            $params[':end_date']   = $endDate;
        }

        $sql = "
            SELECT
                ca.super_techno_enterprise_id AS teuser_id,
                ca.firstname,
                ca.lastname,
                ca.contact_no,
                ca.email,
                ca.register_date,
                ca.status,
                ca.user_type,

                ste.firstname AS ref_firstname,
                ste.lastname AS ref_lastname,
                ste.executive_techno_enterprise_id

            FROM super_techno_enterprise ca

            INNER JOIN executive_techno_enterprise ste
                ON ca.reference_no = ste.executive_techno_enterprise_id

            WHERE ca.reference_no = :user_id
            AND ca.status IN (1,3)

            $whereDateCA

            
            ORDER BY register_date DESC
        ";

        $stmt = $conn->prepare($sql);

        $params = [
            ':user_id' => $userId
        ];

        if ($startDate != '' && $endDate != '') {

            $params[':start_date'] = $startDate;
            $params[':end_date'] = $endDate;
        }

        $stmt->execute($params);

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
?>