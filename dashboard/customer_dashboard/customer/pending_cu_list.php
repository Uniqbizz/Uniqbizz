<?php

include_once (__DIR__ .'/../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    $sql = "SELECT * FROM ca_customer
            WHERE reference_no = ?
            AND (status = '2' OR status = '0')";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$userId]);

    $data = [];

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        $date = date('d-m-Y', strtotime($row['added_on']));

        $status = ($row['status'] == '2')
            ? '<span class="badge bg-warning">Pending</span>'
            : '<span class="badge bg-danger">Deleted</span>';

        $data[] = [
            $row['id'],
            $row['firstname'].' '.$row['lastname'],
            '<p>'.$row['ta_reference_no'].' '.$row['ta_reference_name'].'</p>
             <p>'.$row['reference_no'].' '.$row['registrant'].'</p>',
            $row['contact_no'],
            $date,
            $status
        ];
    }

    echo json_encode([
        "data" => $data
    ]);

}catch(Exception $e){

    echo json_encode([
        "data" => [],
        "error" => $e->getMessage()
    ]);

}