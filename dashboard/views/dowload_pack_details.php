<?php
    $id = $_GET['id']; //package_id '156'
    require '../connect.php';
    include '../models/package_download/package_download.php';
?>
<!DOCTYPE html>
<html lang="zxx" dir="lrt">

<head>
    <!-- Title -->
    <title>Book Tour </title>
    <link rel="icon" type="image/x-icon" sizes="20x20" href="../../assets/images/icon/fav.png">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap-5.3.0.min.css">
    <!-- Fonts & icon -->
    <link rel="stylesheet" type="text/css" href="../../assets/css/remixicon.css">
    <!-- Plugin -->
    <link rel="stylesheet" type="text/css" href="../../assets/css/plugin.css">
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="../../assets/css/main-style.css">
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
                            $data = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = $id limit 1");
                            $data->execute();
                            $data->setFetchMode(PDO::FETCH_ASSOC);
                            if ($data->rowCount() > 0) {
                                $counterimage = 0;
                                foreach (($data->fetchAll()) as $key_1 => $image) {
                                    echo '<div class="swiper-slide">
                                            <img src="../../' . $image['image'] . '" alt="BizzMirth" >
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
                                                <!-- data load from models file -->
                                                <?php include '../models/package_download/tour_plan.php' ?>
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
    <script src="../../assets/libs/jquery/jquery.min.js"></script>
    <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        window.print();
        window.onafterprint = function() {
            window.history.back(); // or use window.location.href = 'yourpage.php';
        };
    </script>
</body>

</html>