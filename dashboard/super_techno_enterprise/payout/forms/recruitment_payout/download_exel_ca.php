<?php
require '../../../../connect.php';
require '../../../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$payoutYear = $_GET['payoutYear'];
$payoutMonth = $_GET['payoutMonth'];
$payoutmessage = $_GET['payoutmessage'];
$designation = $_GET['designation'] ?? '';
$user_id = $_GET['user_id'] ?? '';
$user_id_str=substr($user_id,0,1) == 'F'?substr($user_id,0,1):substr($user_id,0,2);

$dateObj   = DateTime::createFromFormat('!m', $payoutMonth);
$monthName = $dateObj->format('F'); 

if($payoutmessage == 'PreviousPayout'){
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->mergeCells('A1:I1');
    $sheet->setCellValue(
        'A1',
        'Previous Payout List as of '.$monthName.', '.$payoutYear
    );

    $rowNo = 3;
    // $stmt2 = "SELECT * FROM ca_ta_payout WHERE $designation = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $stmt2 = "SELECT 
                    ca.created_date,
                    ca.status,
                    ca.id,
                    ca.business_mentor,
                    ca.message_bm,
                    ca.commision_bm,
                    ca.status_bm,
                    ca.techno_enterprise,
                    ca.message_te,
                    ca.commision_te,
                    ca.status_te,
                    COALESCE(cap.status, 0) AS status,
                    cap.date AS paydate
                FROM ca_ta_payout ca
                LEFT JOIN ca_ta_payout_paid cap 
                    ON cap.$designation = ca.$designation
                    AND cap.techno_enterprise = ca.techno_enterprise
                    AND YEAR(cap.date) = '".$payoutYear."'
                    AND MONTH(cap.date) = '".$payoutMonth."'
                WHERE ca.$designation = '".$user_id."' 
                AND YEAR(ca.created_date) = '".$payoutYear."' 
                AND MONTH(ca.created_date) = '".$payoutMonth."'
                ";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$headers = [
            'Date',
            'Reference ID',
            'Reference Name',
            'Payout Details',
            'Amount',
            'TDS',
            'Total Payable',
            'Status',
            'Paid Date'
        ];

        $col = 'A';

        foreach($headers as $header){
            $sheet->setCellValue($col.$rowNo, $header);
            $col++;
        }

        $rowNo++;
        foreach($stmt2->fetchAll() as $key => $row2){
            $rd= new DateTime($row2['created_date']);
            $newDate= $rd->format('d-m-Y');
            $id = $row2['id'];

            if($user_id_str == "ST"){

                $BC_Commi = $row2['commision_bm'];
            
                (int)$BC_Commi_TDS = (int)$BC_Commi*2/100;
                (int)$BC_Commi_Total = (int)$BC_Commi-(int)$BC_Commi_TDS; 

                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message_bm'];
                $message1 =  str_replace('.','<br>',$message1); 
                
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `super_techno_enterprise` where super_techno_enterprise_id='".$row2['business_mentor']."'");
                
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach (($sql1->fetchAll()) as $key => $row1) {
                        $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 

                $status = 'Pending';
                $paidDate = 'NA';

                if($row2['status_bm'] == 1){
                    $status = 'Paid';
                    $paidDate = $row2['paydate'];
                }

                $sheet->setCellValue('A'.$rowNo, $newDate);
                $sheet->setCellValue('B'.$rowNo, $row2['business_mentor']);
                $sheet->setCellValue('C'.$rowNo, $ta_name);
                $sheet->setCellValue('D'.$rowNo, strip_tags($message1));
                $sheet->setCellValue('E'.$rowNo, $BC_Commi);
                $sheet->setCellValue('F'.$rowNo, $BC_Commi_TDS);
                $sheet->setCellValue('G'.$rowNo, $BC_Commi_Total);
                $sheet->setCellValue('H'.$rowNo, $status);
                $sheet->setCellValue('I'.$rowNo, $paidDate);

                $rowNo++;
            }
        
        }
        foreach(range('A','I') as $column){
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
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->mergeCells('A1:I1');
    $sheet->setCellValue(
        'A1',
        'Next Payout List as of '.$monthName.', '.$payoutYear
    );

    $rowNo = 3;
    // $stmt2 = "SELECT * FROM ca_ta_payout WHERE $designation = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $stmt2 ="SELECT 
                    ca.created_date,
                    ca.status,
                    ca.id,
                    ca.business_mentor,
                    ca.message_bm,
                    ca.commision_bm,
                    ca.status_bm,
                    ca.techno_enterprise,
                    ca.message_te,
                    ca.commision_te,
                    ca.status_te,
                    COALESCE(cap.status, 0) AS status,
                    cap.date AS paydate
                FROM ca_ta_payout ca
                LEFT JOIN ca_ta_payout_paid cap 
                    ON cap.$designation = ca.$designation
                    AND cap.techno_enterprise = ca.techno_enterprise
                    AND YEAR(cap.date) = '".$payoutYear."'
                    AND MONTH(cap.date) = '".$payoutMonth."'
                WHERE ca.$designation = '".$user_id."' 
                AND YEAR(ca.created_date) = '".$payoutYear."' 
                AND MONTH(ca.created_date) = '".$payoutMonth."'";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
       
    	$headers = [
            'Date',
            'Reference ID',
            'Reference Name',
            'Payout Details',
            'Amount',
            'TDS',
            'Total Payable',
            'Status',
            'Paid Date'
        ];

        $col = 'A';

        foreach($headers as $header){
            $sheet->setCellValue($col.$rowNo, $header);
            $col++;
        }

        $rowNo++;
        foreach($stmt2->fetchAll() as $key => $row2){
            $rd= new DateTime($row2['created_date']);
            $newDate= $rd->format('d-m-Y');
            $id = $row2['id'];

            if($user_id_str == "ST"){

                $BC_Commi = $row2['commision_bm'];
            
                (int)$BC_Commi_TDS = (int)$BC_Commi*2/100;
                (int)$BC_Commi_Total = (int)$BC_Commi-(int)$BC_Commi_TDS; 

                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message_bm'];
                $message1 =  str_replace('.','<br>',$message1); 
                
                
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `super_techno_enterprise` where super_techno_enterprise_id='".$row2['business_mentor']."'");
                
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach (($sql1->fetchAll()) as $key => $row1) {
                        $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 

                $status = 'Pending';
                $paidDate = 'NA';

                if($row2['status_bm'] == 1){
                    $status = 'Paid';
                    $paidDate = $row2['paydate'];
                }

                $sheet->setCellValue('A'.$rowNo, $newDate);
                $sheet->setCellValue('B'.$rowNo, $row2['business_mentor']);
                $sheet->setCellValue('C'.$rowNo, $ta_name);
                $sheet->setCellValue('D'.$rowNo, strip_tags($message1));
                $sheet->setCellValue('E'.$rowNo, $BC_Commi);
                $sheet->setCellValue('F'.$rowNo, $BC_Commi_TDS);
                $sheet->setCellValue('G'.$rowNo, $BC_Commi_Total);
                $sheet->setCellValue('H'.$rowNo, $status);
                $sheet->setCellValue('I'.$rowNo, $paidDate);

                $rowNo++;
            }
        }
        foreach(range('A','I') as $column){
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

if($payoutmessage == 'TotalPayout'){
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->mergeCells('A1:I1');
    $sheet->setCellValue(
        'A1',
        'Total Payout List as of '.$monthName.', '.$payoutYear
    );

    $rowNo = 3;
    // $stmt2 = "SELECT * FROM ca_ta_payout WHERE $designation = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $stmt2 ="SELECT 
                    ca.created_date,
                    ca.status,
                    ca.id,
                    ca.business_mentor,
                    ca.message_bm,
                    ca.commision_bm,
                    ca.status_bm,
                    ca.techno_enterprise,
                    ca.message_te,
                    ca.commision_te,
                    ca.status_te,
                    COALESCE(cap.status, 0) AS status,
                    cap.date AS paydate
                FROM ca_ta_payout ca
                LEFT JOIN ca_ta_payout_paid cap 
                    ON cap.$designation = ca.$designation
                    AND cap.techno_enterprise = ca.techno_enterprise
                    AND YEAR(cap.date) = '".$payoutYear."'
                    AND MONTH(cap.date) = '".$payoutMonth."'
                WHERE ca.$designation = '".$user_id."' 
                AND YEAR(ca.created_date) = '".$payoutYear."' 
                AND MONTH(ca.created_date) = '".$payoutMonth."'";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$headers = [
            'Date',
            'Reference ID',
            'Reference Name',
            'Payout Details',
            'Amount',
            'TDS',
            'Total Payable',
            'Status',
            'Paid Date'
        ];

        $col = 'A';

        foreach($headers as $header){
            $sheet->setCellValue($col.$rowNo, $header);
            $col++;
        }

        $rowNo++;
        foreach($stmt2->fetchAll() as $key => $row2){
            $rd= new DateTime($row2['created_date']);
            $newDate= $rd->format('d-m-Y');
            $id = $row2['id'];

            if($user_id_str == "ST"){

                $BC_Commi = $row2['commision_bm'];
            
                (int)$BC_Commi_TDS = (int)$BC_Commi*2/100;
                (int)$BC_Commi_Total = (int)$BC_Commi-(int)$BC_Commi_TDS; 

                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message_bm'];
                $message1 =  str_replace('.','<br>',$message1); 
                
                
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `super_techno_enterprise` where super_techno_enterprise_id='".$row2['business_mentor']."'");
                
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach (($sql1->fetchAll()) as $key => $row1) {
                        $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 

                $status = 'Pending';
                $paidDate = 'NA';

                if($row2['status_bm'] == 1){
                    $status = 'Paid';
                    $paidDate = $row2['paydate'];
                }

                $sheet->setCellValue('A'.$rowNo, $newDate);
                $sheet->setCellValue('B'.$rowNo, $row2['business_mentor']);
                $sheet->setCellValue('C'.$rowNo, $ta_name);
                $sheet->setCellValue('D'.$rowNo, strip_tags($message1));
                $sheet->setCellValue('E'.$rowNo, $BC_Commi);
                $sheet->setCellValue('F'.$rowNo, $BC_Commi_TDS);
                $sheet->setCellValue('G'.$rowNo, $BC_Commi_Total);
                $sheet->setCellValue('H'.$rowNo, $status);
                $sheet->setCellValue('I'.$rowNo, $paidDate);

                $rowNo++;
            }
        }
        foreach(range('A','I') as $column){
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

if($payoutmessage == 'allPayout'){

    $stmt2 = " SELECT 
                    ca.created_date,
                    ca.status,
                    ca.id,
                    ca.business_mentor,
                    ca.message_bm,
                    ca.commision_bm,
                    ca.status_bm,
                    ca.techno_enterprise,
                    ca.message_te,
                    ca.commision_te,
                    ca.status_te,
                    COALESCE(cap.status, 0) AS status,
                    cap.date AS paydate
                FROM ca_ta_payout ca
                LEFT JOIN ca_ta_payout_paid cap 
                    ON cap.$designation = ca.$designation
                    AND cap.techno_enterprise = ca.techno_enterprise
                    AND YEAR(cap.date) = '".$payoutYear."'
                    AND MONTH(cap.date) = '".$payoutMonth."'
                WHERE ca.$designation = '".$user_id."' 
                AND YEAR(ca.created_date) = '".$payoutYear."' 
                AND MONTH(ca.created_date) = '".$payoutMonth."'";
    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->mergeCells('A1:I1');
    $sheet->setCellValue(
        'A1',
        'All Payout List as of '.$monthName.', '.$payoutYear
    );

    $rowNo = 3;
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$headers = [
            'Date',
            'Reference ID',
            'Reference Name',
            'Payout Details',
            'Amount',
            'TDS',
            'Total Payable',
            'Status',
            'Paid Date'
        ];

        $col = 'A';

        foreach($headers as $header){
            $sheet->setCellValue($col.$rowNo, $header);
            $col++;
        }

        $rowNo++;
        foreach($stmt2->fetchAll() as $key => $row2){
            $rd= new DateTime($row2['created_date']);
            $newDate= $rd->format('d-m-Y');
            $id = $row2['id'];

            // get the commission amount of BA's
            $BC_Commi = $row2['commision_bm'];
            $CA_Commi = $row2['commision_te'];
            $ca_ta_Commi = $row2['ca_ta_amt_paid'];
            
            (int)$BC_Commi_TDS = (int)$BC_Commi*2/100;
            (int)$BC_Commi_Total = (int)$BC_Commi-(int)$BC_Commi_TDS; 

            (int)$CA_Commi_TDS = (int)$CA_Commi*2/100;
            (int)$CA_Commi_Total = (int)$CA_Commi-(int)$CA_Commi_TDS; 

            (int)$ca_ta_Commi_TDS = (int)$ca_ta_Commi*2/100;
            (int)$ca_ta_Commi_Total = (int)$ca_ta_Commi-(int)$ca_ta_Commi_TDS; 

            // date in proper formate
            $dt = new DateTime($row2['created_date']);
            $dt = $dt->format('Y-m-d');

            // replace dot at end of the line with break statement
            $message1 = $row2['message_bm'];
            $message1 =  str_replace('.','<br>',$message1); 
            $message2 = $row2['message_te'];
            $message2 =  str_replace('.','<br>',$message2); 
            $message3 = $row2['message_ca_ta'];
            $message3 =  str_replace('.','<br>',$message3); 
            
            if($user_id_str == "SF"){
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `sponsor_Super Techno Enterprise` where sponsor_Super Techno Enterprise_id='".$row2['business_mentor']."'");
            }else if($user_id_str == "MF"){
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `master_Super Techno Enterprise` where master_Super Techno Enterprise_id='".$row2['business_mentor']."'");
            }else{
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_mentor` where business_mentor_id='".$row2['business_mentor']."'");
            }
            $sql1->execute();
            $sql1->setFetchMode(PDO::FETCH_ASSOC);
            if($sql1->rowCount()>0){
                foreach (($sql1->fetchAll()) as $key => $row1) {
                    $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
                }
            } 

            if($user_id_str == "TE" || $user_id_str == "CA"){
                $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['techno_enterprise']."'");
            }else if($user_id_str == "F"){
                $sql2= $conn->prepare("SELECT firstname,lastname FROM `sub_Super Techno Enterprise` where sub_Super Techno Enterprise_id='".$row2['techno_enterprise']."'");
            }
            $sql2->execute();
            $sql2->setFetchMode(PDO::FETCH_ASSOC);
            if($sql2->rowCount()>0){
                foreach (($sql2->fetchAll()) as $key => $row3) {
                    $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                }
            } 

            // BM Payout Row
            $sheet->setCellValue('A'.$rowNo, $newDate);
            $sheet->setCellValue('B'.$rowNo, $row2['business_mentor']);
            $sheet->setCellValue('C'.$rowNo, $ta_name);
            $sheet->setCellValue('D'.$rowNo, $message1);
            $sheet->setCellValue('E'.$rowNo, $BC_Commi);
            $sheet->setCellValue('F'.$rowNo, $BC_Commi_TDS);
            $sheet->setCellValue('G'.$rowNo, $BC_Commi_Total);
            $sheet->setCellValue(
                'H'.$rowNo,
                ($row2['status_bm'] == 0 ? 'Pending' : 'Paid')
            );
            $sheet->setCellValue(
                'I'.$rowNo,
                !empty($row2['paydate']) ? $row2['paydate'] : 'N/A'
            );

            $rowNo++;
            
            
            $sheet->setCellValue('A'.$rowNo, $newDate);
            $sheet->setCellValue('B'.$rowNo, $row2['techno_enterprise']);
            $sheet->setCellValue('C'.$rowNo, $ca_name);
            $sheet->setCellValue('D'.$rowNo, $message2);
            $sheet->setCellValue('E'.$rowNo, $CA_Commi);
            $sheet->setCellValue('F'.$rowNo, $CA_Commi_TDS);
            $sheet->setCellValue('G'.$rowNo, $CA_Commi_Total);
            $sheet->setCellValue(
                'H'.$rowNo,
                ($row2['status_te'] == 0 ? 'Pending' : 'Paid')
            );
            $sheet->setCellValue(
                'I'.$rowNo,
                !empty($row2['paydate']) ? $row2['paydate'] : 'N/A'
            );

            $rowNo++;
            
            
            
        }
        foreach(range('A','I') as $column){
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

    
?>