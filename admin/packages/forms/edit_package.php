<?php

require '../../connect.php';

date_default_timezone_set('Asia/Calcutta');

$today = date('Y-m-d H:i:s');

$response = false;

if (!isset($_POST['payload'])) {

    exit("Invalid Request");

}

$mydata = json_decode($_POST['payload'], true);

if (!$mydata) {

    exit("Invalid Payload");

}
$get_id = isset($mydata['package_id'])
    ? (int)$mydata['package_id']
    : 0;

if ($get_id <= 0) {
    exit(json_encode([
        "status"=>false,
        "message"=>"Invalid Package ID"
    ]));
}

$stmt = $conn->prepare("
    SELECT id
    FROM package
    WHERE id=?
    LIMIT 1
");

$stmt->execute([$get_id]);

if(!$stmt->fetch(PDO::FETCH_ASSOC)){
    exit(json_encode([
        "status"=>false,
        "message"=>"Package not found."
    ]));
}

/*
|--------------------------------------------------------------------------
| IMPORTANT
|--------------------------------------------------------------------------
|
| Since you're now sending FormData:
|
| formData.append("payload", JSON.stringify(payLoadData));
|
| DO NOT use php://input anymore.
|
*/

if (!isset($_POST['payload'])) {

    exit("Invalid Request");

}

$mydata = json_decode($_POST['payload'], true);

if (!$mydata) {

    exit("Invalid Payload");

}

/*
|--------------------------------------------------------------------------
| Uploaded files tracker
|--------------------------------------------------------------------------
|
| Used so if rollback happens we delete uploaded files.
|
*/
function amount($value)
{
    preg_match('/-?\d+(?:\.\d+)?/', str_replace(',', '', $value), $match);
    return $match[0] ?? 0;
}

$uploadedFiles = [];

try {

    $conn->beginTransaction();

    /*
    |--------------------------------------------------------------------------
    | Package Insert
    |--------------------------------------------------------------------------
    */
    if (!empty($mydata['general_info'])) {
        $sql = "
            UPDATE package
            SET
                category_id            = :category_id,
                sub_category_id        = :sub_category_id,
                package_type           = :package_type,
                category_hotel_id      = :category_hotel_id,
                category_occupancy_id  = :category_occupancy_id,
                category_meal_id       = :category_meal_id,
                name                   = :name,
                unique_code            = :unique_code,
                description            = :description,
                detailed_description   = :detailed_description,
                package_keywords       = :package_keywords,
                destination            = :destination,
                location               = :location,
                travel_from            = :travel_from,
                travel_to              = :travel_to,
                sightseeing_type       = :sightseeing_type,
                validity               = :validity,
                tour_days              = :tour_days,
                cities                 = :cities,
                best_season            = :best_season,
                highlight_type         = :highlight_type,
                drop_price_status      = :drop_price_status,
                drop_price_amount      = :drop_price_amount,
                language_type          = :language_type,
                visa_required          = :visa_required,
                category_vehicle_id    = :category_vehicle_id
            WHERE id = :package_id
        ";

        $statement = $conn->prepare($sql);

        $statement->execute([
            ":package_id" => $mydata['package_id'],

            ":category_id" => $mydata['general_info']['categoryId'],

            ":sub_category_id" => $mydata['general_info']['subCategoryId'],

            ":package_type" => $mydata['general_info']['travelTheme'],

            ":category_hotel_id" => $mydata['extra_info']['categoryHotelId'],

            ":category_occupancy_id" => $mydata['extra_info']['occupancyId'],

            ":category_meal_id" => $mydata['extra_info']['categoryMealId'],

            ":name" => $mydata['general_info']['packName'],

            ":unique_code" => $mydata['general_info']['uniqueCode'],

            ":description" => $mydata['general_info']['description'],

            ":detailed_description" => $mydata['general_info']['descriptionDetail'],

            ":package_keywords" => json_encode($mydata['extra_info']['packageKeywords']),

            ":destination" => $mydata['extra_info']['destination'],

            ":location" => $mydata['general_info']['pacLocation'],

            ":travel_from" => $mydata['extra_info']['travelFrom'],

            ":travel_to" => $mydata['extra_info']['travelTo'],

            ":sightseeing_type" => $mydata['extra_info']['sightseeingType'],

            ":validity" => $mydata['general_info']['pacValidity'],

            ":tour_days" => $mydata['general_info']['tourDays'],

            ":cities" => json_encode($mydata['general_info']['cities']),

            ":best_season" => $mydata['general_info']['season'],

            ":highlight_type" => $mydata['general_info']['packageType'],

            ":drop_price_status" => $mydata['general_info']['dropPriceCheck'],

            ":drop_price_amount" => $mydata['general_info']['dropPrice'],

            ":language_type" => $mydata['extra_info']['languageType'],

            ":visa_required" => $mydata['general_info']['visaType'],

            ":category_vehicle_id" => $mydata['extra_info']['vehicleId']

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | NEVER DO SELECT ORDER BY ID DESC
    |--------------------------------------------------------------------------
    */

    $get_id = (int)$mydata['package_id'];
    /*
    |--------------------------------------------------------------------------
    | Package Itinerary Details
    |--------------------------------------------------------------------------
    */

    if (!empty($mydata['itinerary'])) {

        $sql = "
            UPDATE package_itinerary_details
            SET
                inclusion   = :inclusion,
                exclusion   = :exclusion,
                remark      = :remark,
                travel_info = :travel_info,
                highlights  = :highlights
            WHERE package_id = :package_id
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([

            ':package_id'  => $get_id,

            ':inclusion'   => json_encode($mydata['itinerary']['inclusions'] ?? []),

            ':exclusion'   => json_encode($mydata['itinerary']['exclusions'] ?? []),

            ':remark'      => json_encode($mydata['itinerary']['remarks'] ?? []),

            ':travel_info' => json_encode($mydata['itinerary']['thingsToKnow'] ?? []),

            ':highlights'  => json_encode($mydata['itinerary']['highlights'] ?? [])

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Package Trip Days
    |--------------------------------------------------------------------------
    */

    if (!empty($mydata['itinerary']['days'])) {

        // Remove existing itinerary days
        $stmt = $conn->prepare("
            DELETE FROM package_trip_days
            WHERE package_id = :package_id
        ");

        $stmt->execute([
            ':package_id' => $get_id
        ]);

        // Insert updated days
        $sql = "
            INSERT INTO package_trip_days
            (
                package_id,
                day_id,
                title,
                day_details,
                meal_plan,
                day_tansport,
                stay
            )
            VALUES
            (
                :package_id,
                :day_id,
                :title,
                :day_details,
                :meal_plan,
                :day_tansport,
                :stay
            )
        ";

        $stmt = $conn->prepare($sql);

        foreach ($mydata['itinerary']['days'] as $day) {

            $stmt->execute([

                ':package_id'   => $get_id,

                ':day_id'       => $day['day'],

                ':title'        => $day['title'] ?? '',

                ':day_details'  => $day['description'] ?? '',

                ':meal_plan'    => $day['meals'] ?? '',

                ':day_tansport' => $day['transport'] ?? '',

                ':stay'         => $day['stay'] ?? ''

            ]);
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Package Pricing
    |--------------------------------------------------------------------------
    */

    if (!empty($mydata['pricing'])) {

        $sql = "
            UPDATE package_pricing
            SET
                net_price_adult               = :net_price_adult,
                net_price_child               = :net_price_child,
                net_price_adult_with_GST      = :net_price_adult_with_GST,
                net_price_child_with_GST      = :net_price_child_with_GST,
                total_package_price_per_adult = :total_package_price_per_adult,
                total_package_price_per_child = :total_package_price_per_child,
                extra_mattress                = :extra_mattress,
                coupon_adjustment             = :coupon_adjustment,
                guest_amount                  = :guest_amount,
                guest_percentage              = :guest_percentage
            WHERE package_id = :package_id
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([

            ':package_id'                    => $get_id,

            ':net_price_adult'               => $mydata['pricing']['netPriceAdult'],

            ':net_price_child'               => $mydata['pricing']['netPriceChild'],

            ':net_price_adult_with_GST'      => $mydata['pricing']['mrpPerAdult'],

            ':net_price_child_with_GST'      => $mydata['pricing']['mrpPerChild'],

            ':total_package_price_per_adult' => $mydata['pricing']['mrpPerAdultGst'],

            ':total_package_price_per_child' => $mydata['pricing']['mrpPerChildGst'],

            ':extra_mattress'                => $mydata['pricing']['extraMatress'],

            ':coupon_adjustment'             => $mydata['pricing']['couponAdjustment'],

            ':guest_amount'                  => $mydata['pricing']['guestAmount']??0.00,

            ':guest_percentage'              => $mydata['pricing']['guestPercentage']??0

        ]);

    }
    /*
    |--------------------------------------------------------------------------
    | Package Pricing Markup
    |--------------------------------------------------------------------------
    */

    if (!empty($mydata['pricing']['travelConsultant'])) {
        // bm/mf/sf->te/f
        $sql = "
            UPDATE package_pricing_markup
            SET
                company                 = :company,
                customer                = :customer,
                ta_markup               = :ta_markup,
                ca_mark_up_total        = :ca_mark_up_total,
                ca_direct_commission    = :ca_direct_commission,
                ca_incentive            = :ca_incentive,
                bm_mark_up_total        = :bm_mark_up_total,
                bm_direct_commission    = :bm_direct_commission,
                bm_incentive            = :bm_incentive,
                prime_customer          = :prime_customer,
                L1_customer             = :L1_customer,
                L2_customer             = :L2_customer,
                total_mark_up           = :total_mark_up,
                total_commission_amount = :total_commission_amount,
                total_incentive_amount  = :total_incentive_amount,
                coupon_amount           = :coupon_amount,
                suspense                = :suspense
            WHERE package_id = :package_id
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([

            ':package_id' => $get_id,

            ':company' => amount($mydata['pricing']['companyMarkup']),

            ':customer' => amount($mydata['pricing']['totalCustomerShare']),

            ':ta_markup' => amount($mydata['pricing']['travelConsultant']),

            ':ca_mark_up_total' => amount($mydata['pricing']['teBmComInsTotal']),

            ':ca_direct_commission' => amount($mydata['pricing']['teBmComm']),

            ':ca_incentive' => amount($mydata['pricing']['teBmIns']),

            ':bm_mark_up_total' => amount($mydata['pricing']['teBmComInsTotal']),

            ':bm_direct_commission' => amount($mydata['pricing']['bmTeComm']),

            ':bm_incentive' => amount($mydata['pricing']['bmTeIns']),

            ':prime_customer' => amount($mydata['pricing']['customer1']),

            ':L1_customer' => amount($mydata['pricing']['customer2']),

            ':L2_customer' => amount($mydata['pricing']['customer3']),

            ':total_mark_up' => amount($mydata['pricing']['bmTeChainCommInsTotal']),

            ':total_commission_amount' => amount($mydata['pricing']['bmTeChainCommTotal']),

            ':total_incentive_amount' => amount($mydata['pricing']['bmTeChainInsTotal']),

            ':coupon_amount' => amount($mydata['pricing']['couponAdjustment']),

            ':suspense' => amount($mydata['pricing']['bmSuspence'])

        ]);
        // cte->ete->ste->te
        $sql = "
            UPDATE package_pricing_markup_te_chain
            SET
                company                 = :company,
                customer                = :customer,
                ta_markup               = :ta_markup,
                te_mark_up_total        = :te_mark_up_total,
                te_direct_commission    = :te_direct_commission,
                te_incentive            = :te_incentive,
                ete_mark_up_total       = :ete_mark_up_total,
                ete_direct_commission   = :ete_direct_commission,
                ete_incentive           = :ete_incentive,
                ste_mark_up_total       = :ste_mark_up_total,
                ste_direct_commission   = :ste_direct_commission,
                ste_incentive           = :ste_incentive,
                cte_mark_up_total       = :cte_mark_up_total,
                cte_direct_commission   = :cte_direct_commission,
                cte_incentive           = :cte_incentive,
                prime_customer          = :prime_customer,
                L1_customer             = :L1_customer,
                L2_customer             = :L2_customer,
                total_mark_up           = :total_mark_up,
                total_commission_amount = :total_commission_amount,
                total_incentive_amount  = :total_incentive_amount,
                coupon_amount           = :coupon_amount,
                suspense                = :suspense
            WHERE package_id = :package_id
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([

            ':package_id' => $get_id,

            ':company' => amount($mydata['pricing']['companyMarkup']),

            ':customer' => amount($mydata['pricing']['totalCustomerShare']),

            ':ta_markup' => amount($mydata['pricing']['travelConsultant']),

            ':te_mark_up_total' => amount($mydata['pricing']['cTeFCommInsTotal']),

            ':te_direct_commission' => amount($mydata['pricing']['cTeFComm']),

            ':te_incentive' => amount($mydata['pricing']['cTeFIns']),

            ':ete_mark_up_total' => amount($mydata['pricing']['eteCommInsTotal']),

            ':ete_direct_commission' => amount($mydata['pricing']['eteComm']),

            ':ete_incentive' => amount($mydata['pricing']['eteIns']),

            ':ste_mark_up_total' => amount($mydata['pricing']['steCommInsTotal']),

            ':ste_direct_commission' => amount($mydata['pricing']['steComm']),

            ':ste_incentive' => amount($mydata['pricing']['steIns']),

            ':cte_mark_up_total' => amount($mydata['pricing']['cteCommInsTotal']),

            ':cte_direct_commission' => amount($mydata['pricing']['cteComm']),

            ':cte_incentive' => amount($mydata['pricing']['cteIns']),

            ':prime_customer' => amount($mydata['pricing']['customer1']),

            ':L1_customer' => amount($mydata['pricing']['customer2']),

            ':L2_customer' => amount($mydata['pricing']['customer3']),

            ':total_mark_up' => amount($mydata['pricing']['cteChainCommTotal']),

            ':total_commission_amount' => amount($mydata['pricing']['cteChainCommInsTotal']),

            ':total_incentive_amount' => amount($mydata['pricing']['cteChainInsTotal']),

            ':coupon_amount' => amount($mydata['pricing']['couponAdjustment']),

            ':suspense' => amount($mydata['pricing']['cteSuspence'])

        ]);

        // cte->ete->i
        // Check if record exists
        $checkStmt = $conn->prepare("
            SELECT COUNT(*)
            FROM package_pricing_markup_techno_institution
            WHERE package_id = ?
        ");
        $checkStmt->execute([$get_id]);

        $exists = $checkStmt->fetchColumn() > 0;

        if ($exists) {

            // UPDATE
            $sql = "
                UPDATE package_pricing_markup_techno_institution
                SET
                    company                 = :company,
                    customer                = :customer,
                    ins_markup              = :ins_markup,
                    ete_mark_up_total       = :ete_mark_up_total,
                    ete_direct_commission   = :ete_direct_commission,
                    ete_incentive           = :ete_incentive,
                    cte_mark_up_total       = :cte_mark_up_total,
                    cte_direct_commission   = :cte_direct_commission,
                    cte_incentive           = :cte_incentive,
                    prime_customer          = :prime_customer,
                    L1_customer             = :L1_customer,
                    L2_customer             = :L2_customer,
                    total_mark_up           = :total_mark_up,
                    total_commission_amount = :total_commission_amount,
                    total_incentive_amount  = :total_incentive_amount,
                    coupon_amount           = :coupon_amount,
                    suspense                = :suspense
                WHERE package_id = :package_id
            ";

        } else {

            // INSERT
            $sql = "
                INSERT INTO package_pricing_markup_techno_institution (
                    package_id,
                    company,
                    customer,
                    ins_markup,
                    ete_mark_up_total,
                    ete_direct_commission,
                    ete_incentive,
                    cte_mark_up_total,
                    cte_direct_commission,
                    cte_incentive,
                    prime_customer,
                    L1_customer,
                    L2_customer,
                    total_mark_up,
                    total_commission_amount,
                    total_incentive_amount,
                    coupon_amount,
                    suspense
                ) VALUES (
                    :package_id,
                    :company,
                    :customer,
                    :ins_markup,
                    :ete_mark_up_total,
                    :ete_direct_commission,
                    :ete_incentive,
                    :cte_mark_up_total,
                    :cte_direct_commission,
                    :cte_incentive,
                    :prime_customer,
                    :L1_customer,
                    :L2_customer,
                    :total_mark_up,
                    :total_commission_amount,
                    :total_incentive_amount,
                    :coupon_amount,
                    :suspense
                )
            ";

        }

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':package_id' => $get_id,

            ':company' => amount($mydata['pricing']['companyMarkup']),
            ':customer' => amount($mydata['pricing']['totalCustomerShare']),
            ':ins_markup' => amount($mydata['pricing']['cteIComm']),
            ':ete_mark_up_total' => amount($mydata['pricing']['iEteCommInsTotal']),
            ':ete_direct_commission' => amount($mydata['pricing']['iEteComm']),
            ':ete_incentive' => amount($mydata['pricing']['iEteIns']),
            ':cte_mark_up_total' => amount($mydata['pricing']['iCteCommInsTotal']),
            ':cte_direct_commission' => amount($mydata['pricing']['iCteComm']),
            ':cte_incentive' => amount($mydata['pricing']['iCteIns']),
            ':prime_customer' => amount($mydata['pricing']['customer1']),
            ':L1_customer' => amount($mydata['pricing']['customer2']),
            ':L2_customer' => amount($mydata['pricing']['customer3']),
            ':total_mark_up' => amount($mydata['pricing']['iCteComInsTotal']),
            ':total_commission_amount' => amount($mydata['pricing']['iCteComTotal']),
            ':total_incentive_amount' => amount($mydata['pricing']['iCteInsTotal']),
            ':coupon_amount' => amount($mydata['pricing']['couponAdjustment']),
            ':suspense' => amount($mydata['pricing']['cteISuspence'])
        ]);
        // bm/mf/sf->i
        $sql = "
            UPDATE package_pricing_markup_institution
            SET
                company                 = :company,
                customer                = :customer,
                ins_markup              = :ins_markup,
                bm_mark_up_total        = :bm_mark_up_total,
                bm_direct_commission    = :bm_direct_commission,
                bm_incentive            = :bm_incentive,
                prime_customer          = :prime_customer,
                L1_customer             = :L1_customer,
                L2_customer             = :L2_customer,
                total_mark_up           = :total_mark_up,
                total_commission_amount = :total_commission_amount,
                total_incentive_amount  = :total_incentive_amount,
                coupon_amount           = :coupon_amount,
                suspense                = :suspense
            WHERE package_id = :package_id
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([

            ':package_id' => $get_id,

            ':company' => amount($mydata['pricing']['companyMarkup']),

            ':customer' => amount($mydata['pricing']['totalCustomerShare']),

            ':ins_markup' => amount($mydata['pricing']['bmIComm']),

            ':bm_mark_up_total' => amount($mydata['pricing']['iBmCommInsTotal']),

            ':bm_direct_commission' => amount($mydata['pricing']['iBmComm']),

            ':bm_incentive' => amount($mydata['pricing']['iBmIns']),

            ':prime_customer' => amount($mydata['pricing']['customer1']),

            ':L1_customer' => amount($mydata['pricing']['customer2']),

            ':L2_customer' => amount($mydata['pricing']['customer3']),

            ':total_mark_up' => amount($mydata['pricing']['bmIComInsTotal']),

            ':total_commission_amount' => amount($mydata['pricing']['bmIComTotal']),

            ':total_incentive_amount' => amount($mydata['pricing']['bmIInsTotal']),

            ':coupon_amount' => amount($mydata['pricing']['couponAdjustment']),

            ':suspense' => amount($mydata['pricing']['bmISuspence'])

        ]);


    }

    /*
    |--------------------------------------------------------------------------
    | Package cancel policy
    |--------------------------------------------------------------------------
    */
    if (!empty($mydata['pricing'])) {

        $sql = "
            UPDATE cancel_policy
            SET
                policy_1 = :policy_1,
                policy_2 = :policy_2,
                policy_3 = :policy_3,
                policy_4 = :policy_4,
                policy_5 = :policy_5
            WHERE package_id = :package_id
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([

            ':package_id' => $get_id,

            ':policy_1' => $mydata['pricing']['cancellationPercentage1'],

            ':policy_2' => $mydata['pricing']['cancellationPercentage2'],

            ':policy_3' => $mydata['pricing']['cancellationPercentage3'],

            ':policy_4' => $mydata['pricing']['cancellationPercentage4'],

            ':policy_5' => $mydata['pricing']['cancellationPercentage5']

        ]);

    }
    /*
    |--------------------------------------------------------------------------
    | Package Policy
    |--------------------------------------------------------------------------
    */

    if (!empty($mydata['policy'])) {

        // Check if record exists
        $checkStmt = $conn->prepare("
            SELECT COUNT(*)
            FROM package_policy
            WHERE package_id = ?
        ");
        $checkStmt->execute([$get_id]);

        $exists = $checkStmt->fetchColumn() > 0;

        if ($exists) {

            // UPDATE
            $sql = "
                UPDATE package_policy
                SET
                    coupon_allowed             = :coupon_allowed,
                    combine_with_other_offers  = :combine_with_other_offers,
                    minimum_advance_payment    = :minimum_advance_payment,
                    full_payment_before_travel = :full_payment_before_travel
                WHERE package_id = :package_id
            ";

        } else {

            // INSERT
            $sql = "
                INSERT INTO package_policy (
                    package_id,
                    coupon_allowed,
                    combine_with_other_offers,
                    minimum_advance_payment,
                    full_payment_before_travel
                ) VALUES (
                    :package_id,
                    :coupon_allowed,
                    :combine_with_other_offers,
                    :minimum_advance_payment,
                    :full_payment_before_travel
                )
            ";

        }

        $stmt = $conn->prepare($sql);

        $stmt->execute([

            ':package_id' => $get_id,

            ':coupon_allowed' => $mydata['policy']['couponRule']['couponAllowed'],

            ':combine_with_other_offers' => $mydata['policy']['couponRule']['combineWithOffers'],

            ':minimum_advance_payment' => $mydata['policy']['booking']['bookingPercentage'],

            ':full_payment_before_travel' => $mydata['policy']['booking']['bookingDay']

        ]);

    }
    /*
    |--------------------------------------------------------------------------
    | Delete Removed Policy Documents
    |--------------------------------------------------------------------------
    */

    if (!empty($mydata['policy']['deletedDocuments'])) {

        $uploadDir = "../../../uploading/package_policy_attachments/";

        $deleteStmt = $conn->prepare("
            DELETE FROM package_policy_document
            WHERE id = :id
            AND package_id = :package_id
        ");

        foreach ($mydata['policy']['deletedDocuments'] as $doc) {

            // delete physical file
            if (!empty($doc['fileName'])) {

                $path = $uploadDir . $doc['fileName'];

                if (file_exists($path)) {

                    unlink($path);

                }

            }

            // delete database record
            $deleteStmt->execute([

                ':id' => $doc['id'],

                ':package_id' => $get_id

            ]);

        }

    }
    /*
    |--------------------------------------------------------------------------
    | Package Policy Documents
    |--------------------------------------------------------------------------
    */
    
    if (
        isset($_FILES['documents']) &&
        !empty($_FILES['documents']['name'][0]) &&
        !empty($mydata['policy']['documents'])
    ) {

        $uploadDir = "../../../uploading/package_policy_attachments/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $documents = $mydata['policy']['documents'];

        $sql = "
            INSERT INTO package_policy_document
            (
                package_id,
                title,
                file_name,
                type,
                size,
                uploaded_on
            )
            VALUES
            (
                :package_id,
                :title,
                :file_name,
                :type,
                :size,
                :uploaded_on
            )
        ";

        $stmt = $conn->prepare($sql);

        foreach ($_FILES['documents']['name'] as $i => $originalName) {

            if ($_FILES['documents']['error'][$i] != UPLOAD_ERR_OK) {
                throw new Exception("Document upload failed.");
            }

            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            $newFileName = uniqid("DOC_") . "." . $extension;

            $destination = $uploadDir . $newFileName;

            if (!move_uploaded_file($_FILES['documents']['tmp_name'][$i], $destination)) {
                throw new Exception("Unable to move uploaded file.");
            }


            // Match uploaded file document data
            $doc = $documents[$i] ?? [];


            // Skip already existing documents
            if (($doc['existing'] ?? false) === true) {
                continue;
            }


            $uploadedOn = DateTime::createFromFormat(
                'd/m/Y',
                $doc['uploadedOn'] ?? ''
            );

            if (!$uploadedOn) {
                $uploadedOn = new DateTime();
            }


            $stmt->execute([

                ':package_id' => $get_id,

                ':title' => $doc['title'] ?? $originalName,

                ':file_name' => $newFileName,

                ':type' => $doc['type'] ?? strtoupper($extension),

                ':size' => $doc['size'] ?? '0 MB',

                ':uploaded_on' => $uploadedOn->format('Y-m-d')

            ]);
        }

    }
    /*==============================================================================
    | MEDIA
    ==============================================================================*/

    if (!empty($mydata['media'])) {

        $folder = "../../../uploading/packages/";

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $packageName = str_replace(
            ' ',
            '-',
            $mydata['general_info']['packName']
        );

        $packageName = preg_replace(
            '/[^A-Za-z0-9\-]/',
            '',
            $packageName
        );

        /*==========================================================================
        | COVER IMAGE
        ==========================================================================*/

        if (!empty($mydata['media']['coverImage'])) {

            $cover = $mydata['media']['coverImage'];

            // Delete existing cover
            if (!empty($cover['deleted'])) {

                $stmt = $conn->prepare("
                    SELECT image
                    FROM package_pictures
                    WHERE package_id = ?
                    AND type='cover_image'
                ");

                $stmt->execute([$get_id]);

                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $file = "../../../" . $row['image'];

                    if (file_exists($file)) {
                        unlink($file);
                    }
                }

                $stmt = $conn->prepare("
                    DELETE FROM package_pictures
                    WHERE package_id=?
                    AND type='cover_image'
                ");

                $stmt->execute([$get_id]);
            }

            // New cover uploaded
            if (!empty($cover['name'])) {

                $base64 = $cover['name'];

                if (strpos($base64, "base64,") !== false) {

                    list(, $base64) = explode(",", $base64);

                    $imageName = $packageName . "-cover-" . time() . ".jpg";

                    $destination = $folder . $imageName;

                    if (file_put_contents($destination, base64_decode($base64)) === false) {
                        throw new Exception("Unable to save cover image.");
                    }

                    $uploadedFiles[] = $destination;

                    // remove old record
                    $stmt = $conn->prepare("
                        DELETE FROM package_pictures
                        WHERE package_id=?
                        AND type='cover_image'
                    ");

                    $stmt->execute([$get_id]);

                    // insert new
                    $stmt = $conn->prepare("
                        INSERT INTO package_pictures
                        (
                            package_id,
                            image,
                            type
                        )
                        VALUES
                        (
                            :package_id,
                            :image,
                            'cover_image'
                        )
                    ");

                    $stmt->execute([

                        ':package_id'=>$get_id,

                        ':image'=>"uploading/packages/".$imageName

                    ]);
                }
            }
        }

        /*==========================================================================
        | DELETE GALLERY IMAGES
        ==========================================================================*/

        if (!empty($mydata['media']['deletedGallery'])) {

            foreach ($mydata['media']['deletedGallery'] as $pictureId) {

                $stmt = $conn->prepare("
                    SELECT image
                    FROM package_pictures
                    WHERE id=?
                    AND type='gallery_image'
                ");

                $stmt->execute([$pictureId]);

                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $file = "../../../".$row['image'];

                    if (file_exists($file)) {
                        unlink($file);
                    }
                }

                $stmt = $conn->prepare("
                    DELETE FROM package_pictures
                    WHERE id=?
                ");

                $stmt->execute([$pictureId]);
            }
        }

        /*==========================================================================
        | NEW GALLERY IMAGES
        ==========================================================================*/

        if (!empty($mydata['media']['gallery'])) {

            $stmt = $conn->prepare("
                INSERT INTO package_pictures
                (
                    package_id,
                    image,
                    type
                )
                VALUES
                (
                    :package_id,
                    :image,
                    'gallery_image'
                )
            ");

            foreach ($mydata['media']['gallery'] as $key=>$gallery) {

                // Skip existing images
                if (!empty($gallery['existing'])) {
                    continue;
                }

                if (empty($gallery['name'])) {
                    continue;
                }

                $base64 = $gallery['name'];

                if (strpos($base64,'base64,')===false) {
                    continue;
                }

                list(,$base64)=explode(',',$base64);

                $imageName=$packageName.
                    "-gallery-".
                    uniqid().
                    ".jpg";

                $destination=$folder.$imageName;

                if(file_put_contents($destination,base64_decode($base64))===false){
                    throw new Exception("Unable to save gallery image.");
                }

                $uploadedFiles[]=$destination;

                $stmt->execute([

                    ':package_id'=>$get_id,

                    ':image'=>"uploading/packages/".$imageName

                ]);
            }
        }

        /*==========================================================================
        | VIDEOS
        ==========================================================================*/

        // Delete all existing videos
        $conn->prepare("
            DELETE FROM package_pictures
            WHERE package_id = ?
            AND type = 'video'
        ")->execute([$get_id]);

        // Insert all current videos
        if (!empty($mydata['media']['videos'])) {

            $stmt = $conn->prepare("
                INSERT INTO package_pictures
                (
                    package_id,
                    image,
                    type
                )
                VALUES
                (
                    :package_id,
                    :image,
                    'video'
                )
            ");

            foreach ($mydata['media']['videos'] as $video) {

                $url = trim($video['url'] ?? '');

                if ($url === '') {
                    continue;
                }

                $stmt->execute([
                    ':package_id' => $get_id,
                    ':image'      => $url
                ]);
            }
        }
    }
    /*
|--------------------------------------------------------------------------
| Logs
|--------------------------------------------------------------------------
*/

$message = "Edited " . $mydata['general_info']['packName'] . " Package";

$sql = "
    INSERT INTO logs
    (
        title,
        message,
        message2,
        reference_no,
        register_by,
        from_whom
    )
    VALUES
    (
        :title,
        :message,
        :message2,
        :reference_no,
        :register_by,
        :from_whom
    )
";

$stmt = $conn->prepare($sql);

$stmt->execute([

    ':title' => "Edited Package",

    ':message' => $message,

    ':message2' => $message,

    ':reference_no' => "1",

    ':register_by' => "1",

    ':from_whom' => "1"

]);

/*
|--------------------------------------------------------------------------
| Everything Successful
|--------------------------------------------------------------------------
*/

$conn->commit();

echo json_encode([
    "status" => true,
    "message" => "Package Updated successfully."
]);

}
catch (Exception $e) {

    /*
    |--------------------------------------------------------------------------
    | Rollback Database
    |--------------------------------------------------------------------------
    */

    if ($conn->inTransaction()) {

        $conn->rollBack();

    }

    /*
    |--------------------------------------------------------------------------
    | Delete Uploaded Files
    |--------------------------------------------------------------------------
    */

    if (!empty($uploadedFiles)) {

        foreach ($uploadedFiles as $file) {

            if (file_exists($file)) {

                unlink($file);

            }

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Return Error
    |--------------------------------------------------------------------------
    */

    http_response_code(500);

    echo json_encode([

        "status" => false,

        "message" => $e->getMessage()

    ]);

}