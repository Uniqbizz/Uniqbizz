<?php
session_start();
require '../connect.php';
$username=$_POST['username'];
$password=$_POST['password'];
$user_type=$_POST['user_type'];
$remember_me=$_POST['remember_me'];

 

$stmt = $conn->prepare("SELECT * FROM login where username='".$username."' AND password='".$password."' AND user_type_id='".$user_type."' AND status='1'");
$stmt->execute();

    // set the resulting array to associative
$stmt->setFetchMode(PDO::FETCH_ASSOC);

if($stmt->rowCount()>0){
	foreach (($stmt->fetchAll()) as $key => $row) 
		# code...
		// $_SESSION["username2"] = $row['username'];
		$_SESSION["user_type_id_value"] = $row['user_type_id'];
		$_SESSION["user_id"] = $row['user_id'];

		if ($_SESSION["user_type_id_value"] =='2'){
		$stmt = $conn->prepare("SELECT * FROM customer where email='".$username."'  AND (status='1' || status='2')");
				$stmt->execute();

				    // set the resulting array to associative
				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				if($stmt->rowCount()>0){
					foreach (($stmt->fetchAll()) as $key => $row){
						$_SESSION["username2"] = $row['firstname'] ;
						$_SESSION["lname"] = $row['lastname'] ;
						
					}
				}
		}else if($_SESSION["user_type_id_value"] =='3'){
			$stmt = $conn->prepare("SELECT * FROM business_consultant where email='".$username."'  AND status='1' ");
				$stmt->execute();

				    // set the resulting array to associative
				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				if($stmt->rowCount()>0){
					foreach (($stmt->fetchAll()) as $key => $row){
						$_SESSION["username2"] = $row['firstname'] ;
						$_SESSION["lname"] = $row['lastname'] ;
						
					}
				}

		}else if($_SESSION["user_type_id_value"] =='4'){
			$stmt = $conn->prepare("SELECT * FROM franchisee where email='".$username."'  AND status='1' ");
				$stmt->execute();

				    // set the resulting array to associative
				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				if($stmt->rowCount()>0){
					foreach (($stmt->fetchAll()) as $key => $row){
						$_SESSION["username2"] = $row['firstname'] ;
						$_SESSION["lname"] = $row['lastname'] ;
						
					}
				}

		}else if($_SESSION["user_type_id_value"] =='5'){
			$stmt = $conn->prepare("SELECT * FROM sales_manager where email='".$username."'  AND status='1' ");
				$stmt->execute();

				    // set the resulting array to associative
				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				if($stmt->rowCount()>0){
					foreach (($stmt->fetchAll()) as $key => $row){
						$_SESSION["username2"] = $row['firstname'] ;
						$_SESSION["lname"] = $row['lastname'] ;
						
					}
				}

		}else if($_SESSION["user_type_id_value"] =='6'){
			$stmt = $conn->prepare("SELECT * FROM branch_manager where email='".$username."'  AND status='1' ");
				$stmt->execute();

				    // set the resulting array to associative
				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				if($stmt->rowCount()>0){
					foreach (($stmt->fetchAll()) as $key => $row){
						$_SESSION["username2"] = $row['firstname'] ;
						$_SESSION["lname"] = $row['lastname'] ;
						
					}
				}

		}else if($_SESSION["user_type_id_value"] =='7'){
			$stmt = $conn->prepare("SELECT * FROM regional_manager where email='".$username."'  AND status='1' ");
				$stmt->execute();

				    // set the resulting array to associative
				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				if($stmt->rowCount()>0){
					foreach (($stmt->fetchAll()) as $key => $row){
						$_SESSION["username2"] = $row['firstname'] ;
						$_SESSION["lname"] = $row['lastname'] ;
						
					}
				}

		}else if($_SESSION["user_type_id_value"] =='8'){
			$stmt = $conn->prepare("SELECT * FROM super_franchisee where email='".$username."'  AND status='1' ");
				$stmt->execute();

				    // set the resulting array to associative
				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				if($stmt->rowCount()>0){
					foreach (($stmt->fetchAll()) as $key => $row){
						$_SESSION["username2"] = $row['firstname'] ;
						$_SESSION["lname"] = $row['lastname'] ;
						
					}
				}
		}else if($_SESSION["user_type_id_value"] =='9'){
			$stmt = $conn->prepare("SELECT * FROM employees where email='".$username."'  AND status='1' ");
				$stmt->execute();

				    // set the resulting array to associative
				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				if($stmt->rowCount()>0){
					foreach (($stmt->fetchAll()) as $key => $row){
						$_SESSION["username2"] = $row['firstname'] ;
						$_SESSION["lname"] = $row['lastname'] ;
						
					}
				}
				// 10 customers
				// 11 Travel Agent
		}else if($_SESSION["user_type_id_value"] =='10'){
			$stmt = $conn->prepare("SELECT * FROM ca_customer where email='".$username."'  AND status='1' ");
				$stmt->execute();

				    // set the resulting array to associative
				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				if($stmt->rowCount()>0){
					foreach (($stmt->fetchAll()) as $key => $row){
						$_SESSION["username2"] = $row['firstname'] ;
						$_SESSION["lname"] = $row['lastname'] ;
						
					}
				}
		}else if($_SESSION["user_type_id_value"] =='11'){
			$stmt = $conn->prepare("SELECT * FROM ca_travelagency where email='".$username."'  AND status='1' ");
				$stmt->execute();

				    // set the resulting array to associative
				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				if($stmt->rowCount()>0){
					foreach (($stmt->fetchAll()) as $key => $row){
						$_SESSION["username2"] = $row['firstname'] ;
						$_SESSION["lname"] = $row['lastname'] ;
						
					}
				}
		}else if($_SESSION["user_type_id_value"] =='12'){
			$stmt = $conn->prepare("SELECT * FROM base_agency where email='".$username."'  AND status='1' ");
				$stmt->execute();

				    // set the resulting array to associative
				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				if($stmt->rowCount()>0){
					foreach (($stmt->fetchAll()) as $key => $row){
						$_SESSION["username2"] = $row['firstname'] ;
						$_SESSION["lname"] = $row['lastname'] ;
						
					}
				}
		}else if($_SESSION["user_type_id_value"] =='13'){
			$stmt = $conn->prepare("SELECT * FROM primary_agency where email='".$username."'  AND status='1' ");
				$stmt->execute();

				    // set the resulting array to associative
				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				if($stmt->rowCount()>0){
					foreach (($stmt->fetchAll()) as $key => $row){
						$_SESSION["username2"] = $row['firstname'] ;
						$_SESSION["lname"] = $row['lastname'] ;
						
					}
				}
		}else if($_SESSION["user_type_id_value"] =='14'){
			$stmt = $conn->prepare("SELECT * FROM premium_agency where email='".$username."'  AND status='1' ");
				$stmt->execute();

				    // set the resulting array to associative
				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				if($stmt->rowCount()>0){
					foreach (($stmt->fetchAll()) as $key => $row){
						$_SESSION["username2"] = $row['firstname'] ;
						$_SESSION["lname"] = $row['lastname'] ;
						
					}
				}
		}else if($_SESSION["user_type_id_value"] =='15'){
			$stmt = $conn->prepare("SELECT * FROM business_trainee where email='".$username."'  AND status='1' ");
			$stmt->execute();

				// set the resulting array to associative
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			if($stmt->rowCount()>0){
				foreach (($stmt->fetchAll()) as $key => $row){
					$_SESSION["username2"] = $row['firstname'] ;
					$_SESSION["lname"] = $row['lastname'] ;
					
				}
			}
		}else if($_SESSION["user_type_id_value"] =='16'){
			$stmt = $conn->prepare("SELECT * FROM corporate_agency where email='".$username."'  AND status='1' ");
			$stmt->execute();

				// set the resulting array to associative
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			if($stmt->rowCount()>0){
				foreach (($stmt->fetchAll()) as $key => $row){
					$_SESSION["username2"] = $row['firstname'] ;
					$_SESSION["lname"] = $row['lastname'] ;
					
				}
			}
		}else if($_SESSION["user_type_id_value"] =='17'){
			$_SESSION["username2"] = $username;
			$_SESSION["lname"] = "Sub Admin";

		}else if($_SESSION["user_type_id_value"] =='18'){
			$stmt = $conn->prepare("SELECT * FROM channel_business_director where email='".$username."'  AND status='1' ");
			$stmt->execute();

				// set the resulting array to associative
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			if($stmt->rowCount()>0){
				foreach (($stmt->fetchAll()) as $key => $row){
					$_SESSION["username2"] = $row['firstname'] ;
					$_SESSION["lname"] = $row['lastname'] ;
					
				}
			}
		}else if($_SESSION["user_type_id_value"] =='19'){
			$stmt = $conn->prepare("SELECT * FROM ca_franchisee where email='".$username."'  AND status='1' ");
			$stmt->execute();

				// set the resulting array to associative
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			if($stmt->rowCount()>0){
				foreach (($stmt->fetchAll()) as $key => $row){
					$_SESSION["username2"] = $row['firstname'] ;
					$_SESSION["lname"] = $row['lastname'] ;
					
				}
			}
		}else if($_SESSION["user_type_id_value"] =='24'){
			$stmt = $conn->prepare("SELECT * FROM employees where email='".$username."' AND user_type = '24' AND status='1' ");
			$stmt->execute();

				// set the resulting array to associative
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			if($stmt->rowCount()>0){
				foreach (($stmt->fetchAll()) as $key => $row){
					$_SESSION["username2"] = $row['name'] ;
					$_SESSION["lname"] = ' ';
					
				}
			}
		}else if($_SESSION["user_type_id_value"] =='25'){
			$stmt = $conn->prepare("SELECT * FROM employees where email='".$username."' AND user_type = '25' AND status='1' ");
			$stmt->execute();

				// set the resulting array to associative
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			if($stmt->rowCount()>0){
				foreach (($stmt->fetchAll()) as $key => $row){
					$_SESSION["username2"] = $row['name'] ;
					$_SESSION["lname"] = ' ' ;
					
				}
			}
		}else if($_SESSION["user_type_id_value"] =='26'){
			$stmt = $conn->prepare("SELECT * FROM business_mentor where email='".$username."' AND user_type = '26' AND status='1' ");
			$stmt->execute();

				// set the resulting array to associative
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			if($stmt->rowCount()>0){
				foreach (($stmt->fetchAll()) as $key => $row){
					$_SESSION["username2"] = $row['firstname'] ;
					$_SESSION["lname"] = $row['lastname'] ;
					
				}
			}
		}else{
			$_SESSION["username2"] = '' ;
			$_SESSION["lname"]='';
		}	

	if ($_SESSION["user_type_id_value"] =='2' || $_SESSION["user_type_id_value"]== '3' || $_SESSION["user_type_id_value"]== '4' || $_SESSION["user_type_id_value"]== '5' || $_SESSION["user_type_id_value"]== '6' || $_SESSION["user_type_id_value"]== '7' || $_SESSION["user_type_id_value"]== '8' || $_SESSION["user_type_id_value"]== '9' || $_SESSION["user_type_id_value"]== '10' || $_SESSION["user_type_id_value"]== '11' || $_SESSION["user_type_id_value"]== '12' || $_SESSION["user_type_id_value"]== '13' || $_SESSION["user_type_id_value"]== '14' || $_SESSION["user_type_id_value"]== '15' || $_SESSION["user_type_id_value"]== '16' || $_SESSION["user_type_id_value"]== '17' || $_SESSION["user_type_id_value"]== '18' || $_SESSION["user_type_id_value"]== '19' || $_SESSION["user_type_id_value"]== '24' || $_SESSION["user_type_id_value"]== '25' || $_SESSION["user_type_id_value"]== '26'){
		if ($remember_me == 'true') {
				setcookie('user2',$username, time() + (86400 * 30), "/"); // 86400 = 1 day
				// setcookie('user2',$username , time() + (86400 * 30), "/"); // 86400 = 1 day
				setcookie('pass',$password , time() + (86400 * 30), "/"); // 86400 = 1 day
			}else{
				setcookie('user2',''); // 86400 = 1 day
				setcookie('pass',''); // 86400 = 1 day
			}
		echo '1';
	}else{
		echo '0';
	}
}
	else{
		echo '0';
	}


$stmt2 = $conn->prepare("SELECT * FROM user_type where id='".$_SESSION["user_type_id_value"]."' AND status='1' ");
$stmt2->execute();

    // set the resulting array to associative
$stmt2->setFetchMode(PDO::FETCH_ASSOC);

if($stmt2->rowCount()>0){
	foreach (($stmt2->fetchAll()) as $key => $row2) 

		# code...
		$_SESSION["user_type_name"] = $row2['name'];
}
	else{
		echo '0';
	}

	// if(isset($_SESSION["username"])) {
 //    header("Location:index.php");
 //    }


// if ($result->num_rows > 0) {
// 	while($row = $result->fetch_assoc()) {
// 		echo "1";
// 	}
// } else {
// 	echo "0";
// }

?>