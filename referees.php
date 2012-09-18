<?php
  include('oaf_paths.php');
  include('includes/php/set_session.php');
  include('includes/html/header.html');
  include('includes/php/check_login.php');
  require_once('includes/php/mysqlcon.php');
  include ('includes/php/check_confirmed.php');
  include('includes/js/delete_records.js');
  include('includes/php/oaf_vars.php');
  include('includes/php/functions.php');

  $error_msg = "";
   if (isset($_POST['submit'])) 
   {
    // Grab the profile data from the POST
    $name = mysqli_real_escape_string($dbcon, trim($_POST['Name']));
    $designation = mysqli_real_escape_string($dbcon, trim($_POST['Designation']));
    $correspondence_address = mysqli_real_escape_string($dbcon, trim($_POST['Correspondence_Address']));
    $phone = mysqli_real_escape_string($dbcon, trim($_POST['Phone']));
    $fax = mysqli_real_escape_string($dbcon, trim($_POST['Fax']));
    $email = mysqli_real_escape_string($dbcon, trim($_POST['Email']));
    $error = false;

    // Update the profile data in the database
    if (!$error)
    {
      if (!empty($name) && !empty($designation) && !empty($correspondence_address) && !empty($phone) && !empty($email) && valid_email($email))
      {		  
			 $query = "SELECT Sr_No from Referees WHERE User_ID =  '" . $_SESSION['user_id'] . "'";
			 $data = mysqli_query($dbcon, $query);
			 $rows = mysqli_num_rows($data);
			 
			 //Check if maximum limit is reached
			 if($rows<MAX_REFEREES)
			 {
			 //Insert a row in table Sr_No is set to 0 since it is auto incremented
		     $query = "INSERT INTO Referees VALUES(0, '" . $_SESSION['user_id'] . "', '$name','$designation', '$correspondence_address', ".
					  "'$phone','$fax', '$email') ";
             mysqli_query($dbcon, $query);
			 if(($rows+1) == 3)
			 {
		 		$query = "UPDATE Forms_Submitted SET Referees = 1 WHERE User_ID = '" . $_SESSION['user_id'] . "'";
				mysqli_query($dbcon, $query) or
				trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbcon));
			 }
			 // navigate to this to clear POST array
			 header("location: $PHP_SELF?action=complete");
             }
			 else
			 {
				 $error_msg = "You have already entered the maximum number of references! You can delete other records and then add new ones.";
			 }
      }
      else
      {
        $error_msg = "Please enter valid data.";
      }
    }
 } // End of check for form submission

	  //Stuff for displaying table Check if any data of the user is present in the database
	  $query = "SELECT Sr_No, Name, Designation, Address, Phone, Fax, Email_ID FROM Referees WHERE User_ID = '" . $_SESSION['user_id'] . "'";
	  $data = mysqli_query($dbcon, $query);
	  if (mysqli_num_rows($data) >= 1)
	  {
		$i = 0;
		while($row = mysqli_fetch_assoc($data))
		{
			$sr_no_array[$i] = $row['Sr_No'];
			$name_array[$i] = $row['Name'];
			$designation_array[$i] = $row['Designation'];
			$address_array[$i] = $row['Address'];
			$phone_array[$i] = $row['Phone'];
			$email_array[$i] = $row['Email_ID'];
			$fax_array[$i] = $row['Fax'];
			$i++;
		}

	$table1 =<<<EOD
	
		<table id="table2">
		<tbody1>
		<tr>
			<th scope="col"></th>
			<th scope="col">Name</th>
			<th scope="col">Designation</th>
			<th scope="col">Address</th>
			<th scope="col">Phone</th>
			<th scope="col">E-mail</th>
			<th scope="col">Fax</th>
		</tr>
EOD;

		for (; (list($key_sr_no, $sr_no) = each($sr_no_array)) && (list($key_name, $name) = each($name_array)) 
				&& (list($key_designation, $designation) = each($designation_array)) && (list($key_phone, $phone) = each($phone_array))
				&& (list($key_address, $address) = each($address_array)) && (list($key_email, $email) = each($email_array)) 
				&& (list($key_fax, $fax) = each($fax_array)) ;)
		{
		list($head,$tail) = explode('@',$email);
		$display_email = $head.' @'.$tail;
		$table1 .= <<<EOD
			<tr id=$sr_no>
				<td><input type="checkbox" id=$sr_no></td>
				<td>$name</td>
				<td>$designation</td>
				<td>$address</td>
				<td>$phone</td>
				<td>$display_email</td>
				<td>$fax</td>
			</tr>
EOD;
		}

$table1 .=<<<EOD
		</tbody1>
		</table>
		<input type="button" class="delbutton" value="Delete Record" onclick='send_query("del_referee.php"); parent.location = "referees.php" ' />
		<div id='test'></div>
EOD;
	}
	else
	  {
     $table1 = <<<EOD
		<h3 class="alert_text">You have not yet added any reference!</h3>
		<table id="table2">
		<tr>
			<th>Name</th>
			<th>Designation</th>
			<th>Address</th>
			<th>Phone</th>
			<th>E-mail</th>
			<th>Fax</th>
		</tr>
		</table>
			<input type="button" class="delbutton" value="Delete Entry" onclick="" />
EOD;
	}
?>

<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn1">
<p class="texta">Contact Information of Referees</p>
<?php  echo '<p class="error_text">'.$error_msg.'</p>';  ?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
		 <td class="fieldcell"><input type="text" id="email" name="Email"  maxlength="30" size="12"
						value="<?php if (isset($_POST['Email'])) echo $_POST['Email']; ?>" /></td>
</tr>
<tr>
		 <td class="button" colspan="2"><input type="submit" name="submit" value="Save and Proceed" <?php if($confirmed) echo "disabled"; ?> /></td>
</tr>
</table>
</fieldset>
</form>

    
<div id="navbuttons">
	<input type="button" value="Back" onclick="parent.location= 'general_questions.php' ">
	<input type="button" value="Next" onclick="parent.location= 'terms.php' ">
</div>

</div>
</div>
<div id="leftcolumn">
<?php include('includes/php/sidemenu.php');?>
</div>

<div id="rightcolumn1">
<?php echo $table1; ?>
<br/>
<div id="help">
Note
<ul>
<li>Please enter <b>minimun three</b> records.</li>
<li>All the fields except 'Fax No.' are compulsory.</li>
<li>Please ask the referee to send a letter of reference to 'registrar@iitmandi.ac.in'.</li>
<li>Referees must be familiar with your recent work.</li>
<li>Ensure that the phone number and the email id are upto date since the administration may contact the referee.</li>
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
</ul>
</div>

</div>

</div>
<?php include('includes/html/footer.html'); ?>
</body>
</html>
