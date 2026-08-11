<?php

require '../../connect.php';

date_default_timezone_set('Asia/Calcutta');

$today = date('Y-m-d H:i:s');

$response = false;

$get_id = 0;

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

    $sql = "
        INSERT INTO package
        (
            category_id,
            sub_category_id,
            package_type,
            category_hotel_id,
            category_occupancy_id,
            category_meal_id,
            name,
            unique_code,
            description,
            detailed_description,
            package_keywords,
            destination,
            location,
            travel_from,
            travel_to,
            sightseeing_type,
            validity,
            tour_days,
            cities,
            best_season,
            highlight_type,
            drop_price_status,
            drop_price_amount,
            language_type,
            visa_required,
            category_vehicle_id
        )
        VALUES
        (
            :category_id,
            :sub_category_id,
            :package_type,
            :category_hotel_id,
            :category_occupancy_id,
            :category_meal_id,
            :name,
            :unique_code,
            :description,
            :detailed_description,
            :package_keywords,
            :destination,
            :location,
            :travel_from,
            :travel_to,
            :sightseeing_type,
            :validity,
            :tour_days,
            :cities,
            :best_season,
            :highlight_type,
            :drop_price_status,
            :drop_price_amount,
            :language_type,
            :visa_required,
            :category_vehicle_id
        )
    ";

    $statement = $conn->prepare($sql);

    $statement->execute([

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

    /*
    |--------------------------------------------------------------------------
    | NEVER DO SELECT ORDER BY ID DESC
    |--------------------------------------------------------------------------
    */

    $get_id = $conn->lastInsertId();
    /*
    |--------------------------------------------------------------------------
    | Package Itinerary Details
    |--------------------------------------------------------------------------
    */

    if (!empty($mydata['itinerary'])) {

        $sql = "
            INSERT INTO package_itinerary_details
            (
                package_id,
                inclusion,
                exclusion,
                remark,
                travel_info,
                highlights
            )
            VALUES
            (
                :package_id,
                :inclusion,
                :exclusion,
                :remark,
                :travel_info,
                :highlights
            )
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
            INSERT INTO package_pricing
            (
                package_id,
                net_price_adult,
                net_price_child,
                net_price_adult_with_GST,
                net_price_child_with_GST,
                total_package_price_per_adult,
                total_package_price_per_child,
                extra_mattress,
                coupon_adjustment,
                guest_amount,
                guest_percentage
            )
            VALUES
            (
                :package_id,
                :net_price_adult,
                :net_price_child,
                :net_price_adult_with_GST,
                :net_price_child_with_GST,
                :total_package_price_per_adult,
                :total_package_price_per_child,
                :extra_mattress,
                :coupon_adjustment,
                :guest_amount,
                :guest_percentage
            )
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([

            ':package_id'                     => $get_id,

            ':net_price_adult'                => $mydata['pricing']['netPriceAdult'],

            ':net_price_child'                => $mydata['pricing']['netPriceChild'],

            ':net_price_adult_with_GST'       => $mydata['pricing']['mrpPerAdult'],

            ':net_price_child_with_GST'       => $mydata['pricing']['mrpPerChild'],

            ':total_package_price_per_adult'  => $mydata['pricing']['mrpPerAdultGst'],

            ':total_package_price_per_child'  => $mydata['pricing']['mrpPerChildGst'],

            ':extra_mattress'                 => $mydata['pricing']['extraMatress'],

            ':coupon_adjustment'              => $mydata['pricing']['couponAdjustment'],

            ':guest_amount'                   => $mydata['pricing']['guestAmount'],

            ':guest_percentage'               => $mydata['pricing']['guestPercentage']

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
            INSERT INTO package_pricing_markup
            (
                package_id,
                company,
                customer,
                ta_markup,
                ca_mark_up_total,
                ca_direct_commission,
                ca_incentive,
                bm_mark_up_total,
                bm_direct_commission,
                bm_incentive,
                prime_customer,
                L1_customer,
                L2_customer,
                total_mark_up,
                total_commission_amount,
                total_incentive_amount,
                coupon_amount,
                suspense
            )
            VALUES
            (
                :package_id,
                :company,
                :customer,
                :ta_markup,
                :ca_mark_up_total,
                :ca_direct_commission,
                :ca_incentive,
                :bm_mark_up_total,
                :bm_direct_commission,
                :bm_incentive,
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

        $stmt = $conn->prepare($sql);
        $stmt->execute([

            ':package_id'=>$get_id,

            ':company'=>amount($mydata['pricing']['companyMarkup']),

            ':customer'=>amount($mydata['pricing']['totalCustomerShare']),

            ':ta_markup'=>amount($mydata['pricing']['travelConsultant']),

            ':ca_mark_up_total'=>amount($mydata['pricing']['teBmComInsTotal']),

            ':ca_direct_commission'=>amount($mydata['pricing']['teBmComm']),

            ':ca_incentive'=>amount($mydata['pricing']['teBmIns']),

            ':bm_mark_up_total'=>amount($mydata['pricing']['teBmComInsTotal']),

            ':bm_direct_commission'=>amount($mydata['pricing']['bmTeComm']),

            ':bm_incentive'=>amount($mydata['pricing']['bmTeIns']),

            ':prime_customer'=>amount($mydata['pricing']['customer1']),

            ':L1_customer'=>amount($mydata['pricing']['customer2']),

            ':L2_customer'=>amount($mydata['pricing']['customer3']),

            ':total_mark_up'=>amount($mydata['pricing']['bmTeChainCommInsTotal']),

            ':total_commission_amount'=>amount($mydata['pricing']['bmTeChainCommTotal']),

            ':total_incentive_amount'=>amount($mydata['pricing']['bmTeChainInsTotal']),

            ':coupon_amount'=>amount($mydata['pricing']['couponAdjustment']),

            ':suspense'=>amount($mydata['pricing']['bmSuspence'])

        ]);
        // cte->ete->ste->te
        $sql = "
            INSERT INTO package_pricing_markup_te_chain
            (
                package_id,
                company,
                customer,
                ta_markup,
                te_mark_up_total,
                te_direct_commission,
                te_incentive,
                ete_mark_up_total,
                ete_direct_commission,
                ete_incentive,
                ste_mark_up_total,
                ste_direct_commission,
                ste_incentive,
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
            )
            VALUES
            (
                :package_id,
                :company,
                :customer,
                :ta_markup,
                :te_mark_up_total,
                :te_direct_commission,
                :te_incentive,
                :ete_mark_up_total,
                :ete_direct_commission,
                :ete_incentive,
                :ste_mark_up_total,
                :ste_direct_commission,
                :ste_incentive,
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

        $stmt = $conn->prepare($sql);

        $stmt->execute([

            ':package_id'=>$get_id,

            ':company'=>amount($mydata['pricing']['companyMarkup']),

            ':customer'=>amount($mydata['pricing']['totalCustomerShare']),

            ':ta_markup'=>amount($mydata['pricing']['travelConsultant']),

            ':te_mark_up_total'=>amount($mydata['pricing']['cTeFCommInsTotal']),

            ':te_direct_commission'=>amount($mydata['pricing']['cTeFComm']),

            ':te_incentive'=>amount($mydata['pricing']['cTeFIns']),

            ':ete_mark_up_total'=>amount($mydata['pricing']['eteCommInsTotal']),

            ':ete_direct_commission'=>amount($mydata['pricing']['eteComm']),

            ':ete_incentive'=>amount($mydata['pricing']['eteIns']),

            ':ste_mark_up_total'=>amount($mydata['pricing']['steCommInsTotal']),

            ':ste_direct_commission'=>amount($mydata['pricing']['steComm']),

            ':ste_incentive'=>amount($mydata['pricing']['steIns']),

            ':cte_mark_up_total'=>amount($mydata['pricing']['cteCommInsTotal']),

            ':cte_direct_commission'=>amount($mydata['pricing']['cteComm']),

            ':cte_incentive'=>amount($mydata['pricing']['cteIns']),

            ':prime_customer'=>amount($mydata['pricing']['customer1']),

            ':L1_customer'=>amount($mydata['pricing']['customer2']),

            ':L2_customer'=>amount($mydata['pricing']['customer3']),

            ':total_mark_up'=>amount($mydata['pricing']['cteChainCommTotal']),

            ':total_commission_amount'=>amount($mydata['pricing']['cteChainCommInsTotal']),

            ':total_incentive_amount'=>amount($mydata['pricing']['cteChainInsTotal']),

            ':coupon_amount'=>amount($mydata['pricing']['couponAdjustment']),

            ':suspense'=>amount($mydata['pricing']['cteSuspence'])

        ]);

        // cte->ete->i
        $sql = "
            INSERT INTO package_pricing_markup_techno_institution
            (
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
            )
            VALUES
            (
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

        $stmt = $conn->prepare($sql);

        $stmt->execute([

            ':package_id'=>$get_id,

            ':company'=>amount($mydata['pricing']['companyMarkup']),

            ':customer'=>amount($mydata['pricing']['totalCustomerShare']),

            ':ins_markup'=>amount($mydata['pricing']['cteIComm']),

            ':ete_mark_up_total'=>amount($mydata['pricing']['iEteCommInsTotal']),

            ':ete_direct_commission'=>amount($mydata['pricing']['iEteComm']),

            ':ete_incentive'=>amount($mydata['pricing']['iEteIns']),

            ':cte_mark_up_total'=>amount($mydata['pricing']['iCteCommInsTotal']),

            ':cte_direct_commission'=>amount($mydata['pricing']['iCteComm']),

            ':cte_incentive'=>amount($mydata['pricing']['iCteIns']),

            ':prime_customer'=>amount($mydata['pricing']['customer1']),

            ':L1_customer'=>amount($mydata['pricing']['customer2']),

            ':L2_customer'=>amount($mydata['pricing']['customer3']),

            ':total_mark_up'=>amount($mydata['pricing']['iCteComInsTotal']),

            ':total_commission_amount'=>amount($mydata['pricing']['iCteComTotal']),

            ':total_incentive_amount'=>amount($mydata['pricing']['iCteInsTotal']),

            ':coupon_amount'=>amount($mydata['pricing']['couponAdjustment']),

            ':suspense'=>amount($mydata['pricing']['cteISuspence'])

        ]);
        // bm/mf/sf->i
        $sql = "
            INSERT INTO package_pricing_markup_institution
            (
                package_id,
                company,
                customer,
                ins_markup,
                bm_mark_up_total,
                bm_direct_commission,
                bm_incentive,
                prime_customer,
                L1_customer,
                L2_customer,
                total_mark_up,
                total_commission_amount,
                total_incentive_amount,
                coupon_amount,
                suspense
            )
            VALUES
            (
                :package_id,
                :company,
                :customer,
                :ins_markup,
                :bm_mark_up_total,
                :bm_direct_commission,
                :bm_incentive,
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

        $stmt = $conn->prepare($sql);

        $stmt->execute([

            ':package_id'=>$get_id,

            ':company'=>amount($mydata['pricing']['companyMarkup']),

            ':customer'=>amount($mydata['pricing']['totalCustomerShare']),

            ':ins_markup'=>amount($mydata['pricing']['bmIComm']),

            ':bm_mark_up_total'=>amount($mydata['pricing']['iBmCommInsTotal']),

            ':bm_direct_commission'=>amount($mydata['pricing']['iBmComm']),

            ':bm_incentive'=>amount($mydata['pricing']['iBmIns']),

            ':prime_customer'=>amount($mydata['pricing']['customer1']),

            ':L1_customer'=>amount($mydata['pricing']['customer2']),

            ':L2_customer'=>amount($mydata['pricing']['customer3']),

            ':total_mark_up'=>amount($mydata['pricing']['bmIComInsTotal']),

            ':total_commission_amount'=>amount($mydata['pricing']['bmIComTotal']),

            ':total_incentive_amount'=>amount($mydata['pricing']['bmIInsTotal']),

            ':coupon_amount'=>amount($mydata['pricing']['couponAdjustment']),

            ':suspense'=>amount($mydata['pricing']['bmISuspence'])

        ]);


    }

    /*
    |--------------------------------------------------------------------------
    | Package cancel policy
    |--------------------------------------------------------------------------
    */
    if (!empty($mydata['pricing'])) {

        $sql = "
            INSERT INTO cancel_policy
            (
                package_id,
                policy_1,
                policy_2,
                policy_3,
                policy_4,
                policy_5
            )
            VALUES
            (
                :package_id,
                :policy_1,
                :policy_2,
                :policy_3,
                :policy_4,
                :policy_5
            )
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

        $sql = "
            INSERT INTO package_policy
            (
                package_id,
                coupon_allowed,
                combine_with_other_offers,
                minimum_advance_payment,
                full_payment_before_travel
            )
            VALUES
            (
                :package_id,
                :coupon_allowed,
                :combine_with_other_offers,
                :minimum_advance_payment,
                :full_payment_before_travel
            )
        ";

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

            if (!isset($documents[$i])) {

                throw new Exception("Document payload mismatch.");

            }

            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            $newFileName = uniqid("DOC_") . "." . $extension;

            $destination = $uploadDir . $newFileName;

            if (!move_uploaded_file($_FILES['documents']['tmp_name'][$i], $destination)) {

                throw new Exception("Unable to move uploaded file.");

            }

            /*
            |--------------------------------------------------------------------------
            | Save uploaded file path.
            | Used during rollback.
            |--------------------------------------------------------------------------
            */

            $uploadedFiles[] = $destination;

            $doc = $documents[$i];

            /*
            |--------------------------------------------------------------------------
            | Convert uploaded date
            |--------------------------------------------------------------------------
            */

            $uploadedOn = DateTime::createFromFormat(
                'd/m/Y',
                $doc['uploadedOn']
            );

            if (!$uploadedOn) {

                $uploadedOn = new DateTime();

            }

            $stmt->execute([

                ':package_id' => $get_id,

                ':title' => $doc['title'],

                ':file_name' => $newFileName,

                ':type' => $doc['type'],

                ':size' => $doc['size'],

                ':uploaded_on' => $uploadedOn->format('Y-m-d')

            ]);

        }

    }
    /*
    |--------------------------------------------------------------------------
    | Package Media
    |--------------------------------------------------------------------------
    */

    if (!empty($mydata['media'])) {

        $sql = "
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
                :type
            )
        ";

        $stmt = $conn->prepare($sql);

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

        /*
        |--------------------------------------------------------------------------
        | Cover Image
        |--------------------------------------------------------------------------
        */

        if (!empty($mydata['media']['coverImage']['name'])) {

            $base64 = $mydata['media']['coverImage']['name'];

            if (strpos($base64, 'base64,') !== false) {

                list(, $base64) = explode(',', $base64);

                $imageName = $packageName . "-cover-" . time() . ".jpg";

                $destination = $folder . $imageName;

                if (file_put_contents($destination, base64_decode($base64)) === false) {

                    throw new Exception("Unable to save cover image.");

                }

                /*
                |--------------------------------------------------------------------------
                | Save uploaded file for rollback
                |--------------------------------------------------------------------------
                */

                $uploadedFiles[] = $destination;

                $stmt->execute([

                    ':package_id' => $get_id,

                    ':image' => "uploading/packages/" . $imageName,

                    ':type' => "cover_image"

                ]);

            }

        }

        /*
        |--------------------------------------------------------------------------
        | Gallery Images
        |--------------------------------------------------------------------------
        */

        if (!empty($mydata['media']['gallery'])) {

            foreach ($mydata['media']['gallery'] as $key => $gallery) {

                if (empty($gallery['name'])) {

                    continue;

                }

                $base64 = $gallery['name'];

                if (strpos($base64, 'base64,') === false) {

                    continue;

                }

                list(, $base64) = explode(',', $base64);

                $imageName = $packageName .
                    "-gallery-" .
                    ($key + 1) .
                    "-" .
                    time() .
                    ".jpg";

                $destination = $folder . $imageName;

                if (file_put_contents($destination, base64_decode($base64)) === false) {

                    throw new Exception("Unable to save gallery image.");

                }

                /*
                |--------------------------------------------------------------------------
                | Save uploaded file for rollback
                |--------------------------------------------------------------------------
                */

                $uploadedFiles[] = $destination;

                $stmt->execute([

                    ':package_id' => $get_id,

                    ':image' => "uploading/packages/" . $imageName,

                    ':type' => "gallery_image"

                ]);

            }

        }

        /*
        |--------------------------------------------------------------------------
        | Videos
        |--------------------------------------------------------------------------
        */

        $videoUploadDir = "../../../uploading/package_videos/";
        $videoDbPath    = "uploading/package_videos/";

        /*
        |--------------------------------------------------------------------------
        | Create upload directory
        |--------------------------------------------------------------------------
        */

        if (!is_dir($videoUploadDir)) {

            if (!mkdir($videoUploadDir, 0777, true)) {

                throw new Exception(
                    "Unable to create video upload directory."
                );

            }

        }

        /*
        |--------------------------------------------------------------------------
        | Allowed extensions
        |--------------------------------------------------------------------------
        */

        $allowedExtensions = [
            'mp4',
            'webm',
            'mov',
            'avi',
            'mkv',
            'm4v'
        ];

        /*
        |--------------------------------------------------------------------------
        | Upload new videos
        |--------------------------------------------------------------------------
        */

        if (
            isset($_FILES['videos']) &&
            isset($_FILES['videos']['name']) &&
            is_array($_FILES['videos']['name'])
        ) {

            /*
            |--------------------------------------------------------------------------
            | Insert statement
            |--------------------------------------------------------------------------
            */

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

            /*
            |--------------------------------------------------------------------------
            | Process new videos
            |--------------------------------------------------------------------------
            */

            foreach ($_FILES['videos']['name'] as $i => $originalName) {

                /*
                |--------------------------------------------------------------------------
                | Upload error
                |--------------------------------------------------------------------------
                */

                $error = $_FILES['videos']['error'][$i]
                    ?? UPLOAD_ERR_NO_FILE;

                if ($error !== UPLOAD_ERR_OK) {

                    $uploadErrors = [

                        UPLOAD_ERR_INI_SIZE =>
                            "File exceeds upload_max_filesize.",

                        UPLOAD_ERR_FORM_SIZE =>
                            "File exceeds the form upload limit.",

                        UPLOAD_ERR_PARTIAL =>
                            "File was only partially uploaded.",

                        UPLOAD_ERR_NO_FILE =>
                            "No file was uploaded.",

                        UPLOAD_ERR_NO_TMP_DIR =>
                            "Missing temporary upload directory.",

                        UPLOAD_ERR_CANT_WRITE =>
                            "Failed to write file to disk.",

                        UPLOAD_ERR_EXTENSION =>
                            "A PHP extension stopped the upload."

                    ];

                    $errorMessage =
                        $uploadErrors[$error]
                        ?? "Unknown upload error.";

                    throw new Exception(
                        "Video upload failed: " .
                        $originalName .
                        " | Error code: " .
                        $error .
                        " | " .
                        $errorMessage
                    );

                }

                /*
                |--------------------------------------------------------------------------
                | Get extension
                |--------------------------------------------------------------------------
                */

                $extension = strtolower(
                    pathinfo(
                        $originalName,
                        PATHINFO_EXTENSION
                    )
                );

                /*
                |--------------------------------------------------------------------------
                | Validate extension
                |--------------------------------------------------------------------------
                */

                if (!in_array(
                    $extension,
                    $allowedExtensions,
                    true
                )) {

                    throw new Exception(
                        "Invalid video format: " .
                        $extension
                    );

                }

                /*
                |--------------------------------------------------------------------------
                | Generate unique filename
                |--------------------------------------------------------------------------
                */

                $newFileName =
                    uniqid("VID_", true) .
                    "." .
                    $extension;

                /*
                |--------------------------------------------------------------------------
                | Physical file location
                |--------------------------------------------------------------------------
                */

                $destination =
                    $videoUploadDir .
                    $newFileName;

                /*
                |--------------------------------------------------------------------------
                | Move uploaded video
                |--------------------------------------------------------------------------
                */

                if (!move_uploaded_file(
                    $_FILES['videos']['tmp_name'][$i],
                    $destination
                )) {

                    throw new Exception(
                        "Unable to move uploaded video: " .
                        $originalName
                    );

                }

                /*
                |--------------------------------------------------------------------------
                | Track uploaded file for rollback
                |--------------------------------------------------------------------------
                */

                $uploadedFiles[] = $destination;

                /*
                |--------------------------------------------------------------------------
                | Database path
                |--------------------------------------------------------------------------
                */

                $databasePath =
                    $newFileName;

                /*
                |--------------------------------------------------------------------------
                | Insert new video
                |--------------------------------------------------------------------------
                */

                $stmt->execute([

                    ':package_id' => $get_id,

                    ':image' => $databasePath

                ]);

            }

        }

    }
    /*
|--------------------------------------------------------------------------
| Logs
|--------------------------------------------------------------------------
*/

$message = "Added " . $mydata['general_info']['packName'] . " Package";

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

    ':title' => "Added Package",

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
    "message" => "Package added successfully."
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