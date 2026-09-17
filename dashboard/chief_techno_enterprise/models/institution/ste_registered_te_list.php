<?php
    include_once(__DIR__.'/../../../dashboard_user_details.php');
    header('Content-Type: application/json');
    try {

        $startDate = $_POST['start_date'] ?? '';
        $endDate   = $_POST['end_date'] ?? '';
        $whereDateI = '';
        $params = [
            ':user_id' => $userId
        ];
        if (!empty($startDate) && !empty($endDate)) {
            $whereDateI = "
                AND i.register_date >= :start_date
                AND i.register_date < DATE_ADD(:end_date, INTERVAL 1 DAY)
            ";
            $params[':start_date'] = $startDate;
            $params[':end_date']   = $endDate;
        }
        $sql = "
            (
                SELECT
                    i.institution_id AS teuser_id,
                    i.name AS firstname,
                    '' AS lastname,
                    i.contact_no,
                    i.email,
                    i.register_date,
                    i.status,
                    i.amount,
                    i.user_type,
                    ste.firstname AS ref_firstname,
                    ste.lastname AS ref_lastname,
                    ste.executive_techno_enterprise_id AS reference_id
                FROM institution i
                INNER JOIN executive_techno_enterprise ste
                    ON i.reference_no = ste.executive_techno_enterprise_id
                WHERE ste.reference_no = :user_id
                AND i.status IN (1,3)
                AND ste.status IN (1,3)
                $whereDateI
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