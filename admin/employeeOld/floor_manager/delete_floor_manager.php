<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s' );

require "../../connect.php";

$bm_id= $_POST["bm_id"];
$action= $_POST["action"];
$id= $_POST["id"];
$user_type="5";

if($action == 'pending'){
	$sm_id = ""; //set Floor Manager id to empty
	$status= '0';
}else if($action == 'registered') {
	$sm_id = $_POST["smid"]; //Floor Manager id
	$status= '3';
}else if($action == 'deactivate') {
	$sm_id = $_POST["smid"];
	$status= '1';  // activate
	$today = NULL;
}else if($action == 'deleted') {
	$sm_id = '';
	$status= '2';  // activate for lead
	$today = NULL;
}


// $status= '0';
 $title="Sales Manager";
if($sm_id ==''){
	$message="Deleted Sales Manager from ".$action. " list";
	$message2="Deleted Sales Manager from ".$action. " list";
}else{
	$message="Deleted Sales Manager(".$sm_id.") from ".$action. " list";
	$message2="Deleted Sales Manager(".$sm_id.") from ".$action. " list";
}

$fromWhom="1";
$register_by="6";


	$sql1 = "UPDATE sales_manager SET status=:status, deleted_date=:deleted_date WHERE id=:id";
	$stmt = $conn->prepare($sql1);
	$result=  $stmt->execute(array(
		':status' => $status,
		':deleted_date' => $today,
		':id' => $id		
	));
	
	if(isset($_POST["smid"])){
		$sales_manager_id= $_POST["smid"];
	
		$sql2 = "UPDATE login SET status=:status WHERE user_id=:sales_manager_id and user_type_id=:user_type";
		$stmt2 = $conn->prepare($sql2);
		$result2=  $stmt2->execute(array(
			':status' => $status,
			':user_type' => $user_type,
			':sales_manager_id' => $sales_manager_id		
		));

	if ($result) {

		$sql3= "INSERT INTO logs (title,message,message2, reference_no, register_by, from_whom) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom)";
		$stmt3 =$conn->prepare($sql3);

		$result3=$stmt3->execute(array(
		':title' => $title,
		':message' => $message,
		':message2' =>$message2,
		':reference_no' => $bm_id,
		':register_by' => $register_by,
		':from_whom' => $fromWhom
		));

		if($result3){
			echo $status;
		}else{
			echo $status	;
		}
		// echo 1;

	}
	else{
		echo $status;
	}
} else if ($result2) {
		echo $status;

	}
	else{
		echo $status;
	}



	


?>