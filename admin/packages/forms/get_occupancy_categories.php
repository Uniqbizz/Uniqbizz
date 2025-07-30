<?php

require '../../connect.php';

if ( !empty($_POST['ocup_id']) ) {
    
    $data = $conn->prepare("SELECT * FROM category_occupancy WHERE id = '".$_POST['ocup_id']."'");
    $data->execute();
    $value = $data->fetch();
    
    // print_r($value);
    echo $value['name'];
    
}

?>