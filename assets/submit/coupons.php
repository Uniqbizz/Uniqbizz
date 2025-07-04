<?php

require '../../connect.php';

    $coupon_type = substr($_POST['coupon_code'],0,1);
    
    $data = $conn->prepare("SELECT * FROM coupons WHERE code = '".$_POST['coupon_code']."'");
    $data->execute();
    $data->setFetchMode(PDO::FETCH_ASSOC);
    $coupons = $data->fetch();

    if ( $coupons ) {
        if ( $coupons['status'] != "0" ) {
            $data1 = $conn->prepare("SELECT * FROM club WHERE id = '".$coupons['club_id']."'");
            $data1->execute();
            $price = $data1->fetch();
            $amount = $price['amount'];
            if ( $coupon_type == 'P' && $amount == 10000 ) {
                echo $amount/2;
            } else {
                echo $amount;
            }
        }else {
            echo "used";
        }
    } else {
        echo "invalid";
    }
    

?>