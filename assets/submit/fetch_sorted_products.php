<?php
require '../../connect.php';

$user_id = $_POST['userid'];
$user_type = $_POST['usertype'];
$min_price = floatval($_POST['minPrice']);
$max_price = floatval($_POST['maxPrice']);
$min_duration = intval($_POST['minDuration']);
$max_duration = intval($_POST['maxDuration']);
$sort = $_POST['sort'];
$ratings = $_POST['ratings']; // Array of selected ratings
$destination = trim($_POST['destination'] ?? '');
// destination text

$ratingsStr = implode(",", $ratings);

// Base SELECT
$select = "
    SELECT 
        p.id,
        p.created_date,
        p.name,
        p.description,
        p.destination,
        p.location,
        t.total_package_price_per_adult,
        t.price_up_per_adult,
        t.markup_total,
        c_h.name AS hotel_category";

if ($sort === 'popular') {
    $select .= ",
        p.tour_days,
        COUNT(b.package_id) AS booking_count";
}

// FROM and JOINs
$from = "
    FROM package p
    JOIN package_pricing t ON p.id = t.package_id
    JOIN category c ON p.category_id = c.id
    JOIN category_hotel c_h ON p.category_hotel_id = c_h.id";

if ($sort === 'popular') {
    $from .= " LEFT JOIN bookings b ON b.package_id = p.id";
}

// WHERE filters
$where = "
    WHERE p.status = '1'
    AND t.total_package_price_per_adult BETWEEN {$min_price} AND {$max_price}";

if ($sort === 'popular') {
    $where .= " AND (p.tour_days - 1) BETWEEN {$min_duration} AND {$max_duration}";
}

// ✅ Ratings filter
if (!empty($ratingsStr)) {
    $where .= " AND FIND_IN_SET(c_h.id, '{$ratingsStr}') > 0";
}

// ✅ Destination filter (optional)
if (!empty($destination)) {
    $safeDestination = addslashes($destination);
    $where .= " AND p.destination LIKE '%{$safeDestination}%'";
}

// GROUP BY
$groupBy = "
    GROUP BY 
        p.id, p.name, p.description, p.destination, p.location,
        t.total_package_price_per_adult,t.price_up_per_adult, t.markup_total, c_h.name";

if ($sort === 'popular') {
    $groupBy .= ", p.tour_days";
}

// ORDER BY
switch ($sort) {
    case 'low':
        $orderBy = "ORDER BY t.total_package_price_per_adult ASC";
        break;
    case 'high':
        $orderBy = "ORDER BY t.total_package_price_per_adult DESC";
        break;
    case 'new':
        $orderBy = "ORDER BY p.created_date ASC";
        break;
    case 'popular':
    default:
        $orderBy = "ORDER BY booking_count DESC, p.id";
        break;
}

// ✅ Final Query
$orderByQuery = $select . " " . $from . " " . $where . " " . $groupBy . " " . $orderBy;
//print_r($orderByQuery);
?>
<div class="all-tour-list">
    <div class="row g-4">
        <?php
            require '../../connect.php';

            // $user_id = 0;
            $ta_id = 0;
            // get TA id
            if ($user_id) {
                if ($user_type == '2') {
                    $ta_data = $conn->prepare("SELECT * FROM customer WHERE cust_id = '" . $user_id . "' ");
                    $ta_data->execute();
                    $ta = $ta_data->fetch();
                    $ta_id = $ta['ta_reference'];
                } else if ($user_type == '3') {
                    $ta_id = $user_id;
                }
            }

            $stmt = $conn->prepare($orderByQuery);
            $stmt->execute();
            $stmt->SetFetchMode(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                foreach (($stmt->fetchAll()) as $key => $row) {
                    // $name = $row['name'].''.$row['unique_code'];
                    // echo $srno.' '.$name.'</br>';

                    // get images
                    $data = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = '" . $row['id'] . "' LIMIT 1");
                    $data->execute();
                    $value = $data->fetch();
                    // echo $value['image'].'-id-'.$value['id'].'-package_id-'.$value['package_id'];

                    $adult_price = (float)$row['total_package_price_per_adult'] + (float)$row['price_up_per_adult'];
                    $markup_price = (float)$row['markup_total'];
                    $total_base_price = $adult_price + $markup_price;
                    //print_r($total_base_price);

                    if ($ta_id) {
                        $ta_markup_data = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id = '" . $ta_id . "' AND package_id = '" . $row['id'] . "' AND status='1' LIMIT 1");
                        $ta_markup_data->execute();
                        $ta_markup = $ta_markup_data->fetch();

                        $total_price = $ta_markup['selling_price'] ?? $total_base_price;
                    } else {
                        $total_price = $total_base_price;
                    }

        ?>
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="package-card">
                            <div class="package-img imgEffect4">
                                <a href="#" onclick='viewPackage("<?= $row["id"] ?>")'>
                                    <img src="<?=$value['image'] ?>" alt="BizzMirth">
                                </a>
                                <!-- <div class="image-badge">
                                        <p class="pera">Featured</p>
                                    </div> -->
                            </div>
                            <div class="package-content">
                                <h4 class="area-name">
                                    <a href="#" onclick='viewPackage("<?= $row["id"] ?> ")'><?= $row['name'] ?></a>
                                </h4>
                                <div class="location">
                                    <i class="ri-map-pin-line"></i>
                                    <div class="name"><?= $row['destination'] ?></div>
                                </div>
                                <div class="packages-person">
                                    <div class="count">
                                        <i class="ri-time-line"></i>
                                        <p class="pera"><?= $row['location'] ?></p>
                                    </div>
                                    <!-- <div class="count">
                                            <i class="ri-user-line"></i>
                                            <p class="pera">2 Person</p>
                                        </div> -->
                                </div>
                                <div class="price-review">
                                    <div class="d-flex gap-10">
                                        <p class="light-pera">From</p>
                                        <p class="pera"><span>&#8377</span><?= $total_price ?></p>
                                    </div>
                                    <!-- <div class="rating">
                                            <i class="ri-star-s-fill"></i>
                                            <p class="pera">4.7 (20 Reviews)</p>
                                        </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
        <?php
                }
            }
        ?>
    </div>
</div>