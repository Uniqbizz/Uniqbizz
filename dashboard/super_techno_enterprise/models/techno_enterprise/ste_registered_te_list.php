<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $startDate = $_POST['start_date'] ?? '';
        $endDate   = $_POST['end_date'] ?? '';

        $whereDate = '';

        $params = [
            ':user_id' => $userId
        ];

        if (!empty($startDate) && !empty($endDate)) {

            $whereDate = "
                AND ca.register_date >= :start_date
                AND ca.register_date < DATE_ADD(:end_date, INTERVAL 1 DAY)
            ";

            $params[':start_date'] = $startDate;
            $params[':end_date']   = $endDate;
        }

        $sql = "
            SELECT
                ca.corporate_agency_id,
                ca.firstname,
                ca.lastname,
                ca.contact_no,
                ca.email,
                ca.register_date,
                ca.status,
                ca.amount,

                ste.firstname AS ref_firstname,
                ste.lastname AS ref_lastname,
                ste.super_techno_enterprise_id

            FROM corporate_agency ca

            LEFT JOIN super_techno_enterprise ste
                ON ca.reference_no = ste.super_techno_enterprise_id

            WHERE ca.reference_no = :user_id
            AND ca.status IN (1,3)

            $whereDate

            ORDER BY ca.id DESC
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