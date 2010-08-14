<?php

// delete an available slot

require_once "defaultincludes.inc";

// Get passed variables
$event_id = get_form_var('event_id', 'int');
$day_id = get_form_var('day_id', 'int');
$room_id = get_form_var('room_id', 'int');
$start_hour = get_form_var('start_hour','int');
$start_minute = get_form_var('start_minute', 'int');
$id = get_form_var('id', 'int');

$is_admin = getAdmin();

$returnURL = "day.php?event_id=$event_id&day_id=$day_id&room_id=$room_id";

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

$sql = "DELETE FROM $tbl_entry WHERE id=$id";
$res = sql_command($sql);
if ($res < 0)
{
	$location = $returnURL . "&error=slotdeletefailed";
	redirect($location);
}

redirect($returnURL);


?>