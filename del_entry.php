<?php

require_once "defaultincludes.inc";

$id = get_form_var('id', 'int');
$event_id = get_form_var('event_id', 'int');
$room_id = get_form_var('room_id', 'int');
$day_id = get_form_var('day_id', 'int');
$user_id = get_form_var('user_id', 'int'); // id of the current user
$creator_id = get_form_var('creator_id', 'int'); // id of the entry creator

$returl = "day.php?event_id=$event_id&day_id=$day_id&room_id=$room_id";

if (!isset($id))
{
	$location = $returl . "&error=noentryid";
	redirect($location);
}

// Verify that the user has permissions to delete this entry
if (($user_id == $creator_id) || (getAdmin()))
{
	$sql = "SELECT * FROM $tbl_entry WHERE id=$id LIMIT 1";
	$res = sql_query($sql);
	if ($res < 0)
	{
		fatal_error(TRUE, get_vocab("cantfindentry") . " id=$id " . sql_error());
	}
	$row = sql_row_keyed($res, 0);
	sql_free($res);

	// Acquire a mutex to lock out others who might be deleting the new event
	if (!sql_mutex_lock("$tbl_entry"))
	{
		fatal_error(TRUE, get_vocab("failed_to_acquire"));
	}
	
	$sql = "UPDATE $tbl_entry SET " .
		"user_id=0, " .
		"purpose=NULL, " .
		"comments=NULL, " .
		"guests=NULL, " .
		"guest_emails=NULL, " .
		"confirmed=0 " .
		"WHERE id=$id";
	$res = sql_command($sql);
    if ($res < 0)
	{
		fatal_error(1, get_vocab("updateentryfailed") . " id=$id " . sql_error());
	}
	// if everything is OK, release the mutex and go back to
	// the admin page (for the new event)
	sql_mutex_unlock("$tbl_entry");
	
	// Set up for mailing
	$creator_id = $row['user_id'];
	$to_names = urlencode($row['guests']);
	$to_emails = urlencode($row['guest_emails']);
	$purpose = urlencode($row['purpose']);
	$start_hour = $row['start_hour'];
	$start_minute = $row['start_minute'];
	$end_hour = $row['end_hour'];
	$end_minute = $row['end_minute'];
	
	$location = "email_entry.php?type=3" .
		"&event_id=$event_id" .
		"&day_id=$day_id" .
		"&room_id=$room_id" .
		"&user_id=$user_id" .
		"&creator_id=$creator_id" .
		"&to_names=$to_names" .
		"&to_emails=$to_emails" .
		"&purpose=$purpose" .
		"&start_hour=$start_hour" .
		"&start_minute=$start_minute" .
		"&end_minute=$end_minute" .
		"&end_hour=$end_hour";
		
	redirect($location);
}
// If you got this far then we got an access denied.
$errormsg = 'notowner';

showAccessDenied($day_id, $event_id, $errormsg);
?>
