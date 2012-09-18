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

		  $query = "SELECT Thrust_Areas_SOP FROM Forms_Submitted WHERE User_ID = '$user_id'";
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
    $query = "SELECT * FROM Thrust_Areas_SOP WHERE User_ID = '$user_id'";
    $data = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) 
    {
		switch ($row['Thrust_Area'])
		{
			case 1 : $thrust_areas = 'Materials for electronics and electrical engineering, including meta-materials and nano-materials';
			case 2 : $thrust_areas = 'Materials for electronics and electrical engineering, including meta-materials and nano-materials';
			case 3 : $thrust_areas = 'Materials for electronics and electrical engineering, including meta-materials and nano-materials';
			case 4 : $thrust_areas = 'Materials for electronics and electrical engineering, including meta-materials and nano-materials';

		}
		$sop = $row['SOP'];
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

 <p class ="texta">Statement of Purpose</p>
<?php
		$data =<<<EOD
<fieldset class="fieldset">
  <table>
	<tr>
		 <td class="labelcell"><label for="thrust_areas" >Thrust Areas</label></td>
	</tr>
	<tr>
		 <td class="fieldcell" colspan = "2">$thrust_areas</td>
	</tr>
	<tr>
		 <td class="labelcell1" ccolspan="2"><label for="sop">STATEMENT OF PURPOSE(specific to IIT Mandi)</label></td>
	</tr>
	<tr>
		 <td class="fieldcell" colspan = "2">$sop</td>
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
<input type="button" value="Back" onclick="parent.location= 'best_papers.php' ">
<input type="button" value="Next" onclick="parent.location= 'patents.php'">
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
<li>Choose only one of the listed thrust areas for your SOP</li>
<li>The SOP should be specific to IIT Mandi</li>
<li>Explain your plans inreference to IIT Mandi's vision and goals</li>
<li>For the list of other thrust areas refer to <a href="http://www.iitmandi.ac.in/administration/files/FACULTY%20ADVT%202011-2%2005-03-11.pdf" target="blank">Recruitment Advertisement</a></li>
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
</ul>
</div>
</div>

</div>

<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
