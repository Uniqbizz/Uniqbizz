<?php 
// session_start();
require '../../connect.php';

    date_default_timezone_set('Asia/Calcutta');
    $today = date('Y-m-d H:i:s');

    $id= $_POST["id"];

    $package = $conn->prepare("UPDATE package SET status=:status,deleted_at=:deleted_at WHERE id = '".$id."'");
    $result = $package->execute([
                        ':status' => "0",
                        ':deleted_at' => $today
                    ]);

    //get package name
    $package_details = $conn->prepare("SELECT * from package  WHERE id = '".$id."'");
    $package_details->execute();
    $get_package_name = $package_details->fetch(); 
    $get_package_name = $get_package_name["name"];

    if($result){
        $message = "Removed ".$get_package_name."package from list.";

        //new logs update
        $sql2= "INSERT INTO logs (title,message,message2, reference_no, register_by, from_whom) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom)";
        $stmt =$conn->prepare($sql2);

        $result=$stmt->execute(array(
            ':title' => "Deleted Package",
            ':message' => $message,
            ':message2' => $message,
            ':reference_no' => "1",
            ':register_by' =>"1",
            ':from_whom' => "1"
        ));

        echo "success";
    }else{
        echo "fail";
	}

// Delete Query Empty Records
    // $package = $conn->prepare("DELETE FROM package WHERE id = '".$id."'");
    // $result = $package->execute(array());

    // $itinerary = $conn->prepare("DELETE FROM package_itinerary_details WHERE package_id = '".$id."'");
    // $itinerary->execute(array()); 

    // $days = $conn->prepare("DELETE FROM package_trip_days WHERE package_id = '".$id."'");
    // $days->execute(array()); 

    // $price = $conn->prepare("DELETE FROM package_pricing WHERE package_id = '".$id."'");
    // $price->execute(array()); 

    // // $sql_5 = 'SELECT * FROM package_pictures (package_id,image) VALUES(:package_id,:image)';
    // // $statement_5 = $conn->prepare($sql_5);
    
    // // foreach ( $mydata['images'] as $key => $image) 
    // // {

    // // unlink('/var/www/test/folder/images/image_name.jpeg'); 
    // $pictures = $conn->prepare("DELETE FROM package_pictures WHERE package_id = '".$id."'");
    // $pictures->execute(array()); 

    // $occupancy = $conn->prepare("DELETE FROM package_to_category_occupancy WHERE package_id = '".$id."'");
    // $occupancy->execute(array()); 

    // $vehicle = $conn->prepare("DELETE FROM package_to_category_vehicle WHERE package_id = '".$id."'");
    // $vehicle->execute(array()); 

?>