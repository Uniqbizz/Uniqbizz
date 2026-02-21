 <?php
include '../../connect.php';

$tc_count = $_POST['tc_count'];

$tcs = [];
// Get TCs directly under this BM
//no entry in tc_mapping withmap_status=1
$stmt = $conn->prepare("
    SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, bm.business_mentor_id, bm.firstname AS bm_firstname, bm.lastname AS bm_lastname
    FROM ca_travelagency ca
    JOIN business_mentor bm ON ca.reference_no = bm.business_mentor_id
    WHERE ca.status = 1
    AND ca.ca_travelagency_id NOT IN (
        SELECT tc_id FROM tc_mapping WHERE map_status = 1
    )
");
$stmt->execute();
$tcs = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($tcs) && $tc_count != 0) {
    foreach ($tcs as $tc) {
        $bm_label = '(' . $tc['business_mentor_id'] . ' - ' . $tc['bm_firstname'] . ' ' . $tc['bm_lastname'] . ')';

        echo '<div class="form-check mb-1">
                <input class="form-check-input tc-checkbox" name="tc_ids[]" type="checkbox" value="' . $tc['ca_travelagency_id'] . '" id="tc_' . $tc['ca_travelagency_id'] . '">
                <label class="form-check-label" for="tc_' . $tc['ca_travelagency_id'] . '">' . $tc['ca_travelagency_id'] . ' - ' . $tc['firstname'] . ' ' . $tc['lastname'] . ' ' . $bm_label . '</label>
              </div>';
    }
} else if ($tc_count == 0) {
    echo "<div class='text-dark'>No TCs Applicable.</div>";
} else {
    echo "<div class='text-danger'>No TCs found under this hierarchy.</div>";
}