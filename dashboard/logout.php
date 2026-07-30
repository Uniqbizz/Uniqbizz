<?php

session_start();

// Clear all session variables
$_SESSION = [];

// Delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

if(isset($_SESSION['username2'])){
    unset($_SESSION['username2']);
    unset($_SESSION['user_type_id_value']);
    unset($_SESSION['user_id']);

}
// Destroy the session
session_destroy();

// Remove Remember Me cookies
if (isset($_COOKIE['user2'])) {
    setcookie('user2', '', time() - 3600, '/');
}

if (isset($_COOKIE['pass'])) {
    setcookie('pass', '', time() - 3600, '/');
}

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

header("Location: ../login.php");
exit;