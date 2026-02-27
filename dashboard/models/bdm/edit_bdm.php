<?php
    $id = $_GET['vkvbvjfgfikix'];
    $dept = $_GET['dept'];
    $desig = $_GET['desig'];
    $zn = $_GET['zn'];
    $br = $_GET['br'];
    $editfor = $_GET['editfor'];

    $stmt = $conn->prepare("SELECT * FROM employees WHERE employee_id = :id");
	$stmt->execute(['id' => $id]);			
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	if($stmt->rowCount() > 0){
		foreach(($stmt->fetchAll()) as $key => $row) { 
			$name = $row['name'];
			$employee_id = $row['employee_id'];
			$name = $row['name'];
			$date_of_birth = $row['date_of_birth'];
			$country_code = $row['country_code'];
			$contact = $row['contact'];
			$email = $row['email']; 
			$address = $row['address'];
			$gender = $row['gender'];
			$department_id = $row['department'];
			$designation_id = $row['designation'];
			$zone_id = $row['zone'];
			$branch_id = $row['branch'];
			$reporting_manager_id = $row['reporting_manager'];
			$date_of_joining = $row['date_of_joining'];
			$profile_pic = $row['profile_pic'];
			$id_proof = $row['id_proof'];
			$bank_details = $row['bank_details'];
			$register_by = $row['register_by'];
			$user_type = $row['user_type'];
			$status = $row['status']; 

			// Get Department Name
			$departments = $conn->prepare("SELECT * FROM department WHERE id = :department");
			$departments->execute(['department' => $department_id]);
			$departments->setFetchMode(PDO::FETCH_ASSOC);
			if($departments->rowCount() > 0){
				$department = $departments->fetch();
                $department_name = $department['dept_name'];
			}

			// Get Designation Name
			$designationss = $conn->prepare("SELECT * FROM designation WHERE id = :designation");
			$designationss->execute(['designation' => $designation_id]);
			$designationss->setFetchMode(PDO::FETCH_ASSOC);
			if($designationss->rowCount() > 0){
				$designations = $designationss->fetch();
                $designation_name = $designations['designation_name'];
			}

			// Get Zone Name
			$zones = $conn->prepare("SELECT * FROM zone WHERE id = :zone");
			$zones->execute(['zone' => $zone_id]);
			$zones->setFetchMode(PDO::FETCH_ASSOC);
			if($zones->rowCount() > 0){
				$zone = $zones->fetch();
				$zone_name = $zone['zone_name'];
			}

			// Get Branch Name
			$branches = $conn->prepare("SELECT * FROM branch WHERE id = :branch");
			$branches->execute(['branch' => $branch_id]);
			$branches->setFetchMode(PDO::FETCH_ASSOC);
			if($branches->rowCount() > 0){
				$branch = $branches->fetch();
				$branch_name = $branch['branch_name'];
			}

			// Get Reporting Manager Name
			if($reporting_manager_id == 'null'){
				$reporting_manager_name = 'Not Selected';
			}else{	
				$reporting_managers = $conn->prepare("SELECT * FROM employees WHERE employee_id = :reporting_manager");
				$reporting_managers->execute(['reporting_manager' => $reporting_manager_id]);
				$reporting_managers->setFetchMode(PDO::FETCH_ASSOC);
				if($reporting_managers->rowCount() > 0){
					$reporting_manager = $reporting_managers->fetch();
					$reporting_manager_name = $reporting_manager['name'];
				}
			}
		}

	}
?>