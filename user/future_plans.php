<?php
	include('oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/oaf_vars.php');
	include ($includes_path.'/php/functions.php');
	include($includes_path.'/js/is_selected.js');
	
	$error_msg = "";

		  $query = "SELECT Future_Plans FROM Forms_Submitted WHERE User_ID = '$user_id'";
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
    $query = "SELECT * FROM Future_Plans WHERE User_ID = '$user_id'";
    $data = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) 
    {
	  $research_plan = $row['Research_Plans'];
	  
	  if($research_plan == '1')
	     $error_msg_research = 'Uploaded';
	  else 
	      $error_msg_research = 'Not uploaded';
	      
	  $teaching_plan = $row['Teaching_Plans'];
	  
	  if($teaching_plan == '1')
	     $error_msg_teaching = 'Uploaded';
	  else 
	      $error_msg_teaching = 'Not uploaded';    

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

 <p class ="texta">Future Plans</p>
<?php
		$data =<<<EOD
<fieldset class="fieldset">
  <table>
<tr>
	<td class="labelcell"><label for="research_plan">Research Plans*</label></td>
		  <td class="fieldcell">$error_msg_research</td>
</tr>
<tr>
	<td class="labelcell"><label for="teaching_plan">Teaching Plans*</label></td>
		  <td class="fieldcell">$error_msg_teaching</td>
</tr>
<tr>
	<td colspan=2></td>
</tr>
<tr>
EOD;

	echo $data;
?>
	<tr><td colspan="3"><hr/></td></tr>

		<td class="fieldcell" colspan=1><input type="button" value="Upload again" onclick='parent.location="../forms/<?php echo getScriptName(); ?>"'></td>
</tr>
</table>
</fieldset>
</form>

<br>
<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= 'other_information.php' ">
<input type="button" value="Next" onclick="parent.location= 'general_questions.php'">
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
