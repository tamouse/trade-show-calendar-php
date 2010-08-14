<?php

// Add a new slot to a day
//
// given: event_id, day_id, room_id, start_hour, start_minute
// create a new entry for that particular time and that particular day
// in that room for that event.
//
// Must check to ensure the items given don't create a new slot
// where one exists already.
//

require_once "defaultincludes.inc";

// Get passed variables
$event_id = get_form_var('event_id', 'int');
$day_id = get_form_var('day_id', 'int');
$room_id = get_form_var('room_id', 'int');
$start_hour = get_form_var('start_hour','int');
$start_minute = get_form_var('start_minute', 'int');

$returnURL = "day.php";

$is_admin = getAdmin();

if (!isset($event_id))
{
	$error = 'noevent';
	$location = $returnURL . "?error=$error";
	redirect($location);
}

if (!isset($day_id))
{
	$error = 'noday';
	$location = $returnURL . "?event_id=$event_id&error=$error";
	redirect($location);
}

if (!isset($room_id))
{
	$error = 'noroom';
	$location = $returnURL . "?event_id=$event_id&day_id=$day_id&error=$error";
	redirect($location);
}

if (!isset($start_hour) || !isset($start_minute))
{
	$error = 'nostarttime';
	$location = $returnURL . "?event_id=$event_id&day_id=$day_id&room_id=$room_id&error=$error";
	redirect($location);
}

if (!$is_admin)
{
	$error = 'norights';
	$location = $returnURL . "?event_id=$event_id&day_id=$day_id&room_id=$room_id&error=$error";
	redirect($location);
}



// Look up slot in data base to see if it already exists
$sql = "SELECT id FROM $tbl_entry WHERE event_id=$event_id AND day_id=$day_id AND room_id=$room_id AND start_hour=$start_hour AND start_minute=$start_minute LIMIT 1";
$result = sql_query1($sql);
// DEBUG START
// echo "<p>\$sql=$sql</p>\n";
// echo "<p>\$result=$result</p>\n";
//echo "<pre>\n";
//print_r();
//echo "</pre>\n";
// exit;
// DEBUG END

if ($result > 0)
{
	// slot exists!!
	$error = 'duplicateslot';
	$location = $returnURL . "?event_id=$event_id&day_id=$day_id&room_id=$room_id&error=$error";
	redirect($location);
}

// No slot currently there, create one
$end_hour = $start_hour + 1;  // for now, slots are always one hour in length. TODO: make slots variable times
$end_minute = $start_minute;
$sql = "INSERT INTO $tbl_entry (event_id, day_id, room_id, start_hour, start_minute, end_hour, end_minute) " . 
	"VALUES ($event_id, $day_id, $room_id, $start_hour, $start_minute, $end_hour, $end_minute)";
$result = sql_command($sql);
// DEBUG START
//echo "<p>after insert</p>\n";
//echo "<p>\$sql=$sql</p>\n";
//echo "<p>\$result=$result</p>\n";
//exit;
// DEBUG END

if ($result < 0)
{
	fatal_error(TRUE, "Could not add slot to database for $event_id : $day_id : $room_id : $start_hour : $start_minute :" . sql_error());
	exit;
}
$slot_id = sql_insert_id($tbl_entry);

$location = $returnURL . "?event_id=$event_id&day_id=$day_id&room_id=$room_id&slot_id=$slot_id";
redirect($location);

	
?>