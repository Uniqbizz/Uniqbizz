<?php
// session_start();
require '../../connect.php';

$name=$_POST['name'];
$sql= "INSERT INTO category_meal (name) VALUES (:name )";
$stmt3 =$conn->prepare($sql);

$result2=$stmt3->execute(array(
':name' => $name

));

if($result2){	
		echo 1;
}else
{
	echo 0	;
	}

?>