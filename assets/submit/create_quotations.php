<?php
// insert quotation data
require '../../connect.php';

// Sanitize input
$name = trim($_POST['enName']);
$email = trim($_POST['enEmail']);
$phone_no = trim($_POST['enPhone']);
$destination = trim($_POST['enDestination']);
$days = trim($_POST['enDuration']);
$travel_date = $_POST['enTDate'];
$formattedDate = date('Y-m-d', strtotime($travel_date));

$adults = trim($_POST['enNadults']);
$children = trim($_POST['enNChild']);
$infants = trim($_POST['enNInfants']);

$pax=$adults+$children+$infants;
$package_suggetion=$_POST['enRemarks'];

$budget = trim($_POST['enBudget']);
$meals = isset($_POST['meals']) ? implode(',', $_POST['meals']) : '';
$user_id = trim($_POST['enUserId']);


$formattedDate = false;

if (!empty($travel_date)) {
  // Try specific known format (e.g. dd/mm/yyyy)
  $dt = DateTime::createFromFormat('d/m/Y', $travel_date); // adjust format if needed
  if ($dt) {
    $formattedDate = $dt->format('Y-m-d');
  } else {
    // Fallback: use strtotime
    $formattedDate = date('Y-m-d', strtotime($travel_date));
  }
}

// Only proceed if date was successfully formatted
if ($formattedDate) {
  $query = "INSERT INTO quotations (name, email, phone_no, destination, days, pax, budget, date, package_suggetion) 
                  VALUES (:name, :email, :phone_no, :destination, :days, :pax, :budget, :date, :package_suggetion)";

  $query_run = $conn->prepare($query);
  $query_exec = $query_run->execute([
    ":name" => $name,
    ":email" => $email,
    ":phone_no" => $phone_no,
    ":destination" => $destination,
    ":days" => $days,
    ":pax" => $pax,
    ":budget" => $budget,
    ":date" => $formattedDate,
    ":package_suggetion" => $package_suggetion
  ]);

  if ($query_exec) {
    echo 1;
  } else {
    // Uncomment below line to debug errors
    print_r($query_run->errorInfo());
    exit;
    echo 0;
  }
} else {
  echo "Invalid date format";
}
