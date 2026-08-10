<?php

require '../../connect.php';

$user_id       = $_POST['userid'] ?? 0;
$user_type     = $_POST['usertype'] ?? '';
$min_price     = floatval($_POST['minPrice'] ?? 0);
$max_price     = floatval($_POST['maxPrice'] ?? 999999999);
$min_duration  = intval($_POST['minDuration'] ?? 1);
$max_duration  = intval($_POST['maxDuration'] ?? 999);
$sort          = trim($_POST['sort'] ?? '');
$ratings       = $_POST['ratings'] ?? [];
$theme       = $_POST['theme'] ?? [];
$tour_type     = $_POST['tourType'] ?? [];
$destination   = trim($_POST['destination'] ?? 'All Locations');
$viewType      = trim($_POST['viewType'] ?? '1');


// ============================================================
// NORMALIZE ARRAYS
// ============================================================

if (!is_array($ratings)) {
    $ratings = [$ratings];
}
if (!is_array($theme)) {
    $theme = [$theme];
}

$theme = array_filter(
    array_map('trim', $theme),
    fn($value) => $value !== ''
);

if (!is_array($tour_type)) {
    $tour_type = [$tour_type];
}

$ratings   = array_map('intval', $ratings);
// Theme values are strings
$tour_type = array_map('intval', $tour_type);


// ============================================================
// PAGINATION
// ============================================================

$page = isset($_POST['page']) ? max(1, intval($_POST['page'])) : 1;

$limit  = 12;
$offset = ($page - 1) * $limit;


// ============================================================
// BASE SELECT
// ============================================================

$select = "
    SELECT
        p.id,
        p.created_date,
        p.name,
        p.description,
        p.location,
        p.tour_days,
        p.highlight_type,
        p.package_type,
        t.total_package_price_per_adult,
        t.price_up_per_adult,
        t.markup_total,

        c_h.name AS hotel_category
";


// ============================================================
// FROM / JOIN
// ============================================================

$from = "
    FROM package p

    JOIN package_pricing t
        ON p.id = t.package_id

    JOIN category c
        ON p.category_id = c.id
        AND c.status = 1

    JOIN category_hotel c_h
        ON p.category_hotel_id = c_h.id
";


// ============================================================
// POPULAR JOIN
// ============================================================

if ($sort === 'Popular') {

    $select .= ",
        COUNT(b.package_id) AS booking_count
    ";

    $from .= "
        LEFT JOIN bookings b
            ON b.package_id = p.id
    ";
}


// ============================================================
// WHERE
// ============================================================

$where = "
    WHERE p.status = '1'

    AND t.total_package_price_per_adult
        BETWEEN {$min_price} AND {$max_price}
";


// ============================================================
// POPULAR DURATION FILTER
// ============================================================

if ($sort === 'Popular') {

    $where .= "
        AND (p.tour_days - 1)
        BETWEEN {$min_duration} AND {$max_duration}
    ";
}


// ============================================================
// RATING FILTER
// ============================================================

if (!empty($ratings)) {

    $ratingsStr = implode(',', $ratings);

    $where .= "
        AND FIND_IN_SET(c_h.id, '{$ratingsStr}') > 0
    ";
}

// ============================================================
// TOUR TYPE FILTER
// 0 = ALL
// ============================================================

if (!empty($tour_type) && !in_array(0, $tour_type, true)) {

    $tourTypeStr = implode(',', $tour_type);

    $where .= "
        AND FIND_IN_SET(c.id, '{$tourTypeStr}') > 0
    ";
}


// ============================================================
// DESTINATION FILTER
// ============================================================

if (
    !empty($destination) &&
    $destination !== 'All Locations'
) {

    $destinationEscaped = $conn->quote('%' . trim($destination) . '%');

    $where .= "
        AND (
            LOWER(p.location) LIKE LOWER($destinationEscaped)
            OR LOWER(p.name) LIKE LOWER($destinationEscaped)
            OR LOWER(p.destination) LIKE LOWER($destinationEscaped)
        )
    ";
}
// ============================================================
// THEME FILTER
// ============================================================

if (!empty($theme)) {

    $themeValues = array_map(function ($value) use ($conn) {
        return $conn->quote(trim($value));
    }, $theme);

    $themeStr = implode(',', $themeValues);

    $where .= "
        AND (
            p.package_type IN ($themeStr)
            OR NULLIF(TRIM(p.package_type), '') IS NULL
            OR p.package_type NOT IN ($themeStr)
        )
    ";
}

// ============================================================
// GROUP BY
// ============================================================

$groupBy = "
    GROUP BY
        p.id,
        p.created_date,
        p.name,
        p.description,
        p.location,
        p.tour_days,
        p.highlight_type,
        t.total_package_price_per_adult,
        t.price_up_per_adult,
        t.markup_total,
        c_h.name
";


// ============================================================
// ORDER BY
// ============================================================

switch ($sort) {

    // Lowest price
    case 'low':

        $orderBy = "
            ORDER BY
                t.total_package_price_per_adult ASC
        ";

        break;


    // Highest price
    case 'high':

        $orderBy = "
            ORDER BY
                t.total_package_price_per_adult DESC
        ";

        break;


    // Newest packages
    case 'new':

        $orderBy = "
            ORDER BY
                p.created_date DESC
        ";

        break;


    // Popular
    // Sort according to highlight_type value
    case 'Popular':

        $orderBy = "
            ORDER BY
                p.highlight_type ASC
        ";

        break;


    // Default
    default:

        $orderBy = "
            ORDER BY
                p.created_date DESC
        ";

        break;
}


// ============================================================
// FINAL QUERY
// ============================================================

$orderByQuery = "
    {$select}
    {$from}
    {$where}
    {$groupBy}
    {$orderBy}
    LIMIT {$limit}
    OFFSET {$offset}
";


// ============================================================
// COUNT QUERY
// ============================================================

$countQuery = "
    SELECT COUNT(DISTINCT p.id) AS total
    {$from}
    {$where}
";

$countStmt = $conn->prepare($countQuery);

$countStmt->execute();

$totalRecords = (int) $countStmt->fetchColumn();

$totalPages = $totalRecords > 0
    ? ceil($totalRecords / $limit)
    : 0;


?>

<div class="all-tour-list <?=$viewType == 1?'':'d-none'?> " id="all-tour-list">
    <div class="row g-4">
        <?php
            require '../../connect.php';

            // $user_id = 0;
            $ta_id = 0;
            // get TA id
            if ($user_id) {
                if ($user_type == '10') {
                    $ta_data = $conn->prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '" . $user_id . "' ");
                    $ta_data->execute();
                    $ta = $ta_data->fetch();
                    $ta_id = $ta['ta_reference_no'];
                } else if ($user_type == '11') {
                    $ta_id = $user_id;
                }
            }

            $stmt = $conn->prepare($orderByQuery);
            $stmt->execute();
            // print_r($stmt);
            // exit;
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
                    // $markup_price = (float)$row['markup_total'];
                    $total_base_price = $adult_price ;
                    //print_r($total_base_price);

                    $tourDay = (int)$row['tour_days'] - 1;
                    $tourNight = (int)$row['tour_days'] - 2;

                    if ($ta_id) {
                        $ta_markup_data = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id = '" . $ta_id . "' AND package_id = '" . $row['id'] . "' AND status='1' LIMIT 1");
                        $ta_markup_data->execute();
                        $ta_markup = $ta_markup_data->fetch();
                        $total_price = $ta_markup['selling_price_adult'] ?? $total_base_price;
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
                                <?php

                                    $packageType = trim((string)($row['highlight_type'] ?? ''));

                                    switch ($packageType) {

                                        case 'Trending':
                                            $badgeText = 'Trending';
                                            $badgeClass = 'badge-trending';
                                            break;

                                        case 'Best Seller':
                                            $badgeText = 'Best Seller';
                                            $badgeClass = 'badge-bestseller';
                                            break;

                                        case 'New Arrival':
                                            $badgeText = 'New Arrival';
                                            $badgeClass = 'badge-new-arrival';
                                            break;

                                        case '':
                                            $badgeText = 'Popular';
                                            $badgeClass = 'badge-popular';
                                            break;

                                        default:
                                            $badgeText = 'Popular';
                                            $badgeClass = 'badge-popular';
                                            break;
                                    }

                                ?>

                                <div class="badge-color <?= $badgeClass ?>">
                                    <p><?= htmlspecialchars($badgeText) ?></p>
                                </div>
                            </div>
                            <div class="package-content">
                                <h4 class="area-name">
                                    <a href="#" onclick='viewPackage("<?= $row["id"] ?> ")'><?= $row['name'] ?></a>
                                </h4>
                                <div class="location">
                                    <i class="ri-map-pin-line"></i>
                                    <div class="name"><?= $row['location'] ?></div>
                                </div>
                                <div class="packages-person">
                                    <div class="count">
                                        <i class="ri-time-line"></i>
                                        <!-- <p class="pera"><?= $row['location'] ?></p> -->
                                        <p class="pera"> <?= $tourNight ?> Night <?= $tourDay ?> Days </p>
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
<div class="all-tour-grid <?=$viewType == 2?'':'d-none'?>" id="all-tour-grid">
    <?php
            require '../../connect.php';

            // $user_id = 0;
            $ta_id = 0;
            // get TA id
            if ($user_id) {
                if ($user_type == '10') {
                    $ta_data = $conn->prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '" . $user_id . "' ");
                    $ta_data->execute();
                    $ta = $ta_data->fetch();
                    $ta_id = $ta['ta_reference_no'];
                } else if ($user_type == '11') {
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
                    // $markup_price = (float)$row['markup_total'];
                    $total_base_price = $adult_price ;
                    //print_r($total_base_price);

                    //calculate nights and days from tour days number
                    $tourDay = (int)$row['tour_days'] - 1;
                    $tourNight = (int)$row['tour_days'] - 2;

                    // show inflated pricing and current price
                    $total_price_inflated = $adult_price + 5000;
                    
                    // tour package description limit words counts to show in list view
                    $description = $row['description'];
                    $maxLength = 500;
                    if (strlen($description) > $maxLength) {
                        $truncatedString = substr($description, 0, $maxLength) . '...';
                    } else {
                        $truncatedString = $description;
                    }

                    if ($ta_id) {
                        $ta_markup_data = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id = '" . $ta_id . "' AND package_id = '" . $row['id'] . "' AND status='1' LIMIT 1");
                        $ta_markup_data->execute();
                        $ta_markup = $ta_markup_data->fetch();
                        $total_price = $ta_markup['selling_price_adult'] ?? $total_base_price;
                    } else {
                        $total_price = $total_base_price;
                    }
    ?>
                <div class="card rounded shadow-lg mb-5 bg-body-tertiary rounded-3 mt-5 border-0">
                    <div class="row">
                        <div class="col-lg-4 col-md-12 col-sm-12 col-12 px-0">
                            <div class="parent-container-badge">
                                <a href="#" onclick='viewPackage("<?= $row["id"] ?>")'>
                                    <img src="<?=$value['image']?>" alt="BizzMirth" class="rounded-start imageSize">
                                </a>
                                <div class="badge-color">
                                    <p class="trending">Trending</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12 col-12 py-3 px-0 border-end borderRemove">
                            <h4 class="fw-bolder pb-2 packageTitle">
                                <a href="#" onclick='viewPackage("<?= $row["id"] ?>")'><?= $row['name'] ?></a>
                            </h5>
                            <p class="pb-2 packageLocation">
                                <i class="fa-solid fa-location-dot fa-sm" style="color: #e03d42;"></i>
                                <span class="text-muted list-desc"><?=$row['location']?></span>
                            </p>
                            <!-- <div class="star-ratings d-flex pb-2 packageRatings">
                                <p>
                                    <i class="fa-solid fa-star fa-sm" style="color: #FFD43B;"></i>
                                    <i class="fa-solid fa-star fa-sm" style="color: #FFD43B;"></i>
                                    <i class="fa-solid fa-star fa-sm" style="color: #FFD43B;"></i>
                                    <i class="fa-solid fa-star fa-sm" style="color: #FFD43B;"></i>
                                    <i class="fa-solid fa-star fa-sm" style="color: #FFD43B;"></i>
                                </p>
                                <p><span class="ps-3">3</span> Reviews</p>
                            </div> -->
                            <div class="text-start list-desc packageDesc">
                                <?= $truncatedString ?>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12 col-12 ps-0">
                            <div class="d-flex justify-content-evenly py-3 packageButton">
                                <button class="rounded-2 btn border-danger-subtle border-2">
                                    <p><i class="fa-solid fa-user fa-xs" style="color: #e03d42;"></i> <span class="text-danger"> 1</span></p>
                                </button>
                                <div class="rounded-2 btn border-danger-subtle border-2">
                                    <p class="text-danger"><i class="fa-solid fa-clock-rotate-left fa-xs" style="color: #e03d42;"></i> <span class="text-danger"><?=$tourNight.' Nights '.$tourDay.' Days'?></span></p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-evenly py-3 packagePriceDiv">
                                <h5 class="fw-bolder pacakgePrice">&#8377; <?= $total_price ?></h5>
                                <h5 class="fw-bolder pacakgePrice text-muted text-decoration-line-through">&#8377; <?= $total_price_inflated ?></h5>
                            </div>
                            <div class="d-flex justify-content-center py-3 packageExplore">
                                <a class="btn btn-background-color fw-bolder" href="#" role="button" onclick='viewPackage("<?= $row["id"] ?>")\'>Explore</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                
    <?php
            }
        }
    ?>

</div>
<!-- pagination  logic-->
    <?php
        if ($totalPages > 1):
    ?>
    <div class="pagination-controls text-center mt-4 mb-4">
        <button class="btn btn-danger prev-page" data-page="<?= max(1, $page - 1) ?>" <?= ($page <= 1) ? 'disabled' : '' ?>>Prev</button>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <button class="btn btn-light mx-1 page-btn <?= ($i == $page) ? 'active text-white bg-danger' : '' ?>" data-page="<?= $i ?>">
                <?= $i ?>
            </button>
        <?php endfor; ?>

        <button class="btn btn-danger next-page" data-page="<?= min($totalPages, $page + 1) ?>" <?= ($page >= $totalPages) ? 'disabled' : '' ?>>Next</button>
    </div>
    <?php endif; ?>
<!-- pagination logic -->
