<?php
require '../../connect.php'; // This file should initialize your $conn as a PDO instance

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $createdDate = $_POST['createdDate'] ?? '';
    $usersId = $_POST['usersId'] ?? '';

    if (empty($createdDate) || empty($usersId)) {
        echo "Invalid request.";
        exit;
    }

    try {
        // Prepare and execute the query using PDO
        $query = $conn->prepare("
            SELECT reject_reason 
            FROM ta_top_up_payment
            WHERE ta_id = :user_id AND created_date = :created_date
            LIMIT 1
        ");

        $query->execute([
            ':user_id' => $usersId,
            ':created_date' => $createdDate
        ]);

        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo htmlspecialchars($row['reject_reason']);
        } else {
            echo "No rejection reason found for this record.";
        }

    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }

} else {
    echo "Invalid request method.";
}
?>
