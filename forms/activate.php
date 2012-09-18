<?php
	//This page validates user accounts 
	include ('../includes/html/header.html');
?>
<div id='wrapper'>
<?
// Validate $_GET['x'] and $_GET['y']:
	$x = $y = FALSE;
if (isset($_GET['x']) && preg_match('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/',$_GET['x']) ) 
{
	$x = $_GET['x'];
}
if (isset($_GET['y']) && (strlen($_GET['y']) == 32 ))
{
	$y = $_GET['y'];
}

// If $x and $y aren't correct, redirect the user.
if ($x && $y)
{
// Update the database...
	require_once ('../includes/php/mysqlcon.php');
	$q = "UPDATE Accounts SET Active = NULL WHERE (Email_ID='" . mysqli_real_escape_string($dbcon, $x) . "' AND Active='" . mysqli_real_escape_string($dbcon, $y) . "') LIMIT 1";
	$r = mysqli_query ($dbcon, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbcon));
// Print a customized message:
if (mysqli_affected_rows($dbcon) == 1) 
{
	echo '<br/><br/><br/><br/><div id="wrapper"><div id="help"><h3 calss="alert_text">Congratulations! <br/>Your have successfully activated your Account. <br/>You may now <a href='.$oaf_url.'/login.php >log in</a>.</h3></div></div>';
}
else 
{
	echo '<p class="error_text">Your account could not be activated. Please re-check the link or contact the system administrator.</font></p>';
}
	mysqli_close($dbcon);
} 
else
{ 
	// Redirect.
	$next_url = $oaf_url. '/index.php'; 
	// Define the URL:
	ob_end_clean(); // Delete the buffer.
    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$next_url.'">';
	exit(); // Quit the script.
} // End of main IF-ELSE.
?>
</div>
</body>
</html>
