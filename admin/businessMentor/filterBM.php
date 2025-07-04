<table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="registeredCustomerList-tableFilter">
    <thead class="table-light">
        <tr>
            <th>Business Mentor Id</th>
            <th>Full Name</th>
            <th>Reference ID / Name</th>
            <th>Phone / Email</th>
            <th>Branch</th>
            <th>Joining Date</th>
            <th>Status</th>
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

        $branchFilter = $_POST['branch'];
  
        $sql = "SELECT * FROM `business_mentor` WHERE branch = '".$branchFilter."' AND (status = '1' OR status = '3') order by id";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0){
            foreach(($stmt->fetchAll()) as $key => $row) {
                $bd= new DateTime($row['date_of_birth']);
                $bdate= $bd->format('d-m-Y');

                $rd= new DateTime($row['register_date']);
                $rdate= $rd->format('d-m-Y');

                $branchID = $row['branch'];
                
                $sqlBranch = "SELECT * FROM `branch` WHERE id = '".$branchID."' ";
                $stmtId = $conn -> prepare($sqlBranch);
                $stmtId -> execute();
                $stmtId -> setFetchMode(PDO::FETCH_ASSOC);
                if($stmtId->rowCount()>0){
                    foreach(($stmtId->fetchAll()) as $keyId => $rowId) {
                        $branch = $rowId['branch_name'];
                    }
                }

                echo'<tr>
                    <td>'.$row['business_mentor_id'].'</td>
                    <td>'.$row['firstname'].' '.$row['lastname'].'</td>
                    <td><p class="mb-1">'.$row['reference_no'].'</p>
                        <p class="mb-0">'.$row['registrant'].'</p>
                    </td>
                    <td>
                        <p class="mb-1">+'.$row['country_code'].' '.$row['contact_no'].'</p>
                        <p class="mb-0">'.$row['email'].'</p>
                    </td>
                    <td>'.$branch.'</td>
                    <td>'.$rdate.'</td>';
                    if($row['status']== '1'){
                        echo'<td><span class="badge text-bg-success">Active</span></td>
                        <td>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end-2">
                                    <li><a href="#" onclick=\'overviewPage("'.$row["business_mentor_id"]. '","' .$row["reference_no"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","business_mentor")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-eye font-size-16 text-info me-1"></i> View</a></li>
                                    <li><a href="#" onclick=\'editfuncCust("'.$row["business_mentor_id"]. '","' .$row["reference_no"]. '","' .$row["register_by"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","' .$row["zone"]. '","' .$row["branch"]. '","registered")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                    <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","'.$row["business_mentor_id"]. '","registered")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
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
                                <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end-2">
                                    <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","'.$row["business_mentor_id"]. '","deactivate")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
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