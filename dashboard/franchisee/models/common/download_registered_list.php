<?php

    require_once(__DIR__ . '/../../../../vendor/autoload.php');
    include_once(__DIR__ . '/../../../dashboard_user_details.php');

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    try {

        $type = $_GET['type'] ?? '';

        $startDate = $_GET['start_date'] ?? '';
        $endDate   = $_GET['end_date'] ?? '';

        $whereDate = '';
        $params = [
            ':user_id' => $userId
        ];
        $alias = '';

        switch ($type) {

            case 'tc':
                $alias = 'ta';
                break;

            case 'cu':
                $alias = 'cu';
                break;
        }

        if (!empty($startDate) && !empty($endDate)) {

            $whereDate = "
                AND {$alias}.register_date >= :start_date
                AND {$alias}.register_date < DATE_ADD(:end_date, INTERVAL 1 DAY)
            ";

            $params[':start_date'] = $startDate;
            $params[':end_date']   = $endDate;
        }

        /*
        |--------------------------------------------------------------------------
        | TRAVEL CONSULTANT
        |--------------------------------------------------------------------------
        */

        if ($type == 'tc') {

            $sql = "
                SELECT *
                FROM (

                    SELECT
                        ta.id AS row_id,
                        ta.ca_travelagency_id AS id,
                        CONCAT(ta.firstname,' ',ta.lastname) AS full_name,

                        CONCAT(ca.firstname,' ',ca.lastname) AS reference_name,
                        ca.sub_franchisee_id AS reference_id,

                        ta.contact_no,
                        ta.email,
                        ta.register_date,
                        ta.amount,

                        CASE
                            WHEN ta.status = 1 THEN 'Active'
                            WHEN ta.status = 3 THEN 'Inactive'
                            ELSE 'Rejected'
                        END AS status

                    FROM ca_travelagency ta

                    INNER JOIN sub_franchisee ca
                        ON ta.reference_no = ca.sub_franchisee_id

                    WHERE ta.reference_no = :user_id
                    AND ta.status IN (1,3)

                    $whereDate
                ) x

                ORDER BY x.row_id DESC
            ";

            $fileName = 'Registered_TC_List.xlsx';
        }

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER
        |--------------------------------------------------------------------------
        */

        elseif ($type == 'cu') {

            $sql = "
                SELECT *
                FROM (

                    SELECT
                        cu.id AS row_id,
                        cu.ca_customer_id AS id,

                        CONCAT(cu.firstname,' ',cu.lastname) AS full_name,

                        CONCAT(ta.firstname,' ',ta.lastname) AS reference_name,
                        ta.ca_travelagency_id AS reference_id,

                        cu.contact_no,
                        cu.email,
                        cu.register_date,
                        cu.paid_amount AS amount,

                        CASE
                            WHEN cu.status = 1 THEN 'Active'
                            WHEN cu.status = 3 THEN 'Inactive'
                            ELSE 'Rejected'
                        END AS status

                    FROM ca_customer cu

                    INNER JOIN ca_travelagency ta
                        ON cu.ta_reference_no = ta.ca_travelagency_id

                    INNER JOIN sub_franchisee ca
                        ON ta.reference_no = ca.sub_franchisee_id

                    WHERE ta.reference_no = :user_id
                    AND cu.status IN (1,3)

                    $whereDate

                ) x

                ORDER BY x.row_id DESC
            ";

            $fileName = 'Registered_Customer_List.xlsx';
        }

        $stmt = $conn->prepare($sql);
        // print_r($stmt);
        $stmt->execute($params);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'ID',
            'Full Name',
            'Reference Name',
            'Reference ID',
            'Contact No',
            'Email',
            'Joining Date',
            'Amount',
            'Status'
        ];

        $col = 'A';

        foreach ($headers as $header) {

            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        $row = 2;

        foreach ($data as $item) {

            $sheet->setCellValue('A'.$row, $item['id']);
            $sheet->setCellValue('B'.$row, $item['full_name']);
            $sheet->setCellValue('C'.$row, $item['reference_name']);
            $sheet->setCellValue('D'.$row, $item['reference_id']);
            $sheet->setCellValue('E'.$row, $item['contact_no']);
            $sheet->setCellValue('F'.$row, $item['email']);
            $sheet->setCellValue('G'.$row, $item['register_date']);
            $sheet->setCellValue('H'.$row, $item['amount']);
            $sheet->setCellValue('I'.$row, $item['status']);

            $row++;
        }

        foreach (range('A', 'I') as $column) {

            $sheet->getColumnDimension($column)
                ->setAutoSize(true);
        }

        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        header(
            'Content-Disposition: attachment; filename="'.$fileName.'"'
        );

        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;

    } catch (Exception $e) {

        die($e->getMessage());
    }
?>