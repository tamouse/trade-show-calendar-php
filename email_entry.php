<?php
/**
 * email_entry - check if the user wants to send an email to guests about appointment and if so, email it
 *
 * @author Tamara Temple
 * @version $Id$
 * @copyright Tamara Temple Development, 17 August, 2010
 * @package default
 **/

require_once 'defaultincludes.inc';
require_once 'Mail.php';

$event_id = get_form_var('event_id', 'int');
$day_id = get_form_var('day_id', 'int');
$room_id = get_form_var('room_id', 'int');
$entry_id = get_form_var('entry_id', 'int');
$confirmed = get_form_var('confirmed', 'string');

if (isset($confirmed))
{
	
	// email sending is confirmed
	// ... todo
	$entry = get_record_by_id($tbl_entry, $entry_id);
	$user = get_record_by_id($tbl_users, $entry['user_id']);
	$room = get_record_by_id($tbl_room, $entry['room_id']);
	$day = get_record_by_id($tbl_day, $entry['day_id']);
	$guests = preg_split('/\s*,\s*/', stripslashes($entry['guests']));
	$guest_emails = preg_split('/\s*,\s*/', stripslashes($entry['guest_emails']));
	// DEBUG START
	// echo "<p>split guests and guest_emails</p>\n";
	// echo "<pre>\n";
	// print_r($guests);
	// print_r($guest_emails);
	// echo "</pre>\n";
	// DEBUG END

	// subject
	$SUBJECT = get_vocab('entry_email_subject');
	$ORGANIZERNAME = $user['name'];
	$ORGANIZEREMAIL = $user['email'];
	$ORGANIZERPHONE = $user['phone'];
	$LOCATION = $room['room_name'];
	$STARTTIME = formatTime($entry['start_hour'], $entry['start_minute']);
	$ENDTIME = formatTime($entry['end_hour'], $entry['end_minute']);
	$PURPOSE = stripslashes($entry['purpose']);

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	$headers .= "From: $cdma_admin <no-reply@cdmacalendar.com>" . "\r\n";
	$headers .= "Reply-to: $user[name] <$user[email]>" . "\r\n";

	$message = 'norecipients';
	for ($key = 0, $size = count($guests); $key < $size; $key++) 
	{
		$name = trim($guests[$key]);
		$email = trim($guest_emails[$key]);
		// DEBUG START
		// echo "<p>name=$name</p>\n";
		// echo "<p>email=$email</p>\n";
		// echo "<p>email_placeholder_string=$email_placeholder_string</p>\n";
		// DEBUG END
		
		if (!empty($name) && !empty($email) && $email != $email_placeholder_string)
		{
			$to = $name . " <" . $email . ">";
			$RECIPIENT = $name;
			include("confirmation_message.tmpl");
			// DEBUG START
			// echo "<p>confirmation_message=" .htmlspecialchars($confirmation_message) . "</p>\n";
			// exit;
			// DEBUG END

			
			// Mail it
			if (mail($to, $SUBJECT, $confirmation_message, $headers)) 
			{
				$message = 'emailsent';
			}
			else
			{
				$error = 'mailerror';
			}

		}
	}


	$location = "day.php?event_id=$event_id&day_id=$day_id&room_id=$room_id&message=" . $message;
	// DEBUG START
	// echo "<p>location=$location</p>\n";
	// echo "<p>message=$message</p>\n";
	// echo "<p>count(guests)=" . count($guests) . "</p>\n";
	// echo "<p>Exiting email_entry.php</p>";
	// exit;
	// DEBUG END
	
	redirect($location);
}
else
{
	// Build query to find out if they want to send an email to themselves and guests
	print_header($event_id, $day_id);
	echo "<div id=\"send_email_confirm\">\n";
    echo "<p>" .  get_vocab("sureemail") . "</p>\n";
    echo "<div id=\"send_email_confirm_links\">\n";
    echo "<a href=\"" . $PHP_SELF . "?day_id=$day_id&event_id=$event_id&room_id=$room_id&entry_id=$entry_id&confirmed=Y\"><span id=\"email_yes\">" . get_vocab("YES") . "!</span></a>\n";
    echo "<a href=\"day.php?event_id=$event_id&day_id=$day_id&room_id=$room_id\"><span id=\"email_no\">" . get_vocab("NO") . "!</span></a>\n";
    echo "</div>\n";
    echo "</div>\n";
    
}


?>