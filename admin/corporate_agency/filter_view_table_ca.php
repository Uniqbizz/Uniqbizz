<?php

    require "../connect.php";

    $package = $_POST['package'];
    // $converted = $_POST['converted'];
    // $complimentary = $_POST['complimentary'];
    $startFrom = $_POST['StartFrom'];
    $endFrom = $_POST['EndFrom'];

    // echo $package;
    // echo $converted;
    // echo $complimentary;

    // if($package){
    //     $stmt = $conn->prepare("SELECT *,SUBSTRING(super_franchisee_id,4,6) as sp_id FROM super_franchisee WHERE business_package='".$package."'  AND status='1' order by super_franchisee_id ");
    // }else if{
    //     $stmt = $conn->prepare("SELECT *,SUBSTRING(super_franchisee_id,4,6) as sp_id FROM super_franchisee WHERE (complimentary='".$complimentary."' or converted='".$converted."') OR (complimentary='".$complimentary."' AND converted='".$converted."') AND status='1'  order by super_franchisee_id ");
    // }
    if($package  && !$startFrom && !$endFrom){
        $stmt = $conn->prepare("SELECT *,SUBSTRING(corporate_agency_id,3,6) as ca_id FROM corporate_agency WHERE amount='".$package."' AND status='1' order by corporate_agency_id ");
    }else if($package  && $startFrom && !$endFrom){
        $stmt = $conn->prepare("SELECT * ,SUBSTRING(corporate_agency_id,3,6) as ca_id FROM corporate_agency WHERE amount='".$package."' AND register_date >= '".$startFrom."' AND status='1' order by corporate_agency_id ");
    }else if($package && $startFrom && $endFrom){
        $stmt = $conn->prepare("SELECT * ,SUBSTRING(corporate_agency_id,3,6) as ca_id FROM corporate_agency WHERE amount='".$package."' AND register_date >= '".$startFrom."' AND register_date <= '".$endFrom."' AND status='1' order by corporate_agency_id ");
    }else if(!$package && $startFrom && $endFrom){
        $stmt = $conn->prepare("SELECT * ,SUBSTRING(corporate_agency_id,3,6) as ca_id FROM corporate_agency WHERE register_date >= '".$startFrom."' AND register_date <= '".$endFrom."' AND status='1' order by corporate_agency_id ");
    }else {
        $stmt = $conn->prepare("SELECT * ,SUBSTRING(corporate_agency_id,3,6) as ca_id FROM corporate_agency WHERE status='1' order by corporate_agency_id ");
    }
    // else{
    //     $stmt = $conn->prepare("SELECT *,SUBSTRING(corporate_agency_id,3,6) as ca_id FROM corporate_agency WHERE amount='".$package."' AND complimentary='".$complimentary."' AND converted='".$converted."' AND status='1' order by corporate_agency_id ");
    // }
    // print_r($stmt);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

        echo' 
            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="filterTable">
                <thead class="table-light">
                    <tr>
                        <th>Corporate Agency Id</th>
                        <th>Full Name</th>
                        <th>Reference ID / Name</th>
                        <th>Phone / Email</th>
                        <th>Amount</th>
                        <th>Joining Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

                if($stmt->rowCount()>0){
                    foreach (($stmt->fetchAll()) as $key => $row) {
                        $dt= new DateTime($row['register_date']);
                        $datev= $dt->format('d-m-Y');
                        $bd= new DateTime($row['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $deleted_date= new DateTime($row['deleted_date']);
                        $ddate= $deleted_date->format('d-m-Y'); 
                        $kyc = false;

                        if ( $bdate !== "0000-00-00" && $row['pan_card'] !== "" && $row['aadhar_card'] !== "" && $row['voting_card'] == "" && $row['bank_passbook'] !== "" ) {
                            $kyc = true;
                        } else if ( $bdate !== "0000-00-00" && $row['pan_card'] !== "" && $row['aadhar_card'] == "" && $row['voting_card'] !== "" && $row['bank_passbook'] !== "" ) {
                            $kyc = true;
                        } else {
                            $kyc = false;
                        }
                        echo'<tr>
                            <td>'.$row['corporate_agency_id'].'</td>
                            <td>'.$row['firstname'].' '.$row['lastname'].'</td>
                            <td><p class="mb-1">'.$row['reference_no'].'</p>
                                <p class="mb-0">'.$row['registrant'].'</p>
                            </td>
                            <td>
                                <p class="mb-1">+'.$row['country_code'].' '.$row['contact_no'].'</p>
                                <p class="mb-0">'.$row['email'].'</p>
                            </td>
                            <td>'.$row['amount'].'</td>
                            <td>'.$datev.'</td>';
                            if($row['status']== '1'){
                                echo'<td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-2">
                                            <li><a href="#" onclick=\'overviewPage("'.$row["corporate_agency_id"]. '","' .$row["reference_no"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","corporate_agency")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-eye font-size-16 text-info me-1"></i> View</a></li>
                                            <li><a href="#" onclick=\'editfuncCust("'.$row["corporate_agency_id"]. '","' .$row["reference_no"]. '","' .$row["register_by"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","registered")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                            <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","'.$row["corporate_agency_id"]. '","registered")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                        </ul>
                                    </div>
                                </td>';
                            }else{
                                echo'<td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-2">
                                            <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","'.$row["corporate_agency_id"]. '","deactivate")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
                                        </ul>
                                    </div>
                                </td>';
                            }
                        echo'</tr>';
                    }      
                }else{
                    echo '<tr>
                                <td style="text-align:center" colspan="7">No Registered Corporate Agency
                        </td>
                    <tr>';
                }
                echo'</tbody>
                </table>
                </div>';
?>