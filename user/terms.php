<?php
	include('oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include($includes_path.'/js/terms.js');
	
    $error_msg = "";
if (isset($_POST['submit'])) 
   {
    // Grab the data from the POST
    $date = date('Y-m-d');
    $error = false;
    // Update the profile data in the database
    if (!$error)
    {
		
		$query = "UPDATE Terms_Acceptance SET Accepted = 1 WHERE User_ID = '$user_id'";
        mysqli_query($dbcon, $query);
		
		$query = "UPDATE Forms_Submitted SET Terms_Acceptance = 1 WHERE User_ID = '$user_id'";;
		mysqli_query($dbcon, $query);

        // Navigate to doctoral profile
        $checklist_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/checklist_and_confirm.php';
        echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';
        exit();
      }
      else
      {
        $display_form = true;
      }
    } // End of check for form submission
  else 
  {
		  $query = "SELECT User_ID FROM Terms_Acceptance WHERE User_ID = '$user_id'";
		  $data = mysqli_query($dbcon, $query);
		  if (mysqli_num_rows($data) == 1) ;
		  else 
		  {
			  $query = "INSERT INTO Terms_Acceptance (User_ID, Accepted) VALUES ('$user_id', 0)";
			  mysqli_query($dbcon, $query);
		  }
   
    $query = "SELECT * FROM Terms_Acceptance WHERE User_ID = '$user_id'";
    $data = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_array($data);
	$display_form = !$row['Accepted'];
  }

 
?>
<style>
#contentcolumn
{
width:70%;
margin: 0 4% 0 20%; /*Margins for content column. Should be "0 RightColumnWidth 0 LeftColumnWidth*/
}
</style>
<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
<?php  echo '<p class="error_text">'.$error_msg.'</p>';  ?>

<h2> Terms and Conditions</h2>
<p>
(1) Applicants shall provide relevant certificates and documentary evidence of all items at the time of interview, if not provided with this application. 
The selection shall be conditional until all such evidence is provided in original.<br/>
(2) Applicants shall accept terms and conditions of the institute and abide by them.<br/>
(3) The post for Assistant Professor is permanent and carries retirement benefits in the form of CPF-Cum-Gratuity Scheme. The age of retirement for 
permanent post is 65 years. <br/>
(4) Besides pay, the three posts mentioned carry allowances according to the Institute rules which at present correspond to those admissable to the Central Government 
employees stationed at Mandi/Mandi(H.P)<br/>
(5) Higher initial pay is admissable to exceptionally qualified and deserving candidates.<br/>
(6) Applicants employed in Government or Quasi-Government Organisations/Institutes shall send their applications through <b>Proper Channel</b>, else produce a 
<b>NO OBJECTION CERTIFICATE</b> from their employer at the time of interview.<br/>
(7) Candidates called for and appearing at the interview will be paid Economy airfare on Indian Airlines/Air India within India/First Class railway fare from place of duty or the nearest Railway Station from the residence 
to Mandi/Kiratpur and back by the shortest route.<br/>
</p>
<hr/>
<hr/>

<?php
if($display_form == true)
{
?>
<b> I declare that <br/>
<form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return checkCheckBoxes(this);">
<input type="checkbox" name="Conditions_Read" value="agree"> I have read the terms and conditions. <br/>
<input type="checkbox" name="Confirmed_Information" value="agree">All information provided with this application are true to the best of my knowledge and belief.<br/>

<table>
<tr>
	<td colspan="2"><input type="submit" name="submit" value="I accept" /></td>
</tr>
</table>
</form> 
<br/>
<?php
}
else 
{
	$error_msg = "You have already accepted Terms and condititons! ";
	echo 'You have already accepted the Terms and Conditions<br/><br/>';
	echo '<a href="checklist_and_confirm.php">Click Here</a> to proceed <br /><br />';
}
?>
			<input type="button" value="Back" onclick=" parent.location='referees.php' " />
			<input type="button" value="Next" onclick=" parent.location='checklist_and_confirm.php' " /><br /><br />
</div>
</div>
<div id="leftcolumn">
<?php include($includes_path.'/php/sidemenu.php');?>
</div>
</b>
</div>
<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
