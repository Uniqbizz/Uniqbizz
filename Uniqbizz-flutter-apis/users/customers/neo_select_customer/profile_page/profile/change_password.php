<?php

require '../../../../../../connect.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    try {

        if (!$data) {
            throw new Exception("Invalid JSON data.");
        }

        if (
            !isset($data['userId']) ||
            !isset($data['userType']) ||
            !isset($data['currentPassword']) ||
            !isset($data['newPassword']) ||
            !isset($data['confirmPassword'])
        ) {
            throw new Exception("Missing required parameters.");
        }

        $userId = trim($data['userId']);
        $userType = trim($data['userType']);
        $currentPassword = trim($data['currentPassword']);
        $newPassword = trim($data['newPassword']);
        $confirmPassword = trim($data['confirmPassword']);

        // Check confirm password
        if ($newPassword !== $confirmPassword) {
            throw new Exception("New password and confirm password do not match.");
        }

        // New password should not be the same as current password
        if ($currentPassword === $newPassword) {
            throw new Exception("New password cannot be the same as the current password.");
        }

        // Validate password
        if (
            strlen($newPassword) < 8 ||
            !preg_match('/[A-Za-z]/', $newPassword) ||
            !preg_match('/\d/', $newPassword) ||
            !preg_match('/[^A-Za-z0-9]/', $newPassword)
        ) {
            throw new Exception("Password must contain at least 8 characters, one letter, one number and one special character.");
        }

        // Fetch current password
        $sqlCheck = $conn->prepare("
            SELECT password
            FROM login
            WHERE user_id = :user_id
            AND user_type_id = :user_type
        ");

        $sqlCheck->execute([
            ':user_id' => $userId,
            ':user_type' => $userType
        ]);

        $user = $sqlCheck->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new Exception("User not found.");
        }

        if ($user['password'] != $currentPassword) {
            throw new Exception("Current password is incorrect.");
        }

        // Update password
        $sqlUpdate = $conn->prepare("
            UPDATE login
            SET password = :password
            WHERE user_id = :user_id
            AND user_type_id = :user_type
        ");

        $updated = $sqlUpdate->execute([
            ':password' => $newPassword,
            ':user_id' => $userId,
            ':user_type' => $userType
        ]);

        if (!$updated) {
            throw new Exception("Failed to update password.");
        }

        // Insert log
        $sqlLog = $conn->prepare("
            INSERT INTO logs
            (
                title,
                message,
                operation,
                reference_no,
                register_by,
                from_whom
            )
            VALUES
            (
                :title,
                :message,
                :operation,
                :reference_no,
                :register_by,
                :from_whom
            )
        ");

        $sqlLog->execute([
            ':title' => 'Password Reset',
            ':message' => 'Password has been changed',
            ':operation' => 'update',
            ':reference_no' => $userId,
            ':register_by' => $userType,
            ':from_whom' => $userType
        ]);

        echo json_encode([
            "status" => true,
            "message" => "Password updated successfully."
        ]);

    } catch (Exception $e) {

        echo json_encode([
            "status" => false,
            "message" => $e->getMessage()
        ]);
    }

} else {

    echo json_encode([
        "status" => false,
        "message" => "Invalid request method."
    ]);

}