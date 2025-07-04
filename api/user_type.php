<?php
require 'connect.php';
 
header('Content-Type:application/json');
 
$stmt = $conn->prepare("SELECT * FROM user_type");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
if($stmt->rowCount()>0){
    $data = $stmt->fetchAll();
 
    $json_data = json_encode(['status'=>'true', 'result'=>'found', 'data'=>$data]);
    echo $json_data;
    // print_r($json_data);
 
} else {
    $json_data = json_encode(['status'=>'true', 'result'=>'empty', 'data'=>'Not found']);
    echo $json_data;
 
}
 
?>