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

            $whereDateTE = "
                AND ta.register_date >= :start_date
                AND ta.register_date < DATE_ADD(:end_date, INTERVAL 1 DAY)
            ";
            $whereDateSF = "
                AND ta.register_date >= :start_date
                AND ta.register_date < DATE_ADD(:end_date, INTERVAL 1 DAY)
            ";
            $whereDateI = "
                AND ta.register_date >= :start_date
                AND ta.register_date < DATE_ADD(:end_date, INTERVAL 1 DAY)
            ";

            $params[':start_date'] = $startDate;
            $params[':end_date']   = $endDate;
        }

        $sql = "
            SELECT *
            FROM (

                SELECT
                    ta.id,
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
                    ca.corporate_agency_id AS reference_id,

                    'TE' AS ref_type

                FROM ca_travelagency ta

                INNER JOIN corporate_agency ca
                    ON ta.reference_no = ca.corporate_agency_id

                INNER JOIN super_techno_enterprise ste
                    ON ca.reference_no = ste.super_techno_enterprise_id

                WHERE ste.reference_no = :user_id
                AND ta.status IN (1,3)
                AND ste.status IN (1)

                $whereDateTE

                UNION ALL

                SELECT
                    ta.id,
                    ta.institution_branch_manager_id,
                    ta.firstname,
                    ta.lastname,
                    ta.contact_no,
                    ta.email,
                    ta.register_date,
                    ta.status,
                    ta.amount,

                    sf.firstname AS ref_firstname,
                    sf.lastname AS ref_lastname,
                    sf.institution_id AS reference_id,

                    'F' AS ref_type

                FROM institution_branch_manager ta

                INNER JOIN institution sf
                    ON ta.reference_no = sf.institution_id

                WHERE sf.reference_no = :user_id
                AND ta.status IN (1,3)

                $whereDateSF

            ) x

            ORDER BY x.id DESC
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