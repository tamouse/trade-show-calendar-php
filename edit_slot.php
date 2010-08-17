<?php
// edit_slot.php -- add or edit a slot for the given event, day, room and time
// Tamara Temple <tamara@tamaratemple.com

// DEBUG START
//echo "<p>Get and Post variables</p>\n";
//echo "<pre>\n";
//print_r($_GET);
//print_r($_POST);
//echo "</pre>\n";
// DEBUG END

require_once "defaultincludes.inc";

// Get form variables
$day_id = get_form_var('day_id', 'int');
$event_id = get_form_var('event_id', 'int');
$room_id = get_form_var('room_id', 'int');
$start_hour = get_form_var('start_hour', 'int');
$start_minute = get_form_var('start_minute', 'int');
$new_start_time = get_form_var('new_start_time', 'string');
$old_start_time = get_form_var('old_start_time', 'string');
$new_end_time = get_form_var('new_end_time','string');
$old_end_time = get_form_var('old_end_time','string');
$id = get_form_var('id', 'int');
$change_slot = get_form_var('change_slot', 'string');
$delete_slot = get_form_var('delete_slot', 'string');
$goback = get_form_var('goback', 'string');

$returl = "day.php?mode=1";

if (empty($event_id))
{
	$location = $returl . "&error=noevent";
	redirect($location);
}
if (empty($day_id))
{
	$location = $returl . "&event_id=$event_id&error=noday";
	redirect($location);
}
if (empty($room_id))
{
	$location = $returl . "&event_id=$event_id&day_id=$day_id&error=noroom";
	redirect($location);
}
if (!empty($goback))
{
	$location = $returl . "&event_id=$event_id&day_id=$day_id&room_id=$room_id";
	redirect($location);
}

if (!isset($id) || empty($id) || (is_numeric($id) && ($id < 0)))
{
	$id = 0;	// treat this as a new slot
}

// check to see if user is authorized to create/edit slots -- must be admin
if (!getAuthorised(2))
{
  showAccessDenied($day_id, $event_id);
  exit;
}
$user = getUserName();
$user_id = getUserIDByname($user);

if (!empty($delete_slot))
{
	$location="del_slot.php?event_id=$event_id&day_id=$day_id&room_id=$room_id&id=$id";
	redirect($location);
}

// This is set on the first time through. When the user submits the form, this will get reset inside phase 2.
// This is used to control what content is displayed on the form if it is subsequently redisplayed (as in the case of validation errors)
$first_pass = TRUE;

$validstarttime = TRUE;
$validendtime= TRUE;

// PHASE 2: UPDATE THE DATABASE

if (!empty($change_slot))
{
	
	$first_pass = FALSE;
	// note: convertTimeToArray will handle empty and improper time formats
	list ($new_start_hour, $new_start_minute) = convertTimeToArray($new_start_time);
	list ($new_end_hour, $new_end_minute) = convertTimeToArray($new_end_time);
	// START
	//echo "<p>\$new_start_hour=$new_start_hour</p>\n";
	//echo "<p>\$new_start_minute=$new_start_minute</p>\n";
	//echo "<p>\$new_end_hour=$new_end_hour</p>\n";
	//echo "<p>\$new_end_minute=$new_end_minute</p>\n";
	// DEBUG END
	
	// the form was submitted with perhaps new data on it
	if (!validateHour($new_start_hour) || !validateMinute($new_start_minute))
	{
		$validstarttime = FALSE;
	}
	else if (!validateHour($new_end_hour) || !validateMinute($new_end_minute))
	{
		$validendtime = FALSE;
	}
	else if (($old_start_hour != $new_start_hour) || ($old_start_minute != $new_start_minute) || 
		($old_end_minute != $new_end_minute) || ($old_end_hour != $new_end_hour))
	{
		// DEBUG START
		//echo "<p>making changes</p>\n";
		// DEBUG END
		
		// changes were made on the form, update with the new entries
		// Get the information about the fields in the given table
		$fields = sql_field_info($tbl_entry);
				
		// Acquire a mutex to lock out others who might be deleting the new event
		if (!sql_mutex_lock("$tbl_entry"))
		{
			fatal_error(TRUE, get_vocab("failed_to_acquire"));
		}
		$sql_command = ($id ? "UPDATE" : "INSERT INTO");
		$sql = "$sql_command $tbl_entry SET ";
		$n_fields = count($fields);
		$assign_array = array();
		
		foreach ($fields as $field)
		{
			if (!in_array($field['name'], array('id', "user_id",
				"purpose", "comments", "guests", "guest_emails")))  // don't do anything with these fields
			{				
				switch ($field['name'])
				{
					case 'event_id':
						$assign_array[] = "event_id=$event_id";
						break;
					case 'room_id':
						$assign_array[] = "room_id=$room_id";
						break;
					case 'day_id':
						$assign_array[] = "day_id=$day_id";
						break;
					case 'start_hour':
						$assign_array[] = "start_hour=$new_start_hour";
						break;
					case 'start_minute':
						$assign_array[] = "start_minute=$new_start_minute";
						break;
					case 'end_hour':
						$assign_array[] = "end_hour=$new_end_hour";
						break;
					case 'end_minute':
						$assign_array[] = "end_minute=$new_end_minute";
						break;
					
						
					default:
						// do nothing with extra fields
						break;
				}
			}
			
		}
		$sql .= implode(",", $assign_array);
		if ($id) 
		{
			$sql .= " WHERE id=$id";
		}
		// DEBUG START
		//echo "<p>\$sql=$sql</p>\n";
		// DEBUG END
		
		if (sql_command($sql) < 0)
		{
			fatal_error(1, get_vocab("update_slot_failed") . sql_error());
		}
		// if everything is OK, release the mutex and go back to
		// the admin page (for the new event)
		sql_mutex_unlock("$tbl_entry");
		$location = $returl . "&event_id=$event_id&day_id=$day_id&room_id=$room_id";
		redirect($location);
	}
}



// PHASE 1: GET THE USER INPUT

if ($id)
{
	// Get the existing slot for this slot
	$sql = "select * from $tbl_entry where id=$id";
	$res = sql_query($sql);
	if (! $res)
	{
		fatal_error(1, sql_error());
	}
	if (sql_count($res) != 1)
	{
		fatal_error(1, get_vocab("slotid") . $id . get_vocab("not_found"));
	}

	$row = sql_row_keyed($res, 0);
	sql_free($res);
}
print_header($event_id, $day_id);

if (!empty($error))
{
  echo "<p class=\"error\">" . get_vocab($error) . "</p>\n";
}

?>
<script type="text/javascript">
$(document).ready(function(){
	$("#new_start_time").timepicker({
	    
		'hourAM'          		: [7,8,9,10,11],// AM hours
		'hourPM'          		: [12,1,2,3,4,5,6],// PM hours
		'minDivision'           : [0], // only allows to pick on the hour
		'hourFormat'	  		: 12,// 12 or 24
		'hourCols'		  		: 8,// 6 or 8 columns
		'closeOnComplete'	    : true
	});
	$("#new_end_time").timepicker({
    
		'hourAM'          		: [7,8,9,10,11],// AM hours
		'hourPM'          		: [12,1,2,3,4,5,6],// PM hours
		'minDivision'           : 5, // 5 minute divisions
		'hourFormat'	  		: 12,// 12 or 24
		'hourCols'		  		: 8,// 6 or 8 columns
		'closeOnComplete'	    : true
	});
 	$(function() {
		$("input:submit", ".submit_buttons").button();
		
	});
		
});
</script>
<form class="form_general" id="edit_slot" action="edit_slot.php" method="post">
<fieldset class="admin">
<legend></legend>

	<fieldset>
	<legend></legend>
	<p class="error">
	<?php 
	// It's impossible to have more than one of these error messages, so no need to worry
	// about paragraphs or line breaks.
	echo ((FALSE == $validstarttime) ? get_vocab('invalid_starttime') : "");
	echo ((FALSE == $validendtime) ? get_vocab('invalid_endtime') : "");
	?>
	</p>
	</fieldset>

	<fieldset>
	<legend></legend>
	<input type="hidden" name="id" value="<?php echo ($id ? $row["id"] : 0) ?>">

<?php
	if ($id)
	{	
		$event_name = get_event_name_by_id($row['event_id']);
		$room_name = get_room_name_by_id($row['room_id']);
		$slot_date = get_date_record_by_id($row['day_id']);
	}
	else
	{
		$event_name = get_event_name_by_id($event_id);
		$room_name = get_room_name_by_id($room_id);
		$slot_date = get_date_record_by_id($day_id);
	}
?>

	<div id="event_name">
	<?php
	if ($display_events) 
	{
	?>
		<label for="event_name"><?php echo get_vocab('event') ?></label>
		<input type="text" name="event_name" value="<?php echo htmlspecialchars($event_name) ?>" id="event_name" disabled="disabled"/>
	<?php
	} 
	 ?>
	<input type="hidden" name="event_id" value="<?php echo ($id ? $row['event_id'] : $event_id) ?>" id="event_id" />
	</div>

	<div id="room_name">
	<label for="room_name"><?php echo get_vocab('room') ?></label>
	<input type="text" name="room_name" value="<?php echo htmlspecialchars($room_name) ?>" id="room_name" disabled="disabled"/>
	<input type="hidden" name="room_id" value="<?php echo ($id ? $row['room_id'] : $room_id) ?>" id="room_id" />
	</div>
	
	<?php
		// Get the formatted date string from month, day, year of $slot_date
		$day_string = formatDate($slot_date['day'],$slot_date['month'],$slot_date['year']);
	?>
	<div id="day_string">
	<label for="day_string"><?php echo get_vocab('date') ?></label>
	<input type="text" name="day_string" value="<?php echo htmlspecialchars($day_string) ?>" id="day_string" disabled="disabled"/>
	<input type="hidden" name="day_id" value="<?php echo ($id ? $row['day_id'] : $day_id) ?>" id="day_id" />
	</div>
	
	<div id="start_time">
	<label for="start_hour"><?php echo get_vocab('starttime') ?></label>
	<?php
	if ($id)
	{
		// Get the start time in a string format for display
		$old_start_hour = ($first_pass ? $row['start_hour'] : $new_start_hour);
		$old_start_minute = ($first_pass ? $row['start_minute'] : $new_start_minute);
	}
	else
	{
		$old_start_hour = ($first_pass ? $start_hour : $new_start_hour);
		$old_start_minute = ($first_pass ? $start_minute : $new_start_minute);
	}
	$start_time_str = formatTime($old_start_hour, $old_start_minute);
	
	?>

	<input type="text" id="new_start_time" name="new_start_time" value="<?php echo htmlspecialchars($start_time_str) ?>" id="start_time"/>
	<input type="hidden" name="old_start_hour" value="<?php echo htmlspecialchars($old_start_hour) ?>" id="start_hour"/>
	<input type="hidden" name="old_start_minute" value="<?php echo htmlspecialchars($old_start_minute) ?>" id="end_hour"/>
	</div>
	
	<div id="end_time">
	<label for="end_hour"><?php echo get_vocab('endtime') ?></label>
	<?php
		// Get the end time in a string format for display
		$old_end_hour = ($first_pass ? ($id ? $row['end_hour'] : $start_hour) : $new_end_hour);
		$old_end_minute = ($first_pass ? ($id ? $row['end_minute'] : $start_minute + 50) : $new_end_minute);
		$end_time_str = formatTime($old_end_hour,$old_end_minute);
	?>
	<input type="text" id="new_end_time" name="new_end_time" value="<?php echo htmlspecialchars($end_time_str) ?>" id="end_time"/>
	<input type="hidden" name="old_end_hour" value="<?php echo htmlspecialchars($old_end_hour) ?>" id="end_hour"/> 
	<input type="hidden" name="old_end_minute" value="<?php echo htmlspecialchars($old_end_minute) ?>" id="start_hour"/>
	</div>
	

	</fieldset>
	<?php
	// Submit and Delete buttons (Submit only if they're allowed)  
	echo "<fieldset class=\"submit_buttons\">\n";
	echo "<legend></legend>\n";
	echo "<div id=\"submit_buttons\">\n";
	echo "<input class=\"submit\" type=\"submit\" name=\"change_slot\" value=\"";
	if ($id)
	{
		 echo get_vocab("change");
	}
	else
	{
		echo get_vocab("addslot");
	}
	echo "\">\n";
	if ($id)
	{
		echo "<input class=\"submit\" type=\"submit\" name=\"delete_slot\" value=\"" . get_vocab("deleteslot") . "\">\n";
	}
	echo "<input class=\"submit\" type=\"submit\" name=\"goback\" value=\"" . get_vocab("goback") . "\">\n";
	echo "</div>\n";
	echo "</fieldset>\n";

	?>
</form>

<?php
include_once "trailer.inc";
?>