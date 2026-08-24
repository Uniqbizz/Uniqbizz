<?php

// Fetch logs where user is either actor or target
$stmt = $conn->prepare("
    SELECT *
    FROM `logs`
    WHERE reference_no = :id
    AND user_id IS NOT NULL
    AND user_id != ''
    ORDER BY `id` DESC
");

$stmt->execute([
    'id' => $id
]);

$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);


// =========================================================
// Function to determine user type and fetch user details
// =========================================================

function getUserDetails($conn, $title, $ref_id, $user_id = null)
{
    $table = '';
    $condition = '';
    $selectField = '';
    $idField = '';
    $useUserId = false;

    // =====================================================
    // DETERMINE TABLE + ID
    // =====================================================

    switch (true) {

        // =================================================
        // BUSINESS MENTOR
        // =================================================
        case strpos($title, 'Business Mentor') !== false:

            $table = 'business_mentor';
            $idField = 'business_mentor_id';

            $selectField = '
                firstname,
                lastname,
                profile_pic,
                business_mentor_id,
                id AS base_id
            ';

            $condition = 'reference_no = :ref_id';

            break;


        // =================================================
        // TRAVEL CONSULTANT
        // =================================================
        case strpos($title, 'Travel Consultant') !== false:

            $table = 'ca_travelagency';
            $idField = 'ca_travelagency_id';

            $selectField = '
                firstname,
                lastname,
                profile_pic,
                ca_travelagency_id,
                id AS base_id
            ';

            $condition = 'reference_no = :ref_id';

            break;


        // =================================================
        // CUSTOMER
        // =================================================
        case strpos($title, 'Customer') !== false:

            $table = 'ca_customer';
            $idField = 'ca_customer_id';

            $selectField = '
                firstname,
                lastname,
                profile_pic,
                ca_customer_id,
                id AS base_id
            ';

            $condition = 'COALESCE(reference_no, ta_reference_no) = :ref_id';

            break;


        // =================================================
        // BUSINESS CONSULTANT
        // =================================================
        case strpos($title, 'Business Consultant') !== false:

            $table = 'business_consultant';
            $idField = 'business_consultant_id';

            $selectField = '
                firstname,
                lastname,
                profile_pic,
                business_consultant_id,
                id AS base_id
            ';

            $condition = 'reference_no = :ref_id';

            break;


        // =================================================
        // EXECUTIVE TECHNO ENTERPRISE
        // =================================================
        case strpos($title, 'Executive Techno Enterprise') !== false:

            $table = 'executive_techno_enterprise';
            $idField = 'executive_techno_enterprise_id';

            $selectField = '
                firstname,
                lastname,
                executive_techno_enterprise_id,
                id AS base_id
            ';

            $condition = 'reference_no = :ref_id';

            break;


        // =================================================
        // SUPER TECHNO ENTERPRISE
        // =================================================
        case strpos($title, 'Super Techno Enterprise') !== false:

            $table = 'super_techno_enterprise';
            $idField = 'super_techno_enterprise_id';

            $selectField = '
                firstname,
                lastname,
                super_techno_enterprise_id,
                id AS base_id
            ';

            $condition = 'reference_no = :ref_id';

            break;


        // =================================================
        // NORMAL TECHNO ENTERPRISE
        // =================================================
        case strpos($title, 'Techno Enterprise') !== false:

            $table = 'corporate_agency';
            $idField = 'corporate_agency_id';

            $selectField = '
                firstname,
                lastname,
                profile_pic,
                corporate_agency_id,
                id AS base_id
            ';

            $condition = 'reference_no = :ref_id';

            break;


        // =================================================
        // BUSINESS DEVELOPMENT MANAGER
        // =================================================
        case strpos($title, 'Business Development Manager') !== false:

            $table = 'employees';
            $idField = 'employee_id';

            $selectField = '
                name,
                employee_id,
                profile_pic,
                id AS base_id
            ';

            $condition = '
                reference_no = :ref_id
                AND user_type = 25
            ';

            break;


        // =================================================
        // ZONAL MANAGER
        // =================================================
        case strpos($title, 'Zonal Manager') !== false:

            $table = 'zonal_manager';
            $idField = 'zonal_manager_id';

            $selectField = '
                name,
                zonal_manager_id,
                profile_pic,
                id AS base_id
            ';

            $condition = '
                reference_no = :ref_id
                AND user_type = 27
            ';

            break;


        // =================================================
        // MASTER FRANCHISEE
        // =================================================
        case strpos($title, 'Master Franchisee') !== false:

            $table = 'master_franchisee';
            $idField = 'master_franchisee_id';

            $selectField = '
                firstname,
                lastname,
                profile_pic,
                master_franchisee_id,
                id AS base_id
            ';

            $condition = '
                reference_no = :ref_id
                AND user_type = 28
            ';

            break;


        // =================================================
        // FRANCHISEE
        // =================================================
        case strpos($title, 'Franchisee') !== false:

            $table = 'sub_franchisee';
            $idField = 'sub_franchisee_id';

            $selectField = '
                firstname,
                lastname,
                profile_pic,
                sub_franchisee_id,
                id AS base_id
            ';

            $condition = '
                reference_no = :ref_id
                AND user_type = 29
            ';

            break;


        // =================================================
        // RELATIONSHIP MANAGER
        // =================================================
        case strpos($title, 'Relationship Manager') !== false:

            $table = 'employees';
            $idField = 'employee_id';

            $selectField = '
                name,
                employee_id,
                profile_pic,
                id AS base_id
            ';

            $condition = '
                reference_no = :ref_id
                AND user_type = 31
            ';

            break;


        // =================================================
        // UNKNOWN
        // =================================================
        default:

            return [
                'name' => 'Unknown User',
                'profile_pic' => 'not_uploaded.png'
            ];
    }


    // =====================================================
    // FIND USER
    // =====================================================

    $user = false;

    if (!empty($user_id)) {

        // -------------------------------------------------
        // STEP 1:
        // Try the table-specific ID first
        // Example:
        // ca_travelagency_id = TA250128
        // -------------------------------------------------

        $sqlUser = "
            SELECT $selectField
            FROM $table
            WHERE {$idField} = :user_id
            LIMIT 1
        ";

        $stmtUser = $conn->prepare($sqlUser);

        $stmtUser->execute([
            'user_id' => $user_id
        ]);

        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);


        // -------------------------------------------------
        // STEP 2:
        // If not found, try common database ID
        // Example:
        // id = 136
        // -------------------------------------------------

        if (!$user) {

            $sqlUser = "
                SELECT $selectField
                FROM $table
                WHERE id = :user_id
                LIMIT 1
            ";

            $stmtUser = $conn->prepare($sqlUser);

            $stmtUser->execute([
                'user_id' => $user_id
            ]);

            $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
        }

    } else {

        // -------------------------------------------------
        // NO USER ID
        // Fall back to reference number
        // -------------------------------------------------

        $sqlUser = "
            SELECT $selectField
            FROM $table
            WHERE $condition
            LIMIT 1
        ";

        $stmtUser = $conn->prepare($sqlUser);

        $stmtUser->execute([
            'ref_id' => $ref_id
        ]);

        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
    }


    if (!$user) {

        return [
            'name' => 'Unknown User',
            'profile_pic' => 'not_uploaded.png'
        ];
    }


    // =====================================================
    // RESOLVED USER ID
    // =====================================================

    if (
        isset($user[$idField]) &&
        !empty($user[$idField])
    ) {

        $resolvedUserId = $user[$idField];

    } elseif (
        isset($user['base_id']) &&
        !empty($user['base_id'])
    ) {

        $resolvedUserId = $user['base_id'];

    } else {

        return [
            'name' => 'Unknown User',
            'profile_pic' => 'not_uploaded.png'
        ];
    }


    // =====================================================
    // PROFILE PICTURE
    // =====================================================

    if (
        $table === 'executive_techno_enterprise' ||
        $table === 'super_techno_enterprise'
    ) {

        // ---------------------------------------------
        // ETE / STE PROFILE PIC FROM DOCUMENTS
        // ---------------------------------------------

        $stmtDoc = $conn->prepare("
            SELECT profile_pic
            FROM documents
            WHERE user_id = :user_id
            LIMIT 1
        ");

        $stmtDoc->execute([
            'user_id' => $resolvedUserId
        ]);

        $document = $stmtDoc->fetch(PDO::FETCH_ASSOC);

        $profilePic = 'not_uploaded.png';

        if (!empty($document['profile_pic'])) {

            $profilePicFile =
                "../../uploading/" . $document['profile_pic'];

            if (file_exists($profilePicFile)) {

                $profilePic = $document['profile_pic'];
            }
        }

    } else {

        // ---------------------------------------------
        // NORMAL PROFILE PIC
        // ---------------------------------------------

        $profilePic = 'not_uploaded.png';

        if (!empty($user['profile_pic'])) {

            $profilePicFile =
                "../../uploading/" . $user['profile_pic'];

            if (file_exists($profilePicFile)) {

                $profilePic = $user['profile_pic'];
            }
        }
    }


    // =====================================================
    // COMPOSE NAME
    // =====================================================

    if (
        $table === 'employees' ||
        $table === 'zonal_manager'
    ) {

        $name =
            trim($user['name'] ?? '') .
            ' (' .
            $resolvedUserId .
            ')';

    } else {

        $name =
            trim(
                ($user['firstname'] ?? '') .
                ' ' .
                ($user['lastname'] ?? '')
            ) .
            ' (' .
            $resolvedUserId .
            ')';
    }


    // =====================================================
    // RETURN
    // =====================================================

    return [
        'name' => $name,
        'profile_pic' => $profilePic
    ];
}


// =========================================================
// DISPLAY LOGS
// =========================================================

if (count($logs) > 0) {

    foreach ($logs as $row) {

        $rd = new DateTime($row['register_date']);
        $rdate = $rd->format('d-m-Y');


        // =================================================
        // GET USER DETAILS
        // =================================================

        /*
         * For ETE / STE:
         * $row['user_id'] identifies the specific enterprise.
         *
         * For all other users:
         * reference_no is still used.
         */

        $userId = $row['user_id'] ?? null;

        $user = getUserDetails(
            $conn,
            $row['title'],
            $row['reference_no'],
            $userId
        );


        // =================================================
        // DISPLAY
        // =================================================

        echo '
        <div class="row pt-3">
            <div class="col-md-2">
                <div class="d-flex align-items-center justify-content-center p-3 position">
                    <img src="../../uploading/' .htmlspecialchars($user['profile_pic']) .'" width="50" height="50" class="rounded-circle ms-3"/>
                </div>
            </div>
            <div class="col-md-9">
                <div>
                    <div class="card bg-light p-2 mt-2">
                        <div class="d-flex justify-content-between">
                            <h4>' .htmlspecialchars($row['title']) .' - ' .htmlspecialchars($user['name']) .'</h4>
                            <p class="d-inline">' . $rdate . '</p>
                        </div>
                        <p class="my-0 cardText">' .htmlspecialchars($row['message']) .'</p>
                    </div>
                </div>
            </div>
        </div>';
    }
} else {
    echo '
    <div class="row pt-3">
        <div class="col-md-2">
            <div class="d-flex align-items-center justify-content-center p-3 position">
                <img src="../../uploading/not_uploaded.png" width="50" height="50" class="rounded-circle ms-3"/>
            </div>
        </div>
        <div class="col-md-9">
            <div>
                <div class="card bg-light p-2 mt-2">
                    <div class="d-flex justify-content-between">
                        <h4>-----</h4>
                        <p class="d-inline">--/--/----</p>
                    </div>
                    <p class="my-0 cardText">No Activities Found</p>
                </div>
            </div>
        </div>
    </div>';
}
?>