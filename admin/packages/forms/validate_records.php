<?php
require '../../connect.php';

// get Row data
    $type = $_POST['type'];
    $value = $_POST['value'];

    $data = $conn->prepare("SELECT * FROM package WHERE $type = '".$value."' ");
    $data->execute();
    $value = $data->fetch();

    if ($value) {
            echo "success";
        }else{
            echo "fail";
    }

?>