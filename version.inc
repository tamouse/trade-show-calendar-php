<?php

// $Id: version.inc 1344 2010-04-22 20:10:50Z jberanek $

// This should probably be a class, but you can only have protected
// class members in PHP 5, so we won't bother

function get_cdma_version()
{
  // CDMA developers, make sure to update this string before each release
  $cdma_version = "CDMA 1.4.4.1";

  return $cdma_version;
}

?>
