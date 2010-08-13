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
$event_id = get_form_var('event_id', 'int');
$new_event = get_form_var ('new_event', 'int');
$old_event = get_form_var ('old_event', 'int');
$room_id = get_form_var('room', 'int');
$room_number = get_form_var('room_number', 'string');
$room_name = get_form_var('room_name', 'string');
$room_desc = get_form_var('room_desc', 'string');
$old_room_number = get_form_var('old_room_number', 'string');
$old_room_name = get_form_var('old_room_name', 'string');
$old_room_desc = get_form_var('old_room_desc', 'string');
$event_name = get_form_var('event_name', 'string');
$change_done = get_form_var('change_done', 'string');
$change_room = get_form_var('change_room', 'string');
$change_event = get_form_var('change_event', 'string');

// Get the information about the fields in the room table
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
  $var = "f_" . $field['name'];
  $$var = get_form_var($var, $type);
  if (($type == 'int') && ($$var === ''))
  {
    unset($$var);
  }
}


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
  if (!empty($room)) // Get the event the room is in
  {
    $event_id = cdmaGetRoomEvent($room);
  }
  Header("Location: admin.php?day_id=$day_id&event_id=$event_id");
  exit();
}

// Intialise the validation booleans
$valid_email = TRUE;
$valid_resolution = TRUE;
$enough_slots = TRUE;
$valid_event = TRUE;
$valid_room_name = TRUE;



// PHASE 2
// -------
// Unauthorised users shouldn't normally be able to reach Phase 2, but just in case
// they have, check again that they are allowed to be here
if (isset($change_room) || isset($change_event))
{
  if (!$is_admin)
  {
    showAccessDenied($day_id, $event_id);
    exit();
  }
}

// PHASE 2 (ROOM) - UPDATE THE DATABASE
// ------------------------------------
if (isset($change_room) && !empty($room))
{
  // validate the email addresses
  $valid_email = validate_email_list($room_admin_email);
  
  if (FALSE != $valid_email)
  {
    if (empty($capacity))
    {
      $capacity = 0;
    }
    
    // Acquire a mutex to lock out others who might be deleting the new event
    if (!sql_mutex_lock("$tbl_event"))
    {
      fatal_error(TRUE, get_vocab("failed_to_acquire"));
    }
    // Check the new event still exists
    if (sql_query1("SELECT COUNT(*) FROM $tbl_event WHERE id=$new_event LIMIT 1") < 1)
    {
      $valid_event = FALSE;
    }
    // If so, check that the room name is not already used in the event
    // (only do this if you're changing the room name or the event - if you're
    // just editing the other details for an existing room we don't want to reject
    // the edit because the room already exists!)
    elseif ( (($new_event != $old_event) || ($room_name != $old_room_name))
            && sql_query1("SELECT COUNT(*) FROM $tbl_room WHERE room_name='" . addslashes($room_name) . "' AND event_id=$new_event LIMIT 1") > 0)
    {
      $valid_room_name = FALSE;
    }
    // If everything is still OK, update the databasae
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
            case 'sort_key':
              $assign_array[] = "sort_key='" . addslashes($sort_key) . "'";
              break;
            case 'description':
              $assign_array[] = "description='" . addslashes($description) . "'";
              break;
            case 'capacity':
              $assign_array[] = "capacity=$capacity";
              break;
            case 'room_admin_email':
              $assign_array[] = "room_admin_email='" . addslashes($room_admin_email) . "'";
              break;
            case 'custom_html':
              $assign_array[] = "custom_html='" . addslashes($custom_html) . "'";
              break;
            // then look at any user defined fields
            default:
              $var = "f_" . $field['name'];
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
      $sql .= implode(",", $assign_array) . " WHERE id=$room";
      if (sql_command($sql) < 0)
      {
        fatal_error(0, get_vocab("update_room_failed") . sql_error());
      }
      // if everything is OK, release the mutex and go back to
      // the admin page (for the new event)
      sql_mutex_unlock("$tbl_event");
      Header("Location: admin.php?day=$day&month=$month&year=$year&event_id=$new_event");
      exit();
    }
    
    // Release the mutex
    sql_mutex_unlock("$tbl_event");
  }
}

// PHASE 2 (event) - UPDATE THE DATABASE
// ------------------------------------

if (isset($change_event) && !empty($event))
{ 
  // validate email addresses
  $valid_email = validate_email_list($event_admin_email);
  
  // Tidy up the input from the form
  if (isset($event_eveningends_t))
  {
    // if we've been given a time in minutes rather than hours and minutes, convert it
    // (this will happen if JavaScript is enabled)
    $event_eveningends_minutes = $event_eveningends_t % 60;
    $event_eveningends = ($event_eveningends_t - $event_eveningends_minutes)/60;
  }

  if (!empty($event_morning_ampm))
  {
    if (($event_morning_ampm == "pm") && ($event_morningstarts < 12))
    {
      $event_morningstarts += 12;
    }
    if (($event_morning_ampm == "am") && ($event_morningstarts > 11))
    {
      $event_morningstarts -= 12;
    }
  }

  if (!empty($event_evening_ampm))
  {
    if (($event_evening_ampm == "pm") && ($event_eveningends < 12))
    {
      $event_eveningends += 12;
    }
    if (($event_evening_ampm == "am") && ($event_eveningends > 11))
    {
      $event_eveningends -= 12;
    }
  }
  
  // Convert the book ahead times into seconds
  fromTimeString($event_min_ba_value, $event_min_ba_units);
  fromTimeString($event_max_ba_value, $event_max_ba_units);
  
  // Convert booleans into 0/1 (necessary for PostgreSQL)
  $event_min_ba_enabled = (!empty($event_min_ba_enabled)) ? 1 : 0;
  $event_max_ba_enabled = (!empty($event_max_ba_enabled)) ? 1 : 0;
  $event_private_enabled = (!empty($event_private_enabled)) ? 1 : 0;
  $event_private_mandatory = (!empty($event_private_mandatory)) ? 1 : 0;
  $event_provisional_enabled = (!empty($event_provisional_enabled)) ? 1 : 0;
  $event_reminders_enabled = (!empty($event_reminders_enabled)) ? 1 : 0;
    
  if (!$enable_periods)
  { 
    // Avoid divide by zero errors
    if ($event_res_mins == 0)
    {
      $valid_resolution = FALSE;
    }
    else
    {
      // Check morningstarts, eveningends, and resolution for consistency
      $start_first_slot = ($event_morningstarts*60) + $event_morningstarts_minutes;   // minutes
      $start_last_slot  = ($event_eveningends*60) + $event_eveningends_minutes;       // minutes
      $start_difference = ($start_last_slot - $start_first_slot);         // minutes
      if (($start_difference < 0) or ($start_difference%$event_res_mins != 0))
      {
        $valid_resolution = FALSE;
      }
      
      // Check that the number of slots we now have is no greater than $max_slots
      // defined in the config file - otherwise we won't generate enough CSS classes
      $n_slots = ($start_difference/$event_res_mins) + 1;
      if ($n_slots > $max_slots)
      {
        $enough_slots = FALSE;
      }
    }
  }
    
  // If everything is OK, update the database
  if ((FALSE != $valid_email) && (FALSE != $valid_resolution) && (FALSE != $enough_slots))
  {
    $sql = "UPDATE $tbl_event SET ";
    $assign_array = array();
    $assign_array[] = "event_name='" . addslashes($event_name) . "'";
    $assign_array[] = "event_admin_email='" . addslashes($event_admin_email) . "'";
    $assign_array[] = "custom_html='" . addslashes($custom_html) . "'";
    if (!$enable_periods)
    {
      // only update the min and max book_ahead_secs fields if the form values
      // are set;  they might be NULL because they've been disabled by JavaScript
      $assign_array[] = "resolution=" . $event_res_mins * 60;
      $assign_array[] = "default_duration=" . $event_def_duration_mins * 60;
      $assign_array[] = "morningstarts=" . $event_morningstarts;
      $assign_array[] = "morningstarts_minutes=" . $event_morningstarts_minutes;
      $assign_array[] = "eveningends=" . $event_eveningends;
      $assign_array[] = "eveningends_minutes=" . $event_eveningends_minutes;
      $assign_array[] = "min_book_ahead_enabled=" . $event_min_ba_enabled;
      $assign_array[] = "max_book_ahead_enabled=" . $event_max_ba_enabled;
      if (isset($event_min_ba_value))
      {
        $assign_array[] = "min_book_ahead_secs=" . $event_min_ba_value;
      }
      if (isset($event_max_ba_value))
      {
        $assign_array[] = "max_book_ahead_secs=" . $event_max_ba_value;
      }
    }
    $assign_array[] = "private_enabled=" . $event_private_enabled;
    $assign_array[] = "private_default=" . $event_private_default;
    $assign_array[] = "private_mandatory=" . $event_private_mandatory;
    $assign_array[] = "private_override='" . $event_private_override . "'";
    $assign_array[] = "provisional_enabled=" . $event_provisional_enabled;
    $assign_array[] = "reminders_enabled=" . $event_reminders_enabled;
            
    $sql .= implode(",", $assign_array) . " WHERE id=$event_id";
    if (sql_command($sql) < 0)
    {
      fatal_error(0, get_vocab("update_event_failed") . sql_error());
    }
    // If the database update worked OK, go back to the admin page
    Header("Location: admin.php?day=$day&month=$month&year=$year&event_id=$event_id");
    exit();
  }
}


// PHASE 1 - GET THE USER INPUT
// ----------------------------

print_header($day, $month, $year, isset($event_id) ? $event_id : "", isset($room) ? $room : "");

if ($is_admin)
{
  // Heading is confusing for non-admins
  echo "<h2>" . get_vocab("editroomevent") . "</h2>\n";
}

// Non-admins will only be allowed to view room details, not change them
// (We would use readonly instead of disabled, but it is not valid for some 
// elements, eg <select>)
$disabled = ($is_admin) ? "" : " disabled=\"disabled\"";

// THE ROOM FORM
if (!empty($room))
{
  $res = sql_query("SELECT * FROM $tbl_room WHERE id=$room LIMIT 1");
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
      <input type="hidden" name="room" value="<?php echo $row["id"]?>">
    
      <?php
      $res = sql_query("SELECT id, event_name FROM $tbl_event");
      if (!$res)
      {
        fatal_error(FALSE, "Fatal error: " . sql_error);  // should not happen
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
            case 'sort_key':
              if ($is_admin)
              {
                echo "<label for=\"sort_key\" title=\"" . get_vocab("sort_key_note") . "\">" . get_vocab("sort_key") . ":</label>\n";
                echo "<input type=\"text\" id=\"sort_key\" name=\"sort_key\" value=\"" . htmlspecialchars($row["sort_key"]) . "\"$disabled>\n";
              }
              break;
            case 'description':
              echo "<label for=\"description\">" . get_vocab("description") . ":</label>\n";
              echo "<input type=\"text\" id=\"description\" name=\"description\" value=\"" . htmlspecialchars($row["description"]) . "\"$disabled>\n";
              break;
            case 'capacity':
              echo "<label for=\"capacity\">" . get_vocab("capacity") . ":</label>\n";
              echo "<input type=\"text\" id=\"capacity\" name=\"capacity\" value=\"" . $row["capacity"] . "\"$disabled>\n";
              break;
            case 'room_admin_email':
              echo "<label for=\"room_admin_email\">" . get_vocab("room_admin_email") . ":</label>\n";
              echo "<input type=\"text\" id=\"room_admin_email\" name=\"room_admin_email\" maxlength=\"75\" value=\"" . htmlspecialchars($row["room_admin_email"]) . "\"$disabled>\n";
              break;
            case 'custom_html':
              if ($is_admin)
              {
                // Only show the raw HTML to admins.  Non-admins will see the rendered HTML
                echo "<label for=\"room_custom_html\" title=\"" . get_vocab("custom_html_note") . "\">" . get_vocab("custom_html") . ":</label>\n";
                echo "<textarea id=\"room_custom_html\" class=\"custom_html\" name=\"custom_html\" rows=\"4\" cols=\"40\"$disabled>\n";
                echo htmlspecialchars($row['custom_html']);
                echo "</textarea>\n";
              }
              break;
            // then look at any user defined fields
            default:
              $label_text = get_loc_field_name($tbl_room, $field['name']);
              echo "<label for=\"f_" . $field['name'] . "\">$label_text:</label>\n";
              // Output a checkbox if it's a boolean or integer <= 2 bytes (which we will
              // assume are intended to be booleans)
              if (($field['nature'] == 'boolean') || 
                  (($field['nature'] == 'integer') && isset($field['length']) && ($field['length'] <= 2)) )
              {
                echo "<input type=\"checkbox\" class=\"checkbox\" " .
                      "id=\"f_" . $field['name'] . "\" " .
                      "name=\"f_" . $field['name'] . "\" " .
                      "value=\"1\" " .
                      ((!empty($row[$field['name']])) ? " checked=\"checked\"" : "") .
                      "$disabled>\n";
              }
              // Output a textarea if it's a character string longer than the limit for a
              // text input
              elseif (($field['nature'] == 'character') && isset($field['length']) && ($field['length'] > $text_input_max))
              {
                echo "<textarea rows=\"8\" cols=\"40\" " .
                      "id=\"f_" . $field['name'] . "\" " .
                      "name=\"f_" . $field['name'] . "\" " .
                      "$disabled>\n";
                echo htmlspecialchars($row[$field['name']]);
                echo "</textarea>\n";
              }
              // Otherwise output a text input
              else
              {
                echo "<input type=\"text\" " .
                      "id=\"f_" . $field['name'] . "\" " .
                      "name=\"f_" . $field['name'] . "\" " .
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
        
      ?>
    </fieldset>
  </form>

  <?php
  // Now the custom HTML
  echo "<div id=\"custom_html\">\n";
  // no htmlspecialchars() because we want the HTML!
  echo (!empty($row['custom_html'])) ? $row['custom_html'] . "\n" : "";
  echo "</div>\n";
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
  // Get the settings for this event, from the database if they are there, otherwise from
  // the config file.    A little bit inefficient repeating the SQL query
  // we've just done, but it makes the code simpler and this page is not used very often.
  get_event_settings($event_id);
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
        if (FALSE == $valid_resolution)
        {
          echo "<p class=\"error\">" .get_vocab('invalid_resolution') . "</p>\n";
        }
        if (FALSE == $enough_slots)
        {
          echo "<p class=\"error\">" .get_vocab('too_many_slots') . "</p>\n";
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
      </fieldset>
      
      <?php
        // The custom HTML
        echo "<div>\n";
        echo "<label for=\"event_custom_html\" title=\"" . get_vocab("custom_html_note") . "\">" . get_vocab("custom_html") . ":</label>\n";
        echo "<textarea id=\"event_custom_html\" class=\"custom_html\" name=\"custom_html\" rows=\"4\" cols=\"40\">\n";
        echo htmlspecialchars($row['custom_html']);
        echo "</textarea>\n";
        echo "</div>\n";
    
      if (!$enable_periods)
      {
      ?>
        <script type="text/javascript">
        //<![CDATA[
      
          function getTimeString(time, twentyfourhour_format)
          {
             // Converts a time (in minutes since midnight) into a string
             // of the form hh:mm if twentyfourhour_format is true,
             // otherwise of the form hh:mm am/pm.
           
             // This function doesn't do a great job of replicating the PHP
             // internationalised format, but is probably sufficient for a 
             // rarely used admin page.
           
             var minutes = time % 60;
             time -= minutes;
             var hour = time/60;
             if (!twentyfourhour_format)
             {
               var ap = "AM";
               if (hour > 11) {ap = "PM";}
               if (hour > 12) {hour = hour - 12;}
               if (hour == 0) {hour = 12;}
             }
             if (hour < 10) {hour   = "0" + hour;}
             if (minutes < 10) {minutes = "0" + minutes;}
             var timeString = hour + ':' + minutes;
             if (!twentyfourhour_format)
             {
               timeString += ap;
             }
             return timeString;
          } // function getTimeString()

        
          function writeSelect(morningstarts, morningstarts_minutes, eveningends, eveningends_minutes, res_mins)
          {
            // generates the HTML for the drop-down for the last slot time and
            // puts it in the element with id 'last_slot'
            if (res_mins == 0) return;  // avoid endless loops
          
            var first_slot = (morningstarts * 60) + morningstarts_minutes;
            var last_slot = (eveningends * 60) + eveningends_minutes;
            var last_possible = (24 * 60) - res_mins;
            var html = '<label for="event_eveningends_t"><?php echo get_vocab("event_last_slot_start")?>:<\/label>\n';
            html += '<select id="event_eveningends_t" name="event_eveningends_t">\n';
            for (var t=first_slot; t <= last_possible; t += res_mins)
            {
              html += '<option value="' + t + '"';
              if (t == last_slot)
              {
                html += ' selected="selected"';
              }
              html += ">" + getTimeString(t, <?php echo ($twentyfourhour_format ? "true" : "false") ?>) + "<\/option>\n";
            }
            html += "<\/select>\n";
            document.getElementById('last_slot').innerHTML = html;
          }  // function writeSelect
        
      
          function changeSelect(formObj)
          {
            // re-generates the dropdown given changed form values
            var res_mins = parseInt(formObj.event_res_mins.value);
            if (res_mins == 0) return;  // avoid endless loops and divide by zero errors
            var morningstarts = parseInt(formObj.event_morningstarts.value);
            var morningstarts_minutes = parseInt(formObj.event_morningstarts_minutes.value);
            var eveningends_t = parseInt(formObj.event_eveningends_t.value);
            var morningstarts_t = (morningstarts * 60) + morningstarts_minutes;
            var ampm = "am";
            if (formObj.event_morning_ampm && formObj.event_morning_ampm[1].checked)
            {
              ampm = "pm";
            }        
            if (<?php echo (!$twentyfourhour_format ? "true" : "false") ?>)
            {
              if ((ampm == "pm") && (morningstarts < 12))
              {
                morningstarts += 12;
              }
              if ((ampm == "am") && (morningstarts>11))
              {
                morningstarts -= 12;
              }
            }
            // Find valid values for eveningends
            var remainder = (eveningends_t - morningstarts_t) % res_mins;
            // round up to the nearest slot boundary
            if (remainder != 0)
            {
              eveningends_t += res_mins - remainder;
            }
            // and then step back to make sure that the end of the slot isn't past midnight (and the beginning isn't before the morning start)
            while ((eveningends_t + res_mins > 1440) && (eveningends_t > morningstarts_t + res_mins))  // 1440 minutes in a day
            {
              eveningends_t -= res_mins;
            }
            // convert into hours and minutes
            var eveningends_minutes = eveningends_t % 60;
            var eveningends = (eveningends_t - eveningends_minutes) / 60;
            writeSelect (morningstarts, morningstarts_minutes, eveningends, eveningends_minutes, res_mins);
          } // function changeSelect
        
        //]]>
        </script>
      
        <fieldset>
        <legend><?php echo get_vocab("time_settings")?></legend>
        <div class="div_time">
          <label><?php echo get_vocab("event_first_slot_start")?>:</label>
          <?php
          echo "<input class=\"time_hour\" type=\"text\" id=\"event_morningstarts\" name=\"event_morningstarts\" value=\"";
          if ($twentyfourhour_format)
          {
            printf("%02d", $morningstarts);
          }
          elseif ($morningstarts > 12)
          {
            echo ($morningstarts - 12);
          } 
          elseif ($morningstarts == 0)
          {
            echo "12";
          }
          else
          {
            echo $morningstarts;
          } 
          echo "\" maxlength=\"2\" onChange=\"changeSelect(this.form)\">\n";
          ?>
          <span>:</span>
          <input class="time_minute" type="text" id="event_morningstarts_minutes" name="event_morningstarts_minutes" value="<?php printf("%02d", $morningstarts_minutes) ?>" maxlength="2" onChange="changeSelect(this.form)">
          <?php
          if (!$twentyfourhour_format)
          {
            echo "<div class=\"group ampm\">\n";
            $checked = ($morningstarts < 12) ? "checked=\"checked\"" : "";
            echo "      <label><input name=\"event_morning_ampm\" type=\"radio\" value=\"am\" onClick=\"changeSelect(this.form)\" $checked>" . utf8_strftime("%p",mktime(1,0,0,1,1,2000)) . "</label>\n";
            $checked = ($morningstarts >= 12) ? "checked=\"checked\"" : "";
            echo "      <label><input name=\"event_morning_ampm\" type=\"radio\" value=\"pm\" onClick=\"changeSelect(this.form)\" $checked>". utf8_strftime("%p",mktime(13,0,0,1,1,2000)) . "</label>\n";
            echo "</div>\n";
          }
          ?>
        </div>
      
        <div class="div_dur_mins">
        <label for="event_res_mins"><?php echo get_vocab("event_res_mins") ?>:</label>
        <input type="text" id="event_res_mins" name="event_res_mins" value="<?php echo $resolution/60 ?>" onChange="changeSelect(this.form)">
        </div>
      
        <div class="div_dur_mins">
        <label for="event_def_duration_mins"><?php echo get_vocab("event_def_duration_mins") ?>:</label>
        <input type="text" id="event_def_duration_mins" name="event_def_duration_mins" value="<?php echo $default_duration/60 ?>">
        </div>
        <?php
        echo "<div id=\"last_slot\">\n";
        // The contents of this div will be overwritten by JavaScript if enabled.    The JavaScript version is a drop-down
        // select input with options limited to those times for the last slot start that are valid.   The options are
        // dynamically regenerated if the start of the first slot or the resolution change.    The code below is
        // therefore an alternative for non-JavaScript browsers.
        echo "<div class=\"div_time\">\n";
          echo "<label>" . get_vocab("event_last_slot_start") . ":</label>\n";
          echo "<input class=\"time_hour\" type=\"text\" id=\"event_eveningends\" name=\"event_eveningends\" value=\"";
          if ($twentyfourhour_format)
          {
            printf("%02d", $eveningends);
          }
          elseif ($eveningends > 12)
          {
            echo ($eveningends - 12);
          } 
          elseif ($eveningends == 0)
          {
            echo "12";
          }
          else
          {
            echo $eveningends;
          } 
          echo "\" maxlength=\"2\" onChange=\"changeSelect(this.form)\">\n";

          echo "<span>:</span>\n";
          echo "<input class=\"time_minute\" type=\"text\" id=\"event_eveningends_minutes\" name=\"event_eveningends_minutes\" value=\""; 
          printf("%02d", $eveningends_minutes);
          echo "\" maxlength=\"2\" onChange=\"changeSelect(this.form)\">\n";
          if (!$twentyfourhour_format)
          {
            echo "<div class=\"group ampm\">\n";
            $checked = ($eveningends < 12) ? "checked=\"checked\"" : "";
            echo "      <label><input name=\"event_evening_ampm\" type=\"radio\" value=\"am\" onClick=\"changeSelect(this.form)\" $checked>" . utf8_strftime("%p",mktime(1,0,0,1,1,2000)) . "</label>\n";
            $checked = ($eveningends >= 12) ? "checked=\"checked\"" : "";
            echo "      <label><input name=\"event_evening_ampm\" type=\"radio\" value=\"pm\" onClick=\"changeSelect(this.form)\" $checked>". utf8_strftime("%p",mktime(13,0,0,1,1,2000)) . "</label>\n";
            echo "</div>\n";
          }
        echo "</div>\n";  
        echo "</div>\n";  // last_slot
        ?>
      
        <script type="text/javascript">
        //<![CDATA[
          writeSelect(<?php echo "$morningstarts, $morningstarts_minutes, $eveningends, $eveningends_minutes, $resolution/60" ?>);
        //]]>
        </script>
        </fieldset>
        
        <?php
        // Booking policies
        $min_ba_value = $min_book_ahead_secs;
        toTimeString($min_ba_value, $min_ba_units);
        $max_ba_value = $max_book_ahead_secs;
        toTimeString($max_ba_value, $max_ba_units);
        echo "<fieldset id=\"booking_policies\">\n";
        echo "<legend>" . get_vocab("booking_policies") . "</legend>\n";
        // Minimum book ahead
        echo "<div>\n";
        echo "<label for=\"event_min_book_ahead\">" . get_vocab("min_book_ahead") . ":</label>\n";
        echo "<input class=\"checkbox\" type=\"checkbox\" id=\"event_min_ba_enabled\" name=\"event_min_ba_enabled\"" .
             (($min_book_ahead_enabled) ? " checked=\"checked\"" : "") .
             " onChange=\"check_book_ahead()\">\n";
        echo "<input class=\"text\" type=\"text\" name=\"event_min_ba_value\" value=\"$min_ba_value\">";
        echo "<select id=\"event_min_ba_units\" name=\"event_min_ba_units\">\n";
        $units = array("seconds", "minutes", "hours", "days", "weeks");
        foreach ($units as $unit)
        {
          echo "<option value=\"$unit\"" .
               (($min_ba_units == get_vocab($unit)) ? " selected=\"selected\"" : "") .
               ">" . get_vocab($unit) . "</option>\n";
        }
        echo "</select>\n";
        echo "</div>\n";
        // Maximum book ahead
        echo "<div>\n";
        echo "<label for=\"event_max_book_ahead\">" . get_vocab("max_book_ahead") . ":</label>\n";
        echo "<input class=\"checkbox\" type=\"checkbox\" id=\"event_max_ba_enabled\" name=\"event_max_ba_enabled\"" .
             (($max_book_ahead_enabled) ? " checked=\"checked\"" : "") .
             " onChange=\"check_book_ahead()\">\n";
        echo "<input class=\"text\" type=\"text\" name=\"event_max_ba_value\" value=\"$max_ba_value\">";
        echo "<select id=\"event_max_ba_units\" name=\"event_max_ba_units\">\n";
        $units = array("seconds", "minutes", "hours", "days", "weeks");
        foreach ($units as $unit)
        {
          echo "<option value=\"$unit\"" .
               (($max_ba_units == get_vocab($unit)) ? " selected=\"selected\"" : "") .
               ">" . get_vocab($unit) . "</option>\n";
        }
        echo "</select>\n";
        echo "</div>\n";
        echo "</fieldset>\n";
      } // end if (!$enable_periods)
    
      ?>
      
      <fieldset>
      <legend><?php echo get_vocab("provisional_settings")?></legend>
        <div>
          <label for="event_provisional_enabled"><?php echo get_vocab("enable_provisional")?>:</label>
          <?php $checked = ($provisional_enabled) ? " checked=\"checked\"" : "" ?>
          <input class="checkbox" type="checkbox"<?php echo $checked ?> id="event_provisional_enabled" name="event_provisional_enabled">
        </div>
        <div>
          <label for="event_reminders_enabled"><?php echo get_vocab("enable_reminders")?>:</label>
          <?php $checked = ($reminders_enabled) ? " checked=\"checked\"" : "" ?>
          <input class="checkbox" type="checkbox"<?php echo $checked ?> id="event_reminders_enabled" name="event_reminders_enabled">
        </div>
      </fieldset>
      
      <fieldset>
      <legend><?php echo get_vocab("private_settings")?></legend>
        <div>
          <label for="event_private_enabled"><?php echo get_vocab("allow_private")?>:</label>
          <?php $checked = ($private_enabled) ? " checked=\"checked\"" : "" ?>
          <input class="checkbox" type="checkbox"<?php echo $checked ?> id="event_private_enabled" name="event_private_enabled">
        </div>
        <div>
          <label for="event_private_mandatory"><?php echo get_vocab("force_private")?>:</label>
          <?php $checked = ($private_mandatory) ? " checked=\"checked\"" : "" ?>
          <input class="checkbox" type="checkbox"<?php echo $checked ?> id="event_private_mandatory" name="event_private_mandatory">
        </div>
        <label>
          <?php echo get_vocab("default_settings")?>:
        </label>
        <div class="group">
          <div>
            <label>
              <?php $checked = ($private_default) ? " checked=\"checked\"" : "" ?>
              <input class="radio" type="radio" name="event_private_default" value="1"<?php echo $checked ?>>
              <?php echo get_vocab("default_private")?>
            </label>
          </div>
          <div>
            <label>
              <?php $checked = ($private_default) ? "" : " checked=\"checked\"" ?>
              <input class="radio" type="radio" name="event_private_default" value="0"<?php echo $checked ?>>
              <?php echo get_vocab("default_public")?>
            </label>
          </div>
        </div>
      </fieldset>
    
      <fieldset>
      <legend><?php echo get_vocab("private_display")?></legend>
        <label>
          <?php echo get_vocab("private_display_label")?>
          <span id="private_display_caution">
            <?php echo get_vocab("private_display_caution")?>
          </span>
        </label>
        <div class="group" id="private_override" >
          <div>
            <label>
              <?php $checked = ($private_override == "none") ? " checked=\"checked\"" : "" ?>
              <input class="radio" type="radio" name="event_private_override" value="none"<?php echo $checked ?>>
              <?php echo get_vocab("treat_respect")?>
            </label>
          </div>
          <div>
            <label>
              <?php $checked = ($private_override == "private") ? " checked=\"checked\"" : "" ?>
              <input class="radio" type="radio" name="event_private_override" value="private"<?php echo $checked ?>>
              <?php echo get_vocab("treat_private")?>
            </label>
          </div>
          <div>
            <label>
              <?php $checked = ($private_override == "public") ? " checked=\"checked\"" : "" ?>
              <input class="radio" type="radio" name="event_private_override" value="public"<?php echo $checked ?>>
              <?php echo get_vocab("treat_public")?>
            </label>
          </div>
        </div>
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