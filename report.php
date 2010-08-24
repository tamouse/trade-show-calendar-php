<?php
/**
 * report.php - generate a report of appointments
 *
 * @author Tamara Temple
 * @version $Id$
 * @copyright Tamara Temple Development, 17 August, 2010
 * @package default
 **/

/**
 * Define DocBlock
 **/

require 'defaultincludes.inc';

$event_id = get_form_var('event_id', 'int');
if (!isset($event_id))
{
	$event_id = get_first_event();
}

/**
 * get_entries - retrieves the records for a given event, day and room
 *
 * @return array of entry records
 * @author Tamara Temple
 **/
function get_entries($event_id, $day_id)
{
	global $tbl_entry, $tbl_room;
	
	$sql = "SELECT e.id as entry_id, e.event_id as event_id, e.day_id as day_id, e.room_id as room_id, start_hour, start_minute, end_hour, end_minute, " .
		"user_id, purpose, comments, guests, r.room_name as room_name  " .
		"FROM $tbl_entry as e, $tbl_room as r " .
		" WHERE e.event_id=$event_id AND e.day_id=$day_id AND e.event_id=r.event_id AND e.room_id=r.id " .
		" ORDER BY e.start_hour, e.start_minute, r.room_number";
	
	// DEBUG START
	//echo "<p>sql=$sql</p>\n";
	// DEBUG END
	$res = sql_query($sql);
	if (!$res)
	{
		fatal_error(1, get_vocab('entryfetchfailed') . sql_error());
	}
	$rows = array();
	for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
	{
		$rows[] = $row;
	}
	sql_free($res);
	// DEBUG START
	//echo "<p>rows:</p>\n";
	//echo "<pre>\n";
	//print_r($rows);
	//echo "</pre>\n";
	// exit;
	// DEBUG END
	return $rows;
}

/**
 * get_entries_for_user - retrieves the records for a given event, day and room
 *
 * @return array of entry records sorted by start time (hour, minute)
 * @author Tamara Temple
 **/
function get_appointments_for_user($event_id, $day_id, $user_id)
{
	global $tbl_entry, $tbl_room;
	
	$sql = "SELECT e.id as entry_id, e.event_id as event_id, e.day_id as day_id, e.room_id as room_id, start_hour, start_minute, end_hour, end_minute, " .
		"user_id, purpose, comments, guests, r.id, r.event_id, r.room_name as room_name, r.room_number as room_number  " .
		"FROM $tbl_entry as e, $tbl_room as r " .
		" WHERE e.event_id=$event_id AND e.day_id=$day_id AND e.user_id=$user_id and e.event_id=r.event_id AND e.room_id=r.id " .
		" ORDER BY start_hour, start_minute, room_number";
	// DEBUG START
	//echo "<p>sql=$sql</p>\n";
	// DEBUG END

	
	$res = sql_query($sql);
	if (!$res)
	{
		fatal_error(1, get_vocab('entryfetchfailed') . sql_error());
	}
	$rows = array();
	for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
	{
		$rows[] = $row;
	}
	// DEBUG START
	//echo "<p>rows:</p>\n";
	//echo "<pre>\n";
	//print_r($rows);
	//echo "</pre>\n";
	// exit;
	// DEBUG END
	
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
	
	$sql = "SELECT * FROM $tbl_room WHERE event_id=$event_id ORDER BY id";
	$res = sql_query($sql);
	if (!$res)
	{
		fatal_error(1, get_vocab('roomfetchfailed') . sql_error());
	}
	$rows = array();
	for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
	{
		$rows[$row['id']] = $row; // sort by id number for easy access
	}
	sql_free($res);
	return $rows;
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
	$sql = "SELECT * FROM $tbl_day WHERE event_id=$event_id ORDER BY year, month, day";
	$res = sql_query($sql);
	if (!$res)
	{
		fatal_error(1, get_vocab('dayfetchfailed') . sql_error());
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
 * get_users
 * 
 * cache the users table in the program to keep from looking up entries in it all the time.
 * the array is indexed by id of the user to make lookups speedy
 *
 * @return array of users, sorted by id
 * @author Tamara Temple
 **/
function get_users()
{
	global $tbl_users;
	$sql = "SELECT * FROM $tbl_users ORDER BY id";
	$res = sql_query($sql);
	if (!$res) fatal_error(1, get_vocab('userfetchfailed') . sql_error());
	$rows = array();
	for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++) $rows[$row['id']] = $row; // indexed by row id to make lookups easier
	return $rows;
}



print_header($event_id,0);

// Users must be at least Level 1 for this page as we will be displaying
// information such as email addresses
if (!getAuthorised(1))
{
  showAccessDenied($day_id, $event_id);
  exit();
}

$loggedinuser = getUserName();


$required_level = (isset($max_level) ? $max_level : 2);
$is_admin = (authGetUserLevel($loggedinuser) >= $required_level);

$user = get_user_from_user_name($loggedinuser); // get the user record of the loggedinuser to use in subsequent elements

$user_id = $user['id'];
$user_first_name = $user['first_name'];
$user_last_name = $user['last_name'];

$users=get_users();
$days=get_days($event_id);
$rooms = get_rooms($event_id);

// emit_code_to_open_report
$title = get_vocab(($is_admin ? 'adminreporttitle' : 'userreporttitle'));
$user_name = $user['name'];
eval("\$title=\"$title\";"); // to interpolate variables in title string;
echo "<div class=\"report\">\n";
echo "<h1 class=\"report_title\">$title</h1>\n";

for ($i=0; $i < count($days), $day=$days[$i]; $i++)
{
	// emit_code_for_new_day
	echo "<div class=\"report_day\">\n";	
	echo "<div class=\"day_heading\">";
	$day_heading = get_vocab('day_heading');
	$day_string = $day['day_string'];
	eval("\$day_heading = \"$day_heading\";"); // interpolate variables
	echo $day_heading;
	echo "</div>\n";
	
	if ($is_admin)
	{
		$entries = get_entries($event_id, $day['id']);
	}
	else
	{
		$entries = get_appointments_for_user($event_id, $day['id'], $user_id);
	}
	?>
		<div class="report_day_entry">
		<table class="report_header" width="80%" cellpadding="2pt">
		<tr>
			<td width="40%" class="report_entry_cell"><?php echo get_vocab('purpose')  ?></td>
			<td width="20%" class="report_entry_cell"><?php echo get_vocab('creator') ?></td>
			<td width="20%" class="report_entry_cell"><?php echo get_vocab('duration')  ?></td>
 			<td width="20%" class="report_entry_cell"><?php echo get_vocab('room') ?></td>
		</tr>
		<tr>
		<td colspan="3" class="report_entry_cell"><?php echo get_vocab('guestlist') ?></td>
		<td class="report_entry_cell"><?php echo get_vocab('confirmed_q') ?></td>
		</tr>
		<tr>
		<td colspan="4" class="report_entry_cell"><?php echo get_vocab('comments') ?></td>
		</tr>
		</table>
		</div>
	
	<?php

	for ($k=0; $k < count($entries), $entry=$entries[$k]; $k++)
	{
		// emit_code_for_entry
		echo "<div class=\"report_day_entry\">\n";
		?>
		<table class="report_entry" width="80%" cellpadding="2pt" onMouseUp="location.href='edit_<?php echo ($entry['user_id'] > 0 ? "entry" : "slot") ?>.php?event_id=<?php echo $entry['event_id'] ?>&day_id=<?php echo $entry['day_id'] ?>&room_id=<?php echo $entry['room_id'] ?>&id=<?php echo $entry['entry_id'] ?>'">
		<tr class="report_entry_row" >
			<td width="40%" class="report_entry_cell">
			<?php
				if ($entry['user_id'] > 0)
				{
					echo truncateToDisplay(htmlspecialchars($entry['purpose']),$max_purpose_length_for_report);
				}
				else
				{
					echo get_vocab('available');
				}
				?></td>
		<?php
		if ($is_admin)
		{
			if ($entry['user_id'] > 0)
			{
				$organizer = $users[$entry['user_id']]['first_name'] . " " . $users[$entry['user_id']]['last_name'];
			}
			else
			{
				$organizer = get_vocab('unassigned');
			}
			echo "<td width=\"20%\" class=\"report_entry_cell\">" . truncateToDisplay(htmlspecialchars($organizer),$max_organizer_length_for_report) . "</td>\n";
		}
		$start_time = formatTime($entry['start_hour'],$entry['start_minute']);
		$end_time = formatTime($entry['end_hour'],$entry['end_minute']);
		?>
		<td width="20%" class="report_entry_cell"><?php echo htmlspecialchars($start_time) . " to " . htmlspecialchars($end_time)  ?></td>
 		<td width="20%" class="report_entry_cell"><?php echo htmlspecialchars($entry['room_name']) ?></td>
		</tr>
		<tr>
		<td colspan="3" class="report_entry_cell"><?php echo truncateToDisplay(htmlspecialchars($entry['guests']),$max_guest_list_length_for_report) ?></td>
		<td><?php if ($entry['user_id'] > 0) echo ($entry['confirmed'] == 0 ? get_vocab('notconfimed') : get_vocab('confirmed')); ?></td>
		</tr>
		<tr>
		<td colspan="4" class="report_entry_cell"><?php echo truncateToDisplay(htmlspecialchars($entry['comments']),$max_comment_length_for_report) ?></td>
		</tr>
		</table>
		</div>
		<?php
	}
	// emit_code_to_close_day
	echo "</div>\n";
}
// emit_code_to_close_report
echo "</div>";
$day_id = get_first_day_for_event($event_id);
echo "<p><strong><a href=\"day.php?event_id=$event_id&day_id=$day_id\">" . get_vocab(returncal) . "</a></strong></p>\n";
print_footer(0);

?>
