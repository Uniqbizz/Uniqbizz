<?php

include(__DIR__ . '/../../connect.php');

header('Content-Type: application/json');

try {

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

    if ($start < 0) {
        $start = 0;
    }

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
    // ============================================================

    $where = [];

    $params = [];


    // ============================================================
    // STATUS FILTER
    // ============================================================

    if (
        $selectedStatus !== '' &&
        isset($statusMap[$selectedStatus])
    ) {

        $where[] = "rd.status = :status";

        $params[':status'] = $statusMap[$selectedStatus];
    }


    // ============================================================
    // DATE RANGE FILTER
    // ============================================================

    if ($startDate !== '') {

        $where[] = "DATE(rd.created_date) >= :start_date";

        $params[':start_date'] = $startDate;
    }


    if ($endDate !== '') {

        $where[] = "DATE(rd.created_date) <= :end_date";

        $params[':end_date'] = $endDate;
    }


    // ============================================================
    // DATATABLE SEARCH
    // ============================================================

    if ($searchValue !== '') {

        $where[] = "
            (
                rd.request_id LIKE :search
                OR rd.guestFullName LIKE :search
                OR rd.guestPhone LIKE :search
                OR rd.guestEmail LIKE :search
                OR rd.customer_pickup LIKE :search
                OR rd.customer_drop LIKE :search
                OR rd.pickup_point LIKE :search
                OR rd.drop_point LIKE :search
                OR rd.hotel_category LIKE :search
                OR rd.meal_preference LIKE :search
                OR rd.transport_preference LIKE :search
            )
        ";

        $params[':search'] = '%' . $searchValue . '%';
    }


    // ============================================================
    // WHERE SQL
    // ============================================================

    $whereSQL = '';

    if (!empty($where)) {

        $whereSQL = 'WHERE ' . implode(' AND ', $where);
    }


    // ============================================================
    // TOTAL RECORDS
    // ============================================================

    $totalQuery = "
        SELECT COUNT(*)
        FROM request_details
    ";

    $totalStmt = $conn->prepare($totalQuery);

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
    // FETCH DATA
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

            rd.base_price,
            rd.gst,
            rd.gst_percentage,
            rd.gross_price,
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
            p.name as pack_name

        FROM request_details rd
        INNER JOIN package p ON rd.package_id=p.id
        $whereSQL

        ORDER BY rd.created_date DESC

        LIMIT :start, :length
    ";


    $stmt = $conn->prepare($query);


    // ============================================================
    // BIND PARAMETERS
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
            $row['request_id'] ?? '',
            ENT_QUOTES,
            'UTF-8'
        );


        // ========================================================
        // CUSTOMER DETAILS
        // ========================================================

        $customerName = !empty($row['guestFullName'])
            ? htmlspecialchars(
                $row['guestFullName'],
                ENT_QUOTES,
                'UTF-8'
            )
            : 'N/A';


        $customerPhone = !empty($row['guestPhone'])
            ? htmlspecialchars(
                $row['guestPhone'],
                ENT_QUOTES,
                'UTF-8'
            )
            : 'N/A';


        $customerEmail = !empty($row['guestEmail'])
            ? htmlspecialchars(
                $row['guestEmail'],
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
        // DESTINATION
        // ========================================================
        //
        // request_details contains package_id but does not
        // contain a destination column.
        //
        // For now use customer_pickup / pickup_point.
        //
        // We can JOIN the package table later to show the actual
        // package destination such as "Varanasi".
        // ========================================================

        $destination = $row['pack_name'];


        $destination = htmlspecialchars(
            $destination,
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
                $row['no_of_nights_days'],
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
        // SUBMITTED ON
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
            <div
                class="enquiryEditBtn"
                data-request-id="' . $requestId . '"
            >
                Edit
            </div>
        ';
        $isGuestUser = (
            $row['userId'] === null ||
            trim((string)$row['userId']) === 'null'||
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


} catch (PDOException $e) {

    // ============================================================
    // DATABASE ERROR
    // ============================================================

    echo json_encode([

        'draw' => isset($_POST['draw'])
            ? (int)$_POST['draw']
            : 0,

        'recordsTotal' => 0,

        'recordsFiltered' => 0,

        'data' => [],

        'error' => $e->getMessage()

    ]);
}
?>