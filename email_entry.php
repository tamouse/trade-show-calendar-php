<?php
/**
 * email_entry - check if the user wants to send an email to guests about appointment and if so, email it
 *
 * @author Tamara Temple
 * @version $Id$
 * @copyright Tamara Temple Development, 17 August, 2010
 * @package default
 **/

/**
 * There are three types of email messages:
 *   1) creation of a new appointment
 *   2) modification of an existing appointment
 *   3) cancelation of an existing appointment
 *
 * Given the nature of type #3, we can't rely on the appointment being in the database when this script is called,
 * so the calling scripts may have to include the necessary information on the query string.
 * 
 * Parameters on query string:
 *   type - type of message to send (see above)
 *   event_id - the event this is for
 *   day_id - the day the appointment occurs on
 *   room_id - the room for the appointment
 *   user_id - the user id of whoever initiated the action (could be creator or admin)
 *   creator_id - the user id of the entry creator (may be different from user_id in the case where the admin changes or deletes and appointment)
 *   entry_id - the actual appointment entry (optional - only for type 1 and 2 transactions)
 *   to_names - the urlencoded list of names of the appointment guests (optional - only for type 3 transactions)
 *   to_emails - the urlencoded list of email address to send email to (optional - only for type 3 transactions)
 *   purpose - the urlencoded string containing the purpose of the appointment (optional - only for type 3 transactions)
 *   start_hour - starting hour of the appointment (optional - only for type 3)
 *   start_minute - starting minute of the appointment (optional - only for type 3)
 *   end_hour - ending hour of the appointment (optional - only for type 3)
 *   end_minute - ending minute of the appointment (optional - only for type 3)
 *   confirmed - a flag set on second pass through denoting if the user has confimed sending the email message
 *
 * as of 8/24/2010 - to_names and to_emails are no longer tied together.
 */
require_once 'defaultincludes.inc';
require_once 'Mail.php';
require_once('class.phpmailer.php');




$type = get_form_var('type', 'int');
$event_id = get_form_var('event_id', 'int');
$day_id = get_form_var('day_id', 'int');
$room_id = get_form_var('room_id', 'int');
$user_id = get_form_var('user_id', 'int');
$creator_id = get_form_var('creator_id', 'int');
$confirmed = get_form_var('confirmed', 'string');

if ($type == 3) 
{
	// Get additional optional fields
	$to_names = urldecode(get_form_var('to_names', 'string'));
	$to_emails = urldecode(get_form_var('to_emails', 'string'));
	$purpose = urldecode(get_form_var('purpose', 'string'));
	$start_hour = get_form_var('start_hour', 'int');
	$start_minute = get_form_var('start_minute', 'int');
	$end_hour = get_form_var('end_hour', 'int');
	$end_minute = get_form_var('end_minute', 'int');
	
}
else
{
	$entry_id = get_form_var('entry_id', 'int');
	$entry = get_record_by_id($tbl_entry, $entry_id);
	$to_names = stripslashes($entry['guests']);
	$to_emails = stripslashes($entry['guest_emails']);
	$purpose = stripslashes($entry['purpose']);
	$start_hour = $entry['start_hour'];
	$start_minute = $entry['start_minute'];
	$end_hour = $entry['end_hour'];
	$end_minute = $entry['end_minute'];
	
}

if (isset($confirmed))
{
	
	// email sending is confirmed
	$user = get_record_by_id($tbl_users, $user_id);
	$creator = get_record_by_id($tbl_users, $creator_id);

	$room = get_record_by_id($tbl_room, $room_id);
	
	$day = get_record_by_id($tbl_day, $day_id);
	// explode the recipient and email strings into arrays
	//$to_list = preg_split('/\s*,\s*/', $to_names);
	$emails_list = preg_split('/\s*,\s*/', $to_emails);
	// Add the creator to the lists of recipients
	//$to_list[] = $user['first_name'] . " " . $user['last_name'];
	$emails_list[] = $user['email'];
	if ($creator_id != $user_id)
	{
		//$to_list[] = $creator['first_name'] . " " . $creator['last_name'];
		$emails_list[] = $creator['email'];
	}

	switch ($type) {
		case 1:
			$SUBJECT = get_vocab('type_1_email_subject');
			$CUSTOMMSG = get_vocab('type_1_custom_msg');
			break;
		case 2:
			$SUBJECT = get_vocab('type_2_email_subject');
			$CUSTOMMSG = get_vocab('type_2_custom_msg');
			break;
		case 3:
			$SUBJECT = get_vocab('type_3_email_subject');
			$CUSTOMMSG = get_vocab('type_3_custom_msg');
			break;
		default:
			$error = 'unknownmailtype';
			$location = "day.php?event_id=$event_id&day_id=$day_id&room_id=$room_id&error=$error";
			redirect($location);
			break;
	}
	$SENDERFIRSTNAME = $user['first_name'];
	$SENDERLASTNAME = $user['last_name'];
	$SENDEREMAIL = $user['email'];
	$SENDERPHONE = $user['phone'];
	$ORGANIZERFIRSTNAME = $creator['first_name'];
	$ORGANIZERLASTNAME = $creator['last_name'];
	$ORGANIZEREMAIL = $creator['email'];
	$ORGANIZERPHONE = $creator['phone'];
	$LOCATION = $room['room_name'];
	$MEETINGDATE = $day['day_string'];
	$STARTTIME = formatTime($start_hour, $start_minute);
	$ENDTIME = formatTime($end_hour, $end_minute);
	$PURPOSE = stripslashes($purpose);
	$GUESTLIST = $to_names;
	
	$mail             = new PHPMailer(); // defaults to using php "mail()"

	
	// To send HTML mail, the Content-type header must be set
	//$headers  = 'MIME-Version: 1.0' . "\r\n";
	//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	//$headers .= "From: $cdma_admin <$cdma_admin_email>\r\n";

	$message = 'norecipients';
	include("confirmation_message.tmpl");
	$mail->Body = $confirmation_message;
	$mail->ContentType = "text/html";
	$textbody = strip_tags($confirmation_message);
	$mail->AltBody = $textbody;
	$mail->Subject = $SUBJECT;
	$mail->From = $cdma_admin_email;
	$mail->FromName = $cdma_admin;
	$mail->Sender = $cdma_admin_email;
	$mail->AddReplyTo($ORGANIZEREMAIL, $ORGANIZERFIRSTNAME . " " . $ORGANIZERLASTNAME);
	$mail->IsSMTP();

	for ($key = 0, $size = count($emails_list); $key < $size; $key++) 
	{
		//$name = trim($to_list[$key]);
		$email = trim($emails_list[$key]);
		
		if (/*!empty($name) && !empty($email) && */ $email != $email_placeholder_string)
		{
			// Set up for phpmailer - create to list
			$mail->AddAddress($email, preg_replace('/@.*$/', '', $email));

		}
	}

	
	if (!$mail->Send())
	{
		$error = 'mailerror';
		$message = "Mailer error: " . $mail->ErrorInfo;
	}
	else
	{
		$message = 'emailsent';
	}
	$location = "day.php?event_id=$event_id&day_id=$day_id&room_id=$room_id&message=" . $message;
	if (isset($error))
	{
		$location .= "&error=" . $error;
	}
	
	redirect($location);
}
else
{
	// Build query to find out if they want to send an email to themselves and guests
	print_header($event_id, $day_id);
	echo "<div id=\"send_email_confirm\">\n";
    echo "<p>" .  get_vocab("sureemail") . "</p>\n";
    echo "<div id=\"send_email_confirm_links\">\n";
	$location =  $PHP_SELF . "?type=$type&day_id=$day_id&event_id=$event_id&room_id=$room_id&user_id=$user_id&creator_id=$creator_id";
	if ($type == 3)
	{
		$location .= "&to_names=" . urlencode($to_names) . "&to_emails=" . urlencode($to_emails) . "&purpose=" . urlencode($purpose) .
			"&start_hour=$start_hour&start_minute=$start_minute&end_hour=$end_hour&end_minute=$end_minute";
	}
	else
	{
		$location .= "&entry_id=$entry_id";
	}
	$location .= "&confirmed=Y";
    echo "<a href=\"" . $location . "\"><span id=\"email_yes\">" . get_vocab("YES") . "!</span></a>\n";
    echo "<a href=\"day.php?event_id=$event_id&day_id=$day_id&room_id=$room_id\"><span id=\"email_no\">" . get_vocab("NO") . "!</span></a>\n";
    echo "</div>\n";
    echo "</div>\n";
    
}


?>