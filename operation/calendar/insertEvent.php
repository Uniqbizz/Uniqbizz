<?php
	require '../connect.php';

	$title = $_POST['eventTitle'];
	$date = $_POST['eventDate'];

	$sql = $conn -> prepare(" INSERT INTO events (title, start_date) VALUES (:title, :start_date) ");
	$result = $sql -> execute(array(
		':title' => $title, 
		':start_date' => $date 
	)); 

	if($result){
		echo "1";
	}else{
		echo "0";
	}
?>