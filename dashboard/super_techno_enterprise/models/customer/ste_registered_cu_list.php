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
                AND cu.register_date >= :start_date
                AND cu.register_date < DATE_ADD(:end_date, INTERVAL 1 DAY)
            ";

            $params[':start_date'] = $startDate;
            $params[':end_date']   = $endDate;
        }

        $sql = "
            SELECT *
            FROM (

                SELECT
                    cu.id,
                    cu.ca_customer_id,
                    cu.firstname,
                    cu.lastname,
                    cu.contact_no,
                    cu.email,
                    cu.register_date,
                    cu.status,
                    cu.paid_amount,

                    ta.ca_travelagency_id,
                    ta.firstname AS ref_firstname,
                    ta.lastname AS ref_lastname,

                    'TE' AS ref_type

                FROM ca_customer cu

                INNER JOIN ca_travelagency ta
                    ON cu.ta_reference_no = ta.ca_travelagency_id

                INNER JOIN corporate_agency ca
                    ON ta.reference_no = ca.corporate_agency_id

                WHERE ca.reference_no = :user_id
                AND cu.status IN (1,3)

                $whereDate

            ) x

            ORDER BY x.id DESC
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status'  => true,
            'message' => 'Customer data fetched successfully',
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

    // UNION ALL

    //             SELECT
    //                 cu.id,
    //                 cu.ca_customer_id,
    //                 cu.firstname,
    //                 cu.lastname,
    //                 cu.contact_no,
    //                 cu.email,
    //                 cu.register_date,
    //                 cu.status,
    //                 cu.paid_amount AS amount,

    //                 ta.ca_travelagency_id,
    //                 ta.firstname AS ref_firstname,
    //                 ta.lastname AS ref_lastname,

    //                 'F' AS ref_type

    //             FROM ca_customer cu

    //             INNER JOIN ca_travelagency ta
    //                 ON cu.ta_reference_no = ta.ca_travelagency_id

    //             INNER JOIN sub_franchisee sf
    //                 ON ta.reference_no = sf.sub_franchisee_id

    //             WHERE sf.reference_no = :user_id
    //             AND cu.status IN (1,3)

    //             $whereDate

?>