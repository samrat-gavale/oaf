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
	$completed = mysqli_real_escape_string($dbcon, trim($_POST['Completed']));
	$in_progress = mysqli_real_escape_string($dbcon, trim($_POST['In_Progress']));
   	
	if ( !empty($completed) && !empty($in_progress) && !(empty($_FILES['Guidance_List']['name'])) )
	{	
		if( in_array($_FILES['Guidance_List']['type'], $allowed_types_docs) && ($_FILES['Guidance_List']['size']<= MAXFILESIZE_THESIS_GUIDANCE) )
		{
			// Move the file over.
		   if( move_uploaded_file($_FILES['Guidance_List']['tmp_name'],$uploaddir.'Thesis Supervision List.pdf') )
			{
					echo 'The files has been uploaded!';
					$query = "UPDATE Thesis_Guidance SET List_Uploaded = '1' , Completed = '$completed', In_Progress = '$in_progress' ".
							 "WHERE User_ID = '$user_id'"; 
					mysqli_query($dbcon, $query);
					
					$query = "UPDATE Forms_Submitted SET Thesis_Guidance = '1' WHERE User_ID = '$user_id'"; 
					mysqli_query($dbcon, $query);
					
					//naviate to next page
					$next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
					echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';

					unlink($_FILES['Guidance_List']['tmp_name']);
					exit();
            }
            else
            {
			$error_msg = "Sorry, there was a problem in uploading the file.";
			}
		}
		else
		{
			$error_msg = "All files should be PDF of size ".(MAXFILESIZE_THESIS_GUIDANCE / 1024)."KB or less.";
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
			$query = "SELECT List_Uploaded, Completed, In_Progress FROM Thesis_Guidance WHERE User_ID = '$user_id'";
		  	$data = mysqli_query($dbcon, $query);
		  	if (mysqli_num_rows($data) == 1)
			{
				$row = mysqli_fetch_array($data);
				$completed = $row['Completed'];
				$in_progress = $row['In_Progress'];
			}
		  	else
		  	{
			  $query = "INSERT INTO Thesis_Guidance (User_ID) VALUES ('$user_id')";
			  mysqli_query($dbcon, $query)
			  or die('Error storing data!');
			  $completed = '';
			  $in_progress = '';
		  	}

   }
 // End of the submitted conditional.
?>

<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
<p class="texta">Thesis Supervised</p>
<?php  echo '<p class="error_text">'.$error_msg.'</p>';  ?>

  <form name="thesis_guidance" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset class="fieldset">
 <table>
 <tbody>
	 <tr>
		 <td class="labelcell"><label for="No of Suprevisions completed" >No. of supervisions completed</label></td>
		 <td class="fieldcell"><input type="text"  id="Completed" name="Completed" maxlength="2" size="15"
								value="<?php if (isset($_POST['Completed'])) echo $_POST['Completed'];  else echo $completed; ?>"/></td>
	 </tr>
	 <tr>
		 <td class="labelcell"><label for="No of Suprevisions in progress" >No. of supervisions in progress</label></td>
		 <td class="fieldcell"><input type="text"  id="In_Progress" name="In_Progress" maxlength="2" size="15"
								value="<?php if (isset($_POST['In_Progress'])) echo $_POST['In_Progress'];  else echo $in_progress; ?>"/></td>
	 </tr>
	 <tr>
			<td class = 'labelcell' colspan="2"><label for = 'Guidance_List	'>List of the thesis supervision.<br/>(See the help on right side for the datails of the list document.)</label>
			</td>
	</tr>
	<tr>
			<td class = 'fieldcell'><input type="file" name="Guidance_List" />
			</td>
	 <tr>
		<td class="fieldcell" colspan=1>
			<input type="submit" class="navbuttons" name="submit" value="Submit" <?php if($confirmed) echo "disabled"; ?> />

		<?php
			$next_url_cancel = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
			$next_url_skip = '../user/acad_qualifications.php';
		?>

			<input type="button" class="navbuttons" name="cancel" value="Cancel" onclick="parent.location= '<?php echo $next_url_cancel; ?>' "
										<?php if($confirmed) echo "disabled"; ?> /></td>
     </tr>
 </table>
    </fieldset>
    </form>

		<?php
			include($includes_path.'/js/form_validators/thesis_guidance.js');
		?>

<div id="navbuttons">
		<input type="button" value="Back" onclick="parent.location.href = '../user/sponsored_research.php '" />
		<input type="button" value="Next" onclick="parent.location.href = '../user/industrial_exp.php '" />
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
