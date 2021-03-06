<?php
// $Id: confirm_entry_handler.php 1288 2009-12-17 18:32:24Z cimorrison $

// Handles actions on provisional bookings

require_once "defaultincludes.inc";
require_once "cdma_sql.inc";
require_once "functions_mail.inc";

// Get form variables
$day = get_form_var('day', 'int');
$month = get_form_var('month', 'int');
$year = get_form_var('year', 'int');
$area = get_form_var('area', 'int');
$action = get_form_var('action', 'string');
$id = get_form_var('id', 'int');
$series = get_form_var('series', 'int');
$returl = get_form_var('returl', 'string');
$room_id = get_form_var('room_id', 'int');
$note = get_form_var('note', 'string');

// If we dont know the right date then make it up 
if (!isset($day) or !isset($month) or !isset($year))
{
  $day   = date("d");
  $month = date("m");
  $year  = date("Y");
}

if (empty($area))
{
  $area = get_default_area();
}

// Check that we're allowed to use this page
// We must be at least a logged in user
if(!getAuthorised(1))
{
	$errormsg = 'norights';
  showAccessDenied($day_id, $event_id, $errormsg);
  exit;
}
$user = getUserName();

                  
if (isset($action))
{
  $need_to_send_mail = ($mail_settings['admin_on_bookings'] or $mail_settings['area_admin_on_bookings'] or
                        $mail_settings['room_admin_on_bookings'] or $mail_settings['booker'] or
                        $mail_settings['book_admin_on_provisional']);
                        
  if ($need_to_send_mail)
  {      
    // Retrieve the booking details which we will need for the email
    // (notifyAdminOnBooking relies on them being available as globals)

    $row = cdmaGetBookingInfo($id, $series);
    
    $name          = $row['name'];
    $description   = $row['description'];
    $create_by     = $row['create_by'];
    $type          = $row['type'];
    $status        = $row['status'];
    $starttime     = $row['start_time'];
    $endtime       = $row['end_time'];
    $room_name     = $row['room_name'];
    $room_id       = $row['room_id'];
    $area_name     = $row['area_name'];
    $duration      = ($row['end_time'] - $row['start_time']) - cross_dst($row['start_time'], $row['end_time']);
    $rep_type      = $row['rep_type'];
    $repeat_id     = isset($row['repeat_id'])     ? $row['repeat_id']     : NULL;
    $rep_enddate   = isset($row['rep_enddate'])   ? $row['rep_enddate']   : NULL;
    $rep_opt       = isset($row['rep_opt'])       ? $row['rep_opt']       : NULL;
    $rep_num_weeks = isset($row['rep_num_weeks']) ? $row['rep_num_weeks'] : NULL;
    
    if ($enable_periods)
    {
      list($start_period, $start_date) =  period_date_string($row['start_time']);
    }
    else
    {
      $start_date = time_date_string($row['start_time']);
    }

    if ($enable_periods)
    {
      list( , $end_date) =  period_date_string($row['end_time'], -1);
    }
    else
    {
      $end_date = time_date_string($row['end_time']);
    }
  
    // The optional last parameters below are set to FALSE because we don't want the units
    // translated - otherwise they will end up getting translated twice, resulting
    // in an undefined index error.
    $enable_periods ? toPeriodString($start_period, $duration, $dur_units, FALSE) : toTimeString($duration, $dur_units, FALSE);

  }
  
  // Now that we know the room, check that we have confirm rights for it if necessary
  if ((($action == "accept") || ($action == "reject")) 
       && !auth_book_admin($user, $room_id))
  {
	$errormsg = 'norights';
    showAccessDenied($day_id, $event_id, $errormsg);
    exit;
  }
  
  // ACTION = "ACCEPT"
  if ($action == "accept")
  {
    if (!cdmaConfirmEntry($id, $series))
    {
      $returl .= "&error=accept_failed";
    }
    elseif ($need_to_send_mail)
    {
      $result = notifyAdminOnBooking(TRUE, $id, $series, $action);
    }
  }
  
  // ACTION = "MORE_INFO"
  if ($action == "more_info")
  {
    // update the last reminded time (the ball is back in the 
    // originator's court, so the clock gets reset)
    cdmaUpdateLastReminded($id, $series);
    if ($need_to_send_mail)
    {
      $result = notifyAdminOnBooking(TRUE, $id, $series, $action);
    }
  }
  
  // ACTION = "REMIND"
  if ($action == "remind")
  {
    // update the last reminded time
    cdmaUpdateLastReminded($id, $series);
    if ($need_to_send_mail)
    {
      $result = notifyAdminOnBooking(TRUE, $id, $series, $action);
    }
  }
  
}

// Now it's all done go back to the previous view
header("Location: $returl");
exit;

?>
