<?php
include '../../connect.php';
include 'get_table_user_type.php';
$record_id  = $_POST['user_id'];
$table      = $_POST['table_name'];
$column     = $_POST['column_name'];

$stmt = $conn->prepare("
    SELECT column_name, old_value, new_value, changed_role, created_at
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

    $field = ucfirst(str_replace("_"," ",$log['column_name']));
    $old   = htmlspecialchars($log['old_value']);
    $new   = htmlspecialchars($log['new_value']);
    $admin = htmlspecialchars($log['changed_role']);

    $date = date("d-M-Y g:i A", strtotime($log['created_at']));

   $output .= "
            <div class='edit-log-card'>

            <div class='edit-log-title'><b>$field</b> Updated</div>

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
            <span>Changed by <b>$admin</b></span>
            <span>On <b>$date</b> </span>
            </div>

            </div>
            ";
}
else{
    $output = "No edit history found.";
}

echo $output;
?>