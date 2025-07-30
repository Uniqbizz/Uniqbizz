<?php
require '../../connect.php';

$month_year = $_POST['month_year'] ?? '';
if (empty($month_year)) {
    $month_year = date('Y-m'); // Gets current year and month (YYYY-MM)
}
list($year, $month) = explode('-', $month_year);
$year = (int) $year;
$month = (int) $month;
$design = $_POST['designation'];

$options = '<option value="">--Select User ID & Name First--</option>';

// Function to extract name from message
function extractNameId($message, $prefix) {
    preg_match("/$prefix - (.*?) earned/", $message, $matches);
    return !empty($matches[1]) ? $matches[1] : null;
}

// Define mapping of designations to tables and columns
$mapping = [
    'bm'  => ['table' => 'bm_payout_history',  'user_col' => 'bm_user_id',  'message_col' => 'message_bm',  'prefix' => 'BM'],
    'bdm' => ['table' => 'bdm_payout_history', 'user_col' => 'bdm_user_id', 'message_col' => 'message_bdm', 'prefix' => 'BDM'],
    'bcm' => ['table' => 'bcm_payout_history', 'user_col' => 'bcm_user_id', 'message_col' => 'message_bcm', 'prefix' => 'BCM']
];

if (isset($mapping[$design])) {
    $table = $mapping[$design]['table'];
    $user_col = $mapping[$design]['user_col'];
    $message_col = $mapping[$design]['message_col'];
    $prefix = $mapping[$design]['prefix'];

    // ✅ Fetch distinct user IDs and messages for the given month and year
    $stmt = $conn->prepare("
        SELECT DISTINCT $user_col, $message_col
        FROM $table 
        WHERE MONTH(payout_date) = ? 
        AND YEAR(payout_date) = ?
    ");
    $stmt->execute([$month, $year]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Array to store unique user IDs and names
    $unique_users = [];

    // Loop through each row to extract user names
    foreach ($data as $row) {
        $user_id = $row[$user_col];
        $message = $row[$message_col];

        if (!empty($user_id) && !empty($message)) {
            $name_id = extractNameId($message, $prefix);
            if ($name_id && !isset($unique_users[$user_id])) {
                // Store unique user IDs and names
                $unique_users[$user_id] = $name_id;
            }
        }
    }

    // Build options for the dropdown
    foreach ($unique_users as $user_id => $name) {
        $options .= '<option value="' . htmlspecialchars($user_id) . '">' . htmlspecialchars($name) . '</option>';
    }
}

// Return unique options for dropdown
echo $options;
?>
