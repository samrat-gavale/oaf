<?php
# Script 16.10 - forgot_password.php 
// This page allows a user to reset their password, if forgotten.
include('../user/oaf_paths.php');
include ($includes_path.'/html/header.html');

$error_msg = "";
$success_msg = "";

if (isset($_POST['submitted']))
{
	require_once ($includes_path.'/php/mysqlcon.php');

	// Assume nothing:
	$uid = FALSE;

	// Validate the email address...
	if (!empty($_POST['Email_ID'])) 
	{
		// Check for the existence of that email address...
		$q = 'SELECT User_ID FROM Accounts WHERE Email_ID="'. mysqli_real_escape_string($dbcon, $_POST['Email_ID']) . '"'; 
		$r = mysqli_query ($dbcon, $q) or
			trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbcon));

		if (mysqli_num_rows($r) == 1) 
		{ //Retrieve the user ID:
			list($uid) = mysqli_fetch_array ($r, MYSQLI_NUM);
		}
		else
		{ // No database match made.
			$error_msg = 'The submitted email address does not match those on file!';
			$uid = 0;
		}

	} 
	else
	{ // No email!
		$error_msg = 'Please enter your email address!</p>';
	} // End of empty($_POST['Email_ID']) IF.

	if ($uid) // If everything's OK. 
	{ 
		// Create a new, random password:
		$p = substr ( md5(uniqid(rand(), true)), 3, 10);

		//Update database
		$q = "UPDATE Accounts SET Password=SHA1('$p') WHERE User_ID=$uid LIMIT 1";
		$r = mysqli_query ($dbcon, $q) or
			trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbcon));
		
		if (mysqli_affected_rows($dbcon) == 1) 
		{
			// If it ran OK send an email:
			$body = "Your password to log into Online application for faculty at IIT Mandi has been temporarily changed to '$p'.
				Please log in using this password and this email address. Then you may change
				your password to something more familiar.";

			mail ($_POST['Email_ID'], 'Your temporary password.', $body, 'From:techhelp@iitmandi.ac.in');
			
				echo "<h4 id = 'wrapper' class='alert_text'><br/><br/>Your password has been changed. You will receive the new, temporary password at the email
					address with which you registered. Once you have logged in with this password, you may change it by
					clicking on the 'Change Password' link. Check your new password and then <a href='login.php'>Log In</a></h4>";
			mysqli_close($dbcon);
			exit();
		}
		 else { // If it did not run OK.

			$error_msg = 'Your password could not be changed due to a system error. We apologize for any inconvenience.</p>';
		}
	}
	 else
	 { // Failed the validation test.
		$error_msg = 'The submitted email address does not match those in our records. Please try again.</p>';
		
		mysqli_close($dbcon);
	} // End of the main Submit conditional.
}
	?>
	
<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
	<p class="texta">Reset Your Password</p>
	<?php echo '<p class="error_text">' . $error_msg . '</p>'; ?>
<form name="forgot_pass" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<fieldset class="fieldset">
		<p>Enter your email address below and your
		password will be reset.</p>
		<table>
			<tr>
				<td class="labelcell" >Email Address</td>
				<td class="fieldcell" >	<input type="text" name="Email_ID" size="20" maxlength="40" 
										 value="<?php if(isset($_POST['Email_ID'])) echo $_POST['Email_ID']; ?>" /></td>
			</tr>
			<tr>
				<td class="fieldcell"><input type="submit" name="submit" value="Reset My Password"/></td>
			</tr>
		</table>	
		<input type="hidden" name="submitted"  value="TRUE" />
	</fieldset>
</form>

		<?php
			include($includes_path.'/js/form_validators/forgot_pass.js');
		?>

<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= '../index.php' ">
</div>
</div>

</div>
</div>

<div id="leftcolumn">
</div>

<div id="rightcolumn">
<div id="help">
<h3>Note</h3>
<ul>
<li>Please enter the email ID that you have given while signing up.</li>
</ul>
</div>
</div>

</div>

<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
