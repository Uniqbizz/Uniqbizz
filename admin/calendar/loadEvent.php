<?php
// Fetch events from your database here
require '../connect.php';

// An array to hold your events
$events = array();

$sql = "SELECT * FROM events ";
$sql = $conn -> prepare($sql);
$sql -> Execute();
$sql -> setFetchMode(PDO::FETCH_ASSOC);
if( $sql -> rowCount()>0 ){
	foreach( ($sql -> fetchAll() )as $db_events =>  $db_event){
		$events[] = array(
        'title' => $db_event['title'],
        'start' => $db_event['start_date'],
        // Add other event properties here
    );
	}
} 


// Echo the events as JSON
echo json_encode($events);
?>
