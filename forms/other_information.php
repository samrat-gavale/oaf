<?php
	include('../user/oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include($includes_path.'/php/oaf_vars.php');
	include($includes_path.'/php/functions.php');
	
	$error_msg = "";
   if (isset($_POST['submit']))
   {
 	$memberships = mysqli_real_escape_string($dbcon, trim($_POST['Memberships']));
	$proficiencies = mysqli_real_escape_string($dbcon, trim($_POST['Proficiencies']));
	$other_info = mysqli_real_escape_string($dbcon, trim($_POST['Other_Info']));
	
$awards = $_FILES['Awards']['name'];
    $awards_type = $_FILES['Awards']['type'];
    $awards_size = $_FILES['Awards']['size']; 
	$extracurriculars = $_FILES['Extracurriculars']['name'];
    $extracurriculars_type = $_FILES['Extracurriculars']['type'];
    $extracurriculars_size = $_FILES['Extracurriculars']['size'];
	$error = false;
 
if (!$error)
    {
      if (!empty($proficiencies) && !empty($awards) && !empty($extracurriculars))
			{
				if (($extracurriculars_type == 'application/pdf') && 
					  ($awards_type == 'application/pdf') && ($extracurriculars_size > 0) &&
					  ($extracurriculars_size <= MAXFILESIZE_EXTRACUR) && ($awards_size > 0) && ($awards_size <= MAXFILESIZE_AWARDS))
					  {
						if (($_FILES['Extracurriculars']['error'] == 0) && ($_FILES['Awards']['error'] == 0)) 
							{
								// Move the file to the target upload folder
								$target_aw = $uploaddir.'Awards.pdf';
								$target_ex = $uploaddir.'Extracurriculars.pdf';
								if( move_uploaded_file($_FILES['Awards']['tmp_name'], $target_aw) &&
							    move_uploaded_file($_FILES['Extracurriculars']['tmp_name'], $target_ex) ) 
								{
								$query = "UPDATE Other_Information SET Memberships = '$memberships', Proficiencies = '$proficiencies', " .
									  "Other_Info = '$other_info', Awards = '1', Extracurriculars = '1' ". 
								"WHERE User_ID = '$user_id'"; 
								mysqli_query($dbcon, $query);

								$query = "UPDATE Forms_Submitted SET Other_Information = 1 WHERE User_ID = '$user_id'"; 
								mysqli_query($dbcon, $query);

								// Clear the score data to clear the form
								$extracurriculars = "";
								$awards = "";

								//naviate to Undergraduate academic profile
								$next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
								echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';
								mysqli_close($dbcon);
							
            exit();
            }
          else 
          {
            $error_msg = 'Sorry, there was a problem uploading your documents.';
          }
        }
      }
      else 
      {
        $error_msg = 'The document must be pdf file not greater than ' . (MAXFILESIZE_AWARDS / MB_SIZE) . ' MB in size.';
      }
		// Try to delete the temporary screen shot image file
		@unlink($_FILES['Awards']['tmp_name']);
		@unlink($_FILES['Extracurriculars']['tmp_name']);
	 }
      else
      {
		$error_msg = 'You must enter all the required data.';
      }
    }
   }// End of check for form submission
  else
  {
		  $query = "SELECT User_ID FROM Other_Information WHERE User_ID = '$user_id'";
		  $data = mysqli_query($dbcon, $query);
		  if (mysqli_num_rows($data) == 1) ;
		  else 
		  {
			  $query = "INSERT INTO Other_Information (User_ID) VALUES ('$user_id')";
			  mysqli_query($dbcon, $query)
			  or die('Error storing data!');
		  }
    // Grab the profile data from the database
    $query = "SELECT * FROM Other_Information WHERE User_ID = '$user_id'";
    $data = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) 
    {
	  $memberships = $row['Memberships'];
      $proficiencies = $row['Proficiencies'];
      $other_info = $row['Other_Info'];
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

 <p class ="texta">Other Information</p>
<?php  echo '<p class="error_text">'.$error_msg.'</p>';  ?>
 <form name="other_information" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
 <fieldset class="fieldset">
 <table>
<tr>
		<td class="labelcell"> <label for="Awards"> Awards, Honors and Recognitions</label></td>
	</tr>
	<tr>
		<td class="labelcell">( Attach pdf containing required details )</td>
	</tr>
	<tr>
		<td><input type="file" id="awards" name="Awards" /></td>
	</tr>
	<tr>
		<td class="labelcell"> <label for="Extracurriculars">Extra-curricular activities</label></td>
	</tr>
	<tr>
		<td class="labelcell">( Attach pdf containing required details )</td>
	</tr>
	<tr>
		<td><input type="file" id="extracurriculars" name="Extracurriculars" /></td>
	</tr>
	<tr><td class="fieldcell"><hr /></td></tr>
	<tr>	
		<td class="labelcell"><label for="details">Memberships, Fellowships of Professional Societies </label></td>
	</tr>
	<tr>
		<td class="fieldcell"><textarea Name="Memberships" cols="53" rows="10" 	MAXLENGTH="700"><?php if (isset($_POST['Memberships'])) echo $_POST['Memberships']; else echo trim($memberships); ?></textarea>
		</td>
	<tr><td class="fieldcell"><hr /></td></tr>
	<tr>	
		<td class="labelcell"><label for="details">Special training, Proficiency or Expertise and Relevant Information</label></td>
	</tr>
	<tr>
		<td class="fieldcell"><textarea Name="Proficiencies" cols="53" rows="10" MAXLENGTH="700"><?php if (isset($_POST['Proficiencies'])) echo $_POST['Proficiencies']; else echo trim($proficiencies); ?></textarea>
		</td>
	</tr>
	<tr><td class="fieldcell"><hr /></td></tr>
	<tr>	
		<td class="labelcell"><label for="details">Any other information not stated before</label></td>
	</tr>
	<tr>
		<td class="fieldcell"><textarea Name="Other_Info" cols="53" rows="10" MAXLENGTH="700"><?php if (isset($_POST['Other_Info'])) echo $_POST['Other_Info']; else echo trim($other_info); ?></textarea>
		</td>
	</tr>

	<tr><td colspan="3"><hr/></td></tr>

<tr>
		<td class="fieldcell"><input type="submit" class="navbuttons" name="submit" value="Submit" <?php if($confirmed) echo "disabled"; ?> />

		<?php
			$next_url_cancel = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
			$next_url_skip = '../user/future_plans.php';
		?>
			
		<input type="button" class="navbuttons" name="cancel" value="Cancel" onclick="parent.location= '<?php echo $next_url_cancel; ?>' "
										<?php if($confirmed) echo "disabled"; ?> /></td>
</tr>
</table>
</fieldset>
</form>

		<?php
			include($includes_path.'/js/form_validators/other_information.js');
		?>
		
<br>
<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= '../user/patents.php' ">
<input type="button" value="Next" onclick="parent.location= '../user/future_plans.php'
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
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
<li>Please upload only pdf documents of size <i>2MB</i> or less.</li>
<li>Try to be precise while mentioning details in the pdfs.</li>
</ul>
</div>
</div>

</div>

<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
