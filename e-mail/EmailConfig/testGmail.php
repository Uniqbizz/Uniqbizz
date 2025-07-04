<?php

    // require "../connect.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer-6.9.2/src/Exception.php';
    require 'PHPMailer-6.9.2/src/PHPMailer.php';
    require 'PHPMailer-6.9.2/src/SMTP.php';

    
        $subjectName = 'CV Details';
        // $to = 'bizzmirth@gmail.com';
        $to = 'pandurang.naik@bizzmirth.com';
        $subject = $subjectName;
        $message3 = '
            Hello Testing
        ';
        
        $mail = new PHPMailer(); 

        $mail->IsSMTP(); 
        $mail->SMTPAuth = true; 

        // $mail->Host = "smtp.gmail.com";
        // $mail->Username = "bizzmirth@gmail.com";
        // $mail->Password = "Bizz@2024";
        $mail->Host = "mail.uniqbizz.com";
        $mail->Username = "support@uniqbizz.com";
        $mail->Password = "support@uniqbizz";
        $mail->SMTPSecure = 'tls'; 
        $mail->Port = 587; 

        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = 2; 

        // $mail->SetFrom("bizzmirth@gmail.com");
        $mail->SetFrom("support@uniqbizz.com");
        $mail->Subject = $subject;
        $mail->Body =$message3;
        $mail->AddAddress($to);

        // $mail->addAttachment("cv/".$fileName);

        $mail->SMTPOptions=array('ssl'=>array(
            'verify_peer'=>false,
            'verify_peer_name'=>false,
            'allow_self_signed'=>false
        ));
        if(!$mail->Send()){
            echo $mail->ErrorInfo;
        }else{
            echo 1;
        }
    ?>