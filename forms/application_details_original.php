<?php
	include('../user/oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/oaf_vars.php');
	include ($includes_path.'/php/functions.php');
	include ($includes_path.'/js/check_position.js');
	
	$error_msg = "";
   if (isset($_POST['submit']))
   {
    // Grab the profile data from the POST
    $advt_no = $_POST['Advertisement_No'];
    $assistant_professor = ( isset($_POST['Assistant_Professor'])? 1 : 0 );
    $assistant_professor_contract = ( isset($_POST['Assistant_Professor_Contract'])? 1 : 0 );
    $professor = ( isset($_POST['Professor'])? 1 : 0 );
    $associate_professor = (isset($_POST['Associate_Professor'])? 1 : 0);
    $comp_elec = (isset($_POST['Sch_Comp_Elec_Engg'])? 1:0);
    $engg = (isset($_POST['Sch_Engg'])? 1:0);
    $basic_sci =(isset($_POST['Sch_Basic_Sci'])? 1:0);
    $hum_soc =(isset($_POST['Sch_Hum_Soc_Sci'])? 1:0);


    $error = false;

    // Update the database
    if (!$error)
    {
		     $query = "UPDATE Application_Details SET Advertisement_No = '$advt_no', Assistant_Professor = '$assistant_professor', Assistant_Professor_Contract = '$assistant_professor_contract', ".
					  "Professor = '$professor', Associate_Professor = '$associate_professor', Sch_Comp_Elec_Engg = '$comp_elec',Sch_Engg = '$engg',Sch_Basic_Sci = '$basic_sci',Sch_Hum_Soc_Sci='$hum_soc' WHERE User_ID = '$user_id'";
             
             mysqli_query($dbcon, $query) or
			 trigger_error("Query: $query\n<br />MySQL Error: " . mysqli_error($dbcon));
			 $query = "UPDATE Forms_Submitted SET Application_Details = 1 WHERE User_ID = '$user_id'";
             mysqli_query($dbcon, $query) or
			 trigger_error("Query: $query\n<br />MySQL Error: " . mysqli_error($dbcon));

		  mysqli_close($dbcon);
         // Navigate to personal info
          $next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
 		  echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';
          exit();
      }
      else
      {
        $error_msg =  'Please enter all the data.';
      }
    }
   // End of check for form submission
  else
  {
		  $query = "SELECT User_ID FROM Application_Details WHERE User_ID = '$user_id'";
		  $data = mysqli_query($dbcon, $query);
		  if (mysqli_num_rows($data) == 1) ;
		  else 
		  {
			  $query = "INSERT INTO Application_Details (User_ID) VALUES ('$user_id')";
			  mysqli_query($dbcon, $query);
		  }
   
    $query = "SELECT * FROM Application_Details WHERE User_ID = '$user_id'";
    $data = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_assoc($data);

    if ($row != NULL) 
    {
	  $advt_no = $row['Advertisement_No'];
         $assistant_professor = $row['Assistant_Professor'];
         $assistant_professor_contract = $row['Assistant_Professor_Contract'];
         $professor = $row['Professor'];
         $associate_professor = $row['Associate_Professor'];
         $comp_elec = $row['Sch_Comp_Elec_Engg'];
		 $engg = $row['Sch_Engg'];
		 $basic_sci = $row['Sch_Basic_Sci'];
		 $hum_soc = $row['Sch_Hum_Soc_Sci'];
      
     }
    else 
    {
      $error_msg = 'There was a problem accessing your profile.';
    }
  }
?>

<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
	<p class="texta">Application Details</p>
	<?php echo '<p class="error_text">' . $error_msg . '</p>'; ?>
<form name="application_details" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
<fieldset class="fieldset">
<table>
<tr>
	 	<td class="labelcell"><strong>Advertisement No.</strong></td>
	 	<td></td>
		<td class="fieldcell"><select name="Advertisement_No">
		<option value="2011/FR-01" <?php if ((isset($_POST['Advertisement_No']) && $_POST['Advertisement_No'] == "IIT_MANDI/1/2011") || ($post_applied_for == "IIT_MANDI/1/2011r") ) echo "IIT_MANDI/1/2011"; ?> > IIT MANDI/1/2011 </option>
							  </select>
</tr>

	<tr><td colspan="3"><hr/></td></tr>

<tr> 	<td class="labelcell" valign="top"><label for="name" ><strong>Post Applied for</strong></label></td><td colspan=2><br></td></tr>
		<tr><td class="fieldcell" colspan="2"><input type="checkbox" name="Assistant_Professor" value="1" <?php if ( $assistant_professor == 1 ) echo "checked"; ?> > Assistant Professor<br /></td></tr>
		<tr><td class="fieldcell" colspan="3"><input type="checkbox" name="Assistant_Professor_Contract" value="1" <?php if ( $assistant_professor_contract == 1 ) echo "checked"; ?> > Assistant Professor(on Contract)<br /></td></tr>
		<tr><td class="fieldcell" colspan="2"><input type="checkbox" name="Professor" value="1" <?php if ($professor == 1) echo "checked"; ?> > Professor<br /></td></tr>
		<tr><td class="fieldcell" colspan="2"><input type="checkbox" name="Associate_Professor" value="1" <?php if ($associate_professor == 1) echo "checked"; ?> > Associate Professor<br /></td></tr>

	<tr><td colspan="3"><hr/></td></tr>

<tr>
		
	<td class="labelcell"  valign="top"><label for="name" ><strong>School</strong></label></td><td colspan=2><br></td></tr>
		<tr><td class="fieldcell" align="left" colspan = "3"><input type="checkbox" name="Sch_Comp_Elec_Engg" value="1" <?php if ( $comp_elec == 1 ) echo "checked"; ?> >School of Computing and Electrical Engineering<br /></td></tr>
		<tr><td class="fieldcell" align="left" colspan = "3"><input type="checkbox" name="Sch_Engg" value="1" <?php if ( $engg == 1 ) echo "checked"; ?> >School of Engineering <br/> </td></tr>
		<tr><td class="fieldcell" align="left" colspan = "3"><input type="checkbox" name="Sch_Basic_Sci" value="1" <?php if ( $basic_sci == 1 ) echo "checked"; ?> >School of Basic Sciences <br /></td></tr>
		<tr><td class="fieldcell" align="left" colspan = "3"><input type="checkbox" name="Sch_Hum_Soc_Sci" value="1" <?php if ( $hum_soc == 1 ) echo "checked"; ?> >School of Humanities and Social Science<br /></td></tr>
		
</tr>

	<tr><td colspan="3"><hr/></td></tr>

<tr>
		<td class="fieldcell" colspan=1><input type="submit" name="submit" value="Submit" <?php if($confirmed) echo "disabled"; ?> /></td>

		<?php $cancel_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user'); ?>

		<td class="fieldcell" colspan=1><input type="button" name="cancel" value="Cancel" onclick="parent.location= '<?php echo $cancel_url; ?>' "
										<?php if($confirmed) echo "disabled"; ?> /></td>
</tr>
</table>
</fieldset>
</form>

		<?php
			include($includes_path.'/js/form_validators/application_details.js');
		?>

<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= '../user/index.php' ">
<input type="button" value="Skip this Page" onclick="parent.location= '../user/personal_info.php' ">
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
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
<li>Select the advertisement number among the options given in the drop down menu of <i>Advertisement Number</i> field.</li>
<li>You may check the details of posts from <a href="http://www.iitmandi.ac.in/administration/recriutment.html" target="new">IIT Mandi website</a></li>
<li>Select atleast one post among those given in the form.</li>
<li>You may apply for <i>multiple posts </i>by checking the corresponding boxes. </li>
<li>You may check the name of schools from <a href="http://www.iitmandi.ac.in/academics/schools.html" target="new">IIT Mandi website</a></li>
</ul>
</div>
</div>

</div>

<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
