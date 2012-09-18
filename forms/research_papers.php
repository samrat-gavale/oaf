<?php
	include('../user/oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/oaf_vars.php');
	include ($includes_path.'/php/functions.php');

	$error_msg = "";
	
// Check if the form has been submitted:
if(isset($_POST['submit']))
{
	// Check for an uploaded file:
	if(!empty($_FILES['Publications_List']['name']))
	{
		// Validate the type. Should be PDF.
		if( in_array($_FILES['Publications_List']['type'], $allowed_types_docs) && ($_FILES['Publications_List']['size']<= MAXFILESIZE_RESEARCH))
		{
			// Move the file over.
		   if( move_uploaded_file($_FILES['Publications_List']['tmp_name'],$uploaddir.'Publication List.pdf') ) 
			{
					$alert_msg ='The file has been uploaded!';
					$publications_list = 1;
					if(file_exists($_FILES['Publications_List']['tmp_name']))
						unlink($_FILES['Publications_List']['tmp_name']);
            }
            else
            {
				$error_msg = "Sorry, there was a problem in uploading the file.";
			}
		}
		else
		{
			$error_msg_list = "<br/>This is not a PDF of size ".(MAXFILESIZE_RESEARCH/1024)."KB or less.";
		}
	}
	
		$num_books = mysqli_real_escape_string($dbcon, trim($_POST['Num_Books']));
		$num_nat_jou = mysqli_real_escape_string($dbcon, trim($_POST['Num_Nat_Jou']));
		$num_int_jou = mysqli_real_escape_string($dbcon, trim($_POST['Num_Int_Jou']));
		$num_nat_conf = mysqli_real_escape_string($dbcon, trim($_POST['Num_Nat_Conf']));
		$num_int_conf = mysqli_real_escape_string($dbcon, trim($_POST['Num_Int_Conf']));

		$query = "UPDATE Research_Papers SET Num_Books_Pub = '$num_books', ".
				 "Num_National_Journals = '$num_nat_jou', ".
				 "Num_International_Journals = '$num_int_jou', " .
				 "Num_National_Conferences = '$num_nat_conf', ".
				 "Num_International_Conferences = '$num_int_conf', ".
				 "Publications_List = '$publications_list' ".
				 "WHERE User_ID = '$user_id'"; 
					mysqli_query($dbcon, $query) or die('Not able to update the database!');
		
		$query = "UPDATE Forms_Submitted SET Research_Papers = 1 WHERE User_ID = '$user_id'"; 
					mysqli_query($dbcon, $query);

					$next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
					echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';
					mysqli_close($dbcon);
					exit();
}

		  $query = "SELECT User_ID FROM Research_Papers WHERE User_ID = '$user_id'";
		  $data = mysqli_query($dbcon, $query);
		  if (mysqli_num_rows($data) == 1) ;
		  else 
		  {
			  $query = "INSERT INTO Research_Papers (User_ID) VALUES ('$user_id')";
			  mysqli_query($dbcon, $query);
		  }


    // Grab the profile data from the database
    $query = "SELECT * FROM Research_Papers WHERE User_ID = '$user_id'";
    $data = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_assoc($data);

    if ($row == NULL) 
    {
		$error_msg ="There was a problem accessing your profile.";
		$num_books = '';
		$num_nat_jou = '';
		$num_int_jou = '';
		$num_nat_conf = '';
		$num_int_conf = '';
    }
    else
    {
		$num_books = $row['Num_Books_Pub'];
		$num_nat_jou = $row['Num_National_Journals'];
		$num_int_jou = $row['Num_International_Journals'];
		$num_nat_conf = $row['Num_National_Conferences'];
		$num_int_conf = $row['Num_International_Conferences'];
		$alert_msg  = "";
		$alert_msg .= (($row['Publications_List'] == 1)? "Uploaded." : "Not Uploaded");
	 }
?>

<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
<form name="research_papers" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<p class="texta">Research Publications</p>
<?php echo '<p class = "error_text">'.$error_msg.'</p>'; ?>
<fieldset class="fieldset1">
<table>
	<tr>
		<td class="labelcell"><label for='Books_pub'>Number of <b>Books Published </b>(if any)</label>
		</td>
    </tr>
    <tr>		
		<td>
		<input type="text" name="Num_Books" maxlength="2"
								value="<?php if (isset($_POST['Num_Books'])) echo $_POST['Num_Books'];  else echo $num_books; ?>"/></td>
		</td>
	</tr>
		
	<tr><td><hr></td></tr>
	
	<tr>
		<td class="labelcell"><label for='National Journals'>Number of papers published in <b>National Journals </b>(if any)</label>
		</td>
    </tr>
    <tr>		
		<td>
		<input type="text" name="Num_Nat_Jou" maxlength="2"
								value="<?php if (isset($_POST['Num_Nat_Jou'])) echo $_POST['Num_Nat_Jou'];
								else echo $num_nat_jou; ?>"/></td>
		</td>
	</tr>
	
	<tr><td><hr></td></tr>
	
	<tr>
		<td class="labelcell"><label for='Books_pub'>Number of papers published <b>International Journals </b>(if any)</label>
		</td>
    </tr>
    <tr>
		<td>
		<input type="text" name="Num_Int_Jou" maxlength="2"
								value="<?php if (isset($_POST['Num_Int_Jou'])) echo $_POST['Num_Int_Jou'];  else echo $num_int_jou; ?>"/></td>
		</td>
	</tr>
	<tr><td><hr></td></tr>
	
	<tr>
		<td class="labelcell"><label for='Int Conf'>Number of papers presented in <b>National Conferences </b>(if any)</label>
		</td>
    </tr>
    <tr>
		<td>
		<input type="text" name="Num_Nat_Conf" maxlength="2"
								value="<?php if (isset($_POST['Num_Nat_Conf'])) echo $_POST['Num_Nat_Conf'];  else echo $num_nat_conf; ?>"/></td>
		</td>
	</tr>

	<tr><td><hr></td></tr>
	
	<tr>
		<td class="labelcell"><label for='Num_Int_Conf'>Number of papers presented in <b>International Coferences  </b>(if any)</label>
		</td>
    </tr>
    <tr>		
		<td>
		<input type="text" name="Num_Int_Conf" maxlength="2"
								value="<?php if (isset($_POST['Num_Int_Conf'])) echo $_POST['Num_Int_Conf'];  else echo $num_int_conf; ?>"/></td>
		</td>
	</tr>

	<tr><td><hr></td></tr>

	<tr>
			<td class='labelcell1'><label for='Publications_List'>List of all the publications.</label>
			</td>
	</tr>
	<tr>
			<td class='fieldcell'><input type="file" name="Publications_List" />
			</td>
	</tr>

	<tr><td><hr></td></tr>

	<tr>
		<td class="fieldcell" colspan=1><input class="navbuttons" type="submit" name="submit" value="Submit" <?php if($confirmed) echo "disabled"; ?> />
		<?php
			$next_url_cancel = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('user');
		?>
		<center><input type="button" class="navbuttons" name="cancel" value="Cancel" onclick="parent.location= '<?php echo $next_url_cancel; ?>' "
										<?php if($confirmed) echo "disabled"; ?> /></center></td>
	</tr>
</table>
</fieldset>
</form>
 
		<?php
			include($includes_path.'/js/form_validators/research_papers.js');
		?>

<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= '../user/industrial_exp.php' ">
<input type="button" value="Next" onclick="parent.location= '../user/best_papers.php' ">
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
<li>Please upload only PDFs of size <b>100KB</b> or less.</li>
<li>Categorize the enteries in each list as 'Refereed' and 'Non Refereed'.</li>
<li>Include details of papers listing
<ol>
<li>Names of authors</li>
<li>title of the paper</li>
<li>name of the journal/conference</li>
<li>volume/proceeding</li>
<li>pages (from-to)</li>
<li>year</li>
</ol>
</li>
</ul>
</div>

<?php echo '<p class = "alert_text">'.$alert_msg.'</p>'; ?>
</div>

</div>

<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>

