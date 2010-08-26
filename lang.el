<?php // -*-mode: PHP; coding:iso-8859-7;-*-

// $Id: lang.el 1310 2010-03-21 20:46:30Z cimorrison $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is a Greek file.
//
//
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$vocab["charset"]            = "iso-8859-7";

// Used in style.inc
$vocab["cdma"]               = "������� ��������� �������� (CDMA)";

// Used in functions.inc
$vocab["report"]             = "�������";
$vocab["admin"]              = "����������";
$vocab["help"]               = "�������";
$vocab["search"]             = "���������";
$vocab["not_php3"]           = "�������: ���� � ������ ��� �������� �� PHP3";

// Used in day.php
$vocab["bookingsfor"]        = "��������� ���";
$vocab["bookingsforpost"]    = ""; // Goes after the date
$vocab["areas"]              = "��������";
$vocab["daybefore"]          = "�������� ���� ����������� ����";
$vocab["dayafter"]           = "�������� ���� ������� ����";
$vocab["gototoday"]          = "�������� ��� �������� ����";
$vocab["goto"]               = "��������";
$vocab["highlight_line"]     = "Highlight this line";
$vocab["click_to_reserve"]   = "Click on the cell to make a reservation.";

// Used in trailer.inc
$vocab["viewday"]            = "������� ��� �����";
$vocab["viewweek"]           = "������� ��� ��������";
$vocab["viewmonth"]          = "������� ��� ����";
$vocab["ppreview"]           = "������������� ���������";

// Used in edit_entry.php
$vocab["addentry"]           = "�������� ��������";
$vocab["editentry"]          = "����������� ��������";
$vocab["editseries"]         = "����������� ������";
$vocab["namebooker"]         = "������� ���������";
$vocab["fulldescription"]    = "������ ���������:<br>&nbsp;&nbsp;(������� ������,<br>&nbsp;&nbsp;���������/��������� ���.)";
$vocab["date"]               = "����������";
$vocab["start_date"]         = "��� �������";
$vocab["end_date"]           = "��� �����";
$vocab["time"]               = "���";
$vocab["period"]             = "Period";
$vocab["duration"]           = "��������";
$vocab["seconds"]            = "������������";
$vocab["minutes"]            = "�����";
$vocab["hours"]              = "����";
$vocab["days"]               = "������";
$vocab["weeks"]              = "���������";
$vocab["years"]              = "������";
$vocab["periods"]            = "periods";
$vocab["all_day"]            = "�������� ����";
$vocab["type"]               = "�����";
$vocab["internal"]           = "���������";
$vocab["external"]           = "���������";
$vocab["save"]               = "����������";
$vocab["rep_type"]           = "����� ����������";
$vocab["rep_type_0"]         = "������";
$vocab["rep_type_1"]         = "��������";
$vocab["rep_type_2"]         = "�����������";
$vocab["rep_type_3"]         = "�������";
$vocab["rep_type_4"]         = "������";
$vocab["rep_type_5"]         = "�������, ���������� �����";
$vocab["rep_type_6"]         = "n-�����������";
$vocab["rep_end_date"]       = "���������� ����������� ����������";
$vocab["rep_rep_day"]        = "����� ����������";
$vocab["rep_for_weekly"]     = "(��� (n-)�����������)";
$vocab["rep_freq"]           = "���������";
$vocab["rep_num_weeks"]      = "������� ���������";
$vocab["rep_for_nweekly"]    = "(��� n-�����������)";
$vocab["ctrl_click"]         = "�������������� Control-Click ��� �� ��������� ������������ ��� ��� ��������";
$vocab["entryid"]            = "�������������� ������� �������� ";
$vocab["repeat_id"]          = "�������������� ������� ���������� "; 
$vocab["you_have_not_entered"] = "��� �������� �� (��)";
$vocab["you_have_not_selected"] = "You have not selected a";
$vocab["valid_room"]         = "room.";
$vocab["valid_time_of_day"]  = "������ ���.";
$vocab["brief_description"]  = "������� ���������.";
$vocab["useful_n-weekly_value"] = "������� n-����������� ����.";

// Used in view_entry.php
$vocab["description"]        = "���������";
$vocab["room"]               = "�������";
$vocab["createdby"]          = "������������� ���";
$vocab["lastupdate"]         = "��������� ���������";
$vocab["deleteentry"]        = "�������� ��������";
$vocab["deleteseries"]       = "�������� ������ ����������";
$vocab["confirmdel"]         = "����� �������\\n��� ������ ��\\n���������� ���� ��� �������;\\n\\n";
$vocab["returnprev"]         = "��������� ���� ����������� ������";
$vocab["invalid_entry_id"]   = "����� �������������� ������� �������.";
$vocab["invalid_series_id"]  = "Invalid series id.";

// Used in edit_entry_handler.php
$vocab["error"]              = "������";
$vocab["sched_conflict"]     = "�������������� ���������������";
$vocab["conflict"]           = "� ��� ������� ���������� �� ��� ��������� ��������";
$vocab["too_may_entrys"]     = "�� �������� �� ������������� ���������� ������ ��������.<br>�������� ��������������� ������������ ��������!";
$vocab["returncal"]          = "��������� �� ������� �����������";
$vocab["failed_to_acquire"]  = "�������� ����������� ������������� ��������� ���� ���� ���������"; 

// Authentication stuff
$vocab["accessdenied"]       = "������������ � ��������";
$vocab["norights"]           = "��� ����� ���������� ��������� ��� �� ������������� ���� �� �����������.";
$vocab["please_login"]       = "�������� ������ �������� (log in)";
$vocab["users.name"]          = "����� ������";
$vocab["users.password"]      = "������� ���������";
$vocab["users.level"]         = "Rights";
$vocab["unknown_user"]       = "�������� �������";
$vocab["you_are"]            = "�����";
$vocab["login"]              = "�������� (Log in)";
$vocab["logoff"]             = "������ (Log Off)";

// Authentication database
$vocab["user_list"]          = "User list";
$vocab["edit_user"]          = "Edit user";
$vocab["delete_user"]        = "Delete this user";
//$vocab["users.name"]         = Use the same as above, for consistency.
//$vocab["users.password"]     = Use the same as above, for consistency.
$vocab["users.email"]         = "Email address";
$vocab["password_twice"]     = "If you wish to change the password, please type the new password twice";
$vocab["passwords_not_eq"]   = "Error: The passwords do not match.";
$vocab["add_new_user"]       = "Add a new user";
$vocab["action"]             = "Action";
$vocab["user"]               = "User";
$vocab["administrator"]      = "Administrator";
$vocab["unknown"]            = "Unknown";
$vocab["ok"]                 = "OK";
$vocab["show_my_entries"]    = "Click to display all my upcoming entries";

// Used in search.php
$vocab["invalid_search"]     = "���� � ���������� ������� ����������.";
$vocab["search_results"]     = "������������ ���������� ���";
$vocab["nothing_found"]      = "��� �������� �������� ��� �� ����������.";
$vocab["records"]            = "���������� ";
$vocab["through"]            = " ��� ";
$vocab["of"]                 = " ��� ";
$vocab["previous"]           = "�����������";
$vocab["next"]               = "�������";
$vocab["entry"]              = "������";
$vocab["view"]               = "�������";
$vocab["advanced_search"]    = "��������� ���������";
$vocab["search_button"]      = "���������";
$vocab["search_for"]         = "��������� ���";
$vocab["from"]               = "���";

// Used in report.php
$vocab["report_on"]          = "������� ��� �����������";
$vocab["report_start"]       = "���������� ������� ��������";
$vocab["report_end"]         = "���������� ����� ��������";
$vocab["match_area"]         = "��������� ��������";
$vocab["match_room"]         = "��������� ��������";
$vocab["match_type"]         = "Match type";
$vocab["ctrl_click_type"]    = "Use Control-Click to select more than one type";
$vocab["match_entry"]        = "��������� �������� ����������";
$vocab["match_descr"]        = "��������� ���������� ����������";
$vocab["include"]            = "�� ��������������";
$vocab["report_only"]        = "������� ����";
$vocab["summary_only"]       = "�������� ����";
$vocab["report_and_summary"] = "������� ��� ��������";
$vocab["summarize_by"]       = "������ ����";
$vocab["sum_by_descrip"]     = "������� ���������";
$vocab["sum_by_creator"]     = "����������";
$vocab["entry_found"]        = "���������� �������";
$vocab["entries_found"]      = "������������ ��������";
$vocab["summary_header"]     = "�������� ���� ��������";
$vocab["summary_header_per"] = "Summary of (Entries) Periods";
$vocab["total"]              = "������";
$vocab["submitquery"]        = "�������� ��������";
$vocab["sort_rep"]           = "Sort Report by";
$vocab["sort_rep_time"]      = "Start Date/Time";
$vocab["rep_dsp"]            = "Display in report";
$vocab["rep_dsp_dur"]        = "Duration";
$vocab["rep_dsp_end"]        = "End Time";

// Used in week.php
$vocab["weekbefore"]         = "�������� ���� ����������� ��������";
$vocab["weekafter"]          = "�������� ���� ������� ��������";
$vocab["gotothisweek"]       = "�������� ���� �������� ��������";

// Used in month.php
$vocab["monthbefore"]        = "�������� ���� ����������� ����";
$vocab["monthafter"]         = "�������� ���� ������� ����";
$vocab["gotothismonth"]      = "�������� ���� �������� ����";

// Used in {day week month}.php
$vocab["no_rooms_for_area"]  = "��� ����� ������� �������� ��� ���� ��� �������";

// Used in admin.php
$vocab["edit"]               = "�����������";
$vocab["delete"]             = "��������";
$vocab["rooms"]              = "��������";
$vocab["in"]                 = "���";
$vocab["noareas"]            = "����� �������";
$vocab["addarea"]            = "�������� ��������";
$vocab["name"]               = "�����";
$vocab["noarea"]             = "��� ���� ��������� �������";
$vocab["browserlang"]        = "� ������������� ��� ������������";
$vocab["addroom"]            = "�������� ��������";
$vocab["capacity"]           = "������������";
$vocab["norooms"]            = "����� �������.";
$vocab["administration"]     = "����������";

// Used in edit_area_room.php
$vocab["editarea"]           = "����������� ��������";
$vocab["change"]             = "������";
$vocab["backadmin"]          = "��������� ���� ����������";
$vocab["editroomarea"]       = "����������� ���������� �������� � ��������";
$vocab["editroom"]           = "����������� ��������";
$vocab["update_room_failed"] = "� ��������� ��� �������� �������: ";
$vocab["error_room"]         = "������: � ������� ";
$vocab["not_found"]          = " ��� �������";
$vocab["update_area_failed"] = "� ��������� ��� ������� �������: ";
$vocab["error_area"]         = "������: � ������� ";
$vocab["room_admin_email"]   = "Room admin email";
$vocab["area_admin_email"]   = "Area admin email";
$vocab["invalid_email"]      = "Invalid email!";

// Used in del.php
$vocab["deletefollowing"]    = "� �������� ���� �� ��������� ��� ��������� ���������";
$vocab["sure"]               = "����� ��������;";
$vocab["YES"]                = "���";
$vocab["NO"]                 = "���";
$vocab["delarea"]            = "������ �� ���������� ���� ��� �������� �� ���� �� ������� ��� �� ��������� �� ��� ����������<p>";

// Used in help.php
$vocab["about_cdma"]         = "������� �� �� CDMA";
$vocab["database"]           = "���� ���������";
$vocab["system"]             = "�������";
$vocab["please_contact"]     = "�������� ������������� �� ";
$vocab["for_any_questions"]  = "��� ���� ��������� ��� ���������� ���.";

// Used in mysql.inc AND pgsql.inc
$vocab["failed_connect_db"]  = "������� ������: �������� �������� ��� ���� ���������";

?>
<?php
// Additional vocabulary for translating
$vocab["notimplemented"]      = "That feature is not implemented yet";
$vocab["inactivitywarning"]   = "Inactivity warning!";
$vocab["warningmessage"]      = "You will automatically be logged out in " .  $page_timeout_warning_timeout / 1000 . " seconds unless you hit 'Cancel.'";
$vocab["closebutton"]         = "Log off";
$vocab["cancelbutton"]        = "Cancel";
$vocab["outstanding"]        = "pending bookings";
$vocab["eventcountfailed"]   = "Event count failed";
$vocab["addslot"]            = "Add slot";
$vocab["events"]             = "Events";
$vocab["available"]          = "Available";
$vocab["booked"]             = "Booked";
$vocab["noslot"]             = "Add slot";
$vocab["noslotid"]           = "No slot was specified";
$vocab["slotdeletefailed"]   = "Slot delete attempt failed";
$vocab["selectdayfailed"]	 = "Selection of day entries failed";
$vocab['instructions1']      = "Click on an <span class="available">available</span> space to book an appointment.";
$vocab['instructions2']      = "Click on a <span class="booked_mine">booked</span> space to edit it.";
$vocab['instructions3']      = "Click on 'add a slot' to add a time slot. Click on an <span class="available">available</span> time slot to edit or delete it.";
$vocab["copyentry"]          = "Copy Entry";
$vocab["copyseries"]         = "Copy Series";
$vocab["emailthis"]          = "Email Appointment?";
$vocab["event"]              = "Event";
$vocab["open"]               = "Open";
$vocab["private"]            = "Private";
$vocab["unavailable"]        = "Private";
$vocab["invalid_purpose"]    = "Invalid purpose";
$vocab["starttime"]          = "Start Time";
$vocab["endtime"]            = "End Time";
$vocab["creator"]            = "Creator";
$vocab["purpose"]            = "Purpose";
$vocab["comments"]           = "Comments";
$vocab["guests"]             = "Guests";
$vocab["guestsemails"]        = "Recipient Emails";
$vocab["goback"]             = "Go Back";
$vocab["cantfindentry"]      = "Cannot find entry in database";
$vocab["purposerequired"]    = "Purpose is a required field.";
$vocab['guestshelp']         = "Enter a list of guests for this booking, separated by commas.";
$vocab['guestemailhelp']     = "Enter emails for recipients of confirmation emails, separated by commas. Emails will be validated to make sure they conform to proper rules for email addresses.";
$vocab["deleteslot"]         = "Delete Slot";
$vocab["invalid_starttime"]  = "Invalid start time!";
$vocab["invalid_endtime"]    = "Invalid end time";
$vocab["status"]             = "Status";
$vocab["confirmed"]             = "Confirmed";
$vocab["provisional"]        = "Provisional booking";
$vocab["accept"]             = "Accept";
$vocab["reject"]             = "Reject";
$vocab["more_info"]          = "More Info";
$vocab["remind_admin"]       = "Remind Admin";
$vocab["series"]             = "Series";
$vocab["request_more_info"]  = "Please list the extra information you require";
$vocab["reject_reason"]      = "Please give a reason for your rejection of this reservation request";
$vocab["send"]               = "Send";
$vocab["accept_failed"]      = "The reservation could not be confirmed.";
$vocab["rules_broken"]       = "The new booking will conflict with the following policies";
$vocab["invalid_booking"]    = "Invalid booking";
$vocab["must_set_description"] = "You must set a brief description for the booking. Please go back and enter one.";
$vocab["mail_subject_accepted"]  = "Entry approved for $cdma_company CDMA";
$vocab["mail_subject_rejected"]  = "Entry rejected for $cdma_company CDMA";
$vocab["mail_subject_more_info"] = "$cdma_company CDMA: more information requested";
$vocab["mail_subject_reminder"]  = "Reminder for $cdma_company CDMA";
$vocab["mail_body_accepted"]     = "An entry has been approved by the administrators; here are the details:";
$vocab["mail_body_rej_entry"]    = "An entry has been rejected by the administrators, here are the details:";
$vocab["mail_body_more_info"]    = "The administrators require more information about an entry; here are the details:";
$vocab["mail_body_reminder"]     = "Reminder - an entry is awaiting approval; here are the details:";
$vocab["mail_subject_entry"] = "Entry added/changed for $cdma_company CDMA";
$vocab["mail_body_new_entry"] = "A new entry has been booked, here are the details:";
$vocab["mail_body_del_entry"] = "An entry has been deleted, here are the details:";
$vocab["mail_body_changed_entry"] = "An entry has been modified, here are the details:";
$vocab["mail_subject_delete"] = "Entry deleted for $cdma_company CDMA";
$vocab["deleted_by"]          = "Deleted by";
$vocab["reason"]              = "Reason";
$vocab["info_requested"]      = "Information requested";
$vocab["min_time_before"]     = "The minimum interval between now and the start of a booking is";
$vocab["max_time_before"]     = "The maximum interval between now and the start of a booking is";
$vocab["notowner"]           = "You are not the owner of this item. You cannot modify it or delete it. Please contact the administrator for more information.";
$vocab["database_login"]           = "Database login";
$vocab["upgrade_required"]         = "The database needs to be upgraded.";
$vocab["supply_userpass"]          = "Please supply a database username and password that has admin rights.";
$vocab["contact_admin"]            = "If you are not the CDMA administrator please contact $cdma_admin.";
$vocab["upgrade_to_version"]       = "Upgrading to database version";
$vocab["upgrade_to_local_version"] = "Upgrading to database local version";
$vocab["upgrade_completed"]        = "Database upgrade completed.";
$vocab["level_0"]            = "none";
$vocab["level_1"]            = "user";
$vocab["level_2"]            = "admin";
$vocab["level_3"]            = "user admin";
$vocab["no_users_initial"]   = "No users in database, allowing initial user creation";
$vocab["no_users_create_first_admin"] = "Create a user configured as an administrator and then you can log in and create more users.";
$vocab["warning_last_admin"] = "Warning!  This is the last admin and so you cannot delete this user or remove admin rights, otherwise you will be locked out of the system.";
$vocab["invaliduser"]           = "Invalid user";
$vocab["adminreporttitle"]      = 'Administrative Report';
$vocab["userreporttitle"]       = 'Appointment Report for $user_first_name $user_last_name'; // don't interpret variables here, done by eval when loaded
$vocab["day_heading"]           = 'Appointments for $day_string';
$vocab["room_heading"]          = 'Subsection for $room_name';
$vocab["notconfimed"]           = "Not Confirmed";
$vocab["guestlist"]             = "Guest List";
$vocab["confirmed_q"]           = "Confirmed?";
$vocab["unassigned"]            = "Unassigned";
$vocab["notloggedin"]           = "You are not logged in. Must be logged in to see reports.";
$vocab["no_rooms_for_event"]  = "No rooms defined for this event";
$vocab["gotoSlots"]          = "Manage slots in calendar -->";
$vocab["capdays"]            = "Days";
$vocab["noevents"]           = "No events have been defined.";
$vocab["addevent"]           = "Add Event";
$vocab["day_string"]         = "Date";
$vocab["nodays"]			 = "No days have been defined.";
$vocab["noday"]				 = "No day selected.";
$vocab["noevent"]            = "No event selected";
$vocab["addday"]             = "Add Day";
$vocab["noroom"]			 = "No room selected.";
$vocab["invalid_event_name"] = "This event name has already been used!";
$vocab['invaliddate']        = "Invalid date given";
$vocab['invalid_day_string'] = "This day has already been used for this event";
$vocab['invalid_room_number'] = "This room number has already been used for this event";
$vocab["invalid_room_name"]       = "This room name has already been used in the area!";
$vocab['nonamegiven']        = "No name given, name is required";
$vocab['noroomnumbergiven']  = "No room number given, required";
$vocab['room_description']   = "Description";
$vocab["nostarttime"]		 = "No start time given.";
$vocab["duplicateslot"]	     = "Duplicate slot";
$vocab["editevent"]               = "Edit Event";
$vocab["savechanges"]             = "Save Changes";
$vocab["backmain"]                = "Back to Main";
$vocab["editroomdayevent"]        = "Edit Event, Day or Room Description";
$vocab["viewroom"]                = "View Room";
$vocab["editday"]                 = "Edit Day";
$vocab["update_event_failed"]     = "Update event failed: ";
$vocab["error_event"]             = "Error: event ";
$vocab["update_day_failed"]       = "Update day failed: ";
$vocab["error_day"]               = "Error: day ";
$vocab["event_admin_email"]       = "Event admin email";
$vocab["invalid_event"]           = "Invalid event!";
$vocab["invalid_phone"]           = "Invalid phone number!";
$vocab["invalid_resolution"]      = "Invalid combination of first slot, last slot and resolution!";
$vocab["general_settings"]        = "General";
$vocab["time_settings"]           = "Slot times";
$vocab["enable_reminders"]        = "Allow users to remind admins";
$vocab["default_settings"]        = "Default/forced settings";
$vocab["room_number"]             = "Room number";
$vocab["room_number_note"]        = "Room number";
$vocab["duplicate_day_string"]      = "Duplicate date for this event";
$vocab["name_empty"]         = "You must enter a name.";
$vocab["name_not_unique"]    = "already exists.   Please choose another name.";
$vocab["delevent"]            = "You must delete all days and rooms in this event before you can delete it<p>";
$vocab["servertime"]         = "Server time";
$vocab["sureemail"]          = "Do you want to send a confirmation email of the Appointment?";
$vocab["emailsent"]          = "Confirmation email sent";
$vocab["mailerror"]          = "Error mailing confirmation message";
$vocab["norecipients"]       = "No email recipients";
$vocab["type_1_email_subject"]    = "Confirmation of New Appointment";
$vocab["type_2_email_subject"]    = "Notice of changes to Appointment";
$vocab["type_3_email_subject"]    = "Notice of cancelation of Appointment";
$vocab["type_1_custom_msg"]    = "<p>This is to confirm your appointment at the CDMA Summit. The following details apply:</p>";
$vocab["type_2_custom_msg"]    = "<p><b>This is a notice of change for your  appointment at the CDMA Summit.</b> The following details now apply:</p>";
$vocab["type_3_custom_msg"]    = "<p><b>This is to inform you of a CANCELATION of your appointment at the CDMA Summit.</b> The following were the details of the appointment:</p>";
$vocab["unknownmailtype"]     = "Internal error: unknown mail transaction type. No mail sent.";
?>
<?php
// Additional vocabulary for translating
$vocab["notyourtimeslot"]    = "You do not have access to this time slot";
?>
