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

        $query = "SELECT * FROM transfered_users WHERE 1";
        $params = [];

        if(!empty($record_id)){
            $query .= " AND transfer_user_id = :record_id";
            $params[':record_id'] = $record_id;
        }

        if(!empty($from_date) && !empty($to_date)){
            $query .= " AND DATE(transfer_date) BETWEEN :from_date AND :to_date";
            $params[':from_date'] = $from_date;
            $params[':to_date']   = $to_date;
        }

        $query .= " ORDER BY transfer_date DESC";

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
        header("Content-Disposition: attachment; filename=".$record_id."_transfer_logs.xls");
        $from_date  = $_GET['from_date'] ?? '';
        $to_date    = $_GET['to_date'] ?? '';

        $query = "SELECT * FROM transfered_users WHERE 1";
        $params = [];

        if(!empty($table_name)){
            $query .= " AND table_name = :table_name";
            $params[':table_name'] = $table_name;
        }

        if(!empty($record_id)){
            $query .= " AND transfer_user_id = :record_id";
            $params[':record_id'] = $record_id;
        }

        if(!empty($from_date) && !empty($to_date)){
            $query .= " AND DATE(transfer_date) BETWEEN :from_date AND :to_date";
            $params[':from_date'] = $from_date;
            $params[':to_date']   = $to_date;
        }

        $query .= " ORDER BY transfer_date DESC";

        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetchAll();

        echo "<table border='1'>
            <tr>
                <th>Date</th>
                <th>Previous User</th>
                <th>Previous User Email</th>
                <th>Previous DOJ</th>
                <th>New User</th>
                <th>New User Email</th>
                <th>Transfer Reason</th>
                <th>Transfer Remark</th>
                <th>Transfer status</th>
                <th>Approve/Reject Date</th>
                <th>Transfered By</th>
            </tr>";

        foreach($result as $row){
            echo "<tr>
                <td>{$row['transfer_date']}</td>
                <td>{$row['prev_user_name']}</td>
                <td>{$row['prev_user_email']}</td>
                <td>{$row['prev_user_doj']}</td>
                <td>{$row['new_user_name']}</td>
                <td>{$row['new_user_email']}</td>
                <td>{$row['transfer_reason']}</td>
                <td>{$row['transfer_remark']}</td>
                <td>";
                    if ($row['transfer_status'] == 2) {
                        echo 'Approved';
                    } elseif ($row['transfer_status'] == 3) {
                        echo 'Rejected';
                    } else {
                        echo 'Pending';
                    }

            echo"</td>
                <td>{$row['transfer_update_date']}</td>
                <td>Admin</td>
            </tr>";
        }

        echo "</table>";
        exit;
    }
?>