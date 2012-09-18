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
    $degree = mysqli_real_escape_string($dbcon, trim($_POST['Degree']));
    $specialization = mysqli_real_escape_string($dbcon, trim($_POST['Specialization']));
    $year = mysqli_real_escape_string($dbcon, trim($_POST['Year']));
    $institute = mysqli_real_escape_string($dbcon, trim($_POST['Institute']));
    $grade = mysqli_real_escape_string($dbcon, trim($_POST['Grade']));
    $error = false;

    // Insert data in the database
    if (!$error)
    {
      if (!empty($degree) && !empty($specialization) && !empty($year) && !empty($institute))
      {
			 $query = "SELECT Sr_No from Academic_Qualifications WHERE User_ID =  '$user_id'";
			 $data = mysqli_query($dbcon, $query);
			 $rows = mysqli_num_rows($data);
			 //Check if maximum limit is reached
			 if($rows<MAX_ACAD_QUALI)
			 {
				//Insert a row in table Sr_No is set to 0 since it is auto incremented
				$query = "INSERT INTO Academic_Qualifications VALUES( 0,'$user_id','$degree','$specialization', ".
					  "'$institute','$year', '$grade') ";
				mysqli_query($dbcon, $query);
				if($rows == 0)
				{
					$query = "UPDATE Forms_Submitted SET Academic_Qualifications = 1 WHERE User_ID = '$user_id'";
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
				 $error_msg =  "You have already entered the maximum number of qualifications! You can delete other records and then add new ones.";
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
<p class="texta">Academic Qualifications</p>
<?php  echo '<p class="error_text">'.$error_msg.'</p>';  ?>

<form name="acad_qualifications" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset class="fieldset">
 <table>
	 <tr>
		 <td class="labelcell"><label for="Degree" >Degree</label></td>
		 <td class="fieldcell"><input type="text"  id="degree" name="Degree" size = "25" maxlength="40" value="<?php if (isset($_POST['Degree'])) echo $_POST['Degree']; ?>"/></td>
	 </tr>
	 <tr>
		 <td class="labelcell"><label for="Specialization" >Subject / Specialization</label></td>
		 <td class="fieldcell"><input type="text"  id="specialization" name="Specialization" size = "25" maxlength="40" value="<?php if (isset($_POST['Specialization'])) echo $_POST['Specialization']; ?>"/></td>
	 </tr>
	 <tr>
		<td class="labelcell"><label for="Year">Year of Completion</label></td>
		<td class="fieldcell"><select name="Year">
									<option value="1960" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1960")) echo "selected"; ?> >1960</option>
									<option value="1961" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1961")) echo "selected"; ?> >1961</option>
									<option value="1962" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1962")) echo "selected"; ?> >1962</option>
									<option value="1963" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1963")) echo "selected"; ?> >1963</option>
									<option value="1964" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1964")) echo "selected"; ?> >1964</option>
									<option value="1965" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1965")) echo "selected"; ?> >1965</option>
									<option value="1966" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1966")) echo "selected"; ?> >1966</option>
									<option value="1967" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1967")) echo "selected"; ?> >1967</option>
									<option value="1968" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1968")) echo "selected"; ?> >1968</option>
									<option value="1969" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1969")) echo "selected"; ?> >1969</option>
									<option value="1970" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1970")) echo "selected"; ?> >1970</option>
									<option value="1971" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1971")) echo "selected"; ?> >1971</option>
									<option value="1972" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1972")) echo "selected"; ?> >1972</option>
									<option value="1973" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1973")) echo "selected"; ?> >1973</option>
									<option value="1974" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1974")) echo "selected"; ?> >1974</option>
									<option value="1975" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1975")) echo "selected"; ?> >1975</option>
									<option value="1976" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1976")) echo "selected"; ?> >1976</option>
									<option value="1977" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1977")) echo "selected"; ?> >1977</option>
									<option value="1978" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1978")) echo "selected"; ?> >1978</option>
									<option value="1979" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1979")) echo "selected"; ?> >1979</option>
									<option value="1980" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1980")) echo "selected"; ?> >1980</option>
									<option value="1981" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1981")) echo "selected"; ?> >1981</option>
									<option value="1982" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1982")) echo "selected"; ?> >1982</option>
									<option value="1983" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1983")) echo "selected"; ?> >1983</option>
									<option value="1984" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1984")) echo "selected"; ?> >1984</option>
									<option value="1985" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1985")) echo "selected"; ?> >1985</option>
									<option value="1986" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1986")) echo "selected"; ?> >1986</option>
									<option value="1987" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1987")) echo "selected"; ?> >1987</option>
									<option value="1988" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1988")) echo "selected"; ?> >1988</option>
									<option value="1989" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1989")) echo "selected"; ?> >1989</option>
									<option value="1990" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1990")) echo "selected"; ?> >1990</option>
									<option value="1991" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1991")) echo "selected"; ?> >1991</option>
									<option value="1992" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1992")) echo "selected"; ?> >1992</option>
									<option value="1993" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1993")) echo "selected"; ?> >1993</option>
									<option value="1994" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1994")) echo "selected"; ?> >1994</option>
									<option value="1995" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1995")) echo "selected"; ?> >1995</option>
									<option value="1996" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1996")) echo "selected"; ?> >1996</option>
									<option value="1997" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1997")) echo "selected"; ?> >1997</option>
									<option value="1998" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1998")) echo "selected"; ?> >1998</option>
									<option value="1999" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "1999")) echo "selected"; ?> >1999</option>
									<option value="2000" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "2000")) echo "selected"; ?> >2000</option>
									<option value="2001" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "2001")) echo "selected"; ?> >2001</option>
									<option value="2002" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "2002")) echo "selected"; ?> >2002</option>
									<option value="2003" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "2003")) echo "selected"; ?> >2003</option>
									<option value="2004" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "2004")) echo "selected"; ?> >2004</option>
									<option value="2005" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "2005")) echo "selected"; ?> >2005</option>
									<option value="2006" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "2006")) echo "selected"; ?> >2006</option>
									<option value="2007" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "2007")) echo "selected"; ?> >2007</option>
									<option value="2008" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "2008")) echo "selected"; ?> >2008</option>
									<option value="2009" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "2009")) echo "selected"; ?> >2009</option>
									<option value="2010" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "2010")) echo "selected"; ?> >2010</option>
									<option value="2011" <?php if ((isset($_POST['Year']) && $_POST['Year'] == "2011")) echo "selected"; ?> >2011</option>
							</td>
	 </tr>
	 <tr>
		 <td class="labelcell"><label for="Institute">University / Institution</label></td>
		 <td class="fieldcell"><input type="text" id="institute" name="Institute" size = "25" maxlength="50"
								value="<?php if (isset($_POST['Institute'])) echo $_POST['Institute']; ?>"/></td>
	 </tr>
	 <tr>
		 <td class="labelcell"><label for="Grade">Grade / Percentage</label><br class="nobr"></td>
		 <td class="fieldcell"><input type="text" id="grade" name="Grade" size = "25" maxlength="10"
								value="<?php if (isset($_POST['Grade'])) echo $_POST['Grade']; ?>"/></td>
	 </tr>
	 <tr>    
     	 <td class="button"><input type="submit" name="submit" size = "15" value="Add Qualification" <?php if($confirmed) echo "disabled"; ?>/></td>   

		<?php $cancel_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user'); ?>
		<td class="fieldcell" colspan=1><input type="button" name="cancel" value="Cancel" onclick="parent.location= '<?php echo $cancel_url; ?>' "
										<?php if($confirmed) echo "disabled"; ?> /></td>
         </tr>
 </table>
 </fieldset>
 </form>
				<?php
					include($includes_path.'/js/form_validators/acad_qualifications.js');
				?>
    
<div id="navbuttons">
			<input type="button" value="Back" onclick="parent.location.href = 'personal_info.php'" size = "15" />
			<input type="button" value="Next" onclick="parent.location.href = 'teaching_exp.php'" size = "15" />
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
<li>All fields in this form except grade are compulsory.(Grade must be entered wherever available)</li>
<li>Enter your grade as Obtained/Maximum.(eg. - 8.65/10.00 or A/A+)</li>
<li>Enter your percentage score as __% (eg. - 84.23%)</li>
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
<li>Maximum allowed entries is <i>8</i>.</li>
<li>Start your academic details from <i>10th standard</i> onwards.</li>
</ul>
</div>
</div>



</div>
<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>

