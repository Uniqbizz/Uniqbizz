<?php
    require '../../connect.php';
    $stmt = $conn->prepare("SELECT * FROM quotations where status='1'");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if($stmt->rowCount()>0){
        foreach (($stmt->fetchAll()) as $key => $row) {
            $quotation_id =$row['id'];
            $name= $row['name'];
            $email= $row['email'];
            $phone_no= $row['phone_no'];
            $destination= $row['destination'];
            $date= $row['date'];
            $package_suggetion = $row['package_suggetion'];
            
        //  $name= $row['name'];
            echo'<tr>
                <td><span class="list-enq-name">'.++$key.'</span></td>
                <td><span class="list-enq-name">'.$name.' </span></td>
                <td><span class="list-enq-name">'.$email.' </span></td>
                <td><span class="list-enq-name">'.$destination.' </span></td>
                <td><span class="list-enq-name">'.$date.' </span></td>
                <td>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-1">
                            <li><a class="text-success m-2 " href="#" onclick=\'updateQuotations("' .$quotation_id. '")\'><i class="fas fa-check-circle font-size-16 text-success me-1"></i>Verified</a></li>
                            <li><a class="text-primary m-2" href="../../views/quotation/view_quotation.php?vkvbvjfgfikix='.$quotation_id.'"><i class="mdi mdi-eye font-size-16 text-info me-1"></i>View</a></li>
                            <li><a class="text-success m-2"><i class="mdi mdi-alpha-s-circle font-size-16 text-success me-1"></i>Sold</a></li>
                        </ul>
                    </div>
                    
                </td>
            </tr>';
        } 
    }
?>