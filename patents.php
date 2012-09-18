<?php
  include('oaf_paths.php');
  include('includes/php/set_session.php');
  include('includes/html/header.html');
  include('includes/php/check_login.php');
  require_once('includes/php/mysqlcon.php');
  include ('includes/php/check_confirmed.php');

$error_msg = "";
   if (isset($_POST['submit'])) 
   {
    // Grab the profile data from the POST
    $num_patents = mysqli_real_escape_string($dbcon, trim($_POST['Num_Patents']));
    $patents = mysqli_real_escape_string($dbcon, trim($_POST['Patents']));

// Update the profile data in the database
    	if (!empty($num_patents) && !empty($patents))
   	{
			$query = "UPDATE Patents SET Num_Patents = '$num_patents', Patents = '$patents' WHERE User_ID = '" . $_SESSION['user_id'] . "'"; 
								mysqli_query($dbcon, $query);

								$query = "UPDATE Forms_Submitted SET Patents = 1 WHERE User_ID = '" . $_SESSION['user_id'] . "'"; 
								mysqli_query($dbcon, $query);

								//naviate to Undergraduate academic profile
								$other_info_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/other_information.php';
								header('Location: ' . $other_info_url);
								mysqli_close($dbcon);
							
         exit();
      }
      else 
      {
       		$error_msg = 'Please enter all the data.';
      }
   }// End of check for form submission
  else 
  {
		  $query = "SELECT User_ID FROM Patents WHERE User_ID = '" . $_SESSION['user_id'] . "'";
		  $data = mysqli_query($dbcon, $query);
		  if (mysqli_num_rows($data) == 1) ;
		  else 
		  {
			  $query = "INSERT INTO Patents (User_ID) VALUES ('" . $_SESSION['user_id'] . "')";
			  mysqli_query($dbcon, $query)
			  or die('Error storing data!');
		  }
    // Grab the profile data from the database
    $query = "SELECT * FROM Patents WHERE User_ID = '" . $_SESSION['user_id'] . "'";
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
width:465px;
}
</style>

<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">

 <p class ="texta">Patents</p>
<?php  echo '<p class="error_text">'.$error_msg.'</p>';  ?>
 <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
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

<tr>
	<td class="button"><input type="submit" name="submit" value="Save and Proceed"
							<?php if($confirmed) echo "disabled"; ?> /></td>
</tr>
</table>
</fieldset>
</form>

<br>
<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= 'thrust_areas_sop.php' ">
<input type="button" value="Skip this Page" onclick="parent.location= 'other_information.php' ">
</div>

</div>
</div>

<div id="leftcolumn">
<?php include('includes/php/sidemenu.php');?>
</div>

<div id="rightcolumn">
<div id="help">
<h3>Note</h3>
<ul>
<li>Number of patents should include awarded as well as pending applications.</li>
<li>Please include all nesessary information about each of patent.</li>
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
</ul>
</div>
</div>

</div>

<?php include('includes/html/footer.html'); ?>
</body>
</html>
