<?php
require "../../connect.php";

$id = $_POST['id'];
$action = $_POST['action'];
$reason = $_POST['reason'];
$current_date=date('Y-m-d');
$status=0;
if($action == 'approve'){
    $status=1;
}else if($action == 'reject'){
    $status=2;
}
$sql0 = "UPDATE sub_franchisee_upgrade SET
    upgrade_status = :status,
    approved_by = :approved_by,
    upgrade_approval_date = :upgrade_approval_date,
    rejection_reason = :rejection_reason
WHERE id = (
    SELECT id FROM (
        SELECT id 
        FROM sub_franchisee_upgrade 
        WHERE sub_franchisee_id = :id
        ORDER BY id DESC 
        LIMIT 1
    ) AS t
)";

$stmt0 = $conn->prepare($sql0);

$result = $stmt0->execute([
    ':status' => $status,   // 0 = Pending, 1 = Approved, 2 = Rejected
    ':approved_by' => 1,
    ':upgrade_approval_date' => $current_date,
    ':rejection_reason' => $reason,
    ':id' => $id
]);


if($result){
    
    $sql = "UPDATE sub_franchisee 
            SET upgrade_status=:upgrade_status
            WHERE sub_franchisee_id=:id";
    
    $stmt = $conn->prepare($sql);
    $result1 = $stmt->execute([
        ':upgrade_status' => 2,
        ':id' => $id
    ]);
    
    echo $status ;
}
?>