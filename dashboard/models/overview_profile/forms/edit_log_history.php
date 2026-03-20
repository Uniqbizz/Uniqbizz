<?php
    require '../../../connect.php';

    /* ================= FETCH DATA (AJAX) ================= */
    if(isset($_POST['action']) && $_POST['action'] === 'fetch_logs'){

        // 🔥 START BUFFER & CLEAN
        ob_start();
        ob_clean();

        header('Content-Type: application/json');

        $record_id = trim($_POST['record_id'] ?? '');
        $from_date = $_POST['from_date'] ?? '';
        $to_date   = $_POST['to_date'] ?? '';

        $query = "SELECT * FROM field_edit_logs WHERE 1";
        $params = [];

        if(!empty($record_id)){
            $query .= " AND record_id = :record_id";
            $params[':record_id'] = $record_id;
        }

        if(!empty($from_date) && !empty($to_date)){
            $query .= " AND DATE(created_at) BETWEEN :from_date AND :to_date";
            $params[':from_date'] = $from_date;
            $params[':to_date']   = $to_date;
        }

        $query .= " ORDER BY created_at DESC";

        try {

            $stmt = $conn->prepare($query);
            $stmt->execute($params);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $result = $stmt->fetchAll();

            echo json_encode([
                "status" => "success",
                "data"   => $result
            ]);

        } catch (Exception $e) {

            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }

        exit;
    }


    /* ================= DOWNLOAD EXCEL ================= */
    if(isset($_GET['download']) && $_GET['download'] == '1'){

        $record_id  = $_GET['record_id'] ?? '';
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=".$record_id."_edit_logs.xls");
        $from_date  = $_GET['from_date'] ?? '';
        $to_date    = $_GET['to_date'] ?? '';

        $query = "SELECT * FROM field_edit_logs WHERE 1";
        $params = [];

        if(!empty($table_name)){
            $query .= " AND table_name = :table_name";
            $params[':table_name'] = $table_name;
        }

        if(!empty($record_id)){
            $query .= " AND record_id = :record_id";
            $params[':record_id'] = $record_id;
        }

        if(!empty($from_date) && !empty($to_date)){
            $query .= " AND DATE(created_at) BETWEEN :from_date AND :to_date";
            $params[':from_date'] = $from_date;
            $params[':to_date']   = $to_date;
        }

        $query .= " ORDER BY created_at DESC";

        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetchAll();

        echo "<table border='1'>
            <tr>
                <th>Date</th>
                <th>Column</th>
                <th>Old Value</th>
                <th>New Value</th>
                <th>Changed By</th>
                <th>Reason</th>
            </tr>";

        foreach($result as $row){
            echo "<tr>
                <td>{$row['created_at']}</td>
                <td>{$row['column_name']}</td>
                <td>{$row['old_value']}</td>
                <td>{$row['new_value']}</td>
                <td>{$row['changed_role']}</td>
                <td>{$row['change_reason']}</td>
            </tr>";
        }

        echo "</table>";
        exit;
    }
?>