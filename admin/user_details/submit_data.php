<?php
session_start();
require '../connect.php';
$username=$_POST['username'];
$password=$_POST['password'];


$stmt = $conn->prepare("SELECT * FROM login where username='".$username."' AND password='".$password."' AND user_id='ADACCESS' ");
$stmt->execute();
// set the resulting array to associative
$stmt->setFetchMode(PDO::FETCH_ASSOC);
if($stmt->rowCount()>0){
	$row = $stmt->fetch();
	
	if ( $row['username'] ) {
		$_SESSION["user_details_access_id"] = $row['username'];
		echo '1';
	}else{
		$_SESSION["user_details_access_id"] = '0';
		echo '0';
	}
}

?>