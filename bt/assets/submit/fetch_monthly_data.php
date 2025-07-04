<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../../connect.php'; // Your PDO setup here

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['monthYear'])) {
    $monthYear = $_POST['monthYear']; // "2025-05"
    $date = explode("-", $monthYear);
    $year = $date[0];
    $month = $date[1];

    function fetchData($conn, $table, $id_field)
    {
        global $month, $year;
        $stmt = $conn->prepare("SELECT * FROM `$table` WHERE MONTH(register_date) = :month AND YEAR(register_date) = :year ORDER BY register_date DESC");
        $stmt->execute(['month' => $month, 'year' => $year]);
        $result = '';
        $srNo = 1;

        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $reg_date = date("d-m-Y", strtotime($row['register_date']));

                // Initialize values
                $registrant = 'NA';
                $reference_no = 'NA';

                if ($table === 'ca_customer') {
                    $registrant = !empty($row['registrant']) ? $row['registrant'] : ($row['ta_reference_name'] ?? '—');
                    $reference_no = !empty($row['reference_no']) ? $row['reference_no'] : ($row['ta_reference_no'] ?? '—');

                } else if ($table === 'employees') {
                    // Fetch reporting manager name from same table where usertype = 24
                    if (!empty($row['reporting_manager'])) {
                        $subStmt = $conn->prepare("SELECT name FROM employees WHERE employee_id = :id AND user_type = '24'");
                        $subStmt->execute(['id' => $row['reporting_manager']]);
                        $manager = $subStmt->fetch(PDO::FETCH_ASSOC);
                        $registrant = $manager ? $manager['name'] : 'NA';
                    } else {
                        $registrant = 'NA';
                    }

                    $reference_no = !empty($row['reporting_manager']) ? $row['reporting_manager'] : 'NA';

                } else {
                    $registrant = $row['registrant'] ?? 'NA';
                    $reference_no = $row['reference_no'] ?? 'NA';
                }

                $result .= '<tr>
                <td><p class="fw-bold text-dark">' . $srNo++ . '</p></td>
                <td class="align-content-center">';
                    if ($table === 'employees') {
                        $result .= '<p class="fw-bold text-dark">' . htmlspecialchars($row['name'] ?? '') . '</p>';
                    } else {
                        $fullName = trim(($row['firstname'] ?? '') . ' ' . ($row['lastname'] ?? ''));
                        $result .= '<p class="fw-bold text-dark">' . htmlspecialchars($fullName) . '</p>';
                    }
                    $result .= '<p class="text-dark">' . htmlspecialchars($row[$id_field] ?? '') . '</p> 
                </td>
                <td class="align-content-center">
                    <p class="fw-bold text-dark">' . htmlspecialchars((string)$registrant) . '</p>
                    <p class="text-dark">' . htmlspecialchars((string)$reference_no) . '</p> 
                </td>
                <td class="align-content-center">
                    <p class="fw-bold text-dark">' . $reg_date . '</p>
                </td>
            </tr>';
            }
        } else {
            $result = '<tr><td></td><td class="align-content-center">No data found</td><td></td><td></td</tr>';
        }

        return $result;
    }


    echo json_encode([
        'bm_html'   => fetchData($conn, 'business_mentor', 'business_mentor_id'),
        'emp_html'   => fetchData($conn, 'employees', 'employee_id'),
        'te_html'   => fetchData($conn, 'corporate_agency', 'corporate_agency_id'),
        'tc_html'   => fetchData($conn, 'ca_travelagency', 'ca_travelagency_id'),
        'cust_html' => fetchData($conn, 'ca_customer', 'ca_customer_id'),
    ]);
}
