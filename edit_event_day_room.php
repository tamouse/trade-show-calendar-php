<?php
// $Id: edit_event_room.php 1319 2010-04-09 09:57:20Z cimorrison $

// If you want to add some extra columns to the room table to describe the room
// then you can do so and this page should automatically recognise them and handle
// them.    At the moment support is limited to the following column types:
//
// MySQL        PostgreSQL            Form input type
// -----        ----------            ---------------
// bigint       bigint                text
// int          integer               text
// mediumint                          text
// smallint     smallint              checkbox
// tinyint                            checkbox
// text         text                  textarea
// tinytext                           textarea
//              character varying     textarea
// varchar(n)   character varying(n)  text/textarea, depending on the value of n
//              character             text
// char(n)      character(n)          text/textarea, depending on the value of n
//
// NOTE 1: For char(n) and varchar(n) fields, a text input will be presented if
// n is less than or equal to $text_input_max, otherwise a textarea box will be
// presented.
//
// NOTE 2: PostgreSQL booleans are not supported, due to difficulties in
// handling the fields in a database independent way (a PostgreSQL boolean
// will return a PHP boolean type when read by a PHP query, whereas a MySQL
// tinyint returns an int).   In order to have a boolean field in the room
// table you should use a smallint in PostgreSQL or a smallint or a tinyint
// in MySQL.
//
// You can put a description of the column that will be used as the label in
// the form in the appropriate lang file(s) using the tag 'room.[columnname]'.
// For example if you want to add a column specifying whether or not a room
// has a coffee machine you could add a column to the room table called
// 'coffee_machine' of type tinyint(1), in MySQL, or smallint in PostgreSQL.
// Then in the appropriate lang file(s) you would add the line
//
// vocab["room.coffee_machine"] = "Coffee machine";  // or appropriate translation
//
// If CDMA can't find an entry for the field in the lang file, then it will use
// the fieldname, eg 'coffee_machine'.

require_once "defaultincludes.inc";

require_once "cdma_sql.inc";




// Get form variables
$day_id = get_form_var('day_id', 'int');
$day_string = get_form_var('day_string', 'string');
$old_day_string = get_form_var('old_day_string', 'string');
$event_id = get_form_var('event_id', 'int');
$new_event = get_form_var ('new_event', 'int');
$old_event = get_form_var ('old_event', 'int');
$old_event_name = get_form_var('old_event_name', 'string');
$room_id = get_form_var('room_id', 'int');
$room_number = get_form_var('room_number', 'int');
$room_name = get_form_var('room_name', 'string');
$room_desc = get_form_var('room_description', 'string');
$old_room_number = get_form_var('old_room_number', 'int');
$old_room_name = get_form_var('old_room_name', 'string');
$old_room_desc = get_form_var('old_room_desc', 'string');
$event_name = get_form_var('event_name', 'string');
$event_admin_email = get_form_var('event_admin_email', 'string');
$change_done = get_form_var('change_done', 'string');
$change_room = get_form_var('change_room', 'string');
$change_event = get_form_var('change_event', 'string');
$change_day = get_form_var('change_day', 'string');


$event_var_prefix = 'e_';
$room_var_prefix = 'r_';
$day_var_prefix = 'd_';



// get_form_var_extended($tbl_day, $day_var_prefix);


// Users must be at least Level 1 for this page as we will be displaying
// information such as email addresses
if (!getAuthorised(1))
{
  showAccessDenied($day_id, $event_id);
  exit();
}
$is_admin = getAdmin();

// Done changing event or room information?
if (isset($change_done))
{
  if (!empty($room_id)) // Get the event the room is in
  {
    $event_id = cdmaGetRoomEvent($room_id);
  }
	else if (!empty($day_id)) // Get the event the day is in
	{
		$event_id = get_event_from_day($day_id);
	}
	else
	{
		$event_id = get_first_event();
	}
  $location = "admin.php?event_id=$event_id";
	redirect($location);
}

// Intialise the validation booleans
$valid_email = TRUE;
$valid_event = TRUE;
$valid_room_name = TRUE;
$valid_room_number = TRUE;
$valid_day_string = TRUE;



// PHASE 2
// -------
// Unauthorised users shouldn't normally be able to reach Phase 2, but just in case
// they have, check again that they are allowed to be here
if (isset($change_room) || isset($change_event) || isset($change_day))
{
  if (!$is_admin)
  {
    showAccessDenied($day_id, $event_id);
    exit();
  }
}

// PHASE 2 (ROOM) - UPDATE THE DATABASE
// ------------------------------------
if (isset($change_room) && !empty($room_id))
{
	// Get the information about the fields in the given table
	$fields = sql_field_info($tbl_room);

	// Get any user defined form variables
	foreach($fields as $field)
	{
	  switch($field['nature'])
	  {
	    case 'character':
	      $type = 'string';
	      break;
	    case 'integer':
	      $type = 'int';
	      break;
	    // We can only really deal with the types above at the moment
	    default:
	      $type = 'string';
	      break;
	  }
	  $var = $room_var_prefix . $field['name'];
	  $$var = get_form_var($var, $type);
	  if (($type == 'int') && ($$var === ''))
	  {
	    unset($$var);
	  }
	}


	// Acquire a mutex to lock out others who might be deleting the new event
	if (!sql_mutex_lock("$tbl_event"))
	{
		fatal_error(TRUE, get_vocab("failed_to_acquire"));
	}
	if (!isset($room_number) || (!is_numeric($room_number)))
	{
		$valid_room_number = FALSE;
	}
	// Check the new event still exists
	elseif (sql_query1("SELECT COUNT(*) FROM $tbl_event WHERE id=$new_event LIMIT 1") < 1)
	{
		$valid_event = FALSE;
	}
	// If so, check that the room name or room number is not already used in the event
	// (only do this if you're changing the room name or the event - if you're
	// just editing the other details for an existing room we don't want to reject
	// the edit because the room already exists!)
	elseif ( (($new_event != $old_event) || ($room_name != $old_room_name) )
		&& sql_query1("SELECT COUNT(*) FROM $tbl_room WHERE room_name='" . addslashes($room_name) . "' AND event_id=$new_event LIMIT 1") > 0)
	{
		$valid_room_name = FALSE;
	}
	// Also do the same check for room number
	elseif ( (($new_event != $old_event) || ($room_number != $old_room_number))
		&& sql_query1("SELECT COUNT(*) FROM $tbl_room WHERE room_number=" . $room_number . " AND event_id=$new_event LIMIT 1") > 0)
	{
		$valid_room_number = FALSE;
	}
	// If everything is still OK, update the database
	else
	{
		$sql = "UPDATE $tbl_room SET ";
		$n_fields = count($fields);
		$assign_array = array();
		foreach ($fields as $field)
		{
			if ($field['name'] != 'id')  // don't do anything with the id field
			{
				switch ($field['name'])
				{
					// first of all deal with the standard CDMA fields
					case 'event_id':
					$assign_array[] = "event_id=$new_event";
					break;
					case 'room_name':
					$assign_array[] = "room_name='" . addslashes($room_name) . "'";
					break;
					case 'room_number':
					$assign_array[] = "room_number=" . $room_number;
					break;
					case 'room_description':
					$assign_array[] = "room_description='" . addslashes($room_desc) . "'";
					break;
					default:
					$var = $room_var_prefix . $field['name'];
					switch ($field['nature'])
					{
						case 'integer':
						if (!isset($$var))
						{
							$$var = 'NULL';
						}
						break;
						default:
						$$var = "'" . addslashes($$var) . "'";
						break;
					}
					$assign_array[] = $field['name'] . "=" . $$var;
					break;
				}
			}
		}
		$sql .= implode(",", $assign_array) . " WHERE id=$room_id";
		
		if (sql_command($sql) < 0)
		{
			fatal_error(0, get_vocab("update_room_failed") . sql_error());
		}
		// if everything is OK, release the mutex and go back to
		// the admin page (for the new event)
		sql_mutex_unlock("$tbl_event");
		$location = "admin.php?&event_id=$new_event";
		redirect($location);

	}

	// Release the mutex
	sql_mutex_unlock("$tbl_event");
}

// PHASE 2 (event) - UPDATE THE DATABASE
// ------------------------------------

if (isset($change_event) && !empty($event_id))
{ 
	// Get the information about the fields in the given table
	$fields = sql_field_info($tbl_event);

	// Get any user defined form variables
	foreach($fields as $field)
	{
	  switch($field['nature'])
	  {
	    case 'character':
	      $type = 'string';
	      break;
	    case 'integer':
	      $type = 'int';
	      break;
	    // We can only really deal with the types above at the moment
	    default:
	      $type = 'string';
	      break;
	  }
	  $var = $event_var_prefix . $field['name'];
	  $$var = get_form_var($var, $type);
	  if (($type == 'int') && ($$var === ''))
	  {
	    unset($$var);
	  }
	}

	// validate email addresses
	$valid_email = validate_email_list($event_admin_email);

	// If everything is OK, update the database
	if ((FALSE != $valid_email))
	{
		$sql = "UPDATE $tbl_event SET ";
		$assign_array = array();
		foreach ($fields as $field)
		{
			if ($field['name'] != 'id')  // don't do anything with the id field
			{
				switch ($field['name'])
				{
					// first of all deal with the standard CDMA fields
					case 'event_name':
						$assign_array[] = "event_name='" . addslashes($event_name) . "'";
						break;
					case 'event_admin_email':
						$assign_array[] = "event_admin_email='" . addslashes($event_admin_email) . "'";
						break;
					default:
						$var = $room_var_prefix . $field['name'];
						switch ($field['nature'])
						{
							case 'integer':
								if (!isset($$var))
								{
									$$var = 'NULL';
								}
								break;
							default:
								$$var = "'" . addslashes($$var) . "'";
								break;
						}
						$assign_array[] = $field['name'] . "=" . $$var;
						break;
				}
			}
		}

		$sql .= implode(",", $assign_array) . " WHERE id=$event_id";
		if (sql_command($sql) < 0)
		{
			fatal_error(0, get_vocab("update_event_failed") . sql_error());
		}
		// If the database update worked OK, go back to the admin page
		$location = "admin.php?" . 
			(isset($event_id) ? "&event_id=$new_event" : '');
		redirect($location);
	}
}

// PHASE 2 (day) - UPDATE THE DATABASE
// ------------------------------------

if (isset($change_day) && !empty($day_id))
{ 
	// Get the information about the fields in the given table
	$fields = sql_field_info($tbl_day);

	// Get any user defined form variables
	foreach($fields as $field)
	{
	  switch($field['nature'])
	  {
	    case 'character':
	      $type = 'string';
	      break;
	    case 'integer':
	      $type = 'int';
	      break;
	    // We can only really deal with the types above at the moment
	    default:
	      $type = 'string';
	      break;
	  }
	  $var = $day_var_prefix . $field['name'];
	  $$var = get_form_var($var, $type);
	  if (($type == 'int') && ($$var === ''))
	  {
	    unset($$var);
	  }
	}
	// DEBUG START
	// echo "<p>\$day_string=$day_string</p>\n";
	// echo "<pre>\n";
	// print_r();
	// echo "</pre>\n";
	// exit;
	// DEBUG END
	
	if (($new_event == $old_event) && ($day_string == $old_day_string)) 
	{
		// no changes made
		$location="admin.php?event_id=$event_id&room_id=$room_id&day_id=$day_id";
		redirect($location);
	}
	$t = strtotime($day_string);
	if (!t)
	{
		$valid_day_string = FALSE;
	}

	// Check the new event still exists
	if (sql_query1("SELECT COUNT(*) FROM $tbl_event WHERE id=$new_event LIMIT 1") < 1)
	{
		$valid_event = FALSE;
		$error = 'invalid_event';
	}
	// If so, check that the room name or room number is not already used in the event
	// (only do this if you're changing the room name or the event - if you're
	// just editing the other details for an existing room we don't want to reject
	// the edit because the room already exists!)
	elseif ( (($new_event != $old_event) || ($day_string != $old_day_string)))
	{
		$sql = "SELECT COUNT(*) FROM $tbl_day WHERE day_string='" . addslashes($day_string) . "' AND event_id=$new_event LIMIT 1";
		// DEBUG START
		// echo "<p>\$sql=$sql</p>\n";
		// exit;
		// DEBUG END
		
		if (sql_query1($sql) > 0) 
		{
			$valid_day_string = FALSE;
			$error = 'duplicate_day_string';
		}
	}
	// If everything is still OK, update the database
	if ($valid_event && $valid_day_string)
	{
		$sql = "UPDATE $tbl_day SET ";
		$assign_array = array();
	    $ignore = array('id', 'day', 'month', 'year');
		foreach ($fields as $field)
		{
			if (!in_array($field['name'], $ignore))  // don't do anything with certain fields
			{
				switch ($field['name'])
				{
					case 'event_id':
						$assign_array[] = "event_id=$new_event";
						break;
					case 'day_string':
						$day_ar = getdate($t);				// $t is set above where the $day_string is validated
						$day = $day_ar['mday'];
						$month = $day_ar['mon'];
						$year = $day_ar['year'];
						$day_string = date($date_format_str, $t);
						$assign_array[] = $field['name'] . "='" . addslashes($day_string) . "'";
						$assign_array[] = "day=$day";
						$assign_array[] = "month=$month";
						$assign_array[] = "year=$year";
						break;

					default:
					$var = $room_var_prefix . $field['name'];
					switch ($field['nature'])
					{
						case 'integer':
						if (!isset($$var))
						{
							$$var = 'NULL';
						}
						break;
						default:
						$$var = "'" . addslashes($$var) . "'";
						break;
					}
					$assign_array[] = $field['name'] . "=" . $$var;
					break;
				}
			}
		}
		$sql .= implode(",", $assign_array) . " WHERE id=$day_id";
		// DEBUG START
		// echo "<p>\$sql=$sql</p>\n";
		// echo "<pre>\n";
		// print_r($assign_array);
		// echo "</pre>\n";
		// exit;
		// DEBUG END


		if (sql_command($sql) < 0)
		{
			fatal_error(0, get_vocab("update_day_failed") . sql_error());
		}
		// If the database update worked OK, go back to the admin page
		$location = "admin.php?" . 
			(isset($new_event) ? "&event_id=$new_event" : '');
		redirect($location);
	}
}




// PHASE 1 - GET THE USER INPUT
// ----------------------------

print_header($event_id, $day_id);

if ($is_admin)
{
  // Heading is confusing for non-admins
  echo "<h2>" . get_vocab("editroomdayevent") . "</h2>\n";
}

if (!empty($error))
{
  echo "<p class=\"error\">" . get_vocab($error) . "</p>\n";
}

// Non-admins will only be allowed to view room details, not change them
// (We would use readonly instead of disabled, but it is not valid for some 
// elements, eg <select>)
$disabled = ($is_admin) ? "" : " disabled=\"disabled\"";

// THE ROOM FORM
if (!empty($room_id))
{
  $res = sql_query("SELECT * FROM $tbl_room WHERE id=$room_id LIMIT 1");
  if (! $res)
  {
    fatal_error(0, get_vocab("error_room") . $room . get_vocab("not_found"));
  }
  $row = sql_row_keyed($res, 0);
  
  echo "<h2>\n";
  echo ($is_admin) ? get_vocab("editroom") : get_vocab("viewroom");
  echo "</h2>\n";
  ?>
  <form class="form_general" id="edit_room" action="edit_event_day_room.php" method="post">
    <fieldset class="admin">
    <legend></legend>
  
      <fieldset>
      <legend></legend>
        <span class="error">
           <?php 
           // It's impossible to have more than one of these error messages, so no need to worry
           // about paragraphs or line breaks.
           echo ((FALSE == $valid_email) ? get_vocab('invalid_email') : "");
           echo ((FALSE == $valid_event) ? get_vocab('invalid_event') : "");
           echo ((FALSE == $valid_room_name) ? get_vocab('invalid_room_name') : "");
           ?>
        </span>
      </fieldset>
    
      <fieldset>
      <legend></legend>
      <input type="hidden" name="room_id" value="<?php echo $row["id"]?>">
    
      <?php
	if ($display_events)
	{
		$res = sql_query("SELECT id, event_name FROM $tbl_event");
		if (!$res)
		{
			fatal_error(FALSE, "Fatal error: " . sql_error());  // should not happen
		}
		if (sql_count($res) == 0)
		{
			fatal_error(FALSE, get_vocab('noevents'));  // should not happen
		}

		// The event select box
		echo "<div>\n";
		echo "<label for=\"new_event\">" . get_vocab("event") . ":</label>\n";
		echo "<select id=\"new_event\" name=\"new_event\"$disabled>\n";
		for ($i = 0; ($row_event = sql_row_keyed($res, $i)); $i++)
		{
			echo "<option value=\"" . $row_event['id'] . "\"";
			if ($row_event['id'] == $row['event_id'])
			{
				echo " selected=\"selected\"";
			}
			echo ">" . $row_event['event_name'] . "</option>\n";
		}  
		echo "</select>\n";
		echo "<input type=\"hidden\" name=\"old_event\" value=\"" . $row['event_id'] . "\">\n";
		echo "</div>\n";
	}
	if (!isset($fields))
	{
		$fields = sql_field_info($tbl_room);
	}
      foreach ($fields as $field)
      {
        if (!in_array($field['name'], array('id', 'event_id')))  // Ignore certain fields
        {
          echo "<div>\n";
          switch($field['name'])
          {
            // first of all deal with the standard CDMA fields
            case 'room_name':
              echo "<label for=\"room_name\">" . get_vocab("name") . ":</label>\n";
              echo "<input type=\"text\" id=\"room_name\" name=\"room_name\" value=\"" . htmlspecialchars($row["room_name"]) . "\"$disabled>\n";
              echo "<input type=\"hidden\" name=\"old_room_name\" value=\"" . htmlspecialchars($row["room_name"]) . "\">\n";
              break;
            case 'room_number':
                echo "<label for=\"room_number\" title=\"" . get_vocab("room_number_note") . "\">" . get_vocab("room_number") . ":</label>\n";
                echo "<input type=\"text\" id=\"room_number\" name=\"room_number\" value=\"" . htmlspecialchars($row["room_number"]) . "\"$disabled>\n";
				echo "<input type=\"hidden\" name=\"old_room_number\" value=\"" . htmlspecialchars($row["room_number"]) . "\">\n";
              break;
            case 'room_description':
              echo "<label for=\"room_description\">" . get_vocab("description") . ":</label>\n";
              echo "<input type=\"text\" id=\"room_description\" name=\"room_description\" value=\"" . htmlspecialchars($row["room_description"]) . "\"$disabled>\n";
              break;
            // then look at any user defined fields
            default:
              $label_text = get_loc_field_name($tbl_room, $field['name']);
              echo "<label for=\"$room_var_prefix" . $field['name'] . "\">$label_text:</label>\n";
              // Output a checkbox if it's a boolean or integer <= 2 bytes (which we will
              // assume are intended to be booleans)
              if (($field['nature'] == 'boolean') || 
                  (($field['nature'] == 'integer') && isset($field['length']) && ($field['length'] <= 2)) )
              {
                echo "<input type=\"checkbox\" class=\"checkbox\" " .
                      "id=\"$room_var_prefix" . $field['name'] . "\" " .
                      "name=\"$room_var_prefix" . $field['name'] . "\" " .
                      "value=\"1\" " .
                      ((!empty($row[$field['name']])) ? " checked=\"checked\"" : "") .
                      "$disabled>\n";
              }
              // Output a textarea if it's a character string longer than the limit for a
              // text input
              elseif (($field['nature'] == 'character') && isset($field['length']) && ($field['length'] > $text_input_max))
              {
                echo "<textarea rows=\"8\" cols=\"40\" " .
                      "id=\"$room_var_prefix" . $field['name'] . "\" " .
                      "name=\"$room_var_prefix" . $field['name'] . "\" " .
                      "$disabled>\n";
                echo htmlspecialchars($row[$field['name']]);
                echo "</textarea>\n";
              }
              // Otherwise output a text input
              else
              {
                echo "<input type=\"text\" " .
                      "id=\"$room_var_prefix" . $field['name'] . "\" " .
                      "name=\"$room_var_prefix" . $field['name'] . "\" " .
                      "value=\"" . htmlspecialchars($row[$field['name']]) . "\"" .
                      "$disabled>\n";
              }
              break;
          }
          echo "</div>\n";
        }
      }
      echo "</fieldset>\n";
    
      // Submit and Back buttons (Submit only if they're an admin)  
      echo "<fieldset class=\"submit_buttons\">\n";
      echo "<legend></legend>\n";
      echo "<div id=\"edit_event_day_room_submit_back\">\n";
      echo "<input class=\"submit\" type=\"submit\" name=\"change_done\" value=\"" . get_vocab("backadmin") . "\">\n";
      echo "</div>\n";
      if ($is_admin)
      { 
        echo "<div id=\"edit_event_day_room_submit_save\">\n";
        echo "<input class=\"submit\" type=\"submit\" name=\"change_room\" value=\"" . get_vocab("change") . "\">\n";
        echo "</div>\n";
      }
      echo "</fieldset>\n";
        
    	echo "</fieldset>";
  		echo "</form>\n";

}

echo "<div class=\"day_region\">\n";

// THE DAY FORM
if (!empty($day_id))
{
  $res = sql_query("SELECT * FROM $tbl_day WHERE id=$day_id LIMIT 1");
  if (! $res)
  {
    fatal_error(0, get_vocab("error_day") . $room . get_vocab("not_found"));
  }
  $row = sql_row_keyed($res, 0);
  
  echo "<h2>\n";
  echo ($is_admin) ? get_vocab("editday") : get_vocab("viewday");
  echo "</h2>\n";
  ?>
  <form class="form_general" id="edit_day" action="edit_event_day_room.php" method="post">
    <fieldset class="admin">
    <legend></legend>
  
   
      <fieldset>
      <legend></legend>
      <input type="hidden" name="day_id" value="<?php echo $row["id"]?>">
    
      <?php
	if ($display_events)
	{
		$res = sql_query("SELECT id, event_name FROM $tbl_event");
		if (!$res)
		{
			fatal_error(FALSE, "Fatal error: " . sql_error());  // should not happen
		}
		if (sql_count($res) == 0)
		{
			fatal_error(FALSE, get_vocab('noevents'));  // should not happen
		}

		// The event select box
		echo "<div>\n";
		echo "<label for=\"new_event\">" . get_vocab("event") . ":</label>\n";
		echo "<select id=\"new_event\" name=\"new_event\"$disabled>\n";
		for ($i = 0; ($row_event = sql_row_keyed($res, $i)); $i++)
		{
			echo "<option value=\"" . $row_event['id'] . "\"";
			if ($row_event['id'] == $row['event_id'])
			{
				echo " selected=\"selected\"";
			}
			echo ">" . $row_event['event_name'] . "</option>\n";
		}  
		echo "</select>\n";
		echo "<input type=\"hidden\" name=\"old_event\" value=\"" . $row['event_id'] . "\">\n";
		echo "</div>\n";
	}

	if (!isset($fields))
	{
		$fields = sql_field_info($tbl_day);
	}
      foreach ($fields as $field)
      {
        if (!in_array($field['name'], array('id', 'event_id', 'day', 'month', 'year')))  // Ignore certain fields
        {
          echo "<div>\n";
          switch($field['name'])
          {
            // first of all deal with the standard CDMA fields
			case 'day_string':
			?>
				<script type="text/javascript">
					$(function() {
						$("#day_string").datepicker({dateFormat: 'mm/dd/yy'});
						$( "#day_string" ).datepicker({ gotoCurrent: true });
						$("#day_string").datepicker();
					});
					</script>
				<input type="hidden" name="old_day_string" value="<?php echo $row['day_string']?>">
				<label for="day_string"><?php echo get_vocab('day_string'); ?>:</label>
				<input type="text" id="day_string" name="day_string" <?php echo $disabled ?> value="<?php echo htmlspecialchars($row['day_string']); ?>">
			<?php
				break;
            // then look at any user defined fields
            default:
              $label_text = get_loc_field_name($tbl_day, $field['name']);
              echo "<label for=\"$day_var_prefix" . $field['name'] . "\">$label_text:</label>\n";
              // Output a checkbox if it's a boolean or integer <= 2 bytes (which we will
              // assume are intended to be booleans)
              if (($field['nature'] == 'boolean') || 
                  (($field['nature'] == 'integer') && isset($field['length']) && ($field['length'] <= 2)) )
              {
                echo "<input type=\"checkbox\" class=\"checkbox\" " .
                      "id=\"$day_var_prefix" . $field['name'] . "\" " .
                      "name=\"$day_var_prefix" . $field['name'] . "\" " .
                      "value=\"1\" " .
                      ((!empty($row[$field['name']])) ? " checked=\"checked\"" : "") .
                      "$disabled>\n";
              }
              // Output a textarea if it's a character string longer than the limit for a
              // text input
              elseif (($field['nature'] == 'character') && isset($field['length']) && ($field['length'] > $text_input_max))
              {
                echo "<textarea rows=\"8\" cols=\"40\" " .
                      "id=\"$day_var_prefix" . $field['name'] . "\" " .
                      "name=\"$day_var_prefix" . $field['name'] . "\" " .
                      "$disabled>\n";
                echo htmlspecialchars($row[$field['name']]);
                echo "</textarea>\n";
              }
              // Otherwise output a text input
              else
              {
                echo "<input type=\"text\" " .
                      "id=\"$day_var_prefix" . $field['name'] . "\" " .
                      "name=\"$day_var_prefix" . $field['name'] . "\" " .
                      "value=\"" . htmlspecialchars($row[$field['name']]) . "\"" .
                      "$disabled>\n";
              }
              break;
          }
          echo "</div>\n";
        }
      }
      echo "</fieldset>\n";
    
      // Submit and Back buttons (Submit only if they're an admin)  
      echo "<fieldset class=\"submit_buttons\">\n";
      echo "<legend></legend>\n";
		echo "<div id=\"submit_buttons\">\n";
      echo "<input class=\"submit\" type=\"submit\" name=\"change_done\" value=\"" . get_vocab("backadmin") . "\">\n";
      if ($is_admin)
      { 
        echo "<input class=\"submit\" type=\"submit\" name=\"change_day\" value=\"" . get_vocab("change") . "\">\n";
      }

	echo "</div>\n";
      echo "</fieldset>\n";
echo "</fieldset>\n";    
  echo "</form>\n";
}



// THE event FORM
if (!empty($event_id))
{
	// Only admins can see this form
	if (!$is_admin)
	{
		showAccessDenied($day_id, $event_id);
		exit();
	}
	// Get the details for this event
	$res = sql_query("SELECT * FROM $tbl_event WHERE id=$event_id LIMIT 1");
	if (! $res)
	{
		fatal_error(0, get_vocab("error_event") . $event_id . get_vocab("not_found"));
	}
	$row = sql_row_keyed($res, 0);
	sql_free($res);
	?>

	<form class="form_general" id="edit_event" action="edit_event_day_room.php" method="post">
	<fieldset class="admin">
	<legend><?php echo get_vocab("editevent") ?></legend>

	<fieldset>
		<legend></legend>
		<?php
	if (FALSE == $valid_email)
	{
		echo "<p class=\"error\">" .get_vocab('invalid_email') . "</p>\n";
	}
	?>
	</fieldset>

	<fieldset>
	<legend><?php echo get_vocab("general_settings")?></legend>
	<input type="hidden" name="event_id" value="<?php echo $row["id"]?>">

	<div>
		<label for="event_name"><?php echo get_vocab("name") ?>:</label>
		<input type="text" id="event_name" name="event_name" value="<?php echo htmlspecialchars($row["event_name"]); ?>">
	</div>

	<div>
		<label for="event_admin_email"><?php echo get_vocab("event_admin_email") ?>:</label>
		<input type="text" id="event_admin_email" name="event_admin_email" maxlength="75" value="<?php echo htmlspecialchars($row["event_admin_email"]); ?>">
	</div>

	<?php
	if (!isset($fields))
	{
		$fields = sql_field_info($tbl_event);
	}
	
	foreach ($fields as $field)
	{
		if (!in_array($field['name'], array('id', 'event_name', 'event_admin_email')))  // Ignore certain fields
		{
			echo "<div>\n";
			$label_text = get_loc_field_name($tbl_event, $field['name']);
			echo "<label for=\"$event_var_prefix" . $field['name'] . "\">$label_text:</label>\n";
			// Output a checkbox if it's a boolean or integer <= 2 bytes (which we will
			// assume are intended to be booleans)
			if (($field['nature'] == 'boolean') || 
				(($field['nature'] == 'integer') && isset($field['length']) && ($field['length'] <= 2)) )
			{
				echo "<input type=\"checkbox\" class=\"checkbox\" " .
					"id=\"$event_var_prefix" . $field['name'] . "\" " .
					"name=\"$event_var_prefix" . $field['name'] . "\" " .
					"value=\"1\" " .
					((!empty($row[$field['name']])) ? " checked=\"checked\"" : "") .
					">\n";
			}
			// Output a textarea if it's a character string longer than the limit for a
			// text input
			elseif (($field['nature'] == 'character') && isset($field['length']) && ($field['length'] > $text_input_max))
			{
				echo "<textarea rows=\"8\" cols=\"40\" " .
					"id=\"$event_var_prefix" . $field['name'] . "\" " .
					"name=\"$event_var_prefix" . $field['name'] . "\" " .
					">\n";
				echo htmlspecialchars($row[$field['name']]);
				echo "</textarea>\n";
			}
			// Otherwise output a text input
			else
			{
				echo "<input type=\"text\" " .
					"id=\"$event_var_prefix" . $field['name'] . "\" " .
					"name=\"$event_var_prefix" . $field['name'] . "\" " .
					"value=\"" . htmlspecialchars($row[$field['name']]) . "\"" .
					">\n";
			}
			echo "</div>\n";
		}
	}

	?>

		</fieldset>

		<fieldset class="submit_buttons">
		<legend></legend>
		<div id="edit_event_room_submit_back">
		<input class="submit" type="submit" name="change_done" value="<?php echo get_vocab("backadmin") ?>">
	</div>
		<div id="edit_event_room_submit_save">
		<input class="submit" type="submit" name="change_event" value="<?php echo get_vocab("change") ?>">
	</div>
		</fieldset>

		</fieldset>
		</form>
		<?php
}

require_once "trailer.inc" ?>
