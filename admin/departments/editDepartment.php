<?php

    require '../connect.php';

    $id = $_POST['id'];
    $deptName = $_POST['saveDeptName'];
    $message = $_POST['message'];
    $status = $_POST['status'];

    $sql = "UPDATE `department` SET dept_name=:dept_name WHERE id=:id ";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute(array(
        ':dept_name' => $deptName,
        ':id' => $id
    ));

    if($result){
        echo 1;
    }else{
        echo 0;
    }
?>