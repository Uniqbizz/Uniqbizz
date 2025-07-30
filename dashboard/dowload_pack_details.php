<?php
$id = $_GET['id']; //package_id '156'
require '../connect.php';
// package
$stmt = $conn->prepare("SELECT * FROM package WHERE id = $id");
$stmt->execute();
$package = $stmt->fetch();
$cat_id = $package['category_id'];
$sub_cat_id = $package['sub_category_id'];
$hotel_cat_id = $package['category_hotel_id'];
$meal_cat_id = $package['category_meal_id'];
$validity = $package['validity'] ?? 0;
// itinery 
$data2 = $conn->prepare("SELECT * FROM package_itinerary_details WHERE package_id = $id");
$data2->execute();
$itinery = $data2->fetch();
// package_pricing 
$data3 = $conn->prepare("SELECT * FROM package_pricing WHERE package_id = $id");
$data3->execute();
$amount = $data3->fetch();
// category 
$data5 = $conn->prepare("SELECT * FROM category WHERE id = $cat_id");
$data5->execute();
$category = $data5->fetch();
// sub_cat 
$data6 = $conn->prepare("SELECT * FROM subcategory WHERE id = $sub_cat_id");
$data6->execute();
$sub_cat = $data6->fetch();
// cat hotel 
$data7 = $conn->prepare("SELECT * FROM category_hotel WHERE id = $hotel_cat_id");
$data7->execute();
if ($data7->rowCount() > 0) {
    $hotel_cat = $data7->fetch();
} else {
    $hotel_cat = "null";
}
// cat meal 
$data8 = $conn->prepare("SELECT * FROM category_meal WHERE id = $meal_cat_id");
$data8->execute();
if ($data8->rowCount() > 0) {
    $meal_cat = $data8->fetch();
} else {
    $meal_cat = "null";
}
// Fetch occupancy types for a given package_id
$data9 = $conn->prepare("SELECT * FROM `package_to_category_occupancy` WHERE package_id = :id");
$data9->bindParam(':id', $id, PDO::PARAM_INT);
$data9->execute();
$occu_type = $data9->rowCount() > 0 ? $data9->fetchAll(PDO::FETCH_ASSOC) : [];
// Fetch all occupancy categories
$data10 = $conn->prepare("SELECT id, name FROM `category_occupancy`");
$data10->execute();
$occu_type_id = $data10->rowCount() > 0 ? $data10->fetchAll(PDO::FETCH_ASSOC) : [];
// Fetch vehicle types for a given package_id
$data11 = $conn->prepare("SELECT * FROM `package_to_category_vehicle` WHERE package_id = :id");
$data11->bindParam(':id', $id, PDO::PARAM_INT);
$data11->execute();
$vehicle_type = $data11->rowCount() > 0 ? $data11->fetchAll(PDO::FETCH_ASSOC) : []; // Corrected variable name
// Fetch all vehicle categories
$data12 = $conn->prepare("SELECT id, name FROM `category_vehicle`");
$data12->execute();
$vehicle_type_id = $data12->rowCount() > 0 ? $data12->fetchAll(PDO::FETCH_ASSOC) : []; // Corrected variable name
//cancellation policy
$data9 = $conn->prepare("SELECT * FROM cancel_policy WHERE package_id = $id");
$data9->execute();
if ($data9->rowCount() > 0) {
    $cancel_policy = $data9->fetch();
} else {
    $cancel_policy['policy_1'] = 0;
    $cancel_policy['policy_2'] = 0;
    $cancel_policy['policy_3'] = 0;
}
?>
<!DOCTYPE html>
<html lang="zxx" dir="lrt">

<head>
    <!-- Title -->
    <title>Book Tour </title>
    <link rel="icon" type="image/x-icon" sizes="20x20" href="../assets/images/icon/fav.png">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-5.3.0.min.css">
    <!-- Fonts & icon -->
    <link rel="stylesheet" type="text/css" href="../assets/css/remixicon.css">
    <!-- Plugin -->
    <link rel="stylesheet" type="text/css" href="../assets/css/plugin.css">
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/main-style.css">
</head>

<body>
    <main id="htmlContent">
        <!-- Destination area S t a r t -->
        <section class="tour-details-section section-padding2">
            <div class="tour-details-area">

                <!-- Details Banner Slider -->
                <div class="tour-details-banner">
                    <div class="swiper tourSwiper-active">
                        <div class="swiper-wrapper">
                            <?php
                            require '../connect.php';
                            $data = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = $id limit 1");
                            $data->execute();
                            $data->setFetchMode(PDO::FETCH_ASSOC);
                            if ($data->rowCount() > 0) {
                                $counterimage = 0;
                                foreach (($data->fetchAll()) as $key_1 => $image) {
                                    echo '<div class="swiper-slide">
                                            <img src="../' . $image['image'] . '" alt="BizzMirth" >
                                          </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="tour-details-container">
                    <div class="container">
                        <div class="details-heading">
                            <div class="d-flex flex-column">
                                <h4 class="title" id="pack_name"><?php echo $package['name'] ?></h4>
                                <div class="d-flex flex-wrap align-items-center gap-30 mt-16">
                                    <div class="location">
                                        <i class="ri-map-pin-line"></i>
                                        <div class="name"><?php echo $package['destination'] ?></div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="d-flex align-items-center flex-wrap gap-20">
                                        <div class="count">
                                            <i class="ri-map-pin-line"></i>
                                            <p class="pera"><?php echo $package['location'] ?></p>
                                        </div>
                                        <div class="count">
                                            <i class="ri-landscape-line"></i>
                                            <p class="pera"><?php echo $package['sightseeing_type'] ?></p>
                                        </div>
                                        <div class="count">
                                            <i class="ri-roadster-line"></i>
                                            <?php
                                            $veh_names = []; // Initialize an array to store vehicle names
                                            foreach ($vehicle_type as $value) { // Corrected variable name
                                                foreach ($vehicle_type_id as $idvalue) { // Corrected variable name
                                                    if ($idvalue['id'] == $value['vehicle_id']) { // Corrected key reference
                                                        $veh_names[] = $idvalue['name']; // Store vehicle names in an array
                                                    }
                                                }
                                            }
                                            echo '<p class="pera">' . implode(', ', $veh_names) . '</p>'; // Join array values with commas
                                            ?>
                                        </div>
                                        <div class="count">
                                            <i class="ri-hotel-bed-line"></i>
                                            <?php
                                            $occu_names = []; // Initialize an array to store occupancy names
                                            foreach ($occu_type as $value) {
                                                foreach ($occu_type_id as $idvalue) {
                                                    if ($idvalue['id'] == $value['occupancy_id']) { // Ensure proper key reference
                                                        $occu_names[] = $idvalue['name']; // Store occupancy names in an array
                                                    }
                                                }
                                            }
                                            echo '<p class="pera">' . implode(', ', $occu_names) . '</p>';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="price-review">
                                <div class="d-flex gap-10 align-items-end">
                                    <p class="light-pera">Starting From</p>
                                    <p class="pera">
                                        <span>&#8377</span><?php echo $amount['total_package_price_per_adult'] ?>/-
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-30">
                            <div class="row g-4">
                                <div class="col-xl-8 col-lg-7">
                                    <div class="tour-details-content">
                                        <h4 class="title">About</h4>
                                        <p class="pera"><?php echo $package['description'] ?></p>
                                    </div>
                                    <div class="tour-include-exclude radius-6">
                                        <div class="row">
                                            <div class="includ-exclude-point col-md-5">
                                                <h4 class="title">Included</h4>
                                                <ul class="expect-list">
                                                    <?php
                                                    $decription = $itinery['inclusion'];
                                                    $decription_1 = explode('.', $decription);
                                                    foreach ($decription_1 as $desc) {
                                                        echo ' <li class="list">' . $desc . '</li> ';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="divider border-1 p-0"></div>
                                            <div class="includ-exclude-point col-md-5">
                                                <h4 class="title">Exclude</h4>
                                                <ul class="expect-list">
                                                    <?php
                                                    $decription = $itinery['exclusion'];
                                                    $decription_1 = explode('.', $decription);
                                                    foreach ($decription_1 as $desc) {
                                                        echo ' <li class="list">' . $desc . '</li> ';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tour-details-content mb-30">
                                        <h4 class="title">Tour Plan</h4>
                                        <div class="destination-accordion">
                                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                                <?php
                                                $data4 = $conn->prepare("SELECT * FROM package_trip_days WHERE package_id = $id");
                                                $data4->execute();
                                                $data4->setFetchMode(PDO::FETCH_ASSOC);

                                                if ($data4->rowCount() > 0) {
                                                    foreach (($data4->fetchAll()) as $key_3 => $day) {
                                                        $decription = $day['day_details'];
                                                        $decription_1 = explode(".", $decription);
                                                        $decription_2 = implode(".<br>", $decription_1);
                                                        echo '<div class="accordion-item">
                                                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                                                    <button class="accordion-button" type="button"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#panelsStayOpen-collapseOne"
                                                                        aria-expanded="true"
                                                                        aria-controls="panelsStayOpen-collapseOne">
                                                                        Day ' . ++$key_3 . ' - ' . $day['title'] . '
                                                                    </button>
                                                                </h2>
                                                                <div id="panelsStayOpen-collapseOne"
                                                                    class="accordion-collapse collapse show"
                                                                    aria-labelledby="panelsStayOpen-headingOne">
                                                                    <div class="accordion-body">
                                                                        <ul class="listing">
                                                                            <li class="list">
                                                                                ' . $decription_2 . '
                                                                            </li>
                                                                        </ul>
                                                                        <hr style="border-top: 1px solid #4b5051" />
                                                                        <div class="row">
                                                                            <div class="col-md-6 col-sm-12 col-12 d-flex">
                                                                                <h6>Meal:&nbsp;</h6>
                                                                                <p>' . $day['meal_plan'] . '</p>
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-12 col-12 d-flex">
                                                                                <h6>Transport:&nbsp;</h6>
                                                                                <p>' . $day['day_tansport'] . '</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tour-include-exclude radius-6">
                                        <div class="row">
                                            <div class="includ-exclude-point col-md-12 col-sm-12 col-12">
                                                <h4 class="title">Remark</h4>
                                                <ul class="expect-list">
                                                    <?php
                                                    $decription = $itinery['remark'];
                                                    $decription_1 = explode('.', $decription);
                                                    foreach ($decription_1 as $desc) {
                                                        echo ' <li class="list">' . $desc . '</li> ';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-5" id="sidebar-sticky">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 mb-3" id="sidebar-sticky">
                                            <aside class="date-travel-card position-sticky top-0 pt-3 pb-1">
                                                <div class="sidebar-item sidebar-item-dark">
                                                    <div class="detail-title mb-3">
                                                        <p class="fs-6 text-muted">Per Adult Price: <b>₹
                                                                <?php echo $amount['total_package_price_per_adult']; ?>/-</b>
                                                        </p>
                                                        <p class="fs-6 text-muted">Per Child Price: <b>₹
                                                                <?php echo $amount['total_package_price_per_child']; ?>/-</b>
                                                        </p>
                                                    </div>
                                                </div>
                                            </aside>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        window.print();
        window.onafterprint = function() {
            window.history.back(); // or use window.location.href = 'yourpage.php';
        };
    </script>
</body>

</html>