<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    $selectedYear = isset($_POST['year']) && $_POST['year'] != ''
    ? (int)$_POST['year']
    : null;

    /*
    |--------------------------------------------------------------------------
    | Get Available Years
    |--------------------------------------------------------------------------
    */

    $yearSql = $conn->prepare("
        SELECT DISTINCT YEAR(register_date) AS year
        FROM ca_customer
        WHERE ta_reference_no = :userId
        AND status = 1
        ORDER BY year DESC
    ");

    $yearSql->execute([
        ':userId' => $userId
    ]);

    $currentYear = (int)date('Y');

    $years = array_map('intval', $yearSql->fetchAll(PDO::FETCH_COLUMN));

    // Always include the current year
    if (!in_array($currentYear, $years)) {
        array_unshift($years, $currentYear);
    }

    // Remove duplicates and sort descending
    $years = array_values(array_unique($years));
    rsort($years);

    // Always select the current year by default unless the user selected another
    if (isset($_POST['year']) && $_POST['year'] != '') {
        $selectedYear = (int)$_POST['year'];
    } else {
        $selectedYear = $currentYear;
    }

    /*
    |--------------------------------------------------------------------------
    | Customer Growth Month Wise
    |--------------------------------------------------------------------------
    */

    $sql = $conn->prepare("
        SELECT
            MONTH(register_date) AS month_no,
            COUNT(*) AS total
        FROM ca_customer
        WHERE ta_reference_no = :userId
        AND status = 1
        AND YEAR(register_date) = :year
        GROUP BY MONTH(register_date)
        ORDER BY MONTH(register_date)
    ");

    $sql->execute([
        ':userId' => $userId,
        ':year'   => $selectedYear
    ]);

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    $labels = [
        'Jan','Feb','Mar','Apr','May','Jun',
        'Jul','Aug','Sep','Oct','Nov','Dec'
    ];

    $chartData = array_fill(0,12,0);

    foreach($result as $row){
        $chartData[$row['month_no']-1] = (int)$row['total'];
    }

    echo json_encode([
        'status'=>true,
        'years'=>$years,
        'selectedYear'=>$selectedYear,
        'labels'=>$labels,
        'data'=>$chartData
    ]);

}catch(Exception $e){

    echo json_encode([
        'status'=>false,
        'message'=>$e->getMessage(),
        'years'=>[],
        'labels'=>[],
        'data'=>[]
    ]);

}