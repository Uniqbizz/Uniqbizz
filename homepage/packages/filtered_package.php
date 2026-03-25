<?php
header('Content-Type: application/json');
require '../../connect.php';

try {
    // ✅ Fetch POST Data
    $data = json_decode(file_get_contents("php://input"), true);

    $user_id       = isset($data['userId']) ? $data['userId'] : '';
    $user_type     = isset($data['usertype']) ? $data['usertype'] : "";
    $min_price     = ceil(floatval($data['minPrice'] ?? 0));
    $max_price     = ceil(floatval($data['maxPrice'] ?? 999999));
    $min_duration  = intval($data['minDuration'] ?? 0);
    $max_duration  = intval($data['maxDuration'] ?? 999);
    $sort          = isset($data['sort']) ? $data['sort'] : '';
    $ratings       = $data['ratings'] ?? []; // Array
    $destination   = trim($data['destination'] ?? '');

    $ratingsStr = !empty($ratings) ? implode(",", array_map('intval', $ratings)) : '';

    // ✅ Base SELECT
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
            (t.total_package_price_per_adult + t.price_up_per_adult) AS total_price,
            c_h.name AS hotel_category";

    if ($sort === 'popular') {
        $select .= ", p.tour_days, COUNT(b.package_id) AS booking_count";
    }

    // ✅ FROM & JOIN
    $from = "
        FROM package p
        JOIN package_pricing t ON p.id = t.package_id
        JOIN category c ON p.category_id = c.id
        JOIN category_hotel c_h ON p.category_hotel_id = c_h.id";

    if ($sort === 'popular') {
        $from .= " LEFT JOIN bookings b ON b.package_id = p.id";
    }

    // ✅ WHERE Conditions
    $where = "
        WHERE p.status = '1'
        AND (t.total_package_price_per_adult + t.price_up_per_adult) BETWEEN {$min_price} AND {$max_price}";

    if ($sort === 'popular') {
        $where .= " AND (p.tour_days - 1) BETWEEN {$min_duration} AND {$max_duration}";
    }

    if (!empty($ratingsStr)) {
        $where .= " AND FIND_IN_SET(c_h.id, '{$ratingsStr}') > 0";
    }

    if (!empty($destination)) {
        $safeDestination = addslashes($destination);
        $where .= " AND p.destination LIKE '%{$safeDestination}%'";
    }

    // ✅ GROUP BY
    $groupBy = "
        GROUP BY 
            p.id, p.name, p.description, p.destination, p.location,
            t.total_package_price_per_adult, t.price_up_per_adult, c_h.name";

    if ($sort === 'popular') {
        $groupBy .= ", p.tour_days";
    }

    // ✅ ORDER BY
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
            $orderBy = "ORDER BY booking_count DESC, p.id DESC";
            break;
        default:
            $orderBy = "ORDER BY p.id DESC"; // fallback when no sort provided
            break;
    }

    $finalQuery = $select . " " . $from . " " . $where . " " . $groupBy . " " . $orderBy;

    // ✅ Get Travel Agent ID (if applicable)
    $ta_id = 0;
    if ($user_id) {
        if ($user_type == 2) {
            $ta_data = $conn->prepare("SELECT ta_reference FROM customer WHERE cust_id = :user_id");
            $ta_data->execute([':user_id' => $user_id]);
            $ta = $ta_data->fetch();
            $ta_id = $ta['ta_reference'] ?? 0;
        } elseif ($user_type == 3) {
            $ta_id = $user_id;
        }
    }

    // ✅ Execute main query
    $stmt = $conn->prepare($finalQuery);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $packages = [];

    if ($stmt->rowCount() > 0) {
        $rows = $stmt->fetchAll();

        foreach ($rows as $row) {
            // ✅ Get Image (Last Image)
            $imgStmt = $conn->prepare("SELECT image FROM package_pictures WHERE package_id = :pid ORDER BY id DESC LIMIT 1");
            $imgStmt->execute([':pid' => $row['id']]);
            $imageRow = $imgStmt->fetch();

            // ✅ Price Calculation
            $adult_price = (float)$row['total_package_price_per_adult'] + (float)$row['price_up_per_adult'];
            $total_price = $adult_price;

            if ($ta_id) {
                $ta_stmt = $conn->prepare("SELECT selling_price FROM package_markup_travelagent WHERE travelagent_id = :ta_id AND package_id = :pid AND status = '1' LIMIT 1");
                $ta_stmt->execute([':ta_id' => $ta_id, ':pid' => $row['id']]);
                $ta_markup = $ta_stmt->fetch();
                if ($ta_markup && isset($ta_markup['selling_price'])) {
                    $total_price = ceil($ta_markup['selling_price']);
                }
            }

            $packages[] = [
                'id'           => $row['id'],
                'name'         => $row['name'],
                'description'  => $row['description'],
                'destination'  => $row['destination'],
                'location'     => $row['location'],
                'image'        => $imageRow['image'] ?? '',
                'price'        => ceil($total_price),
                'hotel_category' => $row['hotel_category'],
            ];
        }
    }

    echo json_encode([
        'status'   => 'success',
        'count'    => count($packages),
        'packages' => $packages
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
