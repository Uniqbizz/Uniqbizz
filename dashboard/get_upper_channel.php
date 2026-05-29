<?php
    function get_reference($conn,$ref_no){
        $reference_no = substr($ref_no,0,1) == 'F' || substr($ref_no,0,1) == 'I' 
                            ? substr($ref_no,0,1)
                            : substr($ref_no,0,2);
        $ref_arr=[];
        $name=$id='NA';
        if ($reference_no == "TE" || $reference_no == "CA") {
            $sql2 = "SELECT * FROM `corporate_agency` WHERE corporate_agency_id = '".$ref_no."' AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
            $stmt2 = $conn -> prepare($sql2);
            $stmt2 -> execute();
            $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($stmt2->rowCount()>0){
                foreach(($stmt2->fetchAll()) as $key2 => $row2){
                    $name = $row2['registrant'];
                    $id = $row2['reference_no'];
                }
            }
        }else if($reference_no == "BM"){
            $sql2 = "SELECT * FROM `business_mentor` WHERE business_mentor_id = '".$ref_no."' AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
            $stmt2 = $conn -> prepare($sql2);
            $stmt2 -> execute();
            $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($stmt2->rowCount()>0){
                foreach(($stmt2->fetchAll()) as $key2 => $row2){
                    $name = $row2['registrant'];
                    $id = $row2['reference_no'];
                }
            }
        }else if ($reference_no == "F") {
            $sql2 = "SELECT registrant,reference_no FROM `sub_franchisee` WHERE sub_franchisee_id = '".$ref_no."' AND (status = '1' OR status = '3') ORDER BY sponsor_franchisee_id ASC ";
            $stmt2 = $conn -> prepare($sql2);
            $stmt2 -> execute();
            $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($stmt2->rowCount()>0){
                foreach(($stmt2->fetchAll()) as $key2 => $row2){
                    $name = $row2['registrant'];
                    $id = $row2['reference_no'];
                }
            }
        }else if ($reference_no == "I") {
            $sql2 = "SELECT registrant,reference_no FROM `institution` WHERE institution_id = '".$ref_no."' AND (status = '1' OR status = '3') ORDER BY institution_id ASC ";
            $stmt2 = $conn -> prepare($sql2);
            $stmt2 -> execute();
            $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($stmt2->rowCount()>0){
                foreach(($stmt2->fetchAll()) as $key2 => $row2){
                    $name = $row2['registrant'];
                    $id = $row2['reference_no'];
                }
            }
        }else if($reference_no == "MF"){
            $sql2 = "SELECT registrant,reference_no FROM `master_franchisee` WHERE master_franchisee_id = '".$ref_no."' AND (status = '1' OR status = '3') ORDER BY master_franchisee_id ASC ";
            $stmt2 = $conn -> prepare($sql2);
            $stmt2 -> execute();
            $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($stmt2->rowCount()>0){
                foreach(($stmt2->fetchAll()) as $key2 => $row2){
                    $name = $row2['registrant'];
                    $id = $row2['reference_no'];
                }
            }
        }else if($reference_no == "SF"){
            $sql2 = "SELECT registrant,reference_no FROM `sponsor_franchisee` WHERE sponsor_franchisee_id = '".$ref_no."' AND (status = '1' OR status = '3') ORDER BY master_franchisee_id ASC ";
            $stmt2 = $conn -> prepare($sql2);
            $stmt2 -> execute();
            $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($stmt2->rowCount()>0){
                foreach(($stmt2->fetchAll()) as $key2 => $row2){
                    $name = $row2['registrant'];
                    $id = $row2['reference_no'];
                }
            }
        }
        $ref_arr[] = $name;
        $ref_arr[] = $id;

        return $ref_arr;
    }
?>