<?php 
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