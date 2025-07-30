<?php

session_start();

if(isset($_SESSION['username2'])){
    unset($_SESSION['username2']);
    unset($_SESSION['user_type_id_value']);
    unset($_SESSION['user_id']);
    //   setcookie('user2','');
	  // setcookie('pass','');
    // session_destroy();
}
if(isset($_COOKIE['user2'])){
  // echo '<script>alert("savio");</script>';
	setcookie('user2',''); // 86400 = 1 day;
	setcookie('pass',''); // 86400 = 1 day
}
	
	
  header("location: ../login.php");


?>
