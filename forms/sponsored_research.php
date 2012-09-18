<?php
	include('../user/oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/oaf_vars.php');
	include ($includes_path.'/php/functions.php');
	$error_msg = "";
	    
   if (isset($_POST['submit']))
   {
	$completed_amount = mysqli_real_escape_string($dbcon, trim($_POST['Completed_Amount']));
	$completed_nos = mysqli_real_escape_string($dbcon, trim($_POST['Completed_Nos']));
	$in_progress_amount = mysqli_real_escape_string($dbcon, trim($_POST['In_Progress_Amount']));
	$in_progress_nos = mysqli_real_escape_string($dbcon, trim($_POST['In_Progress_Nos']));
	
		if ( (!empty($completed_amount) || ($completed_amount == '0')) && (!empty($completed_nos) || ($completed_nos == '0')) && (!empty($in_progress_amount) || ($in_progress_amount == '0')) && (!empty($in_progress_nos) || ($in_progress_nos == '0')) )
		{	
			if( in_array($_FILES['Projects_List']['type'], $allowed_types_docs) && ($_FILES['Projects_List']['size']<= MAXFILESIZE_SPONSORED_PROJECTS) )
		{
			// Move the file over.
		   if( move_uploaded_file($_FILES['Projects_List']['tmp_name'],$uploaddir.'Sponsored Projects List.pdf') )
			{
					$query = "UPDATE Sponsored_Research_Projects SET List_Uploaded = '1' , Completed_Amount = '$completed_amount', ".
							 "Completed_Nos = '$completed_nos', In_Progress_Nos = '$in_progress_nos', In_Progress_Amount = '$in_progress_amount' ".
							 "WHERE User_ID = '$user_id'"; 
					mysqli_query($dbcon, $query);
					
					$query = "UPDATE Forms_Submitted SET Sponsored_Research_Projects = '1' WHERE User_ID = '$user_id'"; 
					mysqli_query($dbcon, $query);
					
					unlink($_FILES['Projects_List']['tmp_name']);

					//naviate to Undergraduate academic profile
					$next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
					echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';
					mysqli_close($dbcon);
					exit();
            }
            else
            {
			$error_msg = "Sorry, there was a problem in uploading the file.";
			}
		}
		else
		{
			$error_msg = "The should be PDF of size ".(MAXFILESIZE_SPONSORED_PROJECTS / 1024)."KB or less.";
		}
	}
	else
	{
		//Not all uploaded
		$error_msg =  "Please enter all the data.";
	}
  }

	else
	{
			$query = "SELECT List_Uploaded, Completed_Amount, Completed_Nos, In_Progress_Amount, In_Progress_Nos FROM Sponsored_Research_Projects WHERE User_ID = '$user_id'";
		  	$data = mysqli_query($dbcon, $query);
		  	if (mysqli_num_rows($data) == 1)
			{
				$row = mysqli_fetch_array($data);
				$completed_amount = $row['Completed_Amount'];
				$completed_nos = $row['Completed_Nos'];
				$in_progress_amount = $row['In_Progress_Amount'];
				$in_progress_nos = $row['In_Progress_Nos'];
			}
		  	else
		  	{
			  $query = "INSERT INTO Sponsored_Research_Projects (User_ID) VALUES ('$user_id')";
			  mysqli_query($dbcon, $query)
			  or die('Error storing data!');
				$completed_amount = '';
				$completed_nos = '';
				$in_progress_amount = '';
				$in_progress_nos = '';
		  	}
	}

?>
</head>
<body>
<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
<p class="texta">Sponsored Research Projects</p>
<?php  echo '<p class="error_text">'.$error_msg.'</p>';  ?>
  <form name="sponsored_research" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset class="fieldset">
 <table>
 <tbody>
 	 <tr>
		 <td class="labelcell"><label for="No of Sponsored Projects Completed" >No of Sponsored Projects completed</label></td>
		 <td class="fieldcell"><input type="text" name="Completed_Nos" maxlength="2" size="15"
								value="<?php if (isset($_POST['Completed_Nos'])) echo $_POST['Completed_Nos'];  else echo $completed_nos; ?>"/></td>
	 </tr>
	<tr>
			<td class="labelcell"><label for="Completed_Amount">Total Amount of Grant</label></td>
			<td class="fieldcell"><input type="text" maxlength="40" name="Completed_Amount" size="15" 
									value="<?php if (isset($_POST['Completed_Amount'])) echo $_POST['Completed_Amount']; 
											else echo $completed_amount; ?>" ></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
 	 <tr>
		 <td class="labelcell"><label for="No of Sponsored Projects In Progress" >No of Sponsored Projects In Progress</label></td>
		 <td class="fieldcell"><input type="text" name="In_Progress_Nos" maxlength="2" size="15"
								value="<?php if (isset($_POST['In_Progress_Nos'])) echo $_POST['In_Progress_Nos'];  else echo $in_progress_nos; ?>"/></td>
	 </tr>
	<tr>
			<td class="labelcell"><label for="In_Progress_Amount">Total Amount of Grant</label></td>
			<td class="fieldcell"><input type="text" maxlength="40" name="In_Progress_Amount" size="15"
									value="<?php if (isset($_POST['In_Progress_Amount'])) echo $_POST['In_Progress_Amount'];
											else echo $in_progress_amount; ?>" ></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
	 <tr>
			<td class = 'labelcell' colspan="2"><label for = 'Projects_List	'>List and description of the projects.<br/>
												(See the help on right side for the details of the list document.)</label>
			</td>
	</tr>
	<tr>
			<td class = 'fieldcell'><input type="file" name="Projects_List" />
			</td>
	 <tr>						

	<tr><td colspan="2"><hr></td></tr>

	 <tr>	
		<td class="fieldcell" colspan=1><input class="navbuttons" type="submit" name="submit" value="Submit" <?php if($confirmed) echo "disabled"; ?> />
		<?php
			$next_url_cancel = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
		?>
		<center><input type="button" class="navbuttons" name="cancel" value="Cancel" onclick="parent.location= '<?php echo $next_url_cancel; ?>' "
										<?php if($confirmed) echo "disabled"; ?> /></center></td>
     </tr>
  </tbody>
 </table>
    </fieldset>
    </form>
 
		<?php
			include($includes_path.'/js/form_validators/sponsored_research.js');
		?>

 <div id="navbuttons">   
    	<input type="button" value="Back" onclick="parent.location.href = '../user/teaching_exp.php '" size = "15" />
		<input type="button" value="Next" onclick="parent.location.href = '../user/thesis_guidance.php '" size = "15" /><br /><br />
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
<li>Please upload only PDF document of size 200KB or less.</li>
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
