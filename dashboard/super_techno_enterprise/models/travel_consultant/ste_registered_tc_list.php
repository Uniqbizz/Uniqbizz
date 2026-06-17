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
                AND ta.register_date >= :start_date
                AND ta.register_date < DATE_ADD(:end_date, INTERVAL 1 DAY)
            ";

            $params[':start_date'] = $startDate;
            $params[':end_date']   = $endDate;
        }

        $sql = "
            SELECT
                ta.ca_travelagency_id,
                ta.firstname,
                ta.lastname,
                ta.contact_no,
                ta.email,
                ta.register_date,
                ta.status,
                ta.amount,

                ca.firstname AS ref_firstname,
                ca.lastname AS ref_lastname,
                ca.corporate_agency_id

            FROM ca_travelagency ta

            LEFT JOIN corporate_agency ca
                ON ta.reference_no = ca.corporate_agency_id

            WHERE ca.reference_no = :user_id
            AND ta.status IN (1,3)

            $whereDate

            ORDER BY ta.id DESC
        ";

        $stmt = $conn->prepare($sql);

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

    exit;
?>