<?php
require "../connect.php";

header('Content-Type: application/json'); // Tell browser we're returning JSON

// Decode JSON input
$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
    exit;
}

$current_date = date('Y-m-d'); // Use proper MySQL date format
$identifier_id = $input["id"] ?? null;
$tc_count = intval($input['tcCount'] ?? 0);

// Handle selected IDs safely
$tc_ids = $input['selectedIds'] ?? [];
$tc_ids = is_array($tc_ids) ? array_filter($tc_ids) : array_filter(explode(',', $tc_ids));

$tc_assign_status = !empty($tc_ids) ? 1 : 2;

$tc_message = "$identifier_id: $tc_count TC's have been allotted from Registered list on $current_date";
$tc_message2 = "$identifier_id: $tc_count TC's have been allotted from Registered list on $current_date";

try {
    $conn->beginTransaction(); // ✅ Wrap in transaction for safety

    // Update corporate_agency
    $sql1 = "UPDATE corporate_agency 
             SET no_tc_alloted=:no_tc_alloted, tc_assign_status=:tc_assign_status
             WHERE corporate_agency_id=:identifier_id";

    $stmt = $conn->prepare($sql1);
    $result = $stmt->execute([
        ':no_tc_alloted' => $tc_count,
        ':tc_assign_status' => $tc_assign_status,
        ':identifier_id' => $identifier_id
    ]);

    if (!$result) {
        throw new Exception('Failed to update Techno Enterprise');
    }

    if (!empty($tc_ids)) {
        foreach ($tc_ids as $tc_id) {
            // Fetch BM reference no and travel agency ID
            $sql2 = "SELECT reference_no, ca_travelagency_id 
                     FROM ca_travelagency 
                     WHERE ca_travelagency_id=:identifier_id AND status=1";

            $stmt3 = $conn->prepare($sql2);
            $stmt3->execute([':identifier_id' => $tc_id]);
            $row = $stmt3->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $bmreference_no = $row['reference_no'];
                $ca_travelagency_id = $row['ca_travelagency_id'];

                // Insert into tc_mapping
                $sql_insert = "INSERT INTO tc_mapping (te_id, bm_id, tc_id, map_status, map_date) 
                               VALUES (:te_id, :bm_id, :tc_id, :map_status, :map_date)";

                $stmt_insert = $conn->prepare($sql_insert);
                $result2 = $stmt_insert->execute([
                    ':te_id' => $identifier_id,
                    ':bm_id' => $bmreference_no,
                    ':tc_id' => $ca_travelagency_id,
                    ':map_status' => 1,
                    ':map_date' => $current_date
                ]);

                if (!$result2) {
                    throw new Exception('Failed to map TC');
                }
            }
        }
    }

    // Insert log
    $sql3_1 = "INSERT INTO logs (user_id, title, message, message2, reference_no, register_by, from_whom, operation) 
               VALUES (:user_id, :title, :message, :message2, :reference_no, :register_by, :from_whom, :operation)";
    $stmt3_1 = $conn->prepare($sql3_1);

    $result3_1 = $stmt3_1->execute([
        ':user_id' => $identifier_id,
        ':title' => 'TC Allotment',
        ':message' => $tc_message,
        ':message2' => $tc_message2,
        ':reference_no' => 'NA',
        ':register_by' => 15,
        ':from_whom' => 15,
        ':operation' => 'TC Allotment'
    ]);

    if (!$result3_1) {
        throw new Exception('Failed to log activity');
    }

    $conn->commit();
    echo json_encode(['status' => 'success', 'message' => 'TCs allotted successfully']);

} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
