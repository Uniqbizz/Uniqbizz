<?php 

    require '../connect.php';
    $today = date('Y-m-d H:i:s' );

    $id = $_POST['id'];
	$email = $_POST['email'];
	$status = $_POST['status'];
	$message = $_POST['message'];

    // $sql = "DELETE FROM employees WHERE id = :id";
    // $stmt = $conn->prepare($sql);
    // $result = $stmt->execute(array(
    //     ':id' => $id
    // ));

    // if($result){
    //     echo json_encode(array('success' => 1, 'message' => 'Employee deleted successfully'));
    // }else{
    //     echo json_encode(array('success' => 0, 'message' => 'Employee deletion failed'));
    // }

    $stmt = $conn->prepare("UPDATE employees SET status = :status, deleted_date = :deleted_date WHERE id = :id");
    $result = $stmt -> execute(array(
        ':status' => $status,
        ':deleted_date' => $today,
        ':id' => $id
    ));

    if($result){
        echo $status;
    }else{
        echo '0';
    }

    $conn = null;

?>