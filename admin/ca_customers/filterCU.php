<table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="registeredCustomerList-tableFilter">
    <thead class="table-light">
        <tr>
            <th>Customer Id/Full Name</th>
            <th>Reference ID / Name</th>
            <th>Phone / Email</th>
            <th>Type/Complemetory</th>
            <th>Address</th>
            <th>Joining Date</th>
            <th>status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        require '../connect.php';

        // session_start();

        // if(!isset($_SESSION['username'])){
        //     echo '<script>location.href = "../login.php";</script>';
        // }

        $state = $_POST['state'];
        if($state == '0'){
            $sql = "SELECT * FROM `ca_customer` WHERE (status = '1' OR status = '3') ORDER BY ca_customer_id ASC ";
        }else{
            $sql = "SELECT * FROM `ca_customer` WHERE state = '".$state."' AND (status = '1' OR status = '3') ORDER BY ca_customer_id ASC ";
        }
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0){
            foreach(($stmt->fetchAll()) as $key => $row) {
                $bd= new DateTime($row['date_of_birth']);
                $bdate= $bd->format('d-m-Y');

                $rd= new DateTime($row['register_date']);
                $rdate= $rd->format('d-m-Y');
                $comp_chek = $row['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 

                echo'<tr>
                    <td><p class="mb-1">'.$row['ca_customer_id'].'</p>
                        <p class="mb-1">'.$row['firstname'].' '.$row['lastname'].'</p>
                    </td>';

                    if($row['reference_no']){
                            echo'<td><p class="mb-1">'.$row['reference_no'].'</p>
                            <p class="mb-0">'.$row['registrant'].'</p>
                        </td>';
                    }else{
                        echo'<td><p class="mb-1">'.$row['ta_reference_no'].'</p>
                            <p class="mb-0">'.$row['ta_reference_name'].'</p>
                        </td>';
                    }

                    echo'<td>
                        <p class="mb-1">+'.$row['country_code'].' '.$row['contact_no'].'</p>
                        <p class="mb-0">'.$row['email'].'</p>
                    </td>
                    <td><p class="mb-0">'.$row['customer_type'].'</p><p class="mb-0">'.$comp_chek.'</p></td>
                    <td>'.$row['address'].'</td>
                    <td>'.$rdate.'</td>';
                    if($row['status']== '1'){
                        echo'<td><span class="badge text-bg-success">Active</span></td>
                        <td>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-2">
                                    <li><a href="#" onclick=\'overviewPage("'.$row["ca_customer_id"]. '","' .$row["reference_no"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","ca_customer")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-eye font-size-16 text-info me-1"></i> View</a></li>
                                    <li><a href="#" onclick=\'editfuncCust("'.$row["ca_customer_id"]. '","' .$row["reference_no"]. '","' .$row["register_by"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","registered")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                    <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","'.$row["ca_customer_id"]. '","registered")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                </ul>
                            </div>
                        </td>';
                    }else{
                        echo'<td><span class="badge text-bg-danger">Deactive</span></td>
                        <td>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-2">
                                    <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","'.$row["ca_customer_id"]. '","deactivate")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
                                </ul>
                            </div>
                        </td>';
                    }
                echo'</tr>';
            }
        }
           
    ?> 

    </tbody>
</table>