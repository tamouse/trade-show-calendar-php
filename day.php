<?php
// $Id: day.php 1281 2009-12-09 22:37:17Z jberanek $

require_once "defaultincludes.inc";
require_once "theme.inc";

// Get form variables
$event_id = get_form_var('event_id', 'int');
$day_id = get_form_var('day_id', 'int');
$debug_flag = get_form_var('debug_flag', 'int');

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


// print the page header
print_header($event_id, $day_id);

$format = "Gi";

// TOP SECTION:  THE FORM FOR SELECTING AN EVENT
echo "<div id=\"event_form\">\n";
$sql = "select id, event_name from $tbl_event order by event_name";
$res = sql_query($sql);
if ($res == -1) fatal_error(0, "select from $tbl_event failed: " . sql_error());
$events_defined = $res && (sql_count($res) > 0);
if ($events_defined)
{
  // If there are some events defined, then show the event form
  echo "<form id=\"eventChangeForm\" method=\"get\" action=\"$PHP_SELF\">\n";
  echo "<fieldset>\n";
  echo "<legend></legend>\n";
  
  // The event selector
  echo "<label id=\"event_label\" for=\"event_select\">" . get_vocab("event") . ":</label>\n";
  echo "<select class=\"room_event_select\" id=\"event_select\" name=\"event_id\" onchange=\"this.form.submit()\">";
  for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
  {
    $selected = ($row['id'] == $event_id) ? "selected=\"selected\"" : "";
    echo "<option $selected value=\"". $row['id']. "\">" . htmlspecialchars($row['event_name']) . "</option>";
  }
  echo "</select>\n";
  
  // Some hidden inputs for current day, room
  echo "<input type=\"hidden\" name=\"day_id\" value=\"$day_id\">\n";
  echo "<input type=\"hidden\" name=\"room_id\" value=\"$room_id\">\n";

  
  // The change event button (won't be needed or displayed if JavaScript is enabled)
  echo "<input type=\"submit\" name=\"change\" class=\"js_none\" value=\"" . get_vocab("change") . "\">\n";
  
  // If they're an admin then give them edit and delete buttons for the event
  // and also a form for adding a new event
  if ($is_admin)
  {
    // Can't use <button> because IE6 does not support those properly
    echo "<input type=\"image\" class=\"button\" name=\"edit\" src=\"images/edit.png\"
           title=\"" . get_vocab("edit") . "\" alt=\"" . get_vocab("edit") . "\">\n";
    echo "<input type=\"image\" class=\"button\" name=\"delete\" src=\"images/delete.png\"
           title=\"" . get_vocab("delete") . "\" alt=\"" . get_vocab("delete") . "\">\n";
  }
  
  echo "</fieldset>\n";
  echo "</form>\n";
}
else
{
  echo "<p>" . get_vocab("noevents") . "</p>\n";
}

// Form for changing days in an event
echo "<div id=\"day_form\">\n";
$sql = "select id, day_string from $tbl_day where event_id=$event_id order by day_string";

$res = sql_query($sql);
if ($res == -1) fatal_error(0, "select from $tbl_day failed: " . sql_error());
$days_defined = $res && (sql_count($res) > 0);
if ($days_defined)
{
  // If there are some days defined, then show the day form
  echo "<form id=\"dayChangeForm\" method=\"get\" action=\"$PHP_SELF\">\n";
  echo "<fieldset>\n";
  echo "<legend></legend>\n";
  
  // The event selector
  echo "<label id=\"day_label\" for=\"event_select\">" . get_vocab("date") . ":</label>\n";
  echo "<select class=\"room_day_select\" id=\"day_select\" name=\"day_id\" onchange=\"this.form.submit()\">";
  for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
  {
    $selected = ($row['id'] == $day_id) ? "selected=\"selected\"" : "";
    echo "<option $selected value=\"". $row['id']. "\">" . htmlspecialchars($row['day_string']) . "</option>";
  }
  echo "</select>\n";
  
  // Some hidden inputs for current day, room
  echo "<input type=\"hidden\" name=\"event_id\" value=\"$event_id\">\n";
  echo "<input type=\"hidden\" name=\"room_id\" value=\"$room_id\">\n";

  
  // The change event button (won't be needed or displayed if JavaScript is enabled)
  echo "<input type=\"submit\" name=\"change\" class=\"js_none\" value=\"" . get_vocab("change") . "\">\n";
  
  // If they're an admin then give them edit and delete buttons for the event
  // and also a form for adding a new event
  if ($is_admin)
  {
    // Can't use <button> because IE6 does not support those properly
    echo "<input type=\"image\" class=\"button\" name=\"edit\" src=\"images/edit.png\"
           title=\"" . get_vocab("edit") . "\" alt=\"" . get_vocab("edit") . "\">\n";
    echo "<input type=\"image\" class=\"button\" name=\"delete\" src=\"images/delete.png\"
           title=\"" . get_vocab("delete") . "\" alt=\"" . get_vocab("delete") . "\">\n";
  }
  
  echo "</fieldset>\n";
  echo "</form>\n";
}
else
{
  echo "<p>" . get_vocab("nodays") . "</p>\n";
}



if (isset($event_id))
{
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
  echo "<h1>".get_vocab("no_rooms_for_event")."</h1>";
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
    $header .= "<th class=\"first_last\">" . get_vocab("time") . ":</th>";
  
    $column_width = (int)(95 / sql_count($res));
    for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
    {
      $header .= "<th style=\"width: $column_width%\">" .
                  htmlspecialchars($row['room_name']) . "</th>";
      $rooms[] = $row['id'];
    }
  
    // next line to display times on right side
    if ( FALSE != $row_labels_both_sides )
    {
      $header .= "<th class=\"first_last\">" . ( $enable_periods  ? get_vocab("period") : get_vocab("time") ) . ":</th>";
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
		$t++
		)
	{
      
      // calculate hour and minute (needed for links)
//      $hour = date("H",$t);
//      $minute = date("i",$t);
		$hour = $t;
		$minute = "00";
  
      echo "<tr class=\"$row_class\">";
      draw_time_cell($hour, $minute);
  
      // Loop through the list of rooms we have for this area
      while (list($key, $room_id) = each($rooms))
      {
        // set up the query strings to be used for the link in the cell
        $query_strings = array();
        $query_strings['new_slot']      = "event_id=$event_id&room_id=$room_id&day_id=$day_id&hour=$hour&minute=$minute";
        $query_strings['new_booking']   = "event_id=$event_id&room_id=$room_id&day_id=$day_id&hour=$hour&minute=$minute"; // draw_cell will add the entry_id
        $query_strings['view_booking']  = "event_id=$event_id&room_id=$room_id&day_id=$day_id"; // draw_cell will add the entry_id
		$slot = get_entry_by_event_day_room($event_id, $day_id, $room_id, $hour, $minute);
        draw_cell($slot, $query_strings);
      }
      
      // next lines to display times on right side
      if ( FALSE != $row_labels_both_sides )
      {
        draw_time_cell($hour,$minute);
      }
  
      echo "</tr>\n";
      reset($rooms);
	}  // end standard view (for the body)
  
  echo "</tbody>\n";
  echo "</table>\n";

  print $before_after_links_html;

  show_colour_key();
}
}
require_once "trailer.inc";
?>
