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
    // Grab the data from the POST
    $name = mysqli_real_escape_string($dbcon, trim($_POST['Name']));
    $designation = mysqli_real_escape_string($dbcon, trim($_POST['Designation']));
    $correspondence_address = mysqli_real_escape_string($dbcon, trim($_POST['Correspondence_Address']));
    $phone = mysqli_real_escape_string($dbcon, trim($_POST['Phone']));
    $fax = mysqli_real_escape_string($dbcon, trim($_POST['Fax']));
    $email = mysqli_real_escape_string($dbcon, trim($_POST['Email']));
    $error = false;

    // Insert data in the database
    if (!$error)
    {
      if (!empty($name) && !empty($designation) && !empty($correspondence_address) && !empty($phone) && !empty($email) && valid_email($email))
      {
			 $query = "SELECT Sr_No from Referees WHERE User_ID =  '$user_id'";
			 $data = mysqli_query($dbcon, $query);
			 $rows = mysqli_num_rows($data);
			 //Check if maximum limit is reached
			 if($rows<MAX_REFEREES)
			 {
				//Insert a row in table Sr_No is set to 0 since it is auto incremented
				$query = "INSERT INTO Referees VALUES(0, '$user_id', '$name','$designation', ".
					  "'$correspondence_address', '$phone', '$fax', '$email') ";
				mysqli_query($dbcon, $query);
				if($rows == 0)
				{
					$query = "UPDATE Forms_Submitted SET Referees = 1 WHERE User_ID = '$user_id'";
					mysqli_query($dbcon, $query) or
					trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbcon));
				}
				// Navigate to Teaching Experience		  
				mysqli_close($dbcon);
				$next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
				echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';
				exit();
             }
			 else
			 {
				 $error_msg =  "You have already entered the maximum number of referees! You can delete other records and then add new ones.";
			 }
      }
      else
      {
        $error_msg =  "Please enter all the data.";
      }
    }
 } // End of check for form submission

?>

<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn1">
<p class="texta">Referees</p>
<?php  echo '<p class="error_text">'.$error_msg.'</p>';  ?>

<form name="referees" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset class="fieldset">
 <table>
	 <tr>
   		 <td class="labelcell"><label for="name" >Name</label></td>
</tr>
<tr>
		 <td class="fieldcell" colspan="2"><input type="text" id="name" name="Name" maxlength="40"
						value="<?php if (isset($_POST['Name'])) echo $_POST['Name']; ?>" /></td>
</tr>
<tr>
   		 <td class="labelcell" ><label for="designation" >Designation</label></td>
</tr>
<tr>
		 <td class="fieldcell" colspan="2"><input type="text" id="designation" name="Designation" maxlength="40"
											value="<?php if (isset($_POST['Designation'])) echo $_POST['Designation'];?>" /></td>
</tr>
<tr>
		 <td class="labelcell" colspan="3"><label for="correspondence" >Correspondence Address</label></td>
</tr>
<tr>
		 <td class="fieldcell" colspan="3"><textarea Name="Correspondence_Address" cols="42" rows="6"><?php if (isset($_POST['Correspondence_Address'])) echo trim($_POST['Correspondence_Address']); ?></textarea></td>
</tr>
<tr>
		 <td class="labelcell"><label for="phone" >Phone</label></td>
		 <td class="labelcell"><label for="faxno" >Fax No.</label></td>
		 <td class="labelcell"><label for="email" >e Mail</label></td>
</tr>
<tr>
		 <td class="fieldcell"><input type="1" id="phone" name="Phone"  maxlength="15" size="12"
						value="<?php if (isset($_POST['Phone'])) echo $_POST['Phone']; ?>" /></td>
	   	 <td class="fieldcell"><input type="1" id="faxno" name="Fax"  maxlength="15" size="12"
					    value="<?php if (isset($_POST['Fax'])) echo $_POST['Fax']; ?>" /></td>
		 <td class="fieldcell"><input type="text" id="email" name="Email"  maxlength="40" size="12"
						value="<?php if (isset($_POST['Email'])) echo $_POST['Email']; ?>" /></td>
</tr>
	 <tr>    
     	 <td class="button"><input type="submit" name="submit" size = "15" value="Add Referee" <?php if($confirmed) echo "disabled"; ?>/></td>   

 		<?php $cancel_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user'); ?>
		<td class="fieldcell" colspan=1><input type="button" name="cancel" value="Cancel" onclick="parent.location= '<?php echo $cancel_url; ?>' "
										<?php if($confirmed) echo "disabled"; ?> /></td>
        </tr>
 </table>
 </fieldset>
 </form>
				<?php
					include($includes_path.'/js/form_validators/referees.js');
				?>
    
<div id="navbuttons">
			<input type="button" value="Back" onclick="parent.location.href = '../user/general_questions.php'" size = "15" />
			<input type="button" value="Next" onclick="parent.location.href = '../user/terms.php'" size = "15" />
</div>

</div>
</div>
</div>
<div id="leftcolumn">
<?php include($includes_path.'/php/sidemenu.php');?>
</div>
<div id="rightcolumn1">
<div id="help">
<h3>Note</h3>
<ul>
<li>Please enter <i>minimum three</i> records.</li>
<li>Please enter the phone numbers with correct <b>city code</b></li>
<li>All the fields except 'Fax No.' are compulsory.</li>
<li>Please ask the referee to <b>send a letter of reference to 'registrar@iitmandi.ac.in'</b>.</li>
<li>Referees must be familiar with your recent work.</li>
<li>Ensure that the phone number and the email id are upto date since the administration may contact the referee.</li>
<li>Use <i>Add Entry</i> button to add referee.</li>
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
</ul>
</div>
</div>



</div>
<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>

