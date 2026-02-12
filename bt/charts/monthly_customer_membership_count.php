<?php
    require '../connect.php';
    $formdata = stripslashes(file_get_contents("php://input"));
    $get_data = json_decode($formdata, true);

    $get_year = $get_data['year'];
    $current_year = $get_data['current_year'];
    $current_month = $get_data['current_month'];
    $user_id = $get_data['user_id'];// user id
    $user_type = $get_data['user_type']; //get user type
    
    $data = array(0,0,0,0,0,0,0,0,0,0,0,0);
    //deshboard chart data 
    // for admin
    if ($user_type == '0') {

        $sqlCustFree = "SELECT ca_customer_id, MONTH(register_date) AS start_month, YEAR(register_date) AS start_year FROM ca_customer WHERE customer_type = 'Free' AND status='1' ";
        $sqlCustFree = "SELECT ca_customer_id, MONTH(register_date) AS start_month, YEAR(register_date) AS start_year FROM ca_customer WHERE customer_type = 'Prime' AND status='1' ";
        $sqlCustPrem = "SELECT ca_customer_id, MONTH(register_date) AS start_month, YEAR(register_date) AS start_year FROM ca_customer WHERE customer_type = 'Premium' AND status='1' ";
        $sqlCustPremPlus = "SELECT ca_customer_id, MONTH(register_date) AS start_month, YEAR(register_date) AS start_year FROM ca_customer WHERE customer_type = 'Premium Plus' AND status='1' ";
        $sqlCustPremSelect = "SELECT ca_customer_id, MONTH(register_date) AS start_month, YEAR(register_date) AS start_year FROM ca_customer WHERE customer_type = 'Premium Select' AND status='1' ";
        $sqlCustPremSelectLite = "SELECT ca_customer_id, MONTH(register_date) AS start_month, YEAR(register_date) AS start_year FROM ca_customer WHERE customer_type = 'Premium Select Lite' AND status='1' ";
        $sqlCustNeoSelect = "SELECT ca_customer_id, MONTH(register_date) AS start_month, YEAR(register_date) AS start_year FROM ca_customer WHERE customer_type = 'Neo Select' AND status='1' ";
        $sqlCustNeoSelectUltra = "SELECT ca_customer_id, MONTH(register_date) AS start_month, YEAR(register_date) AS start_year FROM ca_customer WHERE customer_type = 'Neo Select Ultra' AND status='1' ";

        $data_custFree = monthlyChartData($conn, $sqlCustFree, $get_year, $current_year, $current_month ); 
        $data_custPrime = monthlyChartData($conn, $sqlCustFree, $get_year, $current_year, $current_month ); 
        $data_CustPrem = monthlyChartData($conn, $sqlCustPrem, $get_year, $current_year, $current_month ); 
        $data_CustPremPlus = monthlyChartData($conn, $sqlCustPremPlus, $get_year, $current_year, $current_month ); 
        $data_CustPremSelect = monthlyChartData($conn, $sqlCustPremSelect, $get_year, $current_year, $current_month ); 
        $data_CustPremSelectLite = monthlyChartData($conn, $sqlCustPremSelectLite, $get_year, $current_year, $current_month ); 
        $data_custNeoSelect = monthlyChartData($conn, $sqlCustNeoSelect, $get_year, $current_year, $current_month ); 
        $data_custNeoSelectUltra = monthlyChartData($conn, $sqlCustNeoSelectUltra, $get_year, $current_year, $current_month ); 

    // for consultant
    } else if($user_type=='3'){
        $sqlCU = "SELECT cust_id, MONTH(register_date) AS start_month, YEAR(register_date) AS start_year 
                FROM customer where ta_reference='".$user_id."' AND status='1' ";
    
        $data_cust = monthlyChartData($conn, $sqlCU, $get_year, $current_year, $current_month );
        $data_bc = $data;
        $data_bp = $data;

    // for customer
    } else if($user_type=='2'){
        $sqlCU = "SELECT cust_id, MONTH(register_date) AS start_month, YEAR(register_date) AS start_year 
                FROM customer where reference_no='".$user_id."' AND status='1' ";
                
        $data_cust = monthlyChartData($conn, $sqlCU, $get_year, $current_year, $current_month );
        $data_bc = $data;
        $data_bp = $data;
    }

    $multi_array = array( $data_custFree, $data_custPrime, $data_CustPrem, $data_CustPremPlus, $data_CustPremSelect, $data_CustPremSelectLite, $data_custNeoSelect, $data_custNeoSelectUltra);
    $json_encode =  json_encode($multi_array);
    echo $json_encode;
    

    function monthlyChartData($conn, $sql, $get_year, $current_year, $current_month){
        
        $jan=0; $feb=0; $mar=0; $apr=0; $may=0; $jun=0; $jul=0; $aug=0; $sep=0; $oct=0; $nov=0;  $dec=0;

        // get data
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0){
            // print_r($users);
            foreach ($stmt->fetchAll() as $key => $row) {
                // $cust_id = $row['cust_id'];
                $month = $row['start_month'];
                $year = $row['start_year'];
    
                if ( $year == $get_year ) {
                    switch ($month) {
                        case 1 : $jan += 1; break;
                        case 2 : $feb += 1; break;
                        case 3 : $mar += 1; break;
                        case 4 : $apr += 1; break;
                        case 5 : $may += 1; break;
                        case 6 : $jun += 1; break;
                        case 7 : $jul += 1; break;
                        case 8 : $aug += 1; break;
                        case 9 : $sep += 1; break;
                        case 10 : $oct += 1; break;
                        case 11 : $nov += 1; break;
                        case 12 : $dec += 1; break;
                        default: echo '0'; break;
                    }
                }
            }

            // Check current month and year
            if ( $current_year == $get_year ) {
                switch ($current_month) {
                    case 1 : $data = array($jan);break;
                    case 2 : $data = array($jan,$feb);break;
                    case 3 : $data = array($jan,$feb,$mar);break;
                    case 4 : $data = array($jan,$feb,$mar,$apr);break;
                    case 5 : $data = array($jan,$feb,$mar,$apr,$may);break;
                    case 6 : $data = array($jan,$feb,$mar,$apr,$may,$jun);break;
                    case 7 : $data = array($jan,$feb,$mar,$apr,$may,$jun,$jul);break;
                    case 8 : $data = array($jan,$feb,$mar,$apr,$may,$jun,$jul,$aug);break;
                    case 9 : $data = array($jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep);break;
                    case 10 : $data = array($jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$oct);break;
                    case 11 : $data = array($jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov);break;
                    case 12 : $data = array($jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec);break;
                    default: $data = array(0,0,0,0,0,0,0,0,0,0,0,0);break;
                }
            } else {
                $data = array($jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec);
            }

            return $data;
        } else {
            return array(0,0,0,0,0,0,0,0,0,0,0,0);
        }
      
    }
?>
