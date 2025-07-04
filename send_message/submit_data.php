<?php
require '../connect.php';

$name = $_POST["name"];
$email = $_POST["email"];
$phnumber = $_POST["phnumber"];
$comments = $_POST["comments"];

if(!empty($_POST["email"])){ 
    $fromEmail = $email;
                    $toEmail = 'support@uniqbizz.com';
                    $subjectName = 'Contact Us';
                    // $message = $_POST['message'];

                    $to = $toEmail;
                    $subject = $subjectName;
                    
                    ini_set( 'display_errors', 1 );
                    error_reporting( E_ALL );
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: '.$fromEmail.'<'.$fromEmail.'>' . "\r\n".'Reply-To: '.$fromEmail."\r\n" . 'X-Mailer: PHP/' . phpversion();
                    $message3 = '<!DOCTYPE html>
                    <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                    <head>
                      <meta charset="UTF-8">
                      <meta name="viewport" content="width=device-width,initial-scale=1">
                      <meta name="x-apple-disable-message-reformatting">
                      <title></title>
                      <!--[if mso]>
                      <noscript>
                        <xml>
                          <o:OfficeDocumentSettings>
                            <o:PixelsPerInch>96</o:PixelsPerInch>
                          </o:OfficeDocumentSettings>
                        </xml>
                      </noscript>
                      <![endif]-->
                      <style>
                        table, td, div, h1, p {font-family: Arial, sans-serif;}
                      </style>
                    </head>
                    <body style="margin:0;padding:0;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                        <tr>
                          <td align="center" style="padding:0;">
                            <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                              <tr>
                                <td style="padding:30px;background:#a5a5a5;">
                                  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                    <tr>
                                      <td style="padding:0;width:50%;" align="left">
                                       <img src="https://uniqbizz.com/uploading/bizzmirth.png" alt="" width="100" style="height:auto;display:block;" /></p>
                                      </td>
                                      <td style="padding:0;width:50%;" align="right">
                                        <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                          <tr>
                                           <p style="font-size:14px;line-height:20px;font-family:Arial,sans-serif; color: white;">
                                            Bizzmirth Holidays Pvt Ltd<br>
                                            306 Ambrosia Corporate Park EDC Patto Plaza Panjim Goa 403001<br>
                                            Contact No: 0832 2438500 / 8080785714<br>
                                            Email ID: support@uniqbizz.com<br>
                                            URL: uniqbizz.com
                                           </p>
                                          
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding:36px 30px 42px 30px;">
                                  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                    <tr>
                                      <td style="padding:0;">
                                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                          <tr>
                                            
                                            <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                            <td style="width:260px;padding:0;vertical-align:top;color:#153643;">
                                              <!-- <p style="margin:0 0 25px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><img src="https://assets.codepen.io/210284/right.gif" alt="" width="260" style="height:auto;display:block;" /></p> -->
                                              <p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif;">
                                              From: - '.$name.'<br>
                                              Email: - '.$email.'<br>
                                              Phone Number: - '.$phnumber.'<br><br>
                                              <hr><br><br>
                                            </p>
                                              

                                                <p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; ">
                                                 '.$comments.'.
                                                  <br><br>

                                                </p>
                                                <p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; color: #a5a5a5;"> 
                                                Best Regards,<br>
                                                '.$name.'</p>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding:30px;background:#a5a5a5;">
                                  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                    <tr>
                                      <td style="padding:0;width:50%;" align="left">
                                        <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                           Bizzmirth Holidays Pvt. Ltd.<br/>
                                        </p>
                                      </td>
                                      
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </body>
                    </html>';
                    mail($to, $subject, $message3, $headers);
                    echo 1;
}

?>