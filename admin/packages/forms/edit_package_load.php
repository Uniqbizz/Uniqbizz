<?php

require '../../connect.php';

date_default_timezone_set('Asia/Calcutta');

if (!isset($_POST['id']) || empty($_POST['id'])) {
    exit("Invalid Request");
}

$packageId = (int)$_POST['id'];

/*
|--------------------------------------------------------------------------
| Package
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package WHERE id = :id");
$stmt->execute([':id' => $packageId]);
$package = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Package Itinerary Details
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package_itinerary_details WHERE package_id = :package_id");
$stmt->execute([':package_id' => $packageId]);
$itineraryDetails = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Package Trip Days
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package_trip_days WHERE package_id = :package_id");
$stmt->execute([':package_id' => $packageId]);
$packageTripDays = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Package Pricing
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package_pricing WHERE package_id = :package_id");
$stmt->execute([':package_id' => $packageId]);
$packagePricing = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Package Pricing Markup
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package_pricing_markup WHERE package_id = :package_id");
$stmt->execute([':package_id' => $packageId]);
$packagePricingMarkup = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Package Pricing Markup TE Chain
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package_pricing_markup_te_chain WHERE package_id = :package_id");
$stmt->execute([':package_id' => $packageId]);
$packagePricingTeChain = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Package Pricing Markup Institution
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package_pricing_markup_institution WHERE package_id = :package_id");
$stmt->execute([':package_id' => $packageId]);
$packagePricingInstitution = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Package Pricing Markup Techno Institution
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package_pricing_markup_techno_institution WHERE package_id = :package_id");
$stmt->execute([':package_id' => $packageId]);
$packagePricingTechnoInstitution = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Package Policy
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package_policy WHERE package_id = :package_id");
$stmt->execute([':package_id' => $packageId]);
$packagePolicy = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Package Policy Documents
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package_policy_document WHERE package_id = :package_id");
$stmt->execute([':package_id' => $packageId]);
$packagePolicyDocuments = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Package Pictures
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = :package_id");
$stmt->execute([':package_id' => $packageId]);
$packagePictures = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Use the variables directly below
|--------------------------------------------------------------------------
*/

// Example:
// echo $package['package_name'];
// echo $packagePricing['adult_price'];
// foreach ($packageTripDays as $day) { ... }
// foreach ($packagePictures as $picture) { ... }

?>