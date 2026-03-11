<?php
require '../../connect.php';

if(isset($_POST['transfer_user_id'])){

    $transfer_id=$_POST['transfer_id'];
    $status=(int)$_POST['status'];
    $text=$_POST['text'];

    $reason=($status==2?$text:'');
    $remark=($status==3?$text:'');

    $result=user_transfer_action($conn,$transfer_id,$status,$reason,$remark);

    echo $result;
    exit;
}

function insertLog($conn,$data){

    $sql="INSERT INTO logs
    (user_id,title,message,message2,reference_no,register_by,from_whom,operation)
    VALUES
    (:user_id,:title,:message,:message2,:reference_no,:register_by,:from_whom,:operation)";

    // echo "<pre>LOG QUERY:\n$sql\n";
    // print_r($data);
    // echo "</pre>";

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

        $sql="SELECT * FROM transfered_users WHERE id=:id";

        // echo "<pre>QUERY:\n$sql\n";
        // print_r(['id'=>$transfer_id]);
        // echo "</pre>";

        $stmt=$conn->prepare($sql);
        $stmt->execute([':id'=>$transfer_id]);
        $transfer=$stmt->fetch(PDO::FETCH_ASSOC);

        if(!$transfer){
            throw new Exception("Transfer not found");
        }

        $payload=json_decode($transfer['pending_payload'],true);

        $table=$payload['table'];
        $identifier_column=$payload['identifier_column'];
        $identifier_id=$payload['identifier_id'];

        if($status == 2){

            $data=$payload['update_data'];
            $loginData=$payload['login_data'];

            $ignore = [
                'prev_user_data',
                'transfer_check',
                'user_type',
                'editfor',
                'note'
            ];

            $set=[];
            $params=[];

            foreach($data as $key=>$value){

                if(in_array($key,$ignore)) continue;

                $set[]="$key=:$key";
                $params[$key]=$value;
            }

            $params['id']=$identifier_id;

            $sql="UPDATE $table SET ".implode(',',$set)." WHERE $identifier_column=:id";

            // echo "<pre>APPROVE UPDATE QUERY:\n$sql\n";
            // print_r($params);
            // echo "</pre>";

            $stmt=$conn->prepare($sql);
            $stmt->execute($params);

            /* update login */

            $sql="UPDATE login SET username=:username WHERE user_id=:user_id";

            // echo "<pre>LOGIN UPDATE QUERY:\n$sql\n";
            // print_r($loginData);
            // echo "</pre>";

            $stmt=$conn->prepare($sql);
            $stmt->execute($loginData);

            /* mark approved */

            $sql="UPDATE $table SET transfer_check=2 WHERE $identifier_column=:id";

            // echo "<pre>TRANSFER FLAG QUERY:\n$sql\n";
            // print_r(['id'=>$identifier_id]);
            // echo "</pre>";

            $stmt=$conn->prepare($sql);
            $stmt->execute([':id'=>$identifier_id]);

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

        }else if($status == 3){

            $sql="UPDATE $table SET transfer_check=0 WHERE $identifier_column=:id";

            // echo "<pre>REJECT QUERY:\n$sql\n";
            // print_r(['id'=>$identifier_id]);
            // echo "</pre>";

            $stmt=$conn->prepare($sql);
            $stmt->execute([':id'=>$identifier_id]);

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

        $sql="UPDATE transfered_users
        SET transfer_status=:status,
            transfer_reason=:reason,
            transfer_remark=:remark,
            transfer_update_date=NOW()
        WHERE id=:id";

        $params=[
            ':status'=>$status,
            ':reason'=>$reason,
            ':remark'=>$remark,
            ':id'=>$transfer_id
        ];

        // echo "<pre>TRANSFER TABLE UPDATE:\n$sql\n";
        // print_r($params);
        // echo "</pre>";
        

        $stmt=$conn->prepare($sql);
        $stmt->execute($params);

        $conn->commit();

        return $status;

    }catch(Exception $e){

        $conn->rollBack();
        echo $e->getMessage();
        return false;
    }
}
?>