<?php

include_once (__DIR__ .'/../../dashboard_user_details.php');

header('Content-Type: application/json');

$sql = "SELECT * FROM ca_customer
        WHERE reference_no = ?
        AND (status='1' OR status='3')";

$stmt = $conn->prepare($sql);
$stmt->execute([$userId]);

$data = [];

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

    $date = date('d-m-Y', strtotime($row['register_date']));

    $comp = ($row['comp_chek'] == '1')
        ? 'Complimentary'
        : 'Noncomplimentary';

    $status = ($row['status']=='3')
        ? '<span class="badge bg-danger">Deleted</span>'
        : '<span class="badge bg-success">Active</span>';

    $action = '';

    if(in_array($userType,['10','11','33'])){

        if($userType == '10'){

            if($row['status']=='1'){

                $action = '
                <div class="dropdown d-inline-block">
                    <button class="btn btn-soft-secondary btn-sm dropdown"
                        data-bs-toggle="dropdown">
                        <i class="ri-more-fill align-middle"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a class="dropdown-item"
                                onclick=\'editfunc("'.$row["ca_customer_id"].'",
                                "'.$row["country"].'",
                                "'.$row["state"].'",
                                "'.$row["city"].'",
                                "registered")\'>
                                <i class="ri-pencil-fill me-2"></i>Edit
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                                onclick=\'deletefunc("'.$row["id"].'",
                                "'.$row["ca_customer_id"].'",
                                "'.$row["reference_no"].'",
                                "registered",
                                "'.$userId.'",
                                "'.$userType.'")\'>
                                <i class="ri-delete-bin-fill me-2"></i>Delete
                            </a>
                        </li>

                    </ul>
                </div>';

            }else{

                $action='
                <div class="dropdown d-inline-block">
                    <button class="btn btn-soft-secondary btn-sm dropdown"
                        data-bs-toggle="dropdown">
                        <i class="ri-more-fill align-middle"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a class="dropdown-item"
                                onclick=\'deletefunc("'.$row["id"].'",
                                "'.$row["ca_customer_id"].'",
                                "'.$row["reference_no"].'",
                                "deactivate",
                                "'.$userId.'",
                                "'.$userType.'")\'>
                                <i class="ri-arrow-go-back-fill me-2"></i>Restore
                            </a>
                        </li>

                    </ul>
                </div>';
            }
        }
    }

    $record = [
        '<p>'.$row['ca_customer_id'].'</p>
         <p>'.$row['firstname'].' '.$row['lastname'].'</p>',

        '<p>'.$row['ta_reference_no'].' '.$row['ta_reference_name'].'</p>
         <p>'.$row['reference_no'].' '.$row['registrant'].'</p>',

        '<p class="mb-0">'.$row['customer_type'].'</p>
         <p class="mb-0">'.$comp.'</p>',

        $row['contact_no'],

        $date,

        $status
    ];

    if(in_array($userType,['10','11','33'])){
        $record[] = $action;
    }

    $data[] = $record;
}

echo json_encode([
    "data"=>$data
]);