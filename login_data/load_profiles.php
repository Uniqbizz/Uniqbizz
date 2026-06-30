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
            AND user_type_id IN(24, 25, 26, 16, 11, 10, 28, 29, 30, 32, 33, 34, 35, 36)
            AND (
                l.user_id LIKE 'CTE%'
                OR l.user_id LIKE 'ETE%'
                OR l.user_id LIKE 'STE%'
                OR l.user_id LIKE 'BH%'
                OR l.user_id LIKE 'BM%'
                OR l.user_id LIKE 'MF%'
                OR l.user_id LIKE 'SF%'
                OR l.user_id LIKE 'TE%'
                OR l.user_id LIKE 'CA%'
                OR l.user_id LIKE 'I%'
                OR l.user_id LIKE 'F%'
                OR l.user_id LIKE 'TA%'
                OR l.user_id LIKE 'IBR%'
                OR l.user_id LIKE 'CU%'
            )
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