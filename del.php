<?php

require_once "defaultincludes.inc";

// Get form variables
$day_id = get_form_var('day_id', 'int');
$event_id = get_form_var('event_id', 'int');
$room_id = get_form_var('room_id', 'int');
$type = get_form_var('type', 'string');
$confirm = get_form_var('confirm', 'string');

$required_level = (isset($max_level) ? $max_level : 2);
if (!getAuthorised($required_level))
{
	$errormsg = 'norights';
  showAccessDenied($day_id, $event_id, $errormsg);
  exit();
}

// This is gonna blast away something. We want them to be really
// really sure that this is what they want to do.

if ($type == "room")
{
	if (!isset($event_id))
	{
		$event_id = get_event_from_room($room_id);
	}
	
  // We are supposed to delete a room
  if (isset($confirm))
  {
    // They have confirmed it already, so go blast!
    sql_begin();
    // First take out all appointments for this room
    sql_command("delete from $tbl_entry where room_id=$room_id");
   
    // Now take out the room itself
    sql_command("delete from $tbl_room where id=$room_id");
    sql_commit();
   
    // Go back to the admin page
    $location = "admin.php?event_id=$event_id";
	redirect($location);
  }
  else
  {
    print_header($event_id, $day_id);
   
    // We tell them how bad what theyre about to do is
    // Find out how many appointments would be deleted
   
    $sql = "select user_id, purpose, start_hour, start_minute from $tbl_entry where room_id=$room_id";
    $res = sql_query($sql);
    if (! $res)
    {
      echo sql_error();
    }
    else if (sql_count($res) > 0)
    {
      echo "<p>\n";
      echo get_vocab("deletefollowing") . ":\n";
      echo "</p>\n";
      
      echo "<ul>\n";
      
      for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
      {
        echo "<li>".htmlspecialchars($row['purpose'])." (";
        echo $row['start_hour'] . ":" . $row['start_minute'] . ")</li>\n";
      }
      
      echo "</ul>\n";
    }
   
    echo "<div id=\"del_room_confirm\">\n";
    echo "<p>" .  get_vocab("sure") . "</p>\n";
    echo "<div id=\"del_room_confirm_links\">\n";
    echo "<a href=\"del.php?type=room&room_id=$room_id&event_id=$event_id&confirm=Y\"><span id=\"del_yes\">" . get_vocab("YES") . "!</span></a>\n";
    echo "<a href=\"admin.php?event_id=$event_id\"><span id=\"del_no\">" . get_vocab("NO") . "!</span></a>\n";
    echo "</div>\n";
    echo "</div>\n";
  }
}

if ($type == "day")
{
	if (!isset($event_id))
	{
		$event_id = get_event_from_day($day_id);
	}

  // We are supposed to delete a day
  if (isset($confirm))
  {
    // They have confirmed it already, so go blast!
    sql_begin();
    // First take out all appointments for this room
    sql_command("delete from $tbl_entry where day_id=$day_d");
   
    // Now take out the day itself
    sql_command("delete from $tbl_day where id=$day_id");
    sql_commit();
   
    // Go back to the admin page
    $location = "admin.php?event_id=$event_id";
	redirect($location);
  }
  else
  {
    print_header($event_id, $day_id);
   
    // We tell them how bad what theyre about to do is
    // Find out how many appointments would be deleted
   
    $sql = "select purpose, start_hour, start_minute from $tbl_entry where day_id=$day_id";
    $res = sql_query($sql);
    if (! $res)
    {
      echo sql_error();
    }
    else if (sql_count($res) > 0)
    {
      echo "<p>\n";
      echo get_vocab("deletefollowing") . ":\n";
      echo "</p>\n";
      
      echo "<ul>\n";
      
      for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
      {
        echo "<li>".htmlspecialchars($row['purpose'])." (";
        echo $row['start_hour'] . ":" . $row['start_minute'] . ")</li>\n";
      }
      
      echo "</ul>\n";
    }
   
    echo "<div id=\"del_room_confirm\">\n";
    echo "<p>" .  get_vocab("sure") . "</p>\n";
    echo "<div id=\"del_room_confirm_links\">\n";
    echo "<a href=\"del.php?type=day&day_id=$day_id&?event_id=$event_id&confirm=Y\"><span id=\"del_yes\">" . get_vocab("YES") . "!</span></a>\n";
    echo "<a href=\"admin.php?event_id=$event_id\"><span id=\"del_no\">" . get_vocab("NO") . "!</span></a>\n";
    echo "</div>\n";
    echo "</div>\n";
  }
}

if ($type == "event")
{
  // We are only going to let them delete an event if there are
  // no rooms or days. its easier
  $n_rooms = sql_query1("select count(*) from $tbl_room where event_id=$event_id");
  $n_days = sql_query1("select count(*) from $tbl_day where event_id=$event_id");
  if ($n_rooms == 0 && $n_days == 0)
  {
    // OK, nothing there, lets blast it away
    sql_command("delete from $tbl_event where id=$event_id");
   
    // Redirect back to the admin page
    $location ="admin.php";
	redirect($location);
  }
  else
  {
    // There are rooms left in the event
    print_header($event_id, $day_id);
    echo "<p>\n";
    echo get_vocab("delevent");
    echo "<a href=\"admin.php?event_id=$event_id\">" . get_vocab("backadmin") . "</a>";
    echo "</p>\n";
  }
}
require_once "trailer.inc";

?>
