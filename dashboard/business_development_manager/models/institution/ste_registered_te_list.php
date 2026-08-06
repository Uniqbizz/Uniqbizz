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

            $whereDateSF = "
                AND sf.register_date >= :start_date
                AND sf.register_date < DATE_ADD(:end_date, INTERVAL 1 DAY)
            ";

            $params[':start_date'] = $startDate;
            $params[':end_date']   = $endDate;
        }

        $sql = "

            (
                SELECT
                    sf.institution_id AS teuser_id,
                    sf.name AS firstname,
                    '' AS lastname,
                    sf.contact_no,
                    sf.email,
                    sf.register_date,
                    sf.status,
                    sf.amount,
                    sf.user_type,

                    emp.name AS ref_firstname,
                    '' AS ref_lastname,
                    emp.employee_id AS reference_id

                FROM institution sf

                INNER JOIN employees emp
                    ON sf.reference_no = emp.employee_id

                WHERE sf.reference_no = :user_id
                AND sf.status IN (1,3)

                $whereDateSF
            )

            UNION ALL

            (
                SELECT
                    sf.institution_id AS teuser_id,
                    sf.name AS firstname,
                    '' AS lastname,
                    sf.contact_no,
                    sf.email,
                    sf.register_date,
                    sf.status,
                    sf.amount,
                    sf.user_type,

                    bm.firstname AS ref_firstname,
                    bm.lastname AS ref_lastname,
                    bm.business_mentor_id AS reference_id

                FROM institution sf

                INNER JOIN business_mentor bm
                    ON sf.reference_no = bm.business_mentor_id

                WHERE bm.reference_no = :user_id
                AND sf.status IN (1,3)
                AND bm.status IN (1,3)

                $whereDateSF
            )

            ORDER BY register_date DESC;
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