<?php
	include('../user/oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/functions.php');
	
	$error_msg = "";
   if (isset($_POST['submit']))
   {
 	$q1 = mysqli_real_escape_string($dbcon, trim($_POST['Q1']));
    $q2 = mysqli_real_escape_string($dbcon, trim($_POST['Q2']));
    $q3 = mysqli_real_escape_string($dbcon, trim($_POST['Q3']));
    $q4 = mysqli_real_escape_string($dbcon, trim($_POST['Q4']));
    $q5 = mysqli_real_escape_string($dbcon, trim($_POST['Q5']));
	$error = false;
 
if (!$error)
    {
      if (!empty($q1) && !empty($q2) && !empty($q3) && !empty($q4) && !empty($q5))
			{
								$query = "UPDATE General_Questions SET Question_1 = '$q1', Question_2 = '$q2', Question_3 = '$q3', Question_4 = '$q4', Question_5 = '$q5 ' WHERE User_ID = '$user_id'"; 
								mysqli_query($dbcon, $query);

								$query = "UPDATE Forms_Submitted SET General_Questions = 1 WHERE User_ID = '$user_id'"; 
								mysqli_query($dbcon, $query);

								//naviate to Undergraduate academic profile
								$next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
								echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';
								mysqli_close($dbcon);
							
            exit();
            }
            else
			{
				$error_msg = 'You must enter all the required data.';
			}
		}
  }// End of check for form submission
  else
  {
		  $query = "SELECT User_ID FROM General_Questions WHERE User_ID = '$user_id'";
		  $data = mysqli_query($dbcon, $query);
		  if (mysqli_num_rows($data) == 1) ;
		  else 
		  {
			  $query = "INSERT INTO General_Questions (User_ID) VALUES ('$user_id')";
			  mysqli_query($dbcon, $query)
			  or die('Error storing data!');
		  }
    // Grab the profile data from the database
    $query = "SELECT * FROM General_Questions WHERE User_ID = '$user_id'";
    $data = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) 
    {
	  $q1 = $row['Question_1'];
	  $q2 = $row['Question_2'];
      $q3 = $row['Question_3'];
      $q4 = $row['Question_4'];
      $q5 = $row['Question_5']; 
      }
    else 
    {
      $error_msg = 'There was a problem accessing your profile.';
    }
   }
?>
<style>
.fieldset
{
width:425px;
}
</style>
<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">

 <p class ="texta">General Questions</p>
<?php  echo '<p class="error_text">'.$error_msg.'</p>';  ?>
 <form name="general_questions" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
 <fieldset class="fieldset">
 <table>
<tr>
<td class="labelcell"><label for="Q1" ><strong>1. Has there been any break in your academic career? If so, give details thereof with reasons.</strong></label></td>
</tr>

<tr>
<td class="fieldcell"><textarea Name="Q1" cols="53" rows="4"><?php if (isset($_POST['Q1'])) echo $_POST['Q1']; else echo trim($q1); ?></textarea></td>
</tr>
<tr><td><hr></td></tr>
<tr>
<td class="labelcell"><label for="Q2" ><strong>2. Have you been punished during your studies at College/University? If so, give details.</strong></label></td>
</tr>

<tr>
<td class="fieldcell"><textarea Name="Q2" cols="53" rows="4"><?php if (isset($_POST['Q2'])) echo $_POST['Q2']; else echo trim($q2); ?></textarea></td>
</tr>
<tr><td><hr></td></tr>

<tr>
<td class="labelcell" ><label for="Q3" ><strong>3. Have you been punished during your services or convicted by Court of Law?  If so, give details</strong></label></td>
</tr>
<tr>
<td class="fieldcell"><textarea Name="Q3" cols="53" rows="4"><?php if (isset($_POST['Q3'])) echo $_POST['Q3']; else echo trim($q3); ?></textarea></td>
</tr>
<tr><td><hr></td></tr>

<tr>
<td class="labelcell"><label for="Q4" ><strong>4. Were you at any time declared medically unfit or asked to submit your resignation or discharged or dismissed? If yes,give details.</strong></label></td>
</tr>
<tr></tr>
<tr>
<td class="fieldcell"><textarea Name="Q4" cols="53" rows="4"><?php if (isset($_POST['Q4'])) echo $_POST['Q4']; else echo trim($q4); ?></textarea></td>
</tr>
<tr><td><hr></td></tr>

<tr>
<td class="labelcell"><label for="Q5" ><strong>5. Do you have any court cases pending as one of the parties? If yes give details.</strong></label></td>
</tr>

<tr>
<td class="fieldcell"><textarea Name="Q5" cols="53" rows="4"><?php if (isset($_POST['Q5'])) echo $_POST['Q5']; else echo trim($q5); ?></textarea></td>
</tr>

	<tr><td colspan="3"><hr/></td></tr>

<tr>
		<td class="fieldcell" colspan=1><input class="navbuttons" type="submit" name="submit" value="Submit" <?php if($confirmed) echo "disabled"; ?> />

		<?php
			$next_url_cancel = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
			$next_url_skip = '../user/referees.php';
		?>
			
			<input type="button" class="navbuttons" name="cancel" value="Cancel" onclick="parent.location= '<?php echo $next_url_cancel; ?>' "
			<?php if($confirmed) echo "disabled"; ?> /></td>
</tr>
</table>
</fieldset>
</form>

		<?php
			include($includes_path.'/js/form_validators/general_questions.js');
		?>
		
<br>
<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= '../user/future_plans.php' ">
<input type="button" value="Next" onclick="parent.location= '../user/referees.php'
 ">
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
	<li>All the questions are compulsory.</li>
	<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
</ul>
</div>
</div>

</div>

<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
