<?php
header("Content-Type: application/json");

// include PHPMailer
include('../phpmailer_smtp/smtp/PHPMailerAutoload.php');

$response = ["status" => "error", "message" => "Something went wrong."];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $name    = isset($data['name']) ? $data['name'] : '';
    $email   = isset($data['email']) ? $data['email'] : '';
    $message = isset($data['message']) ? $data['message'] : '';

    if (!empty($name) && !empty($email) && !empty($message)) {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';   // Gmail SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bizzmirth@gmail.com'; // replace with your Gmail
        $mail->Password   = 'bisy tqzy bbht qouy';   // use Gmail App Password (not normal password)
        $mail->SMTPSecure = 'tls';
        // $mail->SMTPDebug = 2;
        $mail->Port       = 587;

        $mail->setFrom('bizzmirth@gmail.com', 'App Admin');
        // $mail->addReplyTo($email, $name); // user's email for replies


        $mail->addAddress("admin@bizzmirth.com", "Admin"); // default recipient
        $mail->isHTML(true);

        $mail->Subject = "New Inquiry Message from $name";
        $mail->Body = "
                <div style='font-family: Arial, sans-serif; background: #f4f6f8; padding: 20px;'>
                <div style='max-width: 600px; margin: auto; background: #ffffff; border-radius: 10px; 
                
                                    box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;'>
                <!-- Logo Section -->
                <div style='text-align: center; padding: 20px; background: #ffffff;'>
                <a href='https://ca.uniqbizz.com/' target='_blank'>
                <img src='https://ca.uniqbizz.com/assets/images/bizz_logo.png' 
                
                                         alt='UniqBizz Logo' 
                
                                         style='max-width: 180px; height: auto;' />
                </a>
                </div>
                 
                            <!-- Header -->
                <div style='background: linear-gradient(135deg, #007bff, #00c6ff); 
                
                                        color: white; padding: 20px; text-align: center;'>
                <h2 style='margin: 0;'> New Inquiry Form Submission</h2>
                </div>
                <!-- Body -->
                <div style='padding: 20px; color: #333;'>
                <p style='font-size: 16px;'><strong style='color:#007bff;'>Name:</strong> $name</p>
                <p style='font-size: 16px;'><strong style='color:#007bff;'>Email:</strong> $email</p>
                <p style='font-size: 16px;'><strong style='color:#007bff;'>Message:</strong></p>
                <div style='background: #f9f9f9; padding: 15px; border-left: 4px solid #007bff; 
                
                                            font-size: 15px; line-height: 1.6; border-radius: 6px;'>
                
                                    $message
                </div>
                </div>
                <!-- Footer -->
                <div style='background: #f4f6f8; padding: 15px; text-align: center; font-size: 13px; color: #777;'>
                <p style='margin: 0;'>This inquiry was submitted via <strong>Bizzmirth Holidays Pvt. Ltd. </strong> app.</p>
                </div>
                </div>
                </div>
                
        ";

        if ($mail->send()) {
            $response = ["status" => "success", "message" => "Message sent successfully."];
        } else {
            $response = ["status" => "error", "message" => "Mailer Error: " . $mail->ErrorInfo];
        }
    } else {
        $response = ["status" => "error", "message" => "All fields are required."];
    }
}

echo json_encode($response);
