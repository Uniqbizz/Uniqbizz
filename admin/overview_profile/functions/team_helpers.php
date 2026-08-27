<?php


/*
|--------------------------------------------------------------------------
| Get Member Name
|--------------------------------------------------------------------------
*/

function getMemberName($member, $type)
{
    //BDM
    if ($type == 'business_development_manager') {

        return trim(
            (isset($member['name']) ? $member['name'] : '') .
            ' ' .
            (isset($member['employee_id']) ? $member['employee_id'] : '')
        );
    }
    //I
    if ($type == 'institution') {

        return trim(
            (isset($member['name']) ? $member['name'] : '') .
            ' ' .
            (isset($member['institution_id']) ? $member['institution_id'] : '')
        );
    }


    $firstname = isset($member['firstname'])
        ? $member['firstname']
        : '';

    $lastname = isset($member['lastname'])
        ? $member['lastname']
        : '';


    $memberId = '';
    //BM
    if (isset($member['business_mentor_id'])) {
        $memberId = $member['business_mentor_id'];
    }
    //MF
    elseif (isset($member['master_franchisee_id'])) {
        $memberId = $member['master_franchisee_id'];
    }
    //SF
    elseif (isset($member['sponsor_franchisee_id'])) {
        $memberId = $member['sponsor_franchisee_id'];
    }
    //TE/CA
    elseif (isset($member['corporate_agency_id'])) {
        $memberId = $member['corporate_agency_id'];
    }
    //F
    elseif (isset($member['sub_franchisee_id'])) {
        $memberId = $member['sub_franchisee_id'];
    }
    //TC
    elseif (isset($member['ca_travelagency_id'])) {
        $memberId = $member['ca_travelagency_id'];
    }
    //IBR
    elseif (isset($member['institution_branch_manager_id'])) {
        $memberId = $member['institution_branch_manager_id'];
    }
    //CU
    elseif (isset($member['ca_customer_id'])) {
        $memberId = $member['ca_customer_id'];
    }


    return trim($firstname . ' ' . $lastname . ' ' . $memberId);
}



/*
|--------------------------------------------------------------------------
| Get Phone Number
|--------------------------------------------------------------------------
*/

function getMemberPhone($member)
{
    if (!empty($member['contact_no'])) {
        return $member['contact_no'];
    }

    if (!empty($member['contact'])) {
        return $member['contact'];
    }

    return '--';
}



/*
|--------------------------------------------------------------------------
| Get Profile Image
|--------------------------------------------------------------------------
*/

function getProfileImage($member)
{
    if (!empty($member['profile_pic'])) {

        return '../../uploading/' . $member['profile_pic'];
    }

    return '../../uploading/not_uploaded.png';
}



/*
|--------------------------------------------------------------------------
| Get Team Count
|--------------------------------------------------------------------------
*/

function getTeamCount(
    $conn,
    $memberId,
    $memberType,
    $hierarchyConfig
) {

    if (!isset($hierarchyConfig[$memberType])) {
        return 0;
    }


    $total = 0;


    foreach ($hierarchyConfig[$memberType] as $config) {


        $table = $config['table'];

        $parentColumn = $config['parent_column'];


        $sql = "
            SELECT COUNT(*)
            FROM `$table`
            WHERE `$parentColumn` = ?
            AND status = '1'
        ";


        /*
        |--------------------------------------------------------------------------
        | Extra conditions
        |--------------------------------------------------------------------------
        */

        if (
            isset($config['conditions']) &&
            is_array($config['conditions'])
        ) {

            foreach ($config['conditions'] as $condition) {

                $sql .= " AND " . $condition;
            }

        }


        $stmt = $conn->prepare($sql);

        $stmt->execute(array($memberId));


        $total += (int)$stmt->fetchColumn();

    }


    return $total;
}



/*
|--------------------------------------------------------------------------
| Get Package Count
|--------------------------------------------------------------------------
*/

function getPackageCount(
    $conn,
    $memberId,
    $memberType
) {

    $packageColumns = array(

        'business_development_manager' => 'bdm_id',

        'business_mentor' => 'bm_id',

        'master_franchisee' => 'bm_id',

        'sponsor_franchisee' => 'bm_id',

        'corporate_agency' => 'te_id',

        'sub_franchisee' => 'te_id',

        'institution' => 'te_id',

        'travel_consultant' => 'ta_id',

        'institution_branch_manager' => 'ta_id',

        'customer' => 'cu_id'

    );


    if (!isset($packageColumns[$memberType])) {
        return 0;
    }


    $column = $packageColumns[$memberType];


    $sql = "
        SELECT COUNT(*)
        FROM product_payout
        WHERE `$column` = ?
    ";


    $stmt = $conn->prepare($sql);

    $stmt->execute(array($memberId));


    return (int)$stmt->fetchColumn();

}