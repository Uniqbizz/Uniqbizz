<?php
    require '../connect.php';

	session_start();
	
	// echo $username = $_SESSION['username'];
	// echo $id = $_SESSION['id'];
	// echo $user_id = $_SESSION['user_id'];

	if(!isset($_SESSION['username'])){
		echo '<script>location.href = "../login.php";</script>';
	}

    $id = $_POST['empID'];
    $name = $_POST['empName'];
    $designation = $_POST['designation'];

    // echo $id .' '. $name .' '. $designation;

    if($id && !$name && !$designation){
        $stmt = $conn->prepare(" SELECT * FROM `employees` WHERE employee_id = '".$id."' AND status = '1' order by employee_id ");
    }else if(!$id && $name && !$designation){
        $stmt = $conn->prepare(" SELECT * FROM `employees` WHERE name = '".$name."' AND status = '1' order by id ");
    }else if(!$id && !$name && $designation){
        $stmt = $conn->prepare(" SELECT * FROM `employees` WHERE designation = '".$designation."' AND status = '1' order by id ");
    }
    
    else if($id && $name && !$designation){
        $stmt = $conn->prepare(" SELECT * FROM `employees` WHERE employee_id = '".$id."' AND name = '".$name."' AND status = '1' order by employee_id ");
    }else if(!$id && $name && $designation){
        $stmt = $conn->prepare(" SELECT * FROM `employees` WHERE name = '".$name."' AND designation = '".$designation."' AND status = '1' order by id ");
    }else if($id && !$name && $designation){
        $stmt = $conn->prepare(" SELECT * FROM `employees` WHERE employee_id = '".$id."' AND designation = '".$designation."' AND status = '1' order by employee_id ");
    }
    
    else if($id && $name && $designation){
        $stmt = $conn->prepare(" SELECT * FROM `employees` WHERE employee_id = '".$id."' AND name = '".$name."' AND designation = '".$designation."' AND status = '1' order by employee_id ");
    }

    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if( $stmt-> rowCount()>0 ){
        foreach( ($stmt -> fetchAll()) as $key => $employee ){
            echo'
                <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                    <div class="card">
                        <div class="p-4">
                            <a href="#" class="avatar d-flex justify-content-center align-items-center"><img class="rounded-5" style="width: 100px; height: 100px;" src="../../uploading/'.$employee['profile_pic'].'" alt="User Image"></a>
                        </div>
                        <div class="dropdown profile-action" style="position: absolute;top: 15px;right: 15px;">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">';
                                if($employee['status'] == 1){
                                    echo'
                                        <a class="dropdown-item" href="#" onclick=\'viewEmp("' .$employee["id"]. '","' .$employee["email"]. '","' .$employee["status"]. '","view")\'><i class="fa-solid fa-eye m-r-5 me-2"></i> View</a>
                                        <a class="dropdown-item" href="#" onclick=\'editEmp("' .$employee["id"]. '","' .$employee["email"]. '","' .$employee["status"]. '","edit")\'><i class="fa-solid fa-pencil m-r-5 me-2"></i> Edit</a>
                                        <a class="dropdown-item" href="#" onclick=\'deleteEmp("' .$employee["id"]. '","' .$employee["email"]. '","0","delete")\'><i class="fa-regular fa-trash-can m-r-5 me-2"></i> Delete</a>
                                    ';
                                    // <a class="dropdown-item" href="#" onclick=\'deleteEmp("' .$employee["id"]. '","' .$employee["email"]. '","0","delete")\'><i class="fa-solid fa-square-check m-r-5 me-2"></i> Conform</a>
                                }else{
                                    echo'
                                        <a class="dropdown-item" href="#" onclick=\'deleteEmp("' .$employee["id"]. '","' .$employee["email"]. '","1","restore")\'><i class="fa-regular fa-circle m-r-5 me-2"></i> Restore</a>
                                    ';
                                }	
                                    
                            echo'</div>
                        </div>';
                        if($employee["status"] == 2){
                            echo'<span class="navigation-link-extra" style="position: absolute;top: 40px; right: 21px;">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="svg-icon--material svg-icon navigation-notification text-danger animate__animated animate__heartBeat animate__infinite animate__slower" data-name="Material--Circle">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <circle cx="12" cy="12" opacity="0.3" r="8"></circle>
                                    <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"></path>
                                </svg>
                            </span>';
                        }
                        echo'
                        <h4 class="user-name m-t-10 mb-0 text-center pb-1"><a href="#" class="fw-bold fs-5 text-dark text-decoration-none">'.$employee['name'].'<span class="ms-2 fs-6 text-muted">('.$employee['employee_id'].')</snap></a></h4>
                        <h4 class="user-name m-t-10 mb-0 text-center pb-4"><a href="#" class="fs-6 text-dark text-muted text-decoration-none">Ref: '.$employee['name'].'<span class="ms-2 fs-6 text-muted">('.$employee['employee_id'].')</snap></a></h4>
                    </div>
                </div>
            ';
        }
    }else{
        echo'
            <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                <div class="profile-widget">
                    <div class="profile-img">
                        <a href="#" class="avatar"><img src="../uploading/not_uploaded.png" alt="User Image"></a>
                    </div>
                    <h4 class="user-name m-t-10 mb-0 text-ellipsis">No User Found</h4>
                </div>
            </div>
        ';
    }
?>