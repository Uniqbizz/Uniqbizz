<?php
	session_start();
	require '../../connect.php';

	$username = $_POST['username'] ?? '';
	$password = $_POST['password'] ?? '';

	$stmt = $conn->prepare("
		SELECT username, user_type_id
		FROM login
		WHERE username = :username
		AND BINARY password = BINARY :password
		AND user_id = 1
		AND status = 1
		LIMIT 1
	");

	$stmt->execute([
		':username' => $username,
		':password' => $password
	]);

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($row) {
		if ((string)$row['user_type_id'] === '1') {
			session_regenerate_id(true);

			$_SESSION['username'] = $row['username'];
			$_SESSION['user_type_id'] = $row['user_type_id'];
			$_SESSION['user_details_access_id'] = '0';

			echo '1';
		} else {
			echo '0';
		}
	} else {
		echo '0';
	}
?>
