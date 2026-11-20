<?php

header('Content-Type: application/json; charset=utf-8');

include_once(__DIR__ . '/../../dashboard_user_details.php');

/*
|--------------------------------------------------------------------------
| JSON RESPONSE HELPER
|--------------------------------------------------------------------------
*/

function sendResponse($status, $message, $httpCode = 200, $extra = [])
{
    http_response_code($httpCode);

    echo json_encode(array_merge([
        'status'  => $status,
        'message' => $message
    ], $extra));

    exit;
}


/*
|--------------------------------------------------------------------------
| METHOD VALIDATION
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    sendResponse(
        false,
        'Invalid request method.',
        405
    );

}


/*
|--------------------------------------------------------------------------
| DATABASE CONNECTION VALIDATION
|--------------------------------------------------------------------------
|
| This code assumes your PDO connection variable is $conn.
|
*/

if (!isset($conn) || !($conn instanceof PDO)) {

    sendResponse(
        false,
        'Database connection is not available.',
        500
    );

}

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


/*
|--------------------------------------------------------------------------
| RECEIVE POST DATA
|--------------------------------------------------------------------------
*/

$requestId = trim($_POST['request_id'] ?? '');

$packageId = filter_var(
    $_POST['package_id'] ?? null,
    FILTER_VALIDATE_INT
);

$replyId = filter_var(
    $_POST['reply_id'] ?? null,
    FILTER_VALIDATE_INT
);

$responseAction = trim($_POST['response_action'] ?? '');


/*
|--------------------------------------------------------------------------
| BASIC VALIDATION
|--------------------------------------------------------------------------
*/

if (
    $requestId === '' ||
    $packageId === false ||
    $packageId === null ||
    $packageId <= 0 ||
    $replyId === false ||
    $replyId === null ||
    $replyId <= 0
) {

    sendResponse(
        false,
        'Invalid quotation details. Please refresh the page and try again.',
        422
    );

}


$allowedActions = [
    'approved',
    'rejected',
    'change_request'
];

if (!in_array($responseAction, $allowedActions, true)) {

    sendResponse(
        false,
        'Please select a valid response option.',
        422
    );

}


/*
|--------------------------------------------------------------------------
| RESPONSE DETAILS
|--------------------------------------------------------------------------
*/

$status = null;
$title = '';
$message = '';


/*
|--------------------------------------------------------------------------
| APPROVED
|--------------------------------------------------------------------------
*/

if ($responseAction === 'approved') {

    $status = 1;

    $title = 'Customer Approved the Quotation';

    $message = 'Customer has approved the quotation and submitted the traveller details.';

}


/*
|--------------------------------------------------------------------------
| REJECTED
|--------------------------------------------------------------------------
*/

elseif ($responseAction === 'rejected') {

    $status = 0;

    $title = 'Customer Declined the Quotation';

    $rejectionReason = trim($_POST['rejection_reason'] ?? '');

    $allowedRejectionReasons = [
        'The quotation is too expensive',
        'I found a better offer',
        'Travel plans have changed',
        'I have booked with another provider',
        'The itinerary does not meet my requirements',
        'Other'
    ];

    if (!in_array($rejectionReason, $allowedRejectionReasons, true)) {

        sendResponse(
            false,
            'Please select a valid reason for rejecting the quotation.',
            422
        );

    }

    if ($rejectionReason === 'Other') {

        $otherReason = trim($_POST['rejection_other_reason'] ?? '');

        if ($otherReason === '') {

            sendResponse(
                false,
                'Please enter your rejection reason.',
                422
            );

        }

        if (mb_strlen($otherReason) > 999) {

            sendResponse(
                false,
                'Rejection reason cannot exceed 999 characters.',
                422
            );

        }

        $message = 'Customer declined the quotation. Reason: ' . $otherReason;

    } else {

        $message = 'Customer declined the quotation. Reason: ' . $rejectionReason;

    }

}


/*
|--------------------------------------------------------------------------
| CHANGE REQUEST
|--------------------------------------------------------------------------
*/

elseif ($responseAction === 'change_request') {

    $status = 2;

    $title = 'Customer Requested Changes to the Quotation';

    $changeRequestReason = trim(
        $_POST['change_request_reason'] ?? ''
    );

    if ($changeRequestReason === '') {

        sendResponse(
            false,
            'Please enter your change request reason.',
            422
        );

    }

    if (mb_strlen($changeRequestReason) > 999) {

        sendResponse(
            false,
            'Change request reason cannot exceed 999 characters.',
            422
        );

    }

    $message = $changeRequestReason;

}


/*
|--------------------------------------------------------------------------
| VALIDATE TRAVELLER DETAILS
|--------------------------------------------------------------------------
*/

$members = [];

if ($responseAction === 'approved') {

    if (
        !isset($_POST['members']) ||
        !is_array($_POST['members']) ||
        empty($_POST['members'])
    ) {

        sendResponse(
            false,
            'Please provide the traveller details.',
            422
        );

    }

    $ageLimits = [
        'adult' => [
            'min' => 12,
            'max' => 120
        ],
        'child' => [
            'min' => 2,
            'max' => 11
        ],
        'infant' => [
            'min' => 0,
            'max' => 1
        ]
    ];

    foreach ($_POST['members'] as $memberKey => $member) {

        if (!is_array($member)) {

            sendResponse(
                false,
                'Invalid traveller information.',
                422
            );

        }

        $memberName = trim($member['full_name'] ?? '');

        $memberType = strtolower(
            trim($member['member_type'] ?? '')
        );

        $memberAge = trim((string)($member['age'] ?? ''));

        $memberGender = trim($member['gender'] ?? '');


        /*
        |--------------------------------------------------------------------------
        | NAME VALIDATION
        |--------------------------------------------------------------------------
        */

        if ($memberName === '') {

            sendResponse(
                false,
                'Please enter the name of every traveller.',
                422
            );

        }

        if (mb_strlen($memberName) > 999) {

            sendResponse(
                false,
                'Traveller name is too long.',
                422
            );

        }


        /*
        |--------------------------------------------------------------------------
        | MEMBER TYPE VALIDATION
        |--------------------------------------------------------------------------
        */

        if (!isset($ageLimits[$memberType])) {

            sendResponse(
                false,
                'Invalid traveller type selected.',
                422
            );

        }


        /*
        |--------------------------------------------------------------------------
        | AGE VALIDATION
        |--------------------------------------------------------------------------
        */

        if (
            $memberAge === '' ||
            !preg_match('/^\d+$/', $memberAge)
        ) {

            sendResponse(
                false,
                'Please enter a valid age for every traveller.',
                422
            );

        }

        $age = (int)$memberAge;

        $minAge = $ageLimits[$memberType]['min'];
        $maxAge = $ageLimits[$memberType]['max'];

        if ($age < $minAge || $age > $maxAge) {

            sendResponse(
                false,
                ucfirst($memberType) . ' age must be between ' .
                $minAge . ' and ' . $maxAge . ' years.',
                422
            );

        }


        /*
        |--------------------------------------------------------------------------
        | GENDER VALIDATION
        |--------------------------------------------------------------------------
        */

        if ($memberGender === '') {

            sendResponse(
                false,
                'Please select the gender for every traveller.',
                422
            );

        }

        if (mb_strlen($memberGender) > 99) {

            sendResponse(
                false,
                'Invalid gender value.',
                422
            );

        }


        /*
        |--------------------------------------------------------------------------
        | STORE VALIDATED MEMBER
        |--------------------------------------------------------------------------
        */

        $members[] = [
            'member_type' => ucfirst($memberType),
            'name'        => $memberName,
            'age'         => $age,
            'gender'      => $memberGender
        ];

    }

}


/*
|--------------------------------------------------------------------------
| SAVE CUSTOMER RESPONSE
|--------------------------------------------------------------------------
*/

try {

    $conn->beginTransaction();


    /*
    |--------------------------------------------------------------------------
    | INSERT CUSTOMER REPLY
    |--------------------------------------------------------------------------
    |
    | reply_id here refers to the existing quotation reply ID.
    |
    */

    $insertReply = $conn->prepare("
        INSERT INTO request_details_customer_reply
        (
            request_id,
            package_id,
            reply_id,
            title,
            message,
            status
        )
        VALUES
        (
            :request_id,
            :package_id,
            :reply_id,
            :title,
            :message,
            :status
        )
    ");

    $insertReply->execute([

        ':request_id'  => $requestId,
        ':package_id'  => $packageId,
        ':reply_id'    => $replyId,
        ':title'       => $title,
        ':message'     => $message,
        ':status'      => $status

    ]);


    /*
    |--------------------------------------------------------------------------
    | GET NEW CUSTOMER REPLY ID
    |--------------------------------------------------------------------------
    |
    | This newly generated ID will be used in
    | request_details_member_details.reply_id.
    |
    */

    $customerReplyId = (int)$conn->lastInsertId();


    if ($customerReplyId <= 0) {

        throw new Exception(
            'Unable to generate customer reply ID.'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | INSERT TRAVELLER DETAILS
    |--------------------------------------------------------------------------
    |
    | Traveller details are inserted ONLY when the customer approves.
    |
    */

    if ($responseAction === 'approved') {

        $insertMember = $conn->prepare("
            INSERT INTO request_details_member_details
            (
                request_id,
                package_id,
                reply_id,
                member_type,
                name,
                age,
                gender
            )
            VALUES
            (
                :request_id,
                :package_id,
                :reply_id,
                :member_type,
                :name,
                :age,
                :gender
            )
        ");


        foreach ($members as $member) {

            $insertMember->execute([

                ':request_id'  => $requestId,
                ':package_id'  => $packageId,

                // Newly generated customer reply ID.
                ':reply_id'    => $customerReplyId,

                ':member_type' => $member['member_type'],
                ':name'        => $member['name'],
                ':age'         => $member['age'],
                ':gender'      => $member['gender']

            ]);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | COMMIT TRANSACTION
    |--------------------------------------------------------------------------
    */

    $conn->commit();


    /*
    |--------------------------------------------------------------------------
    | SUCCESS RESPONSE
    |--------------------------------------------------------------------------
    */

    $successMessages = [

        'approved' => 'Your quotation has been approved and traveller details have been submitted successfully.',

        'rejected' => 'Your quotation rejection has been submitted successfully.',

        'change_request' => 'Your change request has been submitted successfully.'

    ];

    sendResponse(
        true,
        $successMessages[$responseAction],
        200,
        [
            'customer_reply_id' => $customerReplyId,
            'response_action'   => $responseAction,
            'redirect_url'      => ''
        ]
    );


} catch (PDOException $e) {

    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    error_log(
        'Customer reply database error: ' . $e->getMessage()
    );

    sendResponse(
        false,
        'A database error occurred while saving your response. Please try again.',
        500
    );


} catch (Throwable $e) {

    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    error_log(
        'Customer reply error: ' . $e->getMessage()
    );

    sendResponse(
        false,
        'Unable to submit your response. Please try again.',
        500
    );

}
?>