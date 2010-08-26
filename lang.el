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
$vocab["cdma"]               = "Σύστημα Κρατήσεων Αιθουσών (CDMA)";

// Used in functions.inc
$vocab["report"]             = "Αναφορά";
$vocab["admin"]              = "Διαχείριση";
$vocab["help"]               = "Βοήθεια";
$vocab["search"]             = "Αναζήτηση";
$vocab["not_php3"]           = "Προσοχή: Αυτή η σελίδα δεν δουλεύει με PHP3";

// Used in day.php
$vocab["bookingsfor"]        = "Κρατήσεις για";
$vocab["bookingsforpost"]    = ""; // Goes after the date
$vocab["areas"]              = "Περιοχές";
$vocab["daybefore"]          = "Μετάβαση στην προηγούμενη μέρα";
$vocab["dayafter"]           = "Μετάβαση στην επόμενη μέρα";
$vocab["gototoday"]          = "Μετάβαση στη σημερινή μέρα";
$vocab["goto"]               = "Μετάβαση";
$vocab["highlight_line"]     = "Highlight this line";
$vocab["click_to_reserve"]   = "Click on the cell to make a reservation.";

// Used in trailer.inc
$vocab["viewday"]            = "Προβολή ανά ημέρα";
$vocab["viewweek"]           = "Προβολή ανά εβδομάδα";
$vocab["viewmonth"]          = "Προβολή ανά μήνα";
$vocab["ppreview"]           = "Προεπισκόπηση εκτύπωσης";

// Used in edit_entry.php
$vocab["addentry"]           = "Προσθήκη εγγραφής";
$vocab["editentry"]          = "Τροποποίηση εγγραφής";
$vocab["editseries"]         = "Τροποποίηση σειράς";
$vocab["namebooker"]         = "Σύντομη περιγραφή";
$vocab["fulldescription"]    = "Πλήρης περιγραφή:<br>&nbsp;&nbsp;(Αριθμός θέσεων,<br>&nbsp;&nbsp;Εσωτερική/Εξωτερική κλπ.)";
$vocab["date"]               = "Ημερομηνία";
$vocab["start_date"]         = "Ώρα έναρξης";
$vocab["end_date"]           = "Ώρα λήξης";
$vocab["time"]               = "Ώρα";
$vocab["period"]             = "Period";
$vocab["duration"]           = "Διάρκεια";
$vocab["seconds"]            = "δευτερόλεπτα";
$vocab["minutes"]            = "λεπτά";
$vocab["hours"]              = "ώρες";
$vocab["days"]               = "ημέρες";
$vocab["weeks"]              = "εβδομάδες";
$vocab["years"]              = "χρόνια";
$vocab["periods"]            = "periods";
$vocab["all_day"]            = "Ολόκληρη μέρα";
$vocab["type"]               = "Τύπος";
$vocab["internal"]           = "Εσωτερικά";
$vocab["external"]           = "Εξωτερικά";
$vocab["save"]               = "Αποθήκευση";
$vocab["rep_type"]           = "Τύπος επανάληψης";
$vocab["rep_type_0"]         = "Τίποτα";
$vocab["rep_type_1"]         = "Ημερήσια";
$vocab["rep_type_2"]         = "Εβδομαδιαία";
$vocab["rep_type_3"]         = "Μηνιαία";
$vocab["rep_type_4"]         = "Χρόνια";
$vocab["rep_type_5"]         = "Μηνιαία, αντίστοιχη ημέρα";
$vocab["rep_type_6"]         = "n-Εβδομαδιαία";
$vocab["rep_end_date"]       = "Ημερομηνία ολοκλήρωσης επανάληψης";
$vocab["rep_rep_day"]        = "Ημέρα επανάληψης";
$vocab["rep_for_weekly"]     = "(για (n-)εβδομαδιαία)";
$vocab["rep_freq"]           = "Συχνότητα";
$vocab["rep_num_weeks"]      = "Αριθμός εβδομάδων";
$vocab["rep_for_nweekly"]    = "(για n-εβδομαδιαία)";
$vocab["ctrl_click"]         = "Χρησιμοποιήστε Control-Click για να επιλέξετε περισσότερες από μία αίθουσες";
$vocab["entryid"]            = "Αναγνωριστικός αριθμός εγγραφής ";
$vocab["repeat_id"]          = "Αναγνωριστικός αριθμός επανάληψης "; 
$vocab["you_have_not_entered"] = "Δεν εισάγατε το (τα)";
$vocab["you_have_not_selected"] = "You have not selected a";
$vocab["valid_room"]         = "room.";
$vocab["valid_time_of_day"]  = "έγκυρη ώρα.";
$vocab["brief_description"]  = "Σύντομη Περιγραφή.";
$vocab["useful_n-weekly_value"] = "χρήσιμη n-εβδομαδιαία τιμή.";

// Used in view_entry.php
$vocab["description"]        = "Περιγραφή";
$vocab["room"]               = "Αίθουσα";
$vocab["createdby"]          = "Δημιουργήθηκε από";
$vocab["lastupdate"]         = "Τελευταία ενημέρωση";
$vocab["deleteentry"]        = "Διαγραφή εγγραφής";
$vocab["deleteseries"]       = "Διαγραφή σειράς επανάληψης";
$vocab["confirmdel"]         = "Είστε βέβαιοι\\nότι θέλετε να\\nδιαγράψετε αυτή την εγγραφή;\\n\\n";
$vocab["returnprev"]         = "Επιστροφή στην προηγούμενη σελίδα";
$vocab["invalid_entry_id"]   = "Λάθος αναγνωριστικός αριθμός αίτησης.";
$vocab["invalid_series_id"]  = "Invalid series id.";

// Used in edit_entry_handler.php
$vocab["error"]              = "Σφάλμα";
$vocab["sched_conflict"]     = "Αντικρουόμενος Προγραμματισμός";
$vocab["conflict"]           = "Η νέα κράτηση αντικρούει με τις ακόλουθες εγγραφές";
$vocab["too_may_entrys"]     = "Οι επιλογές θα δημιουργήσουν υπερβολικό αριθμό εγγραφών.<br>Παρακαλώ χρησιμοποιείστε διαφορετικές επιλογές!";
$vocab["returncal"]          = "Επιστροφή σε προβολή ημερολογίου";
$vocab["failed_to_acquire"]  = "Αποτυχία εξασφάλισης αποκλειστικής πρόσβασης στην βάση δεδομένων"; 

// Authentication stuff
$vocab["accessdenied"]       = "Απαγορεύεται η πρόσβαση";
$vocab["norights"]           = "Δεν έχετε δικαιώματα πρόσβασης για να τροποποιήσετε αυτό το αντικείμενο.";
$vocab["please_login"]       = "Παρακαλώ κάνετε εισαγωγή (log in)";
$vocab["users.name"]          = "Όνομα Χρήστη";
$vocab["users.password"]      = "Κωδικός Πρόσβασης";
$vocab["users.level"]         = "Rights";
$vocab["unknown_user"]       = "Αγνωστος χρήστης";
$vocab["you_are"]            = "Είστε";
$vocab["login"]              = "Εισαγωγή (Log in)";
$vocab["logoff"]             = "Έξοδος (Log Off)";

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
$vocab["invalid_search"]     = "Κενό ή λανθασμένο κείμενο αναζήτησης.";
$vocab["search_results"]     = "Αποτελέσματα αναζήτησης για";
$vocab["nothing_found"]      = "Δεν βρέθηκαν εγγραφές που να ταιριάζουν.";
$vocab["records"]            = "Καταχώρηση ";
$vocab["through"]            = " έως ";
$vocab["of"]                 = " από ";
$vocab["previous"]           = "Προηγούμενη";
$vocab["next"]               = "Επόμενη";
$vocab["entry"]              = "Αίτηση";
$vocab["view"]               = "Προβολή";
$vocab["advanced_search"]    = "Προηγμένη αναζήτηση";
$vocab["search_button"]      = "Αναζήτηση";
$vocab["search_for"]         = "Αναζήτηση για";
$vocab["from"]               = "Από";

// Used in report.php
$vocab["report_on"]          = "Αναφορά για Συναντήσεις";
$vocab["report_start"]       = "Ημερομηνία έναρξης αναφοράς";
$vocab["report_end"]         = "Ημερομηνία λήξης αναφοράς";
$vocab["match_area"]         = "Ταίριασμα περιοχής";
$vocab["match_room"]         = "Ταίριασμα αίθουσας";
$vocab["match_type"]         = "Match type";
$vocab["ctrl_click_type"]    = "Use Control-Click to select more than one type";
$vocab["match_entry"]        = "Ταίριασμα σύντομης περιγραφής";
$vocab["match_descr"]        = "Ταίριασμα αναλυτικής περιγραφής";
$vocab["include"]            = "Να συμπεριληφθούν";
$vocab["report_only"]        = "Αναφορά μόνο";
$vocab["summary_only"]       = "Περίληψη μόνο";
$vocab["report_and_summary"] = "Αναφορά και περίληψη";
$vocab["summarize_by"]       = "Σύνοψη κατά";
$vocab["sum_by_descrip"]     = "Σύντομη περιγραφή";
$vocab["sum_by_creator"]     = "Δημιουργός";
$vocab["entry_found"]        = "καταχώρηση βρέθηκε";
$vocab["entries_found"]      = "καταχωρήσεις βρέθηκαν";
$vocab["summary_header"]     = "Περίληψη ωρών εγγραφών";
$vocab["summary_header_per"] = "Summary of (Entries) Periods";
$vocab["total"]              = "Σύνολο";
$vocab["submitquery"]        = "Εκτέλεση αναφοράς";
$vocab["sort_rep"]           = "Sort Report by";
$vocab["sort_rep_time"]      = "Start Date/Time";
$vocab["rep_dsp"]            = "Display in report";
$vocab["rep_dsp_dur"]        = "Duration";
$vocab["rep_dsp_end"]        = "End Time";

// Used in week.php
$vocab["weekbefore"]         = "Μετάβαση στην προηγούμενη εβδομάδα";
$vocab["weekafter"]          = "Μετάβαση στην επόμενη εβδομάδα";
$vocab["gotothisweek"]       = "Μετάβαση στην τρέχουσα εβδομάδα";

// Used in month.php
$vocab["monthbefore"]        = "Μετάβαση στον προηγούμενο μήνα";
$vocab["monthafter"]         = "Μετάβαση στον επόμενο μήνα";
$vocab["gotothismonth"]      = "Μετάβαση στον τρέχοντα μήνα";

// Used in {day week month}.php
$vocab["no_rooms_for_area"]  = "Δεν έχουν οριστεί αίθουσες για αυτή την περιοχή";

// Used in admin.php
$vocab["edit"]               = "Τροποποίηση";
$vocab["delete"]             = "Διαγραφή";
$vocab["rooms"]              = "Αίθουσες";
$vocab["in"]                 = "στο";
$vocab["noareas"]            = "Καμία περιοχή";
$vocab["addarea"]            = "Προσθήκη περιοχής";
$vocab["name"]               = "Όνομα";
$vocab["noarea"]             = "Δεν έχει επιλεχθεί περιοχή";
$vocab["browserlang"]        = "Ο φυλλομετρητής σας χρησιμοποιεί";
$vocab["addroom"]            = "Προσθήκη αίθουσας";
$vocab["capacity"]           = "Χωρητικότητα";
$vocab["norooms"]            = "Καμιά αίθουσα.";
$vocab["administration"]     = "Διαχείριση";

// Used in edit_area_room.php
$vocab["editarea"]           = "Τροποποίηση περιοχής";
$vocab["change"]             = "Αλλαγή";
$vocab["backadmin"]          = "Επιστροφή στην διαχείριση";
$vocab["editroomarea"]       = "Τροποποίηση περιγραφής περιοχής ή αίθουσας";
$vocab["editroom"]           = "Τροποποίηση αίθουσας";
$vocab["update_room_failed"] = "Η ενημέρωση της αίθουσας απέτυχε: ";
$vocab["error_room"]         = "Σφάλμα: Η αίθουσα ";
$vocab["not_found"]          = " δεν βρέθηκε";
$vocab["update_area_failed"] = "Η ενημέρωση της πειοχής απέτυχε: ";
$vocab["error_area"]         = "Σφάλμα: Η περιοχή ";
$vocab["room_admin_email"]   = "Room admin email";
$vocab["area_admin_email"]   = "Area admin email";
$vocab["invalid_email"]      = "Invalid email!";

// Used in del.php
$vocab["deletefollowing"]    = "Η ενέργεια αυτή θα διαγράψει τις ακόλουθες κρατήσεις";
$vocab["sure"]               = "Είστε σίγουροι;";
$vocab["YES"]                = "ΝΑΙ";
$vocab["NO"]                 = "ΟΧΙ";
$vocab["delarea"]            = "Πρέπει να διαγράψετε όλες τις αίθουσες σε αυτή τη περιοχή για να μπορέσετε να την διαγράψετε<p>";

// Used in help.php
$vocab["about_cdma"]         = "Σχετικά με το CDMA";
$vocab["database"]           = "Βάση δεδομένων";
$vocab["system"]             = "Σύστημα";
$vocab["please_contact"]     = "Παρακαλώ επικοινωνήστε με ";
$vocab["for_any_questions"]  = "για όσες ερωτήσεις δεν απαντώνται εδώ.";

// Used in mysql.inc AND pgsql.inc
$vocab["failed_connect_db"]  = "Κρίσιμο σφάλμα: Αποτυχία σύνδεσης στη βάση δεδομένων";

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
