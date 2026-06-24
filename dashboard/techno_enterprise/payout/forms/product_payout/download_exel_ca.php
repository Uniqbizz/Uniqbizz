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
$userType = $_GET['userType'] ?? '';
$userId = $_GET['user_id'] ?? '';

$tdsPercentage=2/100;

$dateObj   = DateTime::createFromFormat('!m', $payoutMonth);
$monthName = $dateObj->format('F'); 

if($payoutmessage == 'PreviousPayout' || $payoutmessage == 'NextPayout'){
    
    if($userType == '10'){
        $sql = "SELECT * FROM `product_payout` WHERE  (cu1_id = '".$userId."') OR (cu2_id = '".$userId."') OR (cu3_id = '".$userId."')  AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }else if($userType == '11'){
        $sql = "SELECT * FROM `product_payout` WHERE  ta_id = '".$userId."'AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }else if($userType == '16' || $userType =='29' || $userType =='32'){
        $sql = "SELECT * FROM `product_payout` WHERE  te_id = '".$userId."'  AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }else if($userType == '26' || $userType =='28' || $userType =='30'){
        $sql = "SELECT * FROM `product_payout` WHERE  bm_id = '".$userId."'  AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }else if($userType == '25' || $userType == '31'){
        $sql = "SELECT * FROM `product_payout` WHERE  bdm_id = '".$userId."'  AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }else if($userType == '24'){
        $sql = "SELECT * FROM `product_payout` WHERE  bch_id = '".$userId."'  AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }


    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if( $stmt -> rowCount()>0 ){
        $sheet->mergeCells('A1:G1');

        $title = ($payoutmessage == 'PreviousPayout')
            ? 'Previous Payout List as of '.$monthName.', '.$payoutYear
            : 'Next Payout List as of '.$monthName.', '.$payoutYear;

        $sheet->setCellValue('A1', $title);

        $rowNo = 3;
        $headers = [
            'Date',
            'Payout Details'
        ];

        if($userType == '11'){
            $headers[] = 'Markup';
        }

        $headers[] = 'Amount';
        $headers[] = 'TDS';
        $headers[] = 'Total Payable';
        $headers[] = 'Remark';

        $col = 'A';

        foreach($headers as $header){
            $sheet->setCellValue($col.$rowNo, $header);
            $col++;
        }

        $rowNo++;
            
        foreach( ($stmt -> fetchALL()) as $key => $row ){

            // date in proper formate
            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');
            
            //get package Name
            $stmt1 = $conn -> prepare(" SELECT name FROM package WHERE id = '".$row['package_id']."' ");
            $stmt1 -> execute();
            $pkgName = $stmt1 -> fetch();
            $packageName = $pkgName['name'];

            //get customer Name
            $stmt8 = $conn -> prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '".$row['cu_id']."' ");
            $stmt8 -> execute();
            $cu_name = $stmt8 -> fetch();
            $cuName = $cu_name['firstname'].' '.$cu_name['lastname']; 
            
            $no_of_adult = $row['no_of_adult'] ;
            $no_of_child = $row['no_of_child'] ;

            //customer part remaining
            if($userType == '10'){
                $cu1 = $row['cu1_id'];
                $cu2 = $row['cu2_id'];
                $cu3 = $row['cu3_id'];
                if($cu1 == $userId){
                    $message = $row['cu1_mess']; 
                    $amt = $row['cu1_amt'];
                    $status = $row['cu1_status'];
                }else if($cu2 == $userId){
                    $message = $row['cu2_mess'];
                    $amt = $row['cu2_amt'];
                    $status = $row['cu2_status'];
                }else{
                    $message = $row['cu3_mess'];
                    $amt = $row['cu3_amt'];
                    $status = $row['cu3_status'];
                }
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }else if($userType == '11'){
                $id = $row['ta_id'];
                $ta_markup = $row['ta_markup'];
                $message = $row['ta_mess'];
                $amt = $row['ta_amt'];
                $status = $row['ta_status'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }else if($userType == '16'|| $userType =='29' || $userType =='32'){
                $id = $row['te_id'];
                $message = $row['te_mess'];
                $amt = $row['te_amt'];
                $status = $row['te_status'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }else if($userType == '24'){
                $id = $row['bch_id'];
                $message = $row['bch_mess'];
                $amt = $row['bch_amt'];
                $status = $row['bch_status'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }else if($userType == '25' || $userType == '31'){
                $id = $row['bdm_id'];
                $message = $row['bdm_mess'];
                $amt = $row['bdm_amt'];
                $status = $row['bdm_status'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }else if($userType == '26' || $userType =='28' || $userType =='30'){
                $id = $row['bm_id'];
                $message = $row['bm_mess'];
                $amt = $row['bm_amt'];
                $status = $row['bm_status'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }

            $col = 'A';

            $sheet->setCellValue($col++.$rowNo, $dt);

            if($userType == '11'){

                $details =
                    $message .
                    ' on selling '.$packageName.
                    ' Package to '.$cuName.
                    ' No of Adult -> '.$no_of_adult.
                    ' No of Child -> '.$no_of_child.
                    ' Markup Price -> Rs '.$ta_markup;

                $sheet->setCellValue($col++.$rowNo, $details);
                $sheet->setCellValue($col++.$rowNo, $ta_markup);

            }else{

                $details =
                    $message .
                    ' on selling '.$packageName.
                    ' Package to '.$cuName.
                    ' No of Adult -> '.$no_of_adult.
                    ' No of Child -> '.$no_of_child;

                $sheet->setCellValue($col++.$rowNo, $details);
            }

            $sheet->setCellValue($col++.$rowNo, $amt);
            $sheet->setCellValue($col++.$rowNo, $tds);
            $sheet->setCellValue($col++.$rowNo, $total);

            $sheet->setCellValue(
                $col++.$rowNo,
                ($status == 1 ? 'Paid' : 'Pending')
            );

            $rowNo++;
            
        }
        $lastColumn = ($userType == '11') ? 'G' : 'F';

        foreach(range('A', $lastColumn) as $column){
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        if($payoutmessage == 'PreviousPayout'){
            $fileName = 'Previous_Payout_List.xlsx';
        }else{
            $fileName = 'Next_Payout_List.xlsx';
        }

        header(
            'Content-Disposition: attachment; filename="'.$fileName.'"'
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
    if($userType == '10'){
        $sql = "SELECT * FROM `product_payout` WHERE  (cu1_id = '".$userId."') OR (cu2_id = '".$userId."') OR (cu3_id = '".$userId."')  AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }else if($userType == '11'){
        $sql = "SELECT * FROM `product_payout` WHERE  ta_id = '".$userId."'AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }else if($userType == '16'|| $userType =='29' || $userType =='32'){
        $sql = "SELECT * FROM `product_payout` WHERE  te_id = '".$userId."'  AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }else if($userType == '26'|| $userType =='28' || $userType =='30'){
        $sql = "SELECT * FROM `product_payout` WHERE  bm_id = '".$userId."'  AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }else if($userType == '25' || $userType == '31'){
        $sql = "SELECT * FROM `product_payout` WHERE  bdm_id = '".$userId."'  AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }else if($userType == '24'){
        $sql = "SELECT * FROM `product_payout` WHERE  bch_id = '".$userId."'  AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }

    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if( $stmt -> rowCount()>0 ){
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue(
            'A1',
            'Total Payout List as of '.$monthName.', '.$payoutYear
        );

        $rowNo = 3;
        $headers = [
            'Date',
            'Payout Details'
        ];

        if($userType == '11'){
            $headers[] = 'Markup';
        }

        $headers[] = 'Amount';
        $headers[] = 'TDS';
        $headers[] = 'Total Payable';
        $headers[] = 'Remark';

        $col = 'A';

        foreach($headers as $header){
            $sheet->setCellValue($col.$rowNo, $header);
            $col++;
        }

        $rowNo++;
            
        foreach( ($stmt -> fetchALL()) as $key => $row ){

            // date in proper formate
            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');
            
            //get package Name
            $stmt1 = $conn -> prepare(" SELECT name FROM package WHERE id = '".$row['package_id']."' ");
            $stmt1 -> execute();
            $pkgName = $stmt1 -> fetch();
            $packageName = $pkgName['name'];

            //get customer Name
            $stmt8 = $conn -> prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '".$row['cu_id']."' ");
            $stmt8 -> execute();
            $cu_name = $stmt8 -> fetch();
            $cuName = $cu_name['firstname'].' '.$cu_name['lastname']; 
            
            $no_of_adult = $row['no_of_adult'] ;
            $no_of_child = $row['no_of_child'] ;

            //customer part remaining
            if($userType == '10'){
                $cu1 = $row['cu1_id'];
                $cu2 = $row['cu2_id'];
                $cu3 = $row['cu3_id'];
                if($cu1 == $userId){
                    $message = $row['cu1_mess']; 
                    $amt = $row['cu1_amt'];
                    $status = $row['cu1_status'];
                }else if($cu2 == $userId){
                    $message = $row['cu2_mess'];
                    $amt = $row['cu2_amt'];
                    $status = $row['cu2_status'];
                }else{
                    $message = $row['cu3_mess'];
                    $amt = $row['cu3_amt'];
                    $status = $row['cu3_status'];
                }
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }else if($userType == '11'){
                $id = $row['ta_id'];
                $ta_markup = $row['ta_markup'];
                $message = $row['ta_mess'];
                $amt = $row['ta_amt'];
                $status = $row['ta_status'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }else if($userType == '16'|| $userType =='29' || $userType =='32'){
                $id = $row['te_id'];
                $message = $row['te_mess'];
                $amt = $row['te_amt'];
                $status = $row['te_status'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }else if($userType == '24'){
                $id = $row['bch_id'];
                $message = $row['bch_mess'];
                $amt = $row['bch_amt'];
                $status = $row['bch_status'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }else if($userType == '25' || $userType == '31'){
                $id = $row['bdm_id'];
                $message = $row['bdm_mess'];
                $amt = $row['bdm_amt'];
                $status = $row['bdm_status'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }else if($userType == '26'|| $userType =='28' || $userType =='30'){
                $id = $row['bm_id'];
                $message = $row['bm_mess'];
                $amt = $row['bm_amt'];
                $status = $row['bm_status'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }

            $details =
                $message .
                ' on selling '.$packageName.
                ' Package to '.$cuName.
                ' No of Adult -> '.$no_of_adult.
                ' No of Child -> '.$no_of_child;

            if($userType == '11'){
                $details .= ' Markup Price -> Rs '.$ta_markup;
            }

            $col = 'A';

            $sheet->setCellValue($col++.$rowNo, $dt);
            $sheet->setCellValue($col++.$rowNo, $details);

            if($userType == '11'){
                $sheet->setCellValue($col++.$rowNo, $ta_markup);
            }

            $sheet->setCellValue($col++.$rowNo, $amt);
            $sheet->setCellValue($col++.$rowNo, round($tds, 2));
            $sheet->setCellValue($col++.$rowNo, round($total, 2));

            $sheet->setCellValue(
                $col++.$rowNo,
                ($status == '1' ? 'Paid' : 'Pending')
            );

            $rowNo++;
            
        }
        $lastColumn = ($userType == '11') ? 'G' : 'F';

        foreach(range('A', $lastColumn) as $column){
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

