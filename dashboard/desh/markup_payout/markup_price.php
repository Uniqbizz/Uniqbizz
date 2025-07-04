<?php
require '../../connect.php';

// get Row data
$getdata = stripslashes(file_get_contents("php://input"));
// json Decoding, true -> for getting data in associative manner
$data = json_decode($getdata, true);
// print_r($data);

$ta_id = $data['ta_id'];
$package_id = $data['package_id'];
$product_price = (float)$data['product_price'];
$markup_price = (float)$data['markup'];
$total = $product_price + $markup_price;

$markup_data = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id='".$ta_id."' AND package_id='".$package_id."' ");
$markup_data->execute();
$markup = $markup_data->fetch();
// print_r($markup);

if ( $markup ) {
    //  update
    $status = "2";
    $sql = "UPDATE package_markup_travelagent SET markup=:markup,selling_price=:total, status=:status WHERE travelagent_id='".$ta_id."' AND package_id='".$package_id."' ";
    $stmt = $conn->prepare($sql);
    $result =  $stmt->execute(array(
                ':markup' => $markup_price, 
                ':total' => $total,
                ':status' => $status
            ));
    if ( $result ) {
        echo 2;
    } else {
        echo 0;
    }
} else {
    // create
    $sql = "INSERT INTO package_markup_travelagent (travelagent_id, package_id, markup, selling_price) VALUES (:ta_id ,:package_id, :markup, :total)";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute(array(
                    ':ta_id' => $ta_id,
                    ':package_id' => $package_id,
                    ':markup' => $markup_price, 
                    ':total' => $total
                ));
    if ( $result ) {
        echo 1;
    } else {
        echo 0;
    }
}


?>
