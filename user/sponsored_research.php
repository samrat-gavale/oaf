<?php
	include('oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/oaf_vars.php');
	include ($includes_path.'/php/functions.php');
	$error_msg = "";

		  $query = "SELECT Sponsored_Research_Projects FROM Forms_Submitted WHERE User_ID = '$user_id'";
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

			$query = "SELECT List_Uploaded, Completed_Amount, Completed_Nos, In_Progress_Amount, In_Progress_Nos FROM Sponsored_Research_Projects WHERE User_ID = $user_id";
		  	$data = mysqli_query($dbcon, $query);

	  		$row = mysqli_fetch_array($data);
	  		$list_uploaded = ($row['List_Uploaded'] == 1)? 1 : 0;
			$completed_amount = $row['Completed_Amount'];
			$completed_nos = $row['Completed_Nos'];
			$in_progress_amount = $row['In_Progress_Amount'];
			$in_progress_nos = $row['In_Progress_Nos'];
?>

</head>
<body>
<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
<p class="texta">Sponsored Research Projects</p>
<?php
	echo '<p class="error_text">'.$error_msg.'</p>';
	$data =<<<EOD
    <fieldset class="fieldset">
 <table>
 <tbody>
 	 <tr>
		 <td class="labelcell" colspan="2"><label for="No of Sponsored Projects Completed" >No of Sponsored Projects completed</label></td>
		 <td class="fieldcell" ><center>$completed_nos</center></td>
	 </tr>
	<tr>
			<td class="labelcell" colspan="2"><label for="Completed_Amount">Total Amount of Grant</label></td>
			<td class="fieldcell"><center>$completed_amount</center></td>
	</tr>

 	 <tr>
		 <td class="labelcell" colspan="2"><label for="No of Sponsored Projects In Progress" >No of Sponsored Projects In Progress</label></td>
		 <td class="fieldcell"><center>$in_progress_nos</center></td>
	 </tr>
	 <tr>
			<td class="labelcell" colspan="2"><label for="In_Progress_Amount">Total Amount of Grant</label></td>
			<td class="fieldcell" align="center"><center>$in_progress_amount</center></td>
	</tr>

	<tr><td colspan="2"><hr></td></tr>

	 <tr>
			<td class = 'labelcell' colspan="2" align="center"><label for = 'Projects_List'>List and description of the projects.</label>
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
	<tr><td colspan="2"><hr></td></tr>

	 <tr>
		<td class="fieldcell" >
			<input type="button" class="navbuttons" value="Edit" onclick='parent.location="../forms/<?php echo getScriptName(); ?>"'></td>
     </tr>
  </tbody>
 </table>
    </fieldset>
    </form>
 
 <div id="navbuttons">   
    	<input type="button" value="Back" onclick="parent.location.href = 'teaching_exp.php '" size = "15" />
		<input type="button" value="Next" onclick="parent.location.href = 'thesis_guidance.php '" size = "15" /><br /><br />
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
<li>Please upload only PDF document of size 1MB or less.</li>
<li>Categorize the projects as 'Completed' and 'In Progress'</li>
<li>Include a breif description of each project.</li>
<li>The description should include all the necessary information like <b>name of sponsoring organisation, period of funding, amount of grant, co investigators(if any),</b> etc.</li>
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
</ul>
</div>

</div>

</div>
<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
