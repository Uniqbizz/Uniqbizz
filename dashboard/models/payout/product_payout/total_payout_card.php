<?php 
    if($userType == '11'){ //travel_consultant
        $userIdCommi = 'ta_id';
        $amtCal = 'ta_markup + ta_amt';
    }elseif($userType == '16'|| $userType == '29' || $userType == '32'){ //Techno Enterprise/ corporate agency/Franchisee/Institution
        $userIdCommi = 'te_id';
        $amtCal = 'te_amt';
    }elseif($userType == '10'){ //customer
        $userIdCommi = 'cu1_id';
        $amtCal = 'cu1_amt';
    }elseif($userType == '26'|| $userType == '28' || $userType=='30'){//business Mentor/Master Franchisee/Sponsor Franchisee
        $userIdCommi = 'bm_id';
        $amtCal = 'bm_amt';
    }elseif($userType == '25' || $userType == '31'){// business Development manager
        $userIdCommi = 'bdm_id';
        $amtCal = 'bdm_amt';
    }elseif($userType == '24'){ // business channel manager
        $userIdCommi = 'bch_id';
        $amtCal = 'bch_amt';
    }

    $totalPayout = "SELECT SUM($amtCal) as total_payable FROM product_payout WHERE $userIdCommi = '".$userId."' ";
    $Payout = $conn -> prepare($totalPayout);
    $Payout -> execute();
    $Payout -> setFetchMode(PDO::FETCH_ASSOC);
    if($Payout->rowCount()>0){
        foreach(($Payout->fetchAll()) as $key => $row){
            $total_payable = $row["total_payable"] ?? '0';
            $totalPayoutTDS = $total_payable * $tdsPercentage;
            $TotalPayoutFinal = $total_payable - $totalPayoutTDS;
            $truncatedTotalAmount = floor($TotalPayoutFinal * 100) / 100;
            echo'<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs.'.number_format($truncatedTotalAmount,2).'/-</p>';
        }
    }
?>