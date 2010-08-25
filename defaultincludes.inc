<?php

// $Id: defaultincludes.inc 1158 2009-07-16 16:03:44Z jberanek $

require_once "grab_globals.inc.php";
require_once "systemdefaults.inc.php";
if (!file_exists("config.inc.php")) {
	header("Location: noconfig.php"); // redirect to a special page to indicate no local configuation file exits
	exit;
}
require_once "config.inc.php";
require_once "functions.inc";
require_once "dbsys.inc";
require_once "cdma_auth.inc";

?>
