<?php
session_start();
require '../../connect.php';
$username=$_POST['username'];
$password=$_POST['password'];


$stmt = $conn->prepare("SELECT * FROM login where username='".$username."' AND password='".$password."' AND user_id = '1' AND status='1' ");
$stmt->execute();

// set the resulting array to associative
$stmt->setFetchMode(PDO::FETCH_ASSOC);

if($stmt->rowCount()>0){
	foreach (($stmt->fetchAll()) as $key => $row) 
		# code...
		$_SESSION["username"] = $row['username'];
		$_SESSION["user_type_id"] = $row['user_type_id'];
		$_SESSION["user_details_access_id"] = '0';

	if ($_SESSION["user_type_id"] =='1' ){
			echo '1';
		}else{
			echo '0';
		}
	}else{
		echo '0';
	}

	// if(isset($_SESSION["username"])) {
 //    header("Location:index.php");
 //    }


// if ($result->num_rows > 0) {
// 	while($row = $result->fetch_assoc()) {
// 		echo "1";
// 	}
// } else {
// 	echo "0";
// }

?>