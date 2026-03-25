<?php
    require '../connect.php';

    // ✅ Dynamic Base URL
    $base_url = (
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http"
    ) . "://" . $_SERVER['HTTP_HOST'] . "testca.uniqbizz.com/";

    // ✅ Validate ID
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$id) {
        die("Invalid Package ID");
    }

    // ✅ Secure Query
    $stmt = $conn->prepare("SELECT image FROM package_pictures WHERE package_id = :id LIMIT 1");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ✅ Load Model Data
    include 'package_download.php';

    // ✅ Helper Function
    function renderList($text) {
        $items = array_filter(array_map('trim', explode('.', $text)));
        foreach ($items as $item) {
            echo "<li class='list'>" . htmlspecialchars($item) . "</li>";
        }
    }

    // ✅ Optimize Vehicle Mapping
    $vehicleMap = array_column($vehicle_type_id, 'name', 'id');
    $veh_names = [];
    foreach ($vehicle_type as $v) {
        if (isset($vehicleMap[$v['vehicle_id']])) {
            $veh_names[] = $vehicleMap[$v['vehicle_id']];
        }
    }

    // ✅ Optimize Occupancy Mapping
    $occuMap = array_column($occu_type_id, 'name', 'id');
    $occu_names = [];
    foreach ($occu_type as $o) {
        if (isset($occuMap[$o['occupancy_id']])) {
            $occu_names[] = $occuMap[$o['occupancy_id']];
        }
    }
?>

<!DOCTYPE html>
<html lang="zxx" dir="ltr">
    <head>
        <title>Book Tour</title>

        <link rel="icon" href="<?= $base_url ?>assets/images/icon/fav.png">

        <link rel="stylesheet" href="<?= $base_url ?>assets/css/bootstrap-5.3.0.min.css">
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/remixicon.css">
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/plugin.css">
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/main-style.css">
    </head>

    <body>
        <main id="htmlContent">
            <section class="tour-details-section section-padding2">
                <div class="tour-details-area">
                    <!-- 🔷 Image Slider -->
                    <div class="tour-details-banner">
                        <div class="swiper tourSwiper-active">
                            <div class="swiper-wrapper">

                            <?php if (!empty($images)): ?>
                                <?php foreach ($images as $image): ?>
                                    <div class="swiper-slide">
                                        <img src="<?= $base_url . htmlspecialchars($image['image']) ?>" alt="BizzMirth">
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            </div>
                        </div>
                    </div>

                    <div class="tour-details-container">
                        <div class="container">

                            <div class="details-heading">

                                <h4 class="title"><?= htmlspecialchars($package['name']) ?></h4>

                                <div class="location">
                                    <i class="ri-map-pin-line"></i>
                                    <div class="name"><?= htmlspecialchars($package['destination']) ?></div>
                                </div>

                                <p><?= htmlspecialchars($package['location']) ?></p>
                                <p><?= htmlspecialchars($package['sightseeing_type']) ?></p>

                                <p><?= implode(', ', $veh_names) ?></p>
                                <p><?= implode(', ', $occu_names) ?></p>

                                <div class="price-review">
                                    <p>₹<?= htmlspecialchars($amount['total_package_price_per_adult']) ?>/-</p>
                                </div>

                            </div>

                            <!-- 🔷 About -->
                            <div class="tour-details-content">
                                <h4>About</h4>
                                <p><?= htmlspecialchars($package['description']) ?></p>
                            </div>

                            <!-- 🔷 Included / Excluded -->
                            <div class="tour-include-exclude">
                                <div class="row">

                                    <div class="col-md-6">
                                        <h4>Included</h4>
                                        <ul><?php renderList($itinery['inclusion']); ?></ul>
                                    </div>

                                    <div class="col-md-6">
                                        <h4>Excluded</h4>
                                        <ul><?php renderList($itinery['exclusion']); ?></ul>
                                    </div>

                                </div>
                            </div>

                            <!-- 🔷 Tour Plan -->
                            <div class="tour-details-content">
                                <h4>Tour Plan</h4>
                                <?php include 'tour_plan.php'; ?>
                            </div>

                            <!-- 🔷 Remarks -->
                            <div>
                                <h4>Remarks</h4>
                                <ul><?php renderList($itinery['remark']); ?></ul>
                            </div>

                            <!-- 🔷 Sidebar -->
                            <div>
                                <p>Adult Price: ₹<?= htmlspecialchars($amount['total_package_price_per_adult']) ?></p>
                                <p>Child Price: ₹<?= htmlspecialchars($amount['total_package_price_per_child']) ?></p>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- 🔷 JS -->
        <script src="<?= $base_url ?>assets/libs/jquery/jquery.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

        <?php if (!defined('IS_API')): ?>
        <script>
            window.print();
            window.onafterprint = () => window.history.back();
        </script>
        <?php endif; ?>

    </body>
</html>