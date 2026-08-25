<?php

    require '../../connect.php';

    if (isset($_POST['id']) && isset($_POST['visibility'])) {

        $id = (int) $_POST['id'];
        $visibility = (int) $_POST['visibility'];

        // Only allow 0 or 1
        if ($visibility !== 0 && $visibility !== 1) {
            echo "failed";
            exit;
        }

        try {

            $sql = "UPDATE package
                    SET visibility = :visibility
                    WHERE id = :id";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ':visibility' => $visibility,
                ':id' => $id
            ]);

            echo "success";

        } catch (PDOException $e) {

            echo "failed";
        }

    } else {

        echo "failed";
    }
?>