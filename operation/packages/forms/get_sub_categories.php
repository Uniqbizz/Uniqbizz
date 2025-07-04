<?php

require '../../connect.php';

if ( !empty($_POST['cat_id']) ) {
    
    $data = $conn->prepare("SELECT * FROM subcategory WHERE category_id = '".$_POST['cat_id']."'");
    $data->execute();
    $data->setFetchMode(PDO::FETCH_ASSOC);

    if( $data->rowCount()>0){
        echo '<option value="">--Select Sub Category--</option>';
        foreach (($data->fetchAll()) as $key => $value) {
            echo '<option value="'.$value['id'].'">'.$value['sub_category_name'].'</option>';
        }
    }else{
        echo '<option value="">--No Sub Category Available--</option>';
    }
    
}


?>