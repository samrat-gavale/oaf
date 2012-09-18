<?php
	include('oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/functions.php');
	
	$error_msg = "";

		  $query = "SELECT Patents FROM Forms_Submitted WHERE User_ID = '$user_id'";
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
    $query = "SELECT * FROM Patents WHERE User_ID = '$user_id'";
    $data = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) 
    {
	  $num_patents = $row['Num_Patents'];
      $patents = $row['Patents'];
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

 <p class ="texta">Patents</p>
<?php
		$data =<<<EOD
<fieldset class="fieldset">
  <table>
	<tr>
		 <td class="labelcell"><label for="num_patents" >Number of Patents</label></td><td class="fieldcell">$num_patents</td>
	</tr>
	<tr>
		 <td class="labelcell"><label for="patents" >List of Patents</label></td>
		 <td></td>
	</tr>
	<tr>
		 <td class="fieldcell" colspan="2">$patents</td>
	</tr>
	
<tr>
EOD;

	echo $data;
?>
	<tr><td colspan="2"><hr/></td></tr>
	<tr>
		<td class="fieldcell" colspan=1><input type="button" value="Edit" onclick='parent.location="../forms/<?php echo getScriptName(); ?>"'></td>
	</tr>
</table>
</fieldset>
</form>

<br>
<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= 'thrust_areas_sop.php' ">
<input type="button" value="Next" onclick="parent.location= 'other_information.php'">
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
<li>This page is optional. If you do not have any patents, click on <i>Next</i> button.</li>
<li>Number of patents should include awarded as well as pending applications.</li>
<li>Please include all nesessary information about each of patent.</li>
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
</ul>
</div>
</div>

</div>

<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
