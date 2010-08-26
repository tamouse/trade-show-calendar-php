<?php // -*-mode: PHP; coding:iso-8859-1;-*-

// $Id: lang.nl 1310 2010-03-21 20:46:30Z cimorrison $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is an NL Dutch file.
//
// Translations provided by: Marc ter Horst
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$vocab["charset"]            = "iso-8859-1";

// Used in style.inc
$vocab["mrbs"]               = "Vergaderruimte Boekingssysteem";

// Used in functions.inc
$vocab["report"]             = "Rapportage";
$vocab["admin"]              = "Beheer";
$vocab["help"]               = "Help";
$vocab["search"]             = "Zoek";
$vocab["not_php3"]           = "Waarschuwing: Werkt waarschijnlijk niet met PHP3";

// Used in day.php
$vocab["bookingsfor"]        = "Boekingen voor";
$vocab["bookingsforpost"]    = "";
$vocab["areas"]              = "Gebouwen";
$vocab["daybefore"]          = "Naar Vorige Dag";
$vocab["dayafter"]           = "Naar Volgende Dag";
$vocab["gototoday"]          = "Naar Vandaag";
$vocab["goto"]               = "ga naar";
$vocab["highlight_line"]     = "Markeer deze regel";
$vocab["click_to_reserve"]   = "Klik op dit vak om een reservering te maken.";

// Used in trailer.inc
$vocab["viewday"]            = "Bekijk Dag";
$vocab["viewweek"]           = "Bekijk Week";
$vocab["viewmonth"]          = "Bekijk Maand";
$vocab["ppreview"]           = "Afdruk Voorbeeld";

// Used in edit_entry.php
$vocab["addentry"]           = "Boeking Toevoegen";
$vocab["editentry"]          = "Boeking Wijzigen";
$vocab["copyentry"]          = "Kopiëer Boeking";
$vocab["editseries"]         = "Wijzig Reeks";
$vocab["copyseries"]         = "Kopiëer Serie";
$vocab["namebooker"]         = "Korte Omschrijving";
$vocab["fulldescription"]    = "Volledige Omschrijving:<br>&nbsp;&nbsp;(Aantal mensen,<br>&nbsp;&nbsp;Intern/Extern etc)";
$vocab["date"]               = "Datum";
$vocab["start_date"]         = "Start Tijd";
$vocab["end_date"]           = "Eind Tijd";
$vocab["time"]               = "Tijd";
$vocab["period"]             = "Periode";
$vocab["duration"]           = "Tijdsduur";
$vocab["seconds"]            = "seconden";
$vocab["minutes"]            = "minuten";
$vocab["hours"]              = "uren";
$vocab["days"]               = "dagen";
$vocab["weeks"]              = "weken";
$vocab["years"]              = "jaren";
$vocab["periods"]            = "Perioden";
$vocab["all_day"]            = "Hele Dag";
$vocab["type"]               = "Soort";
$vocab["internal"]           = "Intern";
$vocab["external"]           = "Extern";
$vocab["save"]               = "Opslaan";
$vocab["rep_type"]           = "Soort Herhaling";
$vocab["rep_type_0"]         = "Geen";
$vocab["rep_type_1"]         = "Dagelijks";
$vocab["rep_type_2"]         = "Wekelijks";
$vocab["rep_type_3"]         = "Maandelijks";
$vocab["rep_type_4"]         = "Jaarlijks";
$vocab["rep_type_5"]         = "Maandelijks, Overeenkomstige dag";
$vocab["rep_type_6"]         = "n-wekelijks";
$vocab["rep_end_date"]       = "Einde herhaling datum";
$vocab["rep_rep_day"]        = "Herhalingsdag";
$vocab["rep_for_weekly"]     = "(t.b.v. wekelijks)";
$vocab["rep_freq"]           = "Frequentie";
$vocab["rep_num_weeks"]      = "Aantal weken";
$vocab["rep_for_nweekly"]    = "(Voor n-wekelijks)";
$vocab["ctrl_click"]         = "Gebruik Control-Linker muis klik om meer dan 1 ruimte te reserveren";
$vocab["entryid"]            = "Boeking-ID ";
$vocab["repeat_id"]          = "Herhalings-ID "; 
$vocab["you_have_not_entered"] = "U heeft het volgende niet ingevoerd : ";
$vocab["you_have_not_selected"] = "U heeft het volgende niet geselecteerd : ";
$vocab["valid_room"]         = "kamer.";
$vocab["valid_time_of_day"]  = "geldige tijd.";
$vocab["brief_description"]  = "Korte Omschrijving.";
$vocab["useful_n-weekly_value"] = "bruikbaar n-wekelijks aantal.";

// Used in view_entry.php
$vocab["description"]        = "Omschrijving";
$vocab["room"]               = "Kamer";
$vocab["createdby"]          = "Aangemaakt door";
$vocab["lastupdate"]         = "Laatste aanpassing";
$vocab["deleteentry"]        = "Boeking verwijderen";
$vocab["deleteseries"]       = "Herhalingen verwijderen";
$vocab["confirmdel"]         = "Weet U zeker\\ndat U deze\\nBoeking wilt verwijderen?\\n\\n";
$vocab["returnprev"]         = "Terug naar vorige pagina";
$vocab["invalid_entry_id"]   = "Ongeldig Boeking-ID.";
$vocab["invalid_series_id"]  = "Ongeldig Herhalings-ID.";

// Used in edit_entry_handler.php
$vocab["error"]              = "Fout";
$vocab["sched_conflict"]     = "Overlappende Boeking";
$vocab["conflict"]           = "De nieuwe boeking overlapt de volgende boeking(en)";
$vocab["too_may_entrys"]     = "De door U geselecteerde opties zullen teveel boekingen genereren.<br>Pas A.U.B. uw opties aan !";
$vocab["returncal"]          = "Terug naar kalender overzicht";
$vocab["failed_to_acquire"]  = "Het is niet gelukt om exclusive toegang tot de database te verkrijgen"; 
$vocab["invalid_booking"]    = "Verkeerde boeking";
$vocab["must_set_description"] = "Er moet een korte omschrijving worden gegeven. Ga terug een en geef korte omschrijving.";
$vocab["mail_subject_entry"] = "Boeking toegevoegd/aangepast voor Uw Organisatie MRBS";
$vocab["mail_body_new_entry"] = "Er is een nieuwe boeking geplaatst, dit zijn de details:";
$vocab["mail_body_del_entry"] = "Er is een boeking verdwijderd, dit zijn de details:";
$vocab["mail_body_changed_entry"] = "Een boeking is gewijzigd, dit zijn de details:";
$vocab["mail_subject_delete"] = "Boeking gewist voor Uw Organisatie MRBS";

// Authentication stuff
$vocab["accessdenied"]       = "Geen Toegang";
$vocab["norights"]           = "U heeft geen rechten om deze boeking aan te passen.";
$vocab["please_login"]       = "Inloggen A.U.B";
$vocab["users.name"]          = "Naam";
$vocab["users.password"]      = "Wachtwoord";
$vocab["users.level"]         = "Rechten";
$vocab["unknown_user"]       = "Onbekende gebruiker";
$vocab["you_are"]            = "U bent";
$vocab["login"]              = "Inloggen";
$vocab["logoff"]             = "Uitloggen";

// Authentication database
$vocab["user_list"]          = "Gebruikerslijst";
$vocab["edit_user"]          = "Gebruiker aanpassen";
$vocab["delete_user"]        = "Deze gebruiker verwijderen";
//$vocab["users.name"]         = Use the same as above, for consistency.
//$vocab["users.password"]     = Use the same as above, for consistency.
$vocab["users.email"]         = "Email adres";
$vocab["password_twice"]     = "Als u het wachtwoord wilt wijzigen dient u het nieuwe wachtwoord tweemaal in te voeren.";
$vocab["passwords_not_eq"]   = "Fout: De wachtwoorden komen niet overeen.";
$vocab["add_new_user"]       = "Nieuwe gebruiker toevoegen";
$vocab["action"]             = "Handelingen";
$vocab["user"]               = "Gebruiker";
$vocab["administrator"]      = "Beheerder";
$vocab["unknown"]            = "Onbekend";
$vocab["ok"]                 = "OK";
$vocab["show_my_entries"]    = "Klikken om al mijn aankomende boekingen te tonen.";
$vocab["no_users_initial"]   = "Geen gebruiker in de database, aanmaken basis gebruiker toegestaan";
$vocab["no_users_create_first_admin"] = "Maak een gebruiker aan als administrator; daarna kun je inloggen en andere gebruikers aanmaken.";

// Used in search.php
$vocab["invalid_search"]     = "Niet bestaand of ongeldig zoek argument.";
$vocab["search_results"]     = "Zoek resultaten voor";
$vocab["nothing_found"]      = "Geen resultaten voor uw zoek opdracht gevonden.";
$vocab["records"]            = "Boekingregels ";
$vocab["through"]            = " tot en met ";
$vocab["of"]                 = " van ";
$vocab["previous"]           = "Vorige";
$vocab["next"]               = "Volgende";
$vocab["entry"]              = "Boeking";
$vocab["view"]               = "Overzicht";
$vocab["advanced_search"]    = "Uitgebreid Zoeken";
$vocab["search_button"]      = "Zoek";
$vocab["search_for"]         = "Zoeken naar";
$vocab["from"]               = "Van";

// Used in report.php
$vocab["report_on"]          = "Boekingsoverzicht";
$vocab["report_start"]       = "Start datum overzicht";
$vocab["report_end"]         = "Eind datum overzicht";
$vocab["match_area"]         = "Gebied als";
$vocab["match_room"]         = "Kamer als";
$vocab["match_type"]         = "Type als";
$vocab["ctrl_click_type"]    = "Gebruik Control-Linker muis klik om meer dan 1 type te selekteren";
$vocab["match_entry"]        = "Korte omschrijving als";
$vocab["match_descr"]        = "Volledige omschrijving als";
$vocab["include"]            = "Neem mee";
$vocab["report_only"]        = "Alleen overzicht";
$vocab["summary_only"]       = "Alleen samenvatting";
$vocab["report_and_summary"] = "Overzicht en samenvatting";
$vocab["summarize_by"]       = "Samenvatten volgens";
$vocab["sum_by_descrip"]     = "Korte omschrijving";
$vocab["sum_by_creator"]     = "Boeker";
$vocab["entry_found"]        = "boeking gevonden";
$vocab["entries_found"]      = "boekingen gevonden";
$vocab["summary_header"]     = "Totaal aan (geboekte) uren";
$vocab["summary_header_per"] = "Samenvatting van (Boekingen) Perioden";
$vocab["total"]              = "Totaal";
$vocab["submitquery"]        = "Rapport uitvoeren";
$vocab["sort_rep"]           = "Rapport sorteren op";
$vocab["sort_rep_time"]      = "Start Datum/Tijd";
$vocab["rep_dsp"]            = "Weergeven in rapport";
$vocab["rep_dsp_dur"]        = "Duur";
$vocab["rep_dsp_end"]        = "Eind Tijd";

// Used in week.php
$vocab["weekbefore"]         = "Ga naar vorige week";
$vocab["weekafter"]          = "Ga naar volgende week";
$vocab["gotothisweek"]       = "Ga naar deze week";

// Used in month.php
$vocab["monthbefore"]        = "Ga naar vorige maand";
$vocab["monthafter"]         = "Ga naar volgende maand";
$vocab["gotothismonth"]      = "Ga naar deze maand";

// Used in {day week month}.php
$vocab["no_rooms_for_area"]  = "Nog geen kamers gedefiniëerd voor dit gebouw";

// Used in admin.php
$vocab["edit"]               = "Wijzig";
$vocab["delete"]             = "Wis";
$vocab["rooms"]              = "Kamers";
$vocab["in"]                 = "in";
$vocab["noareas"]            = "Gebouwen";
$vocab["addarea"]            = "Gebouw toevoegen";
$vocab["name"]               = "Naam";
$vocab["noarea"]             = "Geen gebouw geselecteerd";
$vocab["browserlang"]        = "Uw browser is ingesteld op ";
$vocab["addroom"]            = "Kamer toevoegen";
$vocab["capacity"]           = "Zitplaatsen";
$vocab["norooms"]            = "Geen Kamers.";
$vocab["administration"]     = "Beheer";

// Used in edit_area_room.php
$vocab["editarea"]           = "Gebouw Wijzigen";
$vocab["change"]             = "Wijzig";
$vocab["backadmin"]          = "Terug naar Beheer";
$vocab["editroomarea"]       = "Gebouw of Kamer wijzigen";
$vocab["editroom"]           = "Kamer wijzigen";
$vocab["update_room_failed"] = "Wijzigen kamer mislukt: ";
$vocab["error_room"]         = "Fout: kamer ";
$vocab["not_found"]          = " niet gevonden";
$vocab["update_area_failed"] = "Wijzigen gebouw mislukt: ";
$vocab["error_area"]         = "Fout: gebouw ";
$vocab["room_admin_email"]   = "Kamer beheer email";
$vocab["area_admin_email"]   = "Gebouw beheer email";
$vocab["invalid_email"]      = "Ongeldig email adres !";

// Used in del.php
$vocab["deletefollowing"]    = "U gaat hiermee de volgende boekingen verwijderen";
$vocab["sure"]               = "Weet U het zeker?";
$vocab["YES"]                = "JA";
$vocab["NO"]                 = "NEE";
$vocab["delarea"]            = "U moet alle kamers in dit gebouw verwijderen voordat U het kunt verwijderen<p>";

// Used in help.php
$vocab["about_mrbs"]         = "Over MRBS";
$vocab["database"]           = "Database";
$vocab["system"]             = "Systeem";
$vocab["please_contact"]     = "Neem contact op met ";
$vocab["servertime"]         = "Datum en tijd op de Server";
$vocab["for_any_questions"]  = "Voor alle vragen die hier niet worden beantwoord.";

// Used in mysql.inc AND pgsql.inc
$vocab["failed_connect_db"]  = "Fatale Fout: Verbinding naar database server mislukt";

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
