<?php
require '../../connect.php';

$query = $conn->prepare("SELECT status from quotations where id='".$_POST['id']."' ");
$query->execute();
$result = $query->fetch();

    if( $result['status'] == 0 ){
        $stmt = $conn->prepare("UPDATE quotations SET status='1'  where id='".$_POST['id']."' ");
    }
    else{
        $stmt = $conn->prepare("UPDATE quotations SET status='0'  where id='".$_POST['id']."' ");
    }
    $data = $stmt->execute();


    if($data){
        echo "success";
    }else{
        echo "fail";
    }


        ?>