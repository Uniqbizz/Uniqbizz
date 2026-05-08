<?php
require '../connect.php';

$post = $_POST;

$user_type      = $post['user_type'];
$identifier_id  = $post['id'];
$email          = $post['email'] ?? '';

/* =========================
USER TYPE → TABLE MAP
========================= */

function getUserTable($user_type)
{
    $map = [
        24=>'employees',25=>'employees',31=>'employees',
        26=>'business_mentor',27=>'zonal_manager',
        28=>'master_franchisee',29=>'sub_franchisee',30=>'sponsor_franchisee',
        32=>'institution',33=>'institution_branch_manager',
        16=>'corporate_agency',11=>'ca_travelagency',10=>'ca_customer'
    ];
    return $map[$user_type] ?? null;
}

/* =========================
TABLE IDENTIFIER
========================= */

function getIdentifierColumn($table)
{
    $map = [
        'employees'=>'employee_id',
        'business_mentor'=>'business_mentor_id',
        'zonal_manager'=>'zonal_manager_id',
        'master_franchisee'=>'master_franchisee_id',
        'sub_franchisee'=>'sub_franchisee_id',
        'sponsor_franchisee'=>'sponsor_franchisee_id',
        'institution'=>'institution_id',
        'institution_branch_manager'=>'institution_branch_manager_id',
        'corporate_agency'=>'corporate_agency_id',
        'ca_travelagency'=>'ca_travelagency_id',
        'ca_customer'=>'ca_customer_id'
    ];
    return $map[$table] ?? 'id';
}

$table = getUserTable($user_type);
$identifier_name = getIdentifierColumn($table);

/* =========================
DATA PREP
========================= */

$data = $post;
$data['id']=$identifier_id;

$loginData=[
    'username'=>$email,
    'user_id'=>$identifier_id
];

$logData=[
    'user_id'=>$identifier_id,
    'title'=>'User Transfer',
    'message'=>$identifier_id.' Was Transfer Requested',
    'message2'=>$identifier_id.' Was Transfer Requested',
    'reference_no'=>'NA',
    'register_by'=>'1',
    'from_whom'=>'1',
    'operation'=>'User Transfer'
];

$transferData=[
    'prev_user_name'=>$post['prev_user_name'] ?? '',
    'prev_user_email'=>$post['prev_user_email'] ?? '',
    'prev_user_doj'=>$post['prev_user_doj'] ?? '',
    'new_user_name'=>$post['name'] ?? '',
    'new_user_email'=>$email,
    'transfer_user_id'=>$identifier_id
];

$result=user_transfer(
    $conn,$table,$identifier_name,$identifier_id,
    $data,$loginData,$logData,$transferData
);

echo $result ? 1 : 0;


/* =========================
TRANSFER FUNCTION
========================= */

function user_transfer($conn,$table,$identifier_name,$identifier_id,$data,$loginData,$logData,$transferData)
{
    try{

        $conn->beginTransaction();

        /* -------- FILTER DATA -------- */

        $ignore=[
            'table','user_type','prev_user_name',
            'prev_user_email','prev_user_doj','editfor',
            'username','user_id'
        ];

        $updateData=[];

        foreach($data as $key=>$value){

            if(in_array($key,$ignore)) continue;
            if($key=='id') continue;

            $updateData[$key]=$value;
        }

        /* -------- PAYLOAD -------- */

        $payload=[
            'table'=>$table,
            'identifier_column'=>$identifier_name,
            'identifier_id'=>$identifier_id,
            'update_data'=>$updateData,
            'login_data'=>$loginData
        ];

        $transferData['pending_payload']=json_encode($payload);
        $transferData['transfer_status']=1;

        /* -------- INSERT TRANSFER -------- */

        $sql="INSERT INTO transfered_users
        (prev_user_name,prev_user_email,prev_user_doj,new_user_name,new_user_email,
        transfer_user_id,pending_payload,transfer_status)
        VALUES
        (:prev_user_name,:prev_user_email,:prev_user_doj,:new_user_name,:new_user_email,
        :transfer_user_id,:pending_payload,:transfer_status)";

        $stmt=$conn->prepare($sql);
        $stmt->execute($transferData);

        /* -------- FLAG USER -------- */

        $stmt=$conn->prepare("UPDATE $table
                              SET transfer_check=1
                              WHERE $identifier_name=:id");

        $stmt->execute([':id'=>$identifier_id]);

        /* -------- LOG -------- */

        $sqlLog="INSERT INTO logs
        (user_id,title,message,message2,reference_no,register_by,from_whom,operation)
        VALUES
        (:user_id,:title,:message,:message2,:reference_no,:register_by,:from_whom,:operation)";

        $stmt=$conn->prepare($sqlLog);
        $stmt->execute($logData);

        $conn->commit();
        return true;

    }catch(Exception $e){

        $conn->rollBack();
        echo $e->getMessage();
        return false;
    }
}
?>