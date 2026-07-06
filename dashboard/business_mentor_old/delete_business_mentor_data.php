<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s' );

require "../connect.php";

$f_id= $_POST["fid"];
$id= $_POST["id"];
$user_type=$f_id_str == 'BM'? '26':($f_id_str == 'MF'?'28':($f_id_str == 'SF'?'30':'NA'));
$userId = $_POST['userId']; //BH250001
$userType = $_POST['userType']; //24
$f_id_str=substr($f_id,0,2);
$status;
$action= $_POST["action"];

if($action == 'pending'){
	$ta_id = ""; //set business_mentor id to empty
    $identifier_name = 'id=';
	$status= '0';
	$operation = "deleted";
}else if($action == 'registered') {
	$ta_id = $_POST["fid"]; //set business_mentor id
    $identifier_name = $f_id_str == 'BM'? 'business_mentor_id=':($f_id_str == 'MF'?'master_franchisee_id=':($f_id_str == 'SF'?'sponsor_franchisee_id=':'NA'));
	$status= '3';
	$operation = "deactivated";
} else if($action == 'deactivate') {
	$ta_id = $_POST["fid"]; //set business_mentor id
    $identifier_name = $f_id_str == 'BM'? 'business_mentor_id=':($f_id_str == 'MF'?'master_franchisee_id=':($f_id_str == 'SF'?'sponsor_franchisee_id=':'NA'));
	$status= '1';					// activate user
	$today = null;
	$operation = "activated";
} else if($action == 'deleted') {
	$ta_id = ""; //set business_mentor id
    $identifier_name = $f_id_str == 'BM'? 'business_mentor_id=':($f_id_str == 'MF'?'master_franchisee_id=':($f_id_str == 'SF'?'sponsor_franchisee_id=':'NA'));
	$status= '2';					// activate user
	$today = null;
	$operation = "pending";
}


 $title= $f_id_str == 'BM'? 'Business Mentor':($f_id_str == 'MF'?'Master Franchisee':($f_id_str == 'SF'?'Sponsor Franchisee':'NA'));
 $table= $f_id_str == 'BM'? 'business_mentor':($f_id_str == 'MF'?'master_franchisee':($f_id_str == 'SF'?'sponsor_franchisee':'NA'));
if($ta_id ==''){
	$message="Deleted ".$title." from ".$action. " list";
	$message2="Deleted ".$title." from ".$action. " list";
}else{
	$message="Deleted ".$title." (".$ta_id.") from ".$action. " list";
	$message2="Deleted ".$title." (".$ta_id.") from ".$action. " list";
}

$fromWhom=$userType;
$register_by=$userType; 

$sql1 = "UPDATE ".$table." SET status=:status, deleted_date=:deleted_date WHERE id='".$id."' ";
$stmt = $conn->prepare($sql1);
$result=  $stmt->execute(array(
	':status' => $status,
	':deleted_date' => $today	
));

if(isset($_POST["fid"])){
	$business_mentor_id= $_POST["fid"];

	$sql2 = "UPDATE login SET status=:status WHERE user_id=:business_mentor_id and user_type_id=:user_type";
	$stmt2 = $conn->prepare($sql2);
	$result2=  $stmt2->execute(array(
		':status' => $status,
		':user_type' => $user_type,
		':business_mentor_id' => $business_mentor_id		
	));

	if ($result2) {
		$sql3= "INSERT INTO logs (title,message,message2, reference_no, register_by, from_whom, operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
		$stmt3 =$conn->prepare($sql3);

		$result3=$stmt3->execute(array(
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			':reference_no' => $userId,
			':register_by' => $register_by,
			':from_whom' => $fromWhom,
			':operation' => $operation
		));

		if($result3){
			echo $status;
		}else{
			echo $status;
		}
	} else{
		echo $status;
	}
} else if ($result) {
	echo $status;
}else{
	echo $status;
}

?>