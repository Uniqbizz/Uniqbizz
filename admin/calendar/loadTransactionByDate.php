<?php
include '../connect.php'; // Adjust this path to your DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date'])) {
    $date = $_POST['date'];

    $sql = "
    SELECT 
        login.user_id,
        login.user_type_id,
        login.register_date,
        employees.name AS employee_name,
        employees.profile_pic AS employee_pic,
        corporate_agency.firstname AS ca_firstname,
        corporate_agency.lastname AS ca_lastname,
        corporate_agency.profile_pic AS ca_pic,
        business_mentor.firstname AS bm_firstname,
        business_mentor.lastname AS bm_lastname,
        business_mentor.profile_pic AS bm_pic,
        ca_travelagency.firstname AS ta_firstname,
        ca_travelagency.lastname AS ta_lastname,
        ca_travelagency.profile_pic AS ta_pic,
        ca_customer.firstname AS cu_firstname,
        ca_customer.lastname AS cu_lastname,
        ca_customer.profile_pic AS cu_pic,
        sub_franchisee.firstname AS f_firstname,
        sub_franchisee.lastname AS f_lastname,
        sub_franchisee.profile_pic AS f_pic,
        master_franchisee.firstname AS mf_firstname,
        master_franchisee.lastname AS mf_lastname,
        master_franchisee.profile_pic AS mf_pic,
        sponsor_franchisee.firstname AS sf_firstname,
        sponsor_franchisee.lastname AS sf_lastname,
        sponsor_franchisee.profile_pic AS sf_pic,
        COALESCE(corporate_agency.amount, business_mentor.paid_amount, ca_travelagency.amount,sub_franchisee.amount,master_franchisee.paid_amount,sponsor_franchisee.paid_amount,ca_customer.paid_amount) AS amount,
        COALESCE(corporate_agency.payment_mode, business_mentor.payment_mode, ca_travelagency.payment_mode,sub_franchisee.payment_mode,master_franchisee.payment_mode,sponsor_franchisee.payment_mode,ca_customer.payment_mode) AS payment_mode
    FROM login
    LEFT JOIN corporate_agency ON corporate_agency_id = login.user_id AND corporate_agency.status = 1
    LEFT JOIN business_mentor ON business_mentor_id = login.user_id AND business_mentor.status = 1
    LEFT JOIN ca_travelagency ON ca_travelagency_id = login.user_id AND ca_travelagency.status = 1
    LEFT JOIN employees ON employees.employee_id = login.user_id AND employees.status = 1
    LEFT JOIN ca_customer ON ca_customer_id = login.user_id AND ca_customer.status = 1
    LEFT JOIN sub_franchisee ON sub_franchisee_id = login.user_id AND sub_franchisee.status = 1
    LEFT JOIN master_franchisee ON master_franchisee_id = login.user_id AND master_franchisee.status = 1
    LEFT JOIN sponsor_franchisee ON sponsor_franchisee_id = login.user_id AND sponsor_franchisee.status = 1
    WHERE DATE(login.register_date) = ?
      AND (
            corporate_agency.amount IS NOT NULL 
         OR business_mentor.paid_amount IS NOT NULL 
         OR ca_travelagency.amount IS NOT NULL
         OR ca_customer.paid_amount IS NOT NULL
         OR sub_franchisee.amount IS NOT NULL
         OR master_franchisee.paid_amount IS NOT NULL
         OR sponsor_franchisee.paid_amount IS NOT NULL
      )
    ORDER BY login.register_date DESC
    LIMIT 5";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$date]);
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $output='<div class="card rounded-4">
                <h2 class="fs-4 p-3">Latest Transaction</h2>';
    if (count($transactions) > 0) {
        foreach ($transactions as $row) {
            // Determine name and profile pic
            if (!empty($row['employee_name'])) {
                $fullName = $row['employee_name'];
                $profilePic = $row['employee_pic'];
            } elseif (!empty($row['ca_firstname'])) {
                $fullName = $row['ca_firstname'] . ' ' . $row['ca_lastname'];
                $profilePic = $row['ca_pic'];
            } elseif (!empty($row['bm_firstname'])) {
                $fullName = $row['bm_firstname'] . ' ' . $row['bm_lastname'];
                $profilePic = $row['bm_pic'];
            } elseif (!empty($row['ta_firstname'])) {
                $fullName = $row['ta_firstname'] . ' ' . $row['ta_lastname'];
                $profilePic = $row['ta_pic'];
            }elseif (!empty($row['f_firstname'])) {
                $fullName = $row['f_firstname'] . ' ' . $row['f_lastname'];
                $profilePic = $row['f_pic'];
            }elseif (!empty($row['mf_firstname'])) {
                $fullName = $row['mf_firstname'] . ' ' . $row['mf_lastname'];
                $profilePic = $row['mf_pic'];
            }elseif (!empty($row['sf_firstname'])) {
                $fullName = $row['sf_firstname'] . ' ' . $row['sf_lastname'];
                $profilePic = $row['sf_pic'];
            }elseif (!empty($row['cu_firstname'])) {
                $fullName = $row['cu_firstname'] . ' ' . $row['cu_lastname'];
                $profilePic = $row['cu_pic'];
            } else {
                $fullName = "Unknown";
                $profilePic = "default.png";
            }
        
            $userTypes = [
                16 => "Techno Enterprise",
                10 => "Customer",
                11 => "Travel Consultant",
                24 => "Business Channel Manager",
                25 => "Business Development Manager",
                26 => "Business Mentor",
                29 => "Franchisee",
                28 => "Master Franchisee",
                30 => "Sponsor Franchisee"
            ];
            
            $user_type_id = $row['user_type_id'];
            $designation = isset($userTypes[$user_type_id]) ? $userTypes[$user_type_id] : "Unknown";


            $rdate = (new DateTime($row['register_date']))->format('d-m-Y');
            $TAmt = $row['amount'];
            $CATAmt = "₹" . preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $TAmt);
            $paymentMode = htmlspecialchars($row['payment_mode'] ?? 'Unknown');

            $output .= '
                    <div class="row mx-0">
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2">
                            <div class="profile-pic pb-1" style="position: relative; left: 15px;">
                                <img src="../uploading/' . $profilePic . '" alt="profile pic" class="rounded-circle" width="50px" height="50px">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <div class="name fw-bold">' . $fullName . '</br> <span class="fw-normal fontSizeTransaction">(' . $designation . ')</span></div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 px-0">
                                    <div class="name fw-bold">Transfered</br> <span class="fw-normal fontSizeTransaction">' . $rdate . '</span></div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 px-0">
                                    <div class="name fw-bold text-success">&#8377; ' . $CATAmt . '/-</br> <span class="fw-normal text-dark fontSizeTransaction">' . $paymentMode . '</span></div>
                                </div>
                            </div>
                        </div>
                        <hr />
                    </div>
            ';
        }
        $output .=' <div class="col-md-12 col-sm-12 col-12 pb-3 pe-3">
                        <a href="latest_transaction/latest_transaction.php"><button class="cpn_btn box-btn float-end">View More</button></a>
                    </div>';
        echo $output;
    } else {
        echo '<div class="card rounded-4 py-2 px-2">
                <div class="name fw-bold fs-6"><p>No Transaction Found</p></div>
              </div>';
    }
} else {
    echo '<div class="p-3"><p>Invalid Request</p></div>';
}
?>
