<?php

    /*
    |--------------------------------------------------------------------------
    | Include Hierarchy Files
    |--------------------------------------------------------------------------
    |
    */

    require_once __DIR__ . '/config/hierarchy_config.php';

    require_once __DIR__ . '/functions/team_helpers.php';

    require_once __DIR__ . '/functions/render_hierarchy.php';

?>


<div class="tab-pane fade rounded-4" id="teams" role="tabpanel">

    <?php

    /*
    |--------------------------------------------------------------------------
    | Render Team Hierarchy
    |--------------------------------------------------------------------------
    |
    | $id      = Current logged-in/member ID
    | $DBtable = Current member type/table
    |
    */

    //BCM
    if ($DBtable == 'business_chanel_manager') {

        renderTeamHierarchy(
            $conn,
            $id,
            'business_chanel_manager',
            $hierarchyConfig
        );

    }
    //CTE
    if ($DBtable == 'chief_techno_enterprise') {

        renderTeamHierarchy(
            $conn,
            $id,
            'chief_techno_enterprise',
            $hierarchyConfig
        );

    }
    //ETE
    if ($DBtable == 'executive_techno_enterprise') {

        renderTeamHierarchy(
            $conn,
            $id,
            'executive_techno_enterprise',
            $hierarchyConfig
        );

    }
    //STE
    if ($DBtable == 'super_techno_enterprise') {

        renderTeamHierarchy(
            $conn,
            $id,
            'super_techno_enterprise',
            $hierarchyConfig
        );

    }
    //BDM
    if ($DBtable == 'business_developement_manager') {

        renderTeamHierarchy(
            $conn,
            $id,
            'business_developement_manager',
            $hierarchyConfig
        );

    }
    //BM
    if ($DBtable == 'business_mentor') {

        renderTeamHierarchy(
            $conn,
            $id,
            'business_mentor',
            $hierarchyConfig
        );

    }
    //MF
    if ($DBtable == 'master_franchisee') {

        renderTeamHierarchy(
            $conn,
            $id,
            'master_franchisee',
            $hierarchyConfig
        );

    }
    //SF
    if ($DBtable == 'sponsor_franchisee') {

        renderTeamHierarchy(
            $conn,
            $id,
            'sponsor_franchisee',
            $hierarchyConfig
        );

    }
    //F
    if ($DBtable == 'sub_franchisee') {

        renderTeamHierarchy(
            $conn,
            $id,
            'sub_franchisee',
            $hierarchyConfig
        );

    }
    //TE/CA
    if ($DBtable == 'corporate_agency') {

        renderTeamHierarchy(
            $conn,
            $id,
            'corporate_agency',
            $hierarchyConfig
        );

    }
    //TC
    if ($DBtable == 'ca_travelagency') {

        renderTeamHierarchy(
            $conn,
            $id,
            'ca_travelagency',
            $hierarchyConfig
        );

    }
    //CU
    if ($DBtable == 'ca_customer') {

        renderTeamHierarchy(
            $conn,
            $id,
            'ca_customer',
            $hierarchyConfig
        );

    }

    ?>

</div>