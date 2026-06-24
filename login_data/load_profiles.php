<?php

    header('Content-Type: application/json');

    include_once('../connect.php');

    try {

        $email = trim($_POST['email'] ?? '');

        if(empty($email))
        {
            echo json_encode([
                'status' => false,
                'message' => 'Email is required'
            ]);
            exit;
        }

        $sql = "
            SELECT
                l.user_id,
                l.user_type_id,
                ut.name AS user_type_name

            FROM login l

            LEFT JOIN user_type ut
                ON ut.id = l.user_type_id

            WHERE l.username = :email
            AND l.status = 1

            ORDER BY l.id
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':email' => $email
        ]);

        $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(empty($profiles))
        {
            echo json_encode([
                'status' => false,
                'message' => 'No profiles found for this email'
            ]);
            exit;
        }

        echo json_encode([
            'status' => true,
            'profiles' => $profiles
        ]);

    } catch(PDOException $e) {

        echo json_encode([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
?>