<?php
	include('../user/oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/oaf_vars.php');
	include ($includes_path.'/php/functions.php');

	$error_msg = '';
// Check if the form has been submitted:
if(isset($_POST['submit'])) 
{
	// Check for an uploaded file:
	if(  !(empty($_FILES['BestPap_1']['name']) || empty($_FILES['BestPap_2']['name']) || empty($_FILES['BestPap_3']['name'])) )
	  {
		// Validate the type. Should be PDF.
		if( in_array($_FILES['BestPap_1']['type'], $allowed_types_docs) && ($_FILES['BestPap_1']['size']<= MAXFILESIZE_BEST_PAPERS) &&
			in_array($_FILES['BestPap_2']['type'], $allowed_types_docs) && ($_FILES['BestPap_2']['size']<= MAXFILESIZE_BEST_PAPERS) &&
			in_array($_FILES['BestPap_3']['type'], $allowed_types_docs) && ($_FILES['BestPap_3']['size']<= MAXFILESIZE_BEST_PAPERS)
		  )
		{
			// Move the file over.
		   if( move_uploaded_file($_FILES['BestPap_1']['tmp_name'],$uploaddir.'Best Paper 1.pdf') &&
			   move_uploaded_file($_FILES['BestPap_2']['tmp_name'],$uploaddir.'Best Paper 2.pdf') &&
			   move_uploaded_file($_FILES['BestPap_3']['tmp_name'],$uploaddir.'Best Paper 3.pdf')
			  )
			{
					echo 'The files has been uploaded!';
					$query = "UPDATE Best_Papers SET Papers_Uploaded = '1' WHERE User_ID = '$user_id'"; 
					mysqli_query($dbcon, $query);
					
					$query = "UPDATE Forms_Submitted SET Best_Papers = '1' WHERE User_ID = '$user_id'"; 
					mysqli_query($dbcon, $query);
					
					//naviate to next page
					$next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
					echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';

					unlink($_FILES['BestPap_1']['tmp_name']);
					unlink($_FILES['BestPap_2']['tmp_name']);
					unlink($_FILES['BestPap_3']['tmp_name']);
						
					exit();
            }
            else
            {
			$error_msg = "Sorry, there was a problem in uploading the files.";
			}
		}
		else
		{
			$error_msg = "All files should be PDF of size ".(MAXFILESIZE_BEST_PAPERS / 1024)."KB or less.";
		}
	}
	else
	{
		//Not all uploaded
		$error_msg =  "Please upload all the files.";
	}
}
	else
	{
			$query = "SELECT Papers_Uploaded FROM Best_Papers WHERE User_ID = '$user_id'";
		  	$data = mysqli_query($dbcon, $query);
		  	if (mysqli_num_rows($data) == 1)
			{
				$row = mysqli_fetch_array($data);
		  		$papers_uploaded = ($row['Papers_Uploaded'] == 1)? 1 : 0;
			}
		  	else
		  	{
			  $query = "INSERT INTO Best_Papers (User_ID) VALUES ('$user_id')";
			  mysqli_query($dbcon, $query)
			  or die('Error storing data!');
		  	}
    // Grab the profile data from the database
    $query = "SELECT Papers_Uploaded FROM Best_Papers WHERE User_ID = '$user_id'";
    $data = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_array($data);

    if ($row == NULL) 
    {
		$error_msg ="There was a problem accessing your profile.";
    }
   }
 // End of the submitted conditional.
?>

<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
<form name="best_papers" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<p class="texta">Three Best Papers</p>
<?php echo '<p class = "error_text">'.$error_msg.'</p>'; ?>
<fieldset class="fieldset">
<table>
	<tr>
			<td class = 'labelcell'><label for = 'BestPap_1'><b>Best Paper 1</b> Published</label>
			</td>
	</tr>
	<tr>
			<td class = 'fieldcell'><input type="file" name="BestPap_1" />
			</td>
	</tr>
	<tr>
			<td class = 'labelcell'><label for = 'BestPap_2'><b>Best Paper 2</b> Published</label>
			</td>
	</tr>
	<tr>
			<td class = 'fieldcell'><input type="file" name="BestPap_2" />
			</td>
	</tr>
	<tr>
			<td class = 'labelcell1'><label for = 'BestPap_3'><b>Best Paper 3</b> Published</label>
			</td>
	</tr>
	<tr>
			<td class = 'fieldcell'><input type="file" name="BestPap_3" />
			</td>
	</tr>
	<tr>
		<td class="fieldcell" colspan="1">
			<input type="submit" class="navbuttons" name="submit" value="Submit" <?php if($confirmed) echo "disabled"; ?> />

		<?php
			$next_url_cancel = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
			$next_url_skip = '../user/thrust_areas_sop.php';
		?>

			<input type="button" class="navbuttons" name="cancel" value="Cancel" onclick="parent.location= '<?php echo $next_url_cancel; ?>' "
										<?php if($confirmed) echo "disabled"; ?> /></td>
	</tr>
</table>
</fieldset>
</form>

		<?php
			include($includes_path.'/js/form_validators/best_papers.js');
		?>

<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= '../user/research_papers.php' ">
<input type="button" value="Next" onclick="parent.location= '../user/thrust_areas_sop.php' ">
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
