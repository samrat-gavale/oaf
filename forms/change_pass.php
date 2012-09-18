<?php
// This page allows a logged-in user to change their password.
include('../user/oaf_paths.php');
include ($includes_path.'/html/header.html');
include ($includes_path.'/php/functions.php');
require_once ($includes_path.'/php/mysqlcon.php');
$error_msg = "";

// If no userid session variable exists, redirect the user:
if (!isset($_SESSION['user_id'])) 
{
	$next_url = '../user/index.php'; 
	// Define the URL.
	ob_end_clean(); // Delete the buffer. 
	echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">'; 
	exit(); // Quit the script. 
}

if (isset($_POST['submitted'])) 
{
	//	require_once (MYSQL);
	// Check for a new password and match against the confirmed password: 
	$p = FALSE; 
	if (valid_pass($_POST ['Password'])) 
	{ 
		if($_POST['Password'] == $_POST['ConfirmPassword'])
		{
			$p = mysqli_real_escape_string($dbcon, $_POST['Password']);
		}
		else 
		{
			$error_msg = 'Your password did not match the confirmed password!';
		}
	} 
	else 
	{
		$error_msg = 'Please enter a valid password!';
	}
	if ($p) 
	{ 
		// If everything's OK. Make the query.
		$q = "UPDATE Accounts SET Password=SHA1('$p') WHERE User_ID={$_SESSION['user_id']} LIMIT 1";
		$r = mysqli_query ($dbcon, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbcon));
		if (mysqli_affected_rows($dbcon) == 1) 
		{
			// If it ran OK. Send an email, if desired.
			?> 
				<div id="maincontainer">
				<div id="contentwrapper">
				<div id="contentcolumn"><br/>
				<div id="help"><p class="alert_text">Your password has been changed.</p>
				<input type="button" value="Home" onclick="parent.location= '../user/index.php' ">
				</div>
				</div>
				</div>
				<div id="leftcolumn">
				<?php include($includes_path.'/php/sidemenu.php');?>
				</div>
				</div>
				</div>
				<?php
				include($includes_path.'/html/footer.html');
			exit();
		}
		else 
		{ 
			// If it did not run OK.
			$error_msg = 'Your password was not changed. Make sure your new password is different than the current password. Contact the system administrator if you think an error occurred.';
		}
	} 
	else 
	{ 
		// Failed the validation test.
		$error_msg = 'Please try again.';
	}
} // End of the main Submit conditional.
?>
<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
<?php echo '<p class="error_text">' . $error_msg . '</p>'; ?>

<p class="texta">Change Your Password</p>
<form name="change_pass" action="change_pass.php" method="post">
<fieldset class="fieldset">
<table>
<tr>
<td class="labelcell" ><label for="newpasswd">New Password <i><small>(Must be between 5 and 20 characters long.)</small></i></label></td>
<td class="fieldcell" ><input type="password" name="Password" value="<?php if (!empty($newpasswd)) echo $newpasswd; ?>"/></td>
</tr>
<tr>
<td class="labelcell"><label for="password">Confirm Password</label></td>
<td class="fieldcell"><input type="password" name="ConfirmPassword" /></td>
</tr>
<tr>
<td><input type="submit" value="Change My Password" name="submit" /></td>
</tr>
</table>
</fieldset>
<input type="hidden" name="submitted" value="TRUE" />
</form>

<?php
	include($includes_path.'/js/form_validators/change_pass.js');
?>

<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= '../index.php' ">
</div>

</div>
</div>

<div id="leftcolumn">
<?php include($includes_path.'/php/sidemenu.php');?>
</div>

<div id="rightcolumn">
<div id="help">
<h3>Note</h3>
<ul>
<li>Your new password must not same as the present password.</li>
<li>The password must have minimum of five letters and maximum of twenty letters</li>
</ul>
</div>
</div>

</div>

<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
