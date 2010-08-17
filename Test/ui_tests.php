<?php

/**
 * User interface tests
 *
 * @author Tamara Temple
 * @version $Id$
 * @copyright Tamara Temple Development, 17 August, 2010
 * @package default
 **/
require_once '../defaultincludes.inc';

print_simple_header();

echo "<h1>User interface tests</h1>\n";

global $verbose;
$verbose = TRUE;

$submit = get_form_var('submit', 'string');

if (!isset($submit) || empty($submit))
{
	$first_pass = TRUE;
}
else
{
	$first_pass = FALSE;
}

echo "<pre>\n";
echo ($first_pass ? "First" : "Second") . " Pass\n";
echo "_GET:";
print_r($_GET);
echo "_POST:";
print_r($_POST);
	
$checked = get_form_var('checked', 'checkbox'); // value of the checkbox
echo "checked=$checked\n";
echo "database value=" . (($checked=="checked") ? 1 : 0) . "\n";  // pass along the correct value for the database (0=false, 1=true)
$old_checked = get_form_var('old_checked', 'string'); // previous value of the checkbox
echo "old_checked=$old_checked\n";
if ($checked == $old_checked)
{
	echo "No change in form\n";
}
else
{
	echo "Form changed\n";
}
echo "</pre>\n";

print_footer(0);

?>

	<form action="<?php echo $PHP_SELF ?>" method="post" accept-charset="utf-8">

		<p><label for="checked">Checked?</label><input type="checkbox" name="checked" value="1" id="checked" <?php echo ($first_pass ? "" : $checked) ?>/>
		<input type="hidden" name="old_checked" value="<?php echo ($first_pass ? '' : $checked) ?>" id="old_checked" />

		<p><input type="submit" name="submit" id="submit" value="Continue &rarr;" /></p>
	</form>
