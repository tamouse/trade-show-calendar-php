<?php

/**
 * Update Language Files from lang.en master
 *
 * @author Tamara Temple
 * @version $Id$
 * @copyright Tamara Temple Development, 25 August, 2010
 * @package default
 **/

/**
 * The master lang.en file has been modified highly for this application.
 * The other lang.* files need to have missing entries added to them so they will work correctly.
 * No attempt is made to actually do the translation.
 **/

/**
 * gatherVocab - gather the vocabulary for the given file and return it in an array
 *
 * @return array of vocabulary entries
 * @author Tamara Temple
 **/
function gatherVocab($file)
{
	if (file_exists($file)) {
		if (!$fh = fopen($file,"r")) {
			echo "Could not open $file.\n";
			exit;
		}
		$vocab = array();
		while ($line = stripslashes(fgets($fh))) {
			if (preg_match('/^\$vocab\[.([a-zA-Z0-9-_.]+).\]/', $line, $matches)) {
				$vocab[$matches[1]] = $line;
			} else {
			}
		}
		return $vocab;
	} else {
		return 0;
	}
}

/**
 * getLangFiels - retrieve the names of the files which contain language vocabulary
 *
 * @return array of file names
 * @author Tamara Temple
 **/
function getLangFiles()
{
	$dir = "."; // run in current directory where lang files are
	$dh  = opendir($dir);
	while (false !== ($filename = readdir($dh))) {
		if (preg_match('/^lang\./', $filename) && !preg_match('/^lang.en$/', $filename)) {
	    	$files[] = $filename;
		}	
	}
	return $files;
}

/**
 * writeAdditionalVocab - write the additional vocabulary to the designated language file
 *
 * @return void
 * @author Tamara Temple
 **/
function writeAdditionalVocab($fn, $av)
{
	$fnback = "$fn.back.".date("Ymdhis");
	echo "Backing up $fn to $fnback\n";
	$ret = copy($fn, $fnback); // make a copy of the file for safe keeping
	if (!$ret) {
		echo "Could not copy $fn to $fnback\n";
		exit;
	}
	$fh = fopen($fn, "a"); // open file for appending
	if (!$fh) {
		echo "Cound not open $fn\n";
		exit;
	}
	echo "Appending to file $fn.";
	if (!fwrite($fh, "<?php\n")) {
		echo "Could not write to file $fn\n";
		exit;
	}
	if (!fwrite($fh, "// Additional vocabulary for translating\n")) {
		echo "Could not write to file $fn\n";
		exit;
	}
	foreach($av as $key => $value){
		if (!fwrite($fh, $value)) {
			echo "Could not write to file $fn\n";
			exit;
		}
		echo ".";
	}
	if (!fwrite($fh, "?>\n")) {
		echo "Count not write to file $fn\n";
		exit;
	}
	echo "done\n";
	if (!fclose($fh)) {
		echo "Error closing file $fn\n";
		exit;
	}
}


/**
 * Main
 *
 * @author Tamara Temple
 */

echo "Updating Language Files\n\n";

$eng_vocab = gatherVocab("lang.en");

echo "English vocabulary:\n";
print_r($eng_vocab);
echo "\n";

if (count($eng_vocab) < 1) {
	echo "Empty english vocabulary!!\n";
	exit;
}
$vocab_files = getLangFiles();

echo "Vocab files:\n";
print_r($vocab_files);
echo "\n";

foreach($vocab_files as $vf) {
	$local_vocab = gatherVocab($vf);
	$added_vocab = array(); // reinitialize added vocab for each additional language file
	foreach($eng_vocab as $key => $value) {
		if (!isset($local_vocab[$key])) {
			$added_vocab[$key] = $value;
		}
	}
	writeAdditionalVocab($vf, $added_vocab);
}

echo "Finished.\n";

?>