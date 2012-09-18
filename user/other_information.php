<?php
	include('oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/oaf_vars.php');
	include ($includes_path.'/php/functions.php');
	
	$error_msg = "";

		  $query = "SELECT Other_Information FROM Forms_Submitted WHERE User_ID = '$user_id'";
		  $row = mysqli_fetch_array(mysqli_query($dbcon, $query))
				  or
				  trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbcon));
		  if ($row[0] == 1) ;
		  else 
		  {
			$next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('forms');
			echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';
			mysqli_close($dbcon);
			exit();
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
      $awards = $row['Awards'];
	  $extracurriculars = $row['Extracurriculars'];
	
	  if($awards == '1')
	     $error_msg_awards = 'You have already uploaded your awards document.';
	  else 
	     $error_msg_awards = 'You have not yet uploaded your awards document.';
	      
	  if($extracurriculars == '1')
			$error_msg_extracur = 'You have already uploaded your extracurriculars document.';
		else
			$error_msg_extracur = 'You have not yet uploaded your extracurriculars document.';

      }
    else 
    {
      $error_msg = 'There was a problem accessing your profile.';
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
<?php
		$data =<<<EOD
<fieldset class="fieldset">
  <table>
	<tr>
		 <td class="labelcell" colspan="3"><label for="memberships" >Memberships</label></td><td class="fieldcell" colspan="3">$memberships</td>
	</tr>
	<tr>
		 <td class="labelcell" colspan="3"><label for="proficiencies" >Proficiencies</label></td><td class="fieldcell" colspan="3">$proficiencies</td>
	</tr>
	<tr>
	 	 <td class="labelcell" colspan="3"><label for="other_info" >Other Information</label></td><td class="fieldcell" colspan="3">$other_info</td>
	</tr>
	<tr><td colspan="3"><hr/></td></tr>
<tr>
	<td class="labelcell"><label for="awards">Awards</label></td>
		  <td class="fieldcell">$error_msg_awards</td>
</tr>
<tr>
	<td class="labelcell"><label for="extracurriculars">Extra Curriculars</label></td>
		  <td class="fieldcell">$error_msg_extracur</td>
</tr>
<tr>
	<td colspan=2></td>
</tr>
<tr>
EOD;

	echo $data;
?>
	<tr><td colspan="3"><hr/></td></tr>

		<td class="fieldcell" colspan=1><input type="button" value="Edit" onclick='parent.location="../forms/<?php echo getScriptName(); ?>"'></td>
</tr>
</table>
</fieldset>
</form>

<br>
<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= 'patents.php' ">
<input type="button" value="Next" onclick="parent.location= 'future_plans.php'">
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
