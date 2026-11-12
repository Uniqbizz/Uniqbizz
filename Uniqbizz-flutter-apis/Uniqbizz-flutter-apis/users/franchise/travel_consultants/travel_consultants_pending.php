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
    $data = [];
    $allUserData = [];
    
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
                    $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
                    $stmt4->execute([$userCA['corporate_agency_id']]);
                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCATAs as $userCATA) {
                        $dt = new DateTime($userCATA['added_on']);
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
                            'id' => $userCATA['id'],
                            'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                            'ref_id' => $userCATA['reference_no'],
                            'ref_name' => $userCATA['registrant'],
                            'bdm_ref_id' => $id,
                            'bdm_ref_name' => $name,
                            'phone' => $userCATA['contact_no'],
                            'joining_date' => $datev,
                            'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                            'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
                        ];
                    }
                }
                
                // Direct TC with BM Ref
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
                $stmt4->execute([$bm_id]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $dt = new DateTime($userCATA['added_on']);
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
                        'id' => $userCATA['id'],
                        'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                        'ref_id' => $userCATA['reference_no'],
                        'ref_name' => $userCATA['registrant'],
                        'bdm_ref_id' => $id,
                        'bdm_ref_name' => $name,
                        'phone' => $userCATA['contact_no'],
                        'joining_date' => $datev,
                        'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                        'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
                    ];
                }
            }
            
            // Direct TC with BDM Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
            $stmt4->execute([$bdm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $dt = new DateTime($userCATA['added_on']);
                $datev = $dt->format('d-m-Y');

                $data[] = [
                    'id' => $userCATA['id'],
                    'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                    'ref_id' => $userCATA['reference_no'],
                    'ref_name' => $userCATA['registrant'],
                    'bdm_ref_id' => $userCATA['reference_no'],
                    'bdm_ref_name' => $userCATA['registrant'],
                    'phone' => $userCATA['contact_no'],
                    'joining_date' => $datev,
                    'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                    'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
                ];
            }
            
            // BDM->MF/SF
            $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28' UNION SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
            $stmt2->execute([$bdm_id, $bdm_id]);
            $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($userBMS as $userBM) {
                $bm_id = $userBM['id'];
                
                // MF/SF->F->TC
                $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id FROM `sub_franchisee` WHERE reference_no = ? ");
                $stmt2->execute([$bm_id]);
                $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCAs as $userCA) {
                    $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
                    $stmt4->execute([$userCA['sub_franchisee_id']]);
                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCATAs as $userCATA) {
                        $dt = new DateTime($userCATA['added_on']);
                        $datev = $dt->format('d-m-Y');
                        
                        $reference_no = substr($userCATA['reference_no'], 0, 1) == 'F' ? substr($userCATA['reference_no'], 0, 1) : substr($userCATA['reference_no'], 0, 2);
                        $name = '';
                        $id = '';
                        
                        if ($reference_no == "F") {
                            $sql2 = "SELECT registrant,reference_no FROM `sub_franchisee` WHERE sub_franchisee_id = ? AND (status = '1' OR status = '3') ORDER BY sponsor_franchisee_id ASC ";
                            $stmt2 = $conn->prepare($sql2);
                            $stmt2->execute([$userCATA['reference_no']]);
                            if ($stmt2->rowCount() > 0) {
                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $name = $row2['registrant'];
                                $id = $row2['reference_no'];
                            }
                        } else if ($reference_no == "MF") {
                            $sql2 = "SELECT registrant,reference_no FROM `master_franchisee` WHERE master_franchisee_id = ? AND (status = '1' OR status = '3') ORDER BY master_franchisee_id ASC ";
                            $stmt2 = $conn->prepare($sql2);
                            $stmt2->execute([$userCATA['reference_no']]);
                            if ($stmt2->rowCount() > 0) {
                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $name = $row2['registrant'];
                                $id = $row2['reference_no'];
                            }
                        }

                        $data[] = [
                            'id' => $userCATA['id'],
                            'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                            'ref_id' => $userCATA['reference_no'],
                            'ref_name' => $userCATA['registrant'],
                            'bdm_ref_id' => $id,
                            'bdm_ref_name' => $name,
                            'phone' => $userCATA['contact_no'],
                            'joining_date' => $datev,
                            'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                            'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
                        ];
                    }
                }
                
                // Direct TC with MF/SF Ref
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
                $stmt4->execute([$bm_id]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $dt = new DateTime($userCATA['added_on']);
                    $datev = $dt->format('d-m-Y');
                    
                    $reference_no = substr($userCATA['reference_no'], 0, 1) == 'F' ? substr($userCATA['reference_no'], 0, 1) : substr($userCATA['reference_no'], 0, 2);
                    $name = '';
                    $id = '';
                    
                    if ($reference_no == "F") {
                        $sql2 = "SELECT registrant,reference_no FROM `sub_franchisee` WHERE sub_franchisee_id = ? AND (status = '1' OR status = '3') ORDER BY sponsor_franchisee_id ASC ";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute([$userCATA['reference_no']]);
                        if ($stmt2->rowCount() > 0) {
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    } else if ($reference_no == "MF") {
                        $sql2 = "SELECT registrant,reference_no FROM `master_franchisee` WHERE master_franchisee_id = ? AND (status = '1' OR status = '3') ORDER BY master_franchisee_id ASC ";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute([$userCATA['reference_no']]);
                        if ($stmt2->rowCount() > 0) {
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    }

                    $data[] = [
                        'id' => $userCATA['id'],
                        'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                        'ref_id' => $userCATA['reference_no'],
                        'ref_name' => $userCATA['registrant'],
                        'bdm_ref_id' => $id,
                        'bdm_ref_name' => $name,
                        'phone' => $userCATA['contact_no'],
                        'joining_date' => $datev,
                        'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                        'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
                    ];
                }
            }
            
            // BDM->F-TC
            $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id FROM `sub_franchisee` WHERE reference_no = ? ");
            $stmt2->execute([$bdm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
                $stmt4->execute([$userCA['sub_franchisee_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $dt = new DateTime($userCATA['added_on']);
                    $datev = $dt->format('d-m-Y');
                    
                    $reference_no = substr($userCATA['reference_no'], 0, 1) == 'F' ? substr($userCATA['reference_no'], 0, 1) : substr($userCATA['reference_no'], 0, 2);
                    $name = '';
                    $id = '';
                    
                    if ($reference_no == "F") {
                        $sql2 = "SELECT registrant,reference_no FROM `sub_franchisee` WHERE sub_franchisee_id = ? AND (status = '1' OR status = '3') ORDER BY sponsor_franchisee_id ASC ";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute([$userCATA['reference_no']]);
                        if ($stmt2->rowCount() > 0) {
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    } else if ($reference_no == "MF") {
                        $sql2 = "SELECT registrant,reference_no FROM `master_franchisee` WHERE master_franchisee_id = ? AND (status = '1' OR status = '3') ORDER BY master_franchisee_id ASC ";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute([$userCATA['reference_no']]);
                        if ($stmt2->rowCount() > 0) {
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    }

                    $data[] = [
                        'id' => $userCATA['id'],
                        'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                        'ref_id' => $userCATA['reference_no'],
                        'ref_name' => $userCATA['registrant'],
                        'bdm_ref_id' => $id,
                        'bdm_ref_name' => $name,
                        'phone' => $userCATA['contact_no'],
                        'joining_date' => $datev,
                        'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                        'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
                    ];
                }
            }
            
            // BDM->TE-TC
            $stmt2 = $conn->prepare("SELECT DISTINCT corporate_agency_id FROM `corporate_agency` WHERE reference_no = ? ");
            $stmt2->execute([$bdm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
                $stmt4->execute([$userCA['corporate_agency_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $dt = new DateTime($userCATA['added_on']);
                    $datev = $dt->format('d-m-Y');
                    
                    $reference_no = substr($userCATA['reference_no'], 0, 1) == 'F' ? substr($userCATA['reference_no'], 0, 1) : substr($userCATA['reference_no'], 0, 2);
                    $name = '';
                    $id = '';
                    
                    if ($reference_no == "CA" || $reference_no == "TE") {
                        $sql2 = "SELECT registrant,reference_no FROM `corporate_agency` WHERE corporate_agency_id = ? AND (status = '1' OR status = '3') ORDER BY sponsor_franchisee_id ASC ";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute([$userCATA['reference_no']]);
                        if ($stmt2->rowCount() > 0) {
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    } else if ($reference_no == "BM") {
                        $sql2 = "SELECT registrant,reference_no FROM `business_mentor` WHERE business_mentor_id = ? AND (status = '1' OR status = '3') ORDER BY master_franchisee_id ASC ";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute([$userCATA['reference_no']]);
                        if ($stmt2->rowCount() > 0) {
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    }

                    $data[] = [
                        'id' => $userCATA['id'],
                        'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                        'ref_id' => $userCATA['reference_no'],
                        'ref_name' => $userCATA['registrant'],
                        'bdm_ref_id' => $id,
                        'bdm_ref_name' => $name,
                        'phone' => $userCATA['contact_no'],
                        'joining_date' => $datev,
                        'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                        'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
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
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
                $stmt4->execute([$userCA['corporate_agency_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $dt = new DateTime($userCATA['added_on']);
                    $datev = $dt->format('d-m-Y');

                    $data[] = [
                        'id' => $userCATA['id'],
                        'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                        'ref_id' => $userCATA['reference_no'],
                        'ref_name' => $userCATA['registrant'],
                        'phone' => $userCATA['contact_no'],
                        'joining_date' => $datev,
                        'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                        'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
                    ];
                }
            }
            
            // Direct TC with BM Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $dt = new DateTime($userCATA['added_on']);
                $datev = $dt->format('d-m-Y');

                $data[] = [
                    'id' => $userCATA['id'],
                    'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                    'ref_id' => $userCATA['reference_no'],
                    'ref_name' => $userCATA['registrant'],
                    'phone' => $userCATA['contact_no'],
                    'joining_date' => $datev,
                    'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                    'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
                ];
            }
        }
        
        // Direct TC with BDM Ref
        $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $dt = new DateTime($userCATA['added_on']);
            $datev = $dt->format('d-m-Y');

            $data[] = [
                'id' => $userCATA['id'],
                'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                'ref_id' => $userCATA['reference_no'],
                'ref_name' => $userCATA['registrant'],
                'phone' => $userCATA['contact_no'],
                'joining_date' => $datev,
                'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
            ];
        }
        
        // BDM->MF/SF
        $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28' UNION SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
        $stmt2->execute([$userId, $userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];
            
            // MF/SF->F->TC
            $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id FROM `sub_franchisee` WHERE reference_no = ? ");
            $stmt2->execute([$bm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
                $stmt4->execute([$userCA['sub_franchisee_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $dt = new DateTime($userCATA['added_on']);
                    $datev = $dt->format('d-m-Y');

                    $data[] = [
                        'id' => $userCATA['id'],
                        'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                        'ref_id' => $userCATA['reference_no'],
                        'ref_name' => $userCATA['registrant'],
                        'phone' => $userCATA['contact_no'],
                        'joining_date' => $datev,
                        'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                        'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
                    ];
                }
            }
            
            // Direct TC with MF/SF Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $dt = new DateTime($userCATA['added_on']);
                $datev = $dt->format('d-m-Y');
                
                $data[] = [
                    'id' => $userCATA['id'],
                    'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                    'ref_id' => $userCATA['reference_no'],
                    'ref_name' => $userCATA['registrant'],
                    'phone' => $userCATA['contact_no'],
                    'joining_date' => $datev,
                    'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                    'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
                ];
            }
        }
        
        // BDM->F-TC
        $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id FROM `sub_franchisee` WHERE reference_no = ? ");
        $stmt2->execute([$bm_id]);
        $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCAs as $userCA) {
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
            $stmt4->execute([$userCA['sub_franchisee_id']]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $dt = new DateTime($userCATA['added_on']);
                $datev = $dt->format('d-m-Y');

                $data[] = [
                    'id' => $userCATA['id'],
                    'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                    'ref_id' => $userCATA['reference_no'],
                    'ref_name' => $userCATA['registrant'],
                    'phone' => $userCATA['contact_no'],
                    'joining_date' => $datev,
                    'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                    'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
                ];
            }
        }
        
        // BDM->TE-TC
        $stmt2 = $conn->prepare("SELECT DISTINCT corporate_agency_id FROM `corporate_agency` WHERE reference_no = ? ");
        $stmt2->execute([$bm_id]);
        $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCAs as $userCA) {
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
            $stmt4->execute([$userCA['corporate_agency_id']]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $dt = new DateTime($userCATA['added_on']);
                $datev = $dt->format('d-m-Y');

                $data[] = [
                    'id' => $userCATA['id'],
                    'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                    'ref_id' => $userCATA['reference_no'],
                    'ref_name' => $userCATA['registrant'],
                    'phone' => $userCATA['contact_no'],
                    'joining_date' => $datev,
                    'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                    'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
                ];
            }
        }
    } else if ($userType == "26" || $userType == "28" || $userType == "30") {
        if ($userType == "28" || $userType == "30") {
            $stmt2 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
        } else {
            $stmt2 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
        }
        $stmt2->execute([$userId]);
        $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach ($referrals as $referral) {
            $userCA = ($userType == '28' || $userType == "30") ? $referral['sub_franchisee_id'] : $referral['corporate_agency_id'];
            
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
            $stmt4->execute([$userCA]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $dt = new DateTime($userCATA['added_on']);
                $datev = $dt->format('d-m-Y');

                $data[] = [
                    'id' => $userCATA['id'],
                    'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                    'ref_id' => $userCATA['reference_no'],
                    'ref_name' => $userCATA['registrant'],
                    'phone' => $userCATA['contact_no'],
                    'joining_date' => $datev,
                    'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                    'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
                ];
            }
        }
        
        // Direct TC with BM Ref
        $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $dt = new DateTime($userCATA['added_on']);
            $datev = $dt->format('d-m-Y');

            $data[] = [
                'id' => $userCATA['id'],
                'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                'ref_id' => $userCATA['reference_no'],
                'ref_name' => $userCATA['registrant'],
                'phone' => $userCATA['contact_no'],
                'joining_date' => $datev,
                'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
            ];
        }
    } else if ($userType == "16" || $userType == "291") {
        $sql3 = "SELECT * FROM `ca_travelagency` WHERE reference_no = ? AND (status = '2' OR status = '0')";
        $stmt3 = $conn->prepare($sql3);
        $stmt3->execute([$userId]);
        
        if ($stmt3->rowCount() > 0) {
            foreach ($stmt3->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $dt = new DateTime($row['added_on']);
                $datev = $dt->format('d-m-Y');
                
                $data[] = [
                    'id' => $row['id'],
                    'name' => $row['firstname'] . ' ' . $row['lastname'],
                    'nominee_name' => $row['nominee_name'],
                    'nominee_relation' => $row['nominee_relation'],
                    'email' => $row['email'],
                    'gender' => $row['gender'],
                    'county_code' => $row['country_code'],
                    'dob' => $row['date_of_birth'],
                    'profile_pic' => $row['profile_pic'],
                    'pan_card' => $row['pan_card'],
                    'aadhar_card' => $row['aadhar_card'],
                    'voting_card' => $row['voting_card'],
                    'passbook' => $row['passbook'],
                    'payment_proof' => $row['payment_proof'],
                    'paymentMode' => $row['payment_mode'],
                    'cheque_no' => $row['cheque_no'],
                    'cheque_date' => $row['cheque_date'],
                    'bank_name' => $row['bank_name'],
                    'transaction_no' => $row['transaction_no'],
                    'address' => $row['address'],
                    'pincode' => $row['pincode'],
                    'country' => $row['country'],
                    'state' => $row['state'],
                    'city' => $row['city'],
                    'ref_id' => $row['reference_no'],
                    'ref_name' => $row['registrant'],
                    'phone' => $row['contact_no'],
                    'joining_date' => $datev,
                    'status' => $row['status'] == '2' ? 'Pending' : 'Delete',
                    'status_badge' => $row['status'] == '2' ? 'warning' : 'danger'
                ];
            }
        }
    } else if ($userType == "31") {
        // Direct TC with RM Ref
        $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $dt = new DateTime($userCATA['added_on']);
            $datev = $dt->format('d-m-Y');

            $data[] = [
                'id' => $userCATA['id'],
                'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                'ref_id' => $userCATA['reference_no'],
                'ref_name' => $userCATA['registrant'],
                'phone' => $userCATA['contact_no'],
                'joining_date' => $datev,
                'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
            ];
        }
        
        // RM->MF/SF
        $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28' UNION SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
        $stmt2->execute([$userId, $userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];
            
            // MF/SF->F->TC
            $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id FROM `sub_franchisee` WHERE reference_no = ? ");
            $stmt2->execute([$bm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
                $stmt4->execute([$userCA['sub_franchisee_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $dt = new DateTime($userCATA['added_on']);
                    $datev = $dt->format('d-m-Y');

                    $data[] = [
                        'id' => $userCATA['id'],
                        'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                        'ref_id' => $userCATA['reference_no'],
                        'ref_name' => $userCATA['registrant'],
                        'phone' => $userCATA['contact_no'],
                        'joining_date' => $datev,
                        'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                        'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
                    ];
                }
            }
            
            // Direct TC with MF/SF Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '2' OR status = '0')");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $dt = new DateTime($userCATA['added_on']);
                $datev = $dt->format('d-m-Y');
                
                $data[] = [
                    'id' => $userCATA['id'],
                    'name' => $userCATA['firstname'] . ' ' . $userCATA['lastname'],
                    'ref_id' => $userCATA['reference_no'],
                    'ref_name' => $userCATA['registrant'],
                    'phone' => $userCATA['contact_no'],
                    'joining_date' => $datev,
                    'status' => $userCATA['status'] == '2' ? 'Pending' : 'Delete',
                    'status_badge' => $userCATA['status'] == '2' ? 'warning' : 'danger'
                ];
            }
        }
    } else if ($userType == "29") {
        $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '2')");
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