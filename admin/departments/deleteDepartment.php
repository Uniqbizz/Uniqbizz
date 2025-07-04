<?php

    require '../connect.php';

    $id = $_POST['id'];
    $deptName = $_POST['name'];
    $message = $_POST['message'];
    $status = $_POST['status'];

    $sql = "UPDATE `department` SET status=:status WHERE id=:id ";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute(array(
        ':status' => $status,
        ':id' => $id
    ));

    if($result){
        echo 1;
    }else{
        echo 0;
    }

?>