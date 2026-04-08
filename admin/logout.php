<?php
  session_start();

  // Unset all session variables
  $_SESSION = [];

  // Destroy session
  session_destroy();

  // Delete session cookie also (IMPORTANT)
  if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
      );
  }

  // Delete custom cookies
  if(isset($_COOKIE['user2'])){
      setcookie('user2', '', time() - 3600, '/');
  }
  if(isset($_COOKIE['pass'])){
      setcookie('pass', '', time() - 3600, '/');
  }

  // Redirect
  header("location: index.php");
  exit();
?>
