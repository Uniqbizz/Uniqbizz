<?php 
    $totalPayout = "SELECT SUM(total_payable) as total_payable FROM ca_ta_payout_paid";
    $Payout = $conn -> prepare($totalPayout);
    $Payout -> execute();
    $Payout -> setFetchMode(PDO::FETCH_ASSOC);
    if($Payout->rowCount()>0){
        foreach(($Payout->fetchAll()) as $key => $row){
            $total_payable = $row["total_payable"] ?? '0';
            echo'
            <p class="fs-5 font fw-bolder mt-n2 icon">Rs.'.$total_payable.'/- </p>
            <span class="badge badge-pill badge-soft-success font-size-10 fw-bold status1" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>
            ';
        }
    }
?>