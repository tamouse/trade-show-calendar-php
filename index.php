<?php


// $Id: index.php 1278 2009-12-09 13:16:58Z cimorrison $

// Index is just a stub to redirect to the appropriate view
// as defined in config.inc.php using the variable $default_view
// If $default_room is defined in config.inc.php then this will
// be used to redirect to a particular room.

require_once "defaultincludes.inc";
require_once "cdma_sql.inc";

// Check for initial conditions
if (get_num_records($tbl_users) == 0)
{
	// no users, must create first one
	redirect("edit_users.php");
}

if (get_num_records($tbl_event) == 0)
{
	// no events, must create at least one
	redirect("admin.php");
}

$event_id = get_first_event();

$redirect_str = "day.php?event_id=$event_id";
redirect($redirect_str);



?>
