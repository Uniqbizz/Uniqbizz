<?php
include(__DIR__ . '/../../connect.php');
function parseFaqTxt($filePath)
{
    if (!file_exists($filePath)) {
        return [];
    }

    $content = file_get_contents($filePath);

    preg_match_all('/Q:\s*(.*?)\s*A:\s*(.*?)(?=\n\s*Q:|$)/is', $content, $matches, PREG_SET_ORDER);

    $faqs = [];

    foreach ($matches as $match) {
        $faqs[] = [
            'question' => trim($match[1]),
            'answer'   => trim($match[2])
        ];
    }

    return $faqs;
}
$chainMap = [
    'CU->IBR->I->SF'                 => 1,
    'CU->IBR->I->MF'                 => 2,
    'CU->IBR->I->BM'                 => 3,
    'CU->IBR->I->ETE->CTE'           => 4,

    'CU->TA->I->SF'                  => 5,
    'CU->TA->I->MF'                  => 6,
    'CU->TA->I->BM'                  => 7,
    'CU->TA->I->ETE->CTE'            => 8,

    'CU->TA->TE->SF'                 => 9,
    'CU->TA->TE->MF'                 => 10,
    'CU->TA->TE->BM'                 => 11,
    'CU->TA->TE->STE->ETE->CTE'      => 12,

    'CU->TA->CA->SF'                 => 13,
    'CU->TA->CA->MF'                 => 14,
    'CU->TA->CA->BM'                 => 15,
    'CU->TA->CA->STE->ETE->CTE'      => 16,

    'CU->TA->F->SF'                  => 17,
    'CU->TA->F->MF'                  => 18,
    'CU->TA->F->BM'                  => 19,
    'CU->TA->F->STE->ETE->CTE'       => 20,

    'CU->TA->BM'                     => 21
];
$upperChain =[];
$upperChainString = null;
$upperChainId = null;
$upperChainReference = null;
$upperChainPrefix = null;
$customerReferrals = [];
$chainDetails = [];
//gst
$stmt = $conn->prepare("SELECT * FROM `gst` ORDER BY id DESC");
$stmt->execute();
$gst=$stmt->fetch();
// =====================================================
// DETERMINE PREFIX AND FETCH USER DETAILS
// =====================================================

$userDetails = [];
$customerType = '';
$prefix = '';

if (preg_match('/^(CU|TA|TE|CA|F|I|BM|BH|CTE|ETE|STE|IBR)/i', (string)$user_id, $matches)) {
    $prefix = strtoupper($matches[1]);
}

// Map prefix to the respective table.
// IMPORTANT: Set each id_column to the actual identifier column
// used by your database table.
$tableMap = [
    'CU'  => ['table' => 'ca_customer',                 'id_column' => 'ca_customer_id',                'type'=>'Customer'],
    'TA'  => ['table' => 'ca_travelagency',             'id_column' => 'ca_travelagency_id',            'type'=>'Travel Consultant'],
    'TE'  => ['table' => 'corporate_agency',            'id_column' => 'corporate_agency_id',           'type'=>'Techno Enterprise'],
    'CA'  => ['table' => 'corporate_agency',            'id_column' => 'corporate_agency_id',           'type'=>'Techno Enterprise'],
    'F'   => ['table' => 'sub_franchisee',              'id_column' => 'sub_franchisee_id',             'type'=>'Franchisee'],
    'I'   => ['table' => 'institution',                 'id_column' => 'institution_id',                'type'=>'Institution'],
    'IBR' => ['table' => 'institution_branch_manager',  'id_column' => 'institution_branch_manager_id', 'type'=>'Institution Branch manager'],
    'BM'  => ['table' => 'business_mentor',             'id_column' => 'business_mentor_id',            'type'=>'Business Mentor'],
    'BH'  => ['table' => 'employees',                   'id_column' => 'employee_id',                   'type'=>'Business Developement manager'],
    'CTE' => ['table' => 'chief_techno_enterprise',     'id_column' => 'chief_techno_enterprise_id',    'type'=>'Chief Techno Enterprise'],
    'ETE' => ['table' => 'executive_techno_enterprise', 'id_column' => 'executive_techno_enterprise_id','type'=>'Executive Techno Enterprise'],
    'STE' => ['table' => 'super_techno_enterprise',     'id_column' => 'super_techno_enterprise_id',    'type'=>'Super Techno Enterprise']
];
$Requester_type = 'Guest User';
if ($prefix !== '' && isset($tableMap[$prefix])) {

    $table = $tableMap[$prefix]['table'];
    $idColumn = $tableMap[$prefix]['id_column'];
    $Requester_type = $prefix != 'CU' ? $tableMap[$prefix]['type']:'';

    // Remove the prefix to get the numeric database ID.
    $numericId = substr((string)$user_id, strlen($prefix));

    if (ctype_digit($numericId) && (int)$numericId > 0) {

        // Table and column names come only from the fixed whitelist above.
        $sql = "SELECT * FROM `$table` WHERE `$idColumn` = :id LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id' => $user_id
        ]);

        $userDetails = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

        // Determine customer type only for CU.
        if ($prefix == 'CU') {
            $Requester_type = trim($userDetails['customer_type'] ?? '');
        }
    }
}


/**
 * Resolve the complete upper chain for a CU customer.
 *
 * Required:
 *   $conn   = PDO connection
 *   $userId = customer ID from ca_customer
 *
 * Returns:
 *   success
 *   chain
 *   upper_chain_id
 *   chain_details
 *   upper_chain_reference
 *   upper_chain_prefix
 *   error
 */

/**
 * Get the prefix from a reference.
 */
function getReferencePrefix($reference)
{
    $reference = strtoupper(trim((string) $reference));

    if ($reference === '') {
        return null;
    }

    // Check longer prefixes first.
    $prefixes = [
        'CTE', 'ETE', 'STE', 'IBR',
        'BH', 'SF', 'MF', 'BM',
        'TA', 'TE', 'CA', 'F', 'I'
    ];

    foreach ($prefixes as $prefix) {
        if (strpos($reference, $prefix) === 0) {
            return $prefix;
        }
    }

    return null;
}


/**
 * Fetch a record by its ID/reference column.
 */
function getChainRecord($conn, $table, $idColumn, $reference)
{
    $allowedTables = [
        'ca_customer',
        'ca_travelagency',
        'institution_branch_manager',
        'institution',
        'corporate_agency',
        'sub_franchisee',
        'super_techno_enterprise',
        'executive_techno_enterprise',
        'chief_techno_enterprise',
        'sponsor_franchisee',
        'master_franchisee',
        'business_mentor',
        'employees'
    ];

    $allowedColumns = [
        'ca_customer_id',
        'ca_travelagency_id',
        'institution_branch_manager_id',
        'institution_id',
        'corporate_agency_id',
        'sub_franchisee_id',
        'super_techno_enterprise_id',
        'executive_techno_enterprise_id',
        'chief_techno_enterprise_id',
        'sponsor_franchisee_id',
        'master_franchisee_id',
        'business_mentor_id',
        'employee_id'
    ];

    if (
        !in_array($table, $allowedTables, true) ||
        !in_array($idColumn, $allowedColumns, true)
    ) {
        throw new InvalidArgumentException(
            'Invalid table or column: ' . $table . '.' . $idColumn
        );
    }

    $sql = "SELECT *
            FROM `$table`
            WHERE `$idColumn` = :reference
            LIMIT 1";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':reference' => $reference
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}


/**
 * Resolve the upper chain by following reference_no.
 */
function resolveUpperChain($conn, $initialReference)
{
    $chain = ['CU'];
    $chainDetails = [];

    $reference = trim((string) $initialReference);

    $visited = [];

    for ($step = 0; $step < 10; $step++) {

        if ($reference === '') {
            return [
                'success' => false,
                'error' => 'A required reference_no is empty.',
                'chain' => implode('->', $chain),
                'chain_details' => $chainDetails
            ];
        }

        // Prevent circular references.
        $visitKey = strtoupper($reference);

        if (isset($visited[$visitKey])) {
            return [
                'success' => false,
                'error' => 'Circular reference detected: ' . $reference,
                'chain' => implode('->', $chain),
                'chain_details' => $chainDetails
            ];
        }

        $visited[$visitKey] = true;

        $prefix = getReferencePrefix($reference);

        if ($prefix === null) {
            return [
                'success' => false,
                'error' => 'Unknown reference prefix: ' . $reference,
                'chain' => implode('->', $chain),
                'chain_details' => $chainDetails
            ];
        }

        $chain[] = $prefix;

        /*
         * Terminal records:
         * Stop after retrieving these records.
         */
        $terminalTables = [
            'SF'  => [
                'sponsor_franchisee',
                'sponsor_franchisee_id'
            ],
            'MF'  => [
                'master_franchisee',
                'master_franchisee_id'
            ],
            'BM'  => [
                'business_mentor',
                'business_mentor_id'
            ],
            'CTE' => [
                'chief_techno_enterprise',
                'chief_techno_enterprise_id'
            ]
        ];

        if (isset($terminalTables[$prefix])) {

            [$table, $idColumn] = $terminalTables[$prefix];

            $record = getChainRecord(
                $conn,
                $table,
                $idColumn,
                $reference
            );

            if (!$record) {
                return [
                    'success' => false,
                    'error' => "Record not found in {$table}: {$reference}",
                    'chain' => implode('->', $chain),
                    'chain_details' => $chainDetails
                ];
            }

            $chainDetails[] = getChainLevelDetails(
                $prefix,
                $record,
                $reference
            );

            return [
                'success' => true,
                'chain' => implode('->', $chain),
                'chain_details' => $chainDetails,
                'upper_chain_reference' => $reference,
                'upper_chain_prefix' => $prefix
            ];
        }

        /*
         * Non-terminal records.
         */
        $tableMap = [
            'TA' => [
                'ca_travelagency',
                'ca_travelagency_id'
            ],
            'IBR' => [
                'institution_branch_manager',
                'institution_branch_manager_id'
            ],
            'I' => [
                'institution',
                'institution_id'
            ],
            'TE' => [
                'corporate_agency',
                'corporate_agency_id'
            ],
            'CA' => [
                'corporate_agency',
                'corporate_agency_id'
            ],
            'F' => [
                'sub_franchisee',
                'sub_franchisee_id'
            ],
            'STE' => [
                'super_techno_enterprise',
                'super_techno_enterprise_id'
            ],
            'ETE' => [
                'executive_techno_enterprise',
                'executive_techno_enterprise_id'
            ],
            'BH' => [
                'employees',
                'employee_id'
            ]
        ];

        if (!isset($tableMap[$prefix])) {
            return [
                'success' => false,
                'error' => 'Unsupported upper-chain prefix: ' . $prefix,
                'chain' => implode('->', $chain),
                'chain_details' => $chainDetails
            ];
        }

        [$table, $idColumn] = $tableMap[$prefix];

        $record = getChainRecord(
            $conn,
            $table,
            $idColumn,
            $reference
        );

        if (!$record) {
            return [
                'success' => false,
                'error' => "Record not found in {$table}: {$reference}",
                'chain' => implode('->', $chain),
                'chain_details' => $chainDetails
            ];
        }

        $chainDetails[] = getChainLevelDetails(
            $prefix,
            $record,
            $reference
        );

        /*
         * Move to the next upper level.
         */
        if (!array_key_exists('reference_no', $record)) {
            return [
                'success' => false,
                'error' => "reference_no column missing in {$table}.",
                'chain' => implode('->', $chain),
                'chain_details' => $chainDetails
            ];
        }

        $reference = trim((string) $record['reference_no']);

        if ($reference === '') {
            return [
                'success' => false,
                'error' => "reference_no is empty in {$table}.",
                'chain' => implode('->', $chain),
                'chain_details' => $chainDetails
            ];
        }
    }

    return [
        'success' => false,
        'error' => 'Maximum upper-chain depth exceeded.',
        'chain' => implode('->', $chain),
        'chain_details' => $chainDetails
    ];
}


/**
 * Main function for a CU customer.
 */
function getCustomerUpperChain($conn, $userId)
{
    // Access the chain map defined outside this function.
    global $chainMap;

    /*
     * 1. Fetch the CU customer.
     */
    $stmt = $conn->prepare("
        SELECT *
        FROM ca_customer
        WHERE ca_customer_id = :customer_id
        LIMIT 1
    ");

    $stmt->execute([
        ':customer_id' => $userId
    ]);

    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$customer) {
        return [
            'success' => false,
            'error' => 'Customer not found.'
        ];
    }

    $taReference = trim(
        (string) ($customer['ta_reference_no'] ?? '')
    );

    if ($taReference === '') {
        return [
            'success' => false,
            'error' => 'Customer ta_reference_no is empty.'
        ];
    }

    /*
     * 2. Resolve the upper chain.
     */
    $result = resolveUpperChain(
        $conn,
        $taReference
    );

    if (empty($result['success'])) {

        // Keep the CU customer details even if a higher level fails.
        $customerDetails = getChainLevelDetails(
            'CU',
            $customer,
            $customer['ca_customer_id']
        );

        $result['chain_details'] = array_merge(
            [$customerDetails],
            $result['chain_details'] ?? []
        );

        return $result;
    }

    /*
     * 3. Build the complete chain details, starting with CU.
     */
    $chain = $result['chain'];

    $customerDetails = getChainLevelDetails(
        'CU',
        $customer,
        $customer['ca_customer_id']
    );

    $chainDetails = array_merge(
        [$customerDetails],
        $result['chain_details'] ?? []
    );

    /*
     * 4. Verify that the global chain map exists.
     */
    if (!isset($chainMap) || !is_array($chainMap)) {
        return [
            'success' => false,
            'error' => 'Global $chainMap is missing or is not an array.',
            'chain' => $chain,
            'chain_details' => $chainDetails
        ];
    }

    /*
     * 5. Find the mapped chain ID.
     */
    if (!array_key_exists($chain, $chainMap)) {
        return [
            'success' => false,
            'error' => 'The chain is valid, but no chain ID is mapped.',
            'chain' => $chain,
            'chain_details' => $chainDetails,
            'available_chain_keys' => array_keys($chainMap)
        ];
    }

    return [
        'success' => true,
        'chain' => $chain,
        'upper_chain_id' => $chainMap[$chain],
        'chain_details' => $chainDetails,
        'upper_chain_reference' => $result['upper_chain_reference'],
        'upper_chain_prefix' => $result['upper_chain_prefix']
    ];
}


/**
 * Retrieve up to $maxLevels of CU referrals.
 *
 * This is separate from the upper-chain lookup.
 */
function getCustomerReferralLevels(
    PDO $conn,
    $customerId,
    $maxLevels = 3
) {
    $referralLevels = [];
    $visited = [];

    $stmt = $conn->prepare("
        SELECT ca_customer_id, reference_no
        FROM ca_customer
        WHERE ca_customer_id = :customer_id
        LIMIT 1
    ");

    $stmt->execute([
        ':customer_id' => $customerId
    ]);

    $currentCustomer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$currentCustomer) {
        return [
            'success' => false,
            'error' => 'Starting customer not found.',
            'referral_levels' => []
        ];
    }

    $visited[(string) $currentCustomer['ca_customer_id']] = true;

    for ($level = 1; $level <= $maxLevels; $level++) {

        $referenceNo = trim(
            (string) ($currentCustomer['reference_no'] ?? '')
        );

        if ($referenceNo === '') {
            break;
        }

        // Assumes reference_no contains the referrer's CU primary key.
        $stmt = $conn->prepare("
            SELECT ca_customer_id, reference_no
            FROM ca_customer
            WHERE ca_customer_id = :reference_no
            LIMIT 1
        ");

        $stmt->execute([
            ':reference_no' => $referenceNo
        ]);

        $referrer = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$referrer) {
            $referralLevels[] = [
                'level' => $level,
                'reference_no' => $referenceNo,
                'exists' => false,
                'error' => 'Referring customer not found.'
            ];

            break;
        }

        $referrerId = (string) $referrer['ca_customer_id'];

        if (isset($visited[$referrerId])) {
            $referralLevels[] = [
                'level' => $level,
                'customer_id' => $referrerId,
                'exists' => true,
                'error' => 'Circular customer referral detected.'
            ];

            break;
        }

        $visited[$referrerId] = true;

        $referralLevels[] = [
            'level' => $level,
            'customer_id' => $referrerId,
            'reference_no' => $referrer['reference_no'],
            'exists' => true
        ];

        $currentCustomer = $referrer;
    }

    return [
        'success' => true,
        'referral_levels' => $referralLevels
    ];
}


/**
 * Extract the name and ID for each chain level.
 */
function getChainLevelDetails($prefix, array $record, $reference)
{
    $prefix = strtoupper(trim((string) $prefix));

    $idColumns = [
        'CU' => 'ca_customer_id',
        'TA' => 'ca_travelagency_id',
        'IBR' => 'institution_branch_manager_id',
        'I' => 'institution_id',
        'TE' => 'corporate_agency_id',
        'CA' => 'corporate_agency_id',
        'F' => 'sub_franchisee_id',
        'STE' => 'super_techno_enterprise_id',
        'ETE' => 'executive_techno_enterprise_id',
        'CTE' => 'chief_techno_enterprise_id',
        'SF' => 'sponsor_franchisee_id',
        'MF' => 'master_franchisee_id',
        'BM' => 'business_mentor_id',
        'BH' => 'employee_id'
    ];

    $idColumn = $idColumns[$prefix] ?? null;

    $id = (
        $idColumn !== null &&
        isset($record[$idColumn])
    )
        ? $record[$idColumn]
        : $reference;

    // BH and I use a single name column.
    if (in_array($prefix, ['BH', 'I'], true)) {

        $name = trim(
            (string) ($record['name'] ?? '')
        );

    } else {

        $firstName = trim(
            (string) ($record['firstname'] ?? '')
        );

        $lastName = trim(
            (string) ($record['lastname'] ?? '')
        );

        $name = trim($firstName . ' ' . $lastName);

        // Fallback for tables with a single name column.
        if ($name === '') {
            $name = trim(
                (string) ($record['name'] ?? '')
            );
        }
    }

    return [
        'prefix' => $prefix,
        'name' => $name,
        'id' => (string) $id
    ];
}


/*
 * ==========================================================
 * USAGE AND BROWSER CONSOLE DEBUGGING
 * ==========================================================
 *
 * Assumes:
 *   $conn     = existing PDO connection
 *   $prefix   = logged-in user's prefix
 *   $user_id  = CU customer's primary key
 *   $chainMap = defined globally before this code executes
 */

if (strtoupper(trim((string) $prefix)) === 'CU') {

    try {

        // error_log('========== UPPER CHAIN DEBUG START ==========');

        $upperChain = getCustomerUpperChain(
            $conn,
            $user_id
        );

        $customerReferrals = getCustomerReferralLevels(
            $conn,
            $user_id,
            3
        );

        if (!empty($upperChain['success'])) {

            $upperChainString = $upperChain['chain'];
            $upperChainId = $upperChain['upper_chain_id'];
            $upperChainReference = $upperChain['upper_chain_reference'];
            $upperChainPrefix = $upperChain['upper_chain_prefix'];

            // IMPORTANT: Copy the returned details into the outer variable.
            $chainDetails = $upperChain['chain_details'] ?? [];

        } else {

            // Preserve any chain details returned with an error.
            $chainDetails = $upperChain['chain_details'] ?? [];

            error_log(
                'Upper chain failed: ' .
                ($upperChain['error'] ?? 'Unknown error')
            );
        }

        /*
         * Log complete results in the PHP error log.
         */
        // error_log(
        //     'Upper Chain Result: ' .
        //     print_r($upperChain, true)
        // );

        // error_log(
        //     'Customer Referrals: ' .
        //     print_r($customerReferrals, true)
        // );

        // error_log('========== UPPER CHAIN DEBUG END ==========');

        /*
         * Send results to the browser console.
         */
        $debugData = [
            'prefix' => $prefix,
            'user_id' => $user_id,
            'upper_chain' => $upperChain,
            'customer_referrals' => $customerReferrals,
            'chain_map' => isset($chainMap) && is_array($chainMap)
                ? $chainMap
                : null
        ];

        $debugJson = json_encode(
            $debugData,
            JSON_HEX_TAG |
            JSON_HEX_APOS |
            JSON_HEX_QUOT |
            JSON_HEX_AMP
        );

        if ($debugJson === false) {
            $debugJson = '{}';
        }

        echo '<script>
            (function () {
                var debugData = ' . $debugJson . ';

                console.group("CU Upper Chain Debug");

                console.log("Prefix:", debugData.prefix);
                console.log("User ID:", debugData.user_id);

                console.log(
                    "Upper Chain Result:",
                    debugData.upper_chain
                );

                console.log(
                    "Resolved Chain:",
                    debugData.upper_chain.chain || null
                );

                console.log(
                    "Upper Chain ID:",
                    debugData.upper_chain.upper_chain_id || null
                );

                console.log(
                    "Chain Details (all levels):",
                    debugData.upper_chain.chain_details || []
                );

                console.table(
                    debugData.upper_chain.chain_details || []
                );

                console.log(
                    "Customer Referrals:",
                    debugData.customer_referrals
                );

                console.log(
                    "Global Chain Map:",
                    debugData.chain_map
                );

                console.groupEnd();
            })();
        </script>';

    } catch (Throwable $e) {

        error_log(
            'Upper chain exception: ' .
            $e->getMessage()
        );

        error_log(
            'Upper chain exception trace: ' .
            $e->getTraceAsString()
        );

        $exceptionJson = json_encode(
            [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ],
            JSON_HEX_TAG |
            JSON_HEX_APOS |
            JSON_HEX_QUOT |
            JSON_HEX_AMP
        );

        if ($exceptionJson === false) {
            $exceptionJson = '{}';
        }

        echo '<script>
            console.error(
                "Upper Chain PHP Exception:",
                ' . $exceptionJson . '
            );
        </script>';
    }
}
$suspenseAmount = 0.00;
$customerCom1=0.00;
$customerCom2=0.00;
$customerCom3=0.00;
/*
|--------------------------------------------------------------------------
| Package Pricing
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package_pricing WHERE package_id = :package_id");
$stmt->execute([':package_id' => $id]);
$packagePricing = $stmt->fetch(PDO::FETCH_ASSOC);
/*
|--------------------------------------------------------------------------
| Package Pricing Markup
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package_pricing_markup WHERE package_id = :package_id");
$stmt->execute([':package_id' => $id]);
$packagePricingMarkup = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Package Pricing Markup TE Chain
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package_pricing_markup_te_chain WHERE package_id = :package_id");
$stmt->execute([':package_id' => $id]);
$packagePricingTeChain = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Package Pricing Markup Institution
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package_pricing_markup_institution WHERE package_id = :package_id");
$stmt->execute([':package_id' => $id]);
$packagePricingInstitution = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Package Pricing Markup Techno Institution
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("SELECT * FROM package_pricing_markup_techno_institution WHERE package_id = :package_id");
$stmt->execute([':package_id' => $id]);
$packagePricingTechnoInstitution = $stmt->fetch(PDO::FETCH_ASSOC);

if (is_array($upperChain) && !empty($upperChain)) {

    $upperChainId = isset($upperChainId) ? (int) $upperChainId : 0;

    if (in_array($upperChainId, [1, 2, 3, 5, 6, 7], true)) {

        // package_pricing_markup_institution
        $suspenseAmount = $packagePricingInstitution['suspense'] ?? 0.00;
        $customerCom1=$packagePricingInstitution['prime_customer']?? 0.00;
        $customerCom2=$packagePricingInstitution['L1_customer']?? 0.00;
        $customerCom3=$packagePricingInstitution['L2_customer']?? 0.00;

    } elseif (in_array($upperChainId, [4, 8], true)) {

        // package_pricing_markup_techno_institution
        $suspenseAmount = $packagePricingTechnoInstitution['suspense'] ?? 0.00;
        $customerCom1=$packagePricingTechnoInstitution['prime_customer']?? 0.00;
        $customerCom2=$packagePricingTechnoInstitution['L1_customer']?? 0.00;
        $customerCom3=$packagePricingTechnoInstitution['L2_customer']?? 0.00;

    } elseif (in_array($upperChainId, [9, 10, 11, 13, 14, 15, 17, 18, 19,21], true)) {

        // package_pricing_markup
        $suspenseAmount = $packagePricingMarkup['suspense'] ?? 0.00;
        $customerCom1=$packagePricingMarkup['prime_customer']?? 0.00;
        $customerCom2=$packagePricingMarkup['L1_customer']?? 0.00;
        $customerCom3=$packagePricingMarkup['L2_customer']?? 0.00;

    } elseif (in_array($upperChainId, [12, 16, 20], true)) {

        // package_pricing_markup_te_chain
        $suspenseAmount = $packagePricingTeChain['suspense'] ?? 0.00;
        $customerCom1=$packagePricingTeChain['prime_customer']?? 0.00;
        $customerCom2=$packagePricingTeChain['L1_customer']?? 0.00;
        $customerCom3=$packagePricingTeChain['L2_customer']?? 0.00;

    } else {

        // No matching upper chain ID
    }
}
echo'<script>
        console.log("suspence:"+'.$suspenseAmount.')
        console.log("prime:"+'.$customerCom1.')
        console.log("l1:"+'.$customerCom2.')
        console.log("l2:"+'.$customerCom3.')
    </script>';
// =====================================================
// COUPONS AND WALLETS FOR CU
// =====================================================

$cuCoupons = [];
$loyaltyCoupons = [];
$referralBalance = 0;
$discountBalance = 0;

if (
    $prefix === 'CU' &&
    !empty($userDetails) 
) {
    $stmt1 = $conn->prepare("
        SELECT *
        FROM cu_coupons
        WHERE user_id = :user_id
          AND usage_status = 0
          AND confirm_status = 1
    ");

    $stmt1->execute([':user_id' => $user_id]);
    $cuCoupons = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    $stmt2 = $conn->prepare("
        SELECT *
        FROM loyalty_coupon
        WHERE user_id = :user_id
          AND usage_status = 0
          AND confirm_status = 1
    ");

    $stmt2->execute([':user_id' => $user_id]);
    $loyaltyCoupons = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    // Neo Select customers only.
    if (strcasecmp($Requester_type , 'Neo Select') === 0) {

        $stmt3 = $conn->prepare("
            SELECT balance
            FROM customer_reference_wallet_utilization
            WHERE customer_id = :user_id
            ORDER BY id DESC
            LIMIT 1
        ");

        $stmt3->execute([':user_id' => $user_id]);
        $referralWallet = $stmt3->fetch(PDO::FETCH_ASSOC);

        $referralBalance = (float)($referralWallet['balance'] ?? 0);

        $stmt4 = $conn->prepare("
            SELECT balance
            FROM customer_discount_wallet_utilization
            WHERE customer_id = :user_id
            ORDER BY id DESC
            LIMIT 1
        ");

        $stmt4->execute([':user_id' => $user_id]);
        $discountWallet = $stmt4->fetch(PDO::FETCH_ASSOC);

        $discountBalance = (float)($discountWallet['balance'] ?? 0);
    }
    else if (strcasecmp($Requester_type , 'Neo Select') !== 0) { // noe neo select

        $stmt3 = $conn->prepare("
            SELECT balance
            FROM customer_reference_wallet_utilization
            WHERE customer_id = :user_id
            ORDER BY id DESC
            LIMIT 1
        ");

        $stmt3->execute([':user_id' => $user_id]);
        $referralWallet = $stmt3->fetch(PDO::FETCH_ASSOC);
        $referralBalance = (float)($referralWallet['balance'] ?? 0);
        $discountBalance = 0;
    }
}
// package
$sql = "SELECT * 
        FROM package 
        WHERE id = :id ";


$stmt = $conn->prepare($sql);
$stmt->execute([
    ':id' => $id
]);
$package = $stmt->fetch();
$cat_id = $package['category_id'];
$sub_cat_id = $package['sub_category_id'];
$hotel_cat_id = $package['category_hotel_id'];
$meal_cat_id = $package['category_meal_id'];
$validity = $package['validity'] ?? 0;
$package_keywords = $package['package_keywords'] ?? '';
$location  = $package['location'] ?? '';
$destination = $package['destination'] ?? '';
$package_type = $package['package_type'] ?? '';
$category_vehicle_id = $package['category_vehicle_id'] ?? '';

$tour_days_total = $package['tour_days'] - 1  ?? 0;
$tour_days = $tour_days_total - 1;
$tour_nights = $tour_days_total - 2;

// itinery 
$data2 = $conn->prepare("SELECT * FROM package_itinerary_details WHERE package_id = $id");
$data2->execute();
$itinery = $data2->fetch();

// package_pricing 
$data3 = $conn->prepare("SELECT * FROM package_pricing WHERE package_id = $id");
$data3->execute();
$amount = $data3->fetch();

// category 
$data5 = $conn->prepare("SELECT * FROM category WHERE id = $cat_id");
$data5->execute();
$category = $data5->fetch();

// sub_cat 
$data6 = $conn->prepare("SELECT * FROM subcategory WHERE id = $sub_cat_id");
$data6->execute();
$sub_cat = $data6->fetch();

// cat hotel 
$data7 = $conn->prepare("SELECT * FROM category_hotel WHERE id = $hotel_cat_id");
$data7->execute();
if ($data7->rowCount() > 0) {
    $hotel_cat = $data7->fetch();
} else {
    $hotel_cat = "null";
}

// cat meal 
$data8 = $conn->prepare("SELECT * FROM category_meal WHERE id = $meal_cat_id");
$data8->execute();
if ($data8->rowCount() > 0) {
    $meal_cat = $data8->fetch();
} else {
    $meal_cat = "null";
}

// Fetch occupancy types for a given package_id
$data9 = $conn->prepare("SELECT * FROM `package_to_category_occupancy` WHERE package_id = :id");
$data9->bindParam(':id', $id, PDO::PARAM_INT);
$data9->execute();
$occu_type = $data9->rowCount() > 0 ? $data9->fetchAll(PDO::FETCH_ASSOC) : [];

// Fetch all occupancy categories
$data10 = $conn->prepare("SELECT id, name FROM `category_occupancy`");
$data10->execute();
$occu_type_id = $data10->rowCount() > 0 ? $data10->fetchAll(PDO::FETCH_ASSOC) : [];

// Fetch vehicle types for a given package_id
$data11 = $conn->prepare("SELECT * FROM `package_to_category_vehicle` WHERE package_id = :id");
$data11->bindParam(':id', $id, PDO::PARAM_INT);
$data11->execute();
$vehicle_type = $data11->rowCount() > 0 ? $data11->fetchAll(PDO::FETCH_ASSOC) : []; // Corrected variable name

// Fetch vehicle types for a given package_id
$data11 = $conn->prepare("
    SELECT *
    FROM package_pricing
    WHERE package_id = :id
    ORDER BY id DESC
    LIMIT 1
");

$data11->bindParam(':id', $id, PDO::PARAM_INT);
$data11->execute();

$pricing = $data11->fetch(PDO::FETCH_ASSOC) ?: [];

// Fetch all vehicle categories
$data12 = $conn->prepare("SELECT id, name FROM `category_vehicle`");
$data12->execute();
$vehicle_type_id = $data12->rowCount() > 0 ? $data12->fetchAll(PDO::FETCH_ASSOC) : []; // Corrected variable name

//cancellation policy
$data9 = $conn->prepare("SELECT * FROM cancel_policy WHERE package_id = $id");
$data9->execute();
if ($data9->rowCount() > 0) {
    $cancel_policy = $data9->fetch();
} else {
    $cancel_policy['policy_1'] = 0;
    $cancel_policy['policy_2'] = 0;
    $cancel_policy['policy_3'] = 0;
    $cancel_policy['policy_4'] = 0;
    $cancel_policy['policy_5'] = 0;
}
//ta markup
// if($user_type_id_value == '11'){
//     $ta_markup_data = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id = '" . $user_id . "' AND package_id = '" . $id . "' LIMIT 1");
//     $ta_markup_data->execute();
//     $ta_markup = $ta_markup_data->fetch();
//     if ($ta_markup) {
//         $ta_markup_price_val = $ta_markup['markup'] ?? 0;
//     }else {
//         $ta_markup_price_val = 0;
//     } 
// }else {
//     $ta_markup_price_val = 0;
// }
$stmtPolicy = $conn->prepare("
    SELECT title, file_name
    FROM package_policy_document
    WHERE package_id = ?
    ORDER BY id ASC
");

$stmtPolicy->execute([$id]);
$policies = $stmtPolicy->fetchAll(PDO::FETCH_ASSOC);
//share model start 30-07-2026

$title = "Bizzmirth Holidays Pvt Ltd";
$description = "Get latest and best deal on holiday packages";
$siteName = "Holiday Packages";

/*
|--------------------------------------------------------------------------
| Replace this with your thumbnail image URL
|--------------------------------------------------------------------------
|
| Recommended size: 1200x630 px
| Must be publicly accessible.
|
*/
$image = "http://localhost/ca.uniqbizz.com/admin/assets/images/fav.png";

$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
    ? "https"
    : "http")
    . "://"
    . $_SERVER['HTTP_HOST']
    . $_SERVER['REQUEST_URI'];

//share model end
//package similar list
// Get latest 10 packages
$sql = "
    SELECT *
    FROM package
    WHERE status = 1
    AND id != ?
    AND (
        package_keywords LIKE ?
        OR destination LIKE ?
        OR location LIKE ?
        OR package_type LIKE ?
    )

    ORDER BY
        CASE
            WHEN destination LIKE ? THEN 1
            WHEN location LIKE ? THEN 2
            WHEN package_keywords LIKE ? THEN 3
            WHEN package_type LIKE ? THEN 4
            ELSE 5
        END ASC,

        id DESC

    LIMIT 10
";

$keywordSearch    = "%$package_keywords%";
$destinationSearch = "%$destination%";
$locationSearch    = "%$location%";
$typeSearch        = "%$package_type%";

$bindValues = [
    // WHERE
    $id,
    $keywordSearch,
    $destinationSearch,
    $locationSearch,
    $typeSearch,

    // ORDER BY priority
    $keywordSearch,
    $destinationSearch,
    $locationSearch,
    $typeSearch
];

$sqlPack = $conn->prepare($sql);

$sqlPack->execute($bindValues);

$packages = $sqlPack->fetchAll(PDO::FETCH_ASSOC);

$package_array = [];

foreach ($packages as $similarPackage) {

    $sqlPackPrice = $conn->prepare("
        SELECT total_package_price_per_adult
        FROM package_pricing
        WHERE package_id = ?
        ORDER BY id DESC
        LIMIT 1
    ");

    $sqlPackPrice->execute([$similarPackage['id']]);

    $packagePrice = $sqlPackPrice->fetch(PDO::FETCH_ASSOC);

    $sqlPackImage = $conn->prepare("
        SELECT image
        FROM package_pictures
        WHERE package_id = ?
        AND (type IS NULL OR type IN ('cover_image', 'gallary_image'))
        ORDER BY id ASC
    ");

    $sqlPackImage->execute([$similarPackage['id']]);

    $packageImages = $sqlPackImage->fetchAll(PDO::FETCH_COLUMN);

    $days = (int)$similarPackage['tour_days'];
    $nights = max(0, $days - 1);

    $package_duration = $nights . "N / " . $days . "D";

    $package_array[] = [
        "packid"   => $similarPackage['id'],
        "title"    => $similarPackage['name'],
        "duration" => $package_duration,
        "price"    => $packagePrice['total_package_price_per_adult'] ?? 0,
        'images'    => $packageImages,
        "link"     => "tour-details.php?pacId=" . $similarPackage['id']
    ];
}
//guest princinglogic
$userType = $_SESSION['user_type_id_value'] ?? null;

$showGuestPrice = !empty($userType)
    && !in_array((int)$userType, [1, 17, 15]);

$adultPrice = (float)$pricing['total_package_price_per_adult'];
$childPrice = (float)$pricing['total_package_price_per_child'];

$adultDisplayPrice = $adultPrice;
$childDisplayPrice = $childPrice;

if ($showGuestPrice) {

    if (!empty($pricing['guest_amount'])) {

        $guestAmount = (float)$pricing['guest_amount'];

        // Remove guest fixed amount
        $adultDisplayPrice = $adultPrice - $guestAmount;
        $childDisplayPrice = $childPrice - $guestAmount;

    } elseif (!empty($pricing['guest_percentage'])) {

        $percentage = (float)$pricing['guest_percentage'];

        // Remove guest percentage
        $adultDisplayPrice =
            $adultPrice / (1 + ($percentage / 100));

        $childDisplayPrice =
            $childPrice / (1 + ($percentage / 100));
    }
}
$stmt = $conn->prepare("
    SELECT image
    FROM package_pictures
    WHERE package_id = ?
    AND type = 'video'
    ORDER BY id ASC
");

$stmt->execute([$id]);

$packageVideos = $stmt->fetchAll(PDO::FETCH_COLUMN);

function safeJsonDecode($value)
{
    if (empty($value)) {
        return [];
    }

    $decoded = json_decode($value, true);

    return (json_last_error() === JSON_ERROR_NONE && is_array($decoded))
        ? $decoded
        : [];
}
$galleryImages = [];

$galleryData = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = ? AND (type NOT IN ('video') OR type IS NULL)");
$galleryData->execute([$id]);

if ($galleryData->rowCount() > 0) {
    $galleryImages = $galleryData->fetchAll(PDO::FETCH_ASSOC);
}

$coverImage = '';

$coverData = $conn->prepare("
    SELECT image
    FROM package_pictures
    WHERE package_id = ?
      AND type = 'cover_image'
    LIMIT 1
");
$coverData->execute([$id]);

$coverImage = $coverData->fetchColumn() ?: '';

// If no cover image exists, use the first available image.
if ($coverImage === '') {
    $firstImageData = $conn->prepare("
        SELECT image
        FROM package_pictures
        WHERE package_id = ?
          AND (type NOT IN ('video') OR type IS NULL)
        ORDER BY id ASC
        LIMIT 1
    ");

    $firstImageData->execute([$id]);
    $coverImage = $firstImageData->fetchColumn() ?: '';
}
?>