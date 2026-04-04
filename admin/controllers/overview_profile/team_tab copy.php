<?php   
    if ($DBtable == 'business_chanel_manager') {
        include 'team_tab_bcm.php';
    }       
    if ($DBtable == 'business_developement_manager') {
        include 'team_tab_bdm.php';
    }       
    if($DBtable == 'business_mentor'){
        include 'team_tab_bm.php';
    }
    if($DBtable == 'master_franchisee'){
        include 'team_tab_mf.php';
    }
    if($DBtable == 'corporate_agency'){
        include 'team_tab_te.php';
    }
    if($DBtable == 'sub_franchisee'){
        include 'team_tab_f.php';
    }
    if ($DBtable == 'ca_travelagency' || $DBtable == 'institution_branch_manager'){
        include 'team_tab_te.php';
    }
    if ($DBtable == 'sponsor_franchisee'){
        include 'team_tab_sf.php';
    }
    if ($DBtable == 'institution'){
        include 'team_tab_i.php';
    }
    
?>