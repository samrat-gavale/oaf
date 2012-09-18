<?php
	include('../user/oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/oaf_vars.php');
	include ($includes_path.'/php/functions.php');
	include($includes_path.'/js/is_selected.js');
	
	$error_msg = "";
   if (isset($_POST['submit']))
   {
 	$firstname = mysqli_real_escape_string($dbcon, trim($_POST['Firstname']));
	$middlename = mysqli_real_escape_string($dbcon, trim($_POST['Middlename']));
	$lastname = mysqli_real_escape_string($dbcon, trim($_POST['Lastname']));
	$correspondence_address = mysqli_real_escape_string($dbcon, trim($_POST['Correspondence_Address']));
	$correspondence_phone = mysqli_real_escape_string($dbcon, trim($_POST['Correspondence_Phone']));
	$correspondence_fax = mysqli_real_escape_string($dbcon, trim($_POST['Correspondence_Fax']));
	$correspondence_email = mysqli_real_escape_string($dbcon, trim($_POST['Correspondence_eMail']));
	$permanent_address = mysqli_real_escape_string($dbcon, trim($_POST['Permanent_Address']));
	$permanent_phone = mysqli_real_escape_string($dbcon, trim($_POST['Permanent_Phone']));
	$permanent_fax = mysqli_real_escape_string($dbcon, trim($_POST['Permanent_Fax']));
	$permanent_email = mysqli_real_escape_string($dbcon, trim($_POST['Permanent_eMail']));
	
	//following values are submitted through dropdown list so no trimming and stuff
	$year = $_POST['Year'];
	$month = $_POST['Month'];
	$date = $_POST['Date'];
	$birth_date = $year."-".$month."-".$date;
	$nationality = $_POST['Nationality'];
	$sex = $_POST['Sex'];
	$marital_status = $_POST['Marital_Status'];
	$category = $_POST['Category'];
    	$photograph = stripslashes($_FILES['Photograph']['name']);
    	$photograph_type = $_FILES['Photograph']['type'];
    	$photograph_size = $_FILES['Photograph']['size'];
    	$extension = getExtension($photograph);
 		$extension = strtolower($extension);
    	$age = getAge($birth_date);
	$error = false;
 
if (!$error)
    {
      if (  !empty($lastname) && !empty($correspondence_address) && !empty($correspondence_email) &&
            !empty($permanent_address) && !empty($nationality) && !empty($sex) && !empty($marital_status)
            && !empty($photograph))
			{
				$domain = preg_replace('/^[a-zA-Z0-9][a-zA-Z0-9\-\._&!?=#]*@/','',$correspondence_email);
				if(is_numeric($correspondence_phone) && preg_match($email_pattern,$correspondence_email)/* && checkdnsrr($domain)*/ )
				{
					$corres_phone_db = preg_replace('/[\(\-\s\)]/','',$correspondence_phone);
					if ( (in_array($photograph_type, $allowed_types_photo)) && ($photograph_size > 0) && ($photograph_size <= MAXFILESIZE_PHOTO))
						{
							if ($_FILES['Photograph']['error'] == 0) 
							{
								// Move the file to the target upload folder
								$target = $uploaddir.'photograph.'.$extension;
								if(move_uploaded_file($_FILES['Photograph']['tmp_name'], $target)) 
								{
								$query = "UPDATE Personal_Information SET Firstname = '$firstname', Middlename = '$middlename', Lastname = '$lastname', " .
								"Correspondence_Address = '$correspondence_address', Correspondence_Phone = '$corres_phone_db', ".
								"Correspondence_Fax = '$correspondence_fax', Correspondence_eMail = '$correspondence_email', ".
								"Permanent_Address = '$permanent_address', Permanent_Phone = '$permanent_phone', Permanent_Fax = '$Permanent_Fax', ".
								"Permanent_eMail = '$permanent_email', Date_of_Birth = '$birth_date', Age = '$age', Nationality = '$nationality', ".
								"Sex = '$sex', Marital_Status = '$marital_status', Category = '$category', Photo_Extension = '$extension' ". 
								"WHERE User_ID = '$user_id'"; 
								mysqli_query($dbcon, $query);

								$query = "UPDATE Forms_Submitted SET Personal_Information = 1 WHERE User_ID = '$user_id'"; 
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
            $error_msg = 'Sorry, there was a problem uploading your photogragh.';
          }
        }
      }
      else 
      {
        $error_msg = 'The photograph must be a GIF, JPEG, or PNG file not greater than ' . (MAXFILESIZE_PHOTO / 1024) . ' KB in size.';
      }
	}
	else
	{
	$error_msg = 'Phone number or email id in the correspondence address is invalid!';
	}
      // Try to delete the temporary screen shot image file
      @unlink($_FILES['Photograph']['tmp_name']);
	 }
      else
      {
		$error_msg = 'You must enter all the required data.';
      }
    }
   }// End of check for form submission
  else
  {
		  $query = "SELECT User_ID FROM Personal_Information WHERE User_ID = '$user_id'";
		  $data = mysqli_query($dbcon, $query);
		  if (mysqli_num_rows($data) == 1) ;
		  else 
		  {
			  $query = "INSERT INTO Personal_Information (User_ID) VALUES ('$user_id')";
			  mysqli_query($dbcon, $query)
			  or die('Error storing data!');
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

 <p class ="texta">Personal Information</p>
<?php  echo '<p class="error_text">'.$error_msg.'</p>';  ?>
 <form name="personal_info" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
 <fieldset class="fieldset">
 <table>
<tr>
		 <td class="labelcell"><label for="firstname" >Firstname</label></td>
		 <td class="labelcell"><label for="middlename" >Middlename</label></td>
		 <td class="labelcell"><label for="lastname" >Lastname*</label></td>
</tr>
<tr>
		 <td class="fieldcell"><input type="text" id="firstname" name="Firstname" maxlength="30" size="13"
		    			value="<?php if (isset($_POST['Firstname'])) echo $_POST['Firstname']; else echo $firstname; ?>" /></td>
		 <td class="fieldcell"><input type="text" id="middlename" name="Middlename" maxlength="30" size="13"
		    			value="<?php if (isset($_POST['Middlename'])) echo $_POST['Middlename']; else echo $middlename; ?>" /></td>
		 <td class="fieldcell"><input type="text" id="lastname" name="Lastname" maxlength="30" size="13"
		    			value="<?php if (isset($_POST['Lastname'])) echo $_POST['Lastname']; else echo $lastname;?>" /></td>
		 
</tr>
	<tr><td colspan="3"><hr/></td></tr>

<tr>
		 <td class="labelcell" colspan="3"><label for="correspondence_address" >Correspondence Address*</label></td>
</tr>
<tr>
		 <td class="fieldcell" colspan="3"><textarea Name="Correspondence_Address" cols="50" rows="6"><?php if (isset($_POST['Correspondence_Address'])) echo trim($_POST['Correspondence_Address']);
										 else echo trim($correspondence_address); ?></textarea></td>
</tr>
<tr> 		 
		 <td class="labelcell"><label for="phone" >Phone*</label></td>
		 <td class="labelcell"><label for="faxno" >Fax No.</label></td>
		 <td class="labelcell"><label for="email" >eMail*</label></td>
</tr>
<tr>
		 <td class="fieldcell"><input type="text" id="phone" name="Correspondence_Phone"  maxlength="15" size="13"
						value="<?php if (isset($_POST['Correspondence_Phone'])) echo $_POST['Correspondence_Phone']; else echo $correspondence_phone; ?>" /></td>
		 <td class="fieldcell"><input type="text" id="faxno" name="Correspondence_Fax"  maxlength="15" size="13"
								value="<?php if (isset($_POST['Correspondence_Fax'])) echo $_POST['Correspondence_Fax'];
									         else echo $correspondence_fax; ?>" /></td>
		 <td class="fieldcell"><input type="text" id="email" name="Correspondence_eMail"  maxlength="30" size="13"
								value="<?php if (isset($_POST['Correspondence_eMail'])) echo $_POST['Correspondence_eMail'];
											 else echo $correspondence_email; ?>" /></td>
</tr>

	<tr><td colspan="3"><hr/></td></tr>

<tr>
		 <td class="labelcell" colspan="3"><label for="permanentaddress">Permanent Address*</label></td>
</tr>
<tr>
		 <td class="fieldcell" colspan="3"><textarea Name="Permanent_Address" cols="50" rows="6"><?php if (isset($_POST['Permanent_Address'])) echo trim($_POST['Permanent_Address']); else echo trim($permanent_address);  ?></textarea></td>
</tr>
<tr> 		 
		 <td class="labelcell"><label for="phone" >Phone</label></td>
		 <td class="labelcell"><label for="faxno" >Fax No.</label></td>
		 <td class="labelcell"><label for="email" >eMail</label></td>
</tr>
<tr>		 
		 <td class="fieldcell"><input type="1" id="phone" name="Permanent_Phone"  maxlength="15" size="13"
								value="<?php if (isset($_POST['Permanent_Phone'])) echo $_POST['Permanent_Phone'];
											 else echo $permanent_phone; ?>" /></td>	 
		 <td class="fieldcell"><input type="1" id="faxno" name="Permanent_Fax"  maxlength="15" size="13"
								value="<?php if (isset($_POST['Permanent_Fax'])) echo $_POST['Permanent_Fax'];
										     else echo $permanent_fax; ?>" /></td>	 
		 <td class="fieldcell"><input type="text" id="email" name="Permanent_eMail"  maxlength="30" size="13"
								value="<?php if (isset($_POST['Permanent_eMail'])) echo $_POST['Permanent_eMail'];
											 else echo $permanent_email; ?>" /></td>
</tr>

	<tr><td colspan="3"><hr/></td></tr>

<tr>
		<td class="labelcell"><label for="dateofbirth">Date of Birth*</label></td>
		<td class="fieldcell" colspan="2">

						<select name="Year">
							<option value="1940" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1940") || ($year == "1940") ) echo "selected"; ?> >1940</option>
							<option value="1941" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1941") || ($year == "1941") ) echo "selected"; ?> >1941</option>
							<option value="1942" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1942") || ($year == "1942") ) echo "selected"; ?> >1942</option>
							<option value="1943" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1943") || ($year == "1943") ) echo "selected"; ?> >1943</option>
							<option value="1944" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1944") || ($year == "1944") ) echo "selected"; ?> >1944</option>
							<option value="1945" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1945") || ($year == "1945") ) echo "selected"; ?> >1945</option>	
							<option value="1946" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1946") || ($year == "1946") ) echo "selected"; ?> >1946</option>
							<option value="1947" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1947") || ($year == "1947") ) echo "selected"; ?> >1947</option>
							<option value="1948" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1948") || ($year == "1948") ) echo "selected"; ?> >1948</option>
							<option value="1949" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1949") || ($year == "1949") ) echo "selected"; ?> >1949</option>
							<option value="1950" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1950") || ($year == "1950") ) echo "selected"; ?> >1950</option>
							<option value="1951" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1951") || ($year == "1951") ) echo "selected"; ?> >1951</option>
							<option value="1952" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1952") || ($year == "1952") ) echo "selected"; ?> >1952</option>
							<option value="1953" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1953") || ($year == "1953") ) echo "selected"; ?> >1953</option>							
							<option value="1954" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1954") || ($year == "1954") ) echo "selected"; ?> >1954</option>
							<option value="1955" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1955") || ($year == "1955") ) echo "selected"; ?> >1955</option>
							<option value="1956" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1956") || ($year == "1956") ) echo "selected"; ?> >1956</option>
							<option value="1957" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1957") || ($year == "1957") ) echo "selected"; ?> >1957</option>
							<option value="1958" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1958") || ($year == "1958") ) echo "selected"; ?> >1958</option>
							<option value="1959" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1959") || ($year == "1959") ) echo "selected"; ?> >1959</option>
							<option value="1960" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1960") || ($year == "1960") ) echo "selected"; ?> >1960</option>
							<option value="1961" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1961") || ($year == "1961") ) echo "selected"; ?> >1961</option>
							<option value="1962" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1962") || ($year == "1962") ) echo "selected"; ?> >1962</option>
							<option value="1963" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1963") || ($year == "1963") ) echo "selected"; ?> >1963</option>
							<option value="1964" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1964") || ($year == "1964") ) echo "selected"; ?> >1964</option>
							<option value="1965" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1965") || ($year == "1965") ) echo "selected"; ?> >1965</option>
							<option value="1966" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1966") || ($year == "1966") ) echo "selected"; ?> >1966</option>
							<option value="1967" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1967") || ($year == "1967") ) echo "selected"; ?> >1967</option>
							<option value="1968" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1968") || ($year == "1968") ) echo "selected"; ?> >1968</option>
							<option value="1969" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1969") || ($year == "1969") ) echo "selected"; ?> >1969</option>
							<option value="1970" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1970") || ($year == "1970") ) echo "selected"; ?> >1970</option>
							<option value="1971" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1971") || ($year == "1971") ) echo "selected"; ?> >1971</option>
							<option value="1972" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1972") || ($year == "1972") ) echo "selected"; ?> >1972</option>
							<option value="1973" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1973") || ($year == "1973") ) echo "selected"; ?> >1973</option>
							<option value="1974" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1974") || ($year == "1974") ) echo "selected"; ?> >1974</option>
							<option value="1975" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1975") || ($year == "1975") ) echo "selected"; ?> >1975</option>
							<option value="1976" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1976") || ($year == "1976") ) echo "selected"; ?> >1976</option>
							<option value="1977" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1977") || ($year == "1977") ) echo "selected"; ?> >1977</option>
							<option value="1978" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1978") || ($year == "1978") ) echo "selected"; ?> >1978</option>
							<option value="1979" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1979") || ($year == "1979") ) echo "selected"; ?> >1979</option>	
							<option value="1980" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1980") || ($year == "1980") ) echo "selected"; ?> >1980</option>
							<option value="1981" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1981") || ($year == "1981") ) echo "selected"; ?> >1981</option>
							<option value="1982" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1982") || ($year == "1982") ) echo "selected"; ?> >1982</option>
							<option value="1983" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1983") || ($year == "1983") ) echo "selected"; ?> >1983</option>
							<option value="1984" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1984") || ($year == "1984") ) echo "selected"; ?> >1984</option>
							<option value="1985" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1985") || ($year == "1985") ) echo "selected"; ?> >1985</option>																				
							<option value="1986" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1986") || ($year == "1986") ) echo "selected"; ?> >1986</option>
							<option value="1987" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1987") || ($year == "1987") ) echo "selected"; ?> >1987</option>
							<option value="1988" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1988") || ($year == "1988") ) echo "selected"; ?> >1988</option>
							<option value="1989" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1989") || ($year == "1989") ) echo "selected"; ?> >1989</option>
							<option value="1990" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1990") || ($year == "1990") ) echo "selected"; ?> >1990</option>
						</select>

						<select name="Month"> 
							<option value="1" <?php if ((isset($_POST['Month']) && $_POST['Month'] == "1") || ($month == "1") ) echo "selected"; ?> > Jan </option>
							<option value="2" <?php if ((isset($_POST['Month']) && $_POST['Month'] == "2") || ($month == "2") ) echo "selected"; ?> > Feb </option>
							<option value="3" <?php if ((isset($_POST['Month']) && $_POST['Month'] == "3") || ($month == "3") ) echo "selected"; ?> > Mar </option>
							<option value="4" <?php if ((isset($_POST['Month']) && $_POST['Month'] == "4") || ($month == "4") ) echo "selected"; ?> > Apr </option>
							<option value="5" <?php if ((isset($_POST['Month']) && $_POST['Month'] == "5") || ($month == "5") ) echo "selected"; ?> > May </option>
							<option value="6" <?php if ((isset($_POST['Month']) && $_POST['Month'] == "6") || ($month == "6") ) echo "selected"; ?> > June </option>
							<option value="7" <?php if ((isset($_POST['Month']) && $_POST['Month'] == "7") || ($month == "7") ) echo "selected"; ?> > July </option>
							<option value="8" <?php if ((isset($_POST['Month']) && $_POST['Month'] == "8") || ($month == "8") ) echo "selected"; ?> > Aug </option>
							<option value="9" <?php if ((isset($_POST['Month']) && $_POST['Month'] == "9") || ($month == "9") ) echo "selected"; ?> > Sept </option>
							<option value="10" <?php if ((isset($_POST['Month']) && $_POST['Month'] == "10") || ($month == "10") ) echo "selected"; ?> > Oct </option>
							<option value="11" <?php if ((isset($_POST['Month']) && $_POST['Month'] == "11") || ($month == "11") ) echo "selected"; ?> > Nov </option>
							<option value="12" <?php if ((isset($_POST['Month']) && $_POST['Month'] == "12") || ($month == "12") ) echo "selected"; ?> > Dec </option> 
						</select>

						<select name="Date">
							<option value="1" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "1") || ($date == "1") ) echo "selected"; ?> >1</option>
							<option value="2" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "2") || ($date == "2") ) echo "selected"; ?> >2</option>
							<option value="3" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "3") || ($date == "3") ) echo "selected"; ?> >3</option>
							<option value="4" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "4") || ($date == "4") ) echo "selected"; ?> >4</option>
							<option value="5" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "5") || ($date == "5") ) echo "selected"; ?> >5</option>
 							<option value="6" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "6") || ($date == "6") ) echo "selected"; ?> >6</option>
							<option value="7" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "7") || ($date == "7") ) echo "selected"; ?> >7</option>		
							<option value="8" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "8") || ($date == "8") ) echo "selected"; ?> >8</option>
							<option value="9" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "9") || ($date == "9") ) echo "selected"; ?> >9</option>
							<option value="10" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "10") || ($date == "10") ) echo "selected"; ?> >10</option>
							<option value="11" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "11") || ($date == "11") ) echo "selected"; ?> >11</option>
							<option value="12" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "12") || ($date == "12") ) echo "selected"; ?> >12</option>
							<option value="13" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "13") || ($date == "13") ) echo "selected"; ?> >13</option>
							<option value="14" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "14") || ($date == "14") ) echo "selected"; ?> >14</option>
							<option value="15" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "15") || ($date == "15") ) echo "selected"; ?> >15</option>
							<option value="16" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "16") || ($date == "16") ) echo "selected"; ?> >16</option>
							<option value="17" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "17") || ($date == "17") ) echo "selected"; ?> >17</option>
							<option value="18" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "18") || ($date == "18") ) echo "selected"; ?> >18</option>
							<option value="19" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "19") || ($date == "19") ) echo "selected"; ?> >19</option>
							<option value="20" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "20") || ($date == "20") ) echo "selected"; ?> >20</option>
							<option value="21" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "21") || ($date == "21") ) echo "selected"; ?> >21</option>
							<option value="22" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "22") || ($date == "22") ) echo "selected"; ?> >22</option>
							<option value="23" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "23") || ($date == "23") ) echo "selected"; ?> >23</option>
							<option value="24" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "24") || ($date == "24") ) echo "selected"; ?> >24</option>
							<option value="25" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "25") || ($date == "25") ) echo "selected"; ?> >25</option>
							<option value="26" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "26") || ($date == "26") ) echo "selected"; ?> >26</option>
							<option value="27" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "27") || ($date == "27") ) echo "selected"; ?> >27</option>
							<option value="28" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "28") || ($date == "28") ) echo "selected"; ?> >28</option>
							<option value="29" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "29") || ($date == "29") ) echo "selected"; ?> >29</option>
							<option value="30" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "30") || ($date == "30") ) echo "selected"; ?> >30</option>
							<option value="31" <?php if ((isset($_POST['Date']) && $_POST['Date'] == "31") || ($date == "31") ) echo "selected"; ?> >31</option>
						</select>
</td>											             
</tr>
<tr>
		 <td class="labelcell" colspan=1><label for="nationality">Nationality*</label></td>
		 <td class="labelcell"><br><input type="radio" name="Nationality" id="Indian" value="Indian" <?php if ((isset($_POST['Nationality']) && $_POST['Nationality'] == "Indian") || ($nationality == "Indian") ) echo "checked"; ?>  onclick = "is_selected_disable('Nationality','Indian');"/>Indian</td>
		 <td class="labelcell"><br><input type="radio" name="Nationality" id="PIO" value="PIO" <?php if ((isset($_POST['Nationality']) && $_POST['Nationality'] == "PIO") || ($nationality == "PIO") ) echo "checked"; ?> onclick = "is_selected_disable('Nationality','PIO');" />PIO</td>
</tr>
<tr>	 
		 <td></td>
		 <td class="labelcell"><input type="radio" name="Nationality" id="OCI" value="OCI" <?php if ((isset($_POST['Nationality']) && $_POST['Nationality'] == "OCI") || ($nationality == "OCI") ) echo "checked"; ?> onclick = "is_selected_disable('Nationality','OCI');" />OCI</td>
		 <td class="labelcell"><input type="radio" name="Nationality" id= "Foreigner" value="Foreigner" 
							   <?php if ( (isset($_POST['Nationality']) && !(in_array($_POST['Nationality'], $nationality_array))) ||  !(in_array($nationality, $nationality_array)) ) echo "checked"; ?> onclick = "is_selected_enable('Nationality','Foreigner');" />Foreigner</td>
</tr>
<tr>
		 <td></td><td></td>
		 <td class="fieldcell"><input type="text" name="Nationality"  id = "Nationality" size="13" maxlength="20" disabled="disabled"
								value="<?php if ( isset($_POST['Nationality']) && !(in_array($_POST['Nationality'], $nationality_array)) ) echo $_POST['Nationality']; else if ( !(in_array($nationality, $nationality_array)) ) echo $nationality; ?>" /></td>
</tr>
<tr>
		 <td class="labelcell" colspan=1><label for="sex">Sex*</label></td>
		 <td class="labelcell"><input type="radio" name="Sex" value="M" <?php if ((isset($_POST['Sex']) && $_POST['Sex'] == "M") || ($sex == "M") ) echo "checked"; ?> />Male</td>
		 <td class="labelcell"><input type="radio" name="Sex" value="F" <?php if ((isset($_POST['Sex']) && $_POST['Sex'] == "F") || ($sex == "F") ) echo "checked"; ?> />Female</td></tr>
<tr>
		 <td class="labelcell" colspan=1><label for="marital_status">Marital Status*</label></td>
		 <td class="labelcell"><input type="radio" name="Marital_Status" value="UM" <?php if ((isset($_POST['Marital_Status']) && $_POST['Marital_Status'] == "UM") || ($marital_status == "UM") ) echo "checked"; ?> />Unmarried</td>
		 <td class="labelcell"><input type="radio" name="Marital_Status" value="M" <?php if ((isset($_POST['Marital_Status']) && $_POST['Marital_Status'] == "M") || ($marital_status == "M") ) echo "checked"; ?>/>Married</td></tr>
<tr>
		  <td class="labelcell"><label for="category">Category*</label></td>
		  <td class="fieldcell"><select name="Category">
								<option value="GEN" <?php if ((isset($_POST['Category']) && $_POST['Category'] == "GEN") || ($category == "GEN") ) echo "selected"; ?> > Gen </option>
								<option value="OBC" <?php if ((isset($_POST['Category']) && $_POST['Category'] == "OBC") || ($category == "OBC") ) echo "selected"; ?> > OBC </option>
								<option value="ST" <?php if ((isset($_POST['Category']) && $_POST['Category'] == "ST") || ($category == "ST") ) echo "selected"; ?> > ST </option>
								<option value="SC" <?php if ((isset($_POST['Category']) && $_POST['Category'] == "SC") || ($category == "SC") ) echo "selected"; ?> > SC </option></td>
</tr>

	<tr><td colspan="3"><hr/></td></tr>

<tr>
	<td class="labelcell"><label for="photograph">Photograph*</label></td>
</tr>
<tr>
	<td colspan=2><input type="file" id="photograph" name="Photograph" /></td>
</tr>

	<tr><td colspan="3"><hr/></td></tr>

<tr>
		<td class="fieldcell" colspan=1><input type="submit" name="submit" value="Submit" <?php if($confirmed) echo "disabled"; ?> /></td>

		<?php
			$next_url_cancel = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
			$next_url_skip = '../user/acad_qualifications.php';
		?>
			
		<td class="fieldcell" colspan=1><input type="button" name="cancel" value="Cancel" onclick="parent.location= '<?php echo $next_url_cancel; ?>' "
										<?php if($confirmed) echo "disabled"; ?> /></td>
</tr>
</table>
</fieldset>
</form>

		<?php
			include($includes_path.'/js/form_validators/personal_info.js');
		?>
		
<br>
<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= '../user/application_details.php' ">
<input type="button" value="Next" onclick="parent.location= '../user/acad_qualifications.php'
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
