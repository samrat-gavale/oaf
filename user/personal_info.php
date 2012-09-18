<?php
	include('oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/oaf_vars.php');
	include ($includes_path.'/php/functions.php');
	include($includes_path.'/js/is_selected.js');
	
	$error_msg = "";

		  $query = "SELECT Personal_Information FROM Forms_Submitted WHERE User_ID = '$user_id'";
		  $row = mysqli_fetch_array(mysqli_query($dbcon, $query))
				  or
				  trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbcon));
		  if ($row[0] == 1) ;
		  else 
		  {
			mysqli_close($dbcon);
			$next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('forms');
  		    echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';
			exit();
		  }
    // Grab the profile data from the database
    $query = "SELECT * FROM Personal_Information WHERE User_ID = '$user_id'";
    $data = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) 
    {
	  $firstname = $row['Firstname'];
      $lastname = $row['Lastname'];
      $middlename = $row['Middlename'];
      $correspondence_address = $row['Correspondence_Address'];
	  $correspondence_phone = $row['Correspondence_Phone'];
	  $correspondence_fax = $row['Correspondence_Fax'];
	  $correspondence_email = $row['Correspondence_eMail'];
	  $permanent_address = $row['Permanent_Address'];
	  $permanent_phone = $row['Permanent_Phone'];
	  $permanent_fax = $row['Permanent_Fax'];
	  $permanent_email = $row['Permanent_eMail'];
	  $birth_date = $row['Date_of_Birth'];
	  list($year, $month, $date) = explode('-',$birth_date);
	  $nationality = $row['Nationality'];
	  $sex = $row['Sex'];
	  $marital_status = $row['Marital_Status'];
	  $category = $row['Category'];
  	  $photo_extension = $row['Photo_Extension'];
	  
	  if($photo_extension == '')
	     $error_msg = 'You have not yet uploaded your photograph.';
	  else 
	      $error_msg = 'You have already uploaded your photograph.';

      }
    else 
    {
      $error_msg = 'There was a problem accessing your profile.';
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

 <p class ="texta">Personal Information</p>
<?php
		$data =<<<EOD
<fieldset class="fieldset">
  <table>
	<tr>
		 <td class="labelcell"><label for="firstname" >Firstname</label></td><td class="fieldcell">$firstname</td>
	</tr>
	<tr>
		 <td class="labelcell"><label for="middlename" >Middlename</label></td><td class="fieldcell">$middlename</td>
	</tr>
	<tr>
	 	 <td class="labelcell"><label for="lastname" >Lastname*</label></td><td class="fieldcell">$lastname</td>
	</tr>

	<tr><td colspan="3"><hr/></td></tr>

	<tr>
		 <td class="labelcell" colspan="3"><label for="correspondence_address" >Correspondence Address*</label></td>
	</tr>
	<tr>
		 <td class="fieldcell" colspan="3">$correspondence_address</td>
	</tr>

	<tr><td colspan="3"><hr/></td></tr>

	<tr> 		 
		 <td class="labelcell"><label for="phone" >Phone*</label></td><td class="fieldcell">$correspondence_phone</td>
	</tr>
	<tr>
		 <td class="labelcell"><label for="faxno" >Fax No.</label></td><td class="fieldcell">$correspondence_fax</td>
	</tr>
	<tr>
		 <td class="labelcell"><label for="email" >eMail*</label></td><td class="fieldcell">$correspondence_email</td>
	</tr>

	<tr><td colspan="3"><hr/></td></tr>

	<tr>
		 <td class="labelcell" colspan="3"><label for="permanentaddress">Permanent Address*</label></td>
	</tr>
	<tr>
		 <td class="fieldcell" colspan="3">$permanent_address</td>
	</tr>

	<tr><td colspan="3"><hr/></td></tr>

	<tr>
		 <td class="labelcell"><label for="phone" >Phone</label></td><td class="fieldcell">$permanent_phone</td>	 
	</tr>
	<tr>
		 <td class="labelcell"><label for="faxno" >Fax No.</label></td><td class="fieldcell">$permanent_fax</td>	 
	</tr>
	<tr>
		 <td class="labelcell"><label for="email" >eMail</label></td><td class="fieldcell">$permanent_email</td>
	</tr>

	<tr><td colspan="3"><hr/></td></tr>
	
	<tr>
		<td class="labelcell"><label for="dateofbirth">Date of Birth*</label></td>
		<td class="fieldcell" colspan="2">$date-$month-$year</td>
	</tr>

<tr>
		 <td class="labelcell" colspan=1><label for="nationality">Nationality*</label></td>
		 <td class="labelcell">$nationality</td>
</tr>
<tr>
		 <td class="labelcell" colspan=1><label for="sex">Sex*</label></td>
		 <td class="labelcell">$sex</td>
<tr>
		 <td class="labelcell" colspan=1><label for="marital_status">Marital Status*</label></td>
		 <td class="labelcell">$marital_status</td>
<tr>
		  <td class="labelcell"><label for="category">Category*</label></td>
		  <td class="fieldcell">$category</td>
</tr>
	<tr><td colspan="3"><hr/></td></tr>
<tr>
	<td class="labelcell"><label for="photograph">Photograph*</label></td>
		  <td class="fieldcell">$error_msg</td>
</tr>
<tr>
	<td colspan=2></td>
</tr>
<tr>
EOD;

	echo $data;
?>
	<tr><td colspan="3"><hr/></td></tr>

		<td class="fieldcell" colspan=1><input type="button" value="Edit" onclick='parent.location="../forms/<?php echo getScriptName(); ?>"'></td>
</tr>
</table>
</fieldset>
</form>

<br>
<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= 'application_details.php' ">
<input type="button" value="Next" onclick="parent.location= 'acad_qualifications.php'">
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
<li>The fields maked with * in this form are compulsory.</li>
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
<li><i>PIO</i>- Person of Indian Origin.</li>
<li><i>OCI</i>- Overseas Citizen of India.</li>
<li>If you are <i>foreigner</i>, please write your country in  the field provided below it.</li>
<li>The photograph should be in <i>gif,png,jpeg,pjpeg,JPG,X-PNG,x-png</i> formats only.</li>
<li>The photograph size should be less than or equal to <i>200KB</i>.</li>
</ul>
</div>
</div>

</div>

<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
