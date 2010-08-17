<?php 

/* Modified by Tamara Temple <tamara@tamaratemple.com> */
/*Converted from straight .css to .css.php $ */



header("Content-type: text/css"); 

require_once "systemdefaults.inc.php";
require_once "config.inc.php";
require_once "theme.inc";

                                
// IMPORTANT *************************************************************************************************
// In order to avoid problems in locales where the decimal point is represented as a comma, it is important to
//   (1) specify all PHP length variables as strings, eg $border_width = '1.5'; and not $border_width = 1.5;
//   (2) convert PHP variables after arithmetic using number_format
// ***********************************************************************************************************
                                
?>

/* Fixes for Internet Explorer (all versions) */


/* ------------ ADMIN.PHP ---------------------------*/
#admin ul {margin-top: 1.0em}
form.form_admin {margin-top: 0}
.form_admin legend {margin-bottom: 1.0em}   /* by default IE gives no gap between legend and first form element */

/* ------------ DAY/WEEK/MONTH.PHP ------------------*/
table.dwm_main {border-collapse: collapse}  /* separate gives better corners in Firefox,  but doesn't work in IE6/7 */
div.booking_list {overflow-x: hidden}       /* we don't want IE to give us the horizontal scrollbar */


/* ------------ FORM_GENERAL ------------------------*/
/*                                                   */
/*   used in EDIT_ENTRY.PHP and REPORT.PHP           */

.form_general legend {margin-bottom: 2.0em}   /* by default IE gives no gap between legend and first form element */
.form_general#edit_room legend {margin-bottom: 0}    /* no legend here, so we don't want the margin */
.form_general fieldset fieldset legend {margin-bottom: 5px}

/* margin-bottom on some form controls does not work, so put it on the relevant divs instead */
.form_general div#div_description, 
.form_general div#div_date,
.form_general div#div_period,
.form_general div#div_areas,
.form_general div#div_rooms,
.form_general div#div_type,
.form_general div#rep_end_date,
.form_general div#div_report_start,
.form_general div#div_report_end,
.form_general div#div_typematch {margin-bottom: 0.5em}

/* alignment of some inputs with labels is different in IE, so adjust */
.form_general input.radio {margin-top: -0.2em}
.form_general input.checkbox {margin-top: -0.2em}


/* ------------ EDIT_USERS.PHP ------------------*/
#form_edit_users legend {margin-bottom: 1.0em}   /* by default IE gives no gap between legend and first form element */

div.celldiv {overflow: hidden; margin: 0; padding: 0; height: 60px}

span.available {background-color: <?php echo $available_background_color; ?>;}
a.available {display: block; font-size: x-small; font-weight: normal; text-align: center; background-color: <?php echo $available_background_color ?>;}
.available img {margin: auto; padding: 4px 0 2px 0}
<?php
if (!$show_plus_link)
{
  echo ".available img {display: none}\n";
}
?>
.appointmentsettings {font-size: xx-small; font-weight:normal;}
span.new_slot {}
a.new_slot {display: block; font-size: x-small; font-weight:normal; text-align: center}
.new_slot img {margin: auto; padding: 4px 0 2px 0}
<?php
if (!show_plus_link)
{
	echo ".new_booking img {display: none}\n";
}
?>
span.booked {background-color: <?php echo $booked_background_color;?>;}
a.booked {display: block; font-size: x-small; font-weight:normal; font-style: italic; text-align: center; background-color: <?php echo $booked_background_color; ?>;}
.booked img {marging: auto; padding: 4px 0 2px 0}
<?php
if (!show_plus_link)
{
	echo ".booked img {display: none}\n";
}
?>