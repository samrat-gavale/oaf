<?php
	include('oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/functions.php');
	
	$error_msg = "";

		  $query = "SELECT General_Questions FROM Forms_Submitted WHERE User_ID = '$user_id'";
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
<?php
		$data =<<<EOD
<fieldset class="fieldset">
  <table>
	<tr>
		 <td class="labelcell1"><label for="Q1" >1. Has there been any break in your academic career? If so, give details thereof with reasons.</label></td>
	</tr>
	<tr>
		 <td class="fieldcell1">$q1</td>
	</tr>
	<tr><td><hr/></td></tr>
	<tr>
		 <td class="labelcell1"><label for="Q2" >2. Have you been punished during your studies at College/University? If so, give details.</label></td>
	</tr>
	<tr>
		 <td class="fieldcell1">$q2</td>
	</tr>
	<tr><td><hr/></td></tr>
	<tr>
	 	 <td class="labelcell1" colspan="2"><label for="Q3" >3. Have you been punished during your services or convicted by Court of Law?  If so, give details.</label></td>
	</tr>
	<tr>
 	 <td class="fieldcell1">$q3</td>
	</tr>
	<tr><td ><hr/></td></tr>
	<tr>
	 	 <td class="labelcell"><label for="Q4" >4. Were you at any time declared medically unfit or asked to submit your resignation or discharged or dismissed? If yes,give details.</label></td>
	</tr>
	<tr>
 	 <td class="fieldcell1">$q4</td>
	</tr>
	<tr><td><hr/></td></tr>
	<tr>
	 	 <td class="labelcell1"><label for="Q5" >5. Do you have any court cases pending as one of the parties? If yes give details.</label></td>
	</tr>
	<tr>
	 	 <td class="fieldcell1">$q5</td>
	</tr>
<tr>
EOD;

	echo $data;
?>
	<tr><td><hr/></td></tr>

		<td class="fieldcell"><input type="button" value="Edit" onclick='parent.location="../forms/<?php echo getScriptName(); ?>"'></td>
</tr>
</table>
</fieldset>
</form>

<br>
<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= 'future_plans.php' ">
<input type="button" value="Next" onclick="parent.location= 'referees.php'">
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
