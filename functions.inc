<?php

// Pop up an alert box
function js_alert($msg)
{
	echo "<script type=\"text/javascript\" charset=\"utf-8\">\n";
	echo "//<![CDATA[\n";
	echo "alert(\"$msg\");\n";
	echo " //]]>\n";	
	echo "</script>\n";
}

// Check to see if the current logged in user is an admin
function getAdmin()
{
	$user = getUserName();
	$required_level = (isset($max_level) ? $max_level : 2);
	$is_admin = (authGetUserLevel($user) >= $required_level);
	return $is_admin;
}

// Redirect current page to a new page
// Must be called before any content is written to the client
function redirect($url)
{
	header("Location: $url");
	exit;
}

$done_header = FALSE;

// Prints a very simple header.  This may be necessary on occasions, such as
// during a database upgrade, when some of the features that the normal
// header uses are not yet available.
function print_simple_header()
{
  global $done_header;
 
  if ($done_header)
  {
    return;
  } 
  
  header("Content-Type: text/html; charset=" . get_charset());
  header("Pragma: no-cache");                          // HTTP 1.0
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
  echo DOCTYPE;
 ?>

<html>
  <head>
    <?php
      require_once "style.inc";
    ?>
    <title><?php echo get_vocab("cdma") ?></title>
  </head>
  <body>
  <?php
  $done_header = TRUE; 
}

// Print the page header
function print_header($event_id, $day_id)
{
  global $theme, $done_header;
  
  if ($done_header)
  {
    return;
  }
  
  // Load the print_theme_header function appropriate to the theme.    If there
  // isn't one then fall back to the default header.
  @include_once "Themes/$theme/header.inc";
  if (!function_exists("print_theme_header"))
  {
    require_once "Themes/default/header.inc";
  }
  // Now go and do it
  print_theme_header($event_id, $day_id);
  $done_header = TRUE;
}



// Print the standard footer, currently very simple.  Pass $and_exit as
// TRUE to exit afterwards
function print_footer($and_exit)
{
?>
</body>
</html>
<?php
  if ($and_exit)
  {
    exit(0);
  }
}


function toTimeString(&$dur, &$units, $translate=TRUE)
{
  if (abs($dur) >= 60)
  {
    $dur /= 60;

    if (abs($dur) >= 60)
    {
      $dur /= 60;

      if((abs($dur) >= 24) && ($dur % 24 == 0))
      {
        $dur /= 24;

        if((abs($dur) >= 7) && ($dur % 7 == 0))
        {
          $dur /= 7;

          if ((abs($dur) >= 52) && ($dur % 52 == 0))
          {
            $dur  /= 52;
            $units = "years";
          }
          else
          {
            $units = "weeks";
          }
        }
        else
        {
          $units = "days";
        }
      }
      else
      {
        $units = "hours";
      }
    }
    else
    {
      $units = "minutes";
    }
  }
  else
  {
    $units = "seconds";
  }
  // Translate into local language if required
  if ($translate)
  {
    $units = get_vocab($units);
  }
}


// Converts a time period of $units into seconds, when it is originally
// expressed in $dur_units.   (Almost the inverse of toTimeString(),
// but note that toTimeString() can do language translation)
function fromTimeString(&$units, $dur_units)
{
  if (!isset($units) || !isset($dur_units))
  {
    return;
  }
  
  switch($dur_units)
  {
    case "years":
      $units *= 52;
    case "weeks":
      $units *= 7;
    case "days":
      $units *= 24;
    case "hours":
      $units *= 60;
    case "periods":
    case "minutes":
      $units *= 60;
    case "seconds":
      break;
  }
  $units = (int) $units;
}


function toPeriodString($start_period, &$dur, &$units, $translate=TRUE)
{
  global $periods;

  $max_periods = count($periods);

  $dur /= 60;

  if ( $dur >= $max_periods || $start_period == 0 )
  {
    if( $start_period == 0 && $dur == $max_periods )
    {
      $units = $translate ? get_vocab("days") : "days";
      $dur = 1;
      return;
    }

    $dur /= 60;
    if(($dur >= 24) && is_int($dur))
    {
      $dur /= 24;
      $units = $translate ? get_vocab("days") : "days";
      return;
    }
    else
    {
      $dur *= 60;
      $dur = ($dur % $max_periods) + floor( $dur/(24*60) ) * $max_periods;
      $units = $translate ? get_vocab("periods") : "periods";
      return;
    }
  }
  else
  {
    $units = $translate ? get_vocab("periods") : "periods";
  }
}

// Converts a period of $units starting at $start_period into seconds, when it is
// originally expressed in $dur_units (periods or days).   (Almost the inverse of
// toPeriodString(), but note that toPeriodString() can do language translation)
function fromPeriodString($start_period, &$units, $dur_units)
{
  global $periods;
  
  if (!isset($units) || !isset($dur_units))
  {
    return;
  }
  
  // First get the duration in minutes
  $max_periods = count($periods);
  if ($dur_units == "periods")
  {
    $end_period = $start_period + $units;
    if ($end_period > $max_periods)
    {
      $units = (24*60*floor($end_period/$max_periods)) + ($end_period%$max_periods) - $start_period;
    }
  }
  if ($dur_units == "days")
  {
    if ($start_period == 0)
    {
      $units = $max_periods + ($units-1)*60*24;
    }
    else
    {
      $units = $units * 60 * 24;
    }
  }
  
  // Then convert into seconds
  $units = (int) $units;
  $units = 60 * $units;
}

// format a time string from hours and minutes
function formatTime($hour, $minute)
{
	global $time_format_str; // from configuration files
	if (!isset($hour) || !isset($minute))
	{
		return '';
	}
	$t = mktime($hour, $minute);
	$time_string = date($time_format_str, $t);
	return $time_string;
}

// format a date string from day, month, year
function formatDate($day, $month, $year)
{
	global $date_format_str; // from configuration files
	if (!isset($day) || !isset($month) || !isset($year))
	{
		return '';
	}
	$t = mktime(0, 0, 0, $month, $day, $year);
	$date_string = date($date_format_str, $t);
	return $date_string;
}

// Convert a time string to hour and minute
function convertTimeToArray($time_str)
{
	if (empty($time_str))
	{
		return array(-1, -1);
	}
	$t = strtotime($time_str);
	if (!$t)
	{
		return array(-1, -1);
	}
	$t_array = getdate($t);
	$hour = $t_array['hours'];
	$minute = $t_array['minutes'];
	return array($hour, $minute);
}

// Convert a date string to month, day, year
function convertDateToArray($date_str)
{
	if (emptry($date_str))
	{
		return array(-1, -1, -1);
	}
	$t = strtotime($date_str);
	if (!$t)
	{
		return array(-1, -1, -1);
	}
	$d_array = getdate($t);
	$year = $d_array['year'];
	$month = $d_array['month'];
	$day = $d_array['day'];
	return array($month, $day, $year);
}

function genDateSelector($prefix, $day, $month, $year)
{
  if($day   == 0)
  {
    $day = date("d");
  }
  if($month == 0)
  {
    $month = date("m");
  }
  if ($year  == 0)
  {
    $year = date("Y");
  }
  
  echo "
                  <select name=\"${prefix}day\">";
   
  for ($i = 1; $i <= 31; $i++)
  {
    echo "
                    <option" . ($i == $day ? " selected=\"selected\"" : "") . ">$i</option>";
  }

  echo "
                  </select>

                  <select name=\"${prefix}month\" onchange=\"ChangeOptionDays(this.form,'$prefix')\">";

  for ($i = 1; $i <= 12; $i++)
  {
    $m = utf8_strftime("%b", mktime(0, 0, 0, $i, 1, $year));
      
    print "
                    <option value=\"$i\"" . ($i == $month ? " selected=\"selected\"" : "") . ">$m</option>";
  }

  echo "
                  </select>
             <select name=\"${prefix}year\" onchange=\"ChangeOptionDays(this.form,'$prefix')\">";

  $min = min($year, date("Y")) - 5;
  $max = max($year, date("Y")) + 5;

  for ($i = $min; $i <= $max; $i++)
  {
    print "
                    <option value=\"$i\"" . ($i == $year ? " selected=\"selected\"" : "") . ">$i</option>";
  }

  echo "
                  </select>";
}

// Error handler - this is used to display serious errors such as database
// errors without sending incomplete HTML pages. This is only used for
// errors which "should never happen", not those caused by bad inputs.
// If $need_header!=0 output the top of the page too, else assume the
// caller did that. Alway outputs the bottom of the page and exits.
function fatal_error($need_header, $message)
{
  if ($need_header)
  {
    print_header(0, 0);
  }
  echo "<p>$message</p>";
  require_once "trailer.inc";
  exit;
}

// Remove backslash-escape quoting if PHP is configured to do it with
// magic_quotes_gpc. Use this whenever you need the actual value of a GET/POST
// form parameter (which might have special characters) regardless of PHP's
// magic_quotes_gpc setting.
function unslashes($s)
{
  if (get_magic_quotes_gpc())
  {
    return stripslashes($s);
  }
  else
  {
    return $s;
  }
}



// Get the local day name based on language. Note 2000-01-02 is a Sunday.
function day_name($daynumber)
{
  return utf8_strftime("%A", mktime(0,0,0,1,2+$daynumber,2000));
}

function hour_min_format()
{
  global $twentyfourhour_format;
  if ($twentyfourhour_format)
  {
    return "%H:%M";
  }
  else
  {
    return "%I:%M%p";
  }
}

function period_date_string($t, $mod_time=0)
{
  global $periods;

  $time = getdate($t);
  $p_num = $time["minutes"] + $mod_time;
  if( $p_num < 0 )
  {
    $p_num = 0;
  }
  if( $p_num >= count($periods) - 1 )
  {
    $p_num = count($periods ) - 1;
  }
  // I have made the separater a ',' as a '-' leads to an ambiguious
  // display in report.php when showing end times.
  return array($p_num, $periods[$p_num] . utf8_strftime(", %A %d %B %Y",$t));
}

function period_time_string($t, $mod_time=0)
{
  global $periods;

  $time = getdate($t);
  $p_num = $time["minutes"] + $mod_time;
  if ( $p_num < 0 )
  {
    $p_num = 0;
  }
  if ( $p_num >= count($periods) - 1 )
  {
    $p_num = count($periods ) - 1;
  }
  return $periods[$p_num];
}

function time_date_string($t)
{
  global $twentyfourhour_format;

  if ($twentyfourhour_format)
  {
    return utf8_strftime("%H:%M:%S - %A %d %B %Y",$t);
  }
  else
  {
    return utf8_strftime("%I:%M:%S%p - %A %d %B %Y",$t);
  }
}

// version of the standard PHP function nl2br() that takes account of the fact
// that the optional second parameter is only available from PHP 5.3.0 onwards.
function cdma_nl2br($string)
{
  if (function_exists('version_compare') && version_compare(PHP_VERSION, '5.3.0', 'ge'))
  {
    return nl2br($string, IS_XHTML);
  }
  else
  {
    return nl2br($string);
  }
}

// Version of the standard PHP function html_entity_decode()
// Although html_entity_decode() was introduced in PHP 4.3.0, support for
// multi-byte character sets was only introduced in PHP 5.0.0.   
// So if we're running PHP5 or higher we'll use the standard
// PHP function; otherwise we'll do the best we can.   At the moment
// we just replace &nbsp; with an ordinary space, which
// should be sufficient in most CDMA circumstances.   This could
// always be extended later to do something more sophisticated if
// necessary.
function cdma_entity_decode($string)
{
  $n_args = func_num_args();
  if ($n_args > 1)
  {
    $quote_style = func_get_arg(1);
  }
  if ($n_args > 2)
  {
    $charset = func_get_arg(2);
  }
  
  if (function_exists('version_compare') && version_compare(PHP_VERSION, '5.0.0', 'ge'))
  {
    switch ($n_args)
    {
      case 3:
        $string = html_entity_decode($string, $quote_style, $charset);
        break;
      case 2:
        $string = html_entity_decode($string, $quote_style);
        break;
      default:
        $string = html_entity_decode($string);
        break;
    }  
  }
  else
  {
    $string = str_replace('&nbsp;', ' ', $string);
  }
  return $string;
}

// validates an hour of the day.
// must be between 0 and 23.
function validateHour($hour)
{
	return (((isset($hour)) && (is_numeric($hour)) && ($hour >= 0) && ($hour <= 23)) ? TRUE : FALSE);
}

// validates a minute of an hour
// must be between 0 and 59.
function validateMinute($minute)
{
	return (((isset($minute)) && (is_numeric($minute)) && ($minute >= 0) && ($minute <= 59)) ? TRUE : FALSE);
}

// validates a comma separated list of email addresses
// returns FALSE if any one of them is invalid, otherwise TRUE
function validate_email_list($list)
{
  require_once 'Mail/RFC822.php';
  (!isset($list)) ? $list = '': '';
  $emails = explode(',', $list);
  $email_validator = new Mail_RFC822();
  foreach ($emails as $email)
  {
    // if no email address is entered, this is OK, even if isValidInetAddress
    // does not return TRUE
    if ( !$email_validator->isValidInetAddress($email, $strict = FALSE)
         && ('' != $list) )
    {
      return FALSE;
    }
  }
  return TRUE;
}

// Strip the email place holders
function stripEmailPlaceholders($s)
{
	global $email_placeholder_pattern;
	$stripped = preg_replace($email_placeholder_pattern, '', $s);
	return $stripped;
}

// validates a phone number against a regular expression
// based on a configured phone number formats
function validate_phone($phone)
{
	global $phone_number_pattern;
	
	(!isset($phone) ? $phone = '' : '');
	if (!preg_match($phone_number_pattern, $phone) && '' != $phone)
	{
		return FALSE;
	}
	return TRUE;
}

// Output a start table cell tag <td> with color class.
// $colclass is an entry type (A-J), zebra stripes if
// empty or row_highlight if highlighted.
// $slots is the number of time slots high that the cell should be
function tdcell($colclass)
{
  echo "<td class=\"$colclass\"";
  if ($slots > 1)
  // No need to output more HTML than necessary
  {
    echo " " . (($times_along_top) ? "colspan" : "rowspan") . "=\"$slots\"";
  }
  echo ">\n";
}

// Display the entry-type color key. This has up to 2 rows, up to 5 columns
function show_colour_key()
{
  global $typel;
  // set the table width.   Default is 5, but try and avoid rows of unequal length
  switch (count($typel))
  {
    case '6':
      $table_width = 3;
      break;
    case '8':
    case '12':
      $table_width = 4;
      break;
    default:
      $table_width = 5;
  }
  echo "<table id=\"colour_key\"><tr>\n";
  $nct = 0;
  for ($ct = "A"; $ct <= "Z"; $ct++)
  {
    if (!empty($typel[$ct]))
    {
      if (++$nct > $table_width)
      {
        $nct = 1;
        echo "</tr><tr>";
      }
      tdcell($ct);
      echo "<div class=\"celldiv\" " .  // put the description inside a div which will give clipping in case of long names
      "title=\"$typel[$ct]\">\n";        // but put the name in the title so you can still read it all if you hover over it
      echo "$typel[$ct]</div></td>\n";
    }
  }
  // If there is more than one row and the bottom row isn't complete then 
  // pad it out with a single merged cell
  if ((count($typel) > $table_width) && ($nct < $table_width))
  {
    echo "<td colspan=\"" . ($table_width - $nct) . "\"" .
        " id=\"row_padding\">&nbsp;</td>\n";
  }
  echo "</tr></table>\n";
}

// Round time down to the nearest resolution
function round_t_down($t, $resolution, $am7)
{
  return (int)$t - (int)abs(((int)$t-(int)$am7)
                            % $resolution);
}

// Round time up to the nearest resolution
function round_t_up($t, $resolution, $am7)
{
  if (($t-$am7) % $resolution != 0)
  {
    return $t + $resolution - abs(((int)$t-(int)
                                   $am7) % $resolution);
  }
  else
  {
    return $t;
  }
}

// generate some html to allow selection of the current event
function make_event_selector_html($event_id, $room_id, $day_id, $show_edit_buttons)
{
	global $tbl_event;
	$out_html = "<div id=\"event_form\">\n";
	$sql = "select id, event_name from $tbl_event order by event_name";
	$res = sql_query($sql);
	if ($res == -1) fatal_error(0, "select from $tbl_event failed: " . sql_error());
	$events_defined = $res && (sql_count($res) > 0);
	if ($events_defined)
	{
	  // If there are some events defined, then show the event form
	  $out_html .= "<form id=\"eventChangeForm\" method=\"get\" action=\"$PHP_SELF\">\n";
	  $out_html .= "<fieldset>\n";
	  $out_html .= "<legend></legend>\n";

	  // The event selector
	  $out_html .= "<label id=\"event_label\" for=\"event_select\">" . get_vocab("event") . ":</label>\n";
	  $out_html .= "<select class=\"room_event_select\" id=\"event_select\" name=\"event_id\" onchange=\"this.form.submit()\">";
	  for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
	  {
	    $selected = ($row['id'] == $event_id) ? "selected=\"selected\"" : "";
	    $out_html .= "<option $selected value=\"". $row['id']. "\">" . htmlspecialchars($row['event_name']) . "</option>";
	  }
	  $out_html .= "</select>\n";

	  // Some hidden inputs for current day, room
	  $out_html .= "<input type=\"hidden\" name=\"day_id\" value=\"$day_id\">\n";
	  $out_html .= "<input type=\"hidden\" name=\"room_id\" value=\"$room_id\">\n";


	  // The change event button (won't be needed or displayed if JavaScript is enabled)
	  $out_html .= "<input type=\"submit\" name=\"change\" class=\"js_none\" value=\"" . get_vocab("change") . "\">\n";

	  // If they're an admin then give them edit and delete buttons for the event
	  // and also a form for adding a new event
	  if ($show_edit_buttons)
	  {
	    // Can't use <button> because IE6 does not support those properly
	    $out_html .= "<input type=\"image\" class=\"button\" name=\"edit\" src=\"images/edit.png\"
	           title=\"" . get_vocab("edit") . "\" alt=\"" . get_vocab("edit") . "\">\n";
	    $out_html .= "<input type=\"image\" class=\"button\" name=\"delete\" src=\"images/delete.png\"
	           title=\"" . get_vocab("delete") . "\" alt=\"" . get_vocab("delete") . "\">\n";
	  }

	  $out_html .= "</fieldset>\n";
	  $out_html .= "</form>\n";
	}
	else
	{
	  $out_html .= "<h2>" . get_vocab("noevents") . "</h2>\n";
	}
	$out_html .= "</div>"; // end event_form
	return $out_html;
}

// Form for changing days in an event
function make_day_selector_html($event_id, $room_id, $day_id, $mode)
{
	global $tbl_day;
	echo "<div class=\"day_selector\">\n";
	$sql = "select id, day_string from $tbl_day where event_id=$event_id order by year, month, day";
	$res = sql_query($sql);
	if ($res == -1) fatal_error(0, "select from $tbl_day failed: " . sql_error());
	$days_defined = $res && (sql_count($res) > 0);
	if ($days_defined)
	{
		// If there are some days defined, then show the days as tabs across the top of the page
		echo "<table class=\"day_selector_table\">\n";
		echo "<tr class=\"day_selector_row\">\n";
		for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
		{
			$selected = ($row['id'] == $day_id) ? "selected" : "unselected"; // define tab's subclass
			$location = $PHP_SELF . "?event_id=" . $event_id . "&room_id=" . $room_id . "&day_id=" . $row['id'] . "&mode=" . $mode;
			echo "<td class=\"day_selector_cell " . $selected . "\" >\n";
			echo "<a class=\"day_selector_link\" href=\"" . $location . "\" >" . $row['day_string'] . "</a>\n";
			echo "</td>\n";
		}
		echo "</tr></table>\n";
	}
	else
	{
		echo "<h2>" . get_vocab("nodays") . "</h2>\n";
	}
	echo "</div>\n"; // end div day_selector
}


// This will return the appropriate value for isdst for mktime().
// The order of the arguments was chosen to match those of mktime.
// hour is added so that this function can when necessary only be
// run if the time is between midnight and 3am (all DST changes
// occur in this period.
function is_dst ( $month, $day, $year, $hour="-1" )
{
  if ( $hour != -1  && $hour > 3)
  {
    return( -1 );
  }
   
  // entering DST
  if( !date( "I", mktime(12, 0, 0, $month, $day-1, $year)) && 
      date( "I", mktime(12, 0, 0, $month, $day, $year)))
  {
    return( 0 ); 
  }

  // leaving DST
  else if( date( "I", mktime(12, 0, 0, $month, $day-1, $year)) && 
           !date( "I", mktime(12, 0, 0, $month, $day, $year)))
  {
    return( 1 );
  }
  else
  {
    return( -1 );
  }
}

// if crossing dst determine if you need to make a modification
// of 3600 seconds (1 hour) in either direction
function cross_dst ( $start, $end )
{
  // entering DST
  if ( !date( "I", $start) &&  date( "I", $end))
  {
    $modification = -3600;
  }

  // leaving DST
  else if(  date( "I", $start) && !date( "I", $end))
  {
    $modification = 3600;
  }
  else
  {
    $modification = 0;
  }

  return $modification;
}

// If $time falls on a non-working day, shift it back to the end of the last 
// working day before that
function shift_to_workday($time)
{
  global $working_days;
  
  $dow = date('w', $time);  // get the day of the week
  $skip_back = 0;           // number of days to skip back
  // work out how many days to skip back to get to a working day
  while (!in_array($dow, $working_days))
  {
    if ($skip_back == 7)
    {
      break;
    }
    $skip_back++;
    $dow = ($dow + 6) % 7;  // equivalent to skipping back a day
  }
  if ($skip_back != 0)
  {
    // set the time to the end of the working day
    $d = date('j', $time) - $skip_back;
    $m = date('n', $time);
    $y  = date('Y', $time);
    $time = mktime(23, 59, 59, $m, $d, $y);
  }
  return $time;
}
  
// Returns the difference in seconds between two timestamps, $now and $then
// It gives $now - $then, less any seconds that were part of a non-working day
function working_time_diff($now, $then)
{
  global $working_days;
  
  // Deal with the easy case
  if ($now == $then)
  {
    return 0;
  }
  // Sanitise the $working_days array in case it was malformed
  $working_week = array_unique(array_intersect(array(0,1,2,3,4,5,6), $working_days));
  $n_working_days = count($working_week);
  // Deal with the special case where there are no working days
  if ($n_working_days == 0)
  {
    return 0;
  }
  // and the special case where there are no holidays
  if ($n_working_days == 7)
  {
    return ($now - $then);
  }

  // For the rest we're going to assume that $last comes after $first
  $last = max($now, $then);
  $first = min($now, $then);
  
  // first of all, if $last or $first fall on a non-working day, shift
  // them back to the end of the last working day
  $last = shift_to_workday($last);
  $first = shift_to_workday($first);
  // So calculate the difference
  $diff = $last - $first;
  // Then we have to deduct all the non-working days in between.   This will be
  // (a) the number of non-working days in the whole weeks between them +
  // (b) the number of non-working days in the part week
  
  // First let's calculate (a)
  $last = mktime(12, 0, 0, date('n', $last), date('j', $last), date('Y', $last));
  $first = mktime(12, 0, 0, date('n', $first), date('j', $first), date('Y', $first));
  $days_diff = (int) round(($last - $first)/(60*60*24));  // the difference in days
  $whole_weeks = (int) floor($days_diff/7);  // the number of whole weeks between the two
  $non_working_days = $whole_weeks * (7 - $n_working_days);
  // Now (b), ie we just have to calculate how many non-working days there are between the two
  // days of the week that are left
  $last_dow = date('w', $last);
  $first_dow = date('w', $first);
  
  while ($first_dow != $last_dow)
  {
    $first_dow = ($first_dow + 1) % 7;
    if (!in_array($first_dow, $working_week))
    {
      $non_working_days++;
    }
  }

  // So now subtract the number of weekend seconds
  $diff = $diff - ($non_working_days * 60*60*24);
  
  // Finally reverse the difference if $now was in fact before $then
  if ($now < $then)
  {
    $diff = -$diff;
  }
  
  return (int) $diff;
}

// checks whether a given day of the week is supposed to be hidden in the display
function is_hidden_day ($dow)
{
  global $hidden_days;
  return (isset($hidden_days) && in_array($dow, $hidden_days));
}

function draw_cell($cell, $query_strings, $mode)
{
  // draws a single cell in the main table of the day or slot view
  //
  // $cell is aan array that looks like this:
  // 
  // $cell[id]
  //      [event_id]
  //      [day_id]
  //      [room_id]
  //      [start_time]
  //      [user_id]
  //      [purpose]
  //
  //  
  // $query_strings is an array containg the query strings (or partial query strings) to be
  // appended to the link used for the cell.    It is indexed as follows:
  //    ['new_slot']   the string to be used for an empty cell if there is no slot
  //    ['new_booking']     the string to be used for an empty cell if there is a slot
  //    ['view_booking']       the string to be used for a full cell
  //
  // $mode specifies whether this is editing appointments or slots
  //
  // $cell_class specifies the default class for the cell (odd_row, even_row or row_highlight)
  // so that the zebra stripes can be drawn, or else to allow the whole row to be highlighted.
  
	$is_admin = getAdmin();
	$current_user = getUserName();
	$current_user_rec = get_user_from_user_name($current_user);
	$current_user_id = $current_user_rec['id'];
    
	// Don't need to change anything here to use this in either mode
	if(isset($cell) && ($cell != 0))
	{       
		$id         = $cell["id"];
		$event_id	= $cell["event_id"];
		$day_id		= $cell["day_id"];
		$room_id	= $cell["room_id"];
		$start_hour	= $cell["start_hour"];
		$start_minute = $cell["start_minute"];
		if (isset($cell["user_id"]) && $cell['user_id'] > 0)
		{
			$user_id	= $cell["user_id"];
			$descr		= $cell["purpose"];
			$descr = get_vocab('booked')
				. "<br/><span class=\"appointmentsettings\">(" . formatTime($start_hour, $start_minute) . " to<br />" . formatTime($cell["end_hour"],$cell["end_minute"]) . ")</span>";
			$cell_class = ($current_user_id == $cell['user_id'] ? 'booked_mine' : 'booked');
		}
		else
		{
			unset($user_id);
			$descr		= get_vocab('available')
				. "<br/><span class=\"appointmentsettings\">(" . formatTime($start_hour, $start_minute) . " to<br />" . formatTime($cell["end_hour"],$cell["end_minute"]) . ")</span>";
			$cell_class = 'available';
		}
	}
	else  // cell not set
	{
		unset($id);
		$descr = get_vocab('noslot');
		$cell_class = 'no_slot';
   }

	

	echo "<td class=\"$cell_class\">";
	echo "<div class=\"celldiv\">\n";
	  

	if (!isset($id)) // no slot
	{
		
		if ($mode)
		{
			echo "<a class=\"$cell_class\" href=\"edit_slot.php?" . $query_strings['new_slot'] . "\">";
			echo $descr;
			echo "</a>\n";
		}
	}
	else if (!isset($user_id)) // open slot, no booking
	{
		if ($mode)
		{
			// allow for admin to delete an available slot
			echo "<a class=\"$cell_class\" href=\"edit_slot.php?id=$id&" . $query_strings['new_slot'] . "\">";
			echo $descr;
			echo "</a>\n";
		}
		else
		{
			echo "<a class=\"$cell_class\" href=\"edit_entry.php?id=$id&" . $query_strings['new_booking'] . "\">";
			echo $descr;
			echo "</a>\n";
		}
	}
    else                 // if it is booked then show the booking
	{
		echo "<a class=\"$cell_class\" href=\"edit_entry.php?id=$id&". $query_strings['view_booking'] . "\">$descr</a>\n";
	}
	echo "</div>\n";
	
	echo "</td>\n";
}  // end function draw_cell

// shortens a string so that it will display in a cell
function truncateToDisplay($text,$limit)
{
	if (!isset($limit) || $limit < 1) return $text;
	$sstr = substr($text, 0, $limit);
	$sstr .= (strlen($text) > $limit) ? " ..." : "";
	return $sstr;
}

// Draw a time cell to be used in the first and last columns of the day view
//   $hour - hour of the day
//   $minute - minute of the hour
function draw_time_cell($hour, $minute)
{
	echo "<td class=\"row_labels\">\n";
	echo "<div class=\"celldiv\">";
    echo $hour . ":" . $minute;
	echo "</div></td>\n";
}


/// SQL Functions

// get_first_event() - retrieve the first event in the data base
//
// returns: id of first event
function get_first_event()
{
	global $tbl_event;
	$sql = "SELECT id FROM $tbl_event ORDER BY id LIMIT 1;";
	
	$event_id = sql_query1($sql);
	$event_id =  ((!isset($event_id) || ($event_id < 0)) ? 0 : $event_id);
	return $event_id;
  
}

// get_event_from_id($event_id) - retrieve the given event by id
//
// Paramters:
//   $event_id - the id of the event to retrieve
//
// Returns:
//   $row[name]
//       [description]
//
function get_event_from_id($event_id)
{
	global $tbl_event;
	if (isset($event_id))
	{
		$sql = "SELECT event_name, event_description FROM $tbl_event WHERE id = $event_id;";
		$res = sql_query($sql);
		if (! $res)
		{
			fatal_error(0, sql_error());
		}
		$row = sql_row_keyed($res, 0);
		return $row;
	}
	else
	{
		return 0;
	}
}

// get_first_day_for_event($event_id) - get the first day of an event
//
// Parameters:
//   $event_id - id of the event
//
// Returns:
//   id of the day entry
function get_first_day_for_event($event_id)
{
	global $tbl_day;
	if (isset($event_id))
	{
		$sql = "SELECT id FROM $tbl_day WHERE event_id = $event_id LIMIT 1";
		$day_id = sql_query1($sql);
		return ((!isset($day_id) || ($day_id < 0)) ? 0 : $day_id);
	  
	}
}


// get_day_from_id($day_id) - get the day record from the day id
//
// Parameters:
//   $day_id - id of the day record
//
// Returns:
//   $row[day]
//       [month]
//       [year]
//
function get_day_from_id($day_id)
{
	global $tbl_day;
	if (isset($day_id))
	{
		$sql = "SELECT day, month, year FROM $tbl_day WHERE id = $day_id;";
		$res = sql_query($sql);
		if (!$res)
		{
			return sql_row_keyed($res,0);
		}
	}
}

// get_event_from_day - get the event for the given day
function get_event_from_day($day_id)
{
	global $tbl_day;
	if (isset($day_id))
	{	
		$sql = "SELECT event_id FROM $tbl_day WHERE id = $day_id LIMIT 1";
		$event_id = sql_query1($sql);
		return ((!isset($event_id) || ($event_id < 0)) ? 0 : $event_id);
	}
}

// get_event_from_room - get the event for the given room
function get_event_from_room($room_id)
{
	global $tbl_room;
	if (isset($room_id))
	{	
		$sql = "SELECT event_id FROM $tbl_room WHERE id = $room_id LIMIT 1";
		$event_id = sql_query1($sql);
		return ((!isset($event_id) || ($event_id < 0)) ? 0 : $event_id);
	}
}

// get an entry by the event, day, room, hour, and minute
function get_entry_by_event_day_room($event_id, $day_id, $room_id, $hour, $minute)
{
	global $tbl_entry;
	if (isset($event_id) && isset($day_id) && isset($room_id) && isset($hour) && isset($minute))
	{
		$sql = "SELECT * FROM $tbl_entry WHERE event_id=$event_id AND day_id=$day_id AND room_id=$room_id AND start_hour=$hour AND start_minute=$minute LIMIT 1";
		$res = sql_query($sql);
		if (!$res) return 0;
		$row = sql_row_keyed($res, 0);
		return $row;
		
	}
}

// get a user's id based on user name
function getUserIDByName($user)
{
	global $tbl_users;
	if (empty($user)) return 0;
	$sql = "SELECT id FROM $tbl_users WHERE name='" . addslashes($user) . "' LIMIT 1";
	$user_id = sql_query1($sql);
	return (($user_id < 1) ? 0 : $user_id);
}

// get user's name based on their id
function get_user_name($id)
{
	global $tbl_users;
	if (isset($id) && $id > 0) {
		$sql = "SELECT name FROM $tbl_users WHERE id=$id";
		$name = sql_query1($sql);
		return (is_numeric($name) && $name < 0 ? '' : $name);
	}
}

// get the event name by the event's id
function get_event_name_by_id($id)
{
	global $tbl_event;
	if (isset($id) && $id > 0)
	{
		$sql = "SELECT event_name FROM $tbl_event WHERE id=$id LIMIT 1";
		$event_name = sql_query1($sql);
		if (empty($event_name) || $event_name <0)
		{
			fatal_error(0, "Event with no name: id=$id");
		}
		return $event_name;
	}
	return '';
}

// get the room's name by the room's id
function get_room_name_by_id($id)
{
	global $tbl_room;
	if (isset($id) && $id > 0)
	{
		$sql = "SELECT room_name FROM $tbl_room WHERE id=$id LIMIT 1";
		$room_name = sql_query1($sql);
		if (empty($room_name) || $room_name <0)
		{
			fatal_error(0, "Room with no name: id=$id");
		}
		return $room_name;
	}
	return '';
}

// get the days's day_string by the day's id
function get_day_string_by_id($id)
{
	global $tbl_day;
	if (isset($id) && $id > 0)
	{
		$sql = "SELECT day_string FROM $tbl_day WHERE id=$id LIMIT 1";
		$day_string = sql_query1($sql);
		if (empty($day_string) || $day_string <0)
		{
			fatal_error(0, "Day with no day_string: id=$id");
		}
		return $day_string;
	}
	return '';
}

// get_entry_creator_id
function get_entry_creator_id($id)
{
	global $tbl_entry;
	if (isset($id) && $id > 0)
	{
		$sql = "SELECT user_id as creator_id FROM $tbl_entry WHERE id=$id LIMIT 1";
		$creator_id = sql_query1($sql);
		if ($creator_id < 0)
		{
			return -2;
		}
		return $creator_id;
	}
	return -1;
}

// get the full date record by date id
function get_date_record_by_id($id)
{
	global $tbl_day;
	if (!isset($id))
	{
		return -1;
	}
	$sql = "SELECT * FROM $tbl_day WHERE id=$id LIMIT 1";
	$res = sql_query($sql);
	if ((! $res) || ($res < 0))
	{
		return -2;
		
	}
	$row = sql_row_keyed($res, 0);
	return $row;
	
}

// Return the number of events in the database
function eventCount()
{
	global $tbl_event;
	$sql = "SELECT COUNT(id) FROM $tbl_event";
	$count = sql_query1($sql);
	if ($count < 0)
	{
		fatal_error(0, get_vocab("eventcountfailed") . " " . sql_error($res));
	}
	return $count;
}

// Return the number of records in a table
function get_num_records($table)
{
	$sql = "SELECT COUNT(ID) FROM $table";
	$count = sql_query1($sql);
	if ($count < 0) fatal_error(0, get_vocab("recordcountfailed") . " " . sql_error());
	return $count;
}

// retrieve an database record from a given table by its id
function get_record_by_id($table, $id)
{
	$sql = "SELECT * FROM $table WHERE id=$id LIMIT 1";
	$res = sql_query($sql);
	if (!$res) {
		return -2;
	}
	$row = sql_row_keyed($res, 0);
	return $row;
}

function get_user_from_user_name($user_name)
{
	global $tbl_users;
	$sql = "SELECT * FROM $tbl_users WHERE name='$user_name' LIMIT 1";
	$res = sql_query($sql);
	if (!$res) fatal_error(1, get_vocab('userretrievalfailed') . " " . sql_error());
	$user = sql_row_keyed($res, 0);
	return $user;
}

function get_full_name($id)
{		
	global $tbl_users;
	$sql = "SELECT first_name, last_name FROM $tbl_users WHERE id=$id LIMIT 1";
	$res = sql_query($sql);
	if (!res) return '';
	$row = sql_row_keyed($res, 0);
	return $row['first_name'] . " " . $row['last_name'];
	
}
?>
