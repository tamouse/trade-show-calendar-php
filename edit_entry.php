<?php
// 

require_once "defaultincludes.inc";

require_once "cdma_sql.inc";


global $twentyfourhour_format;

// Get form variables
$day_id = get_form_var('day_id', 'int');
$event_id = get_form_var('event_id', 'int');
$room_id = get_form_var('room_id', 'int');
$start_hour = get_form_var('start_hour', 'int');
$start_minute = get_form_var('start_minute', 'int');
$id = get_form_var('id', 'int');
$change_entry = get_form_var('change_entry', 'string');
$delete_entry = get_form_var('delete_entry', 'string');
$email_entry = get_form_var('email_entry', 'string');
$goback = get_form_var('goback', 'string');
$new_purpose = get_form_var('new_purpose', 'string');
$old_purpose = get_form_var('old_purpose', 'string');
$creator_id = get_form_var('creator_id', 'int');
$new_comments = get_form_var('new_comments', 'string');

$old_comments = get_form_var('old_comments', 'string');
$new_guests = get_form_var('new_guests', 'string');
$old_guests = get_form_var('old_guests', 'string');
$new_guest_emails = get_form_var('new_guests_emails', 'string');
$old_guest_emails = get_form_var('old_guests_emails', 'string');
$old_confirmed = get_form_var('old_confirmed', 'string');
$new_confirmed = get_form_var('new_confirmed', 'checkbox');

$returl = "day.php?";

// helper function to validate the purpose entry
function validatePurpose($purpose)
{
	// Basically, all we need to see is if purpose is empty or not
	if (empty($purpose))
	{
		return 0;
	}
	return 1;
}

// helper function to determine if this entry is editable
function isEditable($user_id, $creator_id)
{
	// DEBUG START
	//echo "<p>\$user_id=$user_id</p>\n";
	//echo "<p>\$creator_id=$creator_id</p>\n";
	// DEBUG END
	
	if ((!isset($creator_id)) || ($creator_id < 1))
	{
		// entry isn't booked, yet, anyone can edit it
		return 1;
	}
	else if ($user_id == $creator_id)
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

if (empty($event_id))
{
	$location = $returl . "error=noevent";
	redirect($location);
}
if (empty($day_id))
{
	$location = $returl . "event_id=$event_id&error=noday";
	redirect($location);
}
if (empty($room_id))
{
	$location = $returl . "event_id=$event_id&day_id=$day_id&error=noroom";
	redirect($location);
}
if (empty($id))
{
	$location = $returl . "event_id=$event_id&day_id=$day_id&room_id=$room_id&error=noslotid";
	redirect($location);
}

if (!empty($goback))
{
	$location = $returl . "?event_id=$event_id&day_id=$day_id&room_id=$room_id";
	redirect($location);
}

if (!empty($email_entry))
{
	$location = "email_entry.php?type=2&event_id=$event_id&day_id=$day_id&room_id=$room_id&entry_id=$id&confirmed=Y"; // bypass confirmation
	redirect($location);
}

$entry_var_prefix = "en_";
    
if (!getAuthorised(1))
{
  showAccessDenied($day_id, $event_id);
  exit;
}
$user = getUserName();
$user_id = getUserIDByname($user);
$is_admin = (authGetUserLevel($user) >= 2);

// get the creator id from the entry
$creator_id = get_entry_creator_id($id);

if (!isEditable($user_id, $creator_id) && !$is_admin)
{
	// Don't let other users see entry details
	$location = "day.php?event_id=$event_id&room_id=$room_id&day_id=$day_id";
	redirect($location);
}
// Note: if $creator_id = 0, this is a new appointment
if ($creator_id == 0)
{
	$confirmation_type = 1; // confirmation of new appointment
}
else
{
	$confirmation_type = 2; // notification of changes
}

if (!empty($delete_entry))
{
	if (isEditable($user_id, $creator_id) || $is_admin)
	{
		$location="del_entry.php?event_id=$event_id&day_id=$day_id&room_id=$room_id&id=$id&user_id=$user_id&creator_id=$creator_id";
		redirect($location);
	}
}

// This is set on the first time through. When the user submits the form, this will get reset inside phase 2.
// This is used to control what content is displayed on the form if it is subsequently redisplayed (as in the case of validation errors)
$first_pass = TRUE;

$validPurpose = TRUE;
$validEmail = TRUE;

// PHASE 2: UPDATE THE DATABASE

if (!empty($change_entry))
{
	$first_pass = FALSE;
	
	// the form was submitted with perhaps new data on it
	if (!validatePurpose($new_purpose))
	{
		$validPurpose = FALSE;
	}
	else if (!validate_email_list(stripEmailPlaceholders($new_guest_emails)))
	{
		$validEmail = FALSE;
	}
	else if (($old_purpose!= $new_purpose) || ($old_comments != $new_comments) || ($old_confirmed != $new_confirmed)
		|| ($old_guests != $new_guests) || ($old_guest_emails != $new_guest_emails)
		|| ($old_confirmed != $new_confirmed))
	{
		// changes were made on the form, update with the new entries
		// Get the information about the fields in the given table
		$fields = sql_field_info($tbl_entry);
		
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
		  $var = $entry_var_prefix . $field['name'];
		  $$var = get_form_var($var, $type);
		  if (($type == 'int') && ($$var === ''))
		  {
		    unset($$var);
		  }
		}
		
		// Acquire a mutex to lock out others who might be deleting the new event
		if (!sql_mutex_lock("$tbl_entry"))
		{
			fatal_error(TRUE, get_vocab("failed_to_acquire"));
		}
		$sql = "UPDATE $tbl_entry SET ";
		$n_fields = count($fields);
		$assign_array = array();
		
		foreach ($fields as $field)
		{
			if (!in_array($field['name'], array('id', "event_id", "room_id", "day_id", "start_hour",
				"start_minute", "end_hour", "end_minute")))  // don't do anything with these fields
			{				
				switch ($field['name'])
				{
					// if creator_id is 0, they assign this user to the creator role
					case 'user_id':
						if ($creator_id == 0)
						{
							$creator_id = $user_id;
						}
						$assign_array[] = $field['name'] . "=" . $creator_id;
						break;
					// first of all deal with the standard CDMA fields
					case 'purpose':
						$assign_array[] = $field['name'] . "='" . addslashes($new_purpose) . "'";
						break;
					case 'comments':
						$assign_array[] = $field['name'] . "='" . addslashes($new_comments) . "'";
						break;
					case 'confirmed':
						if (!empty($new_confirmed)) {
							$assign_array[] = $field['name'] . "=1";
						} else {
							$assign_array[] = $field['name'] . "=0";
						}
						break;
					case 'guests':
						$assign_array[] = $field["name"] . "='" . addslashes($new_guests) . "'";
						break;
					case 'guest_emails':
						$assign_array[] = $field['name'] . "='" . addslashes($new_guest_emails) . "'";
						break;
						
					case 'confirmed':
						$assign_array[] = $field['name'] . "=" . (isset($new_confirmed) ? 1 : 0);
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
		$sql .= implode(",", $assign_array) . " WHERE id=$id";
		// START
		// echo "<p>\$sql=$sql</p>\n";
		// DEBUG END
		
		if (sql_command($sql) < 0)
		{
			fatal_error(1, get_vocab("update_entry_failed") . sql_error());
		}
		// if everything is OK, release the mutex and go back to
		// the admin page (for the new event)
		sql_mutex_unlock("$tbl_entry");
		$location = "email_entry.php?type=$confirmation_type&event_id=$event_id&day_id=$day_id&room_id=$room_id&entry_id=$id" 
			. "&user_id=$user_id&creator_id=$creator_id";
		redirect($location);
	}
}



// PHASE 1: GET THE USER INPUT

// Get the existing entry for this slot
$sql = "select * from $tbl_entry where id=$id";
$res = sql_query($sql);
if (! $res)
{
	fatal_error(1, sql_error());
}
if (sql_count($res) != 1)
{
	fatal_error(1, get_vocab("entryid") . $id . get_vocab("not_found"));
}

$row = sql_row_keyed($res, 0);
sql_free($res);

print_header($event_id, $day_id);

if (!empty($error))
{
  echo "<p class=\"error\">" . get_vocab($error) . "</p>\n";
}

// only permit certain actions and fields to admins or entry owners
$disabled = (isEditable($user_id, $row['user_id']) || $is_admin) ? "" : " disabled=\"disabled\"";

?>


<form class="form_general" id="edit_entry" action="edit_entry.php" method="post">
<fieldset class="admin">
<legend></legend>

	<fieldset>
	<legend></legend>
	<span class="error">
	<?php 
	// It's impossible to have more than one of these error messages, so no need to worry
	// about paragraphs or line breaks.
	echo ((FALSE == $validEmail) ? get_vocab('invalid_email') : "");
	echo ((FALSE == $validPurpose) ? get_vocab('invalid_purpose') : "");
	?>
	</span>
	</fieldset>

	<fieldset>
	<legend></legend>
	<?php
	if ($id)
	{
	?>
	<input type="hidden" name="id" value="<?php echo $row["id"]?>">

<?php
	}
	
	$event_name = get_event_name_by_id($row['event_id']);
	$room_name = get_room_name_by_id($row['room_id']);
	$entry_date = get_date_record_by_id($row['day_id']);
?>
	<div id="event_name">
	<?php if ($display_events) { ?>
		<label for="event_name"><?php echo get_vocab('event') ?></label>
		<input type="text" name="event_name" value="<?php echo htmlspecialchars($event_name) ?>" id="event_name" disabled="disabled"/>
	<?php } ?>
	<input type="hidden" name="event_id" value="<?php echo $row['event_id'] ?>" id="event_id" />
	</div>

	<div id="room_name">
	<label for="room_name"><?php echo get_vocab('room') ?></label>
	<input type="text" name="room_name" value="<?php echo htmlspecialchars($room_name) ?>" id="room_name" disabled="disabled"/>
	<input type="hidden" name="room_id" value="<?php echo $row['room_id'] ?>" id="room_id" />
	</div>
	
	<?php
		// Get the formatted date string from month, day, year of $entry_date
		$day_string = formatDate($entry_date['day'],$entry_date['month'],$entry_date['year']);
	?>
	<div id="day_string">
	<label for="day_string"><?php echo get_vocab('date') ?></label>
	<input type="text" name="day_string" value="<?php echo htmlspecialchars($day_string) ?>" id="day_string" disabled="disabled"/>
	<input type="hidden" name="day_id" value="<?php echo $row['day_id'] ?>" id="day_id" />
	</div>
	
	<div id="start_time">
	<label for="start_hour"><?php echo get_vocab('starttime') ?></label>
	<?php
		// Get the start time in a string format for display
		$start_time_str = formatTime($row['start_hour'], $row['start_minute']);
	?>
	<input type="text" name="start_time" value="<?php echo htmlspecialchars($start_time_str) ?>" id="start_time" disabled="disabled"/>
	<input type="hidden" name="start_hour" value="<?php echo htmlspecialchars($row["start_hour"]) ?>" id="start_hour"/>
	<input type="hidden" name="start_minute" value="<?php echo htmlspecialchars($row['start_minute']) ?>" id="end_hour"/>
	</div>
	
	<div id="end_time">
	<label for="end_hour"><?php echo get_vocab('endtime') ?></label>
	<?php
		// Get the end time in a string format for display
		$end_time_str = formatTime($row['end_hour'],$row['end_minute']);
	?>
	<input type="text" name="end_time" value="<?php echo htmlspecialchars($end_time_str) ?>" id="end_time" disabled="disabled"/>
	<input type="hidden" name="end_hour" value="<?php echo htmlspecialchars($row['end_hour']) ?>" id="end_hour"/> 
	<input type="hidden" name="end_minute" value="<?php echo htmlspecialchars($row['end_minute']) ?>" id="start_hour"/>
	</div>
	
	<?php
	if ($row['user_id'] < 1)
	{
		// this is an available slot for booking. assign the currently logged in user as the creator
		$creator_id = $user_id;
		$creator_name = $user;
	}
	else
	{
		$creator_id = $row['user_id'];
		$creator_name = get_user_name($creator_id);
		if (is_numeric($creator_name) && ($creator_name < 1))
		{
			fatal_error(0, get_vocab('nosuchuser') . " \$creator_id=$creator_id ");
		}
	}
	
	?>
	<div id="creator">
	<label for="creator"><?php echo get_vocab('creator') ?></label>
	<input type="text" name="creator" value="<?php echo htmlspecialchars($creator_name) ?>" id="creator" disabled="disabled"/>
	<input type="hidden" name="creator_id" value="<?php echo htmlspecialchars($creator_id) ?>"/>
	</div>

	<div id="purpose">
	<label for="new_purpose" class="required"><?php echo get_vocab('purpose') ?></label>
	<input type="text" name="new_purpose" value="<?php echo htmlspecialchars(($first_pass ? $row['purpose'] : $new_purpose)) ?>" id="new_purpose" <?php echo $disabled ?>/>
	<input type="hidden" name="old_purpose" value="<?php echo htmlspecialchars(($first_pass ? $row['purpose'] : $new_purpose)) ?>"/>
	<div id="purpose_help" class="field_help"><?php echo get_vocab('purposerequired') ?></div>
	</div>
		
	
	<div id="comments">
	<label for="new_comments"><?php echo get_vocab('comments') ?></label>
	<textarea name="new_comments" id="new_comments" <?php echo $disabled ?>><?php echo htmlspecialchars(($first_pass ? $row['comments'] : $new_comments)) ?></textarea>
	<input type="hidden" name="old_comments" value="<?php echo htmlspecialchars(($first_pass ? $row['comments'] : $new_comments)) ?>"/>
	</div>
	
	<div id="guests">
	<label for="new_guests"><?php echo get_vocab('guests') ?></label>
	<textarea name="new_guests" id="new_guests" <?php echo $disabled ?>><?php echo htmlspecialchars(($first_pass ? $row['guests'] : $new_guests)) ?></textarea>
	<input type="hidden" name="old_guests" value="<?php echo htmlspecialchars(($first_pass ? $row['guests'] : $new_guests)) ?>"/>
	<div id="guests_help" class="field_help"><?php echo get_vocab('guestshelp'); ?></div>
	</div>
		

	<div id="guest_emails">
	<label for="new_guest_emails"><?php echo get_vocab('guestsemails') ?></label>
	<textarea  name="new_guests_emails" id="new_guest_emails" <?php echo $disabled ?>><?php echo htmlspecialchars(($first_pass ? $row['guest_emails'] : $new_guest_emails)) ?></textarea>
	<input type="hidden" name="old_guest_emails" value="<?php echo htmlspecialchars(($first_pass ? $row['guest_emails'] : $new_guest_emails)) ?>"/>
	<div id="emails_help" class="field_help"><?php echo get_vocab('guestemailhelp') ?></div>
	</div>
		
	
	<div id="confirmed">
	<label for="new_confirmed"><?php echo get_vocab('confirmed') ?>?</label>
	<input type="checkbox" class="checkbox" name="new_confirmed" id="new_confirmed" value="<?php echo ($first_pass ? (($row['confirmed']==1) ? "checked" : "") : $new_confirmed) ?>" <?php echo ($first_pass ? (($row['confirmed']==1) ? "checked" : "") : $new_confirmed) ?>/>
	<input type="hidden" name="old_confirmed" value="<?php echo ($first_pass ? ($row['confirmed']==1 ? "checked" : '') : $new_confirmed) ?>"/>
	</div>

	</fieldset>
	<?php
	// Submit and Delete buttons (Submit only if they're allowed)  
	echo "<fieldset class=\"submit_buttons\">\n";
	echo "<legend></legend>\n";
	echo "<div class=\"submit_buttons\">\n";
	if ($is_admin || isEditable($user_id, $row['user_id']))
	{
		echo "<input class=\"submit\" type=\"submit\" name=\"change_entry\" value=\"" . get_vocab("change") . "\"/>\n";
		if ($id)
		{
			echo "<input class=\"submit\" type=\"submit\" name=\"delete_entry\" value=\"" . get_vocab("deleteentry") . "\"/>\n";
		}
		echo "<input class=\"submit\" type=\"submit\" name=\"email_entry\" value=\"" . get_vocab("emailthis") . "\"/>\n";
	}
	echo "<input class=\"submit\" type=\"submit\" name=\"goback\" value=\"" . get_vocab("goback") . "\"/>\n";
	echo "</fieldset>\n";

	?>
</form>

<?php
include_once "trailer.inc";
?>