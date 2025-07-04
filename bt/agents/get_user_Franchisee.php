
<?php

//For Multiple designation add form  get name list ref:corporate partner
require '../connect.php';

    $table = $_POST["designation"];

    if ( $table == "business_trainee" ) {
        $user = $conn->prepare("SELECT * FROM business_trainee WHERE status = '1' ORDER BY business_trainee_id");
    }else if ( $table == "travel_agent" ) {
        $user = $conn->prepare("SELECT * FROM travel_agent WHERE status = '1' ORDER BY travel_agent_id");
    }else if ( $table == "branch_manager" ) {
        $user = $conn->prepare("SELECT * FROM branch_manager WHERE status = '1' ORDER BY branch_manager_id");
    }else if ($table == "corporate_agency"){
         $user = $conn->prepare("SELECT * FROM corporate_agency WHERE status = '1' ORDER BY corporate_agency_id");
    }else if ($table == "base_agency"){
         $user = $conn->prepare("SELECT * FROM base_agency WHERE status = '1' ORDER BY base_agency_id");
    }else if ($table == "sales_manager"){
         $user = $conn->prepare("SELECT * FROM sales_manager WHERE status = '1' ORDER BY sales_manager_id");
    }else if ($table == "channel_business_director"){
         $user = $conn->prepare("SELECT * FROM channel_business_director WHERE status = '1' ORDER BY channel_business_director_id");
    }else if ($table == "ca_travelagency"){
         $user = $conn->prepare("SELECT * FROM ca_travelagency WHERE status = '1' ORDER BY ca_travelagency_id");
    }else if ($table == "ca_customer"){
         $user = $conn->prepare("SELECT * FROM ca_customer WHERE status = '1' ORDER BY ca_customer_id");
    }else if ($table == "business_consultant"){
         $user = $conn->prepare("SELECT * FROM business_consultant WHERE status = '1' ORDER BY business_consultant_id");
    }else if ($table == "business_mentor"){
         $user = $conn->prepare("SELECT * FROM business_mentor WHERE status = '1' ORDER BY business_mentor_id");
    }else if ($table == "business_development_manager"){
         $user = $conn->prepare("SELECT * FROM employees WHERE user_type = '25' AND status = '1' ORDER BY employee_id");
    }else if ($table == "business_channel_manager"){
         $user = $conn->prepare("SELECT * FROM employees WHERE user_type = '24' AND status = '1' ORDER BY employee_id");
    }

    $user->execute();
    $user->setFetchMode(PDO::FETCH_ASSOC);

    if ( $user ->rowCount() > 0) {
        $user_data = $user->fetchAll();
        // echo json_encode($user_data);

        if ( $table == "business_trainee" ) {
            echo '<option value="">--Select Business Trainee ID & Name--</option>';
        }  else if ( $table == "travel_agent" ) {
            echo '<option value="">--Select Travel Agent ID & Name--</option>';
        }  else if ( $table == "branch_manager" ) {
            echo '<option value="">--Select Branch Manager ID & Name--</option>';
        }else if ( $table == "corporate_agency" ) {
            echo '<option value="">--Select Techno Enterprise ID & Name--</option>';
        }else if ( $table == "base_agency" ) {
            echo '<option value="">--Select base_agency ID & Name--</option>';
        }else if ( $table == "sales_manager" ) {
            echo '<option value="">--Select sales_manager ID & Name--</option>';
        }else if ( $table == "channel_business_director" ) {
            echo '<option value="">--Select CBD ID & Name--</option>';
        }else if ( $table == "ca_travelagency" ) {
            echo '<option value="">--Select Travel Agency ID & Name--</option>';
        }else if ( $table == "ca_customer" ) {
            echo '<option value="">--Select Customer ID & Name--</option>';
        }else if ( $table == "business_consultant" ) {
            echo '<option value="">--Select Business Consultant ID & Name--</option>';
        }else if ( $table == "business_mentor" ) {
            echo '<option value="">--Select Business Mentor ID & Name--</option>';
        }else if ( $table == "business_development_manager" ) {
            echo '<option value="">--Select Business Development Manager ID & Name--</option>';
        }else if ( $table == "business_channel_manager" ) {
            echo '<option value="">--Select Business Channel Manager ID & Name--</option>';
        }
        
        foreach ($user_data as $key => $value) {
            if ( $table == "business_trainee" ) {
                echo '<option value="'.$value['business_trainee_id'].'">'.$value['business_trainee_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }  else if ( $table == "travel_agent" ) {
                echo '<option value="'.$value['travel_agent_id'].'">'.$value['travel_agent_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            } else if ( $table == "branch_manager" ) {
                echo '<option value="'.$value['branch_manager_id'].'">'.$value['branch_manager_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ( $table == "corporate_agency" ) {
                echo '<option value="'.$value['corporate_agency_id'].'">'.$value['corporate_agency_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ( $table == "base_agency" ) {
                echo '<option value="'.$value['base_agency_id'].'">'.$value['base_agency_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ( $table == "sales_manager" ) {
                echo '<option value="'.$value['sales_manager_id'].'">'.$value['sales_manager_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ( $table == "channel_business_director" ) {
                echo '<option value="'.$value['channel_business_director_id'].'">'.$value['channel_business_director_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ( $table == "ca_travelagency" ) {
                echo '<option value="'.$value['ca_travelagency_id'].'">'.$value['ca_travelagency_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ( $table == "ca_customer" ) {
                echo '<option value="'.$value['ca_customer_id'].'">'.$value['ca_customer_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ( $table == "business_consultant" ) {
                echo '<option value="'.$value['business_consultant_id'].'">'.$value['business_consultant_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ( $table == "business_mentor" ) {
                echo '<option value="'.$value['business_mentor_id'].'">'.$value['business_mentor_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ( $table == "business_development_manager" ) {
                echo '<option value="'.$value['employee_id'].'">'.$value['employee_id'].' - '.$value['name'].'</option>';
            }else if ( $table == "business_channel_manager" ) {
                echo '<option value="'.$value['employee_id'].'">'.$value['employee_id'].' - '.$value['name'].'</option>';
            }
        }
        
    } else {
        echo '<option value="">No User Available</option>';
    }
    

?>