<?php    
require '../connect.php';

$formdata = stripslashes(file_get_contents("php://input"));
$get_data = json_decode($formdata, true);

$get_year = $get_data['year'];
$current_year = $get_data['current_year'];
$current_month = $get_data['current_month'];
$user_id = $get_data['user_id'];
$user_type = $get_data['user_type'];

function monthlyChartData($conn, $reference_no, $get_year, $current_year, $current_month, $user_type){
    $data = array_fill(0, 12, 0);

    $tableMap = [
        '3'  => 'corporate_agency',
        '10' => 'ca_customer',
        '11' => 'ca_customer',
        '15' => 'ca_travelagency',
        '16' => 'ca_travelagency',
        '18' => 'business_consultant',
        '19' => 'business_operation_executive',
        '20' => 'training_manager',
        '21' => 'sales_executive',
        '25' => 'business_mentor',
        '26' => 'corporate_agency'
    ];

    $columnMap = [
        '11' => 'ta_reference_no'
    ];

    if (array_key_exists($user_type, $tableMap)) {
        $table = $tableMap[$user_type];
        $refCol = $columnMap[$user_type] ?? 'reference_no';

        $sql = "SELECT MONTH(register_date) AS start_month, YEAR(register_date) AS start_year 
                FROM $table 
                WHERE $refCol = :reference_no AND status = '1'";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':reference_no' => $reference_no]);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            if ($row['start_year'] == $get_year) {
                $data[$row['start_month'] - 1] += 1;
            }
        }

        if ($current_year == $get_year) {
            array_splice($data, $current_month);
        }
    }

    return $data;
}

// Special case for BCM → return 3 separate arrays
if ($user_type == '24') {
    $bdm = array_fill(0, 12, 0);
    $bm = array_fill(0, 12, 0);
    $tc = array_fill(0, 12, 0);

    // BDMs under BCM
    $sql = "SELECT MONTH(register_date) AS start_month, YEAR(register_date) AS start_year 
            FROM employees 
            WHERE reporting_manager = :ref AND status = '1' AND user_type = 25";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        if ($row['start_year'] == $get_year) {
            $bdm[$row['start_month'] - 1] += 1;
        }
    }

    // BMs under BDMs
    $sql = "SELECT MONTH(bm.register_date) AS start_month, YEAR(bm.register_date) AS start_year 
            FROM employees AS bdm
            JOIN business_mentor AS bm ON bm.reference_no = bdm.employee_id
            WHERE bdm.reporting_manager = :ref AND bdm.user_type = 25 AND bdm.status = '1'
              AND bm.user_type = 26 AND bm.status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        if ($row['start_year'] == $get_year) {
            $bm[$row['start_month'] - 1] += 1;
        }
    }

    // TCs under BMs
    $sql = "SELECT MONTH(tc.register_date) AS start_month, YEAR(tc.register_date) AS start_year 
            FROM employees AS bdm
            JOIN business_mentor AS bm ON bm.reference_no = bdm.employee_id
            JOIN ca_travelagency AS tc ON tc.reference_no = bm.business_mentor_id
            WHERE bdm.reporting_manager = :ref AND bdm.user_type = 25 AND bdm.status = '1'
              AND bm.user_type = 26 AND bm.status = '1' AND tc.status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        if ($row['start_year'] == $get_year) {
            $tc[$row['start_month'] - 1] += 1;
        }
    }

    if ($current_year == $get_year) {
        array_splice($bdm, $current_month);
        array_splice($bm, $current_month);
        array_splice($tc, $current_month);
    }

    echo json_encode([$bdm, $bm, $tc]);
} else if ($user_type == '25') {
    // For BDM → BM → TC
    $bm = array_fill(0, 12, 0);
    $tc = array_fill(0, 12, 0);

    // Get direct BMs
    $sql = "SELECT business_mentor_id, register_date FROM business_mentor 
            WHERE reference_no = :ref AND user_type = 26 AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    $bmRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($bmRows as $row) {
        $date = $row['register_date'];
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date)); // 1-based
        if ($year == $get_year) {
            $bm[$month - 1]++;
        }
    }

    // Get TCs under those BMs
    $bmIds = array_column($bmRows, 'business_mentor_id');
    if (!empty($bmIds)) {
        $inClause = implode(',', array_fill(0, count($bmIds), '?'));
        $sql = "SELECT register_date FROM ca_travelagency 
                WHERE reference_no IN ($inClause) AND status = '1'";
        $stmt = $conn->prepare($sql);
        $stmt->execute($bmIds);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $year = date('Y', strtotime($row['register_date']));
            $month = date('n', strtotime($row['register_date']));
            if ($year == $get_year) {
                $tc[$month - 1]++;
            }
        }
    }

    if ($current_year == $get_year) {
        array_splice($bm, $current_month);
        array_splice($tc, $current_month);
    }

    echo json_encode([ $bm, $tc ]);

} else if ($user_type == '26') {
    // For BM → TC only
    $tc = array_fill(0, 12, 0);

    $sql = "SELECT register_date FROM ca_travelagency 
            WHERE reference_no = :ref AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $year = date('Y', strtotime($row['register_date']));
        $month = date('n', strtotime($row['register_date']));
        if ($year == $get_year) {
            $tc[$month - 1]++;
        }
    }

    if ($current_year == $get_year) {
        array_splice($tc, $current_month);
    }

    echo json_encode([ $tc ]);
} else {
    // fallback for other users
    $data = monthlyChartData($conn, $user_id, $get_year, $current_year, $current_month, $user_type);
    echo json_encode([$data]);
}
?>
