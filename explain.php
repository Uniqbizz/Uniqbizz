<?php 
    require 'connect.php';

    $table = 'business_mentor';
    $stmt = $conn->query("DESCRIBE `$table`");
    $results = $stmt->fetchAll();

    // get data in normal format
    if ($results) {
        // print_r($results);
        echo "<table border='1'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        foreach ($results as $row) {
            echo "<tr>";
            foreach ($row as $col) {
                echo "<td>" . htmlspecialchars($col) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No structure found or table doesn't exist.";
    }

    // get table fields name in json
    // Extract only the 'Field' values (column names)
    // $columns = array_column($results, 'Field');

    // header('Content-Type: application/json');
    // echo json_encode($columns);

    // No need to close PDO explicitly; it closes automatically
?>

