<?php 

    if($userType == '11'){ //travel_consultant
        $userIdCommi = 'ta_id';
        $amtCal = 'ta_markup + ta_amt';
    }elseif($userType == '16' || $userType == '29'){ //Techno Enterprise/ corporate agency/Franchisee
        $userIdCommi = 'te_id';
        $amtCal = 'te_amt';
    }elseif($userType == '10'){ //customer
        $userIdCommi = 'cu1_id';
        $amtCal = 'cu1_amt';
    }elseif($userType == '26' || $userType == '28' || $userType=='30'){//business Mentor/Master Franchisee/Sponsor Franchisee
        $userIdCommi = 'bm_id';
        $amtCal = 'bm_amt';
    }elseif($userType == '25' || $userType == '31'){// business Development manager
        $userIdCommi = 'bdm_id';
        $amtCal = 'bdm_amt';
    }elseif($userType == '24'){ // business channel manager
        $userIdCommi = 'bch_id';
        $amtCal = 'bch_amt';
    }

    $previousPayout = $conn -> prepare("SELECT SUM(($amtCal)) as previousPayout FROM product_payout WHERE $userIdCommi = '".$userId."' AND YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ");
    $previousPayout -> execute();
    $previousPayout -> setFetchMode(PDO::FETCH_ASSOC);
    if($previousPayout -> rowCount()>0){
        foreach(($previousPayout -> fetchAll()) as $key => $row){
            $previousPayout = $row['previousPayout'];
            $previousPayoutTDS = $previousPayout * $tdsPercentage;
            $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
            $truncatedPrevAmount = floor($TotalpreviousPayout * 100) / 100;
            echo'<p class="fs-5 fw-bolder mt-n2">Rs. ' .number_format($truncatedPrevAmount,2). '/- <span class="badge bg-success fw-bold ms-4">Paid</span> </p>';
        }
    }
?>