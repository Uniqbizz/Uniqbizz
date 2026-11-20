
<?php

include_once(__DIR__ . '/../../dashboard_user_details.php');

header('Content-Type: application/json; charset=utf-8');

try {

    // ============================================================
    // VALIDATE USER
    // ============================================================

    if (!isset($userId) || trim((string)$userId) === '') {
        throw new RuntimeException('User session not found.');
    }

    // ============================================================
    // DATATABLE PARAMETERS
    // ============================================================

    $draw = isset($_POST['draw'])
        ? (int)$_POST['draw']
        : 0;

    $start = isset($_POST['start'])
        ? (int)$_POST['start']
        : 0;

    $length = isset($_POST['length'])
        ? (int)$_POST['length']
        : 10;

    $searchValue = trim($_POST['search']['value'] ?? '');
    $selectedStatus = trim($_POST['status'] ?? '');
    $startDate = trim($_POST['start_date'] ?? '');
    $endDate = trim($_POST['end_date'] ?? '');

    // ============================================================
    // SAFETY
    // ============================================================

    $start = max(0, $start);

    if ($length < 1) {
        $length = 10;
    }

    // ============================================================
    // STATUS MAPPING
    // ============================================================

    $statusMap = [
        'New Enquiry'       => 1,
        'In Progress'       => 2,
        'Quotation Sent'    => 3,
        'Awaiting Response' => 4,
        'Closed'            => 5
    ];

    // ============================================================
    // WHERE CONDITIONS
    // IMPORTANT: USER FILTER IS ALWAYS APPLIED
    // ============================================================

    $where = [
        'rd.userId = :userId'
    ];

    $params = [
        ':userId' => $userId
    ];

    // ============================================================
    // STATUS FILTER
    // ============================================================

    if (
        $selectedStatus !== '' &&
        isset($statusMap[$selectedStatus])
    ) {

        $where[] = 'rd.status = :status';

        $params[':status'] = $statusMap[$selectedStatus];
    }

    // ============================================================
    // DATE RANGE FILTER
    // ============================================================

    if ($startDate !== '') {

        $where[] = 'DATE(rd.created_date) >= :start_date';

        $params[':start_date'] = $startDate;
    }

    if ($endDate !== '') {

        $where[] = 'DATE(rd.created_date) <= :end_date';

        $params[':end_date'] = $endDate;
    }

    // ============================================================
    // DATATABLE SEARCH
    // Use separate placeholders for every column
    // ============================================================

    if ($searchValue !== '') {

        $where[] = "
            (
                rd.request_id LIKE :search_request_id
                OR rd.guestFullName LIKE :search_name
                OR rd.guestPhone LIKE :search_phone
                OR rd.guestEmail LIKE :search_email
                OR rd.customer_pickup LIKE :search_customer_pickup
                OR rd.customer_drop LIKE :search_customer_drop
                OR rd.pickup_point LIKE :search_pickup_point
                OR rd.drop_point LIKE :search_drop_point
                OR rd.hotel_category LIKE :search_hotel
                OR rd.meal_preference LIKE :search_meal
                OR rd.transport_preference LIKE :search_transport
            )
        ";

        $searchParam = '%' . $searchValue . '%';

        $params[':search_request_id'] = $searchParam;
        $params[':search_name'] = $searchParam;
        $params[':search_phone'] = $searchParam;
        $params[':search_email'] = $searchParam;
        $params[':search_customer_pickup'] = $searchParam;
        $params[':search_customer_drop'] = $searchParam;
        $params[':search_pickup_point'] = $searchParam;
        $params[':search_drop_point'] = $searchParam;
        $params[':search_hotel'] = $searchParam;
        $params[':search_meal'] = $searchParam;
        $params[':search_transport'] = $searchParam;
    }

    // ============================================================
    // FINAL WHERE SQL
    // ============================================================

    $whereSQL = 'WHERE ' . implode(' AND ', $where);

    // ============================================================
    // TOTAL RECORDS
    // Counts all enquiries belonging to this user,
    // without applying status/date/search filters.
    // ============================================================

    $totalQuery = "
        SELECT COUNT(*)
        FROM request_details
        WHERE userId = :userId
    ";

    $totalStmt = $conn->prepare($totalQuery);

    $totalStmt->bindValue(
        ':userId',
        $userId,
        PDO::PARAM_STR
    );

    $totalStmt->execute();

    $recordsTotal = (int)$totalStmt->fetchColumn();

    // ============================================================
    // FILTERED RECORDS
    // ============================================================

    $filteredQuery = "
        SELECT COUNT(*)
        FROM request_details rd
        $whereSQL
    ";

    $filteredStmt = $conn->prepare($filteredQuery);

    foreach ($params as $key => $value) {

        $filteredStmt->bindValue($key, $value);
    }

    $filteredStmt->execute();

    $recordsFiltered = (int)$filteredStmt->fetchColumn();

    // ============================================================
    // FETCH ENQUIRY DATA
    // ============================================================

    $query = "
        SELECT

            rd.id,
            rd.request_id,
            rd.package_id,

            rd.adult_count,
            rd.child_count,
            rd.infant_count,

            rd.adult_price,
            rd.child_price,

            rd.adult_total,
            rd.children_total,

            rd.subtotal,

            rd.transport_type,
            rd.transport_amt,

            rd.travel_start_date,
            rd.travel_end_date,

            rd.no_of_nights_days,

            rd.pickup_point,
            rd.customer_pickup,

            rd.drop_point,
            rd.customer_drop,

            rd.room_count,
            rd.mattress_count,

            rd.hotel_category,
            rd.meal_preference,
            rd.transport_preference,

            rd.special_requirement,

            rd.coupons_applied_count,
            rd.coupon_discount,
            rd.coupons,

            rd.rooms,
            rd.gst,
            rd.gst_percentage,
            rd.convenience_fee,
            rd.final_price,

            rd.userId,

            rd.guestFullName,
            rd.guestPhone,
            rd.guestEmail,

            rd.created_date,
            rd.updated_on,

            rd.status,

            rd.discount_wallet_amount,
            rd.referral_wallet_amount,

            rd.old_hotel_category,
            rd.old_meal_preference,
            rd.old_transport_preference,

            p.name AS pack_name

        FROM request_details rd

        INNER JOIN package p
            ON rd.package_id = p.id

        $whereSQL

        ORDER BY rd.created_date DESC

        LIMIT :start, :length
    ";

    $stmt = $conn->prepare($query);

    // ============================================================
    // BIND FILTER PARAMETERS
    // ============================================================

    foreach ($params as $key => $value) {

        $stmt->bindValue($key, $value);
    }

    $stmt->bindValue(
        ':start',
        $start,
        PDO::PARAM_INT
    );

    $stmt->bindValue(
        ':length',
        $length,
        PDO::PARAM_INT
    );

    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ============================================================
    // PREPARE DATATABLE DATA
    // ============================================================

    $data = [];

    foreach ($rows as $row) {

        // ========================================================
        // ENQUIRY ID
        // ========================================================

        $requestId = htmlspecialchars(
            (string)($row['request_id'] ?? ''),
            ENT_QUOTES,
            'UTF-8'
        );

        // ========================================================
        // CUSTOMER DETAILS
        // ========================================================

        $customerName = !empty($row['guestFullName'])
            ? htmlspecialchars(
                (string)$row['guestFullName'],
                ENT_QUOTES,
                'UTF-8'
            )
            : 'N/A';

        $customerPhone = !empty($row['guestPhone'])
            ? htmlspecialchars(
                (string)$row['guestPhone'],
                ENT_QUOTES,
                'UTF-8'
            )
            : 'N/A';

        $customerEmail = !empty($row['guestEmail'])
            ? htmlspecialchars(
                (string)$row['guestEmail'],
                ENT_QUOTES,
                'UTF-8'
            )
            : 'N/A';

        $customerDetails = '
            <div>

                <p class="fontSize12 mb-1 fw-bold">
                    ' . $customerName . '
                </p>

                <p class="fontSize12 mb-1">
                    <i class="fa-solid fa-phone me-2"></i>
                    ' . $customerPhone . '
                </p>

                <p class="fontSize12 mb-1">
                    <i class="fa-regular fa-envelope me-2"></i>
                    ' . $customerEmail . '
                </p>

            </div>
        ';

        // ========================================================
        // DESTINATION / PACKAGE NAME
        // ========================================================

        $destination = htmlspecialchars(
            (string)($row['pack_name'] ?? 'N/A'),
            ENT_QUOTES,
            'UTF-8'
        );

        // ========================================================
        // TRAVEL START DATE
        // ========================================================

        $travelStart = 'N/A';

        if (!empty($row['travel_start_date'])) {

            $travelStart = date(
                'd M Y',
                strtotime($row['travel_start_date'])
            );
        }

        // ========================================================
        // TRAVEL END DATE
        // ========================================================

        $travelEnd = 'N/A';

        if (!empty($row['travel_end_date'])) {

            $travelEnd = date(
                'd M Y',
                strtotime($row['travel_end_date'])
            );
        }

        // ========================================================
        // NIGHTS / DAYS
        // ========================================================

        $nightsDays = !empty($row['no_of_nights_days'])
            ? htmlspecialchars(
                (string)$row['no_of_nights_days'],
                ENT_QUOTES,
                'UTF-8'
            )
            : '';

        // ========================================================
        // DESTINATION DETAILS HTML
        // ========================================================

        $destinationDetails = '
            <div>

                <p class="fontSize12 mb-1 fw-bold">
                    ' . $destination . '
                </p>

                <p class="fontSize12 mb-1">
                    <span>' . $travelStart . '</span>
                    -
                    <span>' . $travelEnd . '</span>
                </p>

                <p class="fontSize12 mb-1">
                    <span>' . $nightsDays . '</span>
                </p>

            </div>
        ';

        // ========================================================
        // SUBMITTED ON / UPDATED ON
        // ========================================================

        $submittedDate = 'N/A';
        $submittedTime = '';

        $updatedDate = 'N/A';
        $updatedTime = '';

        if (!empty($row['created_date'])) {

            $submittedDate = date(
                'd M Y',
                strtotime($row['created_date'])
            );

            $submittedTime = date(
                'h:i A',
                strtotime($row['created_date'])
            );
        }

        if (!empty($row['updated_on'])) {

            $updatedDate = date(
                'd M Y',
                strtotime($row['updated_on'])
            );

            $updatedTime = date(
                'h:i A',
                strtotime($row['updated_on'])
            );
        }

        $submittedOn = '
            <div>

                <p class="fontSize12 mb-1 fw-bold">
                    ' . $submittedDate . '
                </p>

                <p class="fontSize12 mb-1">
                    ' . $submittedTime . '
                </p>

            </div>
        ';

        $updatedOn = '
            <div>

                <p class="fontSize12 mb-1 fw-bold">
                    ' . $updatedDate . '
                </p>

                <p class="fontSize12 mb-1">
                    ' . $updatedTime . '
                </p>

            </div>
        ';

        // ========================================================
        // STATUS
        // ========================================================

        $statusValue = (int)$row['status'];

        $statusName = 'Unknown';
        $statusClass = '';

        switch ($statusValue) {

            case 1:

                $statusName = 'New Enquiry';
                $statusClass = 'enquiryStatusBtn1';

                break;

            case 2:

                $statusName = 'In Progress';
                $statusClass = 'enquiryStatusBtn2';

                break;

            case 3:

                $statusName = 'Quotation Sent';
                $statusClass = 'enquiryStatusBtn3';

                break;

            case 4:

                $statusName = 'Awaiting Response';
                $statusClass = 'enquiryStatusBtn4';

                break;

            case 5:

                $statusName = 'Closed';
                $statusClass = 'enquiryStatusBtn5';

                break;
        }

        $status = '
            <div class="enquiryStatusBtn ' . $statusClass . '">
                ' . $statusName . '
            </div>
        ';

        // ========================================================
        // ACTION
        // ========================================================

        $action = '
            <form action="enquiries.php" method="POST">

                <input
                    type="hidden"
                    name="request_id"
                    value="' . $requestId . '"
                >

                <button
                    type="submit"
                    class="enquiryEditBtn"
                    style="border: none; cursor: pointer;"
                >
                    Edit
                </button>

            </form>
        ';

        // ========================================================
        // GUEST USER LABEL
        // ========================================================

        $isGuestUser = (
            $row['userId'] === null ||
            trim((string)$row['userId']) === 'null' ||
            trim((string)$row['userId']) === ''
        );

        $guestUserText = $isGuestUser
            ? '<p class="fontSize12 mb-0 text-muted">Guest user</p>'
            : '';

        // ========================================================
        // FINAL DATATABLE ROW
        // ========================================================

        $data[] = [

            'enquiry_id' => '
                <p class="text-danger fontSize12 fw-bold mb-0">
                    ' . $requestId . '
                </p>
                ' . $guestUserText . '
            ',

            'customer_details' => $customerDetails,

            'destination_details' => $destinationDetails,

            'submitted_on' => $submittedOn,

            'updated_on' => $updatedOn,

            'status' => $status,

            'action' => $action

        ];
    }

    // ============================================================
    // DATATABLE RESPONSE
    // ============================================================

    echo json_encode([

        'draw' => $draw,

        'recordsTotal' => $recordsTotal,

        'recordsFiltered' => $recordsFiltered,

        'data' => $data

    ]);

} catch (Throwable $e) {

    error_log('Enquiries DataTable Error: ' . $e->getMessage());

    http_response_code(500);

    echo json_encode([

        'draw' => isset($_POST['draw'])
            ? (int)$_POST['draw']
            : 0,

        'recordsTotal' => 0,

        'recordsFiltered' => 0,

        'data' => [],

        'error' => 'Unable to load enquiries. Please try again.'

    ]);
}

?>