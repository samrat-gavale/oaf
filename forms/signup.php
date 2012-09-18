<?php
include('../includes/html/header_signup.html');
include('../user/oaf_paths.php');
include('../includes/php/functions.php');
$error_msg = "";

if(isset($_POST['submit']))
{
	/*	require_once('../includes/php/recaptchalib.php');
		$privatekey = "6LfX9sASAAAAAADxcN2ru0QwtBH5Oj_z4lZCY7fE";
		$resp = recaptcha_check_answer ($privatekey,
		$_SERVER["REMOTE_ADDR"],
		$_POST["recaptcha_challenge_field"],
		$_POST["recaptcha_response_field"]);

		if (!$resp->is_valid) 
	 */
	if (0) 
	{
		// What happens when the CAPTCHA was entered incorrectly
		$error_msg = "The characters you entered didn\'t match the word verification. Please try again.(reCAPTCHA said: " . $resp->error . ")";
		$display_form = true;  
	}
	else
	{
		$password = trim($_POST['Password']);
		$confirm_password = trim($_POST['ConfirmPassword']);
		$email_id = trim($_POST['EmailID']);
		$confirm_email_id = trim($_POST['ConfirmEmailID']);

		if(empty($password) || empty($confirm_password) || empty($email_id) || empty($confirm_email_id))
		{
			$error_msg = 'Please enter all the information.';
			$display_form = true;
		}
		else if(!valid_email($email_id) || !valid_email($confirm_email_id))
		{
			$error_msg = 'Please enter a valid Email Id';
			$display_form = true;
		}
		else if(!valid_pass($password) || !valid_pass($confirm_password))
		{
			$error_msg = 'Please enter a valid password (minimun four and maximum twenty characters).';
			$display_form = true;
		}
		else if($password != $confirm_password) 
		{
			$error_msg = 'Passwords don\'t match!';
			$display_form = true;
		}
		else if($email_id != $confirm_email_id)
		{
			$error_msg = 'Email IDs don\'t match!';
			$display_form = true;
		}
		else 
		{ $display_form = false; }

	}
}

else
{
	$display_form = true;
}

if($display_form == true)
{
	?>
		</style>

		</div>
		<div id="maincontainer">
		<div id="contentwrapper">

		<div id="contentcolumn">
		<p class ="texta">Sign Up</p>
		<?php
		echo '<p class="error_text">' . $error_msg . '</p>';
	?>

		<form  name="signup" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<fieldset class="fieldset1">
		<table>
		<tr>
		<td class="labelcell"><label for="email">email ID</label></td>
		<td class="fieldcell"><input type="text"id="email" name="EmailID"  maxlength="30" size="25"
		value="<?php if (isset($_POST['EmailID'])) echo $_POST['EmailID']; ?>" /></td>
		</tr>
		<tr>
		<td class="labelcell"><label for="Confirm email">Confirm email ID</label><br class="nobr"></td>
		<td class="fieldcell"><input type="text" id="email" name="ConfirmEmailID"  maxlength="30" size="25"
		value="<?php if (isset($_POST['ConfirmEmailID'])) echo $_POST['ConfirmEmailID']; ?>" /></td>
		</tr>
		<tr>
		<td class="labelcell"><label for="password" >Password</label></td>
		<td class="fieldcell"><input type="password" id="password" name="Password"  maxlength="15" size="25"/></td>
		</tr>
		<tr>
		<td class="labelcell"><label for="Confirm Password">Confirm Password</label></td>
		<td class="fieldcell"><input type="password"  id="password" name="ConfirmPassword" maxlength="15" size="25"/></td>
		</tr>
		<tr><td colspan="2">
		<?php
		include('../includes/js/captcha.js');
	?>
		</td>
		</tr>
		<tr>    
	     	 <td class="button"><input type="submit" name="submit" value="Sign Up"/></td>   
        </tr>   
		</table>
		</fieldset>
		</form>

		<?php
			include($includes_path.'/js/form_validators/signup.js');
		?>

		<div id="navbuttons">
		<input type="button" value="Back" onclick="parent.location= '../index.php' ">
		</div>

		</div>
		</div>

		<div id="leftcolumn">
		</div>

		<div id="rightcolumn">
		<div id = "help">
		<h3>Note</h3>
			<ul>
				<li>Password need not be same as the password for this Email account.</li>
				<li>Password must not be longer than fifteen characters.</li>
				<li>Please ensure you enter a valid e-mail ID since it is essential for validation of your account.</li>
				<li>You must remember your given email_ID and password. </li>
				<li>If the charactes diplayed in the reCAPTCHA are not readable, refresh the pase so that new characters are displayed.</li>
				<li>If you already have an account, <a href="login.php">click here</a> to log in.</li>
			</ul>
		</div>
		</div>

		</div>
		</div>

		<?php
			include('../includes/html/footer.html');
		?>
		</body>
		</html>

		<?php
}

else
{
	require_once('../includes/php/mysqlcon.php');
	$query = "SELECT User_ID FROM Accounts WHERE Email_ID = '$email_id'";
	$data = mysqli_query($dbcon,$query);
	$num_existing_users = mysqli_num_rows($data);
	if($num_existing_users != 0)
	{
		$row = mysqli_fetch_assoc($data);
		$uid = $row['User_ID'];
		?>
			</div>	
			<p class="text_error"><br><br> The email id already exists (<?php echo $uid; ?>)! Please choose other email id.</p>
		<div id="wrapper"><a href='javascript:history.go(-1)'>Back</a></div>	
			<?php
	}
	else
	{
		// Create the activation code:
		$activation_code = md5(uniqid(rand(), true));

		// Add the user to the database:
		$query = "INSERT INTO Accounts (Email_ID, Password, Active)
			VALUES ('$email_id', SHA1('$password'), '$activation_code')";
		mysqli_query($dbcon,$query) or trigger_error("Query: $query\n<br />MySQLError: " . mysqli_error($dbcon));
		if (mysqli_affected_rows($dbcon) == 1)
		{ 
			// If it ran OK.
			// Send the email:
			$body = "Thank you for registering at IIT Mandi. To activate your account, please click on this link (the following line should appear as a clickable link, if ti does not, copy-paste it in address bar of your browser.):\n\n";
			$body .= 'http://'.BASE_URL.'/user/activate.php?x=' . urlencode($email_id) . "&y=$activation_code";

			mail($email_id,'Registration Confirmation', $body,'From: techhelp@iitmandi.ac.in');
			// Finish the page:
			echo '<br/><br/><br/><br/><div id = "wrapper"><div id="help"><br/><b>Thank you for registering! <br/>A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.<br/></b></div></div>';
			include ('../includes/html/footer.html'); // Include the HTML footer.

			$query = "SELECT User_ID FROM Accounts WHERE Email_ID = '$email_id'";
			$data = mysqli_query($dbcon,$query);
			$row = mysqli_fetch_array($data);
			$user_id = $row['User_ID'];

			//Insert a row in the froms table and set all form_submited values to 0
			$query = "INSERT INTO Forms_Submitted (User_ID) VALUES('$user_id')";
			mysqli_query($dbcon,$query);

			//Crate a directory for user's uploads
			$old = umask(0);
			mkdir("../../../oaf_uploads/$user_id", 0755);
			umask($old); 
		}
		mysqli_close($dbcon);
	}
}
?>
