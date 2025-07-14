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
        COALESCE(corporate_agency.amount, business_mentor.paid_amount, ca_travelagency.amount) AS amount,
        COALESCE(corporate_agency.payment_mode, business_mentor.payment_mode, ca_travelagency.payment_mode) AS payment_mode
    FROM login
    LEFT JOIN corporate_agency ON corporate_agency_id = login.user_id AND corporate_agency.status = 1
    LEFT JOIN business_mentor ON business_mentor_id = login.user_id AND business_mentor.status = 1
    LEFT JOIN ca_travelagency ON ca_travelagency_id = login.user_id AND ca_travelagency.status = 1
    LEFT JOIN employees ON employees.employee_id = login.user_id AND employees.status = 1
    LEFT JOIN ca_customer ON ca_customer_id = login.user_id AND ca_customer.status = 1
    WHERE DATE(login.register_date) = ?
      AND (
            corporate_agency.amount IS NOT NULL 
         OR business_mentor.paid_amount IS NOT NULL 
         OR ca_travelagency.amount IS NOT NULL
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
            } else {
                $fullName = "Unknown";
                $profilePic = "default.png";
            }

            // Determine user type name
            // $designation = match($row['user_type_id']) {
            //     16 => "Techno Enterprise",
            //     10 => "Customer",
            //     11 => "Travel Consultant",
            //     24 => "Business Channel Manager",
            //     25 => "Business Development Manager",
            //     26 => "Business Mentor",
            //     default => "Unknown"
            // };
            
            $userTypes = [
                16 => "Techno Enterprise",
                10 => "Customer",
                11 => "Travel Consultant",
                24 => "Business Channel Manager",
                25 => "Business Development Manager",
                26 => "Business Mentor"
            ];
            
            $user_type_id = $row['user_type_id'];
            $designation = isset($userTypes[$user_type_id]) ? $userTypes[$user_type_id] : "Unknown";


            $rdate = (new DateTime($row['register_date']))->format('d-m-Y');
            $TAmt = $row['amount'];
            $CATAmt = "₹" . preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $TAmt);
            $paymentMode = htmlspecialchars($row['payment_mode'] ?? 'Unknown');

            $output .= '
                    <div class="card pt-3">
                        <div class="row">
                            <div class="col-2 col-sm-1 col-md-1 col-lg-1 col-xl-2">
                                <div class="profile-pic pb-1" style="position: relative; left: 15px;">
                                    <img src="../uploading/' . $profilePic . '" alt="profile pic" class="rounded-circle" width="50px" height="50px">
                                </div>
                            </div>
                            
                            <div class="col-10 col-sm-11 col-md-11 col-lg-11 col-xl-10 d-flex justify-content-between align-items-center">
                                <div class="name fw-bold">' . $fullName . ' <span class="fw-normal">(' . $designation . ')</span></div>
                            </div>
                            <div class="date text-end fs-6" style="position: absolute; top: 5px; right: 0px;">' . $rdate . '</div>
                        </div>
                        
                        <div class="para ps-3 pb-2">
                            <p>Transferred <span class="amount">' . $CATAmt . '/-</span> to Bizzmirth Holiday Pvt. Ltd via <span class="payment-mode">' . $paymentMode . '</span>.</p>
                        </div>
                    </div>
            ';
        }
        $output .=' <div class="col-md-6 col-sm-6 col-6 pb-3 ps-2">
                        <a href="latest_transaction/latest_transaction.php"><button class="cpn_btn box-btn float-start">View More</button></a>
                    </div>
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
