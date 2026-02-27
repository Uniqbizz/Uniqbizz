<?php
    require '../../connect.php';
    $date1 = date('Y'); 


    $id = $_GET['vkvbvjfgfikix'];
    $name ="";
    $phone_no = "";
    $email = "";
    $destination = "";
    $days = "";
    $budget = "";
    $date = "";
    $pax = "";
    $package_suggetion = "";
    $status="";

    $stmt = $conn->prepare("SELECT * FROM quotations WHERE id='".$id."' ");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if($stmt->rowCount()>0){
        foreach (($stmt->fetchAll()) as $key => $row) {

            $name = $row['name'];
            $phone_no = $row['phone_no'];
            $email = $row['email'];
            $destination = $row['destination'];
            $days = $row['days'];
            $budget = $row['budget'];

            $sdate = new DateTime($row['date']);
            $date = $sdate->format('d-M-Y');
            $pax_adult = $row['pax_adult'];
            $pax_child = $row['pax_child']??0;
            $pax_infant = $row['pax_infant']??0;
            $package_suggetion = $row['package_suggetion'];

            if($row['status']=="1"){
                $status="Complete";
            }else{
                $status="Pending";
            }
        }
    }else{
        echo "no data found";
    }
?>