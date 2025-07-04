<?php
require '../../connect.php';

$cat_id=$_POST['cat_id'];
$name=$_POST['name'];

$sql1 = "UPDATE category_hotel SET name=:name WHERE id='".$cat_id."'";
	$stmt = $conn->prepare($sql1);
	$result=  $stmt->execute(array(
		':name' => $name 
		
		));
		
// echo $name;

if($result){	
		echo 1;
}
else
{
	echo 0	;
	}

?>