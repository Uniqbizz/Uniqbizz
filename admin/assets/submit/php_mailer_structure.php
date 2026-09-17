<?php    
    // PHPMailer
    $mail = new PHPMailer(); 

    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls'; 

    $mail->Host = MAILTRAP_HOST;
    $mail->Port = MAILTRAP_PORT; 

    $mail->Username = MAILTRAP_USERNAME;
    $mail->Password = MAILTRAP_PASSWORD;

    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';

    $mail->SetFrom($fromEmail);
    $mail->AddAddress($to);

    $mail->Subject = $subject;
    $mail->Body =$emailBody;

    $mail->AltBody = 'Welcome to Bizzmirth Holidays. Your portal login credentials are included in this email.';

    if (!$mail->Send()) {
        echo $mail->ErrorInfo;
    } else {
        echo 1;
    }

?>