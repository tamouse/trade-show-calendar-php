<?php
// $Id: day.php 1281 2009-12-09 22:37:17Z jberanek $

require_once "defaultincludes.inc";
require_once "theme.inc";

// Get form variables
$event_id = get_form_var('event_id', 'int');
$day_id = get_form_var('day_id', 'int');
$mode = get_form_var('mode', 'int');
$debug_flag = get_form_var('debug_flag', 'int');
$error = get_form_var('error' , 'string');
$message = get_form_var('message', 'string');

if (empty($mode)) $mode = 0; // managing appointments
// if $mode is set to 1, we're managing slots;

if (empty($debug_flag))
{
  $debug_flag = 0;
}

if (!isset($event_id))
{
	$event_id = get_first_event();
}


if (!isset($day_id))
{
	$day_id = get_first_day_for_event($event_id);
}


$is_admin = getAdmin();

if (($mode == 1) && (!$is_admin))
{
	// User is not authorized to manage slots, kick back to admin
	redirect("admin.php?event_id=$event_id&day_id=$day_id&error=norights");
}


// print the page header
print_header($event_id, $day_id);

if (!empty($error))
{
  echo "<p class=\"error\" id=\"$error\">" . get_vocab($error) . "</p>\n";
}
if (!empty($message))
{
	echo "<p class=\"message\" id=\"$message\">" . get_vocab($message) . "</p>\n";
}



$format = "Gi";

// TOP SECTION:  THE FORM FOR SELECTING A EVENTS (maybe) AND DAYS

if ($display_events)
{
	echo make_event_selector_html($event_id, $room_id, $day_id, FALSE);
}

echo make_day_selector_html($event_id, $room_id, $day_id, $mode);

if ($mode == 0)
{
	echo "<div class=\"instructions\">" . get_vocab('instructions1') . " \n";
	echo get_vocab('instructions2') . "</div>\n";
}
else
{
	echo "<div class=\"instructions\">" . get_vocab('instructions3') . "</div>\n";
}
// We need to know what all the rooms area called, so we can show them all
// pull the data from the db and store it. Convienently we can print the room
// headings and capacities at the same time

$sql = "SELECT * FROM $tbl_room WHERE event_id=$event_id ORDER BY room_number";

$res = sql_query($sql);

// It might be that there are no rooms defined for this area.
// If there are none then show an error and don't bother doing anything
// else
if (! $res)
{
  fatal_error(0, "Error getting room data from event $event_id : " . sql_error());
}
if (sql_count($res) == 0)
{
  echo "<h2>".get_vocab("no_rooms_for_event")."</h2>";
  sql_free($res);
}
else
{

	$before_after_links_html = "";

	// and output them
	print $before_after_links_html;

	// START DISPLAYING THE MAIN TABLE
	echo "<table class=\"dwm_main\" id=\"day_main\">\n";

	// TABLE HEADER
	echo "<thead>\n";
	$header = "<tr>\n";


	// the standard view, with rooms along the top and times down the side
	if ($row_labels)
	{
		$header .= "<th class=\"first_last\">" . get_vocab("time") . ":</th>";
	}

	$column_width = (int)(95 / sql_count($res));
	for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
	{
		$header .= "<th style=\"width: $column_width%\">" .
			htmlspecialchars($row['room_name']) . "</th>";
		$rooms[] = $row['id'];
	}

	// next line to display times on right side
	if ($row_labels_both_sides )
	{
		$header .= "<th class=\"first_last\">" . get_vocab("time") . ":</th>";
	}

	$header .= "</tr>\n";
	echo $header;
	echo "</thead>\n";

	// Now repeat the header in a footer if required
	if ($column_labels_both_ends)
	{
		echo "<tfoot>\n";
		echo $header;
		echo "</tfoot>\n";
	}


	// TABLE BODY LISTING BOOKINGS
	echo "<tbody>\n";

	// This is the main bit of the display
	// We loop through time and then the rooms we just got



	$row_class = "even_row";

	for (
		//         $t = mktime($morningstarts, $morningstarts_minutes, 0, $month, $day, $year);
		//         $t <= mktime($eveningends, $eveningends_minutes, 0, $month, $day, $year);
		//         $t += $resolution, $row_class = ($row_class == "even_row")?"odd_row":"even_row"
		$t = $morningstarts;
		$t <= $eveningends;
		$t++, $row_class = ($row_class == "even_row")?"odd_row":"even_row"
		)
	{

		// calculate hour and minute (needed for links)
		//      $hour = date("H",$t);
		//      $minute = date("i",$t);
		$hour = $t;
		$minute = "00";

		echo "<tr class=\"$row_class\">";
		if ($row_labels)
		{
			draw_time_cell($hour, $minute);
		}
		
		// Loop through the list of rooms we have for this area
		while (list($key, $room_id) = each($rooms))
		{
			// set up the query strings to be used for the link in the cell
			$query_strings = array();
			$query_strings['new_slot']      = "event_id=$event_id&room_id=$room_id&day_id=$day_id&start_hour=$hour&start_minute=$minute";
			$query_strings['new_booking']   = "event_id=$event_id&room_id=$room_id&day_id=$day_id&start_hour=$hour&start_minute=$minute"; // draw_cell will add the entry_id
			$query_strings['view_booking']  = "event_id=$event_id&room_id=$room_id&day_id=$day_id"; // draw_cell will add the entry_id
			$slot = get_entry_by_event_day_room($event_id, $day_id, $room_id, $hour, $minute);
			draw_cell($slot, $query_strings, $mode);
		}

		// next lines to display times on right side
		if ($row_labels && $row_labels_both_sides )
		{
			draw_time_cell($hour,$minute);
		}

		echo "</tr>\n";
		reset($rooms);
	}  // end standard view (for the body)

	echo "</tbody>\n";
	echo "</table>\n";

	print $before_after_links_html;

	// show_colour_key();
}

if ($mode == 1)
{
	echo "<div>";
	echo "<a href=\"admin.php?event_id=$event_id&room_id=$room_id&day_id=$day_id\">" . get_vocab("backadmin") . "</a>";
	echo "</div>\n";
	
}
require_once "trailer.inc";
?>
