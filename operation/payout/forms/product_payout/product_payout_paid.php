
<?php
// <!-- Pending payment Model data add to table   -->
    require '../../../connect.php';

    // id, userID, paymentMessage, amt, status, col_update

    $id = $_POST['id'];
    $userID = $_POST['userID'];
    $commi = $_POST['amt'];
    $paymentMessage = $_POST['message'];
    $status = $_POST['status'];
    $userDesignation = $_POST['col_update'];
    $col_status = 1;
    
    // update message status from corporate_agency_payout_level table
   
    $sql1 = "UPDATE product_payout SET $status=:status WHERE id = :id ";
    $stmt = $conn->prepare($sql1);
    $result = $stmt -> execute(array(
        ':status' => $col_status,
        ':id' => $id
    ));

    // if($result){

    //     $sql2 = $conn->prepare("SELECT * FROM product_payout WHERE id = :id ");
    //     $sql2 -> execute([':id' => $id]);
    //     $details = $sql2 -> fetch();
    //     $package_id = $details['package_id'];
    //     $no_of_adult = $details['no_of_adult'];
    //     $no_of_child = $details['no_of_child'];
    //     $ta_markup = $details['ta_markup'];
        
    //     // $taMarkup = substr($userID,0,2); 
    //     if($userDesignation == "AllPayoutCaTa"){
    //         $mark_ta = $ta_markup;
    //     }else{
    //         $mark_ta = "0";
    //     }

    //     $stmt1 = $conn -> prepare(" SELECT name FROM package WHERE id = '".$package_id."' ");
    //     $stmt1 -> execute();
    //     $pkgName = $stmt1 -> fetch();
    //     $packageName = $pkgName['name'];

    //     if($userDesignation == "AllPayoutBc"){
    //         $stmt2 = $conn -> prepare(" SELECT firstname, lastname FROM business_consultant WHERE business_consultant_id = '".$userID."' ");
    //         $stmt2 -> execute();
    //         $bc_Name = $stmt2 -> fetch();
    //         $userName = $bc_Name['firstname'].' '.$bc_Name['lastname'];
    //     }else if($userDesignation == "AllPayoutCa"){
    //         $stmt3 = $conn -> prepare(" SELECT firstname, lastname FROM corporate_agency WHERE corporate_agency_id = '".$userID."' ");
    //         $stmt3 -> execute();
    //         $ca_Name = $stmt3 -> fetch();
    //         $userName = $ca_Name['firstname'].' '.$ca_Name['lastname'];
    //     }else if($userDesignation == "AllPayoutCaTa"){
    //         $stmt4 = $conn -> prepare(" SELECT firstname, lastname FROM ca_travelagency WHERE ca_travelagency_id = '".$userID."' ");
    //         $stmt4 -> execute();
    //         $ca_ta_Name = $stmt4 -> fetch();
    //         $userName = $ca_ta_Name['firstname'].' '.$ca_ta_Name['lastname'];
    //     }else{
    //         $stmt8 = $conn -> prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '".$userID."' ");
    //         $stmt8 -> execute();
    //         $cu_name = $stmt8 -> fetch();
    //         $userName = $cu_name['firstname'].' '.$cu_name['lastname'];
    //     }

    //     // TDS calculation
    //     $commiMarkup = $commi + $mark_ta;
    //     $tdsAmount = $commiMarkup * 5/100;
    //     $total = $commiMarkup - $tdsAmount; 
        
    //     $sql3 = $conn -> prepare("INSERT INTO `product_payout_paid` (package_id, package_name, no_of_adult, no_of_child, ta_markup, userID, userName, message, Commi_amt, Commi_amt_tds, Commi_amt_total, status) VALUES (:package_id, :package_name, :no_of_adult, :no_of_child, :ta_markup,:userID, :userName, :message, :Commi_amt, :Commi_amt_tds, :Commi_amt_total, :status)");
    //     $result2 = $sql3 -> execute(array(
    //         ':package_id' => $package_id, 
    //         ':package_name' => $packageName, 
    //         ':no_of_adult' => $no_of_adult, 
    //         ':no_of_child' => $no_of_child, 
    //         ':ta_markup' =>  $mark_ta,	
    //         ':userID' => $userID, 
    //         ':userName' => $userName, 
    //         ':message' => $paymentMessage, 
    //         ':Commi_amt' => $commiMarkup, 
    //         ':Commi_amt_tds' => $tdsAmount, 
    //         ':Commi_amt_total' => $total, 
    //         ':status' => 1
    //     ));

    // }

    if($result){
        echo '1';
    }else{
        echo '0';
    }
?>