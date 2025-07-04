<?php
require '../connect.php';

$cat_id=$_POST['cat_id'];
$category_name=$_POST['name'];
$description=$_POST['description'];
$picture=$_POST['picture'];

$title="Category";
$message=$category_name." category has be edited" ;
$message2=$category_name." category has be edited";
$fromWhom="1";

$sql1 = "UPDATE category SET category_name=:category_name,description=:description,picture=:picture WHERE id='".$cat_id."'";
	$stmt = $conn->prepare($sql1);
	$result=  $stmt->execute(array(
		':category_name' => $category_name, 
		':description' => $description, 
		':picture' => $picture
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
else
{
	echo 0	;
	}

?>