<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s' );

require "../connect.php";

$id= $_POST["id"];
$status= '0';

$title="Sub Category";
$message="Category has be deleted" ;
$message2="Category has be deleted";
$fromWhom="1";

	$sql1 = "UPDATE category SET status=:status, deleted_date=:deleted_date WHERE id=:id";
	$stmt = $conn->prepare($sql1);
	$result=  $stmt->execute(array(
		':status' => $status,
		':deleted_date' => $today,
		':id' => $id		
	));

	if($result){
		$sql2= "INSERT INTO logs (title,message,message2, from_whom) VALUES (:title ,:message, :message2, :from_whom)";
	$stmt2 =$conn->prepare($sql2);

	$result2=$stmt2->execute(array(
	':title' => $title,
	':message' => $message,
	':message2' =>$message2,
	':from_whom' => $fromWhom
	));	
	if($result2){
		echo 1;
	}
	else{
	echo 0	;
	}	
		// echo 1;
	}
	else{
		echo 0	;
	}
?>