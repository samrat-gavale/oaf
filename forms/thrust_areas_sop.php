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
		$thrust_area = $_POST['Thrust_Areas'];
	   	$sop = mysqli_real_escape_string($dbcon, trim($_POST['SOP']));
		$error = false;
 
	if (!$error)
    {
      if (!empty($thrust_area) && !empty($sop))
			{
				$query = "UPDATE Thrust_Areas_SOP SET Thrust_Area = '$thrust_area', SOP = '$sop' WHERE User_ID = '$user_id'"; 
				mysqli_query($dbcon, $query);
				
				$query = "UPDATE Forms_Submitted SET Thrust_Areas_SOP = '1' WHERE User_ID = '$user_id'"; 
				mysqli_query($dbcon, $query);

								// Clear the score data to clear the form
								$photograph = "";

								//naviate to Undergraduate academic profile
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
		  $query = "SELECT User_ID FROM Thrust_Areas_SOP WHERE User_ID = '$user_id'";
		  $data = mysqli_query($dbcon, $query);
		  if (mysqli_num_rows($data) == 1) ;
		  else 
		  {
			  $query = "INSERT INTO Thrust_Areas_SOP (User_ID) VALUES ('$user_id')";
			  mysqli_query($dbcon, $query)
			  or die('Error storing data!');
		  }
    // Grab the profile data from the database
    $query = "SELECT * FROM Thrust_Areas_SOP WHERE User_ID = '$user_id'";
    $data = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) 
    {
	  $thrust_areas = $row['Thrust_Area'];
			$sop = $row['SOP'];
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

 <p class ="texta">Statement of Purpose</p>
<?php  echo '<p class="error_text">'.$error_msg.'</p>';  ?>
 <form name="thrust_areas" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
 <fieldset class="fieldset">
 <table>
<tr>
		 <td class="labelcell1"><label for="thrust_areas"><b>Thrust Areas</b></label></td>
</tr>
<tr>
		 <td class="labelcell1"><input type="radio" name="Thrust_Areas" size = "15" value="1" <?php if ((isset($_POST['Thrust_Areas']) && $_POST['Thrust_Areas'] == "1") || ($thrust_areas == "1") ) echo "checked"; ?> />Materials for electronics and electrical engineering, including meta-materials and nano-materials</td>
</tr>
<tr><td><hr/></td></tr>
<tr>
		 <td class="labelcell1"><input type="radio" name="Thrust_Areas" size = "15" value="2" <?php if ((isset($_POST['Thrust_Areas']) && $_POST['Thrust_Areas'] == "2") || ($thrust_areas == "2") ) echo "checked"; ?> />Energy-efficeint and environmentally sound infrastructure for the Himalayan region (renewable energy systems, buildings, transport networks, waste management, water resources management, etc.)</td>
</tr>
<tr><td><hr/></td></tr>
<tr>
		 <td class="labelcell1"><input type="radio" name="Thrust_Areas" size = "15" value="3" <?php if ((isset($_POST['Thrust_Areas']) && $_POST['Thrust_Areas'] == "3") || ($thrust_areas == "3") ) echo "checked"; ?> />Technologies, including IT and communications, for sustainable development (including disaster management and increasing the viability of fruit and vegetable growing through mechanisation/biotech and post-harvest value addition)</td>
</tr>
<tr><td><hr/></td></tr>
<tr>
		 <td class="labelcell1"><input type="radio" name="Thrust_Areas" size = "15" value="4" <?php if ((isset($_POST['Thrust_Areas']) && $_POST['Thrust_Areas'] == "4") || ($thrust_areas == "4") ) echo "checked"; ?> />Other (Specify in title of SOP)</td>
</tr>
<tr><td><hr/></td></tr>
<tr>
		 <td class="labelcell1"><label for="sop">STATEMENT OF PURPOSE(specific to IIT Mandi)</label></td>
</tr>
<tr>
		 <td class="fieldcell" colspan="3"><textarea Name="SOP" cols="55" rows="15" maxlength = "2000" ><?php if (isset($_POST['SOP'])) echo trim($_POST['SOP']); else echo trim($sop);  ?></textarea></td>
</tr>

<tr>
		<td class="fieldcell"><input type="submit" class="navbuttons" name="submit" value="Submit" <?php if($confirmed) echo "disabled"; ?> />

		<?php
			$next_url_cancel = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
			$next_url_skip = '../user/patents.php';
		?>
			
							<input type="button" class="navbuttons" name="cancel" value="Cancel" onclick="parent.location= '<?php echo $next_url_cancel; ?>' "
							<?php if($confirmed) echo "disabled"; ?> /></td>
</tr>
</table>
</fieldset>
</form>

		<?php
			include($includes_path.'/js/form_validators/thrust_areas.js');
		?>
		
<br>
<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= '../user/best_papers.php' ">
<input type="button" value="Next" onclick="parent.location= '../user/patents.php'
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
