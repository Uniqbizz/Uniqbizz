<?php
function renderTeamHierarchy($conn,$parentId,$parentType,$hierarchyConfig,$level = 0) {
    /*
    |--------------------------------------------------------------------------
    | Stop if hierarchy doesn't exist
    |--------------------------------------------------------------------------
    */
    if (!isset($hierarchyConfig[$parentType])) {
        return;
    }
    /*
    |--------------------------------------------------------------------------
    | Track whether any member was found
    |--------------------------------------------------------------------------
    */
    $hasMembers = false;
    /*
    |--------------------------------------------------------------------------
    | Get all possible child types
    |--------------------------------------------------------------------------
    */
    foreach ($hierarchyConfig[$parentType] as $config) {
        $table = $config['table'];
        $idColumn = $config['id_column'];
        $parentColumn = $config['parent_column'];
        $childType = $config['type'];
        $title = $config['title'];
        /*
        |--------------------------------------------------------------------------
        | Main Query
        |--------------------------------------------------------------------------
        */
        $sql = "
            SELECT *
            FROM `$table`
            WHERE `$parentColumn` = ?
            AND status = '1'
        ";
        /*
        |--------------------------------------------------------------------------
        | Additional Conditions
        |--------------------------------------------------------------------------
        */
        if (isset($config['conditions']) && is_array($config['conditions'])) {
            foreach ($config['conditions'] as $condition) {
                $sql .= " AND " . $condition;
            }
        }
        $sql .= " ORDER BY `$idColumn` ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($parentId));
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
        /*
        |--------------------------------------------------------------------------
        | No Members for this particular hierarchy type
        |--------------------------------------------------------------------------
        */
        if (empty($members)) {
            continue;
        }
        /*
        |--------------------------------------------------------------------------
        | Members found
        |--------------------------------------------------------------------------
        */
        $hasMembers = true;
        /*
        |--------------------------------------------------------------------------
        | Loop Members
        |--------------------------------------------------------------------------
        */
        foreach ($members as $member) {
            $memberId = $member[$idColumn];
            /*
            |--------------------------------------------------------------------------
            | Member Details
            |--------------------------------------------------------------------------
            */
            $memberName = getMemberName($member,$childType);
            $memberPhone = getMemberPhone($member);
            $profileImage = getProfileImage($member);
            /*
            |--------------------------------------------------------------------------
            | Get Team Count
            |--------------------------------------------------------------------------
            */
            $teamCount = getTeamCount($conn,$memberId,$childType,$hierarchyConfig);
            /*
            |--------------------------------------------------------------------------
            | Get Package Count
            |--------------------------------------------------------------------------
            */
            $packageCount = getPackageCount($conn,$memberId,$childType);
            /*
            |--------------------------------------------------------------------------
            | Overview Parameters
            |--------------------------------------------------------------------------
            */
            $referenceNo = isset($member['reference_no'])? $member['reference_no']: '';
            $country = isset($member['country'])? $member['country']: '';
            $state = isset($member['state'])? $member['state']: '';
            $city = isset($member['city'])? $member['city']: '';
            /*
            |--------------------------------------------------------------------------
            | Escape Values
            |--------------------------------------------------------------------------
            */
            $safeName = htmlspecialchars($memberName,ENT_QUOTES,'UTF-8');
            $safePhone = htmlspecialchars($memberPhone,ENT_QUOTES,'UTF-8');
            $safeImage = htmlspecialchars($profileImage,ENT_QUOTES,'UTF-8');
            ?>
            <!-- TEAM MEMBER -->
            <button type="button" class="accordion p-0 team-level-<?php echo (int)$level; ?>">
                <div class="card mb-0 rounded-0">
                    <div class="card-body p-2">
                        <div class="row align-items-center">
                            <!-- PROFILE -->
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                        <img src="<?php echo $safeImage; ?>" alt="" class="img-fluid d-block rounded-circle">
                                    </div>
                                    <div>
                                        <a href="#" class="d-block"><h5 class="fs-5 mb-1"><?php echo $safeName; ?></h5></a>
                                        <p class="text-muted mb-0"><?php echo htmlspecialchars($title,ENT_QUOTES,'UTF-8');?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- TEAM COUNT + PACKAGES -->
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                <div class="row text-center">
                                    <div class="col-6 border-end">
                                        <h5 class="mb-1"><?php echo $teamCount; ?></h5>
                                        <p class="text-muted mb-0"><?php echo $childType == 'customer'? 'Total Referred Customers': 'Total Team Member';?></p>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="mb-1"><?php echo $packageCount; ?></h5>
                                        <p class="text-muted mb-0">Total Packages</p>
                                    </div>
                                </div>
                            </div>
                            <!-- PHONE -->
                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                <h5 class="mb-1">Phone No</h5>
                                <p class="text-muted mb-0"><?php echo $safePhone; ?></p>
                            </div>
                            <!-- VIEW PROFILE -->
                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                <div class="text-center">
                                    <a href="#" onclick="overviewPage('<?php echo htmlspecialchars($memberId . ',' .$referenceNo . ',' .$country . ',' .$state . ',' .$city . ',' .$childType,ENT_QUOTES,'UTF-8');?>'); return false;" class="btn btn-primary view-btn">View Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </button>
            <!-- CHILD PANEL -->
            <div class="panel">
                <?php
                /*
                |--------------------------------------------------------------------------
                | RECURSION
                |--------------------------------------------------------------------------
                */
                renderTeamHierarchy($conn,$memberId,$childType,$hierarchyConfig,$level + 1);
                ?>
            </div>
            <?php
        }
    }
    /*
    |--------------------------------------------------------------------------
    | No Members Found
    |--------------------------------------------------------------------------
    |
    | Only display at root level.
    | Child levels remain empty.
    |
    */
    if ($hasMembers === false && $level == 0) {
        ?>
        <div class="card">
            <div class="card-body text-center py-4">
                <div class="text-muted">
                    No team members found.
                </div>
            </div>
        </div>
        <?php
    }
}