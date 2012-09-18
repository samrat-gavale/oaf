<?php
	include('../user/oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/oaf_vars.php');
	include ($includes_path.'/php/functions.php');
	include($includes_path.'/js/is_selected.js');
	
	$error_msg = "";
   if (isset($_POST['submit']))
   {
 		$research_plan = $_FILES['Research_Plan']['name'];
		$research_plan_type = $_FILES['Research_Plan']['type'];
		$research_plan_size = $_FILES['Research_Plan']['size'];
		$teaching_plan = $_FILES['Teaching_Plan']['name'];
		$teaching_plan_type = $_FILES['Teaching_Plan']['type'];
		$teaching_plan_size = $_FILES['Teaching_Plan']['size'];
		$error = false;
 
if (!$error)
    {
      if (!empty($research_plan) && !empty($teaching_plan))
			{
				if (($teaching_plan_type == 'application/pdf') && ($research_plan_type == 'application/pdf') && ($teaching_plan_size > 0)
					  && ($teaching_plan_size <= MAXFILESIZE_FUTURE_PLANS ) && ($research_plan_size > 0) && ($research_plan_size <= MAXFILESIZE_FUTURE_PLANS))
						{
							if (($_FILES['Teaching_Plan']['error'] == 0) && ($_FILES['Research_Plan']['error'] == 0)) 
							{
								// Move the file to the target upload folder
								$target_research = $uploaddir.'Research_Plan.pdf';
								$target_teaching = $uploaddir.'Teaching_Plan.pdf';
								if(move_uploaded_file($_FILES['Research_Plan']['tmp_name'], $target_research) && move_uploaded_file($_FILES['Teaching_Plan']['tmp_name'],$target_teaching)) 
								{
								$query = "UPDATE Future_Plans SET Research_Plans = '1', Teaching_Plans = '1' ". 
								"WHERE User_ID = '$user_id'"; 
								mysqli_query($dbcon, $query);

								$query = "UPDATE Forms_Submitted SET Future_Plans = 1 WHERE User_ID = '$user_id'"; 
								mysqli_query($dbcon, $query);

								// Clear the score data to clear the form
								$research_plan = "";
								$teaching_plan = "";

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
        $error_msg = 'The documents must be pdf files each not greater than ' . (MAXFILESIZE_FUTURE_PLANS / MB_SIZE). ' MB in size.';
      }
	}
	  // Try to delete the temporary screen shot image file
      @unlink($_FILES['Research_Plan']['tmp_name']);
      @unlink($_FILES['Teaching_Plan']['tmp_name']);
	 }
      
   }// End of check for form submission
  else
  {
		  $query = "SELECT User_ID FROM Future_Plans WHERE User_ID = '$user_id'";
		  $data = mysqli_query($dbcon, $query);
		  if (mysqli_num_rows($data) == 1) ;
		  else 
		  {
			  $query = "INSERT INTO Future_Plans (User_ID) VALUES ('$user_id')";
			  mysqli_query($dbcon, $query)
			  or die('Error storing data!');
		  }
    // Grab the profile data from the database
    $query = "SELECT * FROM Future_Plans WHERE User_ID = '$user_id'";
    $data = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL);
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

 <p class ="texta">Future Plans</p>
<?php  echo '<p class="error_text">'.$error_msg.'</p>';  ?>
 <form name="future_plans" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
 <fieldset class="fieldset">
 <table>
<tr>
		<td class="labelcell"> <label for="research plan">Research Plan for the next five years</label></td>
	</tr>
	<tr>
		<td class="labelcell">( A three page summary shall be provided in pdf format )</td>
	</tr>
	<tr>
		<td><input type="file" id="research" name="Research_Plan" /></td>
	</tr>
	<tr><td width="400px"><hr/></td></tr>
	<tr>
		<td class="labelcell"> <label for="teaching plan">Teaching Plan for the next three years</label></td>
	</tr>
	<tr>
		<td class="labelcell">( A one page summary shall be provided in pdf format )</td>
	</tr>
	<tr>
		<td><input type="file" id="teaching" name="Teaching_Plan" /></td>
	</tr>

	<tr><td colspan="3"><hr/></td></tr>

<tr>
		<td class="fieldcell" colspan=1><input class="navbuttons" type="submit" name="submit" value="Submit" <?php if($confirmed) echo "disabled"; ?> />
		<?php
			$next_url_cancel = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
			$next_url_skip = '../user/general_questions.php';
		?>
			
				<input type="button" class="navbuttons" name="cancel" value="Cancel" onclick="parent.location= '<?php echo $next_url_cancel; ?>' "
				<?php if($confirmed) echo "disabled"; ?> /></td>
</tr>
</table>
</fieldset>
</form>
		<?php
			include($includes_path.'/js/form_validators/future_plans.js');
		?>

<br>
<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= '../user/other_information.php' ">
<input type="button" value="Next" onclick="parent.location= '../user/general_questions.php'
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
<li>It is compulsory for all applicants to submit their teaching plan and research plan.</li>
<li>The docments attached should be in <i>PDF</i> format ONLY.</li>
<li>Try to be precise while mentioning details in the pdfs.</li>
<li>Ensure size of pdf is <i>2MB</i> or less.</li>
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
</ul>
</div>
</div>

</div>

<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
