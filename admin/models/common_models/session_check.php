<?php 
    // Prevent caching
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
    header("Pragma: no-cache"); // HTTP 1.0
    header("Expires: 0"); // Proxies
    if (!isset($_SESSION['username'])) {

        // Detect AJAX request
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

            // For AJAX → return JSON (NO redirect)
            echo json_encode(['status' => 'session_expired']);
            exit;

        } else {
            // For normal page → redirect
            echo '<script>location.href = "../../index.php";</script>';
            exit;
        }
    }
?>