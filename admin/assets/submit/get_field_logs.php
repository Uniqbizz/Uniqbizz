<?php
    include '../../connect.php';
    include 'get_table_user_type.php';

    $record_id  = $_POST['user_id'];
    $table      = $_POST['table_name'];
    $column     = $_POST['column_name'];

    /* -------------------------
    FETCH LAST EDIT LOG
    ------------------------- */

    $stmt = $conn->prepare("
        SELECT column_name, old_value, new_value, changed_role,change_reason, created_at
        FROM field_edit_logs
        WHERE record_id = :record_id
        AND table_name = :table_name
        AND column_name = :column_name
        ORDER BY created_at DESC
        LIMIT 1
    ");

    $stmt->execute([
        ':record_id'   => $record_id,
        ':table_name'  => $table,
        ':column_name' => $column
    ]);

    $log = $stmt->fetch(PDO::FETCH_ASSOC);

    $output = "";

    if($log){

        $column_name = $log['column_name'];

        $field = ucfirst(str_replace("_"," ",$column_name));

        $old   = htmlspecialchars($log['old_value']);
        $new   = htmlspecialchars($log['new_value']);
        $admin = htmlspecialchars($log['changed_role']);

        /* -------------------------
        LOOKUP TABLES
        ------------------------- */

        $lookup = [

            'country' => [
                'table' => 'countries',
                'column'=> 'country_name'
            ],

            'state' => [
                'table' => 'states',
                'column'=> 'state_name'
            ],

            'city' => [
                'table' => 'cities',
                'column'=> 'city_name'
            ]

        ];

        if(isset($lookup[$column_name])){

            $lookupTable = $lookup[$column_name]['table'];
            $lookupCol   = $lookup[$column_name]['column'];

            $stmtLookup = $conn->prepare("
                SELECT $lookupCol 
                FROM $lookupTable 
                WHERE status = 1 AND id = :id
            ");

            /* OLD VALUE */

            $stmtLookup->execute([':id'=>$old]);
            $oldData = $stmtLookup->fetch(PDO::FETCH_ASSOC);

            if($oldData){
                $old = $oldData[$lookupCol];
            }

            /* NEW VALUE */

            $stmtLookup->execute([':id'=>$new]);
            $newData = $stmtLookup->fetch(PDO::FETCH_ASSOC);

            if($newData){
                $new = $newData[$lookupCol];
            }
        }

        $date = date("d-M-Y g:i A", strtotime($log['created_at']));
        $change_reason = $log['change_reason'];

        /* -------------------------
        TOOLTIP OUTPUT
        ------------------------- */

        $output .= "

        <div class='edit-log-card'>

            <div class='edit-log-title'>
                <b>$field</b> Updated
            </div>

            <div class='edit-log-grid'>

                <div class='edit-old'>
                    <div class='label'>Old</div>
                    <div class='value'>$old</div>
                </div>

                <div class='edit-arrow'>→</div>

                <div class='edit-new'>
                    <div class='label'>New</div>
                    <div class='value'>$new</div>
                </div>

            </div>

            <div class='edit-log-meta'>
                <span>Changed by <b>$admin</b></br>
                $change_reason
                </span>
                <span>On <b>$date</b></span>
            </div>

        </div>

        ";

    }else{

        $output = "No edit history found.";

    }

    echo $output;
?>