<?php
    $id = $_GET['vkvbvjfgfikix'] ?? '';
    $taId = $_GET['taId'] ?? '';
    $country_id = $_GET['ncy'] ?? '';
    $state_id = $_GET['mst'] ?? '';
    $city_id = $_GET['hct'] ?? '';
    $editfor = $_GET['editfor'] ?? '';

    if ($editfor == 'addreff') {
        $stmt1 = $conn->prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '" . $id . "' ");
        $stmt1->execute();
        $cu_name = $stmt1->fetch();
        $cuName = $cu_name['firstname'] . ' ' . $cu_name['lastname'];
    }
    if ($userType == 10) {
        $stmt11 = $conn->prepare(" SELECT ta_reference_no,customer_type FROM ca_customer WHERE ca_customer_id = '" . $userId . "' ");
        $stmt11->execute();
        $tc = $stmt11->fetch();
        $tcId = $tc['ta_reference_no'];
        $customer_type = $tc['customer_type'];


        $stmt12 = $conn->prepare(" SELECT firstname, lastname FROM ca_travelagency WHERE ca_travelagency_id = '" . $tcId . "' ");
        $stmt12->execute();
        $tcName = $stmt12->fetch();
        $tcFullName = $tcName['firstname'] . ' ' . $tcName['lastname'];

    }
    //institution branch manager (TC level)
    if ($userType == 33) {
        $stmt11 = $conn->prepare(" SELECT ta_reference_no,customer_type FROM ca_customer WHERE ca_customer_id = '" . $userId . "' ");
        $stmt11->execute();
        $tc = $stmt11->fetch();
        $tcId = $tc['ta_reference_no'];
        $customer_type = $tc['customer_type'];


        $stmt12 = $conn->prepare(" SELECT firstname, lastname FROM institution_branch_manager WHERE institution_branch_manager_id = '" . $tcId . "' ");
        $stmt12->execute();
        $tcName = $stmt12->fetch();
        $tcFullName = $tcName['firstname'] . ' ' . $tcName['lastname'];

    }
?>