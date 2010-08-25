<?php

/**
 * Populate the database with initial slots
 *
 * @author Tamara Temple
 * @version $Id$
 * @copyright Tamara Temple Development, 20 August, 2010
 * @package default
 **/

/**
 * The initial population of time slots for the data base 
 * Make all possible slots available
 *
 **/

require 'defaultincludes.inc';

$starting_hour = $morningstarts;
$ending_hour = $eveningends;
$start_minute = 0;
$end_minute = 50;


print_header(0,0);

$is_admin=getAdmin();
if (!$is_admin) 
{
	$errormsg = 'norights';
  showAccessDenied(0,0, $errormsg);
}

/**
 * get_days
 *
 * @return array of day records sorted by year, month, and day
 * @author Tamara Temple
 **/
function get_days($event_id)
{
	global $tbl_day;
	if (!isset($event_id)) fatal_error(0, "Event id not set in get_days");
	$sql = "SELECT * FROM $tbl_day WHERE event_id=$event_id ORDER BY year, month, day";
	$res = sql_query($sql);
	if (!$res)
	{
		fatal_error(1, get_vocab('dayfetchfailed') . " $sql " . sql_error());
	}
	$rows = array();
	for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
	{
		$rows[] = $row;
	}
	sql_free($res);
	return $rows;
}

/**
 * get_rooms - get the room records for a given event and day 
 *
 * @return array of room records sorted by id
 * @author Tamara Temple
 **/
function get_rooms($event_id)
{
	global $tbl_room;
	
	if (!isset($event_id)) fatal_error(0, "Event id not set in get_rooms()");
	$sql = "SELECT * FROM $tbl_room WHERE event_id=$event_id ORDER BY id";
	$res = sql_query($sql);
	if (!$res)
	{
		fatal_error(1, get_vocab('roomfetchfailed') . sql_error());
	}
	$rows = array();
	for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
	{
		$rows[] = $row; // sort by id number for easy access
	}
	sql_free($res);
	return $rows;
}


echo "<h1>Populating event with time slots</h1>\n";

$event_id = get_form_var('event_id', 'int');

if (!isset($event_id)) $event_id = get_first_event();

echo "<p>Deleting existing time slots: ";
$sql = "DELETE FROM $tbl_entry WHERE event_id=$event_id";
$res = sql_command($sql);
if ($res < 0) fatal_error(0, "$sql FAILED. " . sql_error());	
echo "done.</p>";

$days = get_days($event_id);
echo "<p>Inserting for " . count($days) . " days</p>\n";
$rooms = get_rooms($event_id);
echo "<p>Inserting for " . count($rooms) . " rooms</p>\n";

echo "<pre>days:\n";
print_r($days);
echo "</pre>\n";

echo "<pre>rooms:\n";
print_r($rooms);
echo "</pre>\n";


for ($i=0; $i < count($days), $day = $days[$i]; $i++)
{
	$day_id=$day['id'];
	echo "<p>Inserting for day: $day_id: " . $day['day_string'] . "</p>\n";
	echo "<blockquote>\n";
	for ($j=0; $j < count($rooms); $j++)
	{
		$room = $rooms[$j];
		if (!isset($room) || (empty($room))) fatal_error(0, "room  $j is not set!!"); /// WTF!!!
		echo "<pre>room:\n";
		print_r($room);
		echo "</pre>\n";
		$room_id=$room['id'];
		echo "<p>Inserting for room: $room_id: " . $room['room_name'] . "</p>\n";
		echo "<blockquote>\n";
		echo "<p>Starting hour = $starting_hour</p><p>Ending hour = $ending_hour</p>\n";
		
		for ($hour = $starting_hour; $hour <= $ending_hour; $hour++)
		{
			echo "<p>Inserting slot start: $hour:$start_minute to end: $hour:$end_minute</p>\n";
			$sql="INSERT INTO $tbl_entry SET " .
				"event_id=$event_id, " .
				"day_id=$day_id, " .
				"room_id=$room_id, " .
				"start_hour=$hour, " .
				"start_minute=$start_minute, " .
				"end_hour=$hour, " .
				"end_minute=$end_minute ";
			$res=sql_command($sql);
			if ($res < 0) fatal_error(0, "$sql FAILED. " . sql_error());
			echo "<p>done.</p>\n";
		}
		echo "</blockquote>\n";
		echo "<p>Done with room.</p>\n";
	}
	echo "</blockquote>\n";
	echo "<p>Done with day</p>";
}

echo "<p>Populaton successful</p>\n";
echo "<p><a href=\"index.php\">Return to main</a></p>\n";

print_footer(TRUE);

?>