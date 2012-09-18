<?php
	include('../user/oaf_paths.php');
	include($includes_path.'/html/header.html');
  // Start the session
	session_start();

  // Clear the error message
  $error_msg = "";

  // If the user isn't logged in, try to log them in
  //  user_id,email_id is for cookie while  user_ID, Email_ID is for mysql
  if (!isset($_SESSION['user_id'])) 
  {
    if (isset($_POST['submit'])) 
    {
     require_once('../includes/php/mysqlcon.php');
      // Grab the user-entered log-in data
      $user_email_id = mysqli_real_escape_string($dbcon, trim($_POST['Email_ID']));
      $user_password = mysqli_real_escape_string($dbcon, trim($_POST['Password']));
	
      if (!empty($user_email_id) && !empty($user_password)) 
      {
        // Look up the email_id and password in the database
        $query = "SELECT User_ID, Email_ID FROM Accounts WHERE Email_ID = '$user_email_id' AND Password = SHA1('$user_password') 
				  AND Active IS NULL";
        $data = mysqli_query($dbcon, $query);
		
        if (mysqli_num_rows($data) == 1)
         {	
          // The log-in is OK so set the user ID and email_id session vars (and cookies), and redirect to the home page
          $row = mysqli_fetch_array($data);
          $_SESSION['user_id'] = $row['User_ID'];
          $_SESSION['email_id'] = $row['Email_ID'];
//          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
          $home_url = 'http://'.BASE_URL.'/user/index.php';
//          header('Location: ' . $home_url);

		echo '<meta http-equiv="refresh" content="0; url=http://'.BASE_URL.'/">';

          }
        else
        {
          // The email_id/password are incorrect so set an error message
          $error_msg = 'Sorry, you must enter a valid Email Id and password to log in. '
						.'Please ensure that you have activated your account by clicking the link in the email sent at time of signing up.'
						.'If you have forgot your password <a href="forgot_pass.php">click here</a>';
        }
      }
      else 
      {
        // The email_id/password weren't entered so set an error message
        $error_msg = 'Please enter your email_id and password to log in.';
      }
    }
  }
  
  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['user_id'])) 
  {
?>
</div>   <!----------end wrapper-------------->
<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
<p class="texta">Log In</p>
<?php
    echo '<p class="error_text">' . $error_msg . '</p>';
?>
  <form name="login" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<fieldset class="fieldset">
	<table>
		<tr>
			<td class="labelcell" ><label for="email_id">Email ID</label></td>
		    <td class="fieldcell" ><input type="text" name="Email_ID" value="<?php if (!empty($user_email_id)) echo $user_email_id; ?>"/></td>
        </tr>
        <tr>
		    <td class="labelcell"><label for="password">Password</label></td>
	    	<td class="fieldcell"><input type="password" name="Password" /></td>
        </tr>
        <tr>
             <td><input type="submit" value="Log In" name="submit" /></td>
		</tr>
    </table>
    </fieldset>
  </form>

<?php
	include($includes_path.'/js/form_validators/login.js');
?>

<div id="navbuttons">
<input type="button" value="Forgot password?" onclick="parent.location= 'forgot_pass.php' ">
<input type="button" value="Home" onclick="parent.location= '../index.php' ">
</div>

</div>
</div>

<div id="leftcolumn">
</div>

<div id="rightcolumn">
<div id = "help">
<h3>Note</h3>
<ul>
	<li>Please typein your Email Id that you have chosen while you signed up in <i>Email ID</i> field.</li>
	<li>In case you forget your password, click on <i>Forgot Password</i> button.</li>
	<li>If you do not have an account, <a href="signup.php">Click Here</a> to sign up.</li>
</ul>
</div>
</div>

</div>

<?php
  }
  else 
  {
	// Confirm the successful log-in
    echo('<p class="login">You are logged in with ' . $_SESSION['email_id'] . '.</p>');
  }
  ?>
<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
