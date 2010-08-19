<?php

// $Id: style.inc 1209 2009-10-01 22:46:01Z cimorrison $

// NOTE:  The filename for the stylesheet for <= IE6 must contain the string 'ielte6'.
// The href strings in the <link> tags below are used by InitActiveCell in xbLib.js to 
// test whether the browser is IE6 or below - and therefore whether to use JavaScript
// highlighting instead of CSS highlighting.   In particular the href string for the
// stylesheet for browsers IE6 or below must contain the string 'ielte6'.
?>
    <link rel="stylesheet" href="cdma.css.php" type="text/css">
    <link rel="stylesheet" media="print" href="cdma-print.css.php" type="text/css">
    <?php
    // JavaScript overrides first, followed by the IE overrides.   This allows
    // the IE overrides to override the JavaScript overrides.
    ?>
    <script src="cdma-js-overrides.js" type="text/javascript"></script>
    <!--[if IE]>
    <link rel="stylesheet" href="cdma-ie.css.php" type="text/css">
    <![endif]-->
    <!--[if IE 8]>
    <link rel="stylesheet" href="cdma-ie8.css" type="text/css">
    <![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="cdma-ielte8.css" type="text/css">
    <![endif]-->
    <!--[if lte IE 7]>
    <link rel="stylesheet" href="cdma-ielte7.css.php" type="text/css">
    <![endif]-->
    <!--[if lte IE 6]>
    <link rel="stylesheet" href="cdma-ielte6.css" type="text/css">
    <![endif]-->

	<!-- import jquery stuff -->
	<link type="text/css" href="jquery/cdma/css/custom-theme/jquery-ui-1.8.4.custom.css" rel="Stylesheet" />	
		<script type="text/javascript" src="jquery/cdma/js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="jquery/cdma/js/jquery-ui-1.8.4.custom.min.js"></script>
		<link rel="stylesheet" href="jquery/css/jquery.ui.timepicker.css" type="text/css" media="screen" title="no title" charset="utf-8" />
		
		<script type="text/javascript" src="jquery/js/jquery.ui.timepicker.js"></script>
		
		<script type='text/javascript' src='jquery/js/jquery.curvycorners.packed.js'></script>

		
	
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo get_charset(); ?>">
    <meta name="robots" content="noindex">
		<link rel="shortcut icon" href="favicon.ico" />
<?php

global $refresh_rate;
global $PHP_SELF;

if (($refresh_rate != 0) &&
    preg_match("/(day|week|month)\.php/",$PHP_SELF))
{
  echo "    <meta http-equiv=\"Refresh\" content=\"$refresh_rate\">\n";
}
?>
