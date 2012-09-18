<?php
	include('oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	
  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) 
  {
	include($includes_path.'/html/home.html');
  }
  else
  {
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
<center>
<p class="texta">Welcome!</p>
<?php
	$query = "SELECT Confirmed FROM Confirmed_Applications WHERE User_ID = '$user_id'";
	$data = mysqli_query($dbcon,$query);
	$row = mysqli_fetch_assoc($data);
	if($row['Confirmed'])
	{
	?>
	</center>
		<p>You have already confirmed you application.<br/></p>
              <ul> 
                <li> Take a print out of the two documents generated on confirmation of your application.(You can download them from <a href="checklist_and_confirm.php">'Checklist and Confirm'</a> page.)</li>
				<li> Sign the declaration at the end of Application Document and send it along with the Summary Document to Registrar, IIT Mandi
					by post or by fax (Address is mentioned on <a href="http://www.iitmandi.ac.in/oaf/other/contact_us.php">Contact Us</a>). </li>
                <li> You can also send the scanned copies of these documents (after signing the declaraton) by e-mail to <b>recruit@iitmandi.ac.in</b> (Please paste the images obtained on scanning into PDF documents and send these pdfs.) </li>
<font color="red"><li> These documents must reach us latest by <sup>th</sup> , 2011.</font></li>
		<li> We recommend that you visit this site regularly for updates.</li>
              </ul>
	<?php
	}
	else
	{
	?>
		</center>
		<ul>
		   <li><a href="http://www.iitmandi.ac.in/oaf/user/application_details.php">Click here</a> to start filling the application form.</li>
		   <li>We recommend that you go through <a href="http://www.iitmandi.ac.in/oaf/other/overview.php"><i>Overview</i></a> and <a href="http://www.iitmandi.ac.in/oaf/other/faqs.php"><i>FAQs</i></a> page before you start filling up the application form. </li>
		   <li>Please read the 'Note' given on right side of each page before filling the form on that page.</li>
		   <li>The deadline for reciept of Application Document and Summary Document (generated after confirmation of application) is <sup>th</sup> , 2011.</font></li>
		   
 		</ul>

	<?php
	}
	?>
</center>
</div>
</div>
<div id="leftcolumn">
<?php include($includes_path.'/php/sidemenu.php');?>
</div>
<div id="rightcolumn"></div>

</div>
<br/><br/>
<?php
  	include($includes_path.'/html/footer.html');
 }
  	
?>

</body>
</html>

