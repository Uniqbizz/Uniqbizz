<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $startDate = $_POST['start_date'] ?? '';
        $endDate   = $_POST['end_date'] ?? '';

        $whereDateCA = '';
        $whereDateSF = '';

        $params = [
            ':user_id' => $userId
        ];

        if (!empty($startDate) && !empty($endDate)) {

            $whereDateCA = "
                AND ca.register_date >= :start_date
                AND ca.register_date < DATE_ADD(:end_date, INTERVAL 1 DAY)
            ";
            // $whereDateSF = "
            //     AND sf.register_date >= :start_date
            //     AND sf.register_date < DATE_ADD(:end_date, INTERVAL 1 DAY)
            // ";

            $params[':start_date'] = $startDate;
            $params[':end_date']   = $endDate;
        }

        $sql = "
            (
                SELECT
                    ca.corporate_agency_id AS teuser_id,
                    ca.firstname,
                    ca.lastname,
                    ca.contact_no,
                    ca.email,
                    ca.register_date,
                    ca.status,
                    ca.amount,
                    ca.user_type,

                    ste.firstname AS ref_firstname,
                    ste.lastname AS ref_lastname,
                    ste.business_mentor_id

                FROM corporate_agency ca

                INNER JOIN business_mentor ste
                    ON ca.reference_no = ste.business_mentor_id

                WHERE ca.reference_no = :user_id
                AND ca.status IN (1,3)

                $whereDateCA
            )
                UNION ALL

            (
                SELECT
                    sf.sub_franchisee_id AS teuser_id,
                    sf.firstname,
                    sf.lastname,
                    sf.contact_no,
                    sf.email,
                    sf.register_date,
                    sf.status,
                    sf.amount,
                    sf.user_type,

                    ste.firstname AS ref_firstname,
                    ste.lastname AS ref_lastname,
                    ste.business_mentor_id

                FROM sub_franchisee sf

                INNER JOIN business_mentor ste
                    ON sf.reference_no = ste.business_mentor_id

                WHERE sf.reference_no = :user_id
                AND sf.status IN (1,3)

                $whereDateSF
            )
                UNION ALL

            (
                SELECT
                    sf.institution_id AS teuser_id,
                    sf.firstname,
                    sf.lastname,
                    sf.contact_no,
                    sf.email,
                    sf.register_date,
                    sf.status,
                    sf.amount,
                    sf.user_type,

                    ste.firstname AS ref_firstname,
                    ste.lastname AS ref_lastname,
                    ste.business_mentor_id

                FROM institution sf

                INNER JOIN business_mentor ste
                    ON sf.reference_no = ste.business_mentor_id

                WHERE sf.reference_no = :user_id
                AND sf.status IN (1,3)

                $whereDateSF
            )

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