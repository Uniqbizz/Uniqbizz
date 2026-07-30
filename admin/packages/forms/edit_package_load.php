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

if (!isset($_POST['id'])) {

    exit("Invalid Request");

}

$mydata = json_decode($_POST['id'], true);

if (!$mydata) {

    exit("Invalid Payload");

}

    /*
    |--------------------------------------------------------------------------
    | Package Insert
    |--------------------------------------------------------------------------
    */

    $sql = "SELECT * FROM package WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id' => $_POST['id']
    ]);

    $package = $stmt->fetch(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Package Itinerary Details
    |--------------------------------------------------------------------------
    */

    $sql = "SELECT * FROM package_itinerary_details WHERE package_id = :package_id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':package_id' => $_POST['id']
    ]);

    $itineraryDetails = $stmt->fetch(PDO::FETCH_ASSOC);


    /*
    |--------------------------------------------------------------------------
    | Package Trip Days
    |--------------------------------------------------------------------------
    */
    $sql = "SLECT * FROM package_trip_days WHERE package_id = :package_id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':package_id' => $_POST['id']
    ]);

    $packageTripDays = $stmt->fetch(PDO::FETCH_ASSOC);



    /*
    |--------------------------------------------------------------------------
    | Package Pricing
    |--------------------------------------------------------------------------
    */

    $sql = "SELECT * FROM package_pricing WHERE package_id:id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':package_id' => $_POST['id']
    ]);

    $packagePricing = $stmt->fetch(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Package Pricing Markup
    |--------------------------------------------------------------------------
    */

    $sql = "SELECT * FROM package_pricing_markup WHERE package_id:id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':package_id' => $_POST['id']
    ]);

    $packagePricing = $stmt->fetch(PDO::FETCH_ASSOC);

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

        if (!empty($mydata['media']['videos'])) {

            foreach ($mydata['media']['videos'] as $video) {

                if (empty($video['url'])) {

                    continue;

                }

                $stmt->execute([

                    ':package_id' => $get_id,

                    ':image' => trim($video['url']),

                    ':type' => "video"

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