<?php

$hierarchyConfig = array(

    /*
    |--------------------------------------------------------------------------
    | Business Channel Manager
    |--------------------------------------------------------------------------
    */

    'business_chanel_manager' => array(

        array(
            'table'         => 'employees',
            'id_column'     => 'employee_id',
            'parent_column' => 'reporting_manager',

            'conditions' => array(
                "user_type = 25"
            ),

            'type'  => 'business_development_manager',
            'title' => 'Business Development Manager'
        )

    ),
    /*
    |--------------------------------------------------------------------------
    | Chief Techno Enterprise
    |--------------------------------------------------------------------------
    */

    'chief_techno_enterprise' => array(

        array(
            'table'         => 'executive_techno_enterprise',
            'id_column'     => 'executive_techno_enterprise_id',
            'parent_column' => 'reference_no',

            'conditions' => array(
                "user_type = 34"
            ),

            'type'  => 'executive_techno_enterprise',
            'title' => 'Executive Techno Enterprise'
        )

    ),
    /*
    |--------------------------------------------------------------------------
    | Executive Techno Enterprise
    |--------------------------------------------------------------------------
    */

    'executive_techno_enterprise' => array(

        array(
            'table'         => 'super_techno_enterprise',
            'id_column'     => 'super_techno_enterprise_id',
            'parent_column' => 'reference_no',

            'conditions' => array(
                "user_type = 34"
            ),

            'type'  => 'super_techno_enterprise',
            'title' => 'Super Techno Enterprise'
        ),
        array(
            'table'         => 'institution',
            'id_column'     => 'institution_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'institution',
            'title' => 'Institution'
        ),

    ),

    /*
    |--------------------------------------------------------------------------
    | Super Techo Enterprise
    |--------------------------------------------------------------------------
    */

    'super_techno_enterprise' => array(

        array(
            'table'         => 'corporate_agency',
            'id_column'     => 'corporate_agency_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'corporate_agency',
            'title' => 'Techno Enterprise'
        )

    ),
    /*
    |--------------------------------------------------------------------------
    | Business Development Manager
    |--------------------------------------------------------------------------
    */

    'business_development_manager' => array(

        array(
            'table'         => 'business_mentor',
            'id_column'     => 'business_mentor_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'business_mentor',
            'title' => 'Business Mentor'
        ),

        array(
            'table'         => 'corporate_agency',
            'id_column'     => 'corporate_agency_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'corporate_agency',
            'title' => 'Techno Enterprise'
        ),
        array(
            'table'         => 'institution',
            'id_column'     => 'institution_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'institution',
            'title' => 'Institution'
        ),

    ),


    /*
    |--------------------------------------------------------------------------
    | Business Mentor
    |--------------------------------------------------------------------------
    */

    'business_mentor' => array(

        array(
            'table'         => 'corporate_agency',
            'id_column'     => 'corporate_agency_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'corporate_agency',
            'title' => 'Techno Enterprise'
        ),
        array(
            'table'         => 'institution',
            'id_column'     => 'institution_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'institution',
            'title' => 'Institution'
        ),

        array(
            'table'         => 'ca_travelagency',
            'id_column'     => 'ca_travelagency_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'travel_consultant',
            'title' => 'Travel Consultant'
        )

    ),
    /*
    |--------------------------------------------------------------------------
    | Master Franchisee
    |--------------------------------------------------------------------------
    */

    'master_franchisee' => array(

        array(
            'table'         => 'sub_franchisee',
            'id_column'     => 'sub_franchisee_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'sub_franchisee',
            'title' => 'Franchisee'
        ),
        array(
            'table'         => 'institution',
            'id_column'     => 'institution_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'institution',
            'title' => 'Institution'
        ),

        array(
            'table'         => 'ca_travelagency',
            'id_column'     => 'ca_travelagency_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'travel_consultant',
            'title' => 'Travel Consultant'
        )

    ),
    /*
    |--------------------------------------------------------------------------
    | Sponsor Franchisee
    |--------------------------------------------------------------------------
    */

    'sponsor_franchisee' => array(

        array(
            'table'         => 'sub_franchisee',
            'id_column'     => 'sub_franchisee_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'sub_franchisee',
            'title' => 'Sub Franchisee'
        ),
        array(
            'table'         => 'institution',
            'id_column'     => 'institution_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'institution',
            'title' => 'Institution'
        ),

        array(
            'table'         => 'ca_travelagency',
            'id_column'     => 'ca_travelagency_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'travel_consultant',
            'title' => 'Travel Consultant'
        )

    ),


    /*
    |--------------------------------------------------------------------------
    | Techno Enterprise
    |--------------------------------------------------------------------------
    */

    'corporate_agency' => array(

        array(
            'table'         => 'ca_travelagency',
            'id_column'     => 'ca_travelagency_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'travel_consultant',
            'title' => 'Travel Consultant'
        )

    ),
    /*
    |--------------------------------------------------------------------------
    | Franchisee
    |--------------------------------------------------------------------------
    */

    'sub_franchisee' => array(

        array(
            'table'         => 'ca_travelagency',
            'id_column'     => 'ca_travelagency_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'travel_consultant',
            'title' => 'Travel Consultant'
        )

    ),
    /*
    |--------------------------------------------------------------------------
    | Institution
    |--------------------------------------------------------------------------
    */

    'institution' => array(

        array(
            'table'         => 'institution_branch_manager',
            'id_column'     => 'institution_branch_manager_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'institution_branch_manager',
            'title' => 'IBR'
        ),
        array(
            'table'         => 'ca_travelagency',
            'id_column'     => 'ca_travelagency_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'travel_consultant',
            'title' => 'Travel Consultant'
        )

    ),


    /*
    |--------------------------------------------------------------------------
    | Travel Consultant
    |--------------------------------------------------------------------------
    */

    'travel_consultant' => array(

        array(
            'table'         => 'ca_customer',
            'id_column'     => 'ca_customer_id',
            'parent_column' => 'ta_reference_no',

            'conditions' => array(
                "reference_no IS NULL"
            ),

            'type'  => 'customer',
            'title' => 'Customer'
        )

    ),
    /*
    |--------------------------------------------------------------------------
    | Institution Branch manager
    |--------------------------------------------------------------------------
    */

    'institution_branch_maanger' => array(

        array(
            'table'         => 'ca_customer',
            'id_column'     => 'ca_customer_id',
            'parent_column' => 'ta_reference_no',

            'conditions' => array(
                "reference_no IS NULL"
            ),

            'type'  => 'customer',
            'title' => 'Customer'
        )

    ),


    /*
    |--------------------------------------------------------------------------
    | Customer
    |--------------------------------------------------------------------------
    |
    | Customer refers another customer.
    | This allows unlimited hierarchy levels.
    |
    */

    'customer' => array(

        array(
            'table'         => 'ca_customer',
            'id_column'     => 'ca_customer_id',
            'parent_column' => 'reference_no',
            'conditions'    => array(),

            'type'  => 'customer',
            'title' => 'Customer'
        )

    )

);