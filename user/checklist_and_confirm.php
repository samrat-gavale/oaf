<?php
	include('oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/functions.php');
    include($includes_path.'/js/checklist.js');
  $error_msg = "";
 if (isset($_POST['submit'])) 
   {
    $error = false;
    // Update the profile data in the  database
    if (!$error)
    {
			 $display_check = 0;
			 //Copy data into premanent data table
             include($includes_path.'/php/confirm_data.php');

			$confirmation_success_messsage = <<<EOD
              <p class="alert_text"><br />The application process is now complete and your application has be registered succesfully.<br/> Please save the two PDF files generated now. Thank you.</p>
			  <input type="button" value="Application Document" onclick=" parent.location='../includes/php/application_pdf_download.php' " />
              <input type="button" value="Summary Document" onclick=" parent.location='../includes/php/summary_pdf_download.php' " /><br /><br />
              <input type="button" value="Home" onclick=" parent.location='index.php' " />
EOD;

      }
    } // End of check for form submission
  else 
  {
		  $query = "SELECT User_ID FROM Confirmed_Applications WHERE User_ID = '$user_id'";
		  $data = mysqli_query($dbcon, $query);
		  if (mysqli_num_rows($data) == 1) ;
		  else 
		  {
			  $query = "INSERT INTO Confirmed_Applications (User_ID, Confirmed) VALUES ('$user_id', 0)";
			  mysqli_query($dbcon, $query);
		  }
 
    $query = "SELECT * FROM Confirmed_Applications WHERE User_ID = '$user_id'";
    $data = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_assoc($data);
	$display_check = !$row['Confirmed'];
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
<?php
if($display_check == true)
{
?>
<p class="texta">Check List</p>
<?php
echo '<p class="error_text">'.$error_msg.'</p>';  ?>

<i> You must check the details and tick the corresponding checkboxes. </i>
<br/>
<br/>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="/*return checkCheckBoxes(this);*/">
<input type="checkbox" name="Photograph" value="Photograph"> I have uploaded your latest photograph in the personal details page. <br/><br>

<input type="checkbox" name="Personal" value="agree"> I have filled up the personal information page correctly and accurately. <br/><br/>

<input type="checkbox" name="Academic_Record" value="agree"> I have filled up your Academic record in the correct chronology. <br/><br/>

<input type="checkbox" name="Academic_Experience" value="agree"> I have filled up Academic experience page.(optional) <br/><br/>

<input type="checkbox" name="Research_Experience" value="agree"> I have filled up Research experience page coorectly and accurately. <br/><br/>

<input type="checkbox" name="Other_Experience" value="agree"> I have filled up rest of the experiences page and uploaded the required pages.(optional) <br/><br/>

<input type="checkbox" name="Publications" value="agree"> I have filled up Publications page completely and correctly.<br/><br/>

<input type="checkbox" name="Awards" value="agree"> I have filled up Awards and honours and recognitions.<br/><br/>

<input type="checkbox" name="Research_Plan" value="agree"> I have uploaded a three page summary of research plan for the next 5 years. <br/><br/>

<input type="checkbox" name="Teaching_Plan" value="agree"> I have uploaded a one page summary of teaching plan for the next 3 years. <br/><br/>

<input type="checkbox" name="Statement" value="agree"> I have uploaded your statement of purpose. <br/><br/>

<input type="checkbox" name="Referee" value="agree"> I have provided the contact information of atleast one referee.<br/><br/>

<input type="checkbox" name="Terms" value="agree"> I have gone through Terms and Conditions page.<br/><br/>
<label for="final_submit"><class="error_text">Warning:</class><br />
						  Clicking on "Confirm My Application" will lock your application and you will not be able to change any information any more.
						  To go through the information submitted <a href="application_details">click here</a>.<br /><br /></label>
<input type="submit" name="submit" value="Confirm My Application" />
<br /><br />
<input type="button" value="Back" onclick=" parent.location='terms.php' " />
<input type="button" value="Home Page" onclick=" parent.location='index.php' " />
</form>

<?php
}
else if($confirmed == 1)
{
?>
	<br /><p class = 'error_text'>You have already confirmed your application!</p>
	<ul>
	<li> Take a print out of the two documents given below. </li>
	<li> Sign the declaration at the end of Application Document and send it along with the Summary Document to Registrar, IIT Mandi (Address is mentioned on <a href='../other/contact_us.php'>Contact Us</a>). </li>
    <li> You can send the scanned copies of these documents (after signing the declaraton) by e-mail to recruit@iitmandi.ac.in onwards.</li>
    </ul>
    <br/>
	<input type="button" value="Application Document" onclick=" parent.location='includes/php/application_pdf_download.php' " />
	<input type="button" value="Summary Document" onclick=" parent.location='includes/php/summary_pdf_download.php' " /><br /><br />
	<input type="button" value="Homepage" onclick=" parent.location='index.php' " /></div>

<?php
}
if($display_check == 0 && $confirmed !=1)
{
	echo $confirmation_success_messsage;
}

?>
</div>
</div>
<div id="leftcolumn">
<?php include($includes_path.'/php/sidemenu.php');?>
</div>

</div>
<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
