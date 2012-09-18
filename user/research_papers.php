<?php
	include('oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/oaf_vars.php');
	include ($includes_path.'/php/functions.php');

	$error_msg = "";

		  $query = "SELECT Research_Papers FROM Forms_Submitted WHERE User_ID = '$user_id'";
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
		$upload_msg = (($row['Publications_List'] == 1)? "<br/> Uploaded." : "Not Uploaded");
	 }
?>

<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
<p class="texta">Research Publications</p>
<?php echo '<p class = "error_text">'.$error_msg.'</p>'; ?>
<fieldset class="fieldset1">
<table>
	<tr>
		<td class="labelcell"><label for='Books_pub'>Number of <b>Books Published </b>(if any)</label>
		</td>
		<td class='fieldcell'>
			<center><?php echo $num_books; ?></center></td>
		</td>
	</tr>
	<tr><td colspan="3"><hr></td></tr>
	
	<tr>
		<td class="labelcell"><label for='National Journals'>Number of papers published in <b>National Journals </b>(if any)</label>
		</td>
		<td class='fieldcell'>
			<center><?php echo $num_nat_jou; ?></center>
		</td>
	</tr>
	<tr><td colspan="3"><hr></td></tr>
	
	<tr>
		<td class="labelcell"><label for='Books_pub'>Number of papers published <b>International Journals </b>(if any)</label>
		</td>
		<td class='fieldcell'>
			<center><?php echo $num_int_jou; ?></center>
		</td>
	</tr>
	<tr><td colspan="3"><hr></td></tr>
	
	<tr>
		<td class="labelcell"><label for='Int Conf'>Number of papers presented in <b>National Conferences </b>(if any)</label>
		</td>
		<td class='fieldcell'>
			<center><?php echo $num_nat_conf; ?></td></center>
		</td>
	</tr>
	<tr><td colspan="3"><hr></td></tr>
	
	<tr>
		<td class="labelcell"><label for='Num_Int_Conf'>Number of papers presented in <b>International Coferences  </b>(if any)</label>
		</td>
		<td>
			<center><?php echo $num_int_conf; ?></td></center>
		</td>
	</tr>
	<tr><td colspan="3"><hr></td></tr>
	<tr>
			<td class='labelcell1'>
				<label for='Int_Conf'>List of all publications </label>
			</td>
			<td class='fieldcell'>
				<?php echo $upload_msg ; ?>
			</td>
	</tr>
	<tr><td colspan="3"><hr></td></tr>
	<tr>
			<td>
				<input type="button" value="Edit" onclick='parent.location="../forms/<?php echo getScriptName(); ?>"'>
			</td>
	</tr>
</table>
</fieldset>
</form>

<div id="navbuttons">
<input type="button" value="Back" onclick="parent.location= 'industrial_exp.php' ">
<input type="button" value="Next" onclick="parent.location= 'best_papers.php' ">
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

</div>

</div>

<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>

