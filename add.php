<?php

// $Id: add.php 1231 2009-10-27 16:52:17Z cimorrison $

require_once "defaultincludes.inc";

// Get form variables
$day_id = get_form_var('day_id', 'int');
$event_id = get_form_var('event_id', 'int');
$name = get_form_var('name', 'string');
$description = get_form_var('description', 'string');
$day_string = get_form_var('day_string', 'string');
$room_number = get_form_var('room_number', 'string');
$type = get_form_var('type', 'string');

$required_level = (isset($max_level) ? $max_level : 2);
if (!getAuthorised($required_level))
{
  showAccessDenied($day_id, $event_id);
  exit();
}

if (empty($name)) fatal_error(1, get_vocab('nonamegiven'));

// This file is for adding new events/days/rooms

// we need to do different things depending on if its a room
// or an event

if ($type == "event")
{
  // Truncate the name field to the maximum length as a precaution.
  $name = substr($name, 0, $maxlength['event.event_name']);
  $event_name_q = addslashes($name);
  $description = substr($description, 0, $maxlength['event.event_descr']);
  $description_q = addslashes($description);
  // Acquire a mutex to lock out others who might be editing the event
  if (!sql_mutex_lock("$tbl_event"))
  {
    fatal_error(TRUE, get_vocab("failed_to_acquire"));
  }
  // Check that the event name is unique
  if (sql_query1("SELECT COUNT(*) FROM $tbl_event WHERE name='$event_name_q' LIMIT 1") > 0)
  {
    $error = "invalid_event_name";
  }
  // If so, insert the event into the database
  else
  {
    $sql = "INSERT INTO $tbl_event 
            (name, event_description) 
            VALUES ('$event_name_q', $description_q')";
    if (sql_command($sql) < 0)
    {
      fatal_error(1, sql_error());
    }
    $event_id = sql_insert_id("$tbl_event", "id");
  }
  // Release the mutex
  sql_mutex_unlock("$tbl_event");
}

if ($type == "day")
{
	if (!isset($event_id))
	{
		$error = 'noevent';
	}
	else
	{
		// TODO: Valid date given by date picker, no need to validate in here, but maybe should anyway
		$t = strtotime($day_string);
		if (! $t) {
			$error = 'invaliddate';
		}
		else 
		{
			$day_ar = getdate($t);
			$day = $day_ar['day'];
			$month = $day_ar['month'];
			$year = $day_ar['year'];
			// Acquire a mutex  to lock out others who might be editing days
			if (!sql_mutex_lock("$tbl_day"))
			{
				fatal_error(TRUE, get_vocab("failed_to_acquire"));
			}
			$day_string = date("Y-m-d", $t);
			// Acquire a mutex to lock out others who might be editing days
			if (!sql_mutex_lock("$tbl_day"))
			{
				fatal_error(TRUE, get_vocab("failed_to_acquire"));
			}
			// Check that the day_string is unique within the event
			if (sql_query1("SELECT COUNT(*) FROM $tbl_day WHERE day_string='$day_string' AND event_id=$event_id LIMIT 1") > 0)
			{
				$error = "invalid_day_string";
			}
			// If so, insert the day into the datrabase
			else
			{
				$sql = "INSERT INTO $tbl_day (day_string, event_id, day, month, year)
				VALUES ('$day_string', $event_id, $day, $month, $year)";
				if (sql_command($sql) < 0)
				{
					fatal_error(1, sql_error());
				}
				$day_id = sql_insert_id($tbl_day, 'id');
			}
			// Release the mutex
			sql_mutex_unlock("$tbl_day");
			
		}
	}
} // end of type = day


if ($type == "room")
{
	if (!isset($event_id))
	{
		$error = 'noevent';
	}
	else if (empty($name))
	{
		$error = 'nonamegiven';
	}
	else if (empty($room_number))
	{
		$error = 'noroomnumbergiven';
	}
	else
	{
		// Truncate the name and description fields to the maximum length as a precaution.
		$name = substr($name, 0, $maxlength['room.room_name']);
		$description = substr($description, 0, $maxlength['room.description']);
		$room_number = substr($number, 0, $maxlength['room.room_number']);
		// Add SQL escaping
		$room_name_q = addslashes($name);
		$description_q = addslashes($description);
		$room_number_q = addslashes($room_number);
		// Acquire a mutex to lock out others who might be editing rooms
		if (!sql_mutex_lock("$tbl_room"))
		{
			fatal_error(TRUE, get_vocab("failed_to_acquire"));
		}
		// Check that the room name is unique within the event
		if (sql_query1("SELECT COUNT(*) FROM $tbl_room WHERE room_name='$room_name_q' AND event_id=$event_id LIMIT 1") > 0)
		{
			$error = "invalid_room_name";
		}
		// Check that the room number is unique within the event
		if (sql_query1("SELECT COUNT(*) FROM $tbl_room WHERE room_number='$room_number_q' AND event_id=$event_id LIMIT 1") > 0)
		{
			$error = "invalid_room_number";
		}
		// If so, insert the room into the datrabase
		else
		{
			$sql = "INSERT INTO $tbl_room (room_name, room_number, event_id, room_description)
			VALUES ('$room_name_q', '$room_number_q', $event_id, '$description_q')";
			if (sql_command($sql) < 0)
			{
				fatal_error(1, sql_error());
			}
		}
		// Release the mutex
		sql_mutex_unlock("$tbl_room");
	}

}

$returl = "admin.php?event_id=$event_id" . 
			(!isset($day_id) ? "&day_id=$day_id" : "") .
			(!empty($error) ? "&error=$error" : "");
header("Location: $returl");
