<?php
    require '../../connect.php';

    if(isset($_POST['transfer_user_id'])){

        $transfer_id = $_POST['transfer_id'];
        $status = (int)$_POST['status'];
        $text = $_POST['text'];

        $reason = ($status == 2 ? $text : '');
        $remark = ($status == 3 ? $text : '');

        $result = user_transfer_action($conn,$transfer_id,$status,$reason,$remark);

        echo $result;
        exit;
    }


    /* =========================
    INSERT SYSTEM LOG
    ========================= */

    function insertLog($conn,$data){

        $sql="INSERT INTO logs
        (user_id,title,message,message2,reference_no,register_by,from_whom,operation)
        VALUES
        (:user_id,:title,:message,:message2,:reference_no,:register_by,:from_whom,:operation)";

        $stmt=$conn->prepare($sql);
        $stmt->execute($data);
    }


    /* =========================
    APPROVE / REJECT TRANSFER
    ========================= */

    function user_transfer_action($conn,$transfer_id,$status,$reason='',$remark='')
    {
        try{

            $conn->beginTransaction();

            /* =========================
            FETCH TRANSFER RECORD
            ========================= */

            $sql="SELECT * FROM transfered_users WHERE id=:id";
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


            /* =========================
            APPROVE TRANSFER
            ========================= */

            if ($status == 2) {

                $data = $payload['update_data'];
                $loginData = $payload['login_data'];

                $ignore = [
                    'prev_user_data',
                    'transfer_check',
                    'user_type',
                    'editfor',
                    'note'
                ];

                /* =========================
                FETCH CURRENT DATA
                ========================= */

                $stmt = $conn->prepare("SELECT * FROM $table WHERE $identifier_column=:id");
                $stmt->execute([':id'=>$identifier_id]);
                $current_data = $stmt->fetch(PDO::FETCH_ASSOC);

                if(!$current_data){
                    throw new Exception("User not found in main table");
                }

                $set = [];
                $params = [];
                $changes = [];

                foreach ($data as $key=>$value) {

                    if(in_array($key,$ignore)) continue;

                    $old_value = $current_data[$key] ?? null;

                    if($old_value != $value){
                        $changes[]=[
                            'column'=>$key,
                            'old'=>$old_value,
                            'new'=>$value
                        ];
                    }

                    $set[]="$key=:$key";
                    $params[$key]=$value;
                }

                $params['id']=$identifier_id;


                /* =========================
                UPDATE MAIN TABLE
                ========================= */

                if(!empty($set)){
                    $sql="UPDATE $table SET ".implode(',',$set)." WHERE $identifier_column=:id";
                    $stmt=$conn->prepare($sql);
                    $stmt->execute($params);
                }


                /* =========================
                INSERT FIELD EDIT LOGS
                ========================= */

                if(!empty($changes)){

                    $stmtLog=$conn->prepare("
                        INSERT INTO field_edit_logs
                        (table_name,record_id,column_name,old_value,new_value,changed_by,change_reason,changed_role,ip_address)
                        VALUES
                        (:table_name,:record_id,:column_name,:old_value,:new_value,:changed_by,:change_reason,:changed_role,:ip_address)
                    ");

                    foreach($changes as $change){

                        $stmtLog->execute([
                            ':table_name'=>$table,
                            ':record_id'=>$identifier_id,
                            ':column_name'=>$change['column'],
                            ':old_value'=>$change['old'],
                            ':new_value'=>$change['new'],
                            ':changed_by'=>'1',
                            ':change_reason'=>$reason,
                            ':changed_role'=>'admin',
                            ':ip_address'=>$_SERVER['REMOTE_ADDR'] ?? 'NA'
                        ]);
                    }
                }


                /* =========================
                UPDATE LOGIN TABLE
                ========================= */

                if(!empty($loginData)){
                    $sql="UPDATE login SET username=:username WHERE user_id=:user_id";
                    $stmt=$conn->prepare($sql);
                    $stmt->execute($loginData);
                }


                /* =========================
                UPDATE TRANSFER FLAG
                ========================= */

                $sql="UPDATE $table SET transfer_check=2 WHERE $identifier_column=:id";
                $stmt=$conn->prepare($sql);
                $stmt->execute([':id'=>$identifier_id]);


                /* =========================
                SYSTEM LOG
                ========================= */

                $logData=[
                    'user_id'=>$identifier_id,
                    'title'=>'User Transfer',
                    'message'=>$identifier_id.' transfer approved',
                    'message2'=>'Transfer Approved',
                    'reference_no'=>'NA',
                    'register_by'=>'1',
                    'from_whom'=>'1',
                    'operation'=>'Transfer Approved'
                ];

                insertLog($conn,$logData);
            }


            /* =========================
            REJECT TRANSFER
            ========================= */

            else if($status == 3){

                $sql="UPDATE $table SET transfer_check=0 WHERE $identifier_column=:id";
                $stmt=$conn->prepare($sql);
                $stmt->execute([':id'=>$identifier_id]);

                $logData=[
                    'user_id'=>$identifier_id,
                    'title'=>'User Transfer',
                    'message'=>$identifier_id.' transfer rejected',
                    'message2'=>'Transfer Rejected',
                    'reference_no'=>'NA',
                    'register_by'=>'1',
                    'from_whom'=>'1',
                    'operation'=>'Transfer Rejected'
                ];

                insertLog($conn,$logData);
            }


            /* =========================
            UPDATE TRANSFER TABLE
            ========================= */

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