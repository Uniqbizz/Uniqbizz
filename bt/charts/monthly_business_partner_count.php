<?php
    require '../connect.php';
        
    $formdata = stripslashes(file_get_contents("php://input"));
    $get_data = json_decode($formdata, true);

    $get_year = $get_data['year'];
    $current_year = $get_data['current_year'];
    $current_month = $get_data['current_month'];

    $jan=0; $feb=0; $mar=0; $apr=0; $may=0; $jun=0; $jul=0; $aug=0; $sep=0; $oct=0; $nov=0;  $dec=0;
    
    $sql = $conn->prepare("SELECT franchisee_id, MONTH(register_date) AS start_month, YEAR(register_date) AS start_year FROM franchisee where status='1' ");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    if($sql->rowCount()>0){
        // print_r($users);
        foreach ($sql->fetchAll() as $key => $row) {
            $partner_id = $row['franchisee_id'];
            $month = $row['start_month'].', ';
            $year = $row['start_year'];

            if ( $year == $get_year ) {
                switch ($month) {
                    case 1 : $jan += 1; break;
                    case 2 : $feb += 1; break;
                    case 3 : $mar += 1; break;
                    case 4 : $apr += 1; break;
                    case 5 : $may += 1; break;
                    case 6 : $jun += 1; break;
                    case 7 : $jul += 1; break;
                    case 8 : $aug += 1; break;
                    case 9 : $sep += 1; break;
                    case 10 : $oct += 1; break;
                    case 11 : $nov += 1; break;
                    case 12 : $dec += 1; break;
                    default: echo '0'; break;
                }
            }
        }

        // Check current month and year
        if ( $current_year == $get_year ) {
            switch ($current_month) {
                case 1 : $data = "".$jan."";break;
                case 2 : $data = "".$jan.",".$feb."";break;
                case 3 : $data = "".$jan.",".$feb.",".$mar."";break;
                case 4 : $data = "".$jan.",".$feb.",".$mar.",".$apr."";break;
                case 5 : $data = "".$jan.",".$feb.",".$mar.",".$apr.",".$may."";break;
                case 6 : $data = "".$jan.",".$feb.",".$mar.",".$apr.",".$may.",".$jun."";break;
                case 7 : $data = "".$jan.",".$feb.",".$mar.",".$apr.",".$may.",".$jun.",".$jul."";break;
                case 8 : $data = "".$jan.",".$feb.",".$mar.",".$apr.",".$may.",".$jun.",".$jul.",".$aug."";break;
                case 9 : $data = "".$jan.",".$feb.",".$mar.",".$apr.",".$may.",".$jun.",".$jul.",".$aug.",".$sep."";break;
                case 10 : $data = "".$jan.",".$feb.",".$mar.",".$apr.",".$may.",".$jun.",".$jul.",".$aug.",".$sep.",".$oct."";break;
                case 11 : $data = "".$jan.",".$feb.",".$mar.",".$apr.",".$may.",".$jun.",".$jul.",".$aug.",".$sep.",".$oct.",".$nov."";break;
                case 12 : $data = "".$jan.",".$feb.",".$mar.",".$apr.",".$may.",".$jun.",".$jul.",".$aug.",".$sep.",".$oct.",".$nov.",".$dec."";break;
                default: $data = ""; break;
            }
        } else {
          $data = "".$jan.","
                    .$feb.","
                    .$mar.","
                    .$apr.","
                    .$may.","
                    .$jun.","
                    .$jul.","
                    .$aug.","
                    .$sep.","
                    .$oct.","
                    .$nov.","
                    .$dec."";
        }
        
        $data = explode(',', $data);
        $data_ar =  json_encode($data);

        echo $data_ar;
    }else{
        echo 0;    
    }
?>