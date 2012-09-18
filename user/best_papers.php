<?php
	include('oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/oaf_vars.php');
	include ($includes_path.'/php/functions.php');

	$error_msg = '';

		  $query = "SELECT Best_Papers FROM Forms_Submitted WHERE User_ID = '$user_id'";
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

			$query = "SELECT Papers_Uploaded FROM Best_Papers WHERE User_ID = '$user_id'";
		  	$data = mysqli_query($dbcon, $query);
			$row = mysqli_fetch_array($data);
			if ($row == NULL) 
			{
				$error_msg ="There was a problem accessing your profile.";
			}
		  	$uploaded_msg = ($row['Papers_Uploaded'] == 1)? "Uploaded" : "Notuploaded";

?>

<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<p class="texta">Three Best Papers</p>
<?php echo '<p class = "error_text">'.$error_msg.'</p>'; ?>
<fieldset class="fieldset">
<table>
	<tr>
			<td class = 'labelcell'><label for = 'BestPap_1'><b>Best Paper 1</b></label>
			</td>
			<td class = 'labelcell'><?php echo $uploaded_msg; ?>
			</td>
	</tr>
	<tr>
			<td class = 'labelcell1'><label for = 'BestPap_2'><b>Best Paper 2</b></label>
			</td>
			<td class = 'fieldcell'><?php echo $uploaded_msg; ?>
			</td>
	</tr>
	<tr>
			<td class = 'labelcell1'><label for = 'BestPap_3'><b>Best Paper 3</b></label>
			</td>
			<td class = 'fieldcell'><?php echo $uploaded_msg; ?>
			</td>
	</tr>
	<tr><td colspan="3"><hr></td></tr>

	 <tr>
		<td class="fieldcell" >
			<input type="button" class="navbuttons" value="Upload Again" onclick='parent.location="../forms/<?php echo getScriptName(); ?>"'></td>
     </tr>
	</tr>
</table>
</fieldset>
</form>

<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= 'research_papers.php' ">
<input type="button" value="Next" onclick="parent.location= 'thrust_areas_sop.php' ">
</div>

</div>
</div>

<div id="leftcolumn">
<?php include($includes_path.'/php/sidemenu.php');?>
</div>

<div id="rightcolumn">
<div id="help">
<h3>This may help you</h3>
<ul>
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
<li>Ensure that the size of PDFs is 200KB or less.</li>
<li>All the fields are compulsory.</li>
</ul>
</div>
</div>

</div>

<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
