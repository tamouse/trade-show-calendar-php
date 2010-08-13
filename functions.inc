<?php

// $Id: functions.inc 1319 2010-04-09 09:57:20Z cimorrison $

/////////////////////////////////////////
// Set timezone, if one has been provided

global $timezone;

if (isset($timezone))
{
  if (function_exists("date_default_timezone_set"))
  {
    date_default_timezone_set($timezone);
  }
  else
  {
    putenv("TZ=$timezone");
  }
}
else
{
  // to prevent people running into DST problems
  die('Configuration error: $timezone has not been set.');
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

// validates a phone number against a regular expression
// based on a configured phone number formats
function validate_phone_number($phone)
{
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

// generates some html that can be used to select which area should be
// displayed.
function make_area_select_html( $link, $current, $year, $month, $day )
{
  global $tbl_area;
  $out_html = "
<form id=\"areaChangeForm\" method=\"get\" action=\"$link\">
  <div>
    <select class=\"room_area_select\" id=\"area_select\" name=\"area\" onchange=\"this.form.submit()\">";
  
    $sql = "select id, area_name from $tbl_area order by area_name";
    $res = sql_query($sql);
    if ($res)
    {
      for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
      {
        $selected = ($row['id'] == $current) ? "selected=\"selected\"" : "";
        $out_html .= "
      <option $selected value=\"". $row['id']. "\">" . htmlspecialchars($row['area_name']) . "</option>";
      }
    }
    // Note:  the submit button will not be displayed if JavaScript is enabled
    $out_html .= "
    </select>
  
    <input type=\"hidden\" name=\"day\"   value=\"$day\">
    <input type=\"hidden\" name=\"month\" value=\"$month\">
    <input type=\"hidden\" name=\"year\"  value=\"$year\">
    <input type=\"submit\" class=\"js_none\" value=\"".get_vocab("change")."\">
    </div>
</form>\n";

  return $out_html;
} // end make_area_select_html

function make_room_select_html( $link, $area, $current, $year, $month, $day )
{
  global $tbl_room;
  $out_html = "
<form id=\"roomChangeForm\" method=\"get\" action=\"$link\">
  <div>
    <select class=\"room_area_select\" name=\"room\" onchange=\"this.form.submit()\">";
  
    $sql = "select id, room_name from $tbl_room where area_id=$area order by sort_key";
    $res = sql_query($sql);
    if ($res)
    {
      for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
      {
        $selected = ($row['id'] == $current) ? "selected=\"selected\"" : "";
        $out_html .= "
      <option $selected value=\"". $row['id']. "\">" . htmlspecialchars($row['room_name']) . "</option>";
      }
    }
    // Note:  the submit button will not be displayed if JavaScript is enabled
    $out_html .= "
    </select>
    <input type=\"hidden\" name=\"day\"   value=\"$day\">
    <input type=\"hidden\" name=\"month\" value=\"$month\">
    <input type=\"hidden\" name=\"year\"  value=\"$year\">
    <input type=\"hidden\" name=\"area\"  value=\"$area\">
    <input type=\"submit\" class=\"js_none\" value=\"".get_vocab("change")."\">
  </div>
</form>\n";

  return $out_html;
} // end make_area_select_html


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

function draw_cell($cell, $query_strings)
{
  // draws a single cell in the main table of the room view
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
  // $cell_class specifies the default class for the cell (odd_row, even_row or row_highlight)
  // so that the zebra stripes can be drawn, or else to allow the whole row to be highlighted.
  
    
	if(isset($cell))
	{       
		$id         = $cell["id"];
		$event_id	= $cell["event_id"];
		$day_id		= $cell["day_id"];
		$room_id	= $cell["room_id"];
		$start_time	= $cell["start_time"];
		if (isset($cell["user_id"]))
		{
			$user_id	= $cell["user_id"];
			$descr		= $cell["purpose"];
			$cell_class = 'booked';
		}
		else
		{
			unset($user_id);
			$descr		= get_vocab('available');
			$cell_class = 'available';
		}
	}
	else  // cell not set
	{
		unset($id);
		$descr = get_vocab('addslot');
		$cell_class = 'no_slot';
    }


	echo "<td class=\"$cell_class\">";
	echo "<div class=\"celldiv\">\n";
	  

	if (!isset($id)) // no slot
	{
		$user = getUserName();
		$level = authGetUserLevel($user);
		if ($level >= 2)
		{
			echo "<a class=\"new_booking\" href=\"admin.php?" . $query_strings['new_periods'] . "&amp;start_time=$start_time\">";
			echo $descr;
			echo "</a>\n";
		}
	}
	else if (!isset($user_id)) // open slot, no booking
	{
		echo "<a class=\"new_booking\" href=\"edit_entry.php?id=$id&amp;" . $query_strings['new_times'] . "\">";
		echo $descr;
		echo "</a>\n";
	}
    else                 // if it is booked then show the booking
	{
		echo "<a class=\"old_booking\" href=\"view_entry.php?id=$id&amp;". $query_strings['booking'] . "\">$descr</a>\n";
	}
	echo "</div>\n";
	
	echo "</td>\n";
}  // end function draw_cell


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
	$sql = "SELECT id FROM $tbl_events ORDER BY id LIMIT 1;";
	$res = sql_query1($sql);
	if (! $res)
	{
		return;
	}
	else
	{
		return $res[0]['id'];
	}
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
	if (isset($event_id))
	{
		$sql = "SELECT name, description FROM $tbl_event WHERE id = $event_id;";
		$res = sql_query1($sql);
		if (! $res)
		{
			fatal_error(0, sql_error());
		}
		return $res[0];
	}
	else
	{
		return;
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
	if (isset($event_id))
	{
		$sql = "SELECT id FROM $tbl_day WHERE event_id = $event_id;";
		$res = sql_query($sql);
		if (! $res)
		{
			return; // empty result is handled by caller
		}
		else
		{
			return $res[0]['id'];
		}
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
	if (isset($day_id))
	{
		$sql = "SELECT day, month, year FROM $tbl_day WHERE id = $day_id;";
		$res = sql_query1($sql);
		if ($res)
		{
			return $res[0];
		}
	}
}

// day_before($day_id) - return the day before the given day
//
// Parameters:
//   $day_id - id of the day to search on
//
// Returns:
//   id of previous day in event, if it exists
//
function day_before($day_id)
{
	list ($day, $month, $year) = get_day_from_id($day_id);
	$bt = strtotime($month . "/" . $day . "/" . $year . " - 1 day");
	$before_a = gettime($bt);
	$mb = $before_a['month'];
	$db = $before_a['day'];
	$yb = $before_a['year'];
	$db_id = get_day_from_ymd($yb, $mb, $db);
	return $db_id;
	
}
// day_after($day_id) - return the day after the given day
//
// Parameters:
//   $day_id - id of the day to search on
//
// Returns:
//   id of next day in event, if it exists
//
function day_after($day_id)
{
	list ($day, $month, $year) = get_day_from_id($day_id);
	$at = strtotime($month . "/" . $day . "/" . $year . " + 1 day");
	$after_a = gettime($bt);
	$ma = $after_a['month'];
	$da = $after_a['day'];
	$ya = $after_a['year'];
	$da_id = get_day_from_ymd($ya, $ma, $da);
	return $da_id;
	
}
?>