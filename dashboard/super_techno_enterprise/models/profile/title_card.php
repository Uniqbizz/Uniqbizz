<?php

    header('Content-Type: application/json');

    include_once(__DIR__ . '/../../../dashboard_user_details.php');

    try {

        $userId = $_GET['user_id'] ?? '';

        if (empty($userId)) {
            echo json_encode([
                'status'  => false,
                'message' => 'User ID is required'
            ]);
            exit;
        }

        $sqlUserDetails = $conn->prepare("
            SELECT
                ste.super_techno_enterprise_id AS profile_id,
                CONCAT(ste.firstname, ' ', ste.lastname) AS profile_name,
                'Super Techno Enterprise' AS profile_type,
                ste.address AS profile_address,
                ste.email AS profile_email,
                ste.country_code AS profile_phone_prefix,
                ste.contact_no AS profile_phone,
                ste.register_date AS profile_since,
                doc.profile_pic
            FROM super_techno_enterprise ste
            LEFT JOIN documents doc
                ON doc.application_id = ste.application_id
            WHERE ste.super_techno_enterprise_id = :user_id
            LIMIT 1
        ");

        $sqlUserDetails->execute([
            ':user_id' => $userId
        ]);

        $userDetails = $sqlUserDetails->fetch(PDO::FETCH_ASSOC);

        if ($userDetails) {

            echo json_encode([
                'status' => true,
                'data'   => $userDetails
            ]);

        } else {

            echo json_encode([
                'status'  => false,
                'message' => 'User not found'
            ]);
        }

    } catch (PDOException $e) {

        echo json_encode([
            'status'  => false,
            'message' => $e->getMessage()
        ]);
    }
?>