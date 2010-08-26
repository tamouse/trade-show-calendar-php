<?php // -*-mode: PHP; coding:iso-8859-1;-*-

// $Id: lang.sv 1310 2010-03-21 20:46:30Z cimorrison $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is the Swedish file.
//
// Translated provede by: Bo Kleve (bok@unit.liu.se), MissterX
// Modified on 2006-01-04 by: Bj�rn Wiberg <Bjorn.Wiberg@its.uu.se>
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$vocab["charset"]            = "iso-8859-1";

// Used in style.inc
$vocab["mrbs"]               = "MRBS - M�tesRumsBokningsSystem";

// Used in functions.inc
$vocab["report"]             = "Rapport";
$vocab["admin"]              = "Admin";
$vocab["help"]               = "Hj�lp";
$vocab["search"]             = "S�k";
$vocab["not_php3"]           = "VARNING: Detta fungerar f�rmodligen inte med PHP3";

// Used in day.php
$vocab["bookingsfor"]        = "Bokningar f�r";
$vocab["bookingsforpost"]    = "";
$vocab["areas"]              = "Omr�den";
$vocab["daybefore"]          = "G� till f�reg�ende dag";
$vocab["dayafter"]           = "G� till n�sta dag";
$vocab["gototoday"]          = "G� till idag";
$vocab["goto"]               = "G� till";
$vocab["highlight_line"]     = "Markera denna rad";
$vocab["click_to_reserve"]   = "Klicka p� cellen f�r att g�ra en bokning.";

// Used in trailer.inc
$vocab["viewday"]            = "Visa dag";
$vocab["viewweek"]           = "Visa vecka";
$vocab["viewmonth"]          = "Visa m�nad";
$vocab["ppreview"]           = "F�rhandsgranska";

// Used in edit_entry.php
$vocab["addentry"]           = "Ny bokning";
$vocab["editentry"]          = "�ndra bokningen";
$vocab["editseries"]         = "�ndra serie";
$vocab["namebooker"]         = "Kort beskrivning";
$vocab["fulldescription"]    = "Fullst�ndig beskrivning:";
$vocab["date"]               = "Datum";
$vocab["start_date"]         = "Starttid";
$vocab["end_date"]           = "Sluttid";
$vocab["time"]               = "Tid";
$vocab["period"]             = "Period";
$vocab["duration"]           = "L�ngd";
$vocab["seconds"]            = "sekunder";
$vocab["minutes"]            = "minuter";
$vocab["hours"]              = "timmar";
$vocab["days"]               = "dagar";
$vocab["weeks"]              = "veckor";
$vocab["years"]              = "�r";
$vocab["periods"]            = "perioder";
$vocab["all_day"]            = "hela dagen";
$vocab["type"]               = "Typ";
$vocab["internal"]           = "Internt";
$vocab["external"]           = "Externt";
$vocab["save"]               = "Spara";
$vocab["rep_type"]           = "Repetitionstyp";
$vocab["rep_type_0"]         = "ingen";
$vocab["rep_type_1"]         = "dagligen";
$vocab["rep_type_2"]         = "varje vecka";
$vocab["rep_type_3"]         = "m�natligen";
$vocab["rep_type_4"]         = "�rligen";
$vocab["rep_type_5"]         = "M�nadsvis, samma dag";
$vocab["rep_type_6"]         = "Veckovis";
$vocab["rep_end_date"]       = "Repetition slutdatum";
$vocab["rep_rep_day"]        = "Repetitionsdag";
$vocab["rep_for_weekly"]     = "(vid varje vecka)";
$vocab["rep_freq"]           = "Intervall";
$vocab["rep_num_weeks"]      = "Antal veckor";
$vocab["rep_for_nweekly"]    = "(F�r x-veckor)";
$vocab["ctrl_click"]         = "H�ll ner tangenten <I>Ctrl</I> och klicka f�r att v�lja mer �n ett rum";
$vocab["entryid"]            = "Boknings-ID ";
$vocab["repeat_id"]          = "Repetions-ID "; 
$vocab["you_have_not_entered"] = "Du har inte angivit";
$vocab["you_have_not_selected"] = "Du har inte valt";
$vocab["valid_room"]         = "ett giltigt rum.";
$vocab["valid_time_of_day"]  = "en giltig tidpunkt p� dagen.";
$vocab["brief_description"]  = "en kort beskrivning.";
$vocab["useful_n-weekly_value"] = "ett anv�ndbart n-veckovist v�rde.";

// Used in view_entry.php
$vocab["description"]        = "Beskrivning";
$vocab["room"]               = "Rum";
$vocab["createdby"]          = "Skapad av";
$vocab["lastupdate"]         = "Senast uppdaterad";
$vocab["deleteentry"]        = "Radera bokningen";
$vocab["deleteseries"]       = "Radera serie";
$vocab["confirmdel"]         = "�r du s�ker att\\ndu vill radera\\nden h�r bokningen?\\n\\n";
$vocab["returnprev"]         = "�ter till f�reg�ende sida";
$vocab["invalid_entry_id"]   = "Ogiltigt boknings-ID!";
$vocab["invalid_series_id"]  = "Ogiltigt serie-ID!";

// Used in edit_entry_handler.php
$vocab["error"]              = "Fel";
$vocab["sched_conflict"]     = "Bokningskonflikt";
$vocab["conflict"]           = "Den nya bokningen krockar med f�ljande bokning(ar)";
$vocab["too_may_entrys"]     = "De valda inst�llningarna skapar f�r m�nga bokningar.<br>V.g. anv�nd andra inst�llningar!";
$vocab["returncal"]          = "�terg� till kalendervy";
$vocab["failed_to_acquire"]  = "Kunde ej f� exklusiv databas�tkomst"; 
$vocab["invalid_booking"]    = "Ogiltig bokning";
$vocab["must_set_description"] = "Du m�ste ange en kort beskrivning f�r bokningen. V�nligen g� tillbaka och korrigera detta.";

// Authentication stuff
$vocab["accessdenied"]       = "�tkomst nekad";
$vocab["norights"]           = "Du har inte r�ttighet att �ndra bokningen.";
$vocab["please_login"]       = "V�nligen logga in";
$vocab["users.name"]          = "Anv�ndarnamn";
$vocab["users.password"]      = "L�senord";
$vocab["users.level"]         = "R�ttigheter";
$vocab["unknown_user"]       = "Ok�nd anv�ndare";
$vocab["you_are"]            = "Du �r";
$vocab["login"]              = "Logga in";
$vocab["logoff"]             = "Logga ut";

// Authentication database
$vocab["user_list"]          = "Anv�ndarlista";
$vocab["edit_user"]          = "Editera anv�ndare";
$vocab["delete_user"]        = "Radera denna anv�ndare";
//$vocab["users.name"]         = Use the same as above, for consistency.
//$vocab["users.password"]     = Use the same as above, for consistency.
$vocab["users.email"]         = "E-postadress";
$vocab["password_twice"]     = "Om du vill �ndra ditt l�senord, v�nligen mata in detta tv� g�nger";
$vocab["passwords_not_eq"]   = "Fel: L�senorden st�mmer inte �verens.";
$vocab["add_new_user"]       = "L�gg till anv�ndare";
$vocab["action"]             = "Aktion";
$vocab["user"]               = "Anv�ndare";
$vocab["administrator"]      = "Administrat�r";
$vocab["unknown"]            = "Ok�nd";
$vocab["ok"]                 = "OK";
$vocab["show_my_entries"]    = "Klicka f�r att visa alla dina aktuella bokningar";
$vocab["no_users_initial"]   = "Inga anv�ndare finns i databasen. Till�ter initialt skapande av anv�ndare.";
$vocab["no_users_create_first_admin"] = "Skapa en administrativ anv�ndare f�rst. D�refter kan du logga in och skapa fler anv�ndare.";

// Used in search.php
$vocab["invalid_search"]     = "Tom eller ogiltig s�kstr�ng.";
$vocab["search_results"]     = "S�kresultat f�r";
$vocab["nothing_found"]      = "Inga s�ktr�ffar hittades.";
$vocab["records"]            = "Bokning ";
$vocab["through"]            = " t.o.m. ";
$vocab["of"]                 = " av ";
$vocab["previous"]           = "F�reg�ende";
$vocab["next"]               = "N�sta";
$vocab["entry"]              = "Bokning";
$vocab["view"]               = "Visa";
$vocab["advanced_search"]    = "Avancerad s�kning";
$vocab["search_button"]      = "S�k";
$vocab["search_for"]         = "S�k f�r";
$vocab["from"]               = "Fr�n";

// Used in report.php
$vocab["report_on"]          = "Rapport �ver m�ten";
$vocab["report_start"]       = "Startdatum f�r rapport";
$vocab["report_end"]         = "Slutdatum f�r rapport";
$vocab["match_area"]         = "S�k p� plats";
$vocab["match_room"]         = "S�k p� rum";
$vocab["match_type"]         = "S�k p� bokningstyp";
$vocab["ctrl_click_type"]    = "H�ll ner tangenten <I>Ctrl</I> och klicka f�r att v�lja fler �n en typ";
$vocab["match_entry"]        = "S�k p� kort beskrivning";
$vocab["match_descr"]        = "S�k p� fullst�ndig beskrivning";
$vocab["include"]            = "Inkludera";
$vocab["report_only"]        = "Endast rapport";
$vocab["summary_only"]       = "Endast sammanst�llning";
$vocab["report_and_summary"] = "Rapport och sammanst�llning";
$vocab["summarize_by"]       = "Sammanst�ll p�";
$vocab["sum_by_descrip"]     = "Kort beskrivning";
$vocab["sum_by_creator"]     = "Skapare";
$vocab["entry_found"]        = "bokning hittad";
$vocab["entries_found"]      = "bokningar hittade";
$vocab["summary_header"]     = "Sammanst�llning �ver (bokningar) timmar";
$vocab["summary_header_per"] = "Sammanst�llning �ver (bokningar) perioder";
$vocab["total"]              = "Totalt";
$vocab["submitquery"]        = "Skapa rapport";
$vocab["sort_rep"]           = "Sortera rapport efter";
$vocab["sort_rep_time"]      = "Startdatum/starttid";
$vocab["rep_dsp"]            = "Visa i rapport";
$vocab["rep_dsp_dur"]        = "L�ngd";
$vocab["rep_dsp_end"]        = "Sluttid";

// Used in week.php
$vocab["weekbefore"]         = "F�reg�ende vecka";
$vocab["weekafter"]          = "N�sta vecka";
$vocab["gotothisweek"]       = "Denna vecka";

// Used in month.php
$vocab["monthbefore"]        = "F�reg�ende m�nad";
$vocab["monthafter"]         = "N�sta m�nad";
$vocab["gotothismonth"]      = "Denna m�nad";

// Used in {day week month}.php
$vocab["no_rooms_for_area"]  = "Rum saknas f�r denna plats";

// Used in admin.php
$vocab["edit"]               = "�ndra";
$vocab["delete"]             = "Radera";
$vocab["rooms"]              = "Rum";
$vocab["in"]                 = "i";
$vocab["noareas"]            = "Inget omr�de";
$vocab["addarea"]            = "L�gg till omr�de";
$vocab["name"]               = "Namn";
$vocab["noarea"]             = "Inget omr�de valt";
$vocab["browserlang"]        = "Din webbl�sare �r inst�lld att anv�nda spr�k(en)";
$vocab["addroom"]            = "L�gg till rum";
$vocab["capacity"]           = "Kapacitet";
$vocab["norooms"]            = "Inga rum.";
$vocab["administration"]     = "Administration";

// Used in edit_area_room.php
$vocab["editarea"]           = "�ndra omr�de";
$vocab["change"]             = "�ndra";
$vocab["backadmin"]          = "Tillbaka till Administration";
$vocab["editroomarea"]       = "�ndra omr�de eller rum";
$vocab["editroom"]           = "�ndra rum";
$vocab["update_room_failed"] = "Uppdatering av rum misslyckades: ";
$vocab["error_room"]         = "Fel: rum ";
$vocab["not_found"]          = " hittades ej";
$vocab["update_area_failed"] = "Uppdatering av omr�de misslyckades: ";
$vocab["error_area"]         = "Fel: omr�de";
$vocab["room_admin_email"]   = "E-postadress till rumsansvarig";
$vocab["area_admin_email"]   = "E-postadress till omr�desansvarig";
$vocab["invalid_email"]      = "Ogiltig e-postadress!";

// Used in del.php
$vocab["deletefollowing"]    = "Detta raderar f�ljande bokningar";
$vocab["sure"]               = "�r du s�ker?";
$vocab["YES"]                = "JA";
$vocab["NO"]                 = "NEJ";
$vocab["delarea"]            = "Du m�ste ta bort alla rum i detta omr�de innan du kan ta bort omr�det!<p>";
$vocab["backadmin"]          = "Tillbaka till Administration";

// Used in help.php
$vocab["about_mrbs"]         = "Om MRBS";
$vocab["database"]           = "Databas";
$vocab["system"]             = "System";
$vocab["please_contact"]     = "Var v�nlig kontakta ";
$vocab["for_any_questions"]  = "f�r eventuella fr�gor som ej besvaras h�r.";

// Used in mysql.inc AND pgsql.inc
$vocab["failed_connect_db"]  = "Fatalt fel: Kunde ej ansluta till databasen!";

?>
<?php
// Additional vocabulary for translating
$vocab["notimplemented"]      = "That feature is not implemented yet";
$vocab["cdma"]               = "CDMA Calendar Booking";
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
$vocab["about_cdma"]         = "About CDMA";
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
