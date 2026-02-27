<?php
    $stmt = $conn->prepare("SELECT
        SUM(COALESCE(credit_amount, 0)) AS credit_amt,
        SUM(COALESCE(debit_amount, 0)) AS debit_amt,
        (SUM(COALESCE(credit_amount, 0)) - SUM(COALESCE(debit_amount, 0))) AS net_balance FROM customer_reference_booking_points_utilization WHERE customer_id = :userId  AND YEAR(created_date) = :year AND MONTH(created_date) = :month");
    $stmt->execute(['userId' => $userId, 'year' => $DateYear, 'month' => $DateMonth]);
    $bookingMonth = $stmt->fetch(PDO::FETCH_ASSOC)['net_balance'] ?? 0;
    echo '<p class="text-white">' . $bookingMonth . '</p>';

?>