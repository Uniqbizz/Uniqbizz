<?php
require '../../connect.php';

$table = $_POST["designation"];

if ($table == 'bcm' || $table == 'bdm') {
    if ($table == 'bcm') {
        $user = $conn->prepare("SELECT * FROM employees WHERE status = '1' AND user_type='24' ORDER BY employee_id");
        $id_field = 'employee_id';
        $name_field = 'name';
        $label = '--Select BCM ID & Name--';
    } else if ($table == 'bdm') {
        $user = $conn->prepare("SELECT * FROM employees WHERE status = '1' AND user_type='25' ORDER BY employee_id");
        $id_field = 'employee_id';
        $name_field = 'name';
        $label = '--Select BDM ID & Name--';
    }
} else {
    if ($table == "ca_customer") {
        $user = $conn->prepare("SELECT * FROM ca_customer WHERE status = '1' ORDER BY ca_customer_id");
        $id_field = 'ca_customer_id';
        $name_field = 'firstname'; // with lastname
        $label = '--Select Customer ID & Name--';
    } else if ($table == "business_mentor") {
        $user = $conn->prepare("SELECT * FROM business_mentor WHERE status = '1' ORDER BY business_mentor_id");
        $id_field = 'business_mentor_id';
        $name_field = 'firstname';
        $label = '--Select Business Mentor ID & Name--';
    } else if ($table == "corporate_agency") {
        $user = $conn->prepare("SELECT * FROM corporate_agency WHERE status = '1' ORDER BY corporate_agency_id");
        $id_field = 'corporate_agency_id';
        $name_field = 'firstname';
        $label = '--Select Techno Enterprise ID & Name--';
    } else if ($table == "ca_travelagency") {
        $user = $conn->prepare("SELECT * FROM ca_travelagency WHERE status = '1' ORDER BY ca_travelagency_id");
        $id_field = 'ca_travelagency_id';
        $name_field = 'firstname';
        $label = '--Select Travel Agency ID & Name--';
    }
}

$user->execute();
$user->setFetchMode(PDO::FETCH_ASSOC);

if ($user->rowCount() > 0) {
    $user_data = $user->fetchAll();
    echo '<option value="">' . $label . '</option>';

    foreach ($user_data as $value) {
        $display_name = ($table == 'bcm' || $table == 'bdm')
            ? $value[$name_field]
            : $value['firstname'] . ' ' . $value['lastname'];

        echo '<option value="'.$value[$id_field].'">'.$value[$id_field].' - '.$display_name.'</option>';
    }
} else {
    echo "no_users";
}
?>
