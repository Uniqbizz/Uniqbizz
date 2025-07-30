<?php

    require '../connect.php';

    $id = $_POST['id'];
    $desig_name = $_POST['desig_name'];
    $dept_id = $_POST['dept_id'];
    $sept_name = $_POST['dept_name'];
    $message = $_POST['message'];
    $status = $_POST['status'];

    $sql = "UPDATE `designation` SET status=:status WHERE id=:id ";
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