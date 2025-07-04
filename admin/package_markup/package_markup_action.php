<?php
 
    require '../connect.php';

    $id = $_POST['id'];
    $pid = $_POST['pid'];
    $taid = $_POST['taid'];
    $status = $_POST['status'];

    // echo '<br>' .$id .'<br>';
    // echo $pid.'<br>';
    // echo $taid.'<br>';
    // echo $status.'<br>';

    $stmt = $conn -> prepare("UPDATE package_markup_travelagent SET status=:status WHERE id = '".$id."' AND package_id = '".$pid."' ");
    $result = $stmt -> execute(array(
        ':status' => $status
    ));

    if($result){
        echo '1';
    }else{
        echo '0';
    }

?>