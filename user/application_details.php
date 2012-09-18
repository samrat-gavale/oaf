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

		  $query = "SELECT Application_Details FROM Forms_Submitted WHERE User_ID = '" . $_SESSION['user_id'] . "'";
		  $row = mysqli_fetch_array(mysqli_query($dbcon, $query))
				  or
				  trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbcon));
		  if ($row[0] == 1) ;
		  else 
		  {
			$next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('forms');
			echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';
			mysqli_close($dbcon);
			exit();
		  }

    $query = "SELECT * FROM Application_Details WHERE User_ID = '" . $_SESSION['user_id'] . "'";
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

?>

<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
	<p class="texta">Application Details</p>
	<?php echo '<p class="error_text">' . $error_msg . '</p>'; ?>
<fieldset class="fieldset">
<table>
<tr>
	 	<td class="labelcell"><strong>Advertisement No.</strong></td>
	 	<td></td>
		<td class="fieldcell"><?php echo $advt_no; ?> 
</tr>

	<tr><td colspan="3"><hr/></td></tr>

		<tr>
			<td class="labelcell" valign="top"><label for="name" ><strong>Post Applied for</strong></label></td><td colspan=2><br></td>
		</tr>	
		<tr>
			<td class="fieldcell" colspan="3"><?php if ( $assistant_professor == 1 ) echo "Assistant Professor <br />";
													if ( $assistant_professor_contract == 1 ) echo "Assistant Professor(on Contract) <br />";
													if ($professor == 1) echo "Professor <br />";
													if ($associate_professor == 1) echo "Associate Professor <br />"; ?>
			</td>
		</tr>

	<tr><td colspan="3"><hr/></td></tr>
	
		<tr>		
			<td class="labelcell"  valign="top"><label for="name" ><strong>School</strong></label></td><td colspan=2><br></td>
		</tr>
		<tr>
			<td class="fieldcell" align="left" colspan = "4">
				<?php if ( $comp_elec == 1 ) echo "School of Computing and Electrical Engineering <br />";
					  if ( $engg == 1 ) echo "School of Engineering <br/>";
					  if ( $basic_sci == 1 ) echo "School of Basic Sciences <br />";
					  if ( $hum_soc == 1 ) echo "School of Humanities and Social Science <br />"; ?>
			</td>
		</tr>

	<tr><td colspan="3"><hr/></td></tr>

<tr>
		<td class="fieldcell" colspan=1><input type="button" value="Edit" onclick='parent.location="../forms/<?php echo getScriptName(); ?>"'></td>
</tr>
</table>
</fieldset>

<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= 'index.php' ">
<input type="button" value="Next" onclick="parent.location= 'personal_info.php' ">
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
<li>Select the advertisement number among the options given in the drop down menu of <i>Advertisement Number</i> field.</li>
<li>You may check the details of posts from <a href="http://www.iitmandi.ac.in/administration/recriutment.html" target="new">IIT Mandi website</a></li>
<li>Select atleast one post among those given in the form.</li>
<li>You may apply for <i>multiple posts </i>by checking the corresponding boxes. </li>
<li>You may check the name of schools from <a href="http://www.iitmandi.ac.in/academics/schools.html" target="new">IIT Mandi website</a></li>
<li>The buttons on left marked with &#10004 are linked to the forms already submitted by you.</li>
</ul>
</div>
</div>

</div>

<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
