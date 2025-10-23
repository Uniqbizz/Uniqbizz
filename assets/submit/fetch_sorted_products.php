<?php
require '../../connect.php';

// Get POST values safely
$user_id = $_POST['userid'] ?? '';
$user_type = $_POST['usertype'] ?? '';
$min_price = floatval($_POST['minPrice'] ?? 0);
$max_price = floatval($_POST['maxPrice'] ?? 9999999);
$min_duration = intval($_POST['minDuration'] ?? 1);
$max_duration = intval($_POST['maxDuration'] ?? 30);
$sort = $_POST['sort'] ?? 'popular';
$ratings = $_POST['ratings'] ?? [];
$tour_type = $_POST['tourType'] ?? [0];
$destination = trim($_POST['destination'] ?? '');
$page = intval($_POST['page'] ?? 1);
$limit = 10;
$offset = ($page - 1) * $limit;

// Sanitize ratings and tour_type
$ratings = array_map('intval', $ratings);
$ratingsStr = implode(',', $ratings);

$tour_type = array_map('intval', $tour_type);

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
        COUNT(b.package_id) AS booking_count";
}

// FROM and JOINs
$from = "
    FROM package p
    JOIN package_pricing t ON p.id = t.package_id
    JOIN category c ON p.category_id = c.id AND c.status=1
    JOIN category_hotel c_h ON p.category_hotel_id = c_h.id";

if ($sort === 'popular') {
    $from .= " LEFT JOIN bookings b ON b.package_id = p.id";
}

// WHERE conditions
$where = "WHERE p.status = 1 AND t.total_package_price_per_adult BETWEEN :min_price AND :max_price";

if ($sort === 'popular') {
    $where .= " AND (p.tour_days - 1) BETWEEN :min_duration AND :max_duration";
}

// Ratings filter
if (!empty($ratingsStr)) {
    $where .= " AND c_h.id IN ($ratingsStr)";
}

// Tour type filter
if (!empty($tour_type)) {
    if (in_array(0, $tour_type)) {
        $where .= " AND c.id IN (1,2)";
    } else {
        $where .= " AND c.id IN (" . implode(',', $tour_type) . ")";
    }
}

// Destination filter
if (!empty($destination)) {
    $where .= " AND p.destination LIKE :destination";
}

// GROUP BY
$groupBy = "
    GROUP BY 
        p.id, p.name, p.description, p.destination, p.location,
        t.total_package_price_per_adult, t.price_up_per_adult, t.markup_total, c_h.name";

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
        $orderBy = "ORDER BY p.created_date DESC";
        break;
    case 'popular':
    default:
        $orderBy = "ORDER BY booking_count DESC, p.id";
        break;
}

// Count total records for pagination
$countQuery = "SELECT COUNT(DISTINCT p.id) AS total $from $where";
$countStmt = $conn->prepare($countQuery);
$countParams = [
    ':min_price' => $min_price,
    ':max_price' => $max_price,
];
if ($sort === 'popular') {
    $countParams[':min_duration'] = $min_duration;
    $countParams[':max_duration'] = $max_duration;
}
if (!empty($destination)) {
    $countParams[':destination'] = "%$destination%";
}
$countStmt->execute($countParams);
$totalRows = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalRows / $limit);

// Final query with LIMIT
$finalQuery = "$select $from $where $groupBy $orderBy LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($finalQuery);

// Bind parameters
$stmt->bindValue(':min_price', $min_price);
$stmt->bindValue(':max_price', $max_price);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

if ($sort === 'popular') {
    $stmt->bindValue(':min_duration', $min_duration, PDO::PARAM_INT);
    $stmt->bindValue(':max_duration', $max_duration, PDO::PARAM_INT);
}
if (!empty($destination)) {
    $stmt->bindValue(':destination', "%$destination%");
}

$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo '<div class="row">';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Check if package has custom image
        $data = $conn->prepare("SELECT image FROM package_pictures WHERE package_id = :pid LIMIT 1");
        $data->execute([':pid' => $row['id']]);
        $value = $data->fetch(PDO::FETCH_ASSOC);
        $imgPath = !empty($value['image']) ? '' . htmlspecialchars($value['image']) : (!empty($row['image']) ? '../../uploading/package_img/' . htmlspecialchars($row['image']) : 'assets/images/no-image.png');

        $price = number_format($row['total_package_price_per_adult']);
        $days = (int)$row['tour_days'];
        $destinationText = htmlspecialchars($row['destination']);
        $name = htmlspecialchars($row['name']);
        $description = htmlspecialchars($row['description']);

        echo "
        <div class='col-md-4 mb-4'>
            <div class='card tour-card shadow-sm'>
                <img src='{$imgPath}' class='card-img-top' alt='{$name}' style='height:220px; object-fit:cover;'>
                <div class='card-body'>
                    <h5 class='card-title'>{$name}</h5>
                    <p class='card-text text-muted mb-1'>{$destinationText}</p>
                    <p class='small text-secondary mb-2'>{$days} Days Tour</p>
                    <p class='fw-bold text-primary mb-0'>₹{$price} / person</p>
                </div>
            </div>
        </div>";
    }
    echo '</div>';

    // Pagination controls
    echo '<div class="pagination d-flex justify-content-center mt-4">';
    if ($page > 1) {
        echo '<button class="btn btn-outline-primary mx-1 pagination-btn" data-page="' . ($page - 1) . '">Prev</button>';
    }

    for ($i = 1; $i <= $totalPages; $i++) {
        $active = $i == $page ? 'btn-primary' : 'btn-outline-primary';
        echo '<button class="btn ' . $active . ' mx-1 pagination-btn" data-page="' . $i . '">' . $i . '</button>';
    }

    if ($page < $totalPages) {
        echo '<button class="btn btn-outline-primary mx-1 pagination-btn" data-page="' . ($page + 1) . '">Next</button>';
    }
    echo '</div>';
} else {
    echo "<p class='text-center mt-4'>No packages found.</p>";
}
?>