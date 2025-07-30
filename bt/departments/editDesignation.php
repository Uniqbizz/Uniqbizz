<?php

    require '../connect.php';

    $id = $_POST['id'];
    $desig_name = $_POST['desig_name_save'];
    $dept_id = $_POST['dept_id_save'];
    $message = $_POST['message'];
    $status = $_POST['status'];

    $stmt2 = $conn->prepare( " SELECT * FROM  `department` WHERE id = '".$dept_id."' AND status = '1' " );
    $stmt2 -> execute();
    $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
        foreach( ($stmt2 -> fetchAll()) as $key2 => $row2 ){
            $dept_name = $row2['dept_name'];
        }
    }

    $sql = "UPDATE `designation` SET designation_name=:desig_name,dept_id=:dept_id,dept_name=:dept_name WHERE id=:id ";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute(array(
        ':desig_name' => $desig_name,
        ':dept_id' => $dept_id,
        ':dept_name' => $dept_name,
        ':id' => $id
    ));

    if($result){
        echo 1;
    }else{
        echo 0;
    }
?>