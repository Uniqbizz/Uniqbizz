<?php
require '../../connect.php';

// get Row data
$getdata = stripslashes(file_get_contents("php://input"));
// json Decoding, true -> for getting data in associative manner
$data = json_decode($getdata, true);
// print_r($data);

$ta_id = $data['ta_id'];
$package_id = $data['package_id'];
$product_price_adult = (float)$data['product_price_adult'];
$product_price_child = (float)$data['product_price_child'];
$markup_price = (float)$data['markup'];
$total_adult = $product_price_adult + $markup_price;
$total_child = $product_price_child;

$markup_data = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id='" . $ta_id . "' AND package_id='" . $package_id . "' ");
$markup_data->execute();
$markup = $markup_data->fetch();
// print_r($markup);

if ($markup) {
    //  update
    $status = "2";
    $sql = "UPDATE package_markup_travelagent SET markup=:markup,selling_price_adult=:total_adult,selling_price_child=:total_child, status=:status WHERE travelagent_id='" . $ta_id . "' AND package_id='" . $package_id . "' ";
    $stmt = $conn->prepare($sql);
    $result =  $stmt->execute(array(
        ':markup' => $markup_price,
        'total_adult' => $total_adult,
        'total_child' => $total_child,
        ':status' => $status
    ));
    if ($result) {
        echo 2;
    } else {
        echo 0;
    }
} else {
    // create
    $sql = "INSERT INTO package_markup_travelagent (travelagent_id, package_id, markup, selling_price_adult,selling_price_child) VALUES (:ta_id ,:package_id, :markup, :total_adult, :total_child)";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute(array(
        ':ta_id' => $ta_id,
        ':package_id' => $package_id,
        ':markup' => $markup_price,
        'total_adult' => $total_adult,
        'total_child' => $total_child,
    ));
    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
}
