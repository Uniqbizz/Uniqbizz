<?php
    function getUserTable($user_type)
    {
        $map = [
            24=>'employees',25=>'employees',31=>'employees',
            26=>'business_mentor',27=>'zonal_manager',
            28=>'master_franchisee',29=>'sub_franchisee',30=>'sponsor_franchisee',
            32=>'institution',33=>'institution_branch_manager',
            16=>'corporate_agency',11=>'ca_travelagency',10=>'ca_customer'
        ];

        return $map[$user_type] ?? null;
    }
?>