<?php
// session_start();
require '../connect.php';

$category_name=$_POST['name'];
$description=$_POST['description'];
$picture=$_POST['picture'];


 $title="Category";
$message=$category_name." category has be added" ;
$message2=$category_name." category has be added";
$fromWhom="1";


$sql= "INSERT INTO category (category_name,description, picture) VALUES (:category_name ,:description, :picture)";
$stmt3 =$conn->prepare($sql);

$result2=$stmt3->execute(array(
':category_name' => $category_name, 
':description' => $description, 
':picture' => $picture
));

if($result2){
	$sql2= "INSERT INTO logs (title,message,message2, from_whom) VALUES (:title ,:message, :message2, :from_whom)";
	$stmt =$conn->prepare($sql2);

	$result=$stmt->execute(array(
	':title' => $title,
	':message' => $message,
	':message2' =>$message2,
	':from_whom' => $fromWhom
	));	
	if($result){
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