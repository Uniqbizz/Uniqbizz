<?php
session_start();
require "../../connect.php";

$user_id = $_POST["user_id"];
$user_type = $_POST["user_type"];
$newPassword = $_POST["newPassword"];
$confirmPassword = $_POST["confirmPassword"];
$currentPassword = $_POST["currentPassword"];

// 1. Fetch current password from DB
$sqlCheck = "SELECT password FROM login WHERE user_id = :user_id AND user_type_id = :user_type_id";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->execute([
    ':user_id' => $user_id,
    ':user_type_id' => $user_type
]);

$current = $stmtCheck->fetch(PDO::FETCH_ASSOC);

if (!$current || $current['password'] !== $currentPassword) {
    echo 'mismatch'; // current password doesn't match
    exit;
}

// Optional: You can re-check the password format server-side here if needed
if (
    strlen($newPassword) < 8 ||
    !preg_match('/[A-Za-z]/', $newPassword) ||
    !preg_match('/\d/', $newPassword) ||
    !preg_match('/[^A-Za-z0-9]/', $newPassword)
) {
    echo 'invalid'; // password doesn't meet rules
    exit;
}

// 2. Update the new password
$sql = "UPDATE login SET password = :password WHERE user_id = :user_id AND user_type_id = :user_type_id";
$stmt2 = $conn->prepare($sql);
$result2 = $stmt2->execute([
    ':password' => $newPassword,
    ':user_type_id' => $user_type,
    ':user_id' => $user_id
]);

if ($result2) {
    // 3. Log the change
    $sql3 = "INSERT INTO logs (title, message, operation, reference_no, register_by, from_whom)
             VALUES (:title, :message, :operation, :reference_no, :register_by, :from_whom)";
    $stmt3 = $conn->prepare($sql3);

    $result3 = $stmt3->execute([
        ':title' => 'Password Reset',
        ':message' => 'Password has been changed',
        ':operation' => 'update',
        ':reference_no' => $user_id,
        ':register_by' => $user_type,
        ':from_whom' => $user_type
    ]);

    if ($result3) {
        echo 'success';
    } else {
        echo 'log_error'; // Logging failed, but password was updated
    }
} else {
    echo 'update_error'; // Password update failed
}
