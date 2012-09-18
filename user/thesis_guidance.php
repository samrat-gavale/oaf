<?php
	include('oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/oaf_vars.php');
	include ($includes_path.'/php/functions.php');
	$error_msg = "";

		  $query = "SELECT Thesis_Guidance FROM Forms_Submitted WHERE User_ID = '$user_id'";
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
			$query = "SELECT List_Uploaded, Completed, In_Progress FROM Thesis_Guidance WHERE User_ID = '$user_id'";
		  	$data = mysqli_query($dbcon, $query);
			$row = mysqli_fetch_array($data);
		  	$list_uploaded = ($row['List_Uploaded'] == 1)? 1 : 0;
			$completed = $row['Completed'];
			$in_progress = $row['In_Progress'];
?>

<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
<p class="texta">Thesis Supervised</p>
<?php  echo '<p class="error_text">'.$error_msg.'</p>';

$data =<<<EOD

<fieldset class="fieldset">
 <table>
 <tbody>
	 <tr>
		 <td colspan="2" class="labelcell"><label for="No of Suprevisions completed" >No. of supervisions completed</label></td>
		 <td class="fieldcell"><center>$completed</center></td>
	 </tr>
	 <tr>
		 <td colspan="2" class="labelcell"><label for="name_of_student" >No. of supervisions in progress</label></td>
		 <td class="fieldcell"><center>$in_progress</center></td>
	 </tr>

	<tr><td colspan="3"><hr></td></tr>

 	<tr>
			<td class = 'labelcell' colspan="2"><label for = 'Guidance_List	'>List of the thesis supervision</label>
			</td>
EOD;
	if($list_uploaded)
	{
		$data.= '<td class = "fieldcell">Uploaded</td>';
	}
	else
	{
		$data.= '<td class = "fieldcell" >Not Uploaded</td>';
	}

	$data.='</tr>';

echo $data;
?>
	<tr><td colspan="3"><hr></td></tr>

	 <tr>
		<td class="fieldcell" >
			<input type="button" class="navbuttons" value="Edit" onclick='parent.location="../forms/<?php echo getScriptName(); ?>"'></td>
     </tr>
 </table>
</fieldset>
    </form>

<div id="navbuttons">
		<input type="button" value="Back" onclick="parent.location.href = 'sponsored_research.php '" />
		<input type="button" value="Next" onclick="parent.location.href = 'industrial_exp.php '" />
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
<li>Classify the thesis supervisions according to the degree level of students as follows-
  <ol>
	<li>Doctoral</li>
	<li>M. Tech</li>
	<li>MS (Research)</li>
  </ol>
</li>
<li>Further, classify supervisions under each of these categories as 'Completed' and 'In Progress'.</li>
<li>You may not have supervised thesis of each of these categories, but whatever supervision has been done should be categorized as mentioned above.</li>
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
</ul>
</div>
</div>

</div>
<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
