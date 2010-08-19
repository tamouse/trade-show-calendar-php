<?php

// $Id: header.inc 1319 2010-04-09 09:57:20Z cimorrison $

// Print the page header
function print_theme_header($event_id, $day_id)
{
  global $cdma_company, $cdma_company_logo, $cdma_company_url, $cdma_company_more_info,
         $search_str, $locale_warning, $provisional_enabled;
  global $tbl_entry, $tbl_room, $tbl_area;
  global $PHP_SELF;
  
  $page = basename($PHP_SELF, ".php" );

if (!isset($day_id) || (!$day_id))
{

  // If we dont know the right date then make it up 
    $day   = date("d");
    $month = date("m");
    $year  = date("Y");
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
    <script type="text/javascript">

	$( function() {
		$( 'table#banner' ).wrap( "<div style='background-color: #6ccacd; padding: 5px' />" ).parent().corner();

		$( 'table.day_selector_table td.unselected' ).each( function() { $( this ).wrapInner( "<div style='background-color: #6ccacd; padding: 5px;' />" ).children().first().corner( { bl: { radius: 0 }, br: { radius: 0 } } ); } );
		$( 'table.day_selector_table td.selected' ).wrapInner( "<div style='background-color: #FFEF00; padding: 5px;' />" ).children().first().corner( { bl: { radius: 0 }, br: { radius: 0 } } );

	} );
//<![CDATA[

<?php

if ($page == 'pending')
{
?>
  // test whether array contains element
  function contains(array, element)
  {
    for (var i=0; i<array.length; i++)
    {
      if (array[i] == element)
      {
        return true;
      }
    }
    return false;
  }
  
  // Remove duplicates from an array
  function unique(array)
  {
    temp = new Array();
    for (var i=0; i<array.length; i++)
    {
      if (!contains(temp, array[i]))
      {
        temp.push(array[i]);
      }
    }
    return temp;
  }
  
  // Toggle a sub-table in the pending_list table to make it maximised/minimised
  function toggle_table(id)
  { 
    var table = document.getElementById(id);
    if (table.className == 'minimised')
    {
      table.className = 'maximised';
      table.firstChild.firstChild.firstChild.innerHTML = '-';
    }
    else
    {
      table.className = 'minimised';
      table.firstChild.firstChild.firstChild.innerHTML = '+';
    }
  }

  
  // Put a + control in the first cell of all the series headers on the pending.php page
  // and minimise the tables (except for those tables listed in the cookie)
  function activate_sub_tables()
  {
    // Go through each sub-table and minimise it
    var tables = document.getElementsByTagName('table');
    for (var i = 0; (element = tables[i]) != null; i++)
    {
      if (tables[i].className.indexOf('maximised') >= 0)
      {
        tables[i].className = 'minimised';
        tables[i].firstChild.firstChild.firstChild.innerHTML = '+'; 
      } 
    }
     
    // now make the table visible (if it's there at all - which it won't be when you 
    // log off from pending.php
    if (document.getElementById('pending_list'))
    {
      document.getElementById('pending_list').style.visibility = 'visible';
    }
  }
  
  
  
<?php
} // pending
?>

// This will create jqueryui buttons out of all submit buttons of the class 'submit_buttons'
// It will load when the document is ready
	 $(document).ready(function(){
	 	$(function() {
	 		$("input:submit", ".submit_buttons").button();

	 	});

	  });


// actions to be taken on page load
function init()
{
  <?php // ALL PAGES ?>
  // if there's a logon box, set the username input field in focus
  var logonForm = document.getElementById('logon');
  if (logonForm && logonForm.NewUserName)
  {
    logonForm.NewUserName.focus();
  }
  
  <?php
  // EDIT_ENTRY.PHP
  // put the booking name field in focus (but only for new bookings,
  // ie when the field is empty:  if it's a new booking you have to
  // complete that field, but if it's an existing booking you might
  // want to edit any field)
  if ($page == 'edit_entry')
  {
  ?>
  var form = document.getElementById('main');
  if (form && form.name && (form.name.value.length == 0))
  {
    form.name.focus();
  }
  <?php
  }
  
  // PENDING.PHP
  if ($page == 'pending')
  {
  ?>
    activate_sub_tables();
  <?php
  }

  ?>
}


//]]>
    </script>
  </head>
  <?php
  // Put the filename in as a class to aid styling.   
  // (Use a class rather than id to avoid specificity problems)
  echo "<body class=\"$page\" onLoad =\"init()\">\n";
  ?>
    <div class="screenonly">

<?php // show a warning if this is using a low version of php
  if (substr(phpversion(), 0, 1) == 3)
  {
    echo "<h1>" . get_vocab("not_php3") . "</h1>\n";
  }
  if (!empty($locale_warning))
  {
    echo "[Warning: ".$locale_warning."]";
  }
?>

  <table id="banner">
    <tr>
      <td id="company">
        <div>
          <?php
          echo "<div id=\"logo\">\n";
          if (!empty($cdma_company_url))
          {
            echo "<a href=\"$cdma_company_url\">\n";
          }
          if (empty($cdma_company_logo))
          {
            echo "<span>$cdma_company</span>\n";
          }
          else
          {
            $logo_size = getimagesize($cdma_company_logo);
            echo "<img src=\"$cdma_company_logo\" " . $logo_size[3] . " alt=\"logo\">\n";
          }
          if (!empty($cdma_company_url))
          {
            echo "</a>\n";
          }
          echo "</div>\n";
          if (!empty($cdma_company_more_info))
          {
            echo "<div id=\"more_info\">$cdma_company_more_info</div>\n";
          }
			if ($display_app_title) {
          ?>
          <div id="cdma">
            <a href="index.php"><?php echo get_vocab("cdma") ?></a>
          </div> 
			<?php } ?>
        </div>
      </td>
      <?php
		$query_str = "";
      if (!empty($day_id))
		{
			$query_str = "day_id=$day_id";
		}
		if (!empty($event_id))
      {
		$query_str .= ($query_str == "") ? "" : "&amp;";
        $query_str .= "event_id=$event_id";
      }

      if ($display_help)
		{
			echo "<td>\n";
			echo "<a href=\"help.php?$query_str\">" . get_vocab("help") . "</a>\n";
			echo "</td>\n";
		}
      
      echo "<td>\n";
      echo "<a href=\"admin.php?$query_str\">" . get_vocab("admin") . "</a>\n";
      echo "</td>\n";
      
      echo "<td>\n";
      echo "<a href=\"report.php?$query_str\">" . get_vocab("report") . "</a>\n";
      echo "</td>\n";
      ?>
      
      <?php
      // For session protocols that define their own logon box...
      if (function_exists('PrintLogonBox'))
      {
        echo "<td>\n";
        echo "<div id=\"logon_box\">\n";
        PrintLogonBox(); 
        echo "</div>\n";
        echo "</td>\n";
      }
      ?>
    </tr>
  </table>
</div>
<?php

} // end of print_theme_header()
?>
