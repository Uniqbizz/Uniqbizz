<?php
require '../connect.php';

$subcatid=$_POST['subcatid'];
$sub_category_name=$_POST['name'];
$category=$_POST['category'];
$description=$_POST['description'];
$picture=$_POST['picture'];

 $title="Sub Category";
$message=$sub_category_name." sub category has be edited" ;
$message2=$sub_category_name." sub category has be edited";
$fromWhom="1";


$sql1 = "UPDATE subcategory SET sub_category_name=:sub_category_name,description=:description,picture=:picture,category_id=:category WHERE id='".$subcatid."'";
	$stmt = $conn->prepare($sql1);
	$result=  $stmt->execute(array(
		':sub_category_name' => $sub_category_name, 
		':description' => $description, 
		':picture' => $picture,
		':category' => $category
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