<?php
    // get last login details
    date_default_timezone_set('Asia/Kolkata');
    // file path to find lastlogin file on local system(I have downloaded and kept in the below mentioned file)
    $file = "../home/uniqbizz/.lastlogin";
    if(file_exists($file)){

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        if(count($lines) >= 2){
            
            $secondLast = $lines[count($lines)-2];
            
            list($ip, $datetime) = explode("#", $secondLast);

            $ip = trim($ip);
            $datetime = trim($datetime);

            // echo "Previous Login IP: ".$ip."<br>";
            // echo "Previous Login Time: ".date("d M Y h:i A", strtotime($datetime));
            $lastLogin = date("d M Y h:i A", strtotime($datetime)); 
        } else {
            $lastLogin =  "Not enough login records.";
        }

    }else{
        $lastLogin =  "Login file not found.";
    }

?>