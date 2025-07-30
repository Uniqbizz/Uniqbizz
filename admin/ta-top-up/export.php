<?php
require '../connect.php';

// Check if we are downloading all records
if (isset($_GET['all']) && $_GET['all'] == 'true') {
    $stmt = $conn->prepare("SELECT ta_id FROM `ta_top_up_payment` GROUP BY ta_id");
    $stmt->execute();
    $allTAs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $ta_ids = array_column($allTAs, 'ta_id'); // Extract all TA IDs
} elseif (isset($_GET['ta_id'])) {
    $ta_ids = [$_GET['ta_id']]; // Single ID as an array
} else {
    die("No TA ID provided.");
}

// Set Headers for CSV Download
$filename = isset($_GET['all']) ? "All_TopUps.csv" : "TA_" . $_GET['ta_id'] . "_TopUps.csv";
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// Open Output Buffer
$output = fopen('php://output', 'w');

// Write Column Headers for Main Table
fputcsv($output, ['ID', 'Name of TA', 'Total Pending TopUp']);

// Fetch Data for Each TA
foreach ($ta_ids as $ta_id) {
    $stmt = $conn->prepare("SELECT ta_id, ta_fname, ta_lname, SUM(top_up_amt) AS total_pending_amt 
                            FROM `ta_top_up_payment` 
                            WHERE status = 1 AND ta_id = ? 
                            GROUP BY ta_id 
                            ORDER BY ta_id DESC");
    $stmt->execute([$ta_id]);
    $referral = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($referral) {
        fputcsv($output, [
            $referral["ta_id"],
            $referral['ta_fname'] . ' ' . $referral['ta_lname'],
            number_format($referral['total_pending_amt'], 2)
        ]);
    }
}

// Add Space Between Tables
fputcsv($output, []);
fputcsv($output, ['ID', 'TA Name', 'TopUp Amount', 'Payment Method', 'Created Date', 'Updated Date', 'Status']);

// Fetch Nested Data for Each TA
foreach ($ta_ids as $ta_id) {
    $stmt = $conn->prepare("SELECT * FROM `ta_top_up_payment` WHERE status = 1 AND ta_id = ? ORDER BY ID DESC");
    $stmt->execute([$ta_id]);
    $nestedReferrals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($nestedReferrals as $referral) {
        fputcsv($output, [
            $referral["ta_id"],
            $referral['ta_fname'] . ' ' . $referral['ta_lname'],
            number_format($referral['top_up_amt'], 2),
            $referral['pay_mode'],
            $referral['created_date'],
            $referral['updated_date'],
            'Pending'
        ]);
    }
}

// Close Output
fclose($output);
exit;
?>
