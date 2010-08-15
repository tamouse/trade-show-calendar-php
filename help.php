<?php

// $Id: help.php 1157 2009-07-16 15:56:07Z jberanek $

require_once "defaultincludes.inc";

require_once "version.inc";

$location = "day.php" . "?error=notimplemented";
redirect($location);

// Get form variables
$day = get_form_var('day', 'int');
$month = get_form_var('month', 'int');
$year = get_form_var('year', 'int');
$area = get_form_var('area', 'int');
$room = get_form_var('room', 'int');

// If we dont know the right date then make it up
if (!isset($day) or !isset($month) or !isset($year))
{
  $day   = date("d");
  $month = date("m");
  $year  = date("Y");
}
if (empty($area))
{
  $area = get_default_area();
}

print_header($day, $month, $year, $area, isset($room) ? $room : "");

echo "<h3>" . get_vocab("about_cdma") . "</h3>\n";
echo "<table id=\"version_info\">\n";
echo "<tr><td><a href=\"http://cdma.sourceforge.net\">" . get_vocab("cdma") . "</a>:</td><td>" . get_cdma_version() . "</td></tr>\n";
echo "<tr><td>" . get_vocab("database") . ":</td><td>" . sql_version() . "</td></tr>\n";
echo "<tr><td>" . get_vocab("system") . ":</td><td>" . php_uname() . "</td></tr>\n";
echo "<tr><td>" . get_vocab("servertime") . ":</td><td>" . utf8_strftime("%c", time()) . "</td></tr>\n";
echo "<tr><td>PHP:</td><td>" . phpversion() . "</td></tr>\n";
echo "</table>\n";

echo "<p>\n" . get_vocab("browserlang") .":\n";

echo implode(", ", array_keys($langs));

echo "\n</p>\n";

echo "<h3>" . get_vocab("help") . "</h3>\n";
echo "<p>\n";
echo get_vocab("please_contact") . '<a href="mailto:' . htmlspecialchars($cdma_admin_email)
  . '">' . htmlspecialchars($cdma_admin)
  . "</a> " . get_vocab("for_any_questions") . "\n";
echo "</p>\n";
 
require_once "site_faq" . $faqfilelang . ".html";

require_once "trailer.inc";
?>
