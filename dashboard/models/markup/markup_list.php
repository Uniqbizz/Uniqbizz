<?php
    $filter = $_GET['travelType'] ?? '';
    $query = "SELECT p.id, p.description, name, t.markup_total, t.total_package_price_per_adult, t.total_package_price_per_child, pt.ca_direct_commission, c.category_name
                FROM package p, package_pricing t, category c, package_pricing_markup pt
                WHERE p.id = t.package_id 
                AND p.category_id = c.id
                AND p.id = pt.package_id
                AND p.status = '1' 
                AND c.status = '1'";

    if (!empty($filter)) {
        $query .= " AND c.category_name = :category";
    }

    $query .= " ORDER BY p.id DESC";

    $stmt = $conn->prepare($query);

    if (!empty($filter)) {
        $stmt->bindParam(':category', $filter);
    }
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt->rowCount()>0){

        foreach (($stmt->fetchAll()) as $key => $row) {
            $package_id = $row['id'];
            $adult_price = (float)$row['total_package_price_per_adult'];
            $child_price = (float)$row['total_package_price_per_child'];
            $te_direct_comm=(float)$row['ca_direct_commission'];
            //$markup_price = (float)$row['markup_total'];
            $Aproduct_price = $adult_price;
            $Cproduct_price = $child_price;
            
            $ta_markups = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id='".$userId."' AND package_id='".$package_id."' ");
            $ta_markups->execute();
            $ta_markups->setFetchMode(PDO::FETCH_ASSOC);
            $ta_markup = $ta_markups->fetch();
                $markup = $ta_markup['markup'] ?? 0;
                $markup_total = $ta_markup['selling_price_adult'] ?? $Aproduct_price;
                $markup_status = $ta_markup['status'] ?? 1;
            // $ta_commission = 0;
            $stmt2 = $conn->prepare("SELECT * FROM package_pricing_markup WHERE package_id='".$package_id."' ");
            $stmt2->execute();
            $stmt2->setFetchMode(PDO::FETCH_ASSOC);
            if($stmt2->rowCount()>0){
                foreach( ($stmt2->fetchAll()) as $key2 => $row2 ){
                    $ta_commission = $row2['ta_markup'];
                }
            }else{
                $ta_commission = 0;
            }

            echo '<tr style="text-align:left">
                <td> '.++$key.'</td>
                <td>'.$row['name'].'</td>
                <td>'.$row['category_name'].'</a></td>
                <td>Adult Price:₹ '.$Aproduct_price.'/PAX <br/>Child Price:₹ '.$Cproduct_price.'/PAX</td>';
                if ($userType =='11') {
    
                    echo'<td>₹ '.$ta_commission.'/PAX</td>';
                }else if($userType=='16' || $userType == '29'){
                    echo'<td>₹ '.$te_direct_comm.'/PAX</td>';
                }
                if($userType == '11'){ 
                    echo'<td>₹ <input type="text" id="markup_'.$package_id.'" value="'.$markup.'" style="padding:0px 4px; width:45px;" maxlength="4">/Package</td>';
                    echo'<td>₹ '.$markup_total.'</td>';
                    echo'<td> <button type="button" onclick=\'addMarkup("'.$userId.'","'.$package_id.'","'.$Aproduct_price.'","'.$Cproduct_price.'","0")\' class="btn btn-secondary">Add</button></td>';
                } else if ($userType == '16' || $userType == '29') {
                    echo'<td>';
                    echo '<button type="button" class="btn btn-secondary" ><a class="dropdown-item" href="dowload_pack_details.php?id='.urldecode($row["id"]).'" id="generatePDF"><i class="fa-solid fa-arrow-down"></i> Download Details</a></button>';
                        echo'</td>';
                    # code...
                }
            echo'</tr>';
        }
    } else {
        echo '<tr><td colspan="7">No Products to Display</td><tr>';
    }
?>