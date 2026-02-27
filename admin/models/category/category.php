<?php
    require '../../connect.php';
    
    $stmt = $conn->prepare("SELECT * FROM category where status='1' ");
    $stmt->execute();

        // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if($stmt->rowCount()>0){
        foreach (($stmt->fetchAll()) as $key => $row) {
            $cat_id= $row['id'];
            $category_name= $row['category_name'];
        
            echo 
            '<tr>
                <td class="ps-4 fw-bolder"><span class="list-enq-name">'.$category_name.'</span></td>
                
                <td>
                    <a onclick=\'editfuncCat("' .$cat_id. '")\'><i class="mdi mdi-pencil text-success mdi-24px" aria-hidden="true"></i></a>
                </td>
                <td>
                    <a href="#" onclick=\'deletefunc("' .$cat_id. '")\'><i class="mdi mdi-trash-can text-danger mdi-24px" aria-hidden="true"></i></a>
                </td>
            </tr>';
        }
    } else{
            echo 
                '<tr>
                    <td colspan="4">No Category Available
                    </td>
                <tr>';
        }
?> 