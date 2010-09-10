<?php

/**************************************************************************
 *   CDMA system defaults file
 *
 * DO _NOT_ MODIFY THIS FILE YOURSELF. IT FOR _INTERNAL_ USE ONLY.
 *
 * TO CONFIGURE CDMA FOR YOUR SYSTEM ADD CONFIGURATION PARAMETERS FROM
 * THIS FILE INTO config.inc.php, DO _NOT_ EDIT THIS FILE.
 *
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
$db_login = "cdma";
// Database login password:
$db_password = 'cdma-password';
// Prefix for table names.  This will allow multiple installations where only
// one database is available
$db_tbl_prefix = "cdma_";
// Uncomment this to NOT use PHP persistent (pooled) database connections:
// $db_nopersist = 1;

// Field lengths in the database tables
// NOTE:  these must be kept in step with the database.   If you change the field
// lengths in the database then you should change the values here, and vice versa.
$maxlength['entry.purpose']       = 80;  // characters   (purpose field in entry table)
$maxlength['event.event_name'] = 100; // characters   (name field in event table)
$maxlength['event.description'] = 1024; // characters (description field in event table)
$maxlength['room.room_name']   = 25;  // characters   (room_name field in room table)
$maxlength['room.room_number']   = 25;  // characters   (room_number field in room table)
$maxlength['room.description'] = 1024;  // characters   (description field in room table)
$maxlength['users.name']       = 30;  // characters   (name field in users table)
$maxlength['users.phone']      = 20;  // characters   (phone field in users table)
$maxlength['users.email']      = 75;  // characters   (email field in users table)
// other values for the users table need to follow the $maxlength['users.fieldname'] pattern


/*********************************
 * Site identification information
 *********************************/
$cdma_admin = "Your Administrator";
$cdma_admin_email = "admin_email@your.org";  // NOTE:  there are more email addresses in $mail_settings below

// The company name is mandatory.   It is used in the header and also for email notifications.
// The company logo, additional information and URL are all optional.

$cdma_company = "Your Company";   // This line must always be uncommented ($cdma_company is used in various places)

// Uncomment this next line to use a logo instead of text for your organisation in the header
//$cdma_company_logo = "your_logo.gif";    // name of your logo file.   This example assumes it is in the cdma directory

// Uncomment this next line for supplementary information after your company name or logo
//$cdma_company_more_info = "You can put additional information here";  // e.g. "XYZ Department"

// Uncomment this next line to have a link to your organisation in the header
//$cdma_company_url = "http://www.your_organisation.com/";

// This is to fix URL problems when using a proxy in the environment.
// If links inside cdma appear broken, then specify here the URL of
// your cdma root directory, as seen by the users. For example:
// $url_base =  "http://webtools.uab.ericsson.se/oam";
// It is also recommended that you set this if you intend to use email
// notifications, to ensure that the correct URL is displayed in the
// notification.
$url_base = "";


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
// "classic126"     Same colour scheme as cdma 1.2.6

$theme = "default";


/*******************
 * Calendar settings
 *******************/

// TIMES SETTINGS
// --------------

// These settings are all set per area through cdma.   These are the default
// settings that are used when a new area is created.

// The "Times" settings are ignored if $enable_periods is TRUE.

// Note: Be careful to avoid specifying options that display blocks overlapping
// the next day, since it is not properly handled.

// Resolution - what blocks can be booked, in seconds.
// Default is half an hour: 3600 seconds.
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
$eveningends_minutes   = 0;   // must be integer in range 0-59

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
$display_events = TRUE;

// Determine whether to show the help link on the banner
$display_help = TRUE;

// Start of week: 0 for Sunday, 1 for Monday, etc.
$weekstarts = 0;

// Determines whether to display the app title (allows using whole space for branding)
$display_app_title = TRUE;


// Trailer date format: 0 to show dates as "Jul 10", 1 for "10 Jul"
$dateformat = 0;
$date_format_str = "m-d-y"; // m-d-yy

// Full date format string
$full_date_format = "%A, %B %e, %Y"; // dddd, mmm d, yyyy: Friday, September 10, 2010

// Time format in pages. 0 to show dates in 12 hour format, 1 to show them
// in 24 hour format
$twentyfourhour_format = 1;
$time_format_str = "h:i A"; // H:MM AM

// Page refresh time (in seconds). Set to 0 to disable
$refresh_rate = 0;

// Trailer type.   FALSE gives a trailer complete with links to days, weeks and months before
// and after the current date.    TRUE gives a simpler trailer that just has links to the
// current day, week and month.
$simple_trailer = FALSE;

// should events be shown as a list or a drop-down select box?
//$event_list_format = "list";
$event_list_format = "select";

// To view weeks in the bottom (trailer.inc) as week numbers (42) instead of
// 'first day of the week' (13 Oct), set this to TRUE
$view_week_number = FALSE;

// To show row labels, set the following to true
$row_labels = TRUE;

// To display the row labels (times, rooms or days) on the right hand side as well as the 
// left hand side in the day and week views, set to TRUE;
// (was called $times_right_side in earlier versions of cdma)
$row_labels_both_sides = FALSE;

// To display the column headers (times, rooms or days) on the bottom of the table as
// well as the top in the day and week views, set to TRUE;
$column_labels_both_ends = FALSE;

// Define default room to start with (used by index.php)
// Room numbers can be determined by looking at the Edit or Delete URL for a
// room on the admin page.
// Default is 0
$default_room = 0;

// Define the maximum length of a string that can be displayed in an admin table cell
// (eg the rooms and users lists) before it is truncated.  (This is necessary because 
// you don't want a cell to contain for example a 2 kbyte text string, which could happen
// with user defined fields).
$max_content_length = 15;  // characters

// The maximum length of a database field for which a text input can be used on a form
// (eg when editing a user or room).  If longer than this a text area will be used.
$text_input_max = 70;  // characters
                                

/************************
 * Miscellaneous settings
 ************************/

// Default report span in days:
$default_report_days = 60;

// Pattern to use as placeholder for missing email addresses
$email_placeholder_pattern = '/\*\*\s*,?/';
$email_placeholder_string = '**'; // used in help message to display what will be matched as a replacement, without the trailing comma

$show_plus_link = FALSE;   // Change to TRUE to always show the (+) link

// Phone number match pattern
// International numbers:
$phone_number_pattern = '/^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/';
// US numbers:
// $phone_number_pattern = '/^(?:\([2-9]\d{2}\)\ ?|[2-9]\d{2}(?:\-?|\ ?))[2-9]\d{2}[- ]?\d{4}$/';

// Number of milliseconds to wait before timing out the page due to inactivity
$page_timeout = 1000 * 60 * 15; // 15 minutes
$page_timeout_warning_timeout = 1000 * 30; // 30 seconds


// Days of the week that are working days (Sunday = 0, etc.)
$working_days = array(1,2,3,4,5);  // Mon-Fri

/***********************************************
 * Authentication settings - read AUTHENTICATION
 ***********************************************/

$auth["session"] = "php"; // How to get and keep the user ID. One of
           // "http" "php" "cookie" "ip" "host" "nt" "omni"
           // "remote_user"

$auth["type"] = "config"; // How to validate the user/password. One of "none"
                          // "config" "db" "db_ext" "pop3" "imap" "ldap" "nis"
                          // "nw" "ext".

// Configuration parameters for 'cookie' session scheme

// The encryption secret key for the session tokens. You are strongly
// advised to change this if you use this session scheme
$auth["session_cookie"]["secret"] = "This isn't a very good secret!";
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

// The list of administrators (can modify other peoples settings).
//
// This list is not needed when using the 'db' authentication scheme EXCEPT
// when upgrading from a pre-cdma 1.4.2 system that used db authentication.
// Pre-1.4.2 the 'db' authentication scheme did need this list.   When running
// edit_users.php for the first time in a 1.4.2 system or later, with an existing
// users list in the database, the system will automatically add a field to
// the table for access rights and give admin rights to those users in the database
// for whom admin rights are defined here.   After that this list is ignored.
unset($auth["admin"]);              // Include this when copying to config.inc.php
$auth["admin"][] = "127.0.0.1";     // localhost IP address. Useful with IP sessions.
$auth["admin"][] = "administrator"; // A user name from the user list. Useful 
                                    // with most other session schemes.
//$auth["admin"][] = "10.0.0.1";
//$auth["admin"][] = "10.0.0.2";
//$auth["admin"][] = "10.0.0.3";

// 'auth_config' user database
// Format: $auth["user"]["name"] = "password";
$auth["user"]["administrator"] = "secret";
$auth["user"]["alice"] = "a";
$auth["user"]["bob"] = "b";

// 'session_http' configuration settings
$auth["realm"]  = "cdma";

// 'session_remote_user' configuration settings
//$auth['remote_user']['login_link'] = '/login/link.html';
//$auth['remote_user']['logout_link'] = '/logout/link.html';

// 'auth_ext' configuration settings
$auth["prog"]   = "";
$auth["params"] = "";

// 'auth_db' configuration settings
// The highest level of access (0=none; 1=user; 2+=admin).    Used in edit_users.php
// In the future we might want a higher level of granularity, eg to distinguish between
// different levels of admin
$max_level = 2;
// The lowest level of admin allowed to edit other users
$min_user_editing_level = 2;

// Password policy.  Uncomment the variables and set them to the
// required values as appropriate.
// $pwd_policy['length']  = 6;  // Minimum length
// $pwd_policy['alpha']   = 1;  // Minimum number of alpha characters
// $pwd_policy['lower']   = 1;  // Minimum number of lower case characters
// $pwd_policy['upper']   = 1;  // Minimum number of upper case characters
// $pwd_policy['numeric'] = 1;  // Minimum number of numeric characters
// $pwd_policy['special'] = 1;  // Minimum number of special characters (not alpha-numeric)


// 'auth_db_ext' configuration settings
// The 'db_system' variable is equivalent to the core cdma $dbsys variable,
// and allows you to use any of cdma's database abstraction layers for
// db_ext authentication.
$auth['db_ext']['db_system'] = 'mysql';
$auth['db_ext']['db_host'] = 'localhost';
$auth['db_ext']['db_username'] = 'authuser';
$auth['db_ext']['db_password'] = 'authpass';
$auth['db_ext']['db_name'] = 'authdb';
$auth['db_ext']['db_table'] = 'users';
$auth['db_ext']['column_name_username'] = 'name';
$auth['db_ext']['column_name_password'] = 'password';
// Either 'md5', 'sha1', 'crypt' or 'plaintext'
$auth['db_ext']['password_format'] = 'md5';

// 'auth_ldap' configuration settings
// Where is the LDAP server
//$ldap_host = "localhost";
// If you have a non-standard LDAP port, you can define it here
//$ldap_port = 389;
// If you do not want to use LDAP v3, change the following to false
$ldap_v3 = true;
// If you want to use TLS, change the following to true
$ldap_tls = false;
// LDAP base distinguish name
// See AUTHENTICATION for details of how check against multiple base dn's
//$ldap_base_dn = "ou=organizationalunit,dc=my-domain,dc=com";
// Attribute within the base dn that contains the username
//$ldap_user_attrib = "uid";
// If you need to search the directory to find the user's DN to bind
// with, set the following to the attribute that holds the user's
// "username". In Microsoft AD directories this is "sAMAccountName"
//$ldap_dn_search_attrib = "sAMAccountName";
// If you need to bind as a particular user to do the search described
// above, specify the DN and password in the variables below
// $ldap_dn_search_dn = "cn=Search User,ou=Users,dc=some,dc=company";
// $ldap_dn_search_password = "some-password";

// 'auth_ldap' extra configuration for ldap configuration of who can use
// the system
// If it's set, the $ldap_filter will be combined with the value of
// $ldap_user_attrib like this:
//   (&($ldap_user_attrib=username)($ldap_filter))
// After binding to check the password, this check is used to see that
// they are a valid user of cdma.
//$ldap_filter = "cdmauser=y";

// 'auth_imap' configuration settings
// See AUTHENTICATION for details of how check against multiple servers
// Where is the IMAP server
$imap_host = "imap-server-name";
// The IMAP server port
$imap_port = "143";

// 'auth_imap_php' configuration settings
$auth["imap_php"]["hostname"] = "localhost";
// You can also specify any of the following options:
// Specifies the port number to connect to
//$auth["imap_php"]["port"] = 993;
// Use SSL
//$auth["imap_php"]["ssl"] = TRUE;
// Use TLS
//$auth["imap_php"]["tls"] = TRUE;
// Turn off SSL/TLS certificate validation
//$auth["imap_php"]["novalidate-cert"] = TRUE;

// 'auth_pop3' configuration settings
// See AUTHENTICATION for details of how check against multiple servers
// Where is the POP3 server
$pop3_host = "pop3-server-name";
// The POP3 server port
$pop3_port = "110";

// 'auth_smtp' configuration settings
$auth['smtp']['server'] = 'myserver.example.org';

// General settings
// If you want only administrators to be able to book slots, set this
// variable to TRUE
$auth['only_admin_can_book'] = FALSE;
// If you want only administrators to be able to make repeat bookings,
// set this variable to TRUE
$auth['only_admin_can_book_repeat'] = FALSE;


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
$mail_settings['admin_backend'] = 'mail';

/*******************
 * Sendmail settings
 */
 
// Set the path of the Sendmail program (only used with "sendmail" backend).
// Default is '/usr/bin/sendmail'
$sendmail_settings['path'] = '/usr/bin/sendmail';
// Set additional Sendmail parameters (only used with "sendmail" backend).
// (example "-t -i"). Default is ''
$sendmail_settings['args'] = '';

/*******************
 * SMTP settings
 */

// These settings are only used with the "smtp" backend"
$smtp_settings['host'] = 'localhost';  // SMTP server
$smtp_settings['port'] = 25;           // SMTP port number
$smtp_settings['auth'] = FALSE;        // Whether to use SMTP authentication
$smtp_settings['username'] = '';       // Username (if using authentication)
$smtp_settings['password'] = '';       // Password (if using authentication)


// EMAIL - MISCELLANEOUS
// ---------------------

// Set the email address of the From field. Default is 'admin_email@your.org'
$mail_settings['from'] = 'admin_email@your.org';

// Set the recipient email. Default is 'admin_email@your.org'. You can define
// more than one recipient like this "john@doe.com,scott@tiger.com"
$mail_settings['recipients'] = 'admin_email@your.org';

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

// lengths of fields
$max_purpose_length_for_report = 80;
$max_organizer_length_for_report = 30;
$max_comment_length_for_report = 200;
$max_guest_list_length_for_report = 200;


/*************
 * Entry Types
 *************/

// This array maps entry type codes (letters A through J) into descriptions.
//
// This is a basic default array which ensures there are at least some types defined.
// The proper type definitions should be made in config.inc.php:  they have to go there
// because they use get_vocab which requires language.inc which uses settings which might
// be made in config.inc.php.
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

$typel = array();			// declare array

// $typel["A"] = "A";
// $typel["B"] = "B";
// $typel["C"] = "C";
// $typel["D"] = "D";
// $typel["E"] = "E";
// $typel["F"] = "F";
// $typel["G"] = "G";
// $typel["H"] = "H";
// $typel["I"] = "I";
// $typel["J"] = "J";


/***************************************
 * DOCTYPE - internal use, do not change
 ***************************************/

 define('DOCTYPE', '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">');
 
 // Records which DOCTYPE is being used.    Do not change - it will not change the DOCTYPE
 // that is used;  it is merely used when the code needs to know the DOCTYPE, for example
 // in calls to nl2br.   TRUE means XHTML, FALSE means HTML.
 define('IS_XHTML', FALSE);


/********************************************************
 * PHP System Configuration - internal use, do not change
 ********************************************************/

// Disable magic quoting on database returns:
set_magic_quotes_runtime(0);

// Make sure notice errors are not reported, they can break cdma code:
$error_level = E_ALL ^ E_NOTICE;
if (defined("E_DEPRECATED"))
{
  $error_level = $error_level ^ E_DEPRECATED;
}
error_reporting ($error_level);

?>
