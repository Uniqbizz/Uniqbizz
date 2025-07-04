<?php
include '../connect.php';

$tc_count = $_POST['tc_count'];
$reference_no = $_POST['reference_no'];

$tcs = [];

if (strpos($reference_no, 'BH') !== false) {
    // Get BMs under this BH
    $bm_stmt = $conn->prepare("SELECT business_mentor_id FROM business_mentor WHERE reference_no = ?");
    $bm_stmt->execute([$reference_no]);
    $bm_ids = $bm_stmt->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($bm_ids)) {
        $placeholders = implode(',', array_fill(0, count($bm_ids), '?'));

        $query = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, bm.business_mentor_id, bm.firstname AS bm_firstname, bm.lastname AS bm_lastname
                  FROM ca_travelagency ca
                  JOIN business_mentor bm ON ca.reference_no = bm.business_mentor_id
                  WHERE ca.reference_no IN ($placeholders)";

        $stmt = $conn->prepare($query);
        $stmt->execute($bm_ids);
        $tcs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} elseif (strpos($reference_no, 'BM') !== false) {
    // Get TCs directly under this BM
    $stmt = $conn->prepare("SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, bm.business_mentor_id, bm.firstname AS bm_firstname, bm.lastname AS bm_lastname
                            FROM ca_travelagency ca
                            JOIN business_mentor bm ON ca.reference_no = bm.business_mentor_id
                            WHERE ca.reference_no = ? AND ca.status=1");
    $stmt->execute([$reference_no]);
    $tcs = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (!empty($tcs) && $tc_count != 0) {
    foreach ($tcs as $tc) {
        $bm_label = '(' . $tc['business_mentor_id'] . ' - ' . $tc['bm_firstname'] . ' ' . $tc['bm_lastname'] . ')';

        echo '<div class="form-check mb-1">
                <input class="form-check-input tc-checkbox" type="checkbox" value="' . $tc['ca_travelagency_id'] . '" id="tc_' . $tc['ca_travelagency_id'] . '">
                <label class="form-check-label" for="tc_' . $tc['ca_travelagency_id'] . '">' . $tc['ca_travelagency_id'] . ' - ' . $tc['firstname'] . ' ' . $tc['lastname'] . ' ' . $bm_label . '</label>
              </div>';
    }
} else if ($tc_count == 0) {
    echo "<div class='text-dark'>No TCs Applicable.</div>";
} else {
    echo "<div class='text-danger'>No TCs found under this hierarchy.</div>";
}
?>
