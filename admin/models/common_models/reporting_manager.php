<?php
    require '../../connect.php';
    $sql = "SELECT * FROM `employees` WHERE status ='1' ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchAll()) as $key => $row) {
            echo '
                            <option value="' . $row['employee_id'] . '">' . $row['name'] . '</option>
                        ';
        }
    } else {
        echo '<option value="">Manager not available</option>';
    }
?>