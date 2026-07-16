<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $sqlSTE = $conn->prepare("
            SELECT *
            FROM sponsor_franchisee
            WHERE sponsor_franchisee_id = :user_id
            AND status = 1
        ");

        $sqlSTE->execute([
            ':user_id' => $userId
        ]);

        $steData = $sqlSTE->fetch(PDO::FETCH_ASSOC);

        if ($steData) {

            echo json_encode([
                'status'  => true,
                'message' => 'Data fetched successfully',
                'data'    => $steData
            ]);

        } else {

            echo json_encode([
                'status'  => false,
                'message' => 'No record found',
                'data'    => null
            ]);

        }

    } catch (PDOException $e) {

        echo json_encode([
            'status'  => false,
            'message' => $e->getMessage(),
            'data'    => null
        ]);

    }

    exit;
?>