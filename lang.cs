<?php // -*-mode: PHP; coding:iso-8859-2;-*-

// $Id: lang.cs 1310 2010-03-21 20:46:30Z cimorrison $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is a Czech file.
//
// Translations provided by: "SmEjDiL" <malyl@col.cz>, 
//   "David Krotil" <David.Krotil@mu-sokolov.cz>
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$vocab["charset"]            = "iso-8859-2";

// Used in style.inc
$vocab["cdma"]               = "CDMA - Rezerva�n� syst�m";

// Used in functions.inc
$vocab["report"]             = "V�pis";
$vocab["admin"]              = "Administr�tor";
$vocab["help"]               = "Pomoc";
$vocab["search"]             = "Hledat";
$vocab["not_php3"]           = "UPOZORN�N�: Toto z�ejm� nen� funk�n� s PHP3";

// Used in day.php
$vocab["bookingsfor"]        = "Objedn�no pro";
$vocab["bookingsforpost"]    = ""; // Goes after the date
$vocab["areas"]              = "Oblasti";
$vocab["daybefore"]          = "Den vzad";
$vocab["dayafter"]           = "Den vp�ed";
$vocab["gototoday"]          = "Dnes";
$vocab["goto"]               = "P�ej�t na";
$vocab["highlight_line"]     = "Ozna�te tuto ��dku";
$vocab["click_to_reserve"]   = "Klepn�te na bu�ku, aby jste provedli rezervaci.";

// Used in trailer.inc
$vocab["viewday"]            = "Dny";
$vocab["viewweek"]           = "T�dny";
$vocab["viewmonth"]          = "M�s�ce ";
$vocab["ppreview"]           = "Pro tisk";

// Used in edit_entry.php
$vocab["addentry"]           = "P�idat z�znam";
$vocab["editentry"]          = "Editovat z�znam";
$vocab["editseries"]         = "Editovat s�rii";
$vocab["namebooker"]         = "Popis instrukce";
$vocab["fulldescription"]    = "Celkov� popis:<br>&nbsp;&nbsp;(Po�et cestuj�c�ch,<br>&nbsp;&nbsp;Obsazeno/Voln� m�sta atd)";
$vocab["date"]               = "Datum";
$vocab["start_date"]         = "Za��tek";
$vocab["end_date"]           = "Konec";
$vocab["time"]               = "�as";
$vocab["period"]             = "Perioda";
$vocab["duration"]           = "Doba trv�n�";
$vocab["seconds"]            = "sekundy";
$vocab["minutes"]            = "minuty";
$vocab["hours"]              = "hodiny";
$vocab["days"]               = "dny";
$vocab["weeks"]              = "v�kendy";
$vocab["years"]              = "roky";
$vocab["periods"]            = "period";
$vocab["all_day"]            = "V�echny dny";
$vocab["type"]               = "Typ";
$vocab["internal"]           = "Voln� m�sta";
$vocab["external"]           = "Obsazeno";
$vocab["save"]               = "Ulo�it";
$vocab["rep_type"]           = "Typ opakov�n�";
$vocab["rep_type_0"]         = "Nikdy";
$vocab["rep_type_1"]         = "Denn�";
$vocab["rep_type_2"]         = "T�dn�";
$vocab["rep_type_3"]         = "M�s��n�";
$vocab["rep_type_4"]         = "Ro�n�";
$vocab["rep_type_5"]         = "M�s��n�, jednou za m�s�c";
$vocab["rep_type_6"]         = "n-t�dn�";
$vocab["rep_end_date"]       = "Konec opakov�n�";
$vocab["rep_rep_day"]        = "Opakovat v den";
$vocab["rep_for_weekly"]     = "(pro (n-)t�dn�)";
$vocab["rep_freq"]           = "Frekvence";
$vocab["rep_num_weeks"]      = "�islo t�dne";
$vocab["rep_for_nweekly"]    = "(pro n-t�dn�)";
$vocab["ctrl_click"]         = "U��t CTRL pro v�b�r v�ce m�stnost�";
$vocab["entryid"]            = "Vstupn� ID ";
$vocab["repeat_id"]          = "ID pro opakov�n�"; 
$vocab["you_have_not_entered"] = "Nevlo�il jste";
$vocab["you_have_not_selected"] = "Nevybral jste";
$vocab["valid_room"]         = "prost�edek.";
$vocab["valid_time_of_day"]  = "platn� �asov� �sek dne.";
$vocab["brief_description"]  = "Kr�tk� popis.";
$vocab["useful_n-weekly_value"] = "pou�iteln� x-t�denn� hodnota.";

// Used in view_entry.php
$vocab["description"]        = "Popis";
$vocab["room"]               = "M�stnost";
$vocab["createdby"]          = "Vytvo�il u�ivatel";
$vocab["lastupdate"]         = "Posledn� zm�na";
$vocab["deleteentry"]        = "Smazat z�znam";
$vocab["deleteseries"]       = "Smazat s�rii";
$vocab["confirmdel"]         = "Jste si jist�\\nsmaz�n�m tohoto z�znamu?\\n\\n";
$vocab["returnprev"]         = "N�vrat na p�edchoz� str�nku";
$vocab["invalid_entry_id"]   = "�patn� ID z�znamu.";
$vocab["invalid_series_id"]  = "�patn� ID skupiny.";

// Used in edit_entry_handler.php
$vocab["error"]              = "Chyba";
$vocab["sched_conflict"]     = "Konflikt p�i pl�nov�n�";
$vocab["conflict"]           = "Nov� rezervace je v konfliktu s jin�m z�znamem";
$vocab["too_may_entrys"]     = "Vybran� volba byla vytvo�ena pro jin� z�znamy.<br>Pros�m vyberte jinou volbu!";
$vocab["returncal"]          = "N�vrat do kalend��e";
$vocab["failed_to_acquire"]  = "Chyba v�hradn�ho p��stupu do datab�ze"; 

// Authentication stuff
$vocab["accessdenied"]       = "P��stup zam�tnut";
$vocab["norights"]           = "Nem�te p��stupov� pr�vo pro zm�nu t�to polo�ky.";
$vocab["please_login"]       = "Pros�m, p�ihla�te se";
$vocab["users.name"]          = "Jm�no";
$vocab["users.password"]      = "Heslo";
$vocab["users.level"]         = "Pr�va";
$vocab["unknown_user"]       = "Nezn�m� u�ivatel";
$vocab["you_are"]            = "Jste";
$vocab["login"]              = "P�ihl�sit se";
$vocab["logoff"]             = "Odhl�sit se";

// Authentication database
$vocab["user_list"]          = "Seznam u�ivatel�";
$vocab["edit_user"]          = "Editovat u�ivatele";
$vocab["delete_user"]        = "Smazat tohoto u�ivatele";
//$vocab["users.name"]         = Use the same as above, for consistency.
//$vocab["users.password"]     = Use the same as above, for consistency.
$vocab["users.email"]         = "Emailov� adresa";
$vocab["password_twice"]     = "Pokud chcete zm�nit heslo, pros�m napi�te ho dvakr�t";
$vocab["passwords_not_eq"]   = "Chyba: Vlo�en� hesla se neshoduj�.";
$vocab["add_new_user"]       = "P�idat nov�ho u�ivatele";
$vocab["action"]             = "Akce";
$vocab["user"]               = "U�ivatel";
$vocab["administrator"]      = "Administr�tor";
$vocab["unknown"]            = "Nezn�m�";
$vocab["ok"]                 = "Ano";
$vocab["show_my_entries"]    = "Klepnout pro zobraz�n� v�ech nadch�zej�c�ch z�znam�";

// Used in search.php
$vocab["invalid_search"]     = "Pr�zdn� nebo neplatn� hledan� �et�zec.";
$vocab["search_results"]     = "V�sledek hled�n� pro";
$vocab["nothing_found"]      = "Nic nenalezeno";
$vocab["records"]            = "Z�znam";
$vocab["through"]            = " skrze ";
$vocab["of"]                 = " o ";
$vocab["previous"]           = "P�edchozi";
$vocab["next"]               = "Dal��";
$vocab["entry"]              = "Z�znam";
$vocab["view"]               = "N�hled";
$vocab["advanced_search"]    = "Roz���en� hled�n�";
$vocab["search_button"]      = "Hledat";
$vocab["search_for"]         = "Hledat co";
$vocab["from"]               = "Od";

// Used in report.php
$vocab["report_on"]          = "V�pis setk�n�";
$vocab["report_start"]       = "V�pis za��tk�";
$vocab["report_end"]         = "V�pis konc�";
$vocab["match_area"]         = "Hledan� oblast";
$vocab["match_room"]         = "Hledan� m�stnost";
$vocab["match_type"]         = "Hledan� typ";
$vocab["ctrl_click_type"]    = "U��t CTRL pro v�b�r v�ce typ�";
$vocab["match_entry"]        = "Hledat v popisu";
$vocab["match_descr"]        = "Hledat v cel�m popisu";
$vocab["include"]            = "Zahrnovat";
$vocab["report_only"]        = "Jen v�pis";
$vocab["summary_only"]       = "Jen p�ehled";
$vocab["report_and_summary"] = "V�pis a p�ehled";
$vocab["summarize_by"]       = "P�ehled od";
$vocab["sum_by_descrip"]     = "Popis instrukce";
$vocab["sum_by_creator"]     = "Tv�rce";
$vocab["entry_found"]        = "nalezeno";
$vocab["entries_found"]      = "nalezeno";
$vocab["summary_header"]     = "P�ehled  (z�znamu) hodiny";
$vocab["summary_header_per"] = "P�ehled  (z�znamu) periody";
$vocab["total"]              = "Celkem";
$vocab["submitquery"]        = "Vytvo�it sestavu";
$vocab["sort_rep"]           = "Se�adit v�pis podle";
$vocab["sort_rep_time"]      = "V�choz� den/�as";
$vocab["rep_dsp"]            = "Zobrazit ve v�pisu";
$vocab["rep_dsp_dur"]        = "Trv�n�";
$vocab["rep_dsp_end"]        = "�as ukon�en�";

// Used in week.php
$vocab["weekbefore"]         = "T�den dozadu";
$vocab["weekafter"]          = "T�den dop�edu";
$vocab["gotothisweek"]       = "Tento t�den";

// Used in month.php
$vocab["monthbefore"]        = "M�s�c dozadu";
$vocab["monthafter"]         = "M�sic dop�edu";
$vocab["gotothismonth"]      = "Tento m�s�c";

// Used in {day week month}.php
$vocab["no_rooms_for_area"]  = "Pro tuto m�stnost nen� definov�na �adn� oblast!";

// Used in admin.php
$vocab["edit"]               = "Editovat";
$vocab["delete"]             = "Smazat";
$vocab["rooms"]              = "M�stnosti";
$vocab["in"]                 = "v";
$vocab["noareas"]            = "��dn� oblasti";
$vocab["addarea"]            = "P�idat oblast";
$vocab["name"]               = "Jm�no";
$vocab["noarea"]             = "Nen� vybr�na ��dn� oblast";
$vocab["browserlang"]        = "Prohl�ec je nastaven k pou�it�";
$vocab["addroom"]            = "P�idat m�stnost";
$vocab["capacity"]           = "Kapacita";
$vocab["norooms"]            = "��dn� m�stnost.";
$vocab["administration"]     = "Administrace";

// Used in edit_area_room.php
$vocab["editarea"]           = "Editovat oblast";
$vocab["change"]             = "Zm�na";
$vocab["backadmin"]          = "N�vrat do administrace";
$vocab["editroomarea"]       = "Editovat popis oblasti nebo m�stnosti";
$vocab["editroom"]           = "Editovat m�stnosti";
$vocab["update_room_failed"] = "Chyba editace m�stnosti: ";
$vocab["error_room"]         = "Chyba: m�stnost ";
$vocab["not_found"]          = " nenalezen";
$vocab["update_area_failed"] = "Chyba editace oblasti: ";
$vocab["error_area"]         = "Chyba: oblast ";
$vocab["room_admin_email"]   = "Email administr�tora m�stnosti";
$vocab["area_admin_email"]   = "Email administr�tora oblasti";
$vocab["invalid_email"]      = "�patn� email!";

// Used in del.php
$vocab["deletefollowing"]    = "Bylo smaz�no rezervov�n�";
$vocab["sure"]               = "Jste si jist�?";
$vocab["YES"]                = "ANO";
$vocab["NO"]                 = "NE";
$vocab["delarea"]            = "Mus�te smazat v�echny m�stnosti v t�to oblasti p�edt�m ne� ji m��ete smazat<p>";

// Used in help.php
$vocab["about_cdma"]         = "O CDMA";
$vocab["database"]           = "Datab�ze";
$vocab["system"]             = "Syst�m";
$vocab["please_contact"]     = "Pros�m kontaktujte ";
$vocab["for_any_questions"]  = "pokud m�te n�jak� dal�� ot�zky.";

// Used in mysql.inc AND pgsql.inc
$vocab["failed_connect_db"]  = "Fataln� chyba: Nepoda�ilo se p�ipojit do datab�ze";

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
