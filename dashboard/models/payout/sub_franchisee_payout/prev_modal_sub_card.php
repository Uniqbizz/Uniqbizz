<?php 

    if($userType == '28' || $userType == '30'){ //MF/SF
        $userIdCommi = 'master_franchisee';
        $amtCal = 'commission_mf';
    }

    $previousPayout = $conn -> prepare("SELECT SUM(($amtCal)) as previousPayout FROM sub_franchisee_payout WHERE $userIdCommi = '".$userId."' AND YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ");
    $previousPayout -> execute();
    $previousPayout -> setFetchMode(PDO::FETCH_ASSOC);
    if($previousPayout -> rowCount()>0){
        foreach(($previousPayout -> fetchAll()) as $key => $row){
            $previousPayout = $row['previousPayout'];
            $previousPayoutTDS = $previousPayout * $tdsPercentage;
            $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
            $truncatedPrevAmount = floor($TotalpreviousPayout * 100) / 100;
            echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .number_format($truncatedPrevAmount,2). '/- </p>
            <span class="badge bg-success fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
        }
    }
?>