<?php

    require '../connect.php';

    $deptName = $_POST['name'];
    $status = '1';

    $sql = "INSERT INTO `department` (dept_name,status) VALUES (:dept_name,:status)";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute(array(
        ':dept_name' => $deptName,
        ':status' => $status
    ));

    if($result){
        echo 1;
    }else{
        echo 0;
    }
?>