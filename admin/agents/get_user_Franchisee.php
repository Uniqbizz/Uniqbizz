
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
    }else if($table == "master_franchisee"){
        $user = $conn->prepare("SELECT * FROM master_franchisee WHERE status = '1' ORDER BY master_franchisee_id");
    }else if($table == "zonal_manager"){
        $user = $conn->prepare("SELECT * FROM zonal_manager WHERE status = '1' ORDER BY zonal_manager_id");
    }else if($table == "sub_franchisee"){
        $user = $conn->prepare("SELECT * FROM sub_franchisee WHERE status = '1' ORDER BY sub_franchisee_id");
    }else if($table == "sponsor_franchisee"){
        $user = $conn->prepare("SELECT * FROM sponsor_franchisee WHERE status = '1' ORDER BY sponsor_franchisee_id");
    }else if($table == "Prime"){
        $user = $conn->prepare("SELECT * FROM ca_customer WHERE status = '1' AND customer_type='Prime' ORDER BY ca_customer_id");
    }else if($table == "Premium"){
        $user = $conn->prepare("SELECT * FROM ca_customer WHERE status = '1' AND customer_type='Premium' ORDER BY ca_customer_id");
    }else if($table == "Premium Plus"){
        $user = $conn->prepare("SELECT * FROM ca_customer WHERE status = '1' AND customer_type='Premium Plus' ORDER BY ca_customer_id");
    }else if($table == "Premium Select"){
        $user = $conn->prepare("SELECT * FROM ca_customer WHERE status = '1' AND customer_type='Premium Select' ORDER BY ca_customer_id");
    }else if($table == "Premium Select Lite"){
        $user = $conn->prepare("SELECT * FROM ca_customer WHERE status = '1' AND customer_type='Premium Select Lite' ORDER BY ca_customer_id");
    }else if($table == "Neo Select"){
        $user = $conn->prepare("SELECT * FROM ca_customer WHERE status = '1' AND customer_type='Neo Select' ORDER BY ca_customer_id");
    }else if($table == "Neo Select Lite"){
        $user = $conn->prepare("SELECT * FROM ca_customer WHERE status = '1' AND customer_type='Neo Select Lite' ORDER BY ca_customer_id");
    }else if ($table == 'BM_BDM_MF_SF_RM') {
        $user = $conn->prepare("SELECT id,name FROM (
                                    SELECT business_mentor_id AS id,CONCAT(firstname,' ',lastname) AS name FROM business_mentor WHERE status=1
                                    UNION
                                    SELECT master_franchisee_id AS id,CONCAT(firstname,' ',lastname) AS name FROM master_franchisee WHERE status=1
                                    UNION
                                    SELECT sponsor_franchisee_id AS id,CONCAT(firstname,' ',lastname) AS name FROM sponsor_franchisee WHERE status=1
                                    UNION
                                    SELECT employee_id,name AS name FROM employees WHERE status=1
                                )as all_users
                                ORDER BY id");
    }else if($table == "institution"){
        $user = $conn->prepare("SELECT * FROM institution WHERE status = '1' ORDER BY institution_id");
    }else if($table == "institution_branch_manager"){
        $user = $conn->prepare("SELECT * FROM institution_branch_manager WHERE status = '1' ORDER BY institution_branch_manager_id");
    }else if($table == "executive_techno_enterprise"){
        $user = $conn->prepare("SELECT * FROM executive_techno_enterprise WHERE status = '1' ORDER BY executive_techno_enterprise_id");
    }else if($table == "super_techno_enterprise"){
        $user = $conn->prepare("SELECT * FROM super_techno_enterprise WHERE status = '1' ORDER BY super_techno_enterprise_id");
    }else if($table == "chief_techno_enterprise"){
        $user = $conn->prepare("SELECT * FROM chief_techno_enterprise WHERE status = '1' ORDER BY chief_techno_enterprise_id");
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
        }else if ( $table == "master_franchisee" ) {
            echo '<option value="">--Select Master Franchisee ID & Name--</option>';
        }else if ( $table == "zonal_manager" ) {
            echo '<option value="">--Select Zonal Manager ID & Name--</option>';
        }else if ( $table == "sub_franchisee" ) {
            echo '<option value="">--Select Franchisee ID & Name--</option>';
        }else if ( $table == "sponsor_franchisee" ) {
            echo '<option value="">--Select Sponsor Franchisee ID & Name--</option>';
        }else if ( $table == "Prime" || $table == "Premium" || $table == "Premium Plus" || $table == "Premium Select" || $table == "Premium Select Lite" || $table == "Neo Select Lite" || $table == "Neo Select") {
            echo '<option value="">--Select Customer ID & Name--</option>';
        }else if ($table == "BM_BDM_MF_SF_RM") {
            echo '<option value="">--Select User ID & Name--</option>';
        }else if ( $table == "institution" ) {
            echo '<option value="">--Select Institution ID & Name--</option>';
        }else if ( $table == "institution_branch_manager" ) {
            echo '<option value="">--Select Branch Manager ID & Name--</option>';
        }else if ( $table == "executive_techno_enterprise" ) {
            echo '<option value="">--Select Executive TE ID & Name--</option>';
        }else if ( $table == "super_techno_enterprise" ) {
            echo '<option value="">--Select Super TE ID & Name--</option>';
        }else if ( $table == "chief_techno_enterprise" ) {
            echo '<option value="">--Select Chief TE ID & Name--</option>';
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
            }else if ( $table == "master_franchisee" ) {
                echo '<option value="'.$value['master_franchisee_id'].'">'.$value['master_franchisee_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ( $table == "zonal_manager" ) {
                echo '<option value="'.$value['zonal_manager_id'].'">'.$value['zonal_manager_id'].' - '.$value['name'].'</option>';
            }else if ( $table == "sub_franchisee" ) {
                echo '<option value="'.$value['sub_franchisee_id'].'">'.$value['sub_franchisee_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ( $table == "sponsor_franchisee" ) {
                echo '<option value="'.$value['sponsor_franchisee_id'].'">'.$value['sponsor_franchisee_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ( $table == "Prime" || $table == "Premium" || $table == "Premium Plus" || $table == "Premium Select" || $table == "Premium Select Lite" || $table == "Neo Select Lite" || $table == "Neo Select" ) {
                echo '<option value="'.$value['ca_customer_id'].'">'.$value['ca_customer_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ($table == "BM_BDM_MF_SF_RM") {
                echo '<option value="'.$value['id'].'">'.$value['id'].' - '.$value['name'].'</option>';
            }else if ( $table == "institution" ) {
                echo '<option value="'.$value['institution_id'].'">'.$value['institution_id'].' - '.$value['name'].'</option>';
            }else if ( $table == "institution_branch_manager" ) {
                echo '<option value="'.$value['institution_branch_manager_id'].'">'.$value['institution_branch_manager_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ( $table == "executive_techno_enterprise" ) {
                echo '<option value="'.$value['executive_techno_enterprise_id'].'">'.$value['executive_techno_enterprise_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ( $table == "super_techno_enterprise" ) {
                echo '<option value="'.$value['super_techno_enterprise_id'].'">'.$value['super_techno_enterprise_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }else if ( $table == "chief_techno_enterprise" ) {
                echo '<option value="'.$value['chief_techno_enterprise_id'].'">'.$value['chief_techno_enterprise_id'].' - '.$value['firstname'].' '.$value['lastname'].'</option>';
            }
        }
        
    } else {
        echo '<option value="">No User Available</option>';
    }
    

?>