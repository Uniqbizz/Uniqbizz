<!-- Pending payment Model data add to table   -->
<?php

require '../../../../connect.php';

// id,userID, paymentMessage, message, Commi, status, col_update

$id = $_POST['id'];
$userID = $_POST['userID'];
$message = $_POST['paymentMessage'];
$messageDetails = $_POST['message'];
$Commi = $_POST['Commi'];
$status = $_POST['status'];
$col_update = $_POST['col_update'];
$col_status = 1;
$tdsPer = 2 / 100;

// update each column status in table **Status Next to Message**
if ($col_update == "messageBM") {
    $sql3 = "UPDATE ca_cu_payout SET status_bm = :message_status WHERE id = :id ";
} else if ($col_update == "messageTE") {
    $sql3 = "UPDATE ca_cu_payout SET status_te = :message_status WHERE id = :id ";
} else if ($col_update == "messageTC") {
    $sql3 = "UPDATE ca_cu_payout SET status_tc = :message_status WHERE id = :id ";
}
// else if($col_update == "message3"){
//     $sql3 = "UPDATE corporate_agency_payout_level SET message3_status = :message_status WHERE id = :id ";
// }else if($col_update == "message4"){
//     $sql3 = "UPDATE corporate_agency_payout_level SET message4_status = :message_status WHERE id = :id ";
// }else{
//     $sql3 = "UPDATE corporate_agency_payout_level SET message5_status = :message_status WHERE id = :id ";
// }

// TDS calculation
$tdsAmount = $Commi * $tdsPer;
$total = $Commi - $tdsAmount;


$sql = $conn->prepare("SELECT * FROM ca_cu_payout WHERE id= '" . $id . "' ");
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
if ($sql->rowCount() > 0) {
    foreach ($sql->fetchAll() as $key => $row) {
        $business_mentor = $row['business_mentor'] ?? 'NA';
        $techno_enterprise = $row['techno_enterprise'];
        $travel_consultant = $row['travel_consultant'];
        $customer = $row['customer'];
    }
}

// echo " business_consultant :" .$business_consultant. ".";
// echo " corporate_agency :" .$corporate_agency. ".";
// echo " BC_Ref :" .$BC_Ref. ".";
// echo " Payment Message :" .$message. ".";
// echo " Paid Message :" .$messageDetails. ".";
// echo " Commission :" .$BC_Commi. ".";
// echo " TDS Amount :" .$tdsAmount. ".";
// echo " Total Payable :" .$total. ".";
// echo " Status :" .$status. ".";
// echo " Column Update :" .$col_update. ".";

// insert paid CA in corporate_agency_payout_paid table
$sql2 = $conn->prepare("INSERT INTO ca_cu_payout_paid (business_mentor, techno_enterprise, travel_consultant, customer, payout_message, payout_details, amount, tds, total_payable) VALUES (:business_mentor, :techno_enterprise, :travel_consultant, :customer, :payout_message, :payout_details, :amount, :tds, :total_payable) ");
$result = $sql2->execute(array(
    ':business_mentor' => $business_mentor,
    ':techno_enterprise' => $techno_enterprise,
    ':travel_consultant' => $travel_consultant,
    ':customer' => $customer,
    ':payout_message' => $message,
    ':payout_details' => $messageDetails,
    ':amount' => $Commi,
    ':tds' => $tdsAmount,
    ':total_payable' => $total
));

// update message status from corporate_agency_payout_level table
if ($result) {
    $stmt = $conn->prepare($sql3);
    $result2 = $stmt->execute(array(
        ':message_status' => $col_status,
        ':id' => $id
    ));
}

if ($result2) {
    echo "1";
} else {
    echo "0";
}
?>