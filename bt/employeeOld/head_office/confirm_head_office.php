<?php 
require "../../connect.php";
 

$id= $_POST["id"];
$uname= $_POST["uname"];
$state= $_POST["st"];
$string="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#%^*()";
$password = substr(str_shuffle($string), 0,8);
$status= '1';
$user_type_id= '12';

// $sm_id= $_POST["sm_id"];
$register_by ='1';

date_default_timezone_set('Asia/Calcutta');
$todayYear = date('Y' );

$subY=substr($todayYear,2,4);

$sql9= $conn->prepare("SELECT * from head_office where id='".$id."' and status='2'");
$sql9->execute();
$sql9->setFetchMode(PDO::FETCH_ASSOC);
if($sql9->rowCount()>0){
	foreach (($sql9->fetchAll()) as $key9 => $row9) {

		 $registerDate= new DateTime($row9['register_date']);
         $doj= $registerDate->format('d/m/Y');
         $name= $row9['firstname']. ' ' . $row9['lastname'];
         $address = $row9['address'];
         $country_code = $row9['country_code'];
         $contact_no = $row9['contact_no'];

	}
}

// $uid=0;
// $franchisee_id=0;

// $uid='';
// $sql2= $conn->prepare("SELECT franchisee_id,CAST(franchisee_id as SIGNED) AS casted_column  from franchisee where user_type='4'  ORDER BY casted_column desc limit 1");
// made changes in query to get id in order SFA230043 TC230010 RMGA24001
$sql2= $conn->prepare("SELECT distinct head_office_id,SUBSTRING(head_office_id,5,6) as tc_id from head_office where status='1' OR status='3' order by tc_id DESC limit 1");

$sql2->execute();
$sql2->setFetchMode(PDO::FETCH_ASSOC);
if($sql2->rowCount()>0){
	foreach (($sql2->fetchAll()) as $key3 => $row3) {
		 $head_office_id=$row3["head_office_id"];
	}
	if($head_office_id ==''){	
			$uid = 'HDOF'.$subY.'0001';
	}else{

		$subV=substr($head_office_id,4,4);
		if($subV==$subY){
			// ''.$ssd
			$head_office_id++;
			  $head_office_id=str_pad($head_office_id, 4, '0', STR_PAD_LEFT);
			  $uid =$head_office_id;
		}else{

			$head_office_id++;
			$fid=substr($head_office_id,6);
			$newValue = 'HDOF'.$subY.$fid;

			// if($business_package == 'basic'){
			// 	$newValue = 'SFB'.$subY.$fid;
			// }else if($business_package == 'advanced'){
			// 	$newValue = 'SFA'.$subY.$fid;
			// }else if($business_package == 'ultra'){
			// 	$newValue = 'SFU'.$subY.$fid;
			// }

			  $Nhead_office_id=str_pad($newValue, 4, '0', STR_PAD_LEFT);
			  $uid =$Nhead_office_id;
		}
	}



}else
{
	$uid = 'HDOF'.$subY.'0001';
	// if($business_package == 'basic'){
	// 	$uid = 'SFB'.$subY.'0001';
	// }else if($business_package == 'advanced'){
	// 	$uid = 'SFA'.$subY.'0001';
	// }else if($business_package == 'ultra'){
	// 	$uid = 'SFU'.$subY.'0001';
	// }else{

	// }
}

//log file
$title="Confirm Head Office";
$message=$uid." has been approved";
$message2=$uid." has been approved";
$fromWhom="1";


$sql1 = "UPDATE head_office SET status=:status,head_office_id=:head_office_id WHERE id=:id";
	$stmt = $conn->prepare($sql1);
	$result=  $stmt->execute(array(
		':status' => $status,
		':head_office_id' => $uid,
		// ':deleted_date' => $today,
		':id' => $id		
	));

	if ($result) {
		
		$sql= "INSERT INTO login (username,password, user_id, user_type_id , status) VALUES (:uname ,:password, :user_id, :user_type_id, :status)";
		$stmt3 =$conn->prepare($sql);

		$result2=$stmt3->execute(array(
		':uname' => $uname, 
		':password' => $password, 
		':user_id' => $uid, 
		':user_type_id' => $user_type_id, 
		':status' => $status
		));

		if($result2){
			$sql4= "INSERT INTO logs (user_id,title,message,message2, register_by, from_whom) VALUES (:user_id,:title ,:message, :message2, :register_by, :from_whom)";
				$stmt4 =$conn->prepare($sql4);

				$result3=$stmt4->execute(array(
				':user_id' => $uid,
				':title' => $title,
				':message' => $message,
				':message2' =>$message2,
				// ':reference_no' => $sm_id,
				':register_by' => $register_by,
				':from_whom' => $fromWhom
				));

				if($result3){
				    
				    //sms
				    $apikey = "O1y4qz6QvEirxbrmPubk0g";
					  $apisender = "UNIQBI";
				// 	  $msg ="Welcome to Bizzmirth holidays. Your ID is '".$uname."' and your password is '".$password."'";
				$msg ="Welcome to the Uniqbizz. 

Visit uniqbizz.com
                                
Your ID is : - 
                                
Email ID: - '".$uname."'
                                
Password: - '".$password."'
                                
Thank You";
					  $num = $country_code.$contact_no; // MULTIPLE NUMBER VARIABLE PUT HERE...!
					  $ms = rawurlencode($msg); //This for encode your message content
					  $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=1&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
					  //echo $url;
					  $ch=curl_init($url);
					  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					  curl_setopt($ch,CURLOPT_POST,1);
					  curl_setopt($ch,CURLOPT_POSTFIELDS,"");
					  curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
					  $data = curl_exec($ch);
					  echo '

					';
				    
				    
				    //email
				    
					$fromEmail = 'support@uniqbizz.com';
				    $toEmail = $uname;
				    $subjectName = 'Login Details';
				    // $message = $_POST['message'];

				    $to = $toEmail;
				    $subject = $subjectName;
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
										<img src="https://uniqbizz.com/uploading/uniqbizz_logo.png" alt="" width="100" style="height:auto;display:block; position: absolute; top: 37px;" />
										<img src="https://uniqbizz.com/uploading/bizzmirth.png" alt="" width="100" style="height:auto;display:block;" /></p>
					                  </td>
					                  <td style="padding:0;width:50%;" align="right">
					                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
					                      <tr>
					                       <p style="font-size:14px;line-height:20px;font-family:Arial,sans-serif; color: white;">
										    Uniqbizz<br>
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
					                          <p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif;">Dear '.$name.'  <br>
					                          ID: - '.$uid.'<br>
					                          DOJ: - '.$doj.'<br>
					                          Address: - '.$address.'<br>
					                          Username: - '.$uname.'<br>
					                          Password: - '.$password.'<br><br>
					                          <hr><br><br>
					                        </p>
					                          <p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; color: #a5a5a5;"> 
					                            Congratulations on your decision! </p>

					                            <p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; ">
					                              A journey of a thousand miles must begin with a single step. Id like to welcome you to Uniqbizz. We are excited that you have accepted our business offer and agreed upon your start date. I trust that this letter finds you mutually excited about your new opportunity with Uniqbizz.
					                              <br><br>

					                              Each of is will play a role to ensure your successful integration into the company. Your agenda will involve planning your orientation with company and setting some intial work goals so that you feel immediately productive in your new role. And to earn money which is optional, your earnings will depend directly in the amount of questions prior to your start date, please call me anytime, or send email if that is more convenient. We look forward to having you come onboard. The secret of success is constancy to purpose.

					                            </p>
					                            <p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; color: #a5a5a5;"> 
					                            Best Regards,<br>
					                            Uniqbizz</p>
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
										 Uniqbizz.<br/>
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
				else{
				echo 0	;
				}
			// echo 1;
		}
		else{
		echo 0	;
		}

	}
	else{
		echo 0;
	}


?>