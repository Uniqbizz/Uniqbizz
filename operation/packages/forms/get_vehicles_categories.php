<?php

require '../../connect.php';

if ( !empty($_POST['vehicle_id']) ) {
    
    $data = $conn->prepare("SELECT * FROM category_vehicle WHERE id = '".$_POST['vehicle_id']."'");
    $data->execute();
    $value = $data->fetch();
    
    // print_r($value);
    echo $value['name'];
    
}

?>