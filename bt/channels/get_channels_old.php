<?php
require '../connect.php';
$userId = $_POST["user_id"];

    echo '<div class="accordion-box" id="display-accordian" style="padding-bottom:30px">
            <h5 class="gray sticky-h">Referrals 
                <a id="closee" href="#" onclick="closeBtn()" style="color:white; float:right; font-weight:600;">X</a>
            </h5>';

        $stmt_l1 = getSqlQuery($conn, $userId );
        if($stmt_l1->rowCount()>0){
            foreach ($stmt_l1->fetchAll() as $key1 => $row1) {
                $count_refs = getSqlQuery($conn,  $row1['cust_id']);
                $count_ref = $count_refs->rowCount();
                // <!-- level 1 -->
                echo '<button class="accordion sup-level" onclick="showPannel(this); return false;">
                        <div class="flex-container">
                            <div>L1 - '.$row1['cust_id'].' - '.$row1['firstname'].' '.$row1['lastname'].' ('.$count_ref.')</div>
                            <div>'.date_ddmmyy($row1['register_date']).'</div>
                        </div>
                    </button>
                    <div class="panel">';
                //fetch level 2 data    
                $stmt_l2 = getSqlQuery($conn, $row1['cust_id']);
                if($stmt_l2->rowCount()>0){
                    foreach ($stmt_l2->fetchAll() as $key => $row2) {
                        $count_refs = getSqlQuery($conn, $row2['cust_id']);
                        $count_ref = $count_refs->rowCount();
                        // <!-- level 2 -->
                        echo '<button class="accordion sup-level" onclick="showPannel(this); return false;">
                                <div class="flex-container">
                                    <div>L2 - '.$row2['cust_id'].' - '.$row2['firstname'].' '.$row2['lastname'].' ('.$count_ref.')</div>
                                    <div>'.date_ddmmyy($row2['register_date']).'</div>
                                </div>
                            </button>
                            <div class="panel">';
                        //fetch level 3 data
                        $stmt_l3 = getSqlQuery($conn, $row2['cust_id']);
                        if($stmt_l3->rowCount()>0){
                            foreach ($stmt_l3->fetchAll() as $key => $row3) {
                                $count_refs = getSqlQuery($conn, $row3['cust_id']);
                                $count_ref = $count_refs->rowCount();
                                // <!-- level 3 -->
                                echo '<button class="accordion sup-level" onclick="showPannel(this); return false;">
                                        <div class="flex-container">
                                            <div>L3 - '.$row3['cust_id'].' - '.$row3['firstname'].' '.$row3['lastname'].' ('.$count_ref.')</div>
                                            <div>'.date_ddmmyy($row3['register_date']).'</div>
                                        </div>
                                    </button>
                                    <div class="panel">';
                                //fetch level 4 data
                                $stmt_l4 = getSqlQuery($conn, $row3['cust_id'] );
                                if($stmt_l4->rowCount()>0){
                                    foreach ($stmt_l4->fetchAll() as $key => $row4) {
                                        $count_refs = getSqlQuery($conn, $row4['cust_id']);
                                        $count_ref = $count_refs->rowCount();
                                        // <!-- level 4 -->
                                        echo '<button class="accordion sup-level" onclick="showPannel(this); return false;">
                                                <div class="flex-container">
                                                    <div>L4 - '.$row4['cust_id'].' - '.$row4['firstname'].' '.$row4['lastname'].' ('.$count_ref.')</div>
                                                    <div>'.date_ddmmyy($row4['register_date']).'</div>
                                                </div>
                                            </button>
                                            <div class="panel">';
                                        //fetch level 5 data
                                        $stmt_l5 = getSqlQuery($conn, $row4['cust_id']);
                                        if($stmt_l5->rowCount()>0){
                                            foreach ($stmt_l5->fetchAll() as $key => $row5) {
                                                $count_refs = getSqlQuery($conn, $row5['cust_id']);
                                                $count_ref = $count_refs->rowCount();
                                                // <!-- level 5 -->
                                                echo '<button class="accordion sup-level" onclick="showPannel(this); return false;">
                                                        <div class="flex-container">
                                                            <div>L5 - '.$row5['cust_id'].' - '.$row5['firstname'].' '.$row5['lastname'].' ('.$count_ref.')</div>
                                                            <div>'.date_ddmmyy($row5['register_date']).'</div>
                                                        </div>
                                                    </button>';
                                            }
                                        }
                                        echo '</div>';
                                    }
                                }
                                echo '</div>';
                            }
                        }
                        echo '</div>';
                    }
                }
                echo '</div>';
            }
        } else {
        echo '<button class="accordion sup-level" onclick="return false;" >
                <div class="flex-container">
                    <div>No Customers Found</div>
                </div>
            </button>';
        }
    echo '</div>';

    // 2nd dropdown
    $user_id = substr($userId,0,2);
    if($user_id == "TA"){

        // Direct Corporate partner of Business Consultant
        $stmt = $conn->prepare("SELECT * FROM super_franchisee WHERE reference_no = ? AND status='1'");
        $stmt->execute([$userId]);
        $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Render the HTML accordion box
        echo '<div class="accordion-box" id="display-accordian" style="padding-bottom:30px">
                <h5 class="gray sticky-h">Direct Corporate Partners of Business Consultant  
                    <a id="closee" href="#" onclick="closeBtn()" style="color:white; float:right; font-weight:600;">X</a>
                </h5>';

        foreach ($referrals as $referral) {
            // Render the user button
            echo '<button class="accordion sup-level" onclick="showPannel(this); return false;">
                    <div class="flex-container">
                        <div>'. $referral['super_franchisee_id'] .' '. $referral['firstname'] .' '. $referral['lastname'] .' ('. $referral['business_package'] .' - '. $referral['amount'] .')</div>
                        <div>'. date_ddmmyy($referral['register_date']) .'</div>
                    </div>
                </button>
                <div class="panel">';
                // Close the user panel
            echo '</div>';
        }

        // Close the accordion box
        echo '</div>';


        // 3rd Dropdown
        // Retrieve referrals for a given user ID
        $stmt2 = $conn->prepare("SELECT * FROM business_trainee WHERE reference_no = ? AND status='1'");
        $stmt2->execute([$userId]);
        $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // Render the HTML accordion box
        echo '<div class="accordion-box" id="display-accordian" style="padding-bottom:30px">
                <h5 class="gray sticky-h">Corporate Partner Through Business Trainee 
                    <a id="closee" href="#" onclick="closeBtn()" style="color:white; float:right; font-weight:600;">X</a>
                </h5>';

        foreach ($referrals as $referral) {

            $userBT = $referral['business_trainee_id'];
            $stmt3 = $conn->prepare("SELECT count(super_franchisee_id) as totalsuper_franchisee FROM super_franchisee where reference_no = ? and status='1' ");
            $stmt3->execute([$userBT]);
            $stmt3->setFetchMode(PDO::FETCH_ASSOC);

            if($stmt3->rowCount()>0){
                foreach (($stmt3->fetchAll()) as $key => $row) {
                    $totalsuper_franchisee=$row['totalsuper_franchisee'];
                }
            }
            // Render the user button
            echo '<button class="accordion sup-level" onclick="showPannel(this); return false;">
                    <div class="flex-container">
                        <div>'. $referral['business_trainee_id'] .' '. $referral['firstname'] .' '. $referral['lastname'] .' ('.$totalsuper_franchisee.')</div>
                        <div>'. date_ddmmyy($referral['register_date']) .'</div>
                    </div>
                </button>
                <div class="panel">';

            // Retrieve referrals for the current user
            $stmt4 = $conn->prepare("SELECT * FROM super_franchisee WHERE reference_no = ?");
            $stmt4->execute([$referral['business_trainee_id']]);
            $subReferrals = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($subReferrals as $subReferral) {
        
                // Render the sub-user button
                echo '<button class="accordion sup-level" onclick="showPannel(this); return false;">
                        <div class="flex-container">
                            <div>'. $subReferral['super_franchisee_id'] .' '. $subReferral['firstname'] .' '. $subReferral['lastname'] .' ('. $subReferral['business_package'] .' - '. $subReferral['amount'] .')</div>
                            <div>'. date_ddmmyy($subReferral['register_date']) .'</div>
                        </div>
                    </button>
                    <div class="panel">
                        <!-- Render additional information for the sub-user here -->
                    </div>';
            }

            // Close the user panel
            echo '</div>';
        }

        // Close the accordion box
        echo '</div>';
    }else if($user_id == "BT"){
        // Retrieve referrals for a given user ID
        $stmt = $conn->prepare("SELECT * FROM super_franchisee WHERE reference_no = ?");
        $stmt->execute([$userId]);
        $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Render the HTML accordion box
        echo '<div class="accordion-box" id="display-accordian" style="padding-bottom:30px">
                <h5 class="gray sticky-h">Business Trainee Corporate Partners  
                    <a id="closee" href="#" onclick="closeBtn()" style="color:white; float:right; font-weight:600;">X</a>
                </h5>';

        foreach ($referrals as $referral) {
            // Render the user button
            echo '<button class="accordion sup-level" onclick="showPannel(this); return false;">
                    <div class="flex-container">
                        <div>'. $referral['super_franchisee_id'] .' '. $referral['firstname'] .' '. $referral['lastname'] .' ('. $referral['business_package'] .' - '. $referral['amount'] .')</div>
                        <div>'. date_ddmmyy($referral['register_date']) .'</div>
                    </div>
                </button>
                <div class="panel">';
                // Close the user panel
            echo '</div>';
        }

        // Close the accordion box
        echo '</div>';
    }else{
        '<button class="accordion sup-level" onclick="return false;" >
                <div class="flex-container">
                    <div>No Customers Found</div>
                </div>
            </button>';
    }

   // date format
function date_ddmmyy($date) {
  if ($date == '0000-00-00') {
      return 'Not Defined';
  } else {
      return date("d-M-Y", strtotime($date));
  }
} 
function getSqlQuery($conn,  $user_id) {
  // normal 5+1reward = 6 levels
      $sql = "SELECT cust_id,firstname,lastname,register_date FROM customer WHERE reference_no='".$user_id."' AND status='1' ";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      return $stmt;
}


?>