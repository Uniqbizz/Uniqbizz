<?php
require '../../../../connect.php';
require '../../../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$payoutYear = $_GET['payoutYear'];
$payoutMonth = $_GET['payoutMonth'];
$payoutmessage = $_GET['payoutmessage'];
$designation = $_GET['designation'] ?? '';
$user_id = $_GET['user_id'] ?? '';

$dateObj   = DateTime::createFromFormat('!m', $payoutMonth);
$monthName = $dateObj->format('F'); 

if($payoutmessage == 'PreviousPayout'){

    $stmt2 = $conn->prepare("
        SELECT * 
        FROM techno_enterprise_payout 
        WHERE ste_id = '".$user_id."'
        AND YEAR(created_date) = '".$payoutYear."'
        AND MONTH(created_date) = '".$payoutMonth."'
    ");

    $stmt2->execute();
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);

    if($stmt2->rowCount() > 0){

        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue(
            'A1',
            'Previous Payout List as of '.$monthName.', '.$payoutYear
        );

        $rowNo = 3;

        $headers = [
            'Date',
            'Super Techno Enterprise ID',
            'Super Techno Enterprise Name',
            'Techno Enterprise ID',
            'Techno Enterprise Name',
            'Payout Details',
            'Amount',
            'TDS',
            'Total Payable',
            'Status'
        ];

        $col = 'A';
        foreach($headers as $header){
            $sheet->setCellValue($col.$rowNo, $header);
            $col++;
        }

        $rowNo++;

        foreach($stmt2->fetchAll() as $row2){

            $newDate = date('d-m-Y', strtotime($row2['created_date']));

            $Commi = $row2['ste_amount'];

            $Commi_TDS = $Commi * 2 / 100;
            $Commi_Total = $Commi - $Commi_TDS;

            $message1 = str_replace('.', PHP_EOL, $row2['message']);

            $ta_name = '';
            $sql1 = $conn->prepare("
                SELECT firstname, lastname
                FROM super_techno_enterprise
                WHERE super_techno_enterprise_id = '".$row2['ste_id']."'
            ");
            $sql1->execute();

            if($row1 = $sql1->fetch(PDO::FETCH_ASSOC)){
                $ta_name = $row1['firstname'].' '.$row1['lastname'];
            }

            $ca_name = '';
            $sql2 = $conn->prepare("
                SELECT firstname, lastname
                FROM corporate_agency
                WHERE corporate_agency_id = '".$row2['corporate_agency']."'
            ");
            $sql2->execute();

            if($row3 = $sql2->fetch(PDO::FETCH_ASSOC)){
                $ca_name = $row3['firstname'].' '.$row3['lastname'];
            }

            $sheet->setCellValue('A'.$rowNo, $newDate);
            $sheet->setCellValue('B'.$rowNo, $row2['ste_id']);
            $sheet->setCellValue('C'.$rowNo, $ta_name);
            $sheet->setCellValue('D'.$rowNo, $row2['corporate_agency']);
            $sheet->setCellValue('E'.$rowNo, $ca_name);
            $sheet->setCellValue('F'.$rowNo, $message1);
            $sheet->setCellValue('G'.$rowNo, $Commi);
            $sheet->setCellValue('H'.$rowNo, $Commi_TDS);
            $sheet->setCellValue('I'.$rowNo, $Commi_Total);
            $sheet->setCellValue(
                'J'.$rowNo,
                ($row2['status'] == 0 ? 'Pending' : 'Paid')
            );

            $rowNo++;
        }

        foreach(range('A', 'J') as $column){
            $sheet->getColumnDimension($column)->setAutoSize(true);
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
        echo '<script>alert("No Payout Data"); window.history.back();</script>';
    }
}

if($payoutmessage == 'NextPayout'){

    $stmt2 = $conn->prepare("
        SELECT *
        FROM techno_enterprise_payout
        WHERE ste_id = '".$user_id."'
        AND YEAR(created_date) = '".$payoutYear."'
        AND MONTH(created_date) = '".$payoutMonth."'
    ");

    $stmt2->execute();
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);

    if($stmt2->rowCount() > 0){

        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue(
            'A1',
            'Next Payout List as of '.$monthName.', '.$payoutYear
        );

        $rowNo = 3;

        $headers = [
            'Date',
            'Super Techno Enterprise ID',
            'Super Techno Enterprise Name',
            'Techno Enterprise ID',
            'Techno Enterprise Name',
            'Payout Message',
            'Amount',
            'TDS',
            'Total Payable',
            'Status'
        ];

        $col = 'A';
        foreach($headers as $header){
            $sheet->setCellValue($col.$rowNo, $header);
            $col++;
        }

        $rowNo++;

        foreach($stmt2->fetchAll() as $row2){

            $newDate = date('d-m-Y', strtotime($row2['created_date']));

            $Commi = $row2['ste_amount'];
            $Commi_TDS = $Commi * 2 / 100;
            $Commi_Total = $Commi - $Commi_TDS;

            $message1 = str_replace('.', PHP_EOL, $row2['message']);

            $ta_name = '';
            $sql1 = $conn->prepare("
                SELECT firstname, lastname
                FROM super_techno_enterprise
                WHERE super_techno_enterprise_id = '".$row2['ste_id']."'
            ");
            $sql1->execute();

            if($row1 = $sql1->fetch(PDO::FETCH_ASSOC)){
                $ta_name = $row1['firstname'].' '.$row1['lastname'];
            }

            $ca_name = '';
            $sql2 = $conn->prepare("
                SELECT firstname, lastname
                FROM corporate_agency
                WHERE corporate_agency_id = '".$row2['corporate_agency']."'
            ");
            $sql2->execute();

            if($row3 = $sql2->fetch(PDO::FETCH_ASSOC)){
                $ca_name = $row3['firstname'].' '.$row3['lastname'];
            }

            $sheet->setCellValue('A'.$rowNo, $newDate);
            $sheet->setCellValue('B'.$rowNo, $row2['ste_id']);
            $sheet->setCellValue('C'.$rowNo, $ta_name);
            $sheet->setCellValue('D'.$rowNo, $row2['corporate_agency']);
            $sheet->setCellValue('E'.$rowNo, $ca_name);
            $sheet->setCellValue('F'.$rowNo, $message1);
            $sheet->setCellValue('G'.$rowNo, $Commi);
            $sheet->setCellValue('H'.$rowNo, $Commi_TDS);
            $sheet->setCellValue('I'.$rowNo, $Commi_Total);
            $sheet->setCellValue(
                'J'.$rowNo,
                ($row2['status'] == 0 ? 'Pending' : 'Paid')
            );

            $rowNo++;
        }

        $sheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A3:J3')->getFont()->setBold(true);

        foreach(range('A', 'J') as $column){
            $sheet->getColumnDimension($column)->setAutoSize(true);
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
        echo '<script>alert("No Payout Data"); window.history.back();</script>';
    }
} 

if($payoutmessage == 'TotalPayout'){

    $stmt2 = $conn->prepare("
        SELECT *
        FROM techno_enterprise_payout
        WHERE ste_id = '".$user_id."'
        AND YEAR(created_date) = '".$payoutYear."'
        AND MONTH(created_date) = '".$payoutMonth."'
        AND status='1'
    ");

    $stmt2->execute();
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);

    if($stmt2->rowCount() > 0){

        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue(
            'A1',
            'Total Payout List as of '.$monthName.', '.$payoutYear
        );

        $rowNo = 3;

        $headers = [
            'Date',
            'Super Techno Enterprise ID',
            'Super Techno Enterprise Name',
            'Techno Enterprise ID',
            'Techno Enterprise Name',
            'Payout Message',
            'Amount',
            'TDS',
            'Total Payable',
            'Status'
        ];

        $col = 'A';

        foreach($headers as $header){
            $sheet->setCellValue($col.$rowNo, $header);
            $col++;
        }

        $rowNo++;

        foreach($stmt2->fetchAll() as $row2){

            $newDate = date('d-m-Y', strtotime($row2['created_date']));

            $Commi = $row2['ste_amount'];

            $Commi_TDS = $Commi * 2 / 100;
            $Commi_Total = $Commi - $Commi_TDS;

            $message1 = str_replace('.', PHP_EOL, $row2['message']);
            $message2 = str_replace('.', PHP_EOL, $row2['message_details']);

            $ta_name = '';
            $sql1 = $conn->prepare("
                SELECT firstname, lastname
                FROM super_techno_enterprise
                WHERE super_techno_enterprise_id = '".$row2['ste_id']."'
            ");
            $sql1->execute();

            if($row1 = $sql1->fetch(PDO::FETCH_ASSOC)){
                $ta_name = $row1['firstname'].' '.$row1['lastname'];
            }

            $ca_name = '';
            $sql2 = $conn->prepare("
                SELECT firstname, lastname
                FROM corporate_agency
                WHERE corporate_agency_id = '".$row2['corporate_agency']."'
            ");
            $sql2->execute();

            if($row3 = $sql2->fetch(PDO::FETCH_ASSOC)){
                $ca_name = $row3['firstname'].' '.$row3['lastname'];
            }

            $sheet->setCellValue('A'.$rowNo, $newDate);
            $sheet->setCellValue('B'.$rowNo, $row2['ste_id']);
            $sheet->setCellValue('C'.$rowNo, $ta_name);
            $sheet->setCellValue('D'.$rowNo, $row2['corporate_agency']);
            $sheet->setCellValue('E'.$rowNo, $ca_name);
            $sheet->setCellValue('F'.$rowNo, $message1);
            $sheet->setCellValue('G'.$rowNo, $Commi);
            $sheet->setCellValue('H'.$rowNo, $Commi_TDS);
            $sheet->setCellValue('I'.$rowNo, $Commi_Total);
            $sheet->setCellValue(
                'J'.$rowNo,
                ($row2['status'] == 0 ? 'Pending' : 'Paid')
            );

            $rowNo++;
        }

        $sheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A3:J3')->getFont()->setBold(true);

        foreach(range('A', 'J') as $column){
            $sheet->getColumnDimension($column)->setAutoSize(true);
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
        echo '<script>alert("No Payout Data"); window.history.back();</script>';
    }
}

// if($payoutmessage == 'allPayout'){
//     if($designation == 'travel_agent'){
//         $stmt2 = " SELECT * FROM techno_enterprise_payout WHERE ste_id = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
//     }else if($designation == 'corporate_agency'){
//         $stmt2 = " SELECT * FROM techno_enterprise_payout WHERE corporate_agency = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
//     }
//     $output="";
//     $stmt2 = $conn -> prepare($stmt2);
//     $stmt2 -> execute();
//     $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
//     if($stmt2 -> rowCount()>0){
//     	$output .= '<h2 style="text-align:center">All Payout List as of '.$monthName.','.$payoutYear.'</h2>
//         <table border="1" style="text-align:center">
//             <tr>
//                 <th >Date</th>
//                 <th class="mobile_view">Super Techno Enterprise</th>
//                 <th class="mobile_view">Super Techno Enterprise Name</th>
//                 <th class="mobile_view">Techno Enterprise</th>
//                 <th class="mobile_view">Techno Enterprise Name</th>
//                 <th ><span class="long-name">Payout Message</th>
//                 <th ><span class="long-name">Payout Details</th>
//                 <th class="mobile_view tab_view">Amount</th>
//                 <th class="mobile_view" >TDS</th>
//                 <th style="text-align:center;">Total Payable</th>
//                 <th style="text-align:center;">Status</th>
//             </tr>';
//             foreach($stmt2->fetchAll() as $key => $row2){
//                 $rd= new DateTime($row2['created_date']);
//                 $newDate= $rd->format('d-m-Y');
//                 $id = $row2['id'];

//                 // get the commission amount of BA's
//                 $Commi = $row2['ste_amount'];
                
//                 (int)$Commi_TDS = (int)$Commi*2/100;
//                 (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 


//                 // date in proper formate
//                 $dt = new DateTime($row2['created_date']);
//                 $dt = $dt->format('Y-m-d');

//                 // replace dot at end of the line with break statement
//                 $message1 = $row2['message'];
//                 $message1 =  str_replace('.','<br>',$message1); 
//                 $message2 = $row2['message_details'];
//                 $message2 =  str_replace('.','<br>',$message2); 
                
//                 $sql1= $conn->prepare("SELECT firstname,lastname FROM `travel_agent` where travel_agent_id='".$row2['ste_id']."'");
//                 $sql1->execute();
//                 $sql1->setFetchMode(PDO::FETCH_ASSOC);
//                 if($sql1->rowCount()>0){
//                     foreach (($sql1->fetchAll()) as $key => $row1) {
//                         $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
//                     }
//                 } 

//                 $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['corporate_agency']."'");
//                 $sql2->execute();
//                 $sql2->setFetchMode(PDO::FETCH_ASSOC);
//                 if($sql2->rowCount()>0){
//                     foreach (($sql2->fetchAll()) as $key => $row3) {
//                         $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
//                     }
//                 } 

//                 $output .= '<tr>
//                     <td >'.$newDate.'</td>
//                     <td>'.$row2['ste_id'].'</td>
//                     <td>'.$ta_name.'</td>
//                     <td>'.$row2['corporate_agency'].'</td>
//                     <td>'.$ca_name.'</td>
//                     <td class="message">'.$message1.'</td>
//                     <td class="message">'.$message2.'</td>
//                     <td style="text-align:center;">'.$Commi.'/-</td>
//                     <td style="text-align:center;">'.$Commi_TDS.'/-</td>
//                     <td style="text-align:center;">'.$Commi_Total.'/-</td>';
//                     if($row2['status'] == 0){
//                         $output .='<td style="text-align:center;">Pending</td>';
//                     }else{
//                         $output .='<td style="text-align:center;">Paid</td>';
//                     }
//                 $output .='</tr>';
               
//             }
//         $output .= '</table>';
//         header("Content-Type: application/xls");
//         header("Content-Disposition: attachment;filename=All_Payout_List.xls");
//         echo $output;
//     }else{
//         echo 'No All Payout Data';                                                    
//     }
// }

    
?>