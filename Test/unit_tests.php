<?php

include '../defaultincludes.inc';

global $verbose;

$verbose=TRUE;

function test_stripEmailPlaceholders()
{
	global $verbose;
	$instring = "**, mail@gmail.com, **";
	$expected = " mail@gmail.com,";
	if ($verbose) echo "Sending $instring\n";
	$result = stripEmailPlaceholders($instring);
	if ($verbose) echo "Returned: $result Expected: $expected\n";
	if ($result == $expected) return TRUE;
	return FALSE;
}

function test_truncateToDisplay()
{
	global $verbose;
	$instring = "abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz";
	$expected = "abcdefghijklmnopqrst ...";
	if ($verbose) echo "Sending: $instring\n";
	$outstring = truncateToDisplay($instring);
	if ($verbose) echo "Returned: $outstring\n";
	return ($outstring == $expected ? TRUE : FALSE);
}

function test_convertTimeToArray()
{
	global $verbose;
	$time_str = "8:00 AM";
	$hour = 8;
	$minute = 0;
	if ($verbose) echo "Sending $time_str\n";
	list ($r_hour, $r_minute) = convertTimeToArray($time_str);
	if ($verbose) echo "Returned \$r_hour=$r_hour, \$r_minute=$r_minute\n";
	if ($verbose) {
		echo "Print dumps:\n";
		echo "\$r_hour:\n";
		print_r($r_hour);
		echo "\n\$r_minute:\n";
		print_r($r_minute);
		echo "\n";
	}
	if ($verbose) echo "Expected \$hour=$hour, \$minute=$minute\n";
	if (!isset($r_hour) || (!isset($r_minute))) 
	{
		if ($verbose) echo "Not set\n";
		return FALSE;
	}
	if (!is_numeric($r_hour) || (!is_numeric($r_minute))) 
	{
		if ($verbose) echo "Not numeric\n";
		return FALSE;
	}
	if (($hour != $r_hour) || ($minute != $r_minute)) 
	{
		if ($verbose) echo "Not equal\n";
		return FALSE;
	}
	return TRUE;
}


function test_get_user_name_LargeID()
{
	global $verbose;
	$id=100000; // a ridiculously large number
	if ($verbose) echo "Sending \$id=$id\n";
	$name = get_user_name($id);
	if ($verbose) echo "Returned \$name=$name\n";
	if (empty($name)) return TRUE;
	return FALSE;
	
}

function test_eventCount()
{
	global $verbose;
	$count = eventCount();
	if ($verbose) echo "Returned \$count=$count\n";
	return ($count >= 0 ? TRUE : FALSE);
}

function check_entry_table_fields()
{
	global $verbose, $tbl_entry;
	if ($verbose) echo "Searching for fields\n";
	$fields = sql_field_info($tbl_entry);
	if ($verbose) {
		echo "Fields in $tbl_entry:\n";
		print_r($fields);
		echo "\n";
	}
	return TRUE;
}

function _run_test($testname)
{
	global $verbose;
	if ($verbose) echo "Testing $testname\n";
	
	$result = $testname();
	if ($result)
	{
		echo "Test $testname PASSED.";
		echo "\n";
	}
	else
	{
		echo "Test $testname FAILED.\n";
	}
	echo "\n";
	
}

function _send_header()
{
	header("Content-type: text/plain");
	echo "Unit Tests\n\n";
}

function _inspect_var($var)
{
	echo "$var: ";
	$cmd = "print_r(" . "\$" . $var . ");"; echo $cmd;
	eval($cmd);
	echo "\n";
}

function _print_environment()
{
	_inspect_var("_GET");
	_inspect_var("_POST");
	_inspect_var("_SERVER");
	_inspect_var("_ENV");
	_inspect_var("GLOBALS");
	
}
// main

_send_header();

_run_test('test_get_user_name_LargeID');
_run_test('test_eventCount');
_run_test('test_convertTimeToArray');
_run_test('test_truncateToDisplay');

_run_test('test_stripEmailPlaceholders');

_run_test('check_entry_table_fields');
// _print_environment();


?>