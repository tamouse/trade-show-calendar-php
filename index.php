<?php


// $Id: index.php 1278 2009-12-09 13:16:58Z cimorrison $

// Index is just a stub to redirect to the appropriate view
// as defined in config.inc.php using the variable $default_view
// If $default_room is defined in config.inc.php then this will
// be used to redirect to a particular room.

require_once "defaultincludes.inc";
require_once "cdma_sql.inc";

$redirect_str = "day.php";

redirect($redirect_str);



?>
