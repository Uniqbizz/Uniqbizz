<?php 
    $totalPayout = "SELECT SUM($columnCommision) as total_payable FROM ca_ta_payout WHERE $columnDesignation = '".$userId."'  AND  $columnStatus = '1'";
    $Payout = $conn -> prepare($totalPayout);
    $Payout -> execute();
    $Payout -> setFetchMode(PDO::FETCH_ASSOC);
    if($Payout->rowCount()>0){
        foreach(($Payout->fetchAll()) as $key => $row){
            $total_payable = $row["total_payable"] ?? '0';
            echo'
            <p class="fs-5 font fw-bolder mt-n2 icon">Rs.'.$total_payable.'/- </p>
            <span class="badge bg-success font-size-10 fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>
            ';
        }
    }
?>