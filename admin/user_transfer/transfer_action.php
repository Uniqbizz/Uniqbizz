<?php
require '../connect.php';
$transfer_res='';
if(isset($_POST['transfer_user_id'])){

    $transfer_id=$_POST['transfer_id'];
    $status=$_POST['status'];
    $text=$_POST['text'];

    $reason=($status==2?$text:'');
    $remark=($status==3?$text:'');

    $result=user_transfer_action($conn,$transfer_id,$status,$reason,$remark);

    echo $result;
    exit;
}
//logs function
function insertLog($conn,$data){

    $sql="INSERT INTO logs
    (user_id,title,message,message2,reference_no,register_by,from_whom,operation)
    VALUES
    (:user_id,:title,:message,:message2,:reference_no,:register_by,:from_whom,:operation)";

    $stmt=$conn->prepare($sql);
    $stmt->execute($data);

}

/* =========================
APPROVE / REJECT
========================= */

function user_transfer_action($conn,$transfer_id,$status,$reason='',$remark='')
{
    try{

        $conn->beginTransaction();

        $stmt=$conn->prepare("SELECT * FROM transfered_users WHERE id=:id");
        $stmt->execute([':id'=>$transfer_id]);
        $transfer=$stmt->fetch(PDO::FETCH_ASSOC);

        if(!$transfer){
            throw new Exception("Transfer not found");
        }

        $payload=json_decode($transfer['pending_payload'],true);

        $table=$payload['table'];
        $identifier_column=$payload['identifier_column'];
        $identifier_id=$payload['identifier_id'];

        if($status==2){

            $data=$payload['update_data'];
            $loginData=$payload['login_data'];

            $set=[];
            $params=[];

            foreach($data as $key=>$value){

                $set[]="$key=:$key";
                $params[$key]=$value;
            }

            $params['id']=$identifier_id;

            $sql="UPDATE $table SET ".implode(',',$set)." WHERE $identifier_column=:id";
            $stmt=$conn->prepare($sql);
            $stmt->execute($params);

            /* update login */

            $stmt=$conn->prepare("UPDATE login
                                  SET username=:username
                                  WHERE user_id=:user_id");

            $stmt->execute($loginData);

            /* mark approved */

            $stmt=$conn->prepare("UPDATE $table
                                  SET transfer_check=2
                                  WHERE $identifier_column=:id");

            $stmt->execute([':id'=>$identifier_id]);

            /* -------- LOG APPROVED -------- */

            $logData = [
                'user_id' => $identifier_id,
                'title' => 'User Transfer',
                'message' => $identifier_id . ' transfer approved',
                'message2' => 'Transfer Approved',
                'reference_no' => 'NA',
                'register_by' => '1',
                'from_whom' => '1',
                'operation' => 'Transfer Approved'
            ];
            insertLog($conn,$logData);
        }

        if($status==3){

            /* reset flag */

            $stmt=$conn->prepare("UPDATE $table
                                  SET transfer_check=0
                                  WHERE $identifier_column=:id");

            $stmt->execute([':id'=>$identifier_id]);

            /* -------- LOG REJECTED -------- */

            $logData = [
                'user_id' => $identifier_id,
                'title' => 'User Transfer',
                'message' => $identifier_id . ' transfer rejected',
                'message2' => 'Transfer Rejected',
                'reference_no' => 'NA',
                'register_by' => '1',
                'from_whom' => '1',
                'operation' => 'Transfer Rejected'
            ];

            insertLog($conn,$logData);
        }

        /* update transfer table */

        $stmt=$conn->prepare("UPDATE transfered_users
        SET transfer_status=:status,
            transfer_reason=:reason,
            transfer_remark=:remark
        WHERE id=:id");

        $stmt->execute([
            ':status'=>$status,
            ':reason'=>$reason,
            ':remark'=>$remark,
            ':id'=>$transfer_id
        ]);

        $conn->commit();
        return $status;

    }catch(Exception $e){

        $conn->rollBack();
        echo $e->getMessage();
        return false;
    }
}
?>