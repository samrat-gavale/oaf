<?php
	include('oaf_paths.php');
	include('includes/php/set_session.php');
	include('includes/html/header.html');
	include('includes/php/check_login.php');
	require_once('includes/php/mysqlcon.php');
	include ('includes/php/oaf_vars.php');

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
				if (  ($extracurriculars_type == 'application/pdf') && 
					  ($awards_type == 'application/pdf') && ($extracurriculars_size > 0) &&
					  ($extracurriculars_size <= MAXFILESIZE_EXTRACUR) && ($awards_size > 0) && ($awards_size <= MAXFILESIZE_AWARDS)
					) 
					 {
						if (($_FILES['Extracurriculars']['error'] == 0) && ($_FILES['Awards']['error'] == 0))
						{
							// Move the file to the target upload folder
							$target_aw = $uploaddir.'/awards.pdf';
							$target_ex = $uploaddir.'/extracurriculars.pdf'; 
							if( move_uploaded_file($_FILES['Awards']['tmp_name'], $target_aw) &&
							    move_uploaded_file($_FILES['Extracurriculars']['tmp_name'], $target_ex) ) 
							{
							 $query = "UPDATE Other_Information SET Memberships = '$memberships', Proficiencies = '$proficiencies', " .
									  "Other_Info = '$other_info', Awards = '1', Extracurriculars = '1' ".
									  "WHERE User_ID = '" . $_SESSION['user_id'] . "'"; 
							 mysqli_query($dbcon, $query);
							 
							 $query = "UPDATE Forms_Submitted SET Other_Information = 1 WHERE User_ID = '" . $_SESSION['user_id'] . "'";
							 mysqli_query($dbcon, $query);

							 //naviate to future plans
							 $futureplan_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/future_plans.php';
							 header('Location: ' . $futureplan_url);
							 mysqli_close($dbcon);
							 
							// Clear the score data to clear the form
							$extracurriculars = "";
							$awards = "";
							exit();
							}
							else 
							{

							$error_msg = "Sorry, there was a problem uploading your documents.";
							}
						}
					}
					else 
					{
					$error_msg = "The document must be pdf file not larger than ' . (MAXFILESIZE_AWARDS / 1024) . ' KB in size.";
					}

					// Try to delete the temporary screen shot image file
					@unlink($_FILES['Awards']['tmp_name']);
					@unlink($_FILES['Extracurriculars']['tmp_name']);
			}
      else
      {
       $error_msg = "You must enter all the data.";
      }
    } 
   }// End of check for form submission
  else 
  {
		  $query = "SELECT User_ID FROM Other_Information WHERE User_ID = '" . $_SESSION['user_id'] . "'";
		  $data = mysqli_query($dbcon, $query);
		  if (mysqli_num_rows($data) == 1) ;
		  else 
		  {
			  $query = "INSERT INTO Other_Information (User_ID) VALUES ('" . $_SESSION['user_id'] . "')";
			  mysqli_query($dbcon, $query)
			  or die('Error storing data!');
		  }
    // Grab the profile data from the database
    $query = "SELECT * FROM Other_Information WHERE User_ID = '" . $_SESSION['user_id'] . "'";
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
     $error_msg =  "There was a problem accessing your profile.";
    }
   }
?>

<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
<h3 class="texta">Other Information</h3>
<form  enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAXFILESIZE_AWARDS; ?>" />  <!--  MAXFILESIZE_EXTRACUR can also be used instead -->
<fieldset class="fieldset1">
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
	<tr>    
     	 <td class="button"><input type="submit" name="submit" value="Save and Proceed" <?php if($confirmed) echo "disabled"; ?> /></td>   
	</tr> 
</table>
</fieldset>
</form>
<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= 'patents.php' ">
<input type="button" value="Skip this Page" onclick="parent.location= 'future_plans.php' ">
</div>

</div>
</div>

<div id="leftcolumn">
<?php include('includes/php/sidemenu.php');?>
</div>

<div id="rightcolumn">
<div id="help">
<h3>This may help you</h3>
<ul>
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
<li>The docments attached sholud be of PDF format ONLY.</li>
<li>Try to be precise while mentioning details in the pdfs.</li>
</ul>
</div>
</div>

</div>

<?php include('includes/html/footer.html'); ?>
</body>
</html>
