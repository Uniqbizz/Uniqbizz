<?php 
    $nextPayout = $conn -> prepare("SELECT SUM(comm_amt) as nextPayout FROM ca_payout WHERE  business_consultant = '".$userId."' AND YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ");
    $nextPayout -> execute();
    $nextPayout -> setFetchMode(PDO::FETCH_ASSOC);
    if($nextPayout -> rowCount()>0){
        foreach(($nextPayout -> fetchAll()) as $key => $row2){
            $nextPayoutTotal = $row2['nextPayout'];
            $nextPayoutTDS = $nextPayoutTotal * 5/100;
            $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;
            echo'<p class="fs-5 fw-bolder mt-n2">Rs.' .round($TotalNextPayout). '/- <span class="badge bg-warning font-size-10 fw-bold ms-4">Pending</span> </p>';
        }
    }
?>