<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s' );

require "../connect.php";

// $f_id= $_POST["refid"];
$id= $_POST["id"];
$user_type="16";

$status;
$action= $_POST["action"];

if($action == 'pending'){
	$ta_id = ""; //set corporate_agency id to empty
    $identifier_name = 'id=';
	$status= '0';
}else if($action == 'registered') {
	$ta_id = $_POST["refid"]; //set corporate_agency id
    $identifier_name = 'corporate_agency_id=';
	$status= '3';
} else if($action == 'deactivate') {
	$ta_id = $_POST["refid"]; //set corporate_agency id
    $identifier_name = 'corporate_agency_id=';
	$status= '1';					// activate user
	$today = null;
} else if($action == 'deleted') {
	$ta_id = ""; //set corporate_agency id
    $identifier_name = 'corporate_agency_id=';
	$status= '2';					// activate user
	$today = null;
}


 $title="Techno Enterprise";
if($ta_id ==''){
	$message="Deleted Techno Enterprise from ".$action. " list";
	$message2="Deleted Techno Enterprise from ".$action. " list";
}else{
	$message="Deleted Techno Enterprise(".$ta_id.") from ".$action. " list";
	$message2="Deleted Techno Enterprise(".$ta_id.") from ".$action. " list";
}

$fromWhom="15";
$register_by="15"; 
$operation = "Delete";

$sql1 = "UPDATE corporate_agency SET status=:status, deleted_date=:deleted_date WHERE id='".$id."' ";
$stmt = $conn->prepare($sql1);
$result=  $stmt->execute(array(
	':status' => $status,
	':deleted_date' => $today	
));

if(isset($_POST["refid"])){
	$travel_agent_id= $_POST["refid"];

	$sql2 = "UPDATE login SET status=:status WHERE user_id=:travel_agent_id and user_type_id=:user_type";
	$stmt2 = $conn->prepare($sql2);
	$result2=  $stmt2->execute(array(
		':status' => $status,
		':user_type' => $user_type,
		':travel_agent_id' => $travel_agent_id		
	));

	if ($result2) {
		$sql3= "INSERT INTO logs (title,message,message2, reference_no, register_by, from_whom, operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
		$stmt3 =$conn->prepare($sql3);

		$result3=$stmt3->execute(array(
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			':reference_no' => $f_id,
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