<?php // -*-mode: PHP; coding:utf-8;-*-

// $Id: lang.sl 1310 2010-03-21 20:46:30Z cimorrison $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is a sl_SI Slovenian file.
// translated by Martin Terbuc 2007/02/24
//
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$vocab["charset"]            = "utf-8";

// Used in style.inc
$vocab["cdma"]               = "Prikaži urnike prostorov";

// Used in functions.inc
$vocab["report"]             = "Poročilo";
$vocab["admin"]              = "Admin";
$vocab["help"]               = "Pomoč";
$vocab["search"]             = "Išči";
$vocab["not_php3"]           = "OPOZORILO: Verjetno ne bo delovalo z PHP3";

// Used in day.php
$vocab["bookingsfor"]        = "Rezervacija za";
$vocab["bookingsforpost"]    = ""; // Goes after the date
$vocab["areas"]              = "Področja";
$vocab["daybefore"]          = "Prejšnji dan";
$vocab["dayafter"]           = "Naslednji dan";
$vocab["gototoday"]          = "Danes";
$vocab["goto"]               = "pojdi";
$vocab["highlight_line"]     = "Poudari to vrsto";
$vocab["click_to_reserve"]   = "Za dodajanje rezervacije klikni na celico.";

// Used in trailer.inc
$vocab["viewday"]            = "Pogled dan";
$vocab["viewweek"]           = "Pogled teden";
$vocab["viewmonth"]          = "Pogled mesec";
$vocab["ppreview"]           = "Predogled tiskanja";

// Used in edit_entry.php
$vocab["addentry"]           = "Dodaj vnos";
$vocab["editentry"]          = "Uredi vnos";
$vocab["copyentry"]          = "Kopiraj vnos";
$vocab["editseries"]         = "Uredi ponavljanja";
$vocab["copyseries"]         = "Kopiraj vrsto";
$vocab["namebooker"]         = "Kratek opis";
$vocab["fulldescription"]    = "Dolgi opis:<br>&nbsp;&nbsp;(Število oseb,<br>&nbsp;&nbsp;Interno/Zunanje, itd.)";
$vocab["date"]               = "Datum";
$vocab["start_date"]         = "Začetni čas";
$vocab["end_date"]           = "Končni čas";
$vocab["time"]               = "Čas";
$vocab["period"]             = "Ponavljajoč";
$vocab["duration"]           = "Trajanje (za decimalko uporabi piko)";
$vocab["seconds"]            = "sekund";
$vocab["minutes"]            = "minut";
$vocab["hours"]              = "ur";
$vocab["days"]               = "dni";
$vocab["weeks"]              = "tednov";
$vocab["years"]              = "let";
$vocab["periods"]            = "ponavljanj";
$vocab["all_day"]            = "Vse dni";
$vocab["type"]               = "Tip";
$vocab["internal"]           = "Interno";
$vocab["external"]           = "Zunanje";
$vocab["save"]               = "Shrani";
$vocab["rep_type"]           = "Način ponavljanja";
$vocab["rep_type_0"]         = "Brez";
$vocab["rep_type_1"]         = "Dnevno";
$vocab["rep_type_2"]         = "Tedensko";
$vocab["rep_type_3"]         = "Mesečno";
$vocab["rep_type_4"]         = "Letno";
$vocab["rep_type_5"]         = "Mesečno na pripadajoč dan v tednu";
$vocab["rep_type_6"]         = "n-tednov";
$vocab["rep_end_date"]       = "Datum konca ponavljanj";
$vocab["rep_rep_day"]        = "Ponavljaj dni";
$vocab["rep_for_weekly"]     = "(ponavljaj (n-tednov)";
$vocab["rep_freq"]           = "Frequenca";
$vocab["rep_num_weeks"]      = "Število tednov ";
$vocab["rep_for_nweekly"]    = "(za n-tednov)";
$vocab["ctrl_click"]         = "Uporabite Ctrl+klik za izbiro več prostorov";
$vocab["entryid"]            = "ID vnosa ";
$vocab["repeat_id"]          = "ID ponavljanj"; 
$vocab["you_have_not_entered"] = "Niste vnesli";
$vocab["you_have_not_selected"] = "Niste izbrali";
$vocab["valid_room"]         = "prostor.";
$vocab["valid_time_of_day"]  = "veljavne ure v dnevu.";
$vocab["brief_description"]  = "kratek opis.";
$vocab["useful_n-weekly_value"] = "prave vrednosti za n-tednov.";

// Used in view_entry.php
$vocab["description"]        = "Opis";
$vocab["room"]               = "Prostor";
$vocab["createdby"]          = "Vnesel";
$vocab["lastupdate"]         = "Zadnja sprememba";
$vocab["deleteentry"]        = "Izbriši vnos";
$vocab["deleteseries"]       = "Izbriši ponavljanja";
$vocab["confirmdel"]         = "Ste prepričani\\nda želite\\nizbrisati ta vnos?\\n\\n";
$vocab["returnprev"]         = "Vrni na prejšnjo stran";
$vocab["invalid_entry_id"]   = "Napačen vnos.";
$vocab["invalid_series_id"]  = "Napačen vnos ponavljanj.";

// Used in edit_entry_handler.php
$vocab["error"]              = "Napaka";
$vocab["sched_conflict"]     = "Konflikt rezervacij";
$vocab["conflict"]           = "Konflikt nove rezervacije z naslednjim(i) obsoječim(i)";
$vocab["too_may_entrys"]     = "Izbrane nastavitve bi ustvarile preveč vnosov.<br>Prosimo izvedite drugačno izbiro!";
$vocab["returncal"]          = "Vrnitev na pogled koledarja";
$vocab["failed_to_acquire"]  = "Napaka pri dostopu do baze";
$vocab["invalid_booking"]    = "Napačna rezervacija";
$vocab["must_set_description"] = "Vnesti morate kratek opis rezervacije. Prosimo vrnite se in jo vnesite.";
$vocab["mail_subject_entry"] = "Vnos dodan/spremenjen za vaš CDMA";
$vocab["mail_body_new_entry"] = "Dodan je bil nov vnos in tukaj so podrobnosti:";
$vocab["mail_body_del_entry"] = "Vnos je bil izbrisan in tukaj so podrobnosti:";
$vocab["mail_body_changed_entry"] = "Vnos je bil spremenjen in tukaj so podrobnosti:";
$vocab["mail_subject_delete"] = "Vnos za vaš CDMA je bil izbrisan";

// Authentication stuff
$vocab["accessdenied"]       = "Dostop zavrnjen";
$vocab["norights"]           = "Nimate pravice spreminjanja tega.";
$vocab["please_login"]       = "Prosim, prijavite se";
$vocab["users.name"]          = "Uporabniško ime";
$vocab["users.password"]      = "Geslo";
$vocab["users.level"]         = "Pravice";
$vocab["unknown_user"]       = "Neznan uporabnik";
$vocab["you_are"]            = "Prijavljen";
$vocab["login"]              = "Prijava";
$vocab["logoff"]             = "Odjava";

// Authentication database
$vocab["user_list"]          = "Spisek uporabnikov";
$vocab["edit_user"]          = "Uredi uporabnika";
$vocab["delete_user"]        = "Izbriši tega uporabnika";
//$vocab["users.name"]         = Use the same as above, for consistency.
//$vocab["users.password"]     = Use the same as above, for consistency.
$vocab["users.email"]         = "e-pošni naslov";
$vocab["password_twice"]     = "Če želite zamenjati geslo, ga vtipkajte dvakrat";
$vocab["passwords_not_eq"]   = "Napaka: Gesli se ne ujemata.";
$vocab["add_new_user"]       = "Dodaj novega uporabnika";
$vocab["action"]             = "Dejanja";
$vocab["user"]               = "Uporabnik";
$vocab["administrator"]      = "Administrator";
$vocab["unknown"]            = "Neznan";
$vocab["ok"]                 = "Vredu";
$vocab["show_my_entries"]    = "Kliknite za prikaz vseh prihodnjih dogodkov";
$vocab["no_users_initial"]   = "V bazi ni uporabnikov, kreiranje osnovnih";
$vocab["no_users_create_first_admin"] = "Ustvarite uporabnika konfiguriranega kakor administrator in se prijavite, da boste lahko dodajali uporabnike.";

// Used in search.php
$vocab["invalid_search"]     = "Prazen ali napačen iskalni niz.";
$vocab["search_results"]     = "Rezultati iskanja za";
$vocab["nothing_found"]      = "Ni najdenih vnosov niza.";
$vocab["records"]            = "Vnosi ";
$vocab["through"]            = " do ";
$vocab["of"]                 = " od ";
$vocab["previous"]           = "Predhodni";
$vocab["next"]               = "Naslednji";
$vocab["entry"]              = "Vnos";
$vocab["view"]               = "Poglej";
$vocab["advanced_search"]    = "Napredno iskanje";
$vocab["search_button"]      = "Išči";
$vocab["search_for"]         = "Iskanje";
$vocab["from"]               = "Od";

// Used in report.php
$vocab["report_on"]          = "Poročila vnosov";
$vocab["report_start"]       = "Začetni datum poročila";
$vocab["report_end"]         = "Končni datum poročila";
$vocab["match_area"]         = "Ujemanje niza iz opisa področij";
$vocab["match_room"]         = "Ujemanje niza iz opisa prostorov";
$vocab["match_type"]         = "Za tip";
$vocab["ctrl_click_type"]    = "Uporabi Ctrl+klik za izbiro več tipov.";
$vocab["match_entry"]        = "Ujemanje niz iz kratkega opisa";
$vocab["match_descr"]        = "Ujemanje niz iz dolgega opisa";
$vocab["include"]            = "Vključi";
$vocab["report_only"]        = "Samo vnose";
$vocab["summary_only"]       = "Samo pregled";
$vocab["report_and_summary"] = "Vnose in pregled";
$vocab["summarize_by"]       = "Pregled po";
$vocab["sum_by_descrip"]     = "Kratkem opisu";
$vocab["sum_by_creator"]     = "Po vnosniku";
$vocab["entry_found"]        = "najden vnos";
$vocab["entries_found"]      = "najdenih vnosov";
$vocab["summary_header"]     = "Pregled (vnosov) ur";
$vocab["summary_header_per"] = "Pregled (vnosov) ponavljanj";
$vocab["total"]              = "Skupaj";
$vocab["submitquery"]        = "Naredi poročilo";
$vocab["sort_rep"]           = "Uredi poročilo po";
$vocab["sort_rep_time"]      = "Začetni datum/ura";
$vocab["rep_dsp"]            = "V poročilu prikaži";
$vocab["rep_dsp_dur"]        = "Trajanje";
$vocab["rep_dsp_end"]        = "Začetni - končni čas";

// Used in week.php
$vocab["weekbefore"]         = "Prejšni teden";
$vocab["weekafter"]          = "Naslednji teden";
$vocab["gotothisweek"]       = "Ta teden";

// Used in month.php
$vocab["monthbefore"]        = "Prejšni mesec";
$vocab["monthafter"]         = "Naslednji mesec";
$vocab["gotothismonth"]      = "Ta mesec";

// Used in {day week month}.php
$vocab["no_rooms_for_area"]  = "Ni definiranih prostorov v tem področju";

// Used in admin.php
$vocab["edit"]               = "Uredi";
$vocab["delete"]             = "Izbriši";
$vocab["rooms"]              = "Prostori";
$vocab["in"]                 = "v";
$vocab["noareas"]            = "Ni področij";
$vocab["addarea"]            = "Dodaj področje";
$vocab["name"]               = "Ime";
$vocab["noarea"]             = "Ni izbranega področja";
$vocab["browserlang"]        = "Vaš brskalnik je nastavljen za uporabo ";
$vocab["addroom"]            = "Dodaj prostor";
$vocab["capacity"]           = "Število mest";
$vocab["norooms"]            = "Ni prostorov.";
$vocab["administration"]     = "Administracija";

// Used in edit_area_room.php
$vocab["editarea"]           = "Uredi področje";
$vocab["change"]             = "Uporabi";
$vocab["backadmin"]          = "Nazaj v Admin";
$vocab["editroomarea"]       = "Uredi opis področja ali prostora";
$vocab["editroom"]           = "Uredi prostor";
$vocab["update_room_failed"] = "Sprememba za prostor ni uspela: ";
$vocab["error_room"]         = "Napaka: prostor ";
$vocab["not_found"]          = " ne najdem";
$vocab["update_area_failed"] = "Ni uspela posodobitev področja: ";
$vocab["error_area"]         = "Napaka: področje ";
$vocab["room_admin_email"]   = "e-pošta upravnika prostora";
$vocab["area_admin_email"]   = "e-pošta upravnika področja";
$vocab["invalid_email"]      = "Napačen e-pošni naslov!";

// Used in del.php
$vocab["deletefollowing"]    = "Izbrisali boste naslednje vnose";
$vocab["sure"]               = "Ste prepričanie?";
$vocab["YES"]                = "Da";
$vocab["NO"]                 = "NE";
$vocab["delarea"]            = "Izbrisati morate vse prostore v področju, preden ga lahko izbrišete<p>";

// Used in help.php
$vocab["about_cdma"]         = "O CDMA";
$vocab["database"]           = "Podatkovna zbirka";
$vocab["system"]             = "Sistem";
$vocab["servertime"]         = "Čas strežnika";
$vocab["please_contact"]     = "Na dodatna vprašanja vam bo odgovoril ";
$vocab["for_any_questions"]  = ".";

// Used in mysql.inc AND pgsql.inc
$vocab["failed_connect_db"]  = "NAPAKA: ni se možno povezati v podatkovno bazo";

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
