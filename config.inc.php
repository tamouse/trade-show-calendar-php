<?php



/**************************************************************************
 *   CDMA Configuration File
 *   Configure this file for your site.
 *   You shouldn't have to modify anything outside this file
 *   (except for the lang.* files, eg lang.en for English, if
 *   you want to change text strings such as "Meeting Room
 *   Booking System", "room" and "event").
 **************************************************************************/


/*******************
 * Database settings
 ******************/
// Which database system: "pgsql"=PostgreSQL, "mysql"=MySQL,
// "mysqli"=MySQL via the mysqli PHP extension
$dbsys = "mysql";
// Hostname of database server. For pgsql, can use "" instead of localhost
// to use Unix Domain Sockets instead of TCP/IP.
$db_host = "localhost";
// Database name:
$db_database = "cdma";
// Database login user name:
$db_login = "root";
// Database login password:
$db_password = '';
// Prefix for table names.  This will allow multiple installations where only
// one database is available
$db_tbl_prefix = "cdma_";
// Uncomment this to NOT use PHP persistent (pooled) database connections:
// $db_nopersist = 1;


/* Add lines from systemdefaults.inc.php here to change the default
   configuration. Do _NOT_ modify systemdefaults.inc.php. */

/*********************************
 * Site identification information
 *********************************/
$cdma_admin = "CDMA Administrator";
$cdma_admin_email = "no-reply@cdmacalendar.com";  // NOTE:  there are more email addresses in $mail_settings below

// The company name is mandatory.   It is used in the header and also for email notifications.
// The company logo, additional information and URL are all optional.

$cdma_company = "CDMA Summit";   // This line must always be uncommented ($cdma_company is used in various places)

// Uncomment this next line to use a logo instead of text for your organisation in the header
$cdma_company_logo = "images/cdmablanklogo.png";    // name of your logo file.   This example assumes it is in the cdma directory

// Uncomment this next line for supplementary information after your company name or logo
unset($cdma_company_more_info);  // e.g. "XYZ Department"

// Uncomment this next line to have a link to your organisation in the header
$cdma_company_url = "index.php";

$display_app_title = FALSE; // use entire space for branding

/*******************
 * Themes
 *******************/

// Choose a theme for the cdma.   The theme controls two aspects of the look and feel:
//   (a) the styling:  the most commonly changed colours, dimensions and fonts have been 
//       extracted from the main CSS file and put into the styling.inc file in the appropriate
//       directory in the Themes directory.   If you want to change the colour scheme, you should
//       be able to do it by changing the values in the theme file.    More advanced styling changes
//       can be made by changing the rules in the CSS file.
//   (b) the header:  the header.inc file which contains the function used for producing the header.
//       This enables organisations to plug in their own header functions quite easily, in cases where
//       the desired corporate look and feel cannot be changed using the CSS alone and the mark-up
//       itself needs to be changed.
//
//  cdma will look for the files "styling.inc" and "header.inc" in the directory Themes/$theme and
//  if it can't find them will use the files in Themes/default.    A theme directory can contain
//  a replacement styling.inc file or a replacement header.inc file or both.

// Available options are:

// "default"        Default cdma theme
// "classic126"     Same colour scheme as mrbs 1.2.6

$theme = "cdma";


// TIMES SETTINGS
// --------------

// These settings are all set per area through cdma.   These are the default
// settings that are used when a new area is created.

// The "Times" settings are ignored if $enable_periods is TRUE.

// Note: Be careful to avoid specifying options that display blocks overlapping
// the next day, since it is not properly handled.

// Resolution - what blocks can be booked, in seconds.
// Default is half an hour: 1800 seconds.
$resolution = (60 * 60);  // DEFAULT VALUE FOR NEW AREAS

// If the following variable is set to TRUE, the resolution of bookings
// is forced to be the value of $resolution, rather than the resolution set
// for the area in the database.
$force_resolution = FALSE;

// Default duration - default length (in seconds) of a booking.
// Defaults to (60 * 60) seconds, i.e. an hour
$default_duration = (60 * 60);  // DEFAULT VALUE FOR NEW AREAS

// Start and end of day.
// NOTE:  The time between the beginning of the last and first
// slots of the day must be an integral multiple of the resolution,
// and obviously >=0.


// The default settings below (along with the 30 minute resolution above)
// give you 24 half-hourly slots starting at 07:00, with the last slot
// being 18:30 -> 19:00

// The beginning of the first slot of the day (DEFAULT VALUES FOR NEW AREAS)
$morningstarts         = 7;   // must be integer in range 0-23
$morningstarts_minutes = 0;   // must be integer in range 0-59

// The beginning of the last slot of the day (DEFAULT VALUES FOR NEW AREAS)
$eveningends           = 19;  // must be integer in range 0-23
$eveningends_minutes   = 00;   // must be integer in range 0-59

// Example 1.
// If resolution=3600 (1 hour), morningstarts = 8 and morningstarts_minutes = 30 
// then for the last period to start at say 4:30pm you would need to set eveningends = 16
// and eveningends_minutes = 30

// Example 2.
// To get a full 24 hour display with 15-minute steps, set morningstarts=0; eveningends=23;
// eveningends_minutes=45; and resolution=900.

// This is the maximum number of rows (timeslots or periods) that one can expect to see in the day
// and week views.    It is used by cdma.css.php for creating classes.    It does not matter if it
// is too large, except for the fact that more CSS than necessary will be generated.  (The variable
// is ignored if $times_along_top is set to TRUE).
$max_slots = 60;



/******************
 * Display settings
 ******************/

// [These are all variables that control the appearance of pages and could in time
//  become per-user settings]

// Determines whether to show the event selector (if false, assumes only one event in system at a time)
$display_events = FALSE;

// Determine whether to show the help link on the banner
$display_help = FALSE;


// should events be shown as a list or a drop-down select box?
//$event_list_format = "list";
$event_list_format = "select";

// Turn off row labeling altogether
$row_labels = FALSE;

// To display the column headers (times, rooms or days) on the bottom of the table as
// well as the top in the day and week views, set to TRUE;
$column_labels_both_ends = FALSE;
                                
/***********************************************
 * Authentication settings - read AUTHENTICATION
 ***********************************************/

$auth["session"] = "php"; // How to get and keep the user ID. One of
           // "http" "php" "cookie" "ip" "host" "nt" "omni"
           // "remote_user"

$auth["type"] = "db"; // How to validate the user/password. One of "none"
                          // "config" "db" "db_ext" "pop3" "imap" "ldap" "nis"
                          // "nw" "ext".

// Configuration parameters for 'cookie' session scheme

// The encryption secret key for the session tokens. You are strongly
// advised to change this if you use this session scheme
$auth["session_cookie"]["secret"] = "zRarU6W9GFkKqJjQuhEPyYOsBfATNLb0ewt";
// The expiry time of a session, in seconds
$auth["session_cookie"]["session_expire_time"] = (60*60*24*30); // 30 days
// Whether to include the user's IP address in their session cookie.
// Increases security, but could cause problems with proxies/dynamic IP
// machines
$auth["session_cookie"]["include_ip"] = TRUE;


// Configuration parameters for 'php' session scheme

// The expiry time of a session, in seconds
// N.B. Long session expiry times rely on PHP not retiring the session
// on the server too early. If you only want session cookies to be used,
// set this to 0.
$auth["session_php"]["session_expire_time"] = (60*60*24*30); // 30 days


// Cookie path override. If this value is set it will be used by the
// 'php' and 'cookie' session schemes to override the default behaviour
// of automatically determining the cookie path to use
$cookie_path_override = '';

// 'session_http' configuration settings
$auth["realm"]  = "cdma";

// 'auth_db' configuration settings
// The highest level of access (0=none; 1=user; 2+=admin).    Used in edit_users.php
// In the future we might want a higher level of granularity, eg to distinguish between
// different levels of admin
$max_level = 2;
// The lowest level of admin allowed to edit other users
$min_user_editing_level = 2;


/**********************************************
 * Email settings
 **********************************************/

// WHO TO EMAIL
// ------------
// The following settings determine who should be emailed when a booking is made,
// edited or deleted (though the latter two events depend on the "When" settings below).
// Set to TRUE or FALSE as required
// (Note:  the email addresses for the room and area administrators are set from the
// edit_area_room.php page in cdma)
$mail_settings['admin_on_bookings']         = FALSE;  // the addresses defined by $mail_settings['recipients'] below
$mail_settings['area_admin_on_bookings']    = FALSE;  // the area administrator
$mail_settings['room_admin_on_bookings']    = FALSE;  // the room administrator
$mail_settings['booker']                    = FALSE;  // the person making the booking
$mail_settings['book_admin_on_provisional'] = FALSE;  // the booking administrator when provisional bookings are enabled
                                                      // (which is the cdma admin, but this setting allows cdma
                                                      // to be extended to have separate booking approvers)     

// WHEN TO EMAIL
// -------------
// These settings determine when an email should be sent (an email is always sent for new
// bookings provided at least on of the "Who" settings above is set to TRUE).
// Set to TRUE or FALSE as required
$mail_settings['admin_on_delete'] = FALSE;  // when an entry is deleted
$mail_settings['admin_all']       = FALSE;  // edits as well as new bookings


// WHAT TO EMAIL
// -------------
// These settings determine what should be included in the email
// Set to TRUE or FALSE as required
$mail_settings['details'] = FALSE;  // Set to TRUE if you want full booking details;
                                    // otherwise you just get a link to the entry

// HOW TO EMAIL - CHARACTER SET AND LANGUAGE
// -----------------------------------------
// You can override the charset used in emails if $unicode_encoding is 1
// (utf-8) if you like, but be sure the charset you choose can handle all
// the characters in the translation and that anyone may use in a
// booking description
//$mail_charset = "iso-8859-1";

// Set the language used for emails (choose an available lang.* file).
$mail_settings['admin_lang'] = 'en';   // Default is 'en'.


// HOW TO EMAIL - ADDRESSES
// ------------------------
// The email addresses of the cdma administrator are set in the config file, and
// those of the room and area administrators are set though the edit_area_room.php
// in cdma.    But if you have set $mail_settings['booker'] above to TRUE, cdma will
// need the email addresses of ordinary users.   If you are using the "db" 
// authentication method then cdma will be able to get them from the users table.  But
// if you are using any other authentication scheme then the following settings allow
// you to specify a domain name that will be appended to the username to produce a
// valid email address (eg "@domain.com").
$mail_settings['domain'] = '';
// If you use $mail_settings['domain'] above and username returned by cdma contains extra
// strings appended like domain name ('username.domain'), you need to provide
// this extra string here so that it will be removed from the username.
$mail_settings['username_suffix'] = '';


// HOW TO EMAIL - BACKEND
// ----------------------
// Set the name of the backend used to transport your mails. Either 'mail',
// 'smtp' or 'sendmail'. Default is 'mail'. See INSTALL for more details.
$mail_settings['admin_backend'] = 'sendmail';

// EMAIL - MISCELLANEOUS
// ---------------------

// Set the email address of the From field. Default is 'admin_email@your.org'
$mail_settings['from'] = 'tamara@tamaratemple.com';

// Set the recipient email. Default is 'admin_email@your.org'. You can define
// more than one recipient like this "john@doe.com,scott@tiger.com"
$mail_settings['recipients'] = 'tamara@tamaratemple.com';

// Set email address of the Carbon Copy field. Default is ''. You can define
// more than one recipient (see 'recipients')
$mail_settings['cc'] = '';

// Set to TRUE if you want the cc addresses to be appended to the to line.
// (Some email servers are configured not to send emails if the cc or bcc
// fields are set)
$mail_settings['treat_cc_as_to'] = FALSE;



/**********
 * Language
 **********/

// Set this to 1 to use UTF-8 in all pages and in the database, otherwise
// text gets entered in the database in different encodings, dependent
// on the users' language
$unicode_encoding = 1;

// Set this to 1 to disable the automatic language changing cdma performs
// based on the user's browser language settings. It will ensure that
// the language displayed is always the value of $default_language_tokens,
// as specified below
$disable_automatic_language_changing = 0;

// Set this to a different language specifier to default to different
// language tokens. This must equate to a lang.* file in cdma.
// e.g. use "fr" to use the translations in "lang.fr" as the default
// translations.  [NOTE: it is only necessary to change this if you
// have disabled automatic language changing above]
$default_language_tokens = "en";

// Set this to a valid locale (for the OS you run the cdma server on)
// if you want to override the automatic locale determination cdma
// performs
$override_locale = "";

// faq file language selection. IF not set, use the default english file.
// IF your language faq file is available, set $faqfilelang to match the
// end of the file name, including the underscore (ie. for site_faq_fr.html
// use "_fr"
$faqfilelang = ""; 


/*************
 * Reports
 *************/
 
// Default CSV file names
$report_filename  = "report.csv";
$summary_filename = "summary.csv";

// CSV format
$csv_row_sep = "\n";  // Separator between rows/records
$csv_col_sep = ",";   // Separator between columns/fields



// This next section must come at the end of the config file - ie after any
// language and mail settings, as the definitions are used in the included file
require_once "language.inc";   // DO NOT DELETE THIS LINE

/*************
 * Entry Types
 *************/

// This array maps entry type codes (letters A through J) into descriptions.
//
// Each type has a color which is defined in the array $color_types in the Themes
// directory - just edit whichever include file corresponds to the theme you
// have chosen in the config settings. (The default is default.inc, unsurprisingly!)
//
// The value for each type is a short (one word is best) description of the
// type. The values must be escaped for HTML output ("R&amp;D").
// Please leave I and E alone for compatibility.
// If a type's entry is unset or empty, that type is not defined; it will not
// be shown in the day view color-key, and not offered in the type selector
// for new or edited entries.

// $typel["A"] = "A";
$typel["B"] = get_vocab("booked");
// $typel["C"] = "C";
// $typel["D"] = "D";
// $typel["E"] = get_vocab("external");
// $typel["F"] = "F";
// $typel["G"] = "G";
// $typel["H"] = "H";
// $typel["I"] = get_vocab("internal");
// $typel["J"] = "J";
$typel["O"] = get_vocab("open");

?>
