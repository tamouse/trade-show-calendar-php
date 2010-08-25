<?php
/**
 * User Interface tests -- run from top level of app so includes work correctly
 *
 * @author Tamara Temple
 * @version $Id$
 * @copyright Tamara Temple Development, 25 August, 2010
 * @package default
 **/

/**
 * Define DocBlock
 **/

require_once 'defaultincludes.inc';

global $verbose;

$verbose = 1;

function test_showAccessDenied()
{
	// test the showAccessDenied function
	$errormsg = 'notowner';
	if ($verbose) js_alert("Sending: $errormsg");
	showAccessDenied(0,0,$errormsg);
	
}

// main

test_showAccessDenied();

?>