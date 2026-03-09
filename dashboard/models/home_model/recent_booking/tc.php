<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">Recent Bookings</h5>
                        </div>
                    </div>
                    
                </div>   
            </div>    
            <div class="card-body">
                <table id="example-dataTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th data-ordering="false">Booking ID</th>
                            <th data-ordering="false">Customer Name</th>
                            <th data-ordering="false">Package Name</th>
                            <th data-ordering="false">Amount</th>
                            <th data-ordering="false">Booking Date</th>
                            <th data-ordering="false">Travel Date</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                            if($userType == "11" || $userType == "33"){
                                $sql = "SELECT order_id,bookings.name,package.name as package_name,booking_direct_bill.total_net_payable as amount,bookings.created_date as booking_date,bookings.date as travel_date 
                                        FROM `bookings`
                                        INNER JOIN booking_direct_bill on booking_direct_bill.bookings_id=bookings.id
                                        INNER JOIN package on package.id = package_id 
                                        WHERE ta_id = '".$userId."' LIMIT 5";
                                $stmt = $conn -> prepare($sql);
                                $stmt -> execute();
                                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                if($stmt -> rowCount()>0){
                                    foreach(($stmt -> fetchAll()) as $key => $row){
                                        $bd= new DateTime($row['booking_date']);
                                        $bdate= $bd->format('d-m-Y');
                                        $dt= new DateTime($row['travel_date']);
                                        $datev= $dt->format('d-m-Y'); 
                                        echo'<tr>
                                            <td>'.$row['order_id'].'</td>
                                            <td>'.$row['name'].'</td>
                                            <td>'.$row['package_name'].'</td>
                                            <td>'.$row['amount'].'</td>
                                            <td>'.$bdate.'</td>
                                            <td>'.$datev.'</td>';
                                        echo'</tr>';
                                    }
                                }
                            }
                            
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>