<?php
// session_start();
require '../connect.php';

$sub_category_name=$_POST['name'];
$description=$_POST['description'];
$picture=$_POST['picture'];
$category_id=$_POST['category'];

 $title="Sub Category";
$message=$sub_category_name." sub category has be added" ;
$message2=$sub_category_name." sub category has be added";
$fromWhom="1";


$sql= "INSERT INTO subcategory (sub_category_name,description, picture,category_id) VALUES (:sub_category_name ,:description, :picture,:category_id)";
$stmt3 =$conn->prepare($sql);

$result2=$stmt3->execute(array(
':sub_category_name' => $sub_category_name, 
':description' => $description, 
':picture' => $picture,
':category_id'=>$category_id
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