<?php
require '../connect.php';

header('Content-Type: application/json'); // Return JSON response

// Decode JSON input
$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
    exit;
}

$te_id = $input["te_id"] ?? null;

if (!$te_id) {
    echo json_encode(['status' => 'error', 'message' => 'TE ID is required']);
    exit;
}

$response = [];

try {
    // Prepare the query
    $query = "SELECT 
                te.te_id,
                ca.firstname AS ca_firstname,
                ca.lastname AS ca_lastname,
                ca.registrant,
                ca.reference_no,
                te.tc_id,
                tc.firstname AS tc_firstname,
                tc.lastname AS tc_lastname,
                te.bm_id,
                bm.firstname AS bm_firstname,
                bm.lastname AS bm_lastname,
                te.map_date,
                te.map_status
              FROM tc_mapping te
              INNER JOIN corporate_agency ca ON ca.corporate_agency_id = te.te_id
              INNER JOIN ca_travelagency tc ON tc.ca_travelagency_id = te.tc_id
              INNER JOIN business_mentor bm ON bm.business_mentor_id = te.bm_id
              WHERE te.map_status = 1 AND te.te_id = :te_id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':te_id', $te_id, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($data) {
        foreach ($data as $row) {
            $response[] = [
                'te_id'        => $row['te_id'],
                'corporate_agency' => $row['ca_firstname'] . ' ' . $row['ca_lastname'],
                'registrant'   => $row['registrant'],
                'reference_no' => $row['reference_no'],
                'tc_id'        => $row['tc_id'],
                'travel_agency'=> $row['tc_firstname'] . ' ' . $row['tc_lastname'],
                'bm_id'        => $row['bm_id'],
                'business_mentor'=> $row['bm_firstname'] . ' ' . $row['bm_lastname'],
                'map_date'     => $row['map_date'],
                'map_status'   => $row['map_status']
            ];
        }

        echo json_encode(['status' => 'success', 'data' => $response]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No records found for this TE ID']);
    }

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
