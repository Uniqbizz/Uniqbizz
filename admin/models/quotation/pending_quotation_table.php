<?php
    require '../../connect.php';
    
    $stmt = $conn->prepare("SELECT * FROM quotations where status='0'");
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
        
            echo '<tr>
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
                                <li><a href="#" style="color:white" class="text-primary m-2"  onclick=\'updateQuotations("' .$quotation_id. '")\'><i class="mdi mdi-rotate-right font-size-16 text-info me-1"></i>Pending</a></li>
                                <li><a class="text-primary m-2" href="quotation/view_quotation?vkvbvjfgfikix='.$quotation_id.'"><i class="mdi mdi-eye font-size-16 text-info me-1"></i>View</a></li>
                                <li><a class="text-success m-2"><i class="mdi mdi-motion-pause font-size-16 text-info me-1"></i>On Hold</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>';
        } 
    }
    
?>