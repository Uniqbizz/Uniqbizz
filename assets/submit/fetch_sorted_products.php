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
    $tour_type = $_POST['tourType']??[0]; // Array of selected tour_type
    $destination = trim($_POST['destination'] ?? '');
    $viewType = trim($_POST['viewType'] ?? '1');
    // destination text

    $ratingsStr = implode(",", $ratings);
    $tour_typeStr = implode(",", $tour_type);
    //pagination logic
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $limit = 12; // number of packages per page
    $offset = ($page - 1) * $limit;
    //pagination logic 

    // Base SELECT
    $select = "
        SELECT 
            p.id,
            p.created_date,
            p.name,
            p.description,
            p.destination,
            p.location,
            p.tour_days,
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
        JOIN category c ON p.category_id = c.id and c.status=1
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
    // tour type filter
    if (!empty($tour_typeStr) && in_array($tour_typeStr,['1','2'])) {
        $where .= " AND FIND_IN_SET(c.id, '{$tour_typeStr}') > 0";
    }else if(!empty($tour_typeStr) && in_array($tour_typeStr,['0'])){
        $where .= " AND FIND_IN_SET(c.id, '{1,2}') > 0";
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
    // withouth pagination
    // $orderByQuery = $select . " " . $from . " " . $where . " " . $groupBy . " " . $orderBy;
    // without pagination
    // pagination logic
    $orderByQuery = $select . " " . $from . " " . $where . " " . $groupBy . " " . $orderBy . " LIMIT {$limit} OFFSET {$offset}";
    // Count total records for pagination
    $countQuery = "SELECT COUNT(DISTINCT p.id) AS total " . $from . " " . $where;
    $countStmt = $conn->prepare($countQuery);
    $countStmt->execute();
    $totalRecords = $countStmt->fetchColumn();
    $totalPages = ceil($totalRecords / $limit);

    // pagination logic
    //print_r($orderByQuery);
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
                                <div class="badge-color">
                                    <p class="trending">Trending</p>
                                </div>
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
                <div class="card rounded shadow-lg mb-5 bg-body-tertiary rounded-3 mt-5 border-0">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 px-0">
                            <div class="parent-container-badge">
                                <a href="#" onclick='viewPackage("<?= $row["id"] ?>")'>
                                    <img src="<?=$value['image']?>" alt="BizzMirth" class="rounded-start imageSize">
                                </a>
                                <div class="badge-color">
                                    <p class="trending">Trending</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-12 col-12 py-3 px-0 border-end borderRemove">
                            <h4 class="fw-bolder pb-2 packageTitle">
                                <a href="#" onclick='viewPackage("<?= $row["id"] ?>")'><?= $row['name'] ?></a>
                            </h4>
                            <p class="pb-2 packageLocation">
                                <i class="fa-solid fa-location-dot fa-sm" style="color: #e03d42;"></i>
                                <span class="text-muted"><?=$row['destination']?></span>
                            </p>
                            <div class="star-ratings d-flex pb-2 packageRatings">
                                <p>
                                    <i class="fa-solid fa-star fa-sm" style="color: #FFD43B;"></i>
                                    <i class="fa-solid fa-star fa-sm" style="color: #FFD43B;"></i>
                                    <i class="fa-solid fa-star fa-sm" style="color: #FFD43B;"></i>
                                    <i class="fa-solid fa-star fa-sm" style="color: #FFD43B;"></i>
                                    <i class="fa-solid fa-star fa-sm" style="color: #FFD43B;"></i>
                                </p>
                                <p><span class="ps-3">3</span> Reviews</p>
                            </div>
                            <div class="text-start list-desc packageDesc">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae, eius nam! Consequatur 
                                iste tenetur quam? Consequuntur at fugit iure voluptatem porro ipsam ad expedita, autem 
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 ps-0">
                            <div class="d-flex justify-content-evenly py-3 packageButton">
                                <button class="rounded-2 btn border-danger-subtle border-2">
                                    <p><i class="fa-solid fa-user fa-xs" style="color: #e03d42;"></i> <span class="text-danger"> 60</span></p>
                                </button>
                                <div class="rounded-2 btn border-danger-subtle border-2">
                                    <p class="text-danger"><i class="fa-solid fa-clock-rotate-left fa-xs" style="color: #e03d42;"></i> <span class="text-danger"><?=$tourNight.' Night '.$tourDay?></span></p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-evenly py-3 packagePriceDiv">
                                <h5 class="fw-bolder pacakgePrice">&#8377; <?= $total_price ?></h5>
                                <h5 class="fw-bolder pacakgePrice text-muted text-decoration-line-through">&#8377; 25,000</h5>
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
