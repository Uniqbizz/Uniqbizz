<?php

header('Content-Type: application/json');

require_once '../../connect.php';

try {

    /*
    =========================================================
    GET POST DATA
    =========================================================
    */

    $institutionId = $_POST['institution_id'] ?? '';


    /*
    =========================================================
    TC
    =========================================================
    */

    $tcSelected =
        $_POST['tc']['selected'] ?? 0;

    $tcHolidayAccount =
        $_POST['tc']['holiday_account'] ?? 0;

    $tcBookingAmount =
        $_POST['tc']['booking_amount'] ?? 0;


    /*
    =========================================================
    IBR
    =========================================================
    */

    $ibrSelected =
        $_POST['br']['selected'] ?? 0;

    $ibrHolidayAccount =
        $_POST['br']['holiday_account'] ?? 0;

    $ibrHolidayBooking =
        $_POST['br']['holiday_booking'] ?? 0;


    /*
    =========================================================
    VALIDATION
    =========================================================
    */

    if (empty($institutionId)) {

        echo json_encode([
            'status' => false,
            'message' => 'Institution ID is required.'
        ]);

        exit;
    }


    /*
    =========================================================
    AT LEAST ONE DOWNLINE REQUIRED
    =========================================================
    */

    if (
        (int)$tcSelected === 0 &&
        (int)$ibrSelected === 0
    ) {

        echo json_encode([
            'status' => false,
            'message' => 'Please select at least one downline.'
        ]);

        exit;
    }


    /*
    =========================================================
    NORMALIZE VALUES
    =========================================================
    */

    $tcSelected = (int)$tcSelected;

    $ibrSelected = (int)$ibrSelected;


    /*
    =========================================================
    TC VALUES
    =========================================================
    */

    if ($tcSelected === 1) {

        $tcHolidayAccount =
            $tcHolidayAccount ?: 0;

        $tcBookingAmount =
            $tcBookingAmount ?: 0;

    } else {

        $tcHolidayAccount = 0;

        $tcBookingAmount = 0;
    }


    /*
    =========================================================
    IBR VALUES
    =========================================================
    */

    if ($ibrSelected === 1) {

        $ibrHolidayAccount =
            $ibrHolidayAccount ?: 0;

        $ibrHolidayBooking =
            $ibrHolidayBooking ?: 0;

    } else {

        $ibrHolidayAccount = 0;

        $ibrHolidayBooking = 0;
    }


    /*
    =========================================================
    START TRANSACTION
    =========================================================
    */

    $conn->beginTransaction();


    /*
    =========================================================
    STEP 1
    CHECK FOR CURRENT ACTIVE ENTRY
    =========================================================
    */

    $checkSql = "

        SELECT id

        FROM institute_downline_details

        WHERE institution_id = :institution_id
        AND status = 1

        LIMIT 1

    ";

    $checkStmt =
        $conn->prepare($checkSql);

    $checkStmt->execute([
        ':institution_id' => $institutionId
    ]);

    $activeRecord =
        $checkStmt->fetch(PDO::FETCH_ASSOC);


    /*
    =========================================================
    STEP 2
    DEACTIVATE PREVIOUS ACTIVE ENTRY
    ONLY IF IT EXISTS
    =========================================================
    */

    if ($activeRecord) {

        $updateSql = "

            UPDATE institute_downline_details

            SET
                status = 2,
                deleted_date = :deleted_date

            WHERE id = :id
            AND status = 1

        ";

        $updateStmt =
            $conn->prepare($updateSql);

        $updateStmt->execute([

            ':deleted_date' =>
                date('Y-m-d H:i:s'),

            ':id' =>
                $activeRecord['id']
        ]);
    }


    /*
    =========================================================
    STEP 3
    INSERT NEW ACTIVE ENTRY
    =========================================================
    */

    $insertSql = "

        INSERT INTO institute_downline_details
        (
            institution_id,
            downline_tc,
            downline_ibr,
            payout_holiday_account_tc,
            payout_holiday_account_ibr,
            payout_holiday_booking_tc,
            payout_holiday_booking_ibr,
            status
        )

        VALUES
        (
            :institution_id,
            :downline_tc,
            :downline_ibr,
            :payout_holiday_account_tc,
            :payout_holiday_account_ibr,
            :payout_holiday_booking_tc,
            :payout_holiday_booking_ibr,
            :status
        )

    ";

    $insertStmt =
        $conn->prepare($insertSql);

    $insertStmt->execute([

        ':institution_id' =>
            $institutionId,

        ':downline_tc' =>
            $tcSelected,

        ':downline_ibr' =>
            $ibrSelected,

        ':payout_holiday_account_tc' =>
            $tcHolidayAccount,

        ':payout_holiday_account_ibr' =>
            $ibrHolidayAccount,

        ':payout_holiday_booking_tc' =>
            $tcBookingAmount,

        ':payout_holiday_booking_ibr' =>
            $ibrHolidayBooking,

        ':status' =>
            1
    ]);


    /*
    =========================================================
    COMMIT
    =========================================================
    */

    $conn->commit();


    /*
    =========================================================
    SUCCESS RESPONSE
    =========================================================
    */

    echo json_encode([

        'status' => true,

        'message' =>
            'Downline details saved successfully.'
    ]);


} catch (PDOException $e) {

    /*
    =========================================================
    ROLLBACK
    =========================================================
    */

    if ($conn->inTransaction()) {

        $conn->rollBack();
    }


    /*
    =========================================================
    ERROR RESPONSE
    =========================================================
    */

    echo json_encode([

        'status' => false,

        'message' =>
            'Database error occurred.'

        // For development:
        // 'error' => $e->getMessage()
    ]);
}

exit;