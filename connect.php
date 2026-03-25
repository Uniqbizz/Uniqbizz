<?php
$servername = "localhost";

// $username = "uniqbizz_test_db";   //test db 1
// $password = "+!YrromzCChf";

// $username = "uniqbizz_caTest";    //test db 2
// $password = "vjP&v7Us~kXt";


$username = "root";   //localhost
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=uniqbizz_bizzmirth", $username, $password);
    // $conn = new PDO("mysql:host=$servername;dbname=uniqbizz_caTest", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
