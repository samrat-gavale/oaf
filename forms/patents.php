<?php
	include('../user/oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/functions.php');
	
	$error_msg = "";
   if (isset($_POST['submit']))
   {
 	$num_patents = mysqli_real_escape_string($dbcon, trim($_POST['Num_Patents']));
    $patents = mysqli_real_escape_string($dbcon, trim($_POST['Patents']));
	$error = false;
 
if (!$error)
    {
      if (!empty($num_patents) || ($num_patents == 0))
			{
				$query = "UPDATE Patents SET Num_Patents = '$num_patents', Patents = '$patents' WHERE User_ID = '$user_id'"; 
								mysqli_query($dbcon, $query);

								$query = "UPDATE Forms_Submitted SET Patents = 1 WHERE User_ID = '$user_id'"; 
								mysqli_query($dbcon, $query);

								//naviate to Other Information
								$next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
								echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';
								mysqli_close($dbcon);
							
            exit();
            }
            else
			{
				$error_msg = 'You must enter all the required data.';
			}
		}
   }// End of check for form submission
  else
  {
		  $query = "SELECT User_ID FROM Patents WHERE User_ID = '$user_id'";
		  $data = mysqli_query($dbcon, $query);
		  if (mysqli_num_rows($data) == 1) ;
		  else 
		  {
			  $query = "INSERT INTO Patents (User_ID) VALUES ('$user_id')";
			  mysqli_query($dbcon, $query)
			  or die('Error storing data!');
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
<?php  echo '<p class="error_text">'.$error_msg.'</p>';  ?>
 <form name="patents" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
 <fieldset class="fieldset">
 <table>
<tr>
		 <td class="labelcell"><label for="num_patents" >Number of Patents</label></td>
</tr>
<tr>
		 <td class="fieldcell"><input type="text" id="num_patents" name="Num_Patents" maxlength="2" size="13"
		    			value="<?php if (isset($_POST['Num_Patents'])) echo $_POST['Num_Patents']; else echo $num_patents; ?>" /></td>
		 	 
</tr>
<tr>
		 <td class="labelcell" colspan="3"><label for="patents" >List of Patents</label></td>
</tr>
<tr>
		 <td class="fieldcell" colspan="3"><textarea Name="Patents" cols="55" rows="12" maxlength = "2000" ><?php if (isset($_POST['Patents'])) echo trim($_POST['Patents']);
										 else echo trim($patents); ?></textarea></td>
</tr>

	<tr><td colspan="3"><hr/></td></tr>

<tr>
		<td class="fieldcell" colspan=1><input type="submit" name="submit" value="Submit" <?php if($confirmed) echo "disabled"; ?> /></td>

		<?php
			$next_url_cancel = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
			$next_url_skip = '../user/other_information.php';
		?>
			
		<td class="fieldcell" colspan=1><input type="button" name="cancel" value="Cancel" onclick="parent.location= '<?php echo $next_url_cancel; ?>' "
										<?php if($confirmed) echo "disabled"; ?> /></td>
</tr>
</table>
</fieldset>
</form>

		<?php
			include($includes_path.'/js/form_validators/patents.js');
		?>
		
<br>
<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= '../user/thrust_areas_sop.php' ">
<input type="button" value="Next" onclick="parent.location= '../user/other_information.php'
 ">
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
<li>This page is optional. If you do not have any patents, click on <i>Skip This Page</i> button.</li>
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
