<?php

    // ==========================================
    // 1. FETCH MAIN REQUEST STATUS
    // ==========================================

    $mainStmt = $conn->prepare("
        SELECT status
        FROM request_details
        WHERE request_id = :request_id
        LIMIT 1
    ");

    $mainStmt->execute([
        ':request_id' => $request_id
    ]);

    $mainRequestStatus = $mainStmt->fetchColumn();


    // ==========================================
    // 2. FETCH ALL REPLY RECORDS
    // ==========================================

    $replyStmt = $conn->prepare("
        SELECT *
        FROM request_details_reply
        WHERE request_id = :request_id
        ORDER BY id DESC
    ");

    $replyStmt->execute([
        ':request_id' => $request_id
    ]);

    $replyRecords = $replyStmt->fetchAll(PDO::FETCH_ASSOC);


    // ==========================================
    // 3. DETERMINE WHETHER TO SHOW ORIGINAL
    //    EDITABLE SECTION
    // ==========================================

    $showOriginalEditable = (
        (int) $mainRequestStatus == 1
    );

?>
<?php foreach ($replyRecords as $index => $replyData): ?>

    <?php

        $accordionNumber = $index + 1;

        $collapseId = 'collapseReply' . $accordionNumber;
        $headingId  = 'headingReply' . $accordionNumber;

        // Individual reply editing permission
        $canEditReply = (
            isset($replyData['status']) &&
            (int) $replyData['status'] === 1
        );

    ?>
    <div class="accordion-item">

        <h2 class="accordion-header"
            id="<?= htmlspecialchars($headingId) ?>">

            <button class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#<?= htmlspecialchars($collapseId) ?>"
                    aria-expanded="false"
                    aria-controls="<?= htmlspecialchars($collapseId) ?>">

                <div class="accordion-heading-content">

                    <div class="accordion-heading-title">
                        <i class="fa-solid fa-user-pen"></i>
                        Quotation #<?= $accordionNumber ?>
                    </div>

                    <span class="history-status sent-status">
                        <i class="fa-solid fa-circle-check"></i>
                        Sent by Admin · <?= !empty($replyData['created'])
                                    ? date('d M Y, h:i A', strtotime($replyData['created']))
                                    : 'N/A'; ?>
                    </span>

                </div>

            </button>

        </h2>
        <div id="<?= $collapseId ?>"
            class="accordion-collapse collapse <?= !$canEditReply ? 'quotation-locked' : '' ?>"
            aria-labelledby="<?= $headingId ?>"
            data-bs-parent="#formHistoryAccordion">

            <div class="accordion-body">

                <?php if (!$canEditReply): ?>

                    <div class="alert alert-warning">
                        <i class="fa-solid fa-lock me-2"></i>
                        This quotation reply is locked.
                    </div>

                <?php endif; ?>

                <!-- YOUR EXISTING REPLY ACCORDION CONTENT -->
                <!-- Card Section 1 Start -->
                <div class="row rowAlignment">
                    <div class="col-12">
                        <div class="card cardShadow">
                            <div class="d-flex tabDisplayBlock">
                                <div class="p-2 imageWrapper">
                                    <img src="<?= '../../'.$galleryImages[0]['image'] ?>" alt="" class="prepareQuotationImg">
                                </div>
                                <div class="p-3 widthStretch">
                                    <div class="packageIDBtn">
                                        <?= $package['unique_code'] ?>
                                    </div>
                                    <p class="fw-bolder textDarkBlue mb-1 fs-4" id=""><?= $package['name'] ?></p>
                                    <p class="fw-bold textDarkBlue mb-1 fs-5" id="">
                                        <?= $package['description'] ?>
                                    </p>
                                    <div class="d-flex gap-4 redIcons laptopDisplay">
                                        <p class="fontSize12 mb-3">
                                            <i class="fa-solid fa-location-dot me-2"></i>
                                            <?= $package['destination'] ?>
                                        </p>
                                        <p class="fontSize12 mb-3">
                                            <i class="fa-regular fa-calendar me-2"></i>
                                            <?= $tour_nights ?> Nights / <?= $tour_days ?> Days
                                        </p>
                                        <p class="fontSize12 mb-3">
                                            <i class="fa-solid fa-utensils me-2"></i>
                                            Meals: <?= $meal_cat['name'] ?>
                                        </p>
                                    </div>
                                    <p class="fontSize12 mb-3">
                                        <?= $package['detailed_description'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card Section 1 End -->
                <div class="row">
                    <div class="col-xl-8">
                        <!-- Card Section 2 subsection 1 Start -->
                        <div class="card p-3">
                            <h5 class="fw-bold textDarkBlue">
                                <i class="fa-solid fa-clipboard-list fa-xl me-3"></i>
                                Enquiry Information
                            </h5>
                            <div class="row">
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-0">Enquiry ID :</p>
                                    <p class="fs-6 mb-0 fw-bold"><?= $request_id ?></p>
                                </div>
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-0">Received On :</p>
                                    <p class="fs-6 mb-0 fw-bold">
                                        <?= !empty($replyData['created'])
                                            ? date('d M Y, h:i A', strtotime($replyData['created']))
                                            : 'N/A'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 2 subsection 1 End -->
                        <!-- Card Section 2 subsection 2 Start -->
                        <div class="card p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="fw-bold textDarkBlue">
                                    <i class="fa-solid fa-user fa-xl me-3"></i>
                                    Customer Information
                                </h5>
                                <!-- <a class="editCustomerBtn">
                                    <i class="fa-solid fa-pen me-1"></i>
                                    Edit
                                </a> -->
                            </div>
                            <div class="row">
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Full Name :</p>
                                    <p class="fs-6 mb-2 fw-bold"><?= $replyData['guestFullname'] ?></p>
                                </div>
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Mobile :</p>
                                    <p class="fs-6 mb-2 fw-bold"><?= $replyData['gusetPhone'] ?></p>
                                </div>
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Email :</p>
                                    <p class="fs-6 mb-2 fw-bold"><?= $replyData['guestEmail'] ?></p>
                                </div>
                                <!-- <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Address :</p>
                                    <p class="fs-6 mb-2 fw-bold">Mumbai, Maharashtra</p>
                                </div> -->
                                <?php if($replyData['userId'] != 'null'){
                                ?>
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Customer Type :</p>
                                    <p class="fs-6 mb-2 fw-bold"><?= $Requester_type ?></p>
                                </div>
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Member Id :</p>
                                    <p class="fs-6 mb-2 fw-bold"><?= $replyData['userId'] ?></p>
                                </div>
                                <!-- <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Travel Consultant :</p>
                                    <p class="fs-6 mb-2 fw-bold">-</p>
                                </div> -->
                                <?php }else{ ?>
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Customer Type :</p>
                                    <p class="fs-6 mb-2 fw-bold"><?= $Requester_type ?></p>
                                </div>
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Member Id :</p>
                                    <p class="fs-6 mb-2 fw-bold">NA</p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Card Section 2 subsection 2 End -->
                        <div class="card p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="fw-bold textDarkBlue">
                                    <i class="fa-solid fa-calendar-days fa-xl me-3"></i>
                                    Trip Request <span class="fw-normal">(Submitted by Customer)</span>
                                </h5>
                            </div>
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Travel Start Date</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['travel_start_date'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Travel End Date</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['travel_end_date'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Nights / Days</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['no_of_nights_days'] ?>" readonly >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Pickup</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['customer_pickup'] != '' ? $replyData['customer_pickup']: $replyData['pickup_point'] ?>" readonly >
                                        <?php
                                            $oldPickup = !empty($replyData['customer_pickup'])
                                            ? $replyData['pickup_point']
                                            : '';
                                        ?>

                                        <?php if ($oldPickup !== ''): ?>
                                            <small class="old-value-text text-muted"
                                                id="">
                                                Previous Pickup: </br> 
                                                <?= htmlspecialchars($oldPickup, ENT_QUOTES, 'UTF-8') ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Drop</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['customer_drop'] != '' ? $replyData['customer_drop']: $replyData['drop_point'] ?>" readonly>
                                        <?php
                                            $olddrop = !empty($replyData['customer_drop'])
                                            ? $replyData['drop_point']
                                            : '';
                                        ?>

                                        <?php if ($olddrop !== ''): ?>
                                            <small class="old-value-text text-muted"
                                                id="">
                                                Previous Drop: </br> 
                                                <?= htmlspecialchars($olddrop, ENT_QUOTES, 'UTF-8') ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row paxRow">
                                <div class="col-xl-3 paxCol">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Adults (12+ yrs)</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['adult_count'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-xl-3 paxCol">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Children (2-11 yrs)</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['child_count'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-xl-3 paxCol">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Infants (0-1 yrs)</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['infant_count'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-xl-3 paxCol">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Total Pax</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['adult_count'] + $replyData['child_count'] + $requestData['infant_count'] ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 2 subsection 3 End -->
                        <!-- Card Section 2 subsection 4 Start -->
                        <div class="card p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="fw-bold textDarkBlue">
                                    <i class="fa-solid fa-bed fa-xl me-3"></i>
                                    Room Allocation <span class="fw-normal">(Requested by Customer)</span>
                                </h5>
                            </div>
                            
                            <?php
                                $rooms = json_decode($replyData['rooms'] ?? '[]', true);

                                if (!is_array($rooms)) {
                                    $rooms = [];
                                }

                                $totalRooms = count($rooms);

                                $adultCount  = (int)($replyData['adult_count'] ?? 0);
                                $childCount  = (int)($replyData['child_count'] ?? 0);
                                $infantCount = (int)($replyData['infant_count'] ?? 0);

                                $totalTravellers = $adultCount + $childCount + $infantCount;

                                $bedCounts = [];
                                $totalExtraMattresses = 0;
                                $recommendations = [];

                                foreach ($rooms as $room) {
                                    $description = trim($room['description'] ?? '');

                                    // Count extra mattresses separately.
                                    if (preg_match_all(
                                        '/(\d+)\s*Extra\s*Mattress(?:es)?/i',
                                        $description,
                                        $mattressMatches
                                    )) {
                                        foreach ($mattressMatches[1] as $quantity) {
                                            $totalExtraMattresses += (int)$quantity;
                                        }
                                    }

                                    // Remove the entire extra mattress phrase from the room description.
                                    $description = preg_replace(
                                        '/\s*\+?\s*\d+\s*Extra\s*Mattress(?:es)?/i',
                                        '',
                                        $description
                                    );

                                    // Clean up leftover separators and spaces.
                                    $description = trim($description, " \t\n\r\0\x0B,+-");

                                    // Process only bed types now.
                                    $bedItems = preg_split('/\s*\+\s*|\s*,\s*/', $description);

                                    foreach ($bedItems as $item) {

                                        $item = trim($item);

                                        if ($item === '') {
                                            continue;
                                        }

                                        $quantity = 1;

                                        if (preg_match('/^(\d+)\s+(.+)$/i', $item, $matches)) {
                                            $quantity = (int)$matches[1];
                                            $item = trim($matches[2]);
                                        }

                                        // Safety check: never allow a mattress into the bed summary.
                                        if (stripos($item, 'mattress') !== false) {
                                            continue;
                                        }

                                        if ($quantity <= 0 || $item === '') {
                                            continue;
                                        }

                                        $item = preg_replace('/\bBeds\b/i', 'Bed', $item);
                                        $key = strtolower(trim($item));

                                        if (!isset($bedCounts[$key])) {
                                            $bedCounts[$key] = [
                                                'name' => trim($item),
                                                'count' => 0
                                            ];
                                        }

                                        $bedCounts[$key]['count'] += $quantity;
                                    }

                                    // Keep recommendations unique.
                                    $recommendation = trim($room['recommendation'] ?? '');

                                    if (
                                        $recommendation !== '' &&
                                        !in_array($recommendation, $recommendations, true)
                                    ) {
                                        $recommendations[] = $recommendation;
                                    }
                                }

                                /*
                                * 5. Build the combined room type summary.
                                */
                                $roomTypeSummary = [];

                                foreach ($bedCounts as $bed) {

                                    $count = $bed['count'];
                                    $name = $bed['name'];

                                    if (preg_match('/\bBed\b/i', $name)) {
                                        $name = preg_replace(
                                            '/\bBed\b/i',
                                            $count === 1 ? 'Bed' : 'Beds',
                                            $name
                                        );
                                    }

                                    $roomTypeSummary[] = $count . ' ' . $name;
                                }

                                $roomTypeText = implode(', ', $roomTypeSummary);
                            ?>

                            <div class="row">
                                <div class="col-xl-12">

                                    <table class="table table-bordered mb-0 fs-6">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col">Room Count</th>
                                                <th scope="col">Travellers</th>
                                                <th scope="col">Room Type</th>
                                                <th scope="col">Extra Mattress</th>
                                            </tr>
                                        </thead>

                                        <tbody id="" class="fs-6">
                                            <?php if (!empty($rooms)): ?>
                                                <tr>
                                                    <td>
                                                        <?= $totalRooms ?>
                                                        <?= $totalRooms === 1 ? 'Room' : 'Rooms' ?>
                                                    </td>

                                                    <td>
                                                        <?= $totalTravellers ?>
                                                        (<?= $adultCount ?> Adults +
                                                        <?= $childCount ?> Children +
                                                        <?= $infantCount ?> Infants)
                                                    </td>

                                                    <td>
                                                        <?= htmlspecialchars(
                                                            $roomTypeText !== '' ? $roomTypeText : 'N/A',
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ) ?>
                                                    </td>

                                                    <td>
                                                        <?php if ($totalExtraMattresses > 0): ?>
                                                            <?= $totalExtraMattresses ?>
                                                            <?= $totalExtraMattresses === 1
                                                                ? 'Extra Mattress'
                                                                : 'Extra Mattresses' ?>
                                                        <?php else: ?>
                                                            N/A
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        No room details available.
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>

                                    <?php if (!empty($rooms)): ?>
                                        <div class="paxDescriptionBtn d-flex">
                                            <i class="fa-solid fa-circle-user paxColor fa-lg align-content-center me-2"></i>

                                            <span>
                                                <?= $totalTravellers ?>
                                                <?= $totalTravellers === 1 ? 'traveller' : 'travellers' ?>
                                                will be accommodated in
                                                <?= $totalRooms ?>
                                                <?= $totalRooms === 1 ? 'room' : 'rooms' ?>.

                                                <?php if (!empty($recommendations)): ?>
                                                    <br>
                                                    <?= htmlspecialchars(
                                                        implode(', ', $recommendations),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>



                        </div>
                        <!-- Card Section 2 subsection 4 End -->
                        <!-- Card Section 2 subsection 5 Start -->
                        <div class="card p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="fw-bold textDarkBlue">
                                    <i class="fa-solid fa-calendar-days fa-xl me-3"></i>
                                    Customer Preferences <span class="fw-normal">(Submitted by Customer)</span>
                                </h5>
                                
                            </div>
                            <div class="row">
                                <!-- HOTEL CATEGORY -->
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label fontSize10">
                                            Hotel Category
                                        </label>
                                        <div class="icon-select-wrapper">
                                            <i class="ri-hotel-line iconPosition iconRed"></i>
                                            <?php
                                            $sql = $conn->prepare("
                                                SELECT id, name
                                                FROM category_hotel
                                                WHERE status = 1
                                                ORDER BY id DESC
                                            ");
                                            $sql->execute();
                                            $hotelCategories = $sql->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <select id="" class="form-select fontSize10 paddingLeft" name="hotel_category" disabled>
                                                <option value="">Select Hotel</option>

                                                <?php foreach ($hotelCategories as $hotel): ?>
                                                    <option
                                                        value="<?= htmlspecialchars($hotel['id'], ENT_QUOTES, 'UTF-8') ?>"
                                                        <?= ((string)$hotel['id'] === (string)($replyData['hotel_category'] ?? '')) ? 'selected' : '' ?>
                                                    >
                                                        <?= htmlspecialchars($hotel['name'], ENT_QUOTES, 'UTF-8') ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <!-- OLD VALUE -->
                                        <div id="" class="text-muted fontSize10 d-none mt-2"></div>
                                    </div>
                                </div>
                                <!-- MEAL PREFERENCE -->
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label fontSize10">
                                            Meal Preference
                                        </label>
                                        <div class="icon-select-wrapper">
                                            <i class="ri-restaurant-line iconPosition iconRed"></i>
                                            <?php
                                            $sql = $conn->prepare("
                                                SELECT id, name
                                                FROM category_meal
                                                WHERE status = 1
                                                ORDER BY id DESC
                                            ");
                                            $sql->execute();
                                            $mealCategories = $sql->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <select id="" class="form-select fontSize10 paddingLeft" name="meal_preference" disabled>
                                                <option value="">Select Meal</option>
                                                <?php foreach ($mealCategories as $meal_cat): ?>
                                                    <option value="<?= htmlspecialchars($meal_cat['id']) ?>" 
                                                    <?= ($replyData['meal_preference'] == $meal_cat['id']) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($meal_cat['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <!-- OLD VALUE -->
                                        <div id="" class="text-muted fontSize10 d-none mt-2"></div>
                                    </div>
                                </div>
                                <!-- TRANSPORT -->
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label fontSize10">
                                            Transport Preference
                                        </label>
                                        <div class="icon-select-wrapper">
                                            <i class="ri-car-line iconPosition iconRed"></i>
                                            <?php
                                            $sql = $conn->prepare("
                                                SELECT id, name
                                                FROM category_vehicle
                                                WHERE status = 1
                                                ORDER BY id DESC
                                            ");
                                            $sql->execute();
                                            $vehicleCategories = $sql->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <select id="" class="form-select fontSize10 paddingLeft" name="transport_preference" disabled>
                                                <option value="">Select Vehicle</option>
                                                <?php foreach ($vehicleCategories as $vehicle_cat): ?>
                                                    <option value="<?= htmlspecialchars($vehicle_cat['id']) ?>" 
                                                    <?= ($replyData['transport_preference'] == $vehicle_cat['id']) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($vehicle_cat['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <!-- OLD VALUE -->
                                        <div id="" class="text-muted fontSize10 d-none mt-2"></div>
                                    </div>
                                </div>
                                <!-- SPECIAL REQUIREMENT -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="mb-0">
                                        <label for="" class="form-label fontSize10">Special Requirements (Optional)</label>
                                        <textarea
                                            class="form-control fontSize10"
                                            id=""
                                            name="special_requirement"
                                            placeholder="Eg. Wheelchair, extra bed, high floor, adjoining rooms, etc."
                                            style="text-align: left;"
                                            readonly
                                        ><?= htmlspecialchars(trim($replyData['special_requirement'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 2 subsection 5 End -->
                        
                    </div>
                    <div class="col-xl-4">
                        <div class="card cardShadow">
                            <div class="quick-header p-3">
                                <div class="d-flex gap-2">
                                    <i class="fa-solid fa-location-dot fa-xl align-content-center quickIcon"></i>
                                    <h5 class="fw-bold mb-0 textDarkBlue align-content-center">Quick Action</h5>
                                </div>
                                <!-- <button type="button" class="recalculate-btn" id="#">
                                    <i class="fa-solid fa-rotate-right"></i>
                                    Recalculate
                                </button> -->
                            </div>
                            <div class="px-3">
                                <p class="mb-2 fw-bold blueDiv">Base Price (Per Person)</p>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="mb-1">Adult (12+ yrs)</p>
                                        <p class="mb-1">Child (2-11 yrs)</p>
                                        <p class="mb-1">Infant (0-1 yrs)</p>
                                    </div>
                                    <div>
                                        <p class="mb-1 text-end">&#8377; <?= number_format($replyData['adult_price'], 2) ?></p>
                                        <p class="mb-1 text-end">&#8377; <?= number_format($replyData['child_price'], 2) ?></p>
                                        <p class="mb-1 text-end">FREE</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 pb-0">
                                <p class="mb-2 fw-bold blueDiv">Price Based on Travelers</p>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="mb-1">Adult: <span class="" id=""><?= $replyData['adult_count'] ?></span> x &#8377; <?= number_format($adultDisplayPrice, 2) ?></p>
                                        <p class="mb-1">Children: <span class="" id=""><?= $replyData['child_count'] ?></span> x &#8377; <?= number_format($childDisplayPrice, 2) ?></p>
                                        <p class="mb-1">Infant: <span class="" id=""><?= $replyData['infant_count'] ?></span> x FREE</p>
                                        <p class="mb-1">Extra Mattress (1 x &#8377; <?= $pricing['extra_mattress'] ?>)</p>
                                    </div>
                                    <div>
                                        <p class="mb-1 text-end" id="">&#8377; <?= number_format($replyData['adult_total'], 2) ?></p>
                                        <p class="mb-1 text-end" id="">&#8377; <?= number_format($replyData['children_total'], 2) ?></p>
                                        <p class="mb-1 text-end">&#8377; 0.00</p>
                                        <p class="mb-1 text-end" id="#">&#8377; <?= $totalExtraMattresses * $pricing['extra_mattress'] ?></p>
                                        
                                    </div>
                                </div>
                                <hr class="my-1 border border-2 mx-0">
                                <div class="d-flex justify-content-between">
                                    <p class="fw-bold fs-5 textDarkBlue mb-0">Subtotal</p>
                                    <p class="fontSize13 fs-5 fw-bold textDarkBlue mb-0" id="">&#8377; <?= number_format($replyData['subtotal'], 2) ?></p>
                                </div>
                            </div>
                            
                            <hr class="my-1 border border-2 mx-3">
                            <div class="p-3">
                                <p class="fw-bold">Transport</p>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fontSize10" id=""><?= $replyData['transport_type'] ?></p>
                                        <a href="#" class="fontSize10 text-primary" id="">Change Vehicle</a>
                                    </div>
                                    <div>
                                        <!-- <p class="fontSize10 text-end">Included</p> -->
                                    </div>
                                </div>
                            </div>
                            <hr class="my-1 border border-2 mx-3">
                            <?php
                            $savedCoupons = json_decode($replyData['coupons'] ?? '[]', true) ?: [];

                            $totalCouponDiscount = 0;
                            ?>

                            <div class="p-3 pb-0">

                                <p class="fw-bold mb-2 textDarkBlue blueDiv">
                                    Applied Coupons
                                    <span class="text-muted fw-normal fontSize12">
                                        
                                        <i class="ri-error-warning-line"></i>
                                    </span>
                                </p>

                                <div class="coupon-passenger-container">

                                    <?php if (!empty($savedCoupons)): ?>

                                        <?php foreach ($savedCoupons as $coupon): ?>

                                            <?php
                                            $couponCode = trim($coupon['code'] ?? '');
                                            $passenger = $coupon['passenger'] ?? '';
                                            $amount = (float) ($coupon['amount'] ?? 0);

                                            if ($couponCode === '') {
                                                continue;
                                            }

                                            $totalCouponDiscount += $amount;
                                            ?>

                                            <div class="d-flex justify-content-between mb-2 saved-coupon-row">

                                                <div class="d-flex gap-3 largeDisplay">

                                                    <p class="fontSize10 align-content-end mb-0">
                                                        <?= htmlspecialchars($passenger) ?>
                                                    </p>

                                                    <p class="mb-0">
                                                        <select class="form-select fontSize10 selectPadding" disabled>
                                                            <option value="<?= htmlspecialchars($couponCode) ?>" selected>
                                                                <?= htmlspecialchars($couponCode) ?>
                                                            </option>
                                                        </select>
                                                    </p>

                                                </div>

                                                <p class="fontSize10 discountGreen fw-bold text-end align-content-end mb-0">
                                                    - ₹ <?= number_format($amount, 0, '.', ',') ?>
                                                </p>

                                            </div>

                                        <?php endforeach; ?>

                                    <?php else: ?>

                                        <p class="fontSize10 text-muted mb-2">
                                            No coupons applied.
                                        </p>

                                    <?php endif; ?>

                                </div>

                            </div>

                            <hr class="my-1 border border-2 mx-3">

                            <div class="d-flex justify-content-between px-3">

                                <p class="fontSize10 discountGreen fw-bold">
                                    Discounts (Coupons)
                                </p>

                                <p class="fontSize10 discountGreen fw-bold text-end">
                                    - ₹ <?= number_format($totalCouponDiscount, 0, '.', ',') ?>
                                </p>

                            </div>
                            <?php
                            $referralWalletBalance = $referralBalance ?? 0;
                            $discountWalletBalance = $discountBalance ?? 0;
                            ?>

                            <!-- <hr class="my-1 border border-2 mx-3"> -->

                            <div class="d-flex justify-content-between align-items-center px-3">

                                <p class="fontSize10 discountGreen fw-bold mb-0">
                                    Referral Wallet
                                </p>

                                <p class="fontSize10 discountGreen fw-bold text-end mb-0"
                                id="">
                                    ₹ <?= number_format($referralWalletBalance, 2) ?>
                                </p>

                                <div class="d-flex align-items-center">
                                    <span class="fontSize10 discountGreen fw-bold me-1">
                                        - ₹
                                    </span>
                                    <input type="number" class="form-control form-control-sm walletInput" id="" value="<?= $requestData['referral_wallet_amount'] ?>" min="0" step="1" disabled style="width: 80px;">
                                </div>
                            </div>
                            <?php if ($Requester_type == 'Neo Select'){
                            ?>
                            <hr class="my-1 border border-2 mx-3">
                            <div class="d-flex justify-content-between align-items-center px-3">
                                <p class="fontSize10 discountGreen fw-bold mb-0">
                                    Discount Wallet
                                </p>
                                <p class="fontSize10 discountGreen fw-bold text-end mb-0"
                                id="">
                                    ₹ <?= number_format($discountWalletBalance, 2) ?>
                                </p>
                                <div class="d-flex align-items-center">
                                    <span class="fontSize10 discountGreen fw-bold me-1">
                                        - ₹
                                    </span>
                                    <input type="number" class="form-control form-control-sm walletInput" id="" value="0" min="0" step="1" disabled style="width: 80px;">
                                </div>
                            </div>
                            <?php } ?>
                            
                            <hr class="my-2 border border-2 mx-3">
                            <div class="p-3">
                                <p class="fw-bold blueDiv">Adjustments</p>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        
                                        <p class="mb-1">Convenience Fee </p>
                                        <p class="mb-1">GST (<?= $replyData['gst_percentage'] ?>%) </p>
                                    </div>
                                    <div>
                                        
                                        <p class="mb-1 text-end" id="#">&#8377; <?= $replyData['convenience_fee'] ?></p>
                                        <p class="mb-1 text-end">&#8377; <?= $replyData['gst'] ?></p>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-1 border border-2 mx-3">
                            <div class="p-3 pb-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fs-5 textDarkBlue fw-bold">Total Estimated Price</p>
                                    </div>
                                    <div>
                                        <p class="fs-5 text-danger fw-bolder text-end" id="">&#8377; <?= number_format($replyData['final_price'], 2) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card Section 2 subsection 6 Start -->
                <div class="card p-3">
                    <h5 class="fw-bold textDarkBlue">
                        <i class="fa-solid fa-file-lines fa-xl me-3"></i>
                        Package Information <span class="fw-normal">(From Package Master)</span>
                    </h5>
                    <div class="row paxRow mt-1 mb-2">
                        <div class="col-xl-2 paxCol">
                            <p class="fs-6 mb-1">Package ID</p>
                            <p class="fs-6 fw-bold mb-2"><?= $package['unique_code'] ?></p>
                        </div>
                        <div class="col-xl-10">
                            <div class="row paxRow">
                                <div class="col-xl-4 paxCol">
                                    <p class="fs-6 mb-1">Destination</p>
                                    <p class="fs-6 fw-bold mb-2"><?= $package['name'] ?></p>
                                </div>
                                <div class="col-xl-4 paxCol">
                                    <p class="fs-6 mb-1">Duration</p>
                                    <p class="fs-6 fw-bold mb-2"><?= $tour_nights ?> Nights / <?= $tour_days ?> Days</p>
                                </div>
                                <div class="col-xl-4">
                                    <p class="fs-6 mb-1">Package Type</p>
                                    <p class="fs-6 fw-bold mb-2"><?= $package['category_id'] == 2 ? 'Domestic':($package['category_id'] == 1 ?'International':'NA') ?></p>
                                </div>
                                <div class="col-xl-6 paxCol">
                                    <p class="fs-6 mb-1">Pacakge Category</p>
                                    <p class="fs-6 fw-bold mb-2"><?= $package['package_type'] ?></p>
                                </div>
                                <div class="col-xl-6 paxCol">
                                    <p class="fs-6 mb-1">Valid Travel Period</p>
                                    <p class="fs-6 fw-bold mb-2">
                                        Valid Till <?= date('d-m-Y', strtotime($package['validity'])) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-placeholder"></div>
                    <div class="sticky-nav-wrapper">
                        <div class="borderColor1 cardShadow p-2">
                            <ul class="nav nav-underline justify-content-between">
                                <li class="nav-item navItem">
                                    <a class="nav-link pt-0 active" aria-current="page" href="#overview1">
                                        <div class="text-center">
                                            <i class="ri-dashboard-line"></i>
                                        </div>
                                        Overview
                                    </a>
                                </li>
                                <li class="nav-item navItem">
                                    <a class="nav-link pt-0" href="#itinerary1">
                                        <div class="text-center">
                                            <i class="ri-route-line"></i>
                                        </div>
                                        Itinerary
                                    </a>
                                </li>
                                <li class="nav-item navItem">
                                    <a class="nav-link pt-0" href="#inclusion1">
                                        <div class="text-center">
                                            <i class="ri-dashboard-line"></i>
                                        </div>
                                        Inclusions
                                    </a>
                                </li>
                                <li class="nav-item navItem">
                                    <a class="nav-link pt-0" href="#inclusion1">
                                        <div class="text-center">
                                            <i class="ri-dashboard-line"></i>
                                        </div>
                                        Exclusions
                                    </a>
                                </li>
                                <li class="nav-item navItem">
                                    <a class="nav-link pt-0" href="#policies1">
                                        <div class="text-center">
                                            <i class="ri-dashboard-line"></i>
                                        </div>
                                        Policies
                                    </a>
                                </li>
                                <li class="nav-item navItem">
                                    <a class="nav-link pt-0" href="#faqs1">
                                        <div class="text-center">
                                            <i class="ri-question-answer-line"></i>
                                        </div>
                                        Cancellation Policy
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="content-sections">
                        <div id="overview1" class="section-block">
                            <div class="card cardBackgroundColor rounded-3 p-3 cardShadow">
                                <h5 class="fw-bolder textDarkBlue">Overview</h5>
                                <div class="d-flex gap-3">
                                    <div class="overviewImageWrapper">
                                        <img src="<?= '../../'.$galleryImages[0]['image'] ?>" alt="" class="overviewImg">
                                    </div>
                                    <div class="fontSize1">
                                        <p class="fw-normal fontSize12"><?= $package['detailed_description'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="itinerary1" class="section-block">
                            <div class="card cardBackgroundColor rounded-3 p-3 pb-4 cardShadow">
                                <h5 class="fw-bolder textDarkBlue">Itinerary</h5>

                                <div class="tour-details-content">

                                    <div class="destination-accordion mt-2">

                                        <div class="accordion" id="accordionItinerary<?= (int)$accordionNumber ?>">

                                            <?php
                                            $count = 1;

                                            // Fetch saved itinerary days for this request and package
                                            $data4 = $conn->prepare("
                                                SELECT *
                                                FROM request_details_trip_days
                                                WHERE request_id = :request_id
                                                ORDER BY id ASC
                                            ");

                                            $data4->execute([
                                                ':request_id' => $request_id
                                            ]);

                                            $days = $data4->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($days as $key_3 => $day):

                                                $description = $day['day_details'] ?? '';
                                                $mealPlan = $day['meal_plan'] ?? '';
                                                $dayTransport = $day['day_tansport'] ?? '';
                                                $stay = $day['stay'] ?? '';

                                                $headingId = 'itinerary-heading-' . $accordionNumber . '-' . $count;
                                                $collapseId = 'itinerary-collapse-' . $accordionNumber . '-' . $count;
                                            ?>

                                                <div class="timeline-number">
                                                    <?= str_pad($count, 2, '0', STR_PAD_LEFT) ?>
                                                </div>

                                                <div class="accordion-item">

                                                    <h2 class="accordion-header"
                                                        id="<?= $headingId ?>">

                                                        <button
                                                            class="accordion-button <?= ($count != 1) ? 'collapsed' : '' ?>"
                                                            type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#<?= $collapseId ?>"
                                                            aria-expanded="<?= ($count == 1) ? 'true' : 'false' ?>"
                                                            aria-controls="<?= $collapseId ?>">

                                                            Day <?= $key_3 + 1 ?> -
                                                            <?= htmlspecialchars($day['title'] ?? '') ?>

                                                        </button>

                                                    </h2>

                                                    <div
                                                        id="<?= $collapseId ?>"
                                                        class="accordion-collapse collapse <?= ($count == 1) ? 'show' : '' ?>"
                                                        aria-labelledby="<?= $headingId ?>"
                                                        data-bs-parent="#accordionItinerary<?= (int)$accordionNumber ?>">

                                                        <div class="accordion-body">

                                                            <!-- DAY DESCRIPTION -->
                                                            <ul class="listing">
                                                                <li class="list">
                                                                    <?= nl2br(htmlspecialchars($description)) ?>
                                                                </li>
                                                            </ul>

                                                            <hr class="my-3"
                                                                style="border-top:1px solid #4b5051;">

                                                            <!-- MEAL / TRANSPORT / STAY -->
                                                            <div class="d-flex justify-content-evenly displayMeal">

                                                                <div class="gap-1 d-flex">
                                                                    <h6 class="fw-bold align-content-center">
                                                                        Meal:&nbsp;
                                                                    </h6>
                                                                    <p class="text-muted fontSize3 align-content-center">
                                                                        <?= htmlspecialchars($mealPlan ?: 'N/A') ?>
                                                                    </p>
                                                                </div>

                                                                <div class="gap-1 d-flex">
                                                                    <h6 class="fw-bold align-content-center">
                                                                        Transport:&nbsp;
                                                                    </h6>
                                                                    <p class="text-muted fontSize3 align-content-center">
                                                                        <?= htmlspecialchars($dayTransport ?: 'N/A') ?>
                                                                    </p>
                                                                </div>

                                                                <div class="gap-1 d-flex">
                                                                    <h6 class="fw-bold align-content-center">
                                                                        Stay:&nbsp;
                                                                    </h6>
                                                                    <p class="text-muted fontSize3 align-content-center">
                                                                        <?= htmlspecialchars($stay ?: 'N/A') ?>
                                                                    </p>
                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            <?php
                                                $count++;
                                            endforeach;
                                            ?>

                                            <?php if (empty($days)): ?>
                                                <p class="text-muted fontSize10">
                                                    No itinerary details available.
                                                </p>
                                            <?php endif; ?>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <div id="inclusion1" class="section-block">
                            <div class="card cardBackgroundColor rounded-3 p-3 cardShadow">
                                <h5 class="fw-bolder textDarkBlue">Inclusion & Exclusion</h5>
                                
                                <div class="row">
                                    <?php

                                        // Fetch inclusion and exclusion from request_details_itinerary
                                        $itineraryStmt = $conn->prepare("
                                            SELECT inclusion, exclusion
                                            FROM request_details_itinerary
                                            WHERE request_id = :request_id
                                            LIMIT 1
                                        ");

                                        $itineraryStmt->execute([
                                            ':request_id' => $request_id
                                        ]);

                                        $itinery = $itineraryStmt->fetch(PDO::FETCH_ASSOC) ?: [];

                                        // Decode JSON data
                                        $inclusions = safeJsonDecode($itinery['inclusion'] ?? '');
                                        $exclusions = safeJsonDecode($itinery['exclusion'] ?? '');

                                    ?>

                                    <div class="card cardBackgroundColor rounded-3 p-3 cardShadow">
                                        <h5 class="fw-bolder">Inclusion & Exclusion</h5>

                                        <div class="row">

                                            <!-- Inclusions -->
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <?php if (!empty($inclusions)): ?>
                                                    <?php foreach ($inclusions as $inclusion): ?>
                                                        <div class="d-flex gap-3 mt-2">
                                                            <div class="checkIcon">
                                                                <i class="ri-checkbox-circle-fill text-success"></i>
                                                            </div>
                                                            <p class="text-muted fontSize3 align-content-center mb-0">
                                                                <?= htmlspecialchars($inclusion) ?>
                                                            </p>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <p class="text-muted mt-2 mb-0">No inclusions available.</p>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Exclusions -->
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <?php if (!empty($exclusions)): ?>
                                                    <?php foreach ($exclusions as $exclusion): ?>
                                                        <div class="d-flex gap-3 mt-2">
                                                            <div class="closeIcon">
                                                                <i class="ri-close-circle-fill text-danger"></i>
                                                            </div>
                                                            <p class="text-muted fontSize3 align-content-center mb-0">
                                                                <?= htmlspecialchars($exclusion) ?>
                                                            </p>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <p class="text-muted mt-2 mb-0">No exclusions available.</p>
                                                <?php endif; ?>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="policies1" class="section-block">
                            <div class="card cardBackgroundColor rounded-3 p-3 cardShadow">

                                <h5 class="fw-bolder mb-3 textDarkBlue">Policies</h5>

                                <!-- <p class="text-muted fontSize3 mb-3">
                                    Upload brochures, itinerary PDFs or any other important documents for reference.
                                </p> -->

                                <div id="">
                                    <?php
                                        $newPolicyStmt = $conn->prepare("
                                            SELECT *
                                            FROM request_details_policy_document
                                            WHERE request_id = :request_id
                                            ORDER BY id ASC
                                        ");

                                        $newPolicyStmt->execute([
                                            ':request_id' => $request_id
                                        ]);

                                        $newPolicies = $newPolicyStmt->fetchAll(PDO::FETCH_ASSOC);

                                        // Merge existing and newly added policies
                                        $allPolicies = array_merge(
                                            $policies ?? [],
                                            $newPolicies ?? []
                                        );
                                        $hasPolicies = false;

                                        foreach ($allPolicies as $doc):

                                            if (strcasecmp(trim($doc['title'] ?? ''), 'FAQ') === 0) {
                                                continue;
                                            }

                                            $hasPolicies = true;
                                    ?>

                                        <div class="policyItem"
                                            data-id="<?= (int)$doc['id'] ?>"
                                            data-existing="1">

                                            <div class="d-flex align-items-center gap-3">

                                                <div class="highlightIcon" style="background-color: #b2e0b1;">
                                                    <i class="ri-file-pdf-line text-success"></i>
                                                </div>

                                                <div>
                                                    <p class="mb-0 fw-semibold">
                                                        <?= htmlspecialchars($doc['title'] ?? '') ?>
                                                    </p>

                                                    <small class="text-muted">
                                                        <?= htmlspecialchars($doc['file_name'] ?? '') ?>
                                                    </small>
                                                </div>

                                            </div>

                                            <div class="d-flex align-items-center gap-2">

                                                <a
                                                    href="../../uploading/package_policy_attachments/<?= rawurlencode($doc['file_name']) ?>"
                                                    download
                                                    class="downloadBtn"
                                                    title="Download document">
                                                    <i class="ri-download-line"></i>
                                                </a>

                                                <button
                                                    type="button"
                                                    class="btn btn-link text-danger p-1 remove-file"
                                                    data-id="<?= (int)$doc['id'] ?>"
                                                    title="Remove document">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>

                                            </div>
                                        </div>

                                    <?php endforeach; ?>

                                    <?php if (!$hasPolicies): ?>
                                        <p class="text-muted mb-0" id="noOtherPolicy">
                                            No other policy documents available.
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <hr class="my-3">

                                <!-- Upload Area -->
                                <!-- <div class="upload-form-row">

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="documentTitle"
                                        placeholder="Enter Title">

                                    <div class="mini-drop-zone" id="dropZone">
                                        <i class="fa-solid fa-cloud-arrow-up me-2"></i>

                                        <span id="selectedFileText">
                                            Drag &amp; Drop or Click to Upload
                                        </span>

                                        <input
                                            type="file"
                                            id="fileInput"
                                            class="hidden-input"
                                            accept=".pdf,.doc,.docx">
                                    </div>

                                    <button
                                        type="button"
                                        class="btn btn-primary px-4"
                                        id="addDocumentBtn">
                                        Submit
                                    </button>

                                </div> -->

                                <small class="error-message" id="otherPolicy_error"></small>

                            </div>
                        </div>
                        <div id="faqs1" class="section-block">
                            <div class="card cardBackgroundColor rounded-3 p-3 cardShadow mb-0">
                                <h5 class="fw-bolder textDarkBlue">Cancellation Policy</h5>
                                <div class="row borderHighlight mx-0">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-3">
                                        <div class="text-center mb-2">
                                            <label for="mrpPerAdult" class="mb-0">Cancellation Before Travel</label>
                                        </div>
                                        <div class="inputFieldAlignment">
                                            <input type="number" value="" id="mrpPerAdult" placeholder="30+ Days" class="form-control inputWidth" readOnly>
                                            <input type="number" value="" id="mrpPerAdult" placeholder="15 - 30 Days" class="form-control inputWidth" readOnly>
                                            <input type="number" value="" id="mrpPerAdult" placeholder="7 - 15 Days" class="form-control inputWidth" readOnly>
                                            <input type="number" value="" id="mrpPerAdult" placeholder="0 - 7 Days" class="form-control inputWidth" readOnly>
                                            <input type="number" value="" id="mrpPerAdult" placeholder="No Show" class="form-control inputWidth" readOnly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-3">
                                        <div class="text-center mb-2">
                                            <label for="mrpPerChild" class="mb-0">Cancellation Charges</label>
                                        </div>
                                        <div class="inputFieldAlignment">
                                            <div class="input-group inputWidth">
                                                <input type="number" class="form-control" id="" name="cancellationPercentage1" placeholder="0" value="<?= $cancel_policy['policy_1']??0 ?>">
                                                <span class="input-group-text">%</span>
                                                <small class="error-message" id="cancellationPercentage1_error"></small>
                                            </div>
                                            <div class="input-group inputWidth">
                                                <input type="number" class="form-control" id="" name="cancellationPercentage2" placeholder="0" value="<?= $cancel_policy['policy_2']??0 ?>">
                                                <span class="input-group-text">%</span>
                                                <small class="error-message" id="cancellationPercentage2_error"></small>
                                            </div>
                                            <div class="input-group inputWidth">
                                                <input type="number" class="form-control" id="" name="cancellationPercentage3" placeholder="0" value="<?= $cancel_policy['policy_3']??0 ?>">
                                                <span class="input-group-text">%</span>
                                                <small class="error-message" id="cancellationPercentage3_error"></small>
                                            </div>
                                            <div class="input-group inputWidth">
                                                <input type="number" class="form-control" id="" name="cancellationPercentage4" placeholder="0" value="<?= $cancel_policy['policy_4']??0 ?>">
                                                <span class="input-group-text">%</span>
                                                <small class="error-message" id="cancellationPercentage4_error"></small>
                                            </div>
                                            <div class="input-group inputWidth">
                                                <input type="number" class="form-control" id="" name="cancellationPercentage5" placeholder="0" value="<?= $cancel_policy['policy_5']??0 ?>">
                                                <span class="input-group-text">%</span>
                                                <small class="error-message" id="cancellationPercentage5_error"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-8">
                                <div id="markup1" class="section-block mt-4">
                                    <div class="card cardBackgroundColor rounded-3 p-3 cardShadow mb-0">

                                        <h5 class="fw-bolder textDarkBlue">MarkUp Calculation</h5>

                                        <div class="borderHighlight rounded-3 p-3">
                                            <?php if (in_array($upperChainId, [9, 10, 11, 13, 14, 15, 17, 18, 19, 21], true)) { ?>
                                            <!-- cu->tc->te/f->bm/mf/sf -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover align-middle mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="fs-6">Designation</th>
                                                            <th class="fs-6">Name</th>
                                                            <th class="fs-6">ID</th>
                                                            <th class="fs-6">Commission (₹)</th>
                                                            <th class="fs-6">Incentive (₹)</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <!-- BM | SF | M ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">BM | SF | M</td>

                                                            <td>
                                                                <span id="" class="fs-6">
                                                                    <?= htmlspecialchars(
                                                                        $chainDetails[
                                                                            (in_array('TE', array_column($chainDetails, 'prefix')) ||
                                                                            in_array('CA', array_column($chainDetails, 'prefix'))) ? 3 : 2
                                                                        ]['name'] ?? 'NA',
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ) ?>
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <span id="" class="fs-6">
                                                                    <?= htmlspecialchars(
                                                                        $chainDetails[
                                                                            (in_array('TE', array_column($chainDetails, 'prefix')) ||
                                                                            in_array('CA', array_column($chainDetails, 'prefix'))) ? 3 : 2
                                                                        ]['id'] ?? 'NA',
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ) ?>
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="bm_mf_sf_c"
                                                                    value="<?= $packagePricingMarkup['bm_direct_commission']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="bm_mf_sf_i"
                                                                    value="<?= $packagePricingMarkup['bm_incentive']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>

                                                        <!-- TE / F ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">TE / F</td>

                                                            <td>
                                                                <span id="teFName" class="fs-6">
                                                                    <?= htmlspecialchars(
                                                                        (in_array('TE', array_column($chainDetails, 'prefix')) ||
                                                                        in_array('CA', array_column($chainDetails, 'prefix')))
                                                                            ? ($chainDetails[2]['name'] ?? 'NA')
                                                                            : 'NA',
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ) ?>
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <span id="teFId" class="fs-6">
                                                                    <?= htmlspecialchars(
                                                                        (in_array('TE', array_column($chainDetails, 'prefix')) ||
                                                                        in_array('CA', array_column($chainDetails, 'prefix')))
                                                                            ? ($chainDetails[2]['id'] ?? 'NA')
                                                                            : 'NA',
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ) ?>
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="te_f_c"
                                                                    value="<?= $packagePricingMarkup['ca_direct_commission']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="te_f_i"
                                                                    value="<?= $packagePricingMarkup['ca_incentive']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>

                                                        <!-- TC ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">TC</td>

                                                            <td>
                                                                <span id="" class="fs-6">
                                                                    <?= htmlspecialchars($chainDetails[1]['name'] ?? 'NA', ENT_QUOTES, 'UTF-8') ?>
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <span id="" class="fs-6">
                                                                    <?= htmlspecialchars($chainDetails[1]['id'] ?? 'NA', ENT_QUOTES, 'UTF-8') ?>
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="tc_commission"
                                                                    value="<?= $packagePricingMarkup['ta_markup'] ?? 0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td class="text-center">—</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php } elseif (in_array($upperChainId, [12, 16, 20], true)) { ?>
                                            <!-- cu->tc->te/f->ste->ete->cte -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover align-middle mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="fs-6">Designation</th>
                                                            <th class="fs-6">Name</th>
                                                            <th class="fs-6">ID</th>
                                                            <th class="fs-6">Commission (₹)</th>
                                                            <th class="fs-6">Incentive (₹)</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <!-- CTE ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">CTE</td>

                                                            <td>
                                                                <span id="" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="bm_mf_sf_c"
                                                                    value="<?= $packagePricingTeChain['cte_direct_commission']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="bm_mf_sf_i"
                                                                    value="<?= $packagePricingTeChain['cte_incentive']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>
                                                        <!-- ETE ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">ETE</td>

                                                            <td>
                                                                <span id="" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="bm_mf_sf_c"
                                                                    value="<?= $packagePricingTeChain['ete_direct_commission']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="bm_mf_sf_i"
                                                                    value="<?= $packagePricingTeChain['ete_incentive']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>
                                                        <!-- STE ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">STE</td>

                                                            <td>
                                                                <span id="" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="bm_mf_sf_c"
                                                                    value="<?= $packagePricingTeChain['ste_direct_commission']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="bm_mf_sf_i"
                                                                    value="<?= $packagePricingTeChain['ste_incentive']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>
                                                        <!-- TE / F ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">TE / F</td>

                                                            <td>
                                                                <span id="" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="te_f_c"
                                                                    value="<?= $packagePricingTeChain['te_direct_commission']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="te_f_i"
                                                                    value="<?= $packagePricingTeChain['te_incentive']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>
                                                        <!-- TC ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">TC</td>

                                                            <td>
                                                                <span id="" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="tc_commission"
                                                                    value="<?= $packagePricingTeChain['ta_markup'] ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td class="text-center">—</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php } if (in_array($upperChainId, [1, 2, 3, 5, 6, 7,4, 8], true)) { ?>
                                            <h5 class="mb-3 fw-bolder" id="#">Institution Slab</h5>
                                            <table class="table table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col">Range</th>
                                                        <th scope="col">Commission Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="commissionTableBody">
                                                    
                                                </tbody>
                                            </table>
                                            <?php } if (in_array($upperChainId, [1, 2, 3, 5, 6, 7], true)) { ?>
                                            <!-- cu->ibr->i->bm/mf/sf -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover align-middle mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="fs-6">Designation</th>
                                                            <th class="fs-6">Name</th>
                                                            <th class="fs-6">ID</th>
                                                            <th class="fs-6">Commission (₹)</th>
                                                            <th class="fs-6">Incentive (₹)</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <!-- BM | SF | M ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">BM | SF | M</td>

                                                            <td>
                                                                <span id="" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="bm_mf_sf_c"
                                                                    value="<?= $packagePricingInstitution['bm_direct_commission']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="bm_mf_sf_i"
                                                                    value="<?= $packagePricingInstitution['bm_incentive']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>
                                                        <!-- I ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">I</td>

                                                            <td>
                                                                <span id="" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="te_f_c"
                                                                    value="<?= $packagePricingInstitution['ins_markup']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>-
                                                                <!-- <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="te_f_i"
                                                                    value="0.00"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                > -->
                                                            </td>
                                                        </tr>
                                                        <!-- TC ROW -->
                                                        <!-- <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">TC</td>

                                                            <td>
                                                                <span id="" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="tc_commission"
                                                                    value="0.00"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td class="text-center">—</td>
                                                        </tr> -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php } else if (in_array($upperChainId, [4, 8], true)) { ?>
                                            <!-- cu->Ibr->i->ete->cte -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover align-middle mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="fs-6">Designation</th>
                                                            <th class="fs-6">Name</th>
                                                            <th class="fs-6">ID</th>
                                                            <th class="fs-6">Commission (₹)</th>
                                                            <th class="fs-6">Incentive (₹)</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <!-- CTE ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">CTE</td>

                                                            <td>
                                                                <span id="" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="bm_mf_sf_c"
                                                                    value="<?= $packagePricingTechnoInstitution['cte_direct_commission'] ?? 0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="bm_mf_sf_i"
                                                                    value="<?= $packagePricingTechnoInstitution['cte_incentive'] ?? 0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>
                                                        <!-- ETE ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">ETE</td>

                                                            <td>
                                                                <span id=""></span>
                                                            </td>

                                                            <td>
                                                                <span id="">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="bm_mf_sf_c"
                                                                    value="<?= $packagePricingTechnoInstitution['ete_direct_commission'] ?? 0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="bm_mf_sf_i"
                                                                    value="<?= $packagePricingTechnoInstitution['ete_incentive'] ?? 0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>
                                                        <!-- I ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">I</td>

                                                            <td>
                                                                <span id="" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="te_f_c"
                                                                    value="<?= $packagePricingTechnoInstitution['ins_markup'] ?? 0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>-
                                                                <!-- <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="te_f_i"
                                                                    value="0.00"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                > -->
                                                            </td>
                                                        </tr>
                                                        <!-- TC ROW -->
                                                        <!-- <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">TC</td>

                                                            <td>
                                                                <span id="" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="tcId" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id=""
                                                                    name="tc_commission"
                                                                    value="0.00"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td class="text-center">—</td>
                                                        </tr> -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php } ?>
                                            <hr>

                                            <!-- COUPON ADJUSTMENT AND COMPANY -->
                                            <div class="row g-3 mb-3">
                                                <div class="col-lg-6 col-md-6">
                                                    <label for="" class="form-label fw-semibold">
                                                        Coupon Adjustment (₹)
                                                    </label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id=""
                                                        name="coupon_adjustment"
                                                        value="<?= $packagePricing['coupon_adjustment'] ??0.00?>"
                                                        min="0"
                                                        step="1"
                                                        placeholder="0.00"
                                                    >
                                                    <small class="error-message" id="couponAdjustment_error"></small>
                                                </div>

                                                <div class="col-lg-6 col-md-6">
                                                    <label for="" class="form-label fw-semibold">
                                                        Company (₹)
                                                    </label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id=""
                                                        name="company_amount"
                                                        value="<?= $packagePricingMarkup['company'] ??0.00?>"
                                                        min="0"
                                                        step="1"
                                                        placeholder="0.00"
                                                    >
                                                    <small class="error-message" id="companyAmount_error"></small>
                                                </div>
                                            </div>

                                            <!-- SUSPENSE -->
                                            <div class="row g-3 mb-3">
                                                <div class="col-lg-6 col-md-6">
                                                    <label for="" class="form-label fw-semibold">
                                                        Suspense (₹)
                                                    </label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id=""
                                                        name="suspense_amount"
                                                        value="<?= $suspenseAmount ?? 0.00 ?>"
                                                        min="0"
                                                        step="1"
                                                        placeholder="0.00"
                                                    >
                                                    <small class="error-message" id="suspenseAmount_error"></small>
                                                </div>
                                            </div>

                                            <!-- CUSTOMER AMOUNTS -->
                                            <div class="row g-3 mb-3">
                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <label for="" class="form-label fw-semibold">
                                                        L1 Customer (₹)
                                                    </label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id=""
                                                        name="customer_1_amount"
                                                        value="<?= $customerCom1 ?? 0.00 ?>"
                                                        min="0"
                                                        step="1"
                                                    >
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <label for="" class="form-label fw-semibold">
                                                        L2 Customer (₹)
                                                    </label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id=""
                                                        name="customer_2_amount"
                                                        value="<?= $customerCom2 ?? 0.00 ?>"
                                                        min="0"
                                                        step="1"
                                                    >
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <label for="" class="form-label fw-semibold">
                                                        L3 Customer (₹)
                                                    </label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id=""
                                                        name="customer_3_amount"
                                                        value="<?= $customerCom3 ?? 0.00 ?>"
                                                        min="0"
                                                        step="1"
                                                    >
                                                </div>
                                            </div>

                                            <hr>

                                            <!-- NET PRICE -->
                                            <div class="row g-3">

                                                <div class="col-lg-6 col-md-6">
                                                    <label for="" class="form-label fw-semibold">
                                                        Net Price - Adult (₹)
                                                    </label>

                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id=""
                                                        name="net_price_adult"
                                                        value="<?= htmlspecialchars($packagePricing['net_price_adult'] ?? 0) ?>"
                                                        min="0"
                                                        step="1"
                                                    >

                                                    <small class="text-muted d-block" id=""></small>
                                                    <small class="fw-semibold d-block mt-1" id=""></small>

                                                    <small class="error-message" id="netPriceAdult_error"></small>
                                                </div>

                                                <div class="col-lg-6 col-md-6">
                                                    <label for="" class="form-label fw-semibold">
                                                        Net Price - Child (₹)
                                                    </label>

                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id=""
                                                        name="net_price_child"
                                                        value="<?= htmlspecialchars($packagePricing['net_price_child'] ?? 0) ?>"
                                                        min="0"
                                                        step="1"
                                                    >

                                                    <small class="text-muted d-block" id=""></small>
                                                    <small class="fw-semibold d-block mt-1" id=""></small>

                                                    <small class="error-message" id="netPriceChild_error"></small>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card cardShadow section-block mt-4">
                                    <div class="quick-header p-3">
                                        <div class="d-flex gap-2">
                                            <i class="fa-solid fa-file-contract fa-xl align-content-center quickIcon"></i>
                                            <h5 class="fw-bold mb-0 textDarkBlue align-content-center">Revised Quotation</h5>
                                        </div>
                                    </div>
                                        <div class="p-3 pb-0" id="">
                                        <p class="mb-2 fw-bold blueDiv">Customer Applied Discount Details</p>
                                        <div class="d-flex justify-content-between align-items-center px-3 pb-2">
                                            <p class="fontSize10 discountGreen fw-bold mb-0">
                                                <i class="ri-price-tag-3-line"></i>
                                                Discounts (Coupon)
                                            </p>
                                            <p class="fontSize10 discountGreen fw-bold text-end mb-0" id="">- ₹ <?= $requestData['coupon_discount'] ?></p>
                                        </div>
                                        <?php if($requestData['referral_wallet_amount'] != 0){
                                        ?>
                                        <div class="d-flex justify-content-between align-items-center px-3 pb-2">
                                            <p class="fontSize10 discountGreen fw-bold mb-0">
                                                <i class="ri-wallet-3-line"></i>
                                                Reference Wallet
                                            </p>
                                            <p class="fontSize10 discountGreen fw-bold text-end mb-0" id="">- ₹ <?= $requestData['referral_wallet_amount'] ?></p>
                                        </div>
                                        <?php } if ($requestData['discount_wallet_amount'] != 0) {?>
                                            <div class="d-flex justify-content-between align-items-center px-3 pb-2">
                                                <p class="fontSize10 discountGreen fw-bold mb-0">
                                                    <i class="ri-wallet-3-line"></i>
                                                    Discount Wallet
                                                </p>
                                                <p class="fontSize10 discountGreen fw-bold text-end mb-0" id="">- ₹ <?= $requestData['discount_wallet_amount'] ?></p>
                                            </div>
                                        <?php } ?>
                                        <hr class="my-1 border border-2 mx-0">

                                        <div class="d-flex justify-content-between">
                                            <p class="fw-bold fs-5 textDarkBlue mb-0">Subtotal</p>
                                            <p class="fontSize13 fs-5 fw-bold textDarkBlue mb-0" id="">
                                                &#8377; 0
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Discounted Price Details -->
                                    <div class="p-3 pb-0" id="">
                                        <p class="mb-2 fw-bold blueDiv">Discounted Price Details</p>

                                        <div id="" class="d-flex flex-column">
                                            <!-- Discount rows will be added dynamically here -->
                                        </div>

                                        <hr class="my-1 border border-2 mx-0">

                                        <div class="d-flex justify-content-between">
                                            <p class="fw-bold fs-5 textDarkBlue mb-0">Subtotal</p>
                                            <p class="fontSize13 fs-5 fw-bold textDarkBlue mb-0" id="">
                                                &#8377; 0
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Additional Price Details -->
                                    <div class="p-3 pb-0" id="">
                                        <p class="mb-2 fw-bold blueDiv">Additional Price Details</p>

                                        <div id="additionalAdjustmentRows" class="d-flex flex-column">
                                            <!-- Additional price rows will be added dynamically here -->
                                        </div>

                                        <hr class="my-1 border border-2 mx-0">

                                        <div class="d-flex justify-content-between">
                                            <p class="fw-bold fs-5 textDarkBlue mb-0">Subtotal</p>
                                            <p class="fontSize13 fs-5 fw-bold textDarkBlue mb-0" id="">
                                                &#8377; 0
                                            </p>
                                        </div>
                                    </div>
                                    <hr class="my-2 border border-2 mx-3">
                                    <div class="p-3" id="">
                                        <p class="fw-bold blueDiv">Final Quoted Price</p>

                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="mb-1" id="">No Price Adjustment</p>
                                                <p class="mb-1">Final Quoted Price</p>
                                            </div>

                                            <div>
                                                <p class="mb-1 text-end fw-bold" id="">
                                                    &#8377; 0.00
                                                </p>

                                                <p class="mb-1 text-end fw-bold" id="">
                                                    &#8377; 0.00
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="p-3">
                                        <p class="fw-bold blueDiv">Adjustments</p>

                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="mb-1">Convenience Fee</p>
                                                <p class="mb-1">GST (<?= $requestData['gst_percentage'] ?>%)</p>
                                            </div>

                                            <div>
                                                <p class="mb-1 text-end" id="">
                                                    &#8377; <?= number_format((float)$requestData['convenience_fee'], 2) ?>
                                                </p>

                                                <p class="mb-1 text-end" id="">
                                                    &#8377; <?= number_format((float)$requestData['gst'], 2) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-1 border border-2 mx-3">

                                    <div class="p-3 pb-0">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fs-5 textDarkBlue fw-bold">Total Estimated Price</p>
                                            </div>

                                            <div>
                                                <p class="fs-5 text-danger fw-bolder text-end" id="">
                                                    &#8377; <?= number_format((float)$requestData['final_price'], 2) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- Card Section 2 subsection 6 End -->

            </div>
        </div>
    </div>

<?php endforeach; ?>
<?php if ($showOriginalEditable): ?>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingCustomer">
            <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseCustomer1"
                aria-expanded="false"
                aria-controls="collapseCustomer">

                <div class="accordion-heading-content">
                    <div class="accordion-heading-title">
                        <i class="fa-solid fa-user-pen"></i>
                        Prepare Quotation
                    </div>

                    <!-- No history -->
                    <span class="history-status edit-status">
                        <i class="fa-solid fa-pen-to-square"></i>
                        Edit
                    </span>

                    <!-- Show this instead when history exists -->
                    <!--
                    <span class="history-status sent-status">
                        <i class="fa-solid fa-circle-check"></i>
                        Sent by John Doe · 22 Oct 2026, 01:30 PM
                    </span>
                    -->

                </div>

            </button>
        </h2>
        <div
            id="collapseCustomer1"
            class="accordion-collapse collapse"
            aria-labelledby="headingCustomer1"
            data-bs-parent="#formHistoryAccordion">

            <div class="accordion-body">
                <!-- Card Section 1 Start -->
                <div class="row rowAlignment">
                    <div class="col-12">
                        <div class="card cardShadow">
                            <div class="d-flex tabDisplayBlock">
                                <div class="p-2 imageWrapper">
                                    <img src="<?= '../../'.$galleryImages[0]['image'] ?>" alt="" class="prepareQuotationImg">
                                </div>
                                <div class="p-3 widthStretch">
                                    <div class="packageIDBtn">
                                        <?= $package['unique_code'] ?>
                                    </div>
                                    <p class="fw-bolder textDarkBlue mb-1 fs-4" id=""><?= $package['name'] ?></p>
                                    <p class="fw-bold textDarkBlue mb-1 fs-5" id="">
                                        <?= $package['description'] ?>
                                    </p>
                                    <div class="d-flex gap-4 redIcons laptopDisplay">
                                        <p class="fontSize12 mb-3">
                                            <i class="fa-solid fa-location-dot me-2"></i>
                                            <?= $package['destination'] ?>
                                        </p>
                                        <p class="fontSize12 mb-3">
                                            <i class="fa-regular fa-calendar me-2"></i>
                                            <?= $tour_nights ?> Nights / <?= $tour_days ?> Days
                                        </p>
                                        <p class="fontSize12 mb-3">
                                            <i class="fa-solid fa-utensils me-2"></i>
                                            Meals: <?= $meal_cat['name'] ?>
                                        </p>
                                    </div>
                                    <p class="fontSize12 mb-3">
                                        <?= $package['detailed_description'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card Section 1 End -->
                <div class="row">
                    <div class="col-xl-8">
                        <!-- Card Section 2 subsection 1 Start -->
                        <div class="card p-3">
                            <h5 class="fw-bold textDarkBlue">
                                <i class="fa-solid fa-clipboard-list fa-xl me-3"></i>
                                Enquiry Information
                            </h5>
                            <div class="row">
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-0">Enquiry ID :</p>
                                    <p class="fs-6 mb-0 fw-bold"><?= $request_id ?></p>
                                </div>
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-0">Received On :</p>
                                    <p class="fs-6 mb-0 fw-bold">
                                        <?= !empty($requestData['created_date'])
                                            ? date('d M Y, h:i A', strtotime($requestData['created_date']))
                                            : 'N/A'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 2 subsection 1 End -->
                        <!-- Card Section 2 subsection 2 Start -->
                        <div class="card p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="fw-bold textDarkBlue">
                                    <i class="fa-solid fa-user fa-xl me-3"></i>
                                    Customer Information
                                </h5>
                                <!-- <a class="editCustomerBtn">
                                    <i class="fa-solid fa-pen me-1"></i>
                                    Edit
                                </a> -->
                            </div>
                            <div class="row">
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Full Name :</p>
                                    <p class="fs-6 mb-2 fw-bold"><?= $requestData['guestFullName'] ?></p>
                                </div>
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Mobile :</p>
                                    <p class="fs-6 mb-2 fw-bold"><?= $requestData['guestPhone'] ?></p>
                                </div>
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Email :</p>
                                    <p class="fs-6 mb-2 fw-bold"><?= $requestData['guestEmail'] ?></p>
                                </div>
                                <!-- <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Address :</p>
                                    <p class="fs-6 mb-2 fw-bold">Mumbai, Maharashtra</p>
                                </div> -->
                                <?php if($requestData['userId'] != 'null'){
                                ?>
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Customer Type :</p>
                                    <p class="fs-6 mb-2 fw-bold"><?= $Requester_type ?></p>
                                </div>
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Member Id :</p>
                                    <p class="fs-6 mb-2 fw-bold"><?= $requestData['userId'] ?></p>
                                </div>
                                <!-- <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Travel Consultant :</p>
                                    <p class="fs-6 mb-2 fw-bold">-</p>
                                </div> -->
                                <?php }else{ ?>
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Customer Type :</p>
                                    <p class="fs-6 mb-2 fw-bold"><?= $Requester_type ?></p>
                                </div>
                                <div class="col-xl-6 d-flex gap-2">
                                    <p class="fs-6 mb-2">Member Id :</p>
                                    <p class="fs-6 mb-2 fw-bold">NA</p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Card Section 2 subsection 2 End -->
                        <div class="card p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="fw-bold textDarkBlue">
                                    <i class="fa-solid fa-calendar-days fa-xl me-3"></i>
                                    Trip Request <span class="fw-normal">(Submitted by Customer)</span>
                                </h5>
                            </div>
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput11" class="form-label">Travel Start Date</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="exampleFormControlInput11" value="<?= $requestData['travel_start_date'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput21" class="form-label">Travel End Date</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="exampleFormControlInput21" value="<?= $requestData['travel_end_date'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput31" class="form-label">Nights / Days</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="exampleFormControlInput31" value="<?= $requestData['no_of_nights_days'] ?>" readonly >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput41" class="form-label">Pickup</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="exampleFormControlInput41" value="<?= $requestData['customer_pickup'] != '' ? $requestData['customer_pickup']: $requestData['pickup_point'] ?>" >
                                        <?php
                                            $oldPickup = !empty($requestData['customer_pickup'])
                                            ? $requestData['pickup_point']
                                            : '';
                                        ?>

                                        <?php if ($oldPickup !== ''): ?>
                                            <small class="old-value-text text-muted"
                                                id="pickupOldValue1">
                                                Previous Pickup: </br> 
                                                <?= htmlspecialchars($oldPickup, ENT_QUOTES, 'UTF-8') ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput51" class="form-label">Drop</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="exampleFormControlInput51" value="<?= $requestData['customer_drop'] != '' ? $requestData['customer_drop']: $requestData['drop_point'] ?>" >
                                        <?php
                                            $olddrop = !empty($requestData['customer_drop'])
                                            ? $requestData['drop_point']
                                            : '';
                                        ?>

                                        <?php if ($olddrop !== ''): ?>
                                            <small class="old-value-text text-muted"
                                                id="dropOldValue1">
                                                Previous Drop: </br> 
                                                <?= htmlspecialchars($olddrop, ENT_QUOTES, 'UTF-8') ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row paxRow">
                                <div class="col-xl-3 paxCol">
                                    <div class="mb-3">
                                        <label for="adultCount" class="form-label">Adults (12+ yrs)</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="adultCount1" value="<?= $requestData['adult_count'] ?>">
                                    </div>
                                </div>
                                <div class="col-xl-3 paxCol">
                                    <div class="mb-3">
                                        <label for="childcount" class="form-label">Children (2-11 yrs)</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="childcount1" value="<?= $requestData['child_count'] ?>">
                                    </div>
                                </div>
                                <div class="col-xl-3 paxCol">
                                    <div class="mb-3">
                                        <label for="infantCount" class="form-label">Infants (0-1 yrs)</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="infantCount1" value="<?= $requestData['infant_count'] ?>">
                                    </div>
                                </div>
                                <div class="col-xl-3 paxCol">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput91" class="form-label">Total Pax</label>
                                        <input type="text" class="form-control fw-bold textDarkBlue" id="exampleFormControlInput91" value="<?= $requestData['adult_count'] + $requestData['child_count'] + $requestData['infant_count'] ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 2 subsection 3 End -->
                        <!-- Card Section 2 subsection 4 Start -->
                        <div class="card p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="fw-bold textDarkBlue">
                                    <i class="fa-solid fa-bed fa-xl me-3"></i>
                                    Room Allocation <span class="fw-normal">(Requested by Customer)</span>
                                </h5>
                                <a class="editCustomerBtn modifyBtn">
                                    <i class="fa-solid fa-pen me-1"></i>
                                    Edit
                                </a>
                            </div>
                            
                            <?php
                                $rooms = json_decode($requestData['rooms'] ?? '[]', true);

                                if (!is_array($rooms)) {
                                    $rooms = [];
                                }

                                $totalRooms = count($rooms);

                                $adultCount  = (int)($requestData['adult_count'] ?? 0);
                                $childCount  = (int)($requestData['child_count'] ?? 0);
                                $infantCount = (int)($requestData['infant_count'] ?? 0);

                                $totalTravellers = $adultCount + $childCount + $infantCount;

                                $bedCounts = [];
                                $totalExtraMattresses = 0;
                                $recommendations = [];

                                foreach ($rooms as $room) {
                                    $description = trim($room['description'] ?? '');

                                    // Count extra mattresses separately.
                                    if (preg_match_all(
                                        '/(\d+)\s*Extra\s*Mattress(?:es)?/i',
                                        $description,
                                        $mattressMatches
                                    )) {
                                        foreach ($mattressMatches[1] as $quantity) {
                                            $totalExtraMattresses += (int)$quantity;
                                        }
                                    }

                                    // Remove the entire extra mattress phrase from the room description.
                                    $description = preg_replace(
                                        '/\s*\+?\s*\d+\s*Extra\s*Mattress(?:es)?/i',
                                        '',
                                        $description
                                    );

                                    // Clean up leftover separators and spaces.
                                    $description = trim($description, " \t\n\r\0\x0B,+-");

                                    // Process only bed types now.
                                    $bedItems = preg_split('/\s*\+\s*|\s*,\s*/', $description);

                                    foreach ($bedItems as $item) {

                                        $item = trim($item);

                                        if ($item === '') {
                                            continue;
                                        }

                                        $quantity = 1;

                                        if (preg_match('/^(\d+)\s+(.+)$/i', $item, $matches)) {
                                            $quantity = (int)$matches[1];
                                            $item = trim($matches[2]);
                                        }

                                        // Safety check: never allow a mattress into the bed summary.
                                        if (stripos($item, 'mattress') !== false) {
                                            continue;
                                        }

                                        if ($quantity <= 0 || $item === '') {
                                            continue;
                                        }

                                        $item = preg_replace('/\bBeds\b/i', 'Bed', $item);
                                        $key = strtolower(trim($item));

                                        if (!isset($bedCounts[$key])) {
                                            $bedCounts[$key] = [
                                                'name' => trim($item),
                                                'count' => 0
                                            ];
                                        }

                                        $bedCounts[$key]['count'] += $quantity;
                                    }

                                    // Keep recommendations unique.
                                    $recommendation = trim($room['recommendation'] ?? '');

                                    if (
                                        $recommendation !== '' &&
                                        !in_array($recommendation, $recommendations, true)
                                    ) {
                                        $recommendations[] = $recommendation;
                                    }
                                }

                                /*
                                * 5. Build the combined room type summary.
                                */
                                $roomTypeSummary = [];

                                foreach ($bedCounts as $bed) {

                                    $count = $bed['count'];
                                    $name = $bed['name'];

                                    if (preg_match('/\bBed\b/i', $name)) {
                                        $name = preg_replace(
                                            '/\bBed\b/i',
                                            $count === 1 ? 'Bed' : 'Beds',
                                            $name
                                        );
                                    }

                                    $roomTypeSummary[] = $count . ' ' . $name;
                                }

                                $roomTypeText = implode(', ', $roomTypeSummary);
                            ?>

                            <div class="row">
                                <div class="col-xl-12">

                                    <table class="table table-bordered mb-0 fs-6">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col">Room Count</th>
                                                <th scope="col">Travellers</th>
                                                <th scope="col">Room Type</th>
                                                <th scope="col">Extra Mattress</th>
                                            </tr>
                                        </thead>

                                        <tbody id="roomAllocationSummaryBody" class="fs-6">
                                            <?php if (!empty($rooms)): ?>
                                                <tr>
                                                    <td>
                                                        <?= $totalRooms ?>
                                                        <?= $totalRooms === 1 ? 'Room' : 'Rooms' ?>
                                                    </td>

                                                    <td>
                                                        <?= $totalTravellers ?>
                                                        (<?= $adultCount ?> Adults +
                                                        <?= $childCount ?> Children +
                                                        <?= $infantCount ?> Infants)
                                                    </td>

                                                    <td>
                                                        <?= htmlspecialchars(
                                                            $roomTypeText !== '' ? $roomTypeText : 'N/A',
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ) ?>
                                                    </td>

                                                    <td>
                                                        <?php if ($totalExtraMattresses > 0): ?>
                                                            <?= $totalExtraMattresses ?>
                                                            <?= $totalExtraMattresses === 1
                                                                ? 'Extra Mattress'
                                                                : 'Extra Mattresses' ?>
                                                        <?php else: ?>
                                                            N/A
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        No room details available.
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>

                                    <?php if (!empty($rooms)): ?>
                                        <div class="paxDescriptionBtn d-flex">
                                            <i class="fa-solid fa-circle-user paxColor fa-lg align-content-center me-2"></i>

                                            <span>
                                                <?= $totalTravellers ?>
                                                <?= $totalTravellers === 1 ? 'traveller' : 'travellers' ?>
                                                will be accommodated in
                                                <?= $totalRooms ?>
                                                <?= $totalRooms === 1 ? 'room' : 'rooms' ?>.

                                                <?php if (!empty($recommendations)): ?>
                                                    <br>
                                                    <?= htmlspecialchars(
                                                        implode(', ', $recommendations),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>



                        </div>
                        <!-- Card Section 2 subsection 4 End -->
                        <!-- Card Section 2 subsection 5 Start -->
                        <div class="card p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="fw-bold textDarkBlue">
                                    <i class="fa-solid fa-calendar-days fa-xl me-3"></i>
                                    Customer Preferences <span class="fw-normal">(Submitted by Customer)</span>
                                </h5>
                                
                            </div>
                            <div class="row">
                                <!-- HOTEL CATEGORY -->
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="hotelCategory" class="form-label fontSize10">
                                            Hotel Category
                                        </label>
                                        <div class="icon-select-wrapper">
                                            <i class="ri-hotel-line iconPosition iconRed"></i>
                                            <?php
                                            $sql = $conn->prepare("
                                                SELECT id, name
                                                FROM category_hotel
                                                WHERE status = 1
                                                ORDER BY id DESC
                                            ");
                                            $sql->execute();
                                            $hotelCategories = $sql->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <select id="hotelCategory" class="form-select fontSize10 paddingLeft" name="hotel_category" disabled>
                                                <option value="">Select Hotel</option>

                                                <?php foreach ($hotelCategories as $hotel): ?>
                                                    <option
                                                        value="<?= htmlspecialchars($hotel['id'], ENT_QUOTES, 'UTF-8') ?>"
                                                        <?= ((string)$hotel['id'] === (string)($requestData['hotel_category'] ?? '')) ? 'selected' : '' ?>
                                                    >
                                                        <?= htmlspecialchars($hotel['name'], ENT_QUOTES, 'UTF-8') ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <!-- OLD VALUE -->
                                        <small id="oldHotelCategory" class="text-muted fontSize10 d-none mt-2"></small>
                                    </div>
                                </div>
                                <!-- MEAL PREFERENCE -->
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="mealPreference" class="form-label fontSize10">
                                            Meal Preference
                                        </label>
                                        <div class="icon-select-wrapper">
                                            <i class="ri-restaurant-line iconPosition iconRed"></i>
                                            <?php
                                            $sql = $conn->prepare("
                                                SELECT id, name
                                                FROM category_meal
                                                WHERE status = 1
                                                ORDER BY id DESC
                                            ");
                                            $sql->execute();
                                            $mealCategories = $sql->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <select id="mealPreference" class="form-select fontSize10 paddingLeft" name="meal_preference" disabled>
                                                <option value="">Select Meal</option>
                                                <?php foreach ($mealCategories as $meal_cat): ?>
                                                    <option value="<?= htmlspecialchars($meal_cat['id']) ?>" 
                                                    <?= ($requestData['meal_preference'] == $meal_cat['id']) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($meal_cat['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <!-- OLD VALUE -->
                                        <samll id="oldMealPreference" class="text-muted fontSize10 d-none mt-2"></samll>
                                    </div>
                                </div>
                                <!-- TRANSPORT -->
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="transportPreference" class="form-label fontSize10">
                                            Transport Preference
                                        </label>
                                        <div class="icon-select-wrapper">
                                            <i class="ri-car-line iconPosition iconRed"></i>
                                            <?php
                                            $sql = $conn->prepare("
                                                SELECT id, name
                                                FROM category_vehicle
                                                WHERE status = 1
                                                ORDER BY id DESC
                                            ");
                                            $sql->execute();
                                            $vehicleCategories = $sql->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <select id="transportPreference" class="form-select fontSize10 paddingLeft" name="transport_preference" disabled>
                                                <option value="">Select Vehicle</option>
                                                <?php foreach ($vehicleCategories as $vehicle_cat): ?>
                                                    <option value="<?= htmlspecialchars($vehicle_cat['id']) ?>" 
                                                    <?= ($requestData['transport_preference'] == $vehicle_cat['id']) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($vehicle_cat['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <!-- OLD VALUE -->
                                        <small id="oldTransportPreference" class="text-muted fontSize10 d-none mt-2"></small>
                                    </div>
                                </div>
                                <!-- SPECIAL REQUIREMENT -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="mb-0">
                                        <label for="specialRequirement" class="form-label fontSize10">Special Requirements (Optional)</label>
                                        <textarea
                                            class="form-control fontSize10"
                                            id="specialRequirement"
                                            name="special_requirement"
                                            placeholder="Eg. Wheelchair, extra bed, high floor, adjoining rooms, etc."
                                            style="text-align: left;"
                                            readonly
                                        ><?= htmlspecialchars(trim($requestData['special_requirement'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 2 subsection 5 End -->
                        
                    </div>
                    <div class="col-xl-4">
                        <div class="card cardShadow">
                            <div class="quick-header p-3">
                                <div class="d-flex gap-2">
                                    <i class="fa-solid fa-location-dot fa-xl align-content-center quickIcon"></i>
                                    <h5 class="fw-bold mb-0 textDarkBlue align-content-center">Quick Action</h5>
                                </div>
                                <!-- <button type="button" class="recalculate-btn" id="#">
                                    <i class="fa-solid fa-rotate-right"></i>
                                    Recalculate
                                </button> -->
                            </div>
                            <div class="px-3">
                                <p class="mb-2 fw-bold blueDiv">Base Price (Per Person)</p>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="mb-1">Adult (12+ yrs)</p>
                                        <p class="mb-1">Child (2-11 yrs)</p>
                                        <p class="mb-1">Infant (0-1 yrs)</p>
                                    </div>
                                    <div>
                                        <p class="mb-1 text-end" id='perAdultAmt'>&#8377; <?= number_format($adultDisplayPrice, 2) ?></p>
                                        <p class="mb-1 text-end" id='perChildAmt'>&#8377; <?= number_format($childDisplayPrice, 2) ?></p>
                                        <p class="mb-1 text-end">FREE</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 pb-0">
                                <p class="mb-2 fw-bold blueDiv">Price Based on Travelers</p>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="mb-1">Adult: <span class="" id="totalAdultCount"><?= $requestData['adult_count'] ?></span> x &#8377; <?= number_format($adultDisplayPrice, 2) ?></p>
                                        <p class="mb-1">Children: <span class="" id="totalChildrenCount"><?= $requestData['child_count'] ?></span> x &#8377; <?= number_format($childDisplayPrice, 2) ?></p>
                                        <p class="mb-1">Infant: <span class="" id="totalInfantCount"><?= $requestData['infant_count'] ?></span> x FREE</p>
                                        <p class="mb-1" id='extraMatress'>Extra Mattress (1 x &#8377; <?= $pricing['extra_mattress'] ?>)</p>
                                    </div>
                                    <div>
                                        <p class="mb-1 text-end" id="adultTotal">&#8377; <?= number_format($requestData['adult_total'], 2) ?></p>
                                        <p class="mb-1 text-end" id="childrenTotal">&#8377; <?= number_format($requestData['children_total'], 2) ?></p>
                                        <p class="mb-1 text-end">&#8377; 0.00</p>
                                        <p class="mb-1 text-end" id="extraMatressTotal">&#8377; <?= $totalExtraMattresses * $pricing['extra_mattress'] ?></p>
                                        
                                    </div>
                                </div>
                                <hr class="my-1 border border-2 mx-0">
                                <div class="d-flex justify-content-between">
                                    <p class="fw-bold fs-5 textDarkBlue mb-0">Subtotal</p>
                                    <p class="fontSize13 fs-5 fw-bold textDarkBlue mb-0" id="subTotal">&#8377; <?= number_format($requestData['subtotal'], 2) ?></p>
                                </div>
                            </div>
                            
                            <hr class="my-1 border border-2 mx-3">
                            <div class="p-3">
                                <p class="fw-bold">Transport</p>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fontSize10" id="selectedVehicleText"><?= $requestData['transport_type'] ?></p>
                                        <a href="#" class="fontSize10 text-primary" id="changeVehicle">Change Vehicle</a>
                                    </div>
                                    <div>
                                        <!-- <p class="fontSize10 text-end">Included</p> -->
                                    </div>
                                </div>
                            </div>
                            <hr class="my-1 border border-2 mx-3">
                            <?php if($Requester_type  == 'Neo Select'){  ?>
                            <!-- <hr class="my-1 border border-2 mx-3"> -->
                            <div class="p-3 pb-0">
                                <p class="fw-bold mb-2 textDarkBlue blueDiv">
                                    Apply Coupons
                                    <span class="text-muted fw-normal fontSize12">
                                        (One coupon per passenger)
                                        <i class="ri-error-warning-line"></i>
                                    </span>
                                </p>
                                <div id="couponPassengerContainer1" class="coupon-passenger-container"></div>
                            </div>
                            <hr class="my-1 border border-2 mx-3">
                            <div class="d-flex justify-content-between px-3">
                                <p class="fontSize10 discountGreen fw-bold">
                                    Discounts (Coupons)
                                </p>
                                <p class="fontSize10 discountGreen fw-bold text-end"
                                id="totalCouponDiscount1">
                                    - ₹ 0
                                </p>
                            </div>
                            <?php
                            $referralWalletBalance = $referralBalance ?? 0;
                            $discountWalletBalance = $discountBalance ?? 0;
                            ?>

                            <!-- <hr class="my-1 border border-2 mx-3"> -->

                            <div class="d-flex justify-content-between align-items-center px-3">

                                <p class="fontSize10 discountGreen fw-bold mb-0">
                                    Referral Wallet
                                </p>

                                <p class="fontSize10 discountGreen fw-bold text-end mb-0"
                                id="referralWalletBalance">
                                    ₹ <?= number_format($referralWalletBalance, 2) ?>
                                </p>

                                <div class="d-flex align-items-center">
                                    <span class="fontSize10 discountGreen fw-bold me-1">
                                        - ₹
                                    </span>
                                    <input type="number" class="form-control form-control-sm walletInput" id="appliedReferralWallet" value="<?= $requestData['referral_wallet_amount'] ?>" min="0" step="1" disabled style="width: 80px;">
                                </div>
                            </div>
                            <hr class="my-1 border border-2 mx-3">
                            <div class="d-flex justify-content-between align-items-center px-3">
                                <p class="fontSize10 discountGreen fw-bold mb-0">
                                    Discount Wallet
                                </p>
                                <p class="fontSize10 discountGreen fw-bold text-end mb-0"
                                id="discountWalletBalance">
                                    ₹ <?= number_format($discountWalletBalance, 2) ?>
                                </p>
                                <div class="d-flex align-items-center">
                                    <span class="fontSize10 discountGreen fw-bold me-1">
                                        - ₹
                                    </span>
                                    <input type="number" class="form-control form-control-sm walletInput" id="appliedDiscountWallet" value="0" min="0" step="1" disabled style="width: 80px;">
                                </div>
                            </div>
                            <?php } elseif ($Requester_type != 'Neo Select' && in_array($Requester_type,['Prime','Premium','Premium Plus','Premium Select','Premium Select Lite','Neo Select','Neo Select Ultra'])) {?>
                            <div class="p-3 pb-0">
                                <p class="fw-bold mb-2 textDarkBlue blueDiv">
                                    Apply Coupons
                                    <span class="text-muted fw-normal fontSize12">
                                        Only one coupon can be applied per package
                                        <i class="ri-error-warning-line"></i>
                                    </span>
                                </p>
                                <div id="couponPassengerContainer1" class="coupon-passenger-container"></div>
                            </div>
                            
                            <!-- TOTAL -->
                            <hr class="my-1 border border-2 mx-3">
                            <div class="d-flex justify-content-between align-items-center px-3 pb-2">
                                <p class="fontSize10 discountGreen fw-bold mb-0">
                                    <i class="ri-price-tag-3-line"></i>
                                    Discounts (Coupon)
                                </p>
                                <p class="fontSize10 discountGreen fw-bold text-end mb-0" id="totalCouponDiscount1">- ₹ 0</p>
                            </div>
                            <?php
                            $referralWalletBalance = $referralBalance ?? 0;
                            ?>
                            <hr class="my-1 border border-2 mx-3">

                            <div class="d-flex justify-content-between align-items-center px-3">

                                <p class="fontSize10 discountGreen fw-bold mb-0">
                                    Referral Wallet
                                </p>

                                <p class="fontSize10 discountGreen fw-bold text-end mb-0"
                                id="referralWalletBalance">
                                    ₹ <?= number_format($referralWalletBalance, 2) ?>
                                </p>

                                <div class="d-flex align-items-center">
                                    <span class="fontSize10 discountGreen fw-bold me-1">
                                        - ₹
                                    </span>
                                    <input type="number" class="form-control form-control-sm walletInput" id="appliedReferralWallet" value="0" min="0" step="1" disabled style="width: 80px;">
                                </div>
                            </div>
                            <?php } ?>
                            
                            <hr class="my-2 border border-2 mx-3">
                            <div class="p-3">
                                <p class="fw-bold blueDiv">Adjustments</p>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        
                                        <p class="mb-1">Convenience Fee </p>
                                        <p class="mb-1" id='gstPercentage'>GST (<?= $requestData['gst_percentage'] ?>%) </p>
                                    </div>
                                    <div>
                                        
                                        <p class="mb-1 text-end" id="convenienceFee">&#8377; <?= $requestData['convenience_fee'] ?></p>
                                        <p class="mb-1 text-end" id="gstAmount">&#8377; <?= $requestData['gst'] ?></p>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-1 border border-2 mx-3">
                            <div class="p-3 pb-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fs-5 textDarkBlue fw-bold">Total Estimated Price</p>
                                    </div>
                                    <div>
                                        <p class="fs-5 text-danger fw-bolder text-end" id="finalPackagePrice">&#8377; <?= number_format($requestData['final_price'], 2) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card Section 2 subsection 6 Start -->
                <div class="card p-3">
                    <h5 class="fw-bold textDarkBlue">
                        <i class="fa-solid fa-file-lines fa-xl me-3"></i>
                        Package Information <span class="fw-normal">(From Package Master)</span>
                    </h5>
                    <div class="row paxRow mt-1 mb-2">
                        <div class="col-xl-2 paxCol">
                            <p class="fs-6 mb-1">Package ID</p>
                            <p class="fs-6 fw-bold mb-2"><?= $package['unique_code'] ?></p>
                        </div>
                        <div class="col-xl-10">
                            <div class="row paxRow">
                                <div class="col-xl-4 paxCol">
                                    <p class="fs-6 mb-1">Destination</p>
                                    <p class="fs-6 fw-bold mb-2"><?= $package['name'] ?></p>
                                </div>
                                <div class="col-xl-4 paxCol">
                                    <p class="fs-6 mb-1">Duration</p>
                                    <p class="fs-6 fw-bold mb-2"><?= $tour_nights ?> Nights / <?= $tour_days ?> Days</p>
                                </div>
                                <div class="col-xl-4">
                                    <p class="fs-6 mb-1">Package Type</p>
                                    <p class="fs-6 fw-bold mb-2"><?= $package['category_id'] == 2 ? 'Domestic':($package['category_id'] == 1 ?'International':'NA') ?></p>
                                </div>
                                <div class="col-xl-6 paxCol">
                                    <p class="fs-6 mb-1">Pacakge Category</p>
                                    <p class="fs-6 fw-bold mb-2"><?= $package['package_type'] ?></p>
                                </div>
                                <div class="col-xl-6 paxCol">
                                    <p class="fs-6 mb-1">Valid Travel Period</p>
                                    <p class="fs-6 fw-bold mb-2">
                                        Valid Till <?= date('d-m-Y', strtotime($package['validity'])) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-placeholder"></div>
                    <div class="sticky-nav-wrapper">
                        <div class="borderColor1 cardShadow p-2">
                            <ul class="nav nav-underline justify-content-between">
                                <li class="nav-item navItem">
                                    <a class="nav-link pt-0 active" aria-current="page" href="#overview1">
                                        <div class="text-center">
                                            <i class="ri-dashboard-line"></i>
                                        </div>
                                        Overview
                                    </a>
                                </li>
                                <li class="nav-item navItem">
                                    <a class="nav-link pt-0" href="#itinerary1">
                                        <div class="text-center">
                                            <i class="ri-route-line"></i>
                                        </div>
                                        Itinerary
                                    </a>
                                </li>
                                <li class="nav-item navItem">
                                    <a class="nav-link pt-0" href="#inclusion1">
                                        <div class="text-center">
                                            <i class="ri-dashboard-line"></i>
                                        </div>
                                        Inclusions
                                    </a>
                                </li>
                                <li class="nav-item navItem">
                                    <a class="nav-link pt-0" href="#inclusion1">
                                        <div class="text-center">
                                            <i class="ri-dashboard-line"></i>
                                        </div>
                                        Exclusions
                                    </a>
                                </li>
                                <li class="nav-item navItem">
                                    <a class="nav-link pt-0" href="#policies1">
                                        <div class="text-center">
                                            <i class="ri-dashboard-line"></i>
                                        </div>
                                        Policies
                                    </a>
                                </li>
                                <li class="nav-item navItem">
                                    <a class="nav-link pt-0" href="#faqs1">
                                        <div class="text-center">
                                            <i class="ri-question-answer-line"></i>
                                        </div>
                                        Cancellation Policy
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="content-sections">
                        <div id="overview1" class="section-block">
                            <div class="card cardBackgroundColor rounded-3 p-3 cardShadow">
                                <h5 class="fw-bolder textDarkBlue">Overview</h5>
                                <div class="d-flex gap-3">
                                    <div class="overviewImageWrapper">
                                        <img src="<?= '../../'.$galleryImages[0]['image'] ?>" alt="" class="overviewImg">
                                    </div>
                                    <div class="fontSize1">
                                        <p class="fw-normal fontSize12"><?= $package['detailed_description'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="itinerary1" class="section-block">
                            <div class="card cardBackgroundColor rounded-3 p-3 pb-4 cardShadow">
                                <h5 class="fw-bolder textDarkBlue">Itinerary</h5>

                                <div class="tour-details-content">
                                    <div class="destination-accordion mt-2">
                                        <div class="accordion" id="accordionItinerary">

                                            <?php
                                                $count = 1;

                                                // Fetch itinerary days
                                                $data4 = $conn->prepare("
                                                    SELECT *
                                                    FROM package_trip_days
                                                    WHERE package_id = :package_id
                                                ");
                                                $data4->execute([
                                                    ':package_id' => $id
                                                ]);

                                                $days = $data4->fetchAll(PDO::FETCH_ASSOC);

                                                foreach ($days as $key_3 => $day):

                                                    $description = $day['day_details'] ?? '';
                                                    $mealPlan = $day['meal_plan'] ?? '';
                                                    $dayTransport = $day['day_tansport'] ?? '';
                                                    $stay = $day['stay'] ?? '';
                                            ?>

                                                <div class="timeline-number">
                                                    <?= str_pad($count, 2, '0', STR_PAD_LEFT) ?>
                                                </div>

                                                <div class="accordion-item">

                                                    <h2 class="accordion-header"
                                                        id="panelsStayOpen-heading<?= $count ?>">

                                                        <button
                                                            class="accordion-button <?= ($count != 1) ? 'collapsed' : '' ?>"
                                                            type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#panelsStayOpen-collapse<?= $count ?>"
                                                            aria-expanded="<?= ($count == 1) ? 'true' : 'false' ?>"
                                                            aria-controls="panelsStayOpen-collapse<?= $count ?>">

                                                            Day <?= $key_3 + 1 ?> -
                                                            <?= htmlspecialchars($day['title'] ?? '') ?>

                                                        </button>
                                                    </h2>

                                                    <div
                                                        id="panelsStayOpen-collapse<?= $count ?>"
                                                        class="accordion-collapse collapse <?= ($count == 1) ? 'show' : '' ?>"
                                                        aria-labelledby="panelsStayOpen-heading<?= $count ?>"
                                                        data-bs-parent="#accordionItinerary">

                                                        <div class="accordion-body">

                                                            <!-- DAY DESCRIPTION -->
                                                            <ul class="listing">
                                                                <li class="list">
                                                                    <textarea
                                                                        class="form-control fontSize10"
                                                                        name="itinerary[<?= (int)$day['id'] ?>][day_details]"
                                                                        rows="4"
                                                                        placeholder="Enter day description"
                                                                    ><?= htmlspecialchars($description) ?></textarea>
                                                                </li>
                                                            </ul>

                                                            <hr class="my-3"
                                                                style="border-top:1px solid #4b5051;">

                                                            <div class="row g-3 displayMeal">

                                                                <!-- MEAL -->
                                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="mb-3">

                                                                        <label
                                                                            for="mealPlan<?= (int)$day['id'] ?>"
                                                                            class="form-label fontSize10">
                                                                            Meal
                                                                        </label>

                                                                        <div class="icon-select-wrapper">
                                                                            <input
                                                                                type="text"
                                                                                id="mealPlan<?= (int)$day['id'] ?>"
                                                                                class="form-control fontSize10 paddingLeft"
                                                                                name="itinerary[<?= (int)$day['id'] ?>][meal_plan]"
                                                                                value="<?= htmlspecialchars($mealPlan) ?>"
                                                                                placeholder="Enter meal details">
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <!-- TRANSPORT -->
                                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="mb-3">

                                                                        <label
                                                                            for="dayTransport<?= (int)$day['id'] ?>"
                                                                            class="form-label fontSize10">
                                                                            Transport
                                                                        </label>

                                                                        <div class="icon-select-wrapper">
                                                                            <input
                                                                                type="text"
                                                                                id="dayTransport<?= (int)$day['id'] ?>"
                                                                                class="form-control fontSize10 paddingLeft"
                                                                                name="itinerary[<?= (int)$day['id'] ?>][day_tansport]"
                                                                                value="<?= htmlspecialchars($dayTransport) ?>"
                                                                                placeholder="Enter transport details">
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <!-- STAY -->
                                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="mb-3">

                                                                        <label
                                                                            for="dayStay<?= (int)$day['id'] ?>"
                                                                            class="form-label fontSize10">
                                                                            Stay
                                                                        </label>

                                                                        <input
                                                                            type="text"
                                                                            id="dayStay<?= (int)$day['id'] ?>"
                                                                            class="form-control fontSize10"
                                                                            name="itinerary[<?= (int)$day['id'] ?>][stay]"
                                                                            value="<?= htmlspecialchars($stay) ?>"
                                                                            placeholder="Enter stay details">

                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            <?php
                                                $count++;
                                            endforeach;
                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="inclusion1" class="section-block">
                            <div class="card cardBackgroundColor rounded-3 p-3 cardShadow">
                                <h5 class="fw-bolder textDarkBlue">Inclusion & Exclusion</h5>
                                
                                <div class="row">
                                    <?php
                                        $inclusions = safeJsonDecode($itinery['inclusion'] ?? '');
                                        $exclusions = safeJsonDecode($itinery['exclusion'] ?? '');
                                    ?>
                                    <!-- Inclusions -->
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <?php if (!empty($inclusions)): ?>
                                            <?php foreach ($inclusions as $inclusion): ?>
                                                <div class="d-flex gap-3 mt-2">
                                                    <div class="checkIcon">
                                                        <i class="ri-checkbox-circle-fill text-success"></i>
                                                    </div>
                                                    <textarea
                                                        class="form-control fontSize3 text-muted"
                                                        name="inclusions[]"
                                                        rows="2"
                                                        placeholder="Enter inclusion details"
                                                    ><?= htmlspecialchars($inclusion) ?></textarea>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p class="text-muted mt-2 mb-0">No inclusions available.</p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Exclusions -->
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <?php if (!empty($exclusions)): ?>
                                            <?php foreach ($exclusions as $exclusion): ?>
                                                <div class="d-flex gap-3 mt-2">
                                                    <div class="closeIcon">
                                                        <i class="ri-close-circle-fill text-danger"></i>
                                                    </div>
                                                    <textarea
                                                        class="form-control fontSize3 text-muted"
                                                        name="exclusions[]"
                                                        rows="2"
                                                        placeholder="Enter exclusion details"
                                                    ><?= htmlspecialchars($exclusion) ?></textarea>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p class="text-muted mt-2 mb-0">No exclusions available.</p>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="policies1" class="section-block">
                            <div class="card cardBackgroundColor rounded-3 p-3 cardShadow">

                                <h5 class="fw-bolder mb-3 textDarkBlue">Policies</h5>

                                <p class="text-muted fontSize3 mb-3">
                                    Upload brochures, itinerary PDFs or any other important documents for reference.
                                </p>

                                <div id="otherPolicyList">
                                    <?php
                                        $newPolicyStmt = $conn->prepare("
                                            SELECT *
                                            FROM request_details_policy_document
                                            WHERE request_id = :request_id
                                            ORDER BY id ASC
                                        ");

                                        $newPolicyStmt->execute([
                                            ':request_id' => $request_id
                                        ]);

                                        $newPolicies = $newPolicyStmt->fetchAll(PDO::FETCH_ASSOC);

                                        // Merge existing and newly added policies
                                        $allPolicies = array_merge(
                                            $policies ?? [],
                                            $newPolicies ?? []
                                        );
                                        $hasPolicies = false;

                                        foreach ($allPolicies as $doc):

                                            if (strcasecmp(trim($doc['title'] ?? ''), 'FAQ') === 0) {
                                                continue;
                                            }

                                            $hasPolicies = true;
                                    ?>

                                        <div class="policyItem"
                                            data-id="<?= (int)$doc['id'] ?>"
                                            data-existing="1">

                                            <div class="d-flex align-items-center gap-3">

                                                <div class="highlightIcon" style="background-color: #b2e0b1;">
                                                    <i class="ri-file-pdf-line text-success"></i>
                                                </div>

                                                <div>
                                                    <p class="mb-0 fw-semibold">
                                                        <?= htmlspecialchars($doc['title'] ?? '') ?>
                                                    </p>

                                                    <small class="text-muted">
                                                        <?= htmlspecialchars($doc['file_name'] ?? '') ?>
                                                    </small>
                                                </div>

                                            </div>

                                            <div class="d-flex align-items-center gap-2">

                                                <a
                                                    href="../../uploading/package_policy_attachments/<?= rawurlencode($doc['file_name']) ?>"
                                                    download
                                                    class="downloadBtn"
                                                    title="Download document">
                                                    <i class="ri-download-line"></i>
                                                </a>

                                                <button
                                                    type="button"
                                                    class="btn btn-link text-danger p-1 remove-file"
                                                    data-id="<?= (int)$doc['id'] ?>"
                                                    title="Remove document">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>

                                            </div>
                                        </div>

                                    <?php endforeach; ?>

                                    <?php if (!$hasPolicies): ?>
                                        <p class="text-muted mb-0" id="noOtherPolicy">
                                            No other policy documents available.
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <hr class="my-3">

                                <!-- Upload Area -->
                                <div class="upload-form-row">

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="documentTitle"
                                        placeholder="Enter Title">

                                    <div class="mini-drop-zone" id="dropZone">
                                        <i class="fa-solid fa-cloud-arrow-up me-2"></i>

                                        <span id="selectedFileText">
                                            Drag &amp; Drop or Click to Upload
                                        </span>

                                        <input
                                            type="file"
                                            id="fileInput"
                                            class="hidden-input"
                                            accept=".pdf,.doc,.docx">
                                    </div>

                                    <button
                                        type="button"
                                        class="btn btn-primary px-4"
                                        id="addDocumentBtn">
                                        Submit
                                    </button>

                                </div>

                                <small class="error-message" id="otherPolicy_error"></small>

                            </div>
                        </div>
                        <div id="faqs1" class="section-block">
                            <div class="card cardBackgroundColor rounded-3 p-3 cardShadow mb-0">
                                <h5 class="fw-bolder textDarkBlue">Cancellation Policy</h5>
                                <div class="row borderHighlight mx-0">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-3">
                                        <div class="text-center mb-2">
                                            <label for="mrpPerAdult" class="mb-0">Cancellation Before Travel</label>
                                        </div>
                                        <div class="inputFieldAlignment">
                                            <input type="number" value="" id="mrpPerAdult" placeholder="30+ Days" class="form-control inputWidth" readOnly>
                                            <input type="number" value="" id="mrpPerAdult" placeholder="15 - 30 Days" class="form-control inputWidth" readOnly>
                                            <input type="number" value="" id="mrpPerAdult" placeholder="7 - 15 Days" class="form-control inputWidth" readOnly>
                                            <input type="number" value="" id="mrpPerAdult" placeholder="0 - 7 Days" class="form-control inputWidth" readOnly>
                                            <input type="number" value="" id="mrpPerAdult" placeholder="No Show" class="form-control inputWidth" readOnly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-3">
                                        <div class="text-center mb-2">
                                            <label for="mrpPerChild" class="mb-0">Cancellation Charges</label>
                                        </div>
                                        <div class="inputFieldAlignment">
                                            <div class="input-group inputWidth">
                                                <input type="number" class="form-control" id="cancellationPercentage1" name="cancellationPercentage1" placeholder="0" value="<?= $cancel_policy['policy_1']??0 ?>">
                                                <span class="input-group-text">%</span>
                                                <small class="error-message" id="cancellationPercentage1_error"></small>
                                            </div>
                                            <div class="input-group inputWidth">
                                                <input type="number" class="form-control" id="cancellationPercentage2" name="cancellationPercentage2" placeholder="0" value="<?= $cancel_policy['policy_2']??0 ?>">
                                                <span class="input-group-text">%</span>
                                                <small class="error-message" id="cancellationPercentage2_error"></small>
                                            </div>
                                            <div class="input-group inputWidth">
                                                <input type="number" class="form-control" id="cancellationPercentage3" name="cancellationPercentage3" placeholder="0" value="<?= $cancel_policy['policy_3']??0 ?>">
                                                <span class="input-group-text">%</span>
                                                <small class="error-message" id="cancellationPercentage3_error"></small>
                                            </div>
                                            <div class="input-group inputWidth">
                                                <input type="number" class="form-control" id="cancellationPercentage4" name="cancellationPercentage4" placeholder="0" value="<?= $cancel_policy['policy_4']??0 ?>">
                                                <span class="input-group-text">%</span>
                                                <small class="error-message" id="cancellationPercentage4_error"></small>
                                            </div>
                                            <div class="input-group inputWidth">
                                                <input type="number" class="form-control" id="cancellationPercentage5" name="cancellationPercentage5" placeholder="0" value="<?= $cancel_policy['policy_5']??0 ?>">
                                                <span class="input-group-text">%</span>
                                                <small class="error-message" id="cancellationPercentage5_error"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-8">
                                <div id="markup1" class="section-block mt-4">
                                    <div class="card cardBackgroundColor rounded-3 p-3 cardShadow mb-0">

                                        <h5 class="fw-bolder textDarkBlue">MarkUp Calculation</h5>

                                        <div class="borderHighlight rounded-3 p-3">
                                            <?php if (in_array($upperChainId, [9, 10, 11, 13, 14, 15, 17, 18, 19, 21], true)) { ?>
                                            <!-- cu->tc->te/f->bm/mf/sf -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover align-middle mb-0 commission-incentive-table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="fs-6">Designation</th>
                                                            <th class="fs-6">Name</th>
                                                            <th class="fs-6">ID</th>
                                                            <th class="fs-6">Commission (₹)</th>
                                                            <th class="fs-6">Incentive (₹)</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <!-- BM | SF | M ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">BM | SF | M</td>

                                                            <td>
                                                                <span id="bmMfSfName" class="fs-6">
                                                                    <?= htmlspecialchars(
                                                                        $chainDetails[
                                                                            (in_array('TE', array_column($chainDetails, 'prefix')) ||
                                                                            in_array('CA', array_column($chainDetails, 'prefix'))) ? 3 : 2
                                                                        ]['name'] ?? 'NA',
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ) ?>
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <span id="bmMfSfId" class="fs-6">
                                                                    <?= htmlspecialchars(
                                                                        $chainDetails[
                                                                            (in_array('TE', array_column($chainDetails, 'prefix')) ||
                                                                            in_array('CA', array_column($chainDetails, 'prefix'))) ? 3 : 2
                                                                        ]['id'] ?? 'NA',
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ) ?>
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="bmMfSfC"
                                                                    name="bm_mf_sf_c"
                                                                    value="<?= $packagePricingMarkup['bm_direct_commission']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="bmMfSfI"
                                                                    name="bm_mf_sf_i"
                                                                    value="<?= $packagePricingMarkup['bm_incentive']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>

                                                        <!-- TE / F ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">TE / F</td>

                                                            <td>
                                                                <span id="teFName" class="fs-6">
                                                                    <?= htmlspecialchars(
                                                                        (in_array('TE', array_column($chainDetails, 'prefix')) ||
                                                                        in_array('CA', array_column($chainDetails, 'prefix')))
                                                                            ? ($chainDetails[2]['name'] ?? 'NA')
                                                                            : 'NA',
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ) ?>
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <span id="teFId" class="fs-6">
                                                                    <?= htmlspecialchars(
                                                                        (in_array('TE', array_column($chainDetails, 'prefix')) ||
                                                                        in_array('CA', array_column($chainDetails, 'prefix')))
                                                                            ? ($chainDetails[2]['id'] ?? 'NA')
                                                                            : 'NA',
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ) ?>
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="teFC"
                                                                    name="te_f_c"
                                                                    value="<?= $packagePricingMarkup['ca_direct_commission']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="teFI"
                                                                    name="te_f_i"
                                                                    value="<?= $packagePricingMarkup['ca_incentive']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>

                                                        <!-- TC ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">TC</td>

                                                            <td>
                                                                <span id="tcName" class="fs-6">
                                                                    <?= htmlspecialchars($chainDetails[1]['name'] ?? 'NA', ENT_QUOTES, 'UTF-8') ?>
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <span id="tcId" class="fs-6">
                                                                    <?= htmlspecialchars($chainDetails[1]['id'] ?? 'NA', ENT_QUOTES, 'UTF-8') ?>
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="tcCommission"
                                                                    name="tc_commission"
                                                                    value="<?= $packagePricingMarkup['ta_markup'] ?? 0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td class="text-center">—</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php } elseif (in_array($upperChainId, [12, 16, 20], true)) { ?>
                                            <!-- cu->tc->te/f->ste->ete->cte -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover align-middle mb-0 commission-incentive-table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="fs-6">Designation</th>
                                                            <th class="fs-6">Name</th>
                                                            <th class="fs-6">ID</th>
                                                            <th class="fs-6">Commission (₹)</th>
                                                            <th class="fs-6">Incentive (₹)</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <!-- CTE ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">CTE</td>

                                                            <td>
                                                                <span id="bmMfSfName" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="bmMfSfId" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="bmMfSfC"
                                                                    name="bm_mf_sf_c"
                                                                    value="<?= $packagePricingTeChain['cte_direct_commission']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="bmMfSfI"
                                                                    name="bm_mf_sf_i"
                                                                    value="<?= $packagePricingTeChain['cte_incentive']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>
                                                        <!-- ETE ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">ETE</td>

                                                            <td>
                                                                <span id="bmMfSfName" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="bmMfSfId" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="bmMfSfC"
                                                                    name="bm_mf_sf_c"
                                                                    value="<?= $packagePricingTeChain['ete_direct_commission']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="bmMfSfI"
                                                                    name="bm_mf_sf_i"
                                                                    value="<?= $packagePricingTeChain['ete_incentive']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>
                                                        <!-- STE ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">STE</td>

                                                            <td>
                                                                <span id="bmMfSfName" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="bmMfSfId" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="bmMfSfC"
                                                                    name="bm_mf_sf_c"
                                                                    value="<?= $packagePricingTeChain['ste_direct_commission']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="bmMfSfI"
                                                                    name="bm_mf_sf_i"
                                                                    value="<?= $packagePricingTeChain['ste_incentive']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>
                                                        <!-- TE / F ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">TE / F</td>

                                                            <td>
                                                                <span id="teFName" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="teFId" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="teFC"
                                                                    name="te_f_c"
                                                                    value="<?= $packagePricingTeChain['te_direct_commission']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="teFI"
                                                                    name="te_f_i"
                                                                    value="<?= $packagePricingTeChain['te_incentive']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>
                                                        <!-- TC ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">TC</td>

                                                            <td>
                                                                <span id="tcName" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="tcId" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="tcCommission"
                                                                    name="tc_commission"
                                                                    value="<?= $packagePricingTeChain['ta_markup'] ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td class="text-center">—</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php } if (in_array($upperChainId, [1, 2, 3, 5, 6, 7,4, 8], true)) { ?>
                                            <h5 class="mb-3 fw-bolder" id="#">Institution Slab</h5>
                                            <table class="table table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col">Range</th>
                                                        <th scope="col">Commission Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="commissionTableBody">
                                                    
                                                </tbody>
                                            </table>
                                            <?php } if (in_array($upperChainId, [1, 2, 3, 5, 6, 7], true)) { ?>
                                            <!-- cu->ibr->i->bm/mf/sf -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover align-middle mb-0 commission-incentive-table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="fs-6">Designation</th>
                                                            <th class="fs-6">Name</th>
                                                            <th class="fs-6">ID</th>
                                                            <th class="fs-6">Commission (₹)</th>
                                                            <th class="fs-6">Incentive (₹)</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <!-- BM | SF | M ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">BM | SF | M</td>

                                                            <td>
                                                                <span id="bmMfSfName" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="bmMfSfId" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="bmMfSfC"
                                                                    name="bm_mf_sf_c"
                                                                    value="<?= $packagePricingInstitution['bm_direct_commission']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="bmMfSfI"
                                                                    name="bm_mf_sf_i"
                                                                    value="<?= $packagePricingInstitution['bm_incentive']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>
                                                        <!-- I ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">I</td>

                                                            <td>
                                                                <span id="teFName" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="teFId" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="teFC"
                                                                    name="te_f_c"
                                                                    value="<?= $packagePricingInstitution['ins_markup']??0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>-
                                                                <!-- <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="teFI"
                                                                    name="te_f_i"
                                                                    value="0.00"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                > -->
                                                            </td>
                                                        </tr>
                                                        <!-- TC ROW -->
                                                        <!-- <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">TC</td>

                                                            <td>
                                                                <span id="tcName" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="tcId" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="tcCommission"
                                                                    name="tc_commission"
                                                                    value="0.00"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td class="text-center">—</td>
                                                        </tr> -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php } else if (in_array($upperChainId, [4, 8], true)) { ?>
                                            <!-- cu->Ibr->i->ete->cte -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover align-middle mb-0 commission-incentive-table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="fs-6">Designation</th>
                                                            <th class="fs-6">Name</th>
                                                            <th class="fs-6">ID</th>
                                                            <th class="fs-6">Commission (₹)</th>
                                                            <th class="fs-6">Incentive (₹)</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <!-- CTE ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">CTE</td>

                                                            <td>
                                                                <span id="bmMfSfName" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="bmMfSfId" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="bmMfSfC"
                                                                    name="bm_mf_sf_c"
                                                                    value="<?= $packagePricingTechnoInstitution['cte_direct_commission'] ?? 0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="bmMfSfI"
                                                                    name="bm_mf_sf_i"
                                                                    value="<?= $packagePricingTechnoInstitution['cte_incentive'] ?? 0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>
                                                        <!-- ETE ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">ETE</td>

                                                            <td>
                                                                <span id="bmMfSfName"></span>
                                                            </td>

                                                            <td>
                                                                <span id="bmMfSfId">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="bmMfSfC"
                                                                    name="bm_mf_sf_c"
                                                                    value="<?= $packagePricingTechnoInstitution['ete_direct_commission'] ?? 0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="bmMfSfI"
                                                                    name="bm_mf_sf_i"
                                                                    value="<?= $packagePricingTechnoInstitution['ete_incentive'] ?? 0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>
                                                        </tr>
                                                        <!-- I ROW -->
                                                        <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">I</td>

                                                            <td>
                                                                <span id="teFName" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="teFId" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="teFC"
                                                                    name="te_f_c"
                                                                    value="<?= $packagePricingTechnoInstitution['ins_markup'] ?? 0.00 ?>"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td>-
                                                                <!-- <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="teFI"
                                                                    name="te_f_i"
                                                                    value="0.00"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                > -->
                                                            </td>
                                                        </tr>
                                                        <!-- TC ROW -->
                                                        <!-- <tr>
                                                            <td class="fw-semibold textDarkBlue fs-6">TC</td>

                                                            <td>
                                                                <span id="tcName" class="fs-6"></span>
                                                            </td>

                                                            <td>
                                                                <span id="tcId" class="fs-6">-</span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    class="form-control pricing-markup-input"
                                                                    id="tcCommission"
                                                                    name="tc_commission"
                                                                    value="0.00"
                                                                    min="0"
                                                                    step="1"
                                                                    placeholder="0.00"
                                                                >
                                                            </td>

                                                            <td class="text-center">—</td>
                                                        </tr> -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php } ?>
                                            <hr>

                                            <!-- COUPON ADJUSTMENT AND COMPANY -->
                                            <div class="row g-3 mb-3">
                                                <div class="col-lg-6 col-md-6">
                                                    <label for="couponAdjustment" class="form-label fw-semibold">
                                                        Coupon Adjustment (₹)
                                                    </label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id="couponAdjustment"
                                                        name="coupon_adjustment"
                                                        value="<?= $packagePricing['coupon_adjustment'] ??0.00?>"
                                                        min="0"
                                                        step="1"
                                                        placeholder="0.00"
                                                    >
                                                    <small class="error-message" id="couponAdjustment_error"></small>
                                                </div>

                                                <div class="col-lg-6 col-md-6">
                                                    <label for="companyAmount" class="form-label fw-semibold">
                                                        Company (₹)
                                                    </label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id="companyAmount"
                                                        name="company_amount"
                                                        value="<?= $packagePricingMarkup['company'] ??0.00?>"
                                                        min="0"
                                                        step="1"
                                                        placeholder="0.00"
                                                    >
                                                    <small class="error-message" id="companyAmount_error"></small>
                                                </div>
                                            </div>

                                            <!-- SUSPENSE -->
                                            <div class="row g-3 mb-3">
                                                <div class="col-lg-6 col-md-6">
                                                    <label for="suspenseAmount" class="form-label fw-semibold">
                                                        Suspense (₹)
                                                    </label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id="suspenseAmount"
                                                        name="suspense_amount"
                                                        value="<?= $suspenseAmount ?? 0.00 ?>"
                                                        min="0"
                                                        step="1"
                                                        placeholder="0.00"
                                                    >
                                                    <small class="error-message" id="suspenseAmount_error"></small>
                                                </div>
                                            </div>

                                            <!-- CUSTOMER AMOUNTS -->
                                            <div class="row g-3 mb-3">
                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <label for="customer1Amount" class="form-label fw-semibold">
                                                        L1 Customer (₹)
                                                    </label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id="customer1Amount"
                                                        name="customer_1_amount"
                                                        value="<?= $customerCom1 ?? 0.00 ?>"
                                                        min="0"
                                                        step="1"
                                                    >
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <label for="customer2Amount" class="form-label fw-semibold">
                                                        L2 Customer (₹)
                                                    </label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id="customer2Amount"
                                                        name="customer_2_amount"
                                                        value="<?= $customerCom2 ?? 0.00 ?>"
                                                        min="0"
                                                        step="1"
                                                    >
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <label for="customer3Amount" class="form-label fw-semibold">
                                                        L3 Customer (₹)
                                                    </label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id="customer3Amount"
                                                        name="customer_3_amount"
                                                        value="<?= $customerCom3 ?? 0.00 ?>"
                                                        min="0"
                                                        step="1"
                                                    >
                                                </div>
                                            </div>

                                            <hr>

                                            <!-- NET PRICE -->
                                            <div class="row g-3">

                                                <div class="col-lg-6 col-md-6">
                                                    <label for="netPriceAdult" class="form-label fw-semibold">
                                                        Net Price - Adult (₹)
                                                    </label>

                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id="netPriceAdult"
                                                        name="net_price_adult"
                                                        value="<?= htmlspecialchars($packagePricing['net_price_adult'] ?? 0) ?>"
                                                        min="0"
                                                        step="1"
                                                    >

                                                    <small class="text-muted d-block" id="netPriceAdult_original"></small>
                                                    <small class="fw-semibold d-block mt-1" id="netPriceAdult_difference"></small>

                                                    <small class="error-message" id="netPriceAdult_error"></small>
                                                </div>

                                                <div class="col-lg-6 col-md-6">
                                                    <label for="netPriceChild" class="form-label fw-semibold">
                                                        Net Price - Child (₹)
                                                    </label>

                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id="netPriceChild"
                                                        name="net_price_child"
                                                        value="<?= htmlspecialchars($packagePricing['net_price_child'] ?? 0) ?>"
                                                        min="0"
                                                        step="1"
                                                    >

                                                    <small class="text-muted d-block" id="netPriceChild_original"></small>
                                                    <small class="fw-semibold d-block mt-1" id="netPriceChild_difference"></small>

                                                    <small class="error-message" id="netPriceChild_error"></small>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card cardShadow section-block mt-4">
                                    <div class="quick-header p-3">
                                        <div class="d-flex gap-2">
                                            <i class="fa-solid fa-file-contract fa-xl align-content-center quickIcon"></i>
                                            <h5 class="fw-bold mb-0 textDarkBlue align-content-center">Revised Quotation</h5>
                                        </div>
                                    </div>
                                    <div class="p-3 pb-0" id="CustDiscountedPriceDetails">
                                        <p class="mb-2 fw-bold blueDiv">Customer Applied Discount Details</p>
                                        <div class="d-flex justify-content-between align-items-center px-3 pb-2">
                                            <p class="fontSize10 discountGreen fw-bold mb-0">
                                                <i class="ri-price-tag-3-line"></i>
                                                Discounts (Coupon)
                                            </p>
                                            <p class="fontSize10 discountGreen fw-bold text-end mb-0" id="CustCouponDiscount">- ₹ <?= $requestData['coupon_discount'] ?></p>
                                        </div>
                                        <?php if($requestData['referral_wallet_amount'] != 0){
                                        ?>
                                        <div class="d-flex justify-content-between align-items-center px-3 pb-2">
                                            <p class="fontSize10 discountGreen fw-bold mb-0">
                                                <i class="ri-wallet-3-line"></i>
                                                Reference Wallet
                                            </p>
                                            <p class="fontSize10 discountGreen fw-bold text-end mb-0" id="CustReferenceWallet">- ₹ <?= $requestData['referral_wallet_amount'] ?></p>
                                        </div>
                                        <?php } if ($requestData['discount_wallet_amount'] != 0) {?>
                                            <div class="d-flex justify-content-between align-items-center px-3 pb-2">
                                                <p class="fontSize10 discountGreen fw-bold mb-0">
                                                    <i class="ri-wallet-3-line"></i>
                                                    Discount Wallet
                                                </p>
                                                <p class="fontSize10 discountGreen fw-bold text-end mb-0" id="CustDiscountWallet">- ₹ <?= $requestData['discount_wallet_amount'] ?></p>
                                            </div>
                                        <?php } ?>
                                        <hr class="my-1 border border-2 mx-0">

                                        <div class="d-flex justify-content-between">
                                            <p class="fw-bold fs-5 textDarkBlue mb-0">Subtotal</p>
                                            <p class="fontSize13 fs-5 fw-bold textDarkBlue mb-0" id="CustDiscountedPriceSubTotal">
                                                &#8377; 0
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Discounted Price Details -->
                                    <div class="p-3 pb-0" id="discountedPriceDetails">
                                        <p class="mb-2 fw-bold blueDiv">Discounted Price Details</p>

                                        <div id="discountedAdjustmentRows" class="d-flex flex-column">
                                            <!-- Discount rows will be added dynamically here -->
                                        </div>

                                        <hr class="my-1 border border-2 mx-0">

                                        <div class="d-flex justify-content-between">
                                            <p class="fw-bold fs-5 textDarkBlue mb-0">Subtotal</p>
                                            <p class="fontSize13 fs-5 fw-bold textDarkBlue mb-0" id="discountedSubTotal">
                                                &#8377; 0
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Additional Price Details -->
                                    <div class="p-3 pb-0" id="additionalPriceDetails">
                                        <p class="mb-2 fw-bold blueDiv">Additional Price Details</p>

                                        <div id="additionalAdjustmentRows" class="d-flex flex-column">
                                            <!-- Additional price rows will be added dynamically here -->
                                        </div>

                                        <hr class="my-1 border border-2 mx-0">

                                        <div class="d-flex justify-content-between">
                                            <p class="fw-bold fs-5 textDarkBlue mb-0">Subtotal</p>
                                            <p class="fontSize13 fs-5 fw-bold textDarkBlue mb-0" id="additionalSubTotal">
                                                &#8377; 0
                                            </p>
                                        </div>
                                    </div>
                                    <hr class="my-2 border border-2 mx-3">
                                    <div class="p-3" id="finalQuotedPriceDetails">
                                        <p class="fw-bold blueDiv">Final Quoted Price</p>

                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="mb-1" id="netPriceAdjustmentLabel">No Price Adjustment</p>
                                                <p class="mb-1">Final Quoted Price</p>
                                            </div>

                                            <div>
                                                <p class="mb-1 text-end fw-bold" id="netPriceAdjustment">
                                                    &#8377; 0.00
                                                </p>

                                                <p class="mb-1 text-end fw-bold" id="finalQuotedPrice">
                                                    &#8377; 0.00
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="p-3">
                                        <p class="fw-bold blueDiv">Adjustments</p>

                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="mb-1">Convenience Fee</p>
                                                <p class="mb-1" id="quoteGst">GST (<?= $requestData['gst_percentage'] ?>%)</p>
                                            </div>

                                            <div>
                                                <p class="mb-1 text-end" id="quoteConvenienceFee">
                                                    &#8377; <?= number_format((float)$requestData['convenience_fee'], 2) ?>
                                                </p>

                                                <p class="mb-1 text-end" id="quoteGstAmount">
                                                    &#8377; <?= number_format((float)$requestData['gst'], 2) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-1 border border-2 mx-3">

                                    <div class="p-3 pb-0">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fs-5 textDarkBlue fw-bold">Total Estimated Price</p>
                                            </div>

                                            <div>
                                                <p class="fs-5 text-danger fw-bolder text-end" id="estimatedFinalPackagePrice">
                                                    &#8377; <?= number_format((float)$requestData['final_price'], 2) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 pb-2">
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" name="submit_quote" id="submitQuoteBtn"
                                                class="btn btn-primary px-4">
                                                <i class="fa-solid fa-paper-plane me-2"></i>
                                                Submit Quote
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- Card Section 2 subsection 6 End -->
            </div>
        </div>
    </div>

<?php endif; ?>

