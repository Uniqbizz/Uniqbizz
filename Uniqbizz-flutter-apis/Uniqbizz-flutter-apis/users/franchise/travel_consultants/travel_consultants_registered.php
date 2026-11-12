<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
require '../../../connect.php';

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get POST data
$postData = json_decode(file_get_contents('php://input'), true);

// Check required parameters
if (!isset($postData['userId']) || !isset($postData['userType'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required parameters: userId and userType']);
    exit;
}

$userId = $postData['userId'];
$userType = $postData['userType'];

try {
    $allUserData = [];
    $data = [];
    
    if ($userType == "24") {
        $stmt = $conn->prepare("SELECT * FROM `employees` WHERE reporting_manager = ? AND user_type = '25' ");
        $stmt->execute([$userId]);
        $userBDMS = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($userBDMS as $userBDM) {
            $bdm_id = $userBDM['employee_id'];
            
            // BDM->BM
            $stmt2 = $conn->prepare("SELECT * FROM business_mentor WHERE reference_no = ? AND user_type = '26' ");
            $stmt2->execute([$bdm_id]);
            $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($userBMS as $userBM) {
                $bm_id = $userBM['business_mentor_id'];
                
                // BM->TE->TC
                $stmt2 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
                $stmt2->execute([$bm_id]);
                $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCAs as $userCA) {
                    $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
                    $stmt4->execute([$userCA['corporate_agency_id']]);
                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCATAs as $userCATA) {
                        $dt = new DateTime($userCATA['register_date']);
                        $datev = $dt->format('d-m-Y');
                        
                        $reference_no = substr($userCATA['reference_no'], 0, 2);
                        $name = '';
                        $id = '';
                        
                        if ($reference_no == "TE" || $reference_no == "CA") {
                            $sql2 = "SELECT * FROM `corporate_agency` WHERE corporate_agency_id = ? AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
                            $stmt2 = $conn->prepare($sql2);
                            $stmt2->execute([$userCATA['reference_no']]);
                            if ($stmt2->rowCount() > 0) {
                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $name = $row2['registrant'];
                                $id = $row2['reference_no'];
                            }
                        } else if ($reference_no == "BM") {
                            $sql2 = "SELECT * FROM `business_mentor` WHERE business_mentor_id = ? AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                            $stmt2 = $conn->prepare($sql2);
                            $stmt2->execute([$userCATA['reference_no']]);
                            if ($stmt2->rowCount() > 0) {
                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $name = $row2['registrant'];
                                $id = $row2['reference_no'];
                            }
                        }

                        $data[] = [
                            'tc_id' => $userCATA['ca_travelagency_id'],
                            'tc_name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                            'ref_id' => $userCATA['reference_no'],
                            'ref_name' => $userCATA['registrant'],
                            'bdm_ref_id' => $id,
                            'bdm_ref_name' => $name,
                            'phone' => $userCATA['contact_no'],
                            'joining_date' => $datev,
                            'status' => $userCATA['status'] == '1' ? 'Active' : 'Deactive',
                            'status_badge' => $userCATA['status'] == '1' ? 'success' : 'danger'
                        ];
                    }
                }
                
                // Direct TC with BM Ref
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
                $stmt4->execute([$bm_id]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $dt = new DateTime($userCATA['register_date']);
                    $datev = $dt->format('d-m-Y');
                    
                    $reference_no = substr($userCATA['reference_no'], 0, 2);
                    $name = '';
                    $id = '';
                    
                    if ($reference_no == "TE" || $reference_no == "CA") {
                        $sql2 = "SELECT * FROM `corporate_agency` WHERE corporate_agency_id = ? AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute([$userCATA['reference_no']]);
                        if ($stmt2->rowCount() > 0) {
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    } else if ($reference_no == "BM") {
                        $sql2 = "SELECT * FROM `business_mentor` WHERE business_mentor_id = ? AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute([$userCATA['reference_no']]);
                        if ($stmt2->rowCount() > 0) {
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    }

                    $data[] = [
                        'tc_id' => $userCATA['ca_travelagency_id'],
                        'tc_name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                        'ref_id' => $userCATA['reference_no'],
                        'ref_name' => $userCATA['registrant'],
                        'bdm_ref_id' => $id,
                        'bdm_ref_name' => $name,
                        'phone' => $userCATA['contact_no'],
                        'joining_date' => $datev,
                        'status' => $userCATA['status'] == '1' ? 'Active' : 'Deactive',
                        'status_badge' => $userCATA['status'] == '1' ? 'success' : 'danger'
                    ];
                }
            }
            
            // Direct TC with BDM Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
            $stmt4->execute([$bdm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $dt = new DateTime($userCATA['register_date']);
                $datev = $dt->format('d-m-Y');
                
                $reference_no = substr($userCATA['reference_no'], 0, 2);
                $name = '';
                $id = '';
                
                if ($reference_no == "TE" || $reference_no == "CA") {
                    $sql2 = "SELECT * FROM `corporate_agency` WHERE corporate_agency_id = ? AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->execute([$userCATA['reference_no']]);
                    if ($stmt2->rowCount() > 0) {
                        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                        $name = $row2['registrant'];
                        $id = $row2['reference_no'];
                    }
                } else if ($reference_no == "BM") {
                    $sql2 = "SELECT * FROM `business_mentor` WHERE business_mentor_id = ? AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->execute([$userCATA['reference_no']]);
                    if ($stmt2->rowCount() > 0) {
                        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                        $name = $row2['registrant'];
                        $id = $row2['reference_no'];
                    }
                }

                $data[] = [
                    'tc_id' => $userCATA['ca_travelagency_id'],
                    'tc_name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                    'ref_id' => $userCATA['reference_no'],
                    'ref_name' => $userCATA['registrant'],
                    'bdm_ref_id' => $id,
                    'bdm_ref_name' => $name,
                    'phone' => $userCATA['contact_no'],
                    'joining_date' => $datev,
                    'status' => $userCATA['status'] == '1' ? 'Active' : 'Deactive',
                    'status_badge' => $userCATA['status'] == '1' ? 'success' : 'danger'
                ];
            }
            
            // BDM->MF/SF
            $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28' UNION SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '28' ");
            $stmt2->execute([$bdm_id, $bdm_id]);
            $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($userBMS as $userBM) {
                $bm_id = $userBM['id'];
                
                // MF/SF->F->TC
                $stmt2 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
                $stmt2->execute([$bm_id]);
                $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCAs as $userCA) {
                    $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
                    $stmt4->execute([$userCA['sub_franchisee_id']]);
                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCATAs as $userCATA) {
                        $dt = new DateTime($userCATA['register_date']);
                        $datev = $dt->format('d-m-Y');
                        
                        $reference_no = substr($userCATA['reference_no'], 0, 1) == 'F' ? substr($userCATA['reference_no'], 0, 1) : substr($userCATA['reference_no'], 0, 2);
                        $name = '';
                        $id = '';
                        
                        if ($reference_no == "F") {
                            $sql2 = "SELECT * FROM `sub_franchisee` WHERE sub_franchisee_id = ? AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
                            $stmt2 = $conn->prepare($sql2);
                            $stmt2->execute([$userCATA['reference_no']]);
                            if ($stmt2->rowCount() > 0) {
                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $name = $row2['registrant'];
                                $id = $row2['reference_no'];
                            }
                        } else if ($reference_no == "MF") {
                            $sql2 = "SELECT * FROM `master_franchisee` WHERE master_franchisee_id = ? AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                            $stmt2 = $conn->prepare($sql2);
                            $stmt2->execute([$userCATA['reference_no']]);
                            if ($stmt2->rowCount() > 0) {
                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $name = $row2['registrant'];
                                $id = $row2['reference_no'];
                            }
                        }

                        $data[] = [
                            'tc_id' => $userCATA['ca_travelagency_id'],
                            'tc_name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                            'ref_id' => $userCATA['reference_no'],
                            'ref_name' => $userCATA['registrant'],
                            'bdm_ref_id' => $id,
                            'bdm_ref_name' => $name,
                            'phone' => $userCATA['contact_no'],
                            'joining_date' => $datev,
                            'status' => $userCATA['status'] == '1' ? 'Active' : 'Deactive',
                            'status_badge' => $userCATA['status'] == '1' ? 'success' : 'danger'
                        ];
                    }
                }
                
                // Direct TC with SF/MF Ref
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
                $stmt4->execute([$bm_id]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $dt = new DateTime($userCATA['register_date']);
                    $datev = $dt->format('d-m-Y');
                    
                    $reference_no = substr($userCATA['reference_no'], 0, 2);
                    $name = '';
                    $id = '';
                    
                    if ($reference_no == "TE" || $reference_no == "CA") {
                        $sql2 = "SELECT * FROM `corporate_agency` WHERE corporate_agency_id = ? AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute([$userCATA['reference_no']]);
                        if ($stmt2->rowCount() > 0) {
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    } else if ($reference_no == "BM") {
                        $sql2 = "SELECT * FROM `business_mentor` WHERE business_mentor_id = ? AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute([$userCATA['reference_no']]);
                        if ($stmt2->rowCount() > 0) {
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    }

                    $data[] = [
                        'tc_id' => $userCATA['ca_travelagency_id'],
                        'tc_name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                        'ref_id' => $userCATA['reference_no'],
                        'ref_name' => $userCATA['registrant'],
                        'bdm_ref_id' => $id,
                        'bdm_ref_name' => $name,
                        'phone' => $userCATA['contact_no'],
                        'joining_date' => $datev,
                        'status' => $userCATA['status'] == '1' ? 'Active' : 'Deactive',
                        'status_badge' => $userCATA['status'] == '1' ? 'success' : 'danger'
                    ];
                }
            }
            
            // BDM->F-TC
            $stmt2 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
            $stmt2->execute([$bdm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
                $stmt4->execute([$userCA['sub_franchisee_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $dt = new DateTime($userCATA['register_date']);
                    $datev = $dt->format('d-m-Y');
                    
                    $reference_no = substr($userCATA['reference_no'], 0, 1) == 'F' ? substr($userCATA['reference_no'], 0, 1) : substr($userCATA['reference_no'], 0, 2);
                    $name = '';
                    $id = '';
                    
                    if ($reference_no == "F") {
                        $sql2 = "SELECT * FROM `sub_franchisee` WHERE sub_franchisee_id = ? AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute([$userCATA['reference_no']]);
                        if ($stmt2->rowCount() > 0) {
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    } else if ($reference_no == "MF") {
                        $sql2 = "SELECT * FROM `master_franchisee` WHERE master_franchisee_id = ? AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute([$userCATA['reference_no']]);
                        if ($stmt2->rowCount() > 0) {
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    }

                    $data[] = [
                        'tc_id' => $userCATA['ca_travelagency_id'],
                        'tc_name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                        'ref_id' => $userCATA['reference_no'],
                        'ref_name' => $userCATA['registrant'],
                        'bdm_ref_id' => $id,
                        'bdm_ref_name' => $name,
                        'phone' => $userCATA['contact_no'],
                        'joining_date' => $datev,
                        'status' => $userCATA['status'] == '1' ? 'Active' : 'Deactive',
                        'status_badge' => $userCATA['status'] == '1' ? 'success' : 'danger'
                    ];
                }
            }
            
            // BDM->TE-TC
            $stmt2 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
            $stmt2->execute([$bdm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
                $stmt4->execute([$userCA['corporate_agency_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $dt = new DateTime($userCATA['register_date']);
                    $datev = $dt->format('d-m-Y');
                    
                    $reference_no = substr($userCATA['reference_no'], 0, 1) == 'F' ? substr($userCATA['reference_no'], 0, 1) : substr($userCATA['reference_no'], 0, 2);
                    $name = '';
                    $id = '';
                    
                    if ($reference_no == "F") {
                        $sql2 = "SELECT * FROM `corporate_agency` WHERE corporate_agency_id = ? AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute([$userCATA['reference_no']]);
                        if ($stmt2->rowCount() > 0) {
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    } else if ($reference_no == "BM") {
                        $sql2 = "SELECT * FROM `business_mentor` WHERE business_mentor_id = ? AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute([$userCATA['reference_no']]);
                        if ($stmt2->rowCount() > 0) {
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    }

                    $data[] = [
                        'tc_id' => $userCATA['ca_travelagency_id'],
                        'tc_name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                        'ref_id' => $userCATA['reference_no'],
                        'ref_name' => $userCATA['registrant'],
                        'bdm_ref_id' => $id,
                        'bdm_ref_name' => $name,
                        'phone' => $userCATA['contact_no'],
                        'joining_date' => $datev,
                        'status' => $userCATA['status'] == '1' ? 'Active' : 'Deactive',
                        'status_badge' => $userCATA['status'] == '1' ? 'success' : 'danger'
                    ];
                }
            }
        }
    } else if ($userType == "25") {
        // BDM->BM
        $stmt2 = $conn->prepare("SELECT * FROM business_mentor WHERE reference_no = ? AND user_type = '26' ");
        $stmt2->execute([$userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['business_mentor_id'];
            
            // BM->TE->TC
            $stmt2 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
            $stmt2->execute([$bm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
                $stmt4->execute([$userCA['corporate_agency_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $dt = new DateTime($userCATA['register_date']);
                    $datev = $dt->format('d-m-Y');

                    $data[] = [
                        'tc_id' => $userCATA['ca_travelagency_id'],
                        'tc_name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                        'ref_id' => $userCATA['reference_no'],
                        'ref_name' => $userCATA['registrant'],
                        'phone' => $userCATA['contact_no'],
                        'joining_date' => $datev,
                        'status' => $userCATA['status'] == '1' ? 'Active' : 'Deactive',
                        'status_badge' => $userCATA['status'] == '1' ? 'success' : 'danger'
                    ];
                }
            }
            
            // Direct TC with BM Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $dt = new DateTime($userCATA['register_date']);
                $datev = $dt->format('d-m-Y');

                $data[] = [
                    'tc_id' => $userCATA['ca_travelagency_id'],
                    'tc_name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                    'ref_id' => $userCATA['reference_no'],
                    'ref_name' => $userCATA['registrant'],
                    'phone' => $userCATA['contact_no'],
                    'joining_date' => $datev,
                    'status' => $userCATA['status'] == '1' ? 'Active' : 'Deactive',
                    'status_badge' => $userCATA['status'] == '1' ? 'success' : 'danger'
                ];
            }
        }
        
        // Direct TC with BDM Ref
        $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $dt = new DateTime($userCATA['register_date']);
            $datev = $dt->format('d-m-Y');

            $data[] = [
                'tc_id' => $userCATA['ca_travelagency_id'],
                'tc_name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                'ref_id' => $userCATA['reference_no'],
                'ref_name' => $userCATA['registrant'],
                'phone' => $userCATA['contact_no'],
                'joining_date' => $datev,
                'status' => $userCATA['status'] == '1' ? 'Active' : 'Deactive',
                'status_badge' => $userCATA['status'] == '1' ? 'success' : 'danger'
            ];
        }
        
        // BDM->MF/SF
        $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28' UNION SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '28' ");
        $stmt2->execute([$userId, $userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];
            
            // MF/SF->F->TC
            $stmt2 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
            $stmt2->execute([$bm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
                $stmt4->execute([$userCA['sub_franchisee_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $dt = new DateTime($userCATA['register_date']);
                    $datev = $dt->format('d-m-Y');

                    $data[] = [
                        'tc_id' => $userCATA['ca_travelagency_id'],
                        'tc_name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                        'ref_id' => $userCATA['reference_no'],
                        'ref_name' => $userCATA['registrant'],
                        'phone' => $userCATA['contact_no'],
                        'joining_date' => $datev,
                        'status' => $userCATA['status'] == '1' ? 'Active' : 'Deactive',
                        'status_badge' => $userCATA['status'] == '1' ? 'success' : 'danger'
                    ];
                }
            }
            
            // Direct TC with SF/MF Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $dt = new DateTime($userCATA['register_date']);
                $datev = $dt->format('d-m-Y');
                
                $data[] = [
                    'tc_id' => $userCATA['ca_travelagency_id'],
                    'tc_name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                    'ref_id' => $userCATA['reference_no'],
                    'ref_name' => $userCATA['registrant'],
                    'phone' => $userCATA['contact_no'],
                    'joining_date' => $datev,
                    'status' => $userCATA['status'] == '1' ? 'Active' : 'Deactive',
                    'status_badge' => $userCATA['status'] == '1' ? 'success' : 'danger'
                ];
            }
        }
        
        // BDM->F-TC
        $stmt2 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
        $stmt2->execute([$userId]);
        $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCAs as $userCA) {
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
            $stmt4->execute([$userCA['sub_franchisee_id']]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $dt = new DateTime($userCATA['register_date']);
                $datev = $dt->format('d-m-Y');

                $data[] = [
                    'tc_id' => $userCATA['ca_travelagency_id'],
                    'tc_name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                    'ref_id' => $userCATA['reference_no'],
                    'ref_name' => $userCATA['registrant'],
                    'phone' => $userCATA['contact_no'],
                    'joining_date' => $datev,
                    'status' => $userCATA['status'] == '1' ? 'Active' : 'Deactive',
                    'status_badge' => $userCATA['status'] == '1' ? 'success' : 'danger'
                ];
            }
        }
        
        // BDM->TE-TC
        $stmt2 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
        $stmt2->execute([$userId]);
        $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCAs as $userCA) {
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
            $stmt4->execute([$userCA['corporate_agency_id']]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $dt = new DateTime($userCATA['register_date']);
                $datev = $dt->format('d-m-Y');

                $data[] = [
                    'tc_id' => $userCATA['ca_travelagency_id'],
                    'tc_name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                    'ref_id' => $userCATA['reference_no'],
                    'ref_name' => $userCATA['registrant'],
                    'phone' => $userCATA['contact_no'],
                    'joining_date' => $datev,
                    'status' => $userCATA['status'] == '1' ? 'Active' : 'Deactive',
                    'status_badge' => $userCATA['status'] == '1' ? 'success' : 'danger'
                ];
            }
        }
    } else if ($userType == "16" || $userType == "26" || $userType == "291" || $userType == "28" || $userType == "30") {
        if (in_array($userType, ["28", "291", "30"])) {
            // Function to create travel agency row data
            function createTravelAgencyData($userCATA, $conn, $userId, $userType) {
                $dt = new DateTime($userCATA['register_date']);
                $datev = $dt->format('d-m-Y');
                
                $rowData = [
                    'tc_id' => $userCATA['ca_travelagency_id'],
                    // 'tc_name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                    'firstname' => $userCATA['firstname'],
                    'lastname' => $userCATA['lastname'],
                    'nominee_name' => $userCATA['nominee_name'],
                    'nominee_relation' => $userCATA['nominee_relation'],
                    'email' => $userCATA['email'],
                    'gender' => $userCATA['gender'],
                    'county_code' => $userCATA['country_code'],
                    'dob' => $userCATA['date_of_birth'],
                    'profile_pic' => $userCATA['profile_pic'],
                    'pan_card' => $userCATA['pan_card'],
                    'aadhar_card' => $userCATA['aadhar_card'],
                    'voting_card' => $userCATA['voting_card'],
                    'passbook' => $userCATA['passbook'],
                    'payment_proof' => $userCATA['payment_proof'],
                    'paymentMode' => $userCATA['payment_mode'],
                    'cheque_no' => $userCATA['cheque_no'],
                    'cheque_date' => $userCATA['cheque_date'],
                    'bank_name' => $userCATA['bank_name'],
                    'transaction_no' => $userCATA['transaction_no'],
                    'address' => $userCATA['address'],
                    'pincode' => $userCATA['pincode'],
                    'country' => $userCATA['country'],
                    'state' => $userCATA['state'],
                    'city' => $userCATA['city'],
                    'ref_id' => $userCATA['reference_no'],
                    'ref_name' => $userCATA['registrant'],
                    'phone' => $userCATA['contact_no'],
                    'joining_date' => $datev,
                    'status' => $userCATA['status'] == '1' ? 'Active' : 'Deactive',
                    'status_badge' => $userCATA['status'] == '1' ? 'success' : 'danger'
                ];
                
                // Add action data based on user type and status
                if (in_array($userType, ['16', '26', '28', '291', '30'])) {
                    if ($userCATA['status'] == '1') {
                        $rowData['has_actions'] = true;
                        $rowData['can_edit'] = (substr($userCATA['reference_no'], 0, 2) === 'MF' || substr($userCATA['reference_no'], 0, 1) === 'F');
                        $rowData['can_delete'] = $rowData['can_edit'];
                        $rowData['tc_id_for_action'] = $userCATA['ca_travelagency_id'];
                        $rowData['reference_no_for_action'] = $userCATA['reference_no'];
                        $rowData['country'] = $userCATA['country'];
                        $rowData['state'] = $userCATA['state'];
                        $rowData['city'] = $userCATA['city'];
                        $rowData['table_name'] = 'ca_travelagency';
                        $rowData['list_type'] = 'registered';
                    } else {
                        $rowData['has_actions'] = true;
                        $rowData['can_restore'] = true;
                        
                        // Check who deactivated
                        $logsCheck = $conn->prepare("SELECT * FROM logs WHERE user_id=? AND operation='deactivated' ORDER BY register_date DESC LIMIT 1 ");
                        $logsCheck->execute([$userCATA["ca_travelagency_id"]]);
                        $resLog = $logsCheck->fetch(PDO::FETCH_ASSOC);
                        
                        $referenceMap = [
                            "1" => "Admin",
                            "291" => "Franchisee",
                            "28" => "Master Franchisee",
                            "30" => "Sponsor Franchisee"
                        ];
                        
                        $rowData['deactivated_by'] = isset($referenceMap[$resLog['from_whom']]) ? $referenceMap[$resLog['from_whom']] : 'Unknown';
                    }
                }
                
                return $rowData;
            }
            
            // Fetch sub_franchisee referrals
            $stmt2 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ?");
            $stmt2->execute([$userId]);
            $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($referrals as $referral) {
                $userCA = $referral['sub_franchisee_id'];
                
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
                $stmt4->execute([$userCA]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);



                // foreach ($userCATAs as $userCATA) {
                //     $data[] = createTravelAgencyData($userCATA, $conn, $userId, $userType);
                // }
            }

            // Additional check: Master Franchisee can have direct CA
            if ($userType == "28" || $userType == "291") {
                $stmtDirectCA = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
                $stmtDirectCA->execute([$userId]);
                $directCAs = $stmtDirectCA->fetchAll(PDO::FETCH_ASSOC);

                foreach ($directCAs as $userCATA) {
                    $data[] = createTravelAgencyData($userCATA, $conn, $userId, $userType);
                }
            }
        } else {
            if ($userType == '16') {
                $sql4 = "SELECT *, CASE WHEN tm.te_id IS NOT NULL THEN 1 ELSE 0 END AS alloted_check FROM `ca_travelagency` LEFT JOIN tc_mapping tm on tc_id=ca_travelagency_id and te_id = ? WHERE (reference_no = ? OR tm.te_id = ?) AND (status = '1' OR status = '3') ";
                $stmt4 = $conn->prepare($sql4);
                $stmt4->execute([$userId, $userId, $userId]);
            } else {
                $sql4 = "SELECT * FROM `ca_travelagency` WHERE reference_no = ? AND (status = '1' OR status = '3') ";
                $stmt4 = $conn->prepare($sql4);
                $stmt4->execute([$userId]);
            }
            
            if ($stmt4->rowCount() > 0) {
                foreach ($stmt4->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    $dt = new DateTime($row['register_date']);
                    $datev = $dt->format('d-m-Y');
                    
                    $lastName = $row['lastname'];
                    $allotedCheck = isset($row['alloted_check']) ? $row['alloted_check'] : 0;
                    
                    if ($userType == '16' && $allotedCheck == 1) {
                        $lastName .= ' (Allotted TC)';
                    }
                    
                    $rowData = [
                        'tc_id' => $row['ca_travelagency_id'],
                        'tc_name' => $row['firstname'] . ' ' . $lastName,
                        'phone' => $row['contact_no'],
                        'joining_date' => $datev,
                        'status' => $row['status'] == '1' ? 'Active' : 'Deactive',
                        'status_badge' => $row['status'] == '1' ? 'success' : 'danger',
                        'is_alloted' => $allotedCheck == 1
                    ];
                    
                    if ($allotedCheck == 1) {
                        $rowData['ref_id'] = 'Allotted TC';
                        $rowData['ref_name'] = 'Allotted TC';
                    } else {
                        $rowData['ref_id'] = $row['reference_no'];
                        $rowData['ref_name'] = $row['registrant'];
                    }
                    
                    // Add action data
                    if (in_array($userType, ['16', '26', '28', '291', '30'])) {
                        if ($row['status'] == '1') {
                            $rowData['has_actions'] = true;
                            $rowData['can_edit'] = true;
                            $rowData['can_delete'] = true;
                            $rowData['tc_id_for_action'] = $row['ca_travelagency_id'];
                            $rowData['reference_no_for_action'] = $row['reference_no'];
                            $rowData['country'] = $row['country'];
                            $rowData['state'] = $row['state'];
                            $rowData['city'] = $row['city'];
                            $rowData['table_name'] = 'ca_travelagency';
                            $rowData['list_type'] = 'registered';
                        } else {
                            $rowData['has_actions'] = true;
                            $rowData['can_restore'] = true;
                            $rowData['list_type'] = 'deactivate';
                        }
                    }
                    
                    $data[] = $rowData;
                }
            }
        }
    } else if ($userType == "29") {
    $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
    $stmt4->execute([$userId]);
    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($userCATAs as $userCATA) {
        $userTA = $userCATA['id'];
        
        $bd = new DateTime($userCATA['date_of_birth']);
        $bdate = $bd->format('d-m-Y');
        $dt = new DateTime($userCATA['register_date']);
        $datev = $dt->format('d-m-Y');
        
        // Store each row's data in the array
        $allUserData[] = $userCATA;
    }
}

    echo json_encode([
        'success' => true,
        'data' => $allUserData,
        'user_type' => $userType
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Server error',
        'message' => $e->getMessage()
    ]);
}
?>