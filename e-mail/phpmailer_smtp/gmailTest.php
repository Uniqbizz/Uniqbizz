<?php
include('smtp/PHPMailerAutoload.php');
$mail = new PHPMailer(); 
$mail->IsSMTP(); 
$mail->SMTPAuth = true; 
$mail->SMTPSecure = 'tls'; 
$mail->Host = "smtp.gmail.com"; // Use Gmail SMTP server
// $mail->Host = "mail.uniqbizz.com";
$mail->Port = 587; 
$mail->IsHTML(true);
$mail->CharSet = 'UTF-8';
$mail->SMTPDebug = 2; 
$subject = "Test Email";
$msg = "Hello";
$to = "pandurang.naik@bizzmirth.com";
// Your Gmail account details
$mail->Username = "bizzmirth@gmail.com"; // Your Gmail email address
$mail->Password = "Bizz@2024"; // Your Gmail password or App Password (if using 2FA)
$mail->SetFrom("bizzmirth@gmail.com"); // The 'From' email and name
// $mail->Username = "support@uniqbizz.com";
// $mail->Password = "support@uniqbizz";
// $mail->SetFrom("support@uniqbizz.com");
$mail->Subject = $subject;
$mail->Body = $msg;
$mail->AddAddress($to);

// Options for Gmail SMTP
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    )
);
if(!$mail->Send()){
    echo $mail->ErrorInfo;
}else{
    echo 1;
}
?>