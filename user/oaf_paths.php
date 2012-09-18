<?php
$oaf_path = dirname($_SERVER['PHP_SELF']);
define("BASE_URL", "localhost/oaf");
// Is the user using HTTPS?
$oaf_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
// Complete the URL
$oaf_url .=  BASE_URL.dirname($_SERVER['PHP_SELF']);
//echo $oaf_url;
$includes_path = '../includes';
?>
