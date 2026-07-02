<?php

    include_once(__DIR__.'/../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $sql = "
            SELECT *
            FROM (

                SELECT
                    cu.id,
                    cu.ca_customer_id,
                    cu.firstname,
                    cu.lastname,
                    cu.contact_no,
                    cu.email,
                    cu.register_date,
                    cu.status,
                    cu.paid_amount AS amount,
                    CONCAT(
                        cu.customer_type,
                        ' / ',
                        CASE
                            WHEN cu.comp_chek = '1' THEN 'Complementary'
                            WHEN cu.comp_chek = '2' THEN 'Non Complementary'
                            ELSE '-'
                        END
                    ) AS type,

                    ta.ca_travelagency_id,
                    ta.firstname AS ref_firstname,
                    ta.lastname AS ref_lastname

                FROM ca_customer cu

                INNER JOIN ca_travelagency ta
                    ON cu.ta_reference_no = ta.ca_travelagency_id

                WHERE cu.reference_no = :user_id
                AND cu.status IN (1,3)
            ) x

            ORDER BY x.id DESC
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status'  => true,
            'message' => 'Customer data fetched successfully',
            'data'    => $data
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'status'  => false,
            'message' => $e->getMessage(),
            'data'    => []
        ]);
    }

    exit;
?>