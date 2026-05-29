<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s' );

require "../connect.php";

// $f_id= $_POST["refid"];
$id= $_POST["id"];
$usrtype = $_POST['usertype'];
$user_type=$usrtype == 'tc'? "11" : ($usrtype == 'ibr' ? '33' :'');

$status;
$action= $_POST["action"];

if($action == 'pending'){
	$ta_id = ""; //set travel agent id to empty
    $identifier_name = 'id=';
	$status= '0';
}else if($action == 'registered') {
	$ta_id = $_POST["refid"]; //set travel agent id
    $identifier_name = $user_type == '11' ? 'ca_travelagency_id=' : ($user_type == '33' ? 'institution_branch_manager_id' : '') ;
	$status= '3';
} else if($action == 'deactivate') {
	$ta_id = $_POST["refid"]; //set travel agent id
    $identifier_name = $user_type == '11' ? 'ca_travelagency_id=' : ($user_type == '33' ? 'institution_branch_manager_id' : '');
	$status= '1';					// activate user
	$today = null;
} else if($action == 'deleted') {
	$ta_id = ""; //set travel agent id
    $identifier_name = $user_type == '11' ? 'ca_travelagency_id=' : ($user_type == '33' ? 'institution_branch_manager_id' : '');
	$status= '2';					// activate user
	$today = null;
}


 $title=$user_type == '11' ? "Travel Consultant" : ($user_type == '33' ? 'Institution Branch Manager' : '');
if($ta_id ==''){
	$message="Deleted $title from ".$action. " list";
	$message2="Deleted $title from ".$action. " list";
}else{
	$message="Deleted $title(".$ta_id.") from ".$action. " list";
	$message2="Deleted $title(".$ta_id.") from ".$action. " list";
}

$fromWhom="1";
$register_by="1"; 
$operation ="Delete";
$table_name=$user_type == '11' ? 'ca_travelagency' : ($user_type == '33' ? 'institution_branch_manager' : '');
$sql1 = "UPDATE $table_name SET status=:status, deleted_date=:deleted_date WHERE id='".$id."' ";
$stmt = $conn->prepare($sql1);
$result=  $stmt->execute(array(
	':status' => $status,
	':deleted_date' => $today	
));

if(isset($_POST["refid"])){
	$business_consultant_id= $_POST["refid"];

	$sql2 = "UPDATE login SET status=:status WHERE user_id=:business_consultant_id and user_type_id=:user_type";
	$stmt2 = $conn->prepare($sql2);
	$result2=  $stmt2->execute(array(
		':status' => $status,
		':user_type' => $user_type,
		':business_consultant_id' => $business_consultant_id		
	));

	if ($result2) {
		$sql3= "INSERT INTO logs (user_id,title,message,message2, reference_no, register_by, from_whom,operation) VALUES (:user_id,:title ,:message, :message2, :reference_no, :register_by, :from_whom,:operation)";
		$stmt3 =$conn->prepare($sql3);

		$result3=$stmt3->execute(array(
			':user_id' => $business_consultant_id,
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			':reference_no' => $id,
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