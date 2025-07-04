<?php

    require '../connect.php';

    $designation_name = $_POST['desig_name'];
    $dept_id = $_POST['dept_id'];
    // $dept_name = $_POST['dept_name'];
    $status = '1';

    $stmt2 = $conn->prepare( " SELECT * FROM  `department` WHERE id = '".$dept_id."' AND status = '1' " );
    $stmt2 -> execute();
    $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
        foreach( ($stmt2 -> fetchAll()) as $key2 => $row2 ){
            $dept_name = $row2['dept_name'];
        }
    }

    $sql = "INSERT INTO `designation` (designation_name	,dept_id,dept_name,status) VALUES (:designation_name,:dept_id,:dept_name,:status)";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute(array(
        ':designation_name' =>  $designation_name,
        ':dept_id' => $dept_id,
        ':dept_name' => $dept_name,
        ':status' => $status
    ));

    if($result){
        echo 1;
    }else{
        echo 0;
    }
?>