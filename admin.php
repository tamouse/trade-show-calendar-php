<?php


require_once "defaultincludes.inc";

// Get form variables
$day_id = get_form_var('day_id', 'int');
$room_id = get_form_var('room_id', 'int');
$event_id = get_form_var('event_id', 'string');
$error = get_form_var('error', 'string');
// the image buttons:  need to specify edit_x rather than edit etc. because
// IE6 only returns _x and _y
$edit_x = get_form_var('edit_x', 'int');
$delete_x = get_form_var('delete_x', 'int');

if (empty($event_id))
{
	$event_id = get_first_event();
}
if (empty($day_id))
{
	$day_id = get_first_day_for_event($event_id);
}


// Check to see whether the Edit or Delete buttons on the event have been pressed and redirect
// as appropriate
$std_query_string = "event_id=$event_id";
if (isset($edit_x))
{
  $location = "edit_event_day_room.php?$std_query_string";
  redirect($location);
}
if (isset($delete_x))
{
  $location = "del.php?type=event&$std_query_string";
  redirect($location);
}
  
// Users must be at least Level 1 for this page as we will be displaying
// information such as email addresses
if (!getAuthorised(1))
{
  showAccessDenied($day_id, $event_id);
  exit();
}

$event_name = get_event_name_by_id($event_id);

$is_admin = getAdmin();

print_header($event_id, $day_id);

echo "<h2>" . get_vocab("administration") . "</h2>\n";
if (!empty($error))
{
  echo "<p class=\"error\" id=\"$error\">" . get_vocab($error) . "</p>\n";
}

echo "<div class=\"left_side\">\n";

// Button to go to slot management.
// Use the day.php function, but set mode to 1 to manage slots instead of appointments
?>
<div class="gotoSlots">
<form id="gotoSlots" method="get" action="day.php">
<input type="hidden" name="event_id" value="<?php echo $event_id ?>" id="event_id"/>
<input type="hidden" name="mode" value="1" id="mode"/>
<div class="submit_buttons">
<input type="submit" name="gotoSlots" value="<?php echo get_vocab('gotoSlots') ?>" id="gotoSlots"/>
</div>
</form>
</div>

<?php
// TOP SECTION:  THE FORM FOR SELECTING AN EVENT

// Check to see if there is at least one event.
// NOTE: This system will be used in settings of a single event. Therefore, only define one event in the database.
// Per conversation with Christopher Spencer, 8/15/2010 with Tamara Temple <tamara@tamaratemple.com>
$events_defined = (eventCount() > 0 ? TRUE : FALSE);
if (!$events_defined)
{
	if ($is_admin)
	{
		// New event form
		?>
			<div id="new_event_form">
			<form id="add_event" class="form_admin" action="add.php" method="post">
			<fieldset>
			<legend><?php echo get_vocab("addevent") ?></legend>

			<input type="hidden" name="type" value="event">

			<div>
			<label for="event_name" class="required"><?php echo get_vocab("name") ?>:</label>
			<input type="text" id="event_name" name="name" maxlength="<?php echo $maxlength['event.event_name'] ?>">
			</div>

			<div class="submit_buttons">
			<input type="submit" class="submit" value="<?php echo get_vocab("addevent") ?>">
			</div>

			</fieldset>
			</form>
			</div>
			<?php
	}
}


// MIDDLE SECTION: DAYS IN THE SELECTED EVENT

echo "<h2>";
echo get_vocab("capdays");
if (isset($event_name)) {
	echo " " . get_vocab("in") . " " . htmlspecialchars($event_name);
}
echo "</h2>\n";

echo "<div id=\"day_form\">\n";
if (isset($event_id)) {
	$sql = "SELECT * FROM $tbl_day WHERE event_id=$event_id ORDER BY day_string";

	$res = sql_query($sql);
	if (! $res) {
		fatal_error(0, sql_error());
	}
	if (sql_count($res) == 0){
		echo "<p>" . get_vocab("nodays") . "</p>\n";
	}
	else {
		$fields = sql_field_info($tbl_day);
		$days = array();
		for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++) {
			$days[] = $row;
		}
		// Display days
		echo "<div class=\"day_info\"  class=\"freeze_panes\">\n";
	    // (a) the "header" columns containing the day names
	    echo "<div class=\"header_columns\">\n";
	    echo "<table class=\"admin_table\">\n";
	    echo "<thead>\n";
	    echo "<tr>\n";
	    if ($is_admin)
	    {
	      echo "<th><div>&nbsp;</div></th>\n";
	      echo "<th><div>&nbsp;</div></th>\n";
	    }
	    echo "<th><div>" . get_vocab("day_string") . "</div></th>\n";
	    echo "</tr>\n";
	    echo "</thead>\n";


		// Body of table showing defined days in event
	    echo "<tbody>\n";
	    $row_class = "odd_row";
	    foreach ($days as $r)
	    {
	      $row_class = ($row_class == "even_row") ? "odd_row" : "even_row";
	      echo "<tr class=\"$row_class\">\n";
	      // Give admins delete and edit links
	      if ($is_admin)
	      {
	        // Delete link
	        echo "<td><div>\n";
	        echo "<a href=\"del.php?type=day&amp;day_id=" . $r['id'] . "\">\n";
	        echo "<img src=\"images/delete.png\" width=\"16\" height=\"16\" 
	                   alt=\"" . get_vocab("delete") . "\"
	                   title=\"" . get_vocab("delete") . "\">\n";
	        echo "</a>\n";
	        echo "</div></td>\n";
	        // Edit link
	        echo "<td><div>\n";
	        echo "<a href=\"edit_event_day_room.php?day_id=" . $r['id'] . "\">\n";
	        echo "<img src=\"images/edit.png\" width=\"16\" height=\"16\" 
	                   alt=\"" . get_vocab("edit") . "\"
	                   title=\"" . get_vocab("edit") . "\">\n";
	        echo "</a>\n";
	        echo "</div></td>\n";
	      }
	      echo "<td><div><a href=\"edit_event_day_room.php?day_id=" . $r['id'] . "\">" . htmlspecialchars($r['day_string']) . "</a></div></td>\n";
	      echo "</tr>\n";
	    }
	    echo "</tbody>\n";
	    echo "</table>\n";
	    echo "</div>\n";


	}
}
else
{
	echo "<p>" . get_vocab("noevent") . "</p>\n";
}

// Give admins a form for adding days to the event - provided 
// there's an event selected
if ($is_admin && $events_defined && !empty($event_id))
{
	?>
		<form id="add_day" class="form_admin" action="add.php" method="post">
		<fieldset>
		<legend><?php echo get_vocab("addday") ?></legend>

		<input type="hidden" name="type" value="day">
		<input type="hidden" name="event_id" value="<?php echo $event_id; ?>">

	<script type="text/javascript">
		$(function() {
			$("#day_string").datepicker({dateFormat: 'mm/dd/yy'});
			$( "#day_string" ).datepicker({ gotoCurrent: true });
			$("#day_string").datepicker();
		});
		</script>
		<div>
		<label for="day_string" class="required"><?php echo get_vocab("day_string") ?>:</label>
		<input type="text" id="day_string" name="day_string">
		</div>

		<div class="submit_buttons">
		<input type="submit" class="submit" value="<?php echo get_vocab("addday") ?>">
		</div>

		</fieldset>
		</form>
		<?php
}
echo "</div>\n"; // end of day form
echo "</div>\n"; // end of left side


echo "<div class=\"right_side\">\n";

// BOTTOM SECTION: ROOMS IN THE SELECTED EVENT
echo "<h2>\n";
echo get_vocab("rooms");
if(isset($event_name))
{ 
  echo " " . get_vocab("in") . " " . htmlspecialchars($event_name); 
}
echo "</h2>\n";

echo "<div id=\"room_form\">\n";
if (isset($event_id))
{
  $res = sql_query("SELECT * FROM $tbl_room WHERE event_id=$event_id ORDER BY room_number");
  if (! $res)
  {
    fatal_error(0, sql_error());
  }
  if (sql_count($res) == 0)
  {
    echo "<p>" . get_vocab("norooms") . "</p>\n";
  }
  else
  {
     // Get the information about the fields in the room table
    $fields = sql_field_info($tbl_room);
    
    // Build an array with the room info
    $rooms = array();
    for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
    {
      $rooms[] = $row;
    }

    // Display it in a table [Actually two tables side by side so that we can
    // achieve a "Freeze Panes" effect: there doesn't seem to be a good way of
    // getting a colgroup to scroll, so we have to distort the mark-up a little]
    
    echo "<div id=\"room_info\" class=\"freeze_panes\">\n";
    // (a) the "header" columns containing the room names
    echo "<div class=\"header_columns\">\n";
    echo "<table class=\"admin_table\">\n";
    echo "<thead>\n";
    echo "<tr>\n";
    if ($is_admin)
    {
      echo "<th><div>&nbsp;</div></th>\n";
      echo "<th><div>&nbsp;</div></th>\n";
    }
    echo "<th><div>" . get_vocab("name") . "</div></th>\n";
    echo "</tr>\n";
    echo "</thead>\n";
    echo "<tbody>\n";
    $row_class = "odd_row";
    foreach ($rooms as $r)
    {
      $row_class = ($row_class == "even_row") ? "odd_row" : "even_row";
      echo "<tr class=\"$row_class\">\n";
      // Give admins delete and edit links
      if ($is_admin)
      {
        // Delete link
        echo "<td><div>\n";
        echo "<a href=\"del.php?type=room&amp;room_id=" . $r['id'] . "\">\n";
        echo "<img src=\"images/delete.png\" width=\"16\" height=\"16\" 
                   alt=\"" . get_vocab("delete") . "\"
                   title=\"" . get_vocab("delete") . "\">\n";
        echo "</a>\n";
        echo "</div></td>\n";
        // Edit link
        echo "<td><div>\n";
        echo "<a href=\"edit_event_day_room.php?room_id=" . $r['id'] . "\">\n";
        echo "<img src=\"images/edit.png\" width=\"16\" height=\"16\" 
                   alt=\"" . get_vocab("edit") . "\"
                   title=\"" . get_vocab("edit") . "\">\n";
        echo "</a>\n";
        echo "</div></td>\n";
      }
      echo "<td><div><a href=\"edit_event_day_room.php?room_id=" . $r['id'] . "\">" . htmlspecialchars($r['room_name']) . "</a></div></td>\n";
      echo "</tr>\n";
    }
    echo "</tbody>\n";
    echo "</table>\n";
    echo "</div>\n";
    
    // (b) the "body" columns containing the room info
    echo "<div class=\"body_columns\">\n";
    echo "<table class=\"admin_table\">\n";
    echo "<thead>\n";
    echo "<tr>\n";
    // ignore these columns, either because we don't want to display them,
    // or because we have already displayed them in the header column
    $ignore = array('id', 'event_id', 'room_name');
    foreach($fields as $field)
    {
      if (!in_array($field['name'], $ignore))
      {
        switch ($field['name'])
        {
          // the standard CDMA fields
          case 'room_description':
           $text = get_vocab($field['name']);
            break;
          // any user defined fields
          default:
            $text = get_loc_field_name($tbl_room, $field['name']);
            break;
        }
        echo "<th><div>" . htmlspecialchars($text) . "</div></th>\n";
      }
    }
    echo "</tr>\n";
    echo "</thead>\n";
    echo "<tbody>\n";
    $row_class = "odd_row";
    foreach ($rooms as $r)
    {
      $row_class = ($row_class == "even_row") ? "odd_row" : "even_row";
      echo "<tr class=\"$row_class\">\n";
      foreach($fields as $field)
      {
        if (!in_array($field['name'], $ignore))
        {
          switch ($field['name'])
          {
           // any user defined fields
            default:
              if (($field['nature'] == 'boolean') || 
                  (($field['nature'] == 'integer') && isset($field['length']) && ($field['length'] <= 2)) )
              {
                // booleans: represent by a checkmark
                echo "<td class=\"int\"><div>";
                echo (!empty($r[$field['name']])) ? "<img src=\"images/check.png\" alt=\"check mark\" width=\"16\" height=\"16\">" : "&nbsp;";
                echo "</div></td>\n";
              }
              elseif (($field['nature'] == 'integer') && isset($field['length']) && ($field['length'] > 2))
              {
                // integer values
                echo "<td class=\"int\"><div>" . $r[$field['name']] . "</div></td>\n";
              }
              else
              {
                // strings
                $text = htmlspecialchars($r[$field['name']]);
                echo "<td title=\"$text\"><div>";
                echo substr($text, 0, $max_content_length);
                echo (strlen($text) > $max_content_length) ? " ..." : "";
                echo "</div></td>\n";
              }
              break;
          }
        }
      }
      echo "</tr>\n";
    }
    echo "</tbody>\n";
    echo "</table>\n";
    echo "</div>\n";
    echo "</div>\n";
  }
}
else
{
  echo "<p>" . get_vocab("noevent") . "</p>";
}

// Give admins a form for adding rooms to the event - provided 
// there's an event selected
if ($is_admin && $events_defined && !empty($event_id))
{
?>
  <form id="add_room" class="form_admin" action="add.php" method="post">
    <fieldset>
    <legend><?php echo get_vocab("addroom") ?></legend>
        
      <input type="hidden" name="type" value="room">
      <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
        
      <div>
          <label for="room_number" class="required"><?php echo get_vocab("room_number") ?>:</label>
          <input type="text" id="room_number" name="room_number">
      </div>
   
      <div>
        <label for="room_name" class="required"><?php echo get_vocab("name") ?>:</label>
        <input type="text" id="room_name" name="name" maxlength="<?php echo $maxlength['room.room_name'] ?>">
      </div>
                
      <div class="submit_buttons">
        <input type="submit" class="submit" value="<?php echo get_vocab("addroom") ?>">
      </div>
        
    </fieldset>
  </form>
<?php
}
echo "</div>\n"; // end of room form
echo "</div>\n"; // end of right side

echo "<div class=\"simple_trailer\" style=\"clear: both;\">\n";
echo "<a href=\"index.php?event_id=$event_id&day_id=$day_id\">" . get_vocab('backmain') . "</a>\n";
echo "</div>\n";

require_once "trailer.inc"
?>