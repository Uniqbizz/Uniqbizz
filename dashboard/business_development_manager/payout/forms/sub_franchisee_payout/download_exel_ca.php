<?php
require '../../../../connect.php';
require '../../../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$payoutYear = $_GET['payoutYear'];
$payoutMonth = $_GET['payoutMonth'];
$payoutmessage = $_GET['payoutmessage'];
$designation = 'zonal_manager';
$user_id = $_GET['user_id'] ?? '';
$user_id_str=substr($user_id,0,1) == 'F'?substr($user_id,0,1):substr($user_id,0,2);

$dateObj   = DateTime::createFromFormat('!m', $payoutMonth);
$monthName = $dateObj->format('F'); 

if($payoutmessage == 'PreviousPayout'){
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $rowNo = 1;
    $stmt2 = "SELECT * FROM sub_franchisee_payout WHERE $designation = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
        $sheet->mergeCells('A1:H1');

        $sheet->setCellValue(
            'A1',
            'Previous Payout List as of '.$monthName.', '.$payoutYear
        );

        $rowNo = 3;
        $headers = [
            'Date',
            'Reference ID',
            'Reference Name',
            'Payout Details',
            'Amount',
            'TDS',
            'Total Payable',
            'Status'
        ];

        $col = 'A';

        foreach ($headers as $header) {

            $sheet->setCellValue($col.$rowNo, $header);

            $col++;
        }

        $rowNo++;
        foreach($stmt2->fetchAll() as $key => $row2){
            $rd= new DateTime($row2['created_date']);
            $newDate= $rd->format('d-m-Y');
            $id = $row2['id'];

            if($user_id_str == "SF" || $user_id_str == "MF" || $user_id_str == "BH"){

                $BC_Commi = $row2['commision_zm'];
            
                (int)$BC_Commi_TDS = (int)$BC_Commi*2/100;
                (int)$BC_Commi_Total = (int)$BC_Commi-(int)$BC_Commi_TDS; 

                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message_zm'];
                $message1 =  str_replace('.','<br>',$message1); 
                if($user_id_str == "BH"){
                    $sql1= $conn->prepare("SELECT firstname,lastname FROM `employees` where employee_id='".$row2['zonal_manager']."'");
                }
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach (($sql1->fetchAll()) as $key => $row1) {
                        $ta_name = $row1['name'];
                    }
                } 
                $sheet->setCellValue('A'.$rowNo, $newDate);
                $sheet->setCellValue('B'.$rowNo, $row2['zonal_manager']);
                $sheet->setCellValue('C'.$rowNo, $ta_name);
                $sheet->setCellValue('D'.$rowNo, strip_tags($message1));
                $sheet->setCellValue('E'.$rowNo, $BC_Commi);
                $sheet->setCellValue('F'.$rowNo, $BC_Commi_TDS);
                $sheet->setCellValue('G'.$rowNo, $BC_Commi_Total);
                $sheet->setCellValue(
                    'H'.$rowNo,
                    ($row2['status_zm'] == 2 ? 'Pending' : 'Paid')
                );

                $rowNo++;
                // $output .= '<tr>
                //     <td >'.$newDate.'</td>
                //     <td>'.$row2['zonal_manager'].'</td>
                //     <td>'.$ta_name.'</td>
                //     <td class="message">'.$message1.'</td>
                //     <td style="text-align:center;">'.$BC_Commi.'</td>
                //     <td style="text-align:center;">'.$BC_Commi_TDS.'/-</td>
                //     <td style="text-align:center;">'.$BC_Commi_Total.'/-</td>';
                //     if($row2['status_zm'] == 2){
                //         $output .='<td style="text-align:center;">Pending</td>';
                //     }else{
                //         $output .='<td style="text-align:center;">Paid</td>';
                //     }
                // $output .='</tr>';
            }
            
        
        }
        foreach (range('A', 'H') as $column) {

            $sheet
                ->getColumnDimension($column)
                ->setAutoSize(true);
        }
        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        header(
            'Content-Disposition: attachment; filename="Previous_Payout_List.xlsx"'
        );

        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;
    }else{
        echo '<script>
                alert("No Payout Data");
                window.history.back();
            </script>';
        exit;
    }
} 

if($payoutmessage == 'NextPayout'){

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $rowNo = 1;

    $stmt2 = "
        SELECT *
        FROM sub_franchisee_payout
        WHERE $designation = :user_id
        AND YEAR(created_date) = :year
        AND MONTH(created_date) = :month
    ";

    $stmt2 = $conn->prepare($stmt2);

    $stmt2->execute([
        ':user_id' => $user_id,
        ':year'    => $payoutYear,
        ':month'   => $payoutMonth
    ]);

    $stmt2->setFetchMode(PDO::FETCH_ASSOC);

    if($stmt2->rowCount() > 0){

        $sheet->mergeCells('A1:H1');

        $sheet->setCellValue(
            'A1',
            'Next Payout List as of '.$monthName.', '.$payoutYear
        );

        $sheet->getStyle('A1')
            ->getFont()
            ->setBold(true)
            ->setSize(14);

        $rowNo = 3;

        $headers = [
            'Date',
            'Reference ID',
            'Reference Name',
            'Payout Details',
            'Amount',
            'TDS',
            'Total Payable',
            'Status'
        ];

        $col = 'A';

        foreach ($headers as $header) {

            $sheet->setCellValue($col.$rowNo, $header);

            $col++;
        }

        $sheet->getStyle('A3:H3')
            ->getFont()
            ->setBold(true);

        $rowNo++;

        foreach($stmt2->fetchAll() as $row2){

            $newDate = date(
                'd-m-Y',
                strtotime($row2['created_date'])
            );

            if(
                $user_id_str == "SF" ||
                $user_id_str == "MF" ||
                $user_id_str == "BH"
            ){

                $BC_Commi = $row2['commision_zm'];

                $BC_Commi_TDS =
                    $BC_Commi * 2 / 100;

                $BC_Commi_Total =
                    $BC_Commi - $BC_Commi_TDS;

                $message1 =
                    str_replace(
                        '.',
                        PHP_EOL,
                        $row2['message_zm']
                    );

                $ta_name = '';

                if($user_id_str == "SF"){

                    $sql1 = $conn->prepare("
                        SELECT firstname, lastname
                        FROM sponsor_franchisee
                        WHERE sponsor_franchisee_id = ?
                    ");

                }elseif($user_id_str == "MF"){

                    $sql1 = $conn->prepare("
                        SELECT firstname, lastname
                        FROM zonal_manager
                        WHERE zonal_manager_id = ?
                    ");

                }else{

                    $sql1 = $conn->prepare("
                        SELECT name
                        FROM employee
                        WHERE employee_id = ?
                    ");

                }

                $sql1->execute([
                    $row2['zonal_manager']
                ]);

                if($row1 = $sql1->fetch(PDO::FETCH_ASSOC)){

                    $ta_name =
                        $row1['name'];
                }

                $sheet->setCellValue(
                    'A'.$rowNo,
                    $newDate
                );

                $sheet->setCellValue(
                    'B'.$rowNo,
                    $row2['zonal_manager']
                );

                $sheet->setCellValue(
                    'C'.$rowNo,
                    $ta_name
                );

                $sheet->setCellValue(
                    'D'.$rowNo,
                    $message1
                );

                $sheet->setCellValue(
                    'E'.$rowNo,
                    $BC_Commi
                );

                $sheet->setCellValue(
                    'F'.$rowNo,
                    $BC_Commi_TDS
                );

                $sheet->setCellValue(
                    'G'.$rowNo,
                    $BC_Commi_Total
                );

                $sheet->setCellValue(
                    'H'.$rowNo,
                    ($row2['status_zm'] == 2)
                        ? 'Pending'
                        : 'Paid'
                );

                $sheet->getStyle('D'.$rowNo)
                    ->getAlignment()
                    ->setWrapText(true);

                $rowNo++;
            }
        }

        foreach(range('A','H') as $column){

            $sheet
                ->getColumnDimension($column)
                ->setAutoSize(true);
        }

        if(ob_get_length()){
            ob_end_clean();
        }

        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        header(
            'Content-Disposition: attachment; filename="Next_Payout_List.xlsx"'
        );

        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);

        $writer->save('php://output');

        exit;

    }else{

        echo '<script>
                alert("No Payout Data");
                window.history.back();
              </script>';

        exit;
    }
} 

if($payoutmessage == 'TotalPayout'){

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $rowNo = 1;

    $stmt2 = "
        SELECT *
        FROM sub_franchisee_payout
        WHERE $designation = :user_id
        AND YEAR(created_date) = :year
        AND MONTH(created_date) = :month
    ";

    $stmt2 = $conn->prepare($stmt2);

    $stmt2->execute([
        ':user_id' => $user_id,
        ':year'    => $payoutYear,
        ':month'   => $payoutMonth
    ]);

    $stmt2->setFetchMode(PDO::FETCH_ASSOC);

    if($stmt2->rowCount() > 0){

        $sheet->mergeCells('A1:H1');

        $sheet->setCellValue(
            'A1',
            'Total Payout List as of '.$monthName.', '.$payoutYear
        );

        $sheet->getStyle('A1')
            ->getFont()
            ->setBold(true)
            ->setSize(14);

        $rowNo = 3;

        $headers = [
            'Date',
            'Reference ID',
            'Reference Name',
            'Payout Details',
            'Amount',
            'TDS',
            'Total Payable',
            'Status'
        ];

        $col = 'A';

        foreach ($headers as $header) {

            $sheet->setCellValue($col.$rowNo, $header);

            $col++;
        }

        $sheet->getStyle('A3:H3')
            ->getFont()
            ->setBold(true);

        $rowNo++;

        foreach($stmt2->fetchAll() as $row2){

            $newDate = date(
                'd-m-Y',
                strtotime($row2['created_date'])
            );

            if(
                $user_id_str == "SF" ||
                $user_id_str == "MF" ||
                $user_id_str == "BH"
            ){

                $BC_Commi = $row2['commision_zm'];

                $BC_Commi_TDS =
                    $BC_Commi * 2 / 100;

                $BC_Commi_Total =
                    $BC_Commi - $BC_Commi_TDS;

                $message1 = str_replace(
                    '.',
                    PHP_EOL,
                    $row2['message_zm']
                );

                $ta_name = '';

                if($user_id_str == "SF"){

                    $sql1 = $conn->prepare("
                        SELECT firstname, lastname
                        FROM sponsor_franchisee
                        WHERE sponsor_franchisee_id = ?
                    ");

                }elseif($user_id_str == "MF"){

                    $sql1 = $conn->prepare("
                        SELECT firstname, lastname
                        FROM zonal_manager
                        WHERE zonal_manager_id = ?
                    ");

                }else{

                    $sql1 = $conn->prepare("
                        SELECT name
                        FROM employee
                        WHERE employee_id = ?
                    ");

                }

                $sql1->execute([
                    $row2['zonal_manager']
                ]);

                if($row1 = $sql1->fetch(PDO::FETCH_ASSOC)){

                    $ta_name =
                        $row1['name'];
                }

                $sheet->setCellValue(
                    'A'.$rowNo,
                    $newDate
                );

                $sheet->setCellValue(
                    'B'.$rowNo,
                    $row2['zonal_manager']
                );

                $sheet->setCellValue(
                    'C'.$rowNo,
                    $ta_name
                );

                $sheet->setCellValue(
                    'D'.$rowNo,
                    $message1
                );

                $sheet->setCellValue(
                    'E'.$rowNo,
                    $BC_Commi
                );

                $sheet->setCellValue(
                    'F'.$rowNo,
                    $BC_Commi_TDS
                );

                $sheet->setCellValue(
                    'G'.$rowNo,
                    $BC_Commi_Total
                );

                $sheet->setCellValue(
                    'H'.$rowNo,
                    ($row2['status_zm'] == 2)
                        ? 'Pending'
                        : 'Paid'
                );

                $sheet->getStyle('D'.$rowNo)
                    ->getAlignment()
                    ->setWrapText(true);

                $rowNo++;
            }
        }

        foreach(range('A','H') as $column){

            $sheet->getColumnDimension($column)
                ->setAutoSize(true);
        }

        if(ob_get_length()){
            ob_end_clean();
        }

        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        header(
            'Content-Disposition: attachment; filename="Total_Payout_List.xlsx"'
        );

        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;

    }else{

        echo '<script>
                alert("No Payout Data");
                window.history.back();
              </script>';

        exit;
    }
}

if($payoutmessage == 'allPayout'){

    if(
        $user_id_str == 'SF' ||
        $user_id_str == 'MF' ||
        $user_id_str == 'BH'
    ){

        $stmt2 = "
            SELECT *
            FROM sub_franchisee_payout
            WHERE business_mentor = :user_id
            AND YEAR(created_date) = :year
            AND MONTH(created_date) = :month
        ";
    }

    $stmt2 = $conn->prepare($stmt2);

    $stmt2->execute([
        ':user_id' => $user_id,
        ':year'    => $payoutYear,
        ':month'   => $payoutMonth
    ]);

    $stmt2->setFetchMode(PDO::FETCH_ASSOC);

    if($stmt2->rowCount() > 0){

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:J1');

        $sheet->setCellValue(
            'A1',
            'All Payout List as of '.$monthName.', '.$payoutYear
        );

        $sheet->getStyle('A1')
            ->getFont()
            ->setBold(true)
            ->setSize(14);

        $rowNo = 3;

        $headers = [
            'Date',
            'Ref ID',
            'Ref Name',
            'Franchisee ID',
            'Franchisee Name',
            'Payout Details',
            'Amount',
            'TDS',
            'Total Payable',
            'Status'
        ];

        $col = 'A';

        foreach($headers as $header){

            $sheet->setCellValue(
                $col.$rowNo,
                $header
            );

            $col++;
        }

        $sheet->getStyle('A3:J3')
            ->getFont()
            ->setBold(true);

        $rowNo++;

        foreach($stmt2->fetchAll() as $row2){

            $newDate = date(
                'd-m-Y',
                strtotime($row2['created_date'])
            );

            $BC_Commi = $row2['commision_zm'];

            $BC_Commi_TDS =
                $BC_Commi * 2 / 100;

            $BC_Commi_Total =
                $BC_Commi - $BC_Commi_TDS;

            $message1 = str_replace(
                '.',
                PHP_EOL,
                $row2['message_zm']
            );

            $ta_name = '';
            $ca_name = '';

            if($user_id_str == "SF"){

                $sql1 = $conn->prepare("
                    SELECT firstname, lastname
                    FROM sponsor_franchisee
                    WHERE sponsor_franchisee_id = ?
                ");

            }elseif($user_id_str == "MF"){

                $sql1 = $conn->prepare("
                    SELECT firstname, lastname
                    FROM zonal_manager
                    WHERE zonal_manager_id = ?
                ");

            }elseif($user_id_str == "BH"){

                $sql1 = $conn->prepare("
                    SELECT name
                    FROM employee
                    WHERE employee_id = ?
                ");

            }

            $sql1->execute([
                $row2['zonal_manager']
            ]);

            if($row1 = $sql1->fetch(PDO::FETCH_ASSOC)){

                $ta_name =
                    $row1['name'];
            }

            if(!empty($row2['sub_franchisee'])){

                $sql2 = $conn->prepare("
                    SELECT firstname, lastname
                    FROM sub_franchisee
                    WHERE sub_franchisee_id = ?
                ");

                $sql2->execute([
                    $row2['sub_franchisee']
                ]);

                if($row3 = $sql2->fetch(PDO::FETCH_ASSOC)){

                    $ca_name =
                        $row3['firstname'].' '.
                        $row3['lastname'];
                }
            }

            $sheet->setCellValue(
                'A'.$rowNo,
                $newDate
            );

            $sheet->setCellValue(
                'B'.$rowNo,
                $row2['zonal_manager']
            );

            $sheet->setCellValue(
                'C'.$rowNo,
                $ta_name
            );

            $sheet->setCellValue(
                'D'.$rowNo,
                $row2['sub_franchisee']
            );

            $sheet->setCellValue(
                'E'.$rowNo,
                $ca_name
            );

            $sheet->setCellValue(
                'F'.$rowNo,
                $message1
            );

            $sheet->setCellValue(
                'G'.$rowNo,
                $BC_Commi
            );

            $sheet->setCellValue(
                'H'.$rowNo,
                $BC_Commi_TDS
            );

            $sheet->setCellValue(
                'I'.$rowNo,
                $BC_Commi_Total
            );

            $sheet->setCellValue(
                'J'.$rowNo,
                ($row2['status_zm'] == 2)
                    ? 'Pending'
                    : 'Paid'
            );

            $sheet->getStyle('F'.$rowNo)
                ->getAlignment()
                ->setWrapText(true);

            $rowNo++;
        }

        foreach(range('A','J') as $column){

            $sheet->getColumnDimension($column)
                ->setAutoSize(true);
        }

        if(ob_get_length()){
            ob_end_clean();
        }

        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        header(
            'Content-Disposition: attachment; filename="All_Payout_List.xlsx"'
        );

        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;

    }else{

        echo '<script>
                alert("No Payout Data");
                window.history.back();
              </script>';

        exit;
    }
}

    
?>