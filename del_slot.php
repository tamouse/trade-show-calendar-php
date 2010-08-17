<?php

// delete an available slot

require_once "defaultincludes.inc";

// Get passed variables
$event_id = get_form_var('event_id', 'int');
$day_id = get_form_var('day_id', 'int');
$room_id = get_form_var('room_id', 'int');
$id = get_form_var('id', 'int');

$is_admin = getAdmin();

$returnURL = "day.php?mode=1&event_id=$event_id&day_id=$day_id&room_id=$room_id";

if (!$is_admin)
{
	$location = $returnURL . "&error=norights";
	redirect($location);
}

if (!isset($id))
{
	$location = $returnURL . "&error=noslotid";
	redirect($location);
}

// Acquire a mutex to lock out others who might be deleting the new event
if (!sql_mutex_lock("$tbl_entry"))
{
	fatal_error(TRUE, get_vocab("failed_to_acquire"));
}
$sql = "DELETE FROM $tbl_entry WHERE id=$id";
$res = sql_command($sql);
if ($res < 0)
{
	$location = $returnURL . "&error=slotdeletefailed";
	redirect($location);
}
// if everything is OK, release the mutex and go back to
// the admin page (for the new event)
sql_mutex_unlock("$tbl_entry");


redirect($returnURL);


?>