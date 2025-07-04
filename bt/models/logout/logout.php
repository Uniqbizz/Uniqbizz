<?php   
session_start(); //to ensure you are using same session
// session_destroy();
if(session_destroy()){
	header('location:logout.php'); //to redirect back to "index.php" after logging out
}


?>
