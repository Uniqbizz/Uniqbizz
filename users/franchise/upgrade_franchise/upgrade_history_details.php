<?php

require '../../../connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => false,
        "message" => "Invalid request method"
    ]);
    exit;
}

$request = json_decode(file_get_contents("php://input"), true);

$row_id = $request['id'] ?? '';
$id = $request['userId'] ?? '';

if (!$row_id || !$id) {
    echo json_encode([
        "status" => false,
        "message" => "id and userId required"
    ]);
    exit;
}

try {

    /* -------------------------
       Franchisee Details
    ------------------------- */

    $sql = "SELECT 
                sub_franchisee_id,
                CONCAT(firstname,' ',lastname) AS name,
                amount,
                current_commission_per,
                current_incentive_per,
                upgrade_status
            FROM sub_franchisee
            WHERE sub_franchisee_id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->execute([':id'=>$id]);

    $franchisee = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$franchisee){
        echo json_encode([
            "status"=>false,
            "message"=>"Franchisee not found"
        ]);
        exit;
    }

    $previous_amount = $franchisee['amount'];

    /* -------------------------
       Upgrade Details
    ------------------------- */

    $sql = "SELECT *
            FROM sub_franchisee_upgrade
            WHERE sub_franchisee_id = :id
            AND id = :row_id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':id'=>$id,
        ':row_id'=>$row_id
    ]);

    $upgrade = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$upgrade){
        echo json_encode([
            "status"=>false,
            "message"=>"Upgrade record not found"
        ]);
        exit;
    }

    /* -------------------------
       Status Text
    ------------------------- */

    $statusText = '';

    if($upgrade['upgrade_status']==1){
        $statusText = "Approved";
    } elseif($upgrade['upgrade_status']==2){
        $statusText = "Rejected";
    } else {
        $statusText = "Requested";
    }

    /* -------------------------
       Response
    ------------------------- */

    echo json_encode([
        "status"=>true,
        "data"=>[

            "franchisee_id"=>$franchisee['sub_franchisee_id'],
            "franchisee_name"=>$franchisee['name'],

            "previous_amount"=>(float)$previous_amount,
            "selected_new_amount"=>(float)$upgrade['new_investment_amt'],
            "updated_amount"=>(float)$upgrade['upgrade_amt'],

            "new_commission_percent"=>(float)$upgrade['new_commission_per'],
            "new_incentive_percent"=>(float)$upgrade['new_incentive_per'],

            "note"=>$upgrade['note'] ?? '',

            "payment_mode"=>ucfirst($upgrade['payment_mode']),

            "cheque_no"=>$upgrade['cheque_no'],
            "cheque_date"=>$upgrade['cheque_date'],
            "bank_name"=>$upgrade['bank_name'],

            "transaction_no"=>$upgrade['transaction_no'],

            "rejection_reason"=>$upgrade['rejection_reason'] ?? '',

            "status"=>$statusText,

            "payment_proof"=>$upgrade['payment_proof'] 
                ? "uploading/".$upgrade['payment_proof']
                : null
        ]
    ]);

} catch(Exception $e){

    echo json_encode([
        "status"=>false,
        "message"=>$e->getMessage()
    ]);
}